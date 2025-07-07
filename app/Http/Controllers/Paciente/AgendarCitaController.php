<?php

namespace App\Http\Controllers\Paciente;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Specialty;
use App\Models\Doctor;
use App\Models\Schedule;
use App\Models\Appointment;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AgendarCitaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Obtener las citas del paciente autenticado paginadas
        $paciente = auth()->user()->patient;
        $citas = $paciente->appointments()->with(['doctor.user.profile', 'doctor.specialty'])->paginate(10);
        return view('paciente.citas.index', compact('citas'));
    }

    /**
     * Paso 1: Selección de Especialidad
     */
    public function create()
    {
        // Limpiar sesión si viene de un flujo nuevo
        if (!request()->has('preserve_state')) {
            session()->forget(['agendar_cita.specialty_id', 'agendar_cita.doctor_id', 'agendar_cita.schedule_id', 'agendar_cita.appointment_date', 'agendar_cita.appointment_time']);
        }
        
        $especialidades = Specialty::all();
        $selectedSpecialtyId = session('agendar_cita.specialty_id');
        
        return view('paciente.agendarCita.paso1-especialidad', compact('especialidades', 'selectedSpecialtyId'));
    }

    /**
     * Paso 2: Selección de Médico
     */
    public function seleccionarMedico(Request $request)
    {
        $request->validate([
            'specialty_id' => 'required|exists:specialties,id'
        ]);

        // Limpiar estados futuros si cambió la especialidad
        $previousSpecialtyId = session('agendar_cita.specialty_id');
        if ($previousSpecialtyId && $previousSpecialtyId != $request->specialty_id) {
            session()->forget(['agendar_cita.doctor_id', 'agendar_cita.schedule_id', 'agendar_cita.appointment_date', 'agendar_cita.appointment_time']);
        }
        // Guardar especialidad en sesión
        session(['agendar_cita.specialty_id' => $request->specialty_id]);

        $especialidad = Specialty::findOrFail($request->specialty_id);
        $medicos = Doctor::where('specialty_id', $request->specialty_id)
            ->with(['user.profile', 'specialty'])
            ->get();
        $selectedDoctorId = session('agendar_cita.doctor_id');

        return view('paciente.agendarCita.paso2-medico', compact('medicos', 'especialidad', 'selectedDoctorId'));
    }

    /**
     * Paso 2: Selección de Médico (con estado preservado)
     */
    public function seleccionarMedicoPreservado()
    {
        $specialtyId = session('agendar_cita.specialty_id');
        
        if (!$specialtyId) {
            return redirect()->route('paciente.agendarCita.create');
        }

        $especialidad = Specialty::findOrFail($specialtyId);
        $medicos = Doctor::where('specialty_id', $specialtyId)
            ->with(['user.profile', 'specialty'])
            ->get();
        
        $selectedDoctorId = session('agendar_cita.doctor_id');

        return view('paciente.agendarCita.paso2-medico', compact('medicos', 'especialidad', 'selectedDoctorId'));
    }

    /**
     * Paso 3: Selección de Fecha y Hora
     */
    public function seleccionarFechaHora(Request $request)
    {
        $request->validate([
            'specialty_id' => 'required|exists:specialties,id',
            'doctor_id' => 'required|exists:doctors,id'
        ]);

        // Limpiar estados futuros si cambió el médico
        $previousDoctorId = session('agendar_cita.doctor_id');
        if ($previousDoctorId && $previousDoctorId != $request->doctor_id) {
            session()->forget(['agendar_cita.schedule_id', 'agendar_cita.appointment_date', 'agendar_cita.appointment_time']);
        }
        // Guardar médico en sesión
        session(['agendar_cita.doctor_id' => $request->doctor_id]);

        $especialidad = Specialty::findOrFail($request->specialty_id);
        $medico = Doctor::with(['user.profile', 'specialty'])->findOrFail($request->doctor_id);
        $horarios = Schedule::where('doctor_id', $request->doctor_id)->get();

        // Obtener citas existentes del médico para verificar disponibilidad
        $citasExistentes = Appointment::where('doctor_id', $request->doctor_id)
            ->where('status', 'programada')
            ->get()
            ->groupBy(function ($cita) {
                return $cita->appointment_date . ' ' . $cita->appointment_time;
            });

        $selectedScheduleId = session('agendar_cita.schedule_id');
        $selectedDate = session('agendar_cita.appointment_date');
        $selectedTime = session('agendar_cita.appointment_time');

        return view('paciente.agendarCita.paso3-fecha-hora', compact('especialidad', 'medico', 'horarios', 'citasExistentes', 'selectedScheduleId', 'selectedDate', 'selectedTime'));
    }

    /**
     * Paso 3: Selección de Fecha y Hora (con estado preservado)
     */
    public function seleccionarFechaHoraPreservado()
    {
        $specialtyId = session('agendar_cita.specialty_id');
        $doctorId = session('agendar_cita.doctor_id');
        
        if (!$specialtyId || !$doctorId) {
            return redirect()->route('paciente.agendarCita.create');
        }

        $especialidad = Specialty::findOrFail($specialtyId);
        $medico = Doctor::with(['user.profile', 'specialty'])->findOrFail($doctorId);
        $horarios = Schedule::where('doctor_id', $doctorId)->get();

        // Obtener citas existentes del médico para verificar disponibilidad
        $citasExistentes = Appointment::where('doctor_id', $doctorId)
            ->where('status', 'programada')
            ->get()
            ->groupBy(function ($cita) {
                return $cita->appointment_date . ' ' . $cita->appointment_time;
            });

        $selectedScheduleId = session('agendar_cita.schedule_id');
        $selectedDate = session('agendar_cita.appointment_date');
        $selectedTime = session('agendar_cita.appointment_time');

        return view('paciente.agendarCita.paso3-fecha-hora', compact('especialidad', 'medico', 'horarios', 'citasExistentes', 'selectedScheduleId', 'selectedDate', 'selectedTime'));
    }

    /**
     * Paso 4: Confirmación y Pago
     */
    public function confirmacion(Request $request)
    {
        $request->validate([
            'specialty_id' => 'required|exists:specialties,id',
            'doctor_id' => 'required|exists:doctors,id',
            'schedule_id' => 'required|exists:schedules,id',
            'appointment_date' => 'required|date|after:today',
            'appointment_time' => 'required'
        ]);

        // Guardar fecha y hora en sesión
        session([
            'agendar_cita.schedule_id' => $request->schedule_id,
            'agendar_cita.appointment_date' => $request->appointment_date,
            'agendar_cita.appointment_time' => $request->appointment_time
        ]);

        $especialidad = Specialty::findOrFail($request->specialty_id);
        $medico = Doctor::with(['user.profile', 'specialty'])->findOrFail($request->doctor_id);
        $horario = Schedule::findOrFail($request->schedule_id);
        $paciente = auth()->user()->patient;

        // Verificar que la cita no esté ocupada
        $citaExistente = Appointment::where('doctor_id', $request->doctor_id)
            ->where('appointment_date', $request->appointment_date)
            ->where('appointment_time', $request->appointment_time)
            ->where('status', 'programada')
            ->first();

        if ($citaExistente) {
            return back()->withErrors(['error' => 'Esta fecha y hora ya está ocupada. Por favor seleccione otra.']);
        }

        // Calcular el costo (puedes ajustar según tu lógica de precios)
        $costo = 150.00; // Precio base por consulta

        return view('paciente.agendarCita.paso4-confirmacion', compact(
            'especialidad',
            'medico',
            'horario',
            'paciente',
            'costo'
        ));
    }

    /**
     * Guardar la cita y procesar el pago
     */
    public function store(Request $request)
    {
        $request->validate([
            'specialty_id' => 'required|exists:specialties,id',
            'doctor_id' => 'required|exists:doctors,id',
            'schedule_id' => 'required|exists:schedules,id',
            'appointment_date' => 'required|date|after:today',
            'appointment_time' => 'required',
            'payment_method' => 'required|in:online,transfer,clinic',
            'amount' => 'required|numeric|min:0',
            'payment_proof' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120', // 5MB máximo
            'terms' => 'required|accepted'
        ]);

        try {
            DB::beginTransaction();

            $paciente = auth()->user()->patient;

            // Verificar nuevamente que la cita no esté ocupada
            $citaExistente = Appointment::where('doctor_id', $request->doctor_id)
                ->where('appointment_date', $request->appointment_date)
                ->where('appointment_time', $request->appointment_time)
                ->where('status', 'programada')
                ->first();

            if ($citaExistente) {
                return back()->withErrors(['error' => 'Esta fecha y hora ya está ocupada. Por favor seleccione otra.']);
            }

            // Crear la cita
            $cita = Appointment::create([
                'patient_id' => $paciente->id,
                'doctor_id' => $request->doctor_id,
                'schedule_id' => $request->schedule_id,
                'appointment_date' => $request->appointment_date,
                'appointment_time' => $request->appointment_time,
                'status' => 'programada'
            ]);

            // Procesar el comprobante de pago si se subió
            $imagePath = null;
            if ($request->hasFile('payment_proof')) {
                $file = $request->file('payment_proof');
                $fileName = 'payment_proof_' . time() . '_' . $file->getClientOriginalName();
                $imagePath = $file->storeAs('payment_proofs', $fileName, 'public');
            }

            // Crear el registro de pago
            $payment = Payment::create([
                'appointment_id' => $cita->id,
                'uploaded_by' => auth()->id(),
                'payment_method' => $request->payment_method,
                'amount' => $request->amount,
                'status' => $request->payment_method === 'online' ? 'validado' : 'pendiente',
                'uploaded_at' => now(),
                'image_path' => $imagePath
            ]);

            // Si es pago en línea, marcar como validado automáticamente
            if ($request->payment_method === 'online') {
                $payment->update([
                    'validated_by' => auth()->id(),
                    'validated_at' => now()
                ]);
            }

            DB::commit();

            // Limpiar sesión después de agendar exitosamente
            session()->forget(['agendar_cita.specialty_id', 'agendar_cita.doctor_id', 'agendar_cita.schedule_id', 'agendar_cita.appointment_date', 'agendar_cita.appointment_time']);

            return redirect()->route('paciente.citas.show', $cita->id)
                ->with('success', 'Cita agendada exitosamente.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Error al agendar la cita. Por favor intente nuevamente.']);
        }
    }

    /**
     * Obtener horarios disponibles para un médico en una fecha específica
     */
    public function getHorariosDisponibles(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'date' => 'required|date'
        ]);

        $fecha = Carbon::parse($request->date);
        $diaSemana = $this->getDiaSemana($fecha->dayOfWeek);

        // Obtener horarios del médico para ese día
        $horarios = Schedule::where('doctor_id', $request->doctor_id)
            ->where('day_of_week', $diaSemana)
            ->get();

        // Obtener citas existentes para esa fecha
        $citasExistentes = Appointment::where('doctor_id', $request->doctor_id)
            ->where('appointment_date', $request->date)
            ->where('status', 'programada')
            ->pluck('appointment_time')
            ->toArray();

        // Generar slots de tiempo disponibles
        $slotsDisponibles = [];
        foreach ($horarios as $horario) {
            $inicio = Carbon::parse($horario->start_time);
            $fin = Carbon::parse($horario->end_time);

            while ($inicio < $fin) {
                $horaSlot = $inicio->format('H:i:s');
                if (!in_array($horaSlot, $citasExistentes)) {
                    $slotsDisponibles[] = [
                        'time' => $inicio->format('H:i'),
                        'available' => true
                    ];
                }
                $inicio->addMinutes(30); // Slots de 30 minutos
            }
        }

        return response()->json($slotsDisponibles);
    }

    /**
     * Convertir día de la semana de Carbon a formato de la base de datos
     */
    private function getDiaSemana($dayOfWeek)
    {
        $dias = [
            1 => 'LUNES',
            2 => 'MARTES',
            3 => 'MIERCOLES',
            4 => 'JUEVES',
            5 => 'VIERNES',
            6 => 'SABADO',
            0 => 'DOMINGO'
        ];

        return $dias[$dayOfWeek] ?? 'LUNES';
    }

    // Métodos CRUD adicionales para gestionar citas
    public function show($id)
    {
        $cita = Appointment::with(['doctor.user.profile', 'doctor.specialty', 'schedule', 'payment'])
            ->where('patient_id', auth()->user()->patient->id)
            ->findOrFail($id);

        return view('paciente.citas.show', compact('cita'));
    }

    public function edit($id)
    {
        $cita = Appointment::with(['doctor.user.profile', 'doctor.specialty', 'schedule'])
            ->where('patient_id', auth()->user()->patient->id)
            ->findOrFail($id);

        return view('paciente.citas.edit', compact('cita'));
    }

    public function update(Request $request, $id)
    {
        $cita = Appointment::where('patient_id', auth()->user()->patient->id)
            ->findOrFail($id);

        $request->validate([
            'appointment_date' => 'required|date|after:today',
            'appointment_time' => 'required'
        ]);

        $cita->update([
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time
        ]);

        return redirect()->route('paciente.citas.show', $cita->id)
            ->with('success', 'Cita actualizada exitosamente.');
    }

    public function destroy($id)
    {
        $cita = Appointment::where('patient_id', auth()->user()->patient->id)
            ->findOrFail($id);

        $cita->update(['status' => 'cancelada']);

        return redirect()->route('paciente.citas.index')
            ->with('success', 'Cita cancelada exitosamente.');
    }

    public function confirm($id)
    {
        $cita = Appointment::where('patient_id', auth()->user()->patient->id)
            ->findOrFail($id);

        $cita->update(['status' => 'completada']);

        return redirect()->route('paciente.citas.show', $cita->id)
            ->with('success', 'Cita marcada como completada.');
    }

    public function cancel($id)
    {
        $cita = Appointment::where('patient_id', auth()->user()->patient->id)
            ->findOrFail($id);

        $cita->update(['status' => 'cancelada']);

        return redirect()->route('paciente.citas.index')
            ->with('success', 'Cita cancelada exitosamente.');
    }

    /**
     * Limpiar sesión de agendar cita
     */
    public function limpiarSesion()
    {
        session()->forget(['agendar_cita.specialty_id', 'agendar_cita.doctor_id', 'agendar_cita.schedule_id', 'agendar_cita.appointment_date', 'agendar_cita.appointment_time']);
        
        return redirect()->route('dashboard')
            ->with('success', 'Proceso de agendar cita cancelado.');
    }

    public function paso1()
    {
        // Obtener los datos de la cita desde la sesión
        $shift = session('datos_cita.shift');
        $specialtyId = session('datos_cita.specialty_id');
        $doctorId = session('datos_cita.doctor_id');

        // Si no hay datos en la sesión, redirigir al paso anterior
        if (!$shift || !$specialtyId || !$doctorId) {
            return redirect()->route('paciente.agendarCita.create')->with('error', 'Faltan datos para continuar.');
        }

        // Mostrar la vista paso1
        return view('paciente.agendarCita.paso1', compact('shift', 'specialtyId', 'doctorId'));
    }

    public function storeAppointment(Request $request)
    {
        // Validar los datos recibidos
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',  // Validar que el doctor exista
            'fecha' => 'required|date',
            'hora' => 'required',
            'metodo_pago' => 'required',
            /* 'schedule_id' => 'required|exists:schedules,id',  */ // Validar que el horario exista
            'comprobante' => 'nullable|file|mimes:jpeg,png,pdf|max:2048', // Solo si no es efectivo
            
            
        ]);
        // Obtener los datos
        $doctorId = $request->input('doctor_id');
        $fecha = Carbon::parse($request->input('fecha'));  // Convertimos la fecha a un objeto Carbon
        $hora = $request->input('hora');  // Hora seleccionada (en formato HH:mm)
        $turno = $request->input('shift');  // Puede ser 'mañana' o 'tarde'
        
        // Obtener el día de la semana (Lunes = 1, Domingo = 7)
        $dayOfWeek = $fecha->dayOfWeek;  // Esto devuelve un número entre 0 y 6

        // Convertimos el número del día de la semana al nombre en español
        $daysOfWeek = [
            1 => 'LUNES',
            2 => 'MARTES',
            3 => 'MIERCOLES',
            4 => 'JUEVES',
            5 => 'VIERNES',
            6 => 'SABADO',
            0 => 'DOMINGO',
        ];
    
        $dayName = $daysOfWeek[$dayOfWeek];  // Nombre del día en español

        // Buscar el horario correspondiente al doctor, turno, día y hora
        $schedule = Schedule::where('doctor_id', $doctorId)
            ->where('day_of_week', $dayName)
            /* ->where('start_time', $hora) */ // Aquí podrías verificar si el horario de inicio es exactamente la hora seleccionada
            ->where('shift', $turno)  // Filtrar por turno
            ->first();

        // Si el método de pago no es efectivo, asegurarnos de que haya un comprobante
        if ($request->metodo_pago !== 'efectivo' && !$request->hasFile('comprobante')) {
            return back()->withErrors(['comprobante' => 'El comprobante de pago es obligatorio.']);
        }

        $persona = Auth::user();

        $appointment = Appointment::create([
            'patient_id' => $persona->patient->id,
            'doctor_id' => $request->doctor_id,
            'schedule_id' => $schedule->id,
            'appointment_date' => $request->fecha,
            'appointment_time' => $request->hora,
        ]);

        // Si hay un comprobante de pago, lo guardamos
        if ($request->hasFile('comprobante')) {
            $comprobantePath = $request->file('comprobante')->store('comprobantes');
            /* $appointment->comprobante = $comprobantePath; */

            $payment = Payment::create([
                'appointment_id' => $appointment->id,
                'uploadted_by' => $persona->id,
                'image_path' => $comprobantePath,
                'payment_method' => $request->metodo_pago,
                'amount' => 30,
            ]);
        }else{
            $payment = Payment::create([
                'appointment_id' => $appointment->id,
                'uploadted_by' => $persona->id,
                'payment_method' => $request->metodo_pago,
                'amount' => 30,
            ]);
        }
        return response()->json(['message' => 'Cita guardada correctamente']);
    }

    // En el controlador AppointmentController.php
    // En tu controlador
    public function getExistingAppointments($doctorId, $fecha)
    {
        try {
            Log::debug('Doctor ID:', ['doctorId' => $doctorId]);
            Log::debug('Fecha:', ['fecha' => $fecha]);
    
            // Convertir la fecha al formato adecuado
            $fecha = Carbon::parse($fecha)->format('Y-m-d');
    
            // Continuar con la lógica
            $appointments = Appointment::where('doctor_id', $doctorId)
                ->whereDate('appointment_date', $fecha)
                ->get();
    
            // Log para ver las citas obtenidas
            Log::debug('Citas encontradas:', ['appointments' => $appointments]);
    
            // Filtrar las horas ocupadas
            $occupiedHours = $appointments->map(function ($appointment) {
                return $appointment->appointment_time;
            });
    
            return response()->json(['occupied_hours' => $occupiedHours]);
    
        } catch (\Exception $e) {
            // En caso de error, registramos el error en los logs
            Log::error('Error al obtener citas:', ['error' => $e->getMessage()]);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    

}
