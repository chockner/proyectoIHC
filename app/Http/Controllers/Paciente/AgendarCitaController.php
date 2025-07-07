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
use Illuminate\Support\Facades\Log;

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
     * Paso 4: Confirmación y Pago (GET - para manejar errores de validación)
     */
    public function confirmacionGet()
    {
        // Verificar que tenemos todos los datos necesarios en la sesión
        $specialtyId = session('agendar_cita.specialty_id');
        $doctorId = session('agendar_cita.doctor_id');
        $scheduleId = session('agendar_cita.schedule_id');
        $appointmentDate = session('agendar_cita.appointment_date');
        $appointmentTime = session('agendar_cita.appointment_time');

        if (!$specialtyId || !$doctorId || !$scheduleId || !$appointmentDate || !$appointmentTime) {
            return redirect()->route('paciente.agendarCita.create')
                ->withErrors(['error' => 'Datos de la cita no encontrados. Por favor inicie el proceso nuevamente.']);
        }

        $especialidad = Specialty::findOrFail($specialtyId);
        $medico = Doctor::with(['user.profile', 'specialty'])->findOrFail($doctorId);
        $horario = Schedule::findOrFail($scheduleId);
        $paciente = auth()->user()->patient;

        // Calcular el costo
        $costo = 150.00;

        return view('paciente.agendarCita.paso4-confirmacion', compact(
            'especialidad',
            'medico',
            'horario',
            'paciente',
            'costo'
        ));
    }

    /**
     * Paso 4: Confirmación y Pago (POST)
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
        // Log para debugging
        Log::info('Store method called', [
            'method' => $request->method(),
            'payment_method' => $request->payment_method,
            'all_data' => $request->all()
        ]);

        // Validación condicional según el método de pago
        $validationRules = [
            'specialty_id' => 'required|exists:specialties,id',
            'doctor_id' => 'required|exists:doctors,id',
            'schedule_id' => 'required|exists:schedules,id',
            'appointment_date' => 'required|date|after:today',
            'appointment_time' => 'required',
            'payment_method' => 'required|in:tarjeta,transfer,clinica',
            'amount' => 'required|numeric|min:0',
            'terms' => 'required|accepted'
        ];

        // Agregar reglas según el método de pago
        if ($request->payment_method === 'tarjeta') {
            $validationRules['card_number'] = 'required|string|min:13';
            $validationRules['card_holder'] = 'required|string|min:3';
            $validationRules['card_expiry'] = 'required|string|size:5';
            $validationRules['card_cvv'] = 'required|string|min:3';
            $validationRules['card_email'] = 'required|email';
        } elseif ($request->payment_method === 'transfer') {
            $validationRules['transfer_method'] = 'required|in:transferencia,yape,plin';
            $validationRules['payment_proof'] = 'required|file|mimes:jpg,jpeg,png,pdf|max:5120';
        }

        $request->validate($validationRules);

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

            // Determinar el método de pago específico
            $paymentMethod = $request->payment_method;
            if ($request->payment_method === 'transfer') {
                $paymentMethod = $request->transfer_method; // transferencia, yape, o plin
            }

            // Procesar el comprobante de pago si se subió
            $imagePath = null;
            if ($request->hasFile('payment_proof')) {
                $file = $request->file('payment_proof');
                $fileName = 'payment_proof_' . time() . '_' . $file->getClientOriginalName();
                $imagePath = $file->storeAs('payment_proofs', $fileName, 'public');
            }

            // Determinar el estado inicial del pago
            $paymentStatus = 'pendiente';
            $validatedBy = null;
            $validatedAt = null;

            // Si es pago con tarjeta, marcar como validado automáticamente (simulación)
            if ($request->payment_method === 'tarjeta') {
                $paymentStatus = 'validado';
                $validatedBy = auth()->id();
                $validatedAt = now();
            }

            // Crear el registro de pago
            $payment = Payment::create([
                'appointment_id' => $cita->id,
                'uploaded_by' => auth()->id(),
                'validated_by' => $validatedBy,
                'payment_method' => $paymentMethod,
                'amount' => $request->amount,
                'status' => $paymentStatus,
                'uploaded_at' => now(),
                'validated_at' => $validatedAt,
                'image_path' => $imagePath
            ]);

            // Si el pago está validado, mantener la cita como programada
            // Las citas se mantienen como 'programada' hasta que se completen
            if ($paymentStatus === 'validado') {
                // No cambiar el status de la cita, mantener como 'programada'
                // El pago validado es suficiente para confirmar la reserva
            }

            DB::commit();

            // Limpiar sesión después de agendar exitosamente
            session()->forget(['agendar_cita.specialty_id', 'agendar_cita.doctor_id', 'agendar_cita.schedule_id', 'agendar_cita.appointment_date', 'agendar_cita.appointment_time']);

            // Mensaje de éxito según el método de pago
            $successMessage = 'Cita agendada exitosamente.';
            if ($request->payment_method === 'tarjeta') {
                $successMessage = '¡Pago procesado exitosamente! Su cita ha sido confirmada.';
            } elseif ($request->payment_method === 'transfer') {
                $successMessage = 'Cita agendada exitosamente. Su comprobante de pago será revisado y recibirá una confirmación por email.';
            } elseif ($request->payment_method === 'clinica') {
                $successMessage = 'Cita agendada exitosamente. Recuerde realizar el pago en la clínica antes de su consulta.';
            }

            return redirect()->route('paciente.citas.show', $cita->id)
                ->with('success', $successMessage);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error al agendar cita: ' . $e->getMessage());
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
}
