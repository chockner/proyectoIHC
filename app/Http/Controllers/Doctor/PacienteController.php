<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\MedicalRecord;
use App\Models\MedicalRecordDetail;

class PacienteController extends Controller
{
    public function index(Request $request)
    {
        // Obtenemos la consulta de búsqueda si existe
        $search = $request->get('search');
        
        // Si hay una búsqueda, filtramos por nombre y apellido
        if ($search) {
            $pacientes = Patient::with('user.profile')
                ->whereHas('user.profile', function($query) use ($search) {
                    $query->where('first_name', 'like', "%{$search}%")
                          ->orWhere('last_name', 'like', "%{$search}%");
                })
                ->paginate(10);
        } else {
            // Si no hay búsqueda, mostramos todos los pacientes
            $pacientes = Patient::with('user.profile')->paginate(10);
        }

        // Si es una solicitud AJAX, devolvemos solo los resultados de la tabla
        if ($request->ajax()) {
            return view('doctor.pacientes.table', compact('pacientes'));
        }

        return view('doctor.pacientes.index', compact('pacientes'));
    }

    public function show($id){
        $historial = MedicalRecordDetail::with(['medicalRecord.patient.user.profile'])
            ->where('medical_record_id', $id)
            ->paginate(10);
        return view('doctor.pacientes.show', compact('historial'));
    }
}
