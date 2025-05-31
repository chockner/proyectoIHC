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
        // Obtenemos todos los horarios con los doctores relacionados
        $schedulesQuery = Schedule::with('doctor.specialty')->orderBy('start_time');
        
        // Filtrar por especialidad si se selecciona
        if ($request->has('specialty_filter') && $request->specialty_filter) {
            $schedulesQuery->whereHas('doctor', function ($query) use ($request) {
                $query->where('specialty_id', $request->specialty_filter);
            });
        }

        // Ejecutar la consulta y obtener los horarios
        $schedules = $schedulesQuery->get();

        // Generamos las horas de 8 a 6
        $hours = $this->generateHours();

        // Obtener todas las especialidades para el filtro
        $specialties = Specialty::all();

        // Retornamos la vista
        return view('admin.horarios.index', compact('schedules', 'hours', 'specialties'));
    }

    private function generateHours()
    {
        $start = 8; // 8:00 AM
        $end = 19; // 7:00 PM
        /* $interval = 60; */ // Intervalo de 1 hora
        $hours = [];

        // Generamos las horas de 8:00 AM a 7:00 PM
        for ($h = $start; $h < $end; $h++) {
            $hours[] = sprintf('%02d:%02d', $h,0);
        }

        return $hours;
    }

    public function create()
    {
        $doctors = Doctor::all();
        $specialties = Specialty::all();
        return view('admin.horarios.create', compact('doctors', 'specialties'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'day_of_week' => 'required|string|max:10',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        Schedule::create([
            'doctor_id' => $request->doctor_id,
            'day_of_week' => $request->day_of_week,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ]);

        return redirect()->route('admin.horarios.index')->with('success', 'Horario creado exitosamente.');
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
