<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;

class CitaController extends Controller
{
    public function index(Request $request){
        $user = Auth::user();
        $doctorId = $user->doctor->id;

        // Obtener la fecha seleccionada (por defecto la fecha actual)
        $fecha = $request->input('fecha', now()->toDateString());
        
        // Filtrar citas por la fecha
        $citas = Appointment::where('doctor_id', $doctorId)
            ->whereDate('appointment_date', $fecha)  // Esto filtra las citas por la fecha exacta
            ->orderByRaw('FIELD(status, "programada") DESC')
            ->orderBy('appointment_date', 'desc')
            ->paginate(10);
        
        return view('doctor.citas.index', compact('citas'));
    }

    public function edit($id){
        $cita = Appointment::findOrFail($id);
        return view('doctor.citas.edit', compact('cita'));
    }

    public function show($id)
    {
        $appointment = Appointment::with([
            'patient.user.profile',
            'doctor.user.profile',
            'doctor.specialty',
            'payment',
            'medicalRecordDetail'
        ])->findOrFail($id);

        return view('doctor.citas.show', compact('appointment'));
    }
}