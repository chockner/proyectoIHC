<?php

namespace App\Http\Controllers\Paciente;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Schedule;
use App\Models\Doctor;
use App\Models\Specialty;

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


}
