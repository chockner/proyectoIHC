<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Schedule;
use App\Models\Doctor;
use App\Models\Specialty;
use Illuminate\Support\Facades\DB;

class HorarioController extends Controller
{
    public function index(Request $request)
    {
        // Consulta base con relaciones
        $schedulesQuery = Schedule::with([
            'doctor.user.profile',
            'doctor.specialty'
        ])->orderBy('day_of_week')
        ->orderBy('shift') // Ordenar por turno
        ->orderBy('start_time');
        
        // Filtro por especialidad
        if ($request->filled('specialty_filter')) {
            $schedulesQuery->whereHas('doctor', function($query) use ($request) {
                $query->where('specialty_id', $request->specialty_filter);
            });
        }

        // Filtro por turno (opcional)
        if ($request->filled('shift_filter')) {
            $schedulesQuery->where('shift', $request->shift_filter);
        }

        // Obtenemos todos los horarios
        $schedules = $schedulesQuery->get();

        // Generamos las horas separadas por turno
        $hours = [
            'MAÑANA' => $this->generateHours(8, 13),  // 8:00 - 13:00
            'TARDE' => $this->generateHours(14, 19)   // 14:00 - 19:00
        ];
        
        // Días de la semana
        $days = ['LUNES', 'MARTES', 'MIERCOLES', 'JUEVES', 'VIERNES', 'SABADO'];
        
        // Especialidades para el filtro
        $specialties = Specialty::all();

        return view('admin.horarios.index', compact('schedules', 'hours', 'days', 'specialties'));
    }

    private function generateHours($start, $end)
    {
        $hours = [];
        for ($h = $start; $h <= $end; $h++) {
            $hours[] = sprintf('%02d:00', $h);
        }
        return $hours;
    }

    public function create()
    {
        $specialties = Specialty::all();
        return view('admin.horarios.create', compact('specialties'));
    }

    public function getDoctors($specialtyId)
    {
        $doctors = Doctor::where('specialty_id', $specialtyId)
            ->with(['user.profile' => function($query) {
                $query->select('id', 'user_id', 'last_name');
            }])
            ->get(['id', 'user_id', 'specialty_id']);
            
        return response()->json($doctors);
    }

    public function store(Request $request)
    {
        $request->validate([
            'specialty_id' => 'required|exists:specialties,id',
            'doctor_id' => 'required|exists:doctors,id',
            'day_of_week' => 'required|string|max:10|in:LUNES,MARTES,MIERCOLES,JUEVES,VIERNES,SABADO',
            'shift' => 'required|in:MAÑANA,TARDE',
            'start_time' => [
                'required',
                'date_format:H:i',
                function ($attribute, $value, $fail) use ($request) {
                    // Validar que la hora de inicio corresponda al turno
                    $hora = (int) explode(':', $value)[0];
                    if ($request->shift == 'MAÑANA' && ($hora < 8 || $hora >= 13)) {
                        $fail('La hora de inicio no corresponde al turno de la mañana (8:00 - 13:00)');
                    }
                    if ($request->shift == 'TARDE' && ($hora < 14 || $hora >= 19)) {
                        $fail('La hora de inicio no corresponde al turno de la tarde (14:00 - 19:00)');
                    }
                }
            ],
            'end_time' => [
                'required',
                'date_format:H:i',
                'after:start_time',
                function ($attribute, $value, $fail) use ($request) {
                    // Validar que la hora de fin corresponda al turno
                    $hora = (int) explode(':', $value)[0];
                    if ($request->shift == 'MAÑANA' && ($hora < 8 || $hora > 13)) {
                        $fail('La hora de fin no corresponde al turno de la mañana (8:00 - 13:00)');
                    }
                    if ($request->shift == 'TARDE' && ($hora < 14 || $hora > 19)) {
                        $fail('La hora de fin no corresponde al turno de la tarde (14:00 - 19:00)');
                    }
                }
            ]
        ]);

        // Verificar que no exista un horario duplicado
        $exists = Schedule::where('doctor_id', $request->doctor_id)
            ->where('day_of_week', $request->day_of_week)
            ->where('shift', $request->shift)
            ->exists();

        if ($exists) {
            return back()->with('error', 'Este médico ya tiene un horario asignado para este día y turno');
        }

        Schedule::create($request->all());

        return redirect()->route('admin.horarios.index')
            ->with('success', 'Horario creado exitosamente.');
    }
    
    public function editByFilters()
    {
        $specialties = Specialty::all();
        return view('admin.horarios.edit-by-filters', compact('specialties'));
    }
    
    public function getEditData(Request $request)
    {
        $request->validate([
            'specialty_id' => 'required|exists:specialties,id',
            'doctor_id' => 'required|exists:doctors,id',
            'shift' => 'required|in:MAÑANA,TARDE'
        ]);
    
        $horarios = Schedule::where('doctor_id', $request->doctor_id)
                    ->where('shift', $request->shift)
                    ->orderBy('day_of_week')
                    ->get();
    
        // Obtener solo los días que tienen horarios registrados
        $diasConHorarios = $horarios->pluck('day_of_week')->unique()->toArray();
    
        return response()->json([
            'horarios' => $horarios,
            'days' => $diasConHorarios // Solo devolvemos los días con horarios
        ]);
    }
    
    public function bulkUpdate(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'shift' => 'required|in:MAÑANA,TARDE',
            'horarios' => 'required|array',
            'horarios.*.day_of_week' => 'required|in:LUNES,MARTES,MIERCOLES,JUEVES,VIERNES,SABADO',
            'horarios.*.start_time' => 'required|date_format:H:i',
            'horarios.*.end_time' => [
                'required',
                'date_format:H:i',
                'after:horarios.*.start_time',
                function ($attribute, $value, $fail) use ($request) {
                    $index = explode('.', $attribute)[1];
                    $shift = $request->shift;
                    $hora = (int) explode(':', $value)[0];
                    
                    if ($shift == 'MAÑANA' && ($hora < 8 || $hora > 13)) {
                        $fail('La hora de fin no corresponde al turno de la mañana (8:00 - 13:00)');
                    }
                    if ($shift == 'TARDE' && ($hora < 14 || $hora > 19)) {
                        $fail('La hora de fin no corresponde al turno de la tarde (14:00 - 19:00)');
                    }
                }
            ]
        ]);
    
        DB::transaction(function() use ($request) {
            // Eliminar horarios existentes para este médico y turno
            Schedule::where('doctor_id', $request->doctor_id)
                ->where('shift', $request->shift)
                ->delete();
    
            // Crear nuevos horarios
            foreach ($request->horarios as $horarioData) {
                Schedule::create([
                    'doctor_id' => $request->doctor_id,
                    'day_of_week' => $horarioData['day_of_week'],
                    'shift' => $request->shift,
                    'start_time' => $horarioData['start_time'],
                    'end_time' => $horarioData['end_time']
                ]);
            }
        });
    
        return redirect()->route('admin.horarios.index')
            ->with('success', 'Horarios actualizados exitosamente.');
    }

    public function destroy($id)
    {
        $horario = Schedule::findOrFail($id);
        $horario->delete();

        return redirect()->route('admin.horarios.index')->with('success', 'Horario eliminado exitosamente.');
    }
    public function show($id)
    {
        $horario = Schedule::findOrFail($id);
        return view('admin.horarios.show', compact('horario'));
    }
}
