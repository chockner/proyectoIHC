<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CitaController extends Controller
{
    public function index(Request $request){
        $user = Auth::user();
        $doctorId = $user->doctor->id;

        // Obtener la fecha seleccionada (por defecto la fecha actual de Perú)
        $fecha = $request->input('fecha');

        // Si no hay fecha seleccionada, mostrar todas las citas
        if (!$fecha) {
            // Mostrar todas las citas sin filtro de fecha
            $citas = Appointment::where('doctor_id', $doctorId)
                ->orderByRaw('FIELD(status, "programada") DESC')
                ->orderBy('appointment_date', 'desc')
                ->paginate(10);
        } else {
            // Si se selecciona una fecha, filtrar por esa fecha
            $fecha = Carbon::createFromFormat('Y-m-d', $fecha, 'America/Lima')->toDateString(); // Ajustar fecha a la zona horaria de Perú
            $citas = Appointment::where('doctor_id', $doctorId)
                ->whereDate('appointment_date', $fecha)  // Esto filtra las citas por la fecha exacta
                ->orderByRaw('FIELD(status, "programada") DESC')
                ->orderBy('appointment_date', 'desc')
                ->paginate(10);
        }
        
        return view('doctor.citas.index', compact('citas'));
    }

    public function edit($id)
    {
        $cita = Appointment::findOrFail($id);
        return view('doctor.citas.edit', compact('cita'));
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $doctorId = $user->doctor->id;
        
        $appointment = Appointment::findOrFail($id);

        // Validar los datos del formulario
        $validated = $request->validate([
            'diagnosis' => 'nullable|string',
            'treatment' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        // Actualizar o crear el registro en MedicalRecordDetail
        $detalle=MedicalRecordDetail::Create(
            [
                'medical_record_id' => $appointment->patient->medicalRecord->id,
                'appointment_id' => $appointment->id,
                'diagnosis' => $request->diagnosis,
                'treatment' => $request->treatment,
                'notes' => $request->notes,
            ]
        );

        $appointment->update([
            'status' => 'completada',
        ]);
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