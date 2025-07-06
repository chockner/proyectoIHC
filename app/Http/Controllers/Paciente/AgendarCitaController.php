<?php

namespace App\Http\Controllers\Paciente;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Schedule;
use App\Models\Doctor;
use App\Models\Specialty;
use App\Models\Appointment;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AgendarCitaController extends Controller
{
    public function create()
    {
        // Aquí puedes implementar la lógica para mostrar el formulario de agendar cita
        $specialties = Specialty::all();
        return view('paciente.agendarCita.create', compact('specialties'));
    }

    public function getDoctors($specialtyId, $shift)
    {
        // Filtramos los doctores por especialidad y turno
        $doctors = Doctor::where('specialty_id', $specialtyId)
            ->whereHas('schedules', function($query) use ($shift) {
                $query->where('shift', $shift);  // Filtramos por el turno
            })
            ->with(['user.profile' => function($query) {
                $query->select('id', 'user_id', 'last_name');
            }])
            ->get(['id', 'user_id', 'specialty_id']);
        
        return response()->json($doctors);
    }

    public function getSchedules($doctor_id, $shift)
    {
        // Obtener los horarios del doctor para el turno especificado
        $schedules = Schedule::where('doctor_id', $doctor_id)
                             ->where('shift', $shift)
                             ->get();
    
        // Crear un arreglo con los días de la semana y las horas en formato adecuado
        $availableSchedules = [];
    
        foreach ($schedules as $schedule) {
            $availableSchedules[] = [
                'day_of_week' => $schedule->day_of_week,
                'start_time'  => $schedule->start_time->format('H:i'), // Formato de hora: 08:00
                'end_time'    => $schedule->end_time->format('H:i'),   // Formato de hora: 17:00
            ];
        }
    
        return response()->json([
            'schedules' => $availableSchedules,
        ]);
    }


    public function createPaso1(Request $request)
    {
        // Obtén la especialidad, turno y doctor de la sesión o de la solicitud
        $doctorId = session('datos_cita.doctor_id');
        $shift = session('datos_cita.shift');
        
        // Validar si estos datos están disponibles
        if (!$doctorId || !$shift) {
            return redirect()->route('paciente.agendarCita.create')->with('error', 'Faltan datos de turno o médico.');
        }

        // Mostrar la vista para elegir la fecha y hora
        return view('paciente.agendarCita.paso1');
    }

    public function getAvailableTimes($doctorId, $shift, $date)
    {
        // Obtener los horarios del doctor para la fecha y turno seleccionados
        $doctor = Doctor::findOrFail($doctorId);

        // Buscar los horarios disponibles en esa fecha
        $availableTimes = $doctor->schedules()
            ->where('shift', $shift)
            ->whereDate('date', $date)  // Filtrar por la fecha seleccionada
            ->get();

        // Extraer las horas disponibles
        $times = $availableTimes->pluck('time');  // Asegúrate de que "time" sea el campo correcto

        return response()->json($times);
    }

    public function store(Request $request)
    {
        // Validar los datos enviados
        $request->validate([
            'shift' => 'required',
            'specialty_id' => 'required',
            'doctor_id' => 'required',
        ]);

        // Guardar los datos en la sesión
        session([
            'datos_cita.shift' => $request->shift,
            'datos_cita.specialty_id' => $request->specialty_id,
            'datos_cita.doctor_id' => $request->doctor_id,
        ]);

        // Redirigir al paso 1
        return redirect()->route('paciente.agendarCita.paso1');
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
