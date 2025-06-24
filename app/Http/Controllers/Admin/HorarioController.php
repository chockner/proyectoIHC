<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Schedule;
use App\Models\Doctor;
use App\Models\Specialty;


class HorarioController extends Controller
{
    public function index(Request $request)
    {
        // Consulta base con relaciones
        $schedulesQuery = Schedule::with([
            'doctor.user.profile',
            'doctor.specialty'
        ])->orderBy('day_of_week')
        ->orderBy('start_time');
        
        // Filtro por especialidad
        if ($request->filled('specialty_filter')) {
            $schedulesQuery->whereHas('doctor', function($query) use ($request) {
                $query->where('specialty_id', $request->specialty_filter);
            });
        }

        // Obtenemos todos los horarios
        $schedules = $schedulesQuery->get();

        // Generamos las horas de 8:00 a 18:00
        $hours = $this->generateHours();
        
        // Días de la semana
        $days = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes'];
        
        // Especialidades para el filtro
        $specialties = Specialty::all();

        return view('admin.horarios.index', compact('schedules', 'hours', 'days', 'specialties'));
    }

    private function generateHours()
    {
        $hours = [];
        for ($h = 8; $h <= 18; $h++) {
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
            'day_of_week' => 'required|string|max:10',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        Schedule::create($request->all());

        return redirect()->route('admin.horarios.index')
            ->with('success', 'Horario creado exitosamente.');
    }
    public function edit($id)
    {
        $horario = Schedule::findOrFail($id);
        $doctors = Doctor::all();
        return view('admin.horarios.edit', compact('horario', 'doctors'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'day_of_week' => 'required|string|max:10',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        $horario = Schedule::findOrFail($id);
        $horario->update($request->all());

        return redirect()->route('admin.horarios.index')->with('success', 'Horario actualizado exitosamente.');
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
