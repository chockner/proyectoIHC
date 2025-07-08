<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\MedicalRecord;
use App\Models\MedicalRecordDetail;

class PacienteController extends Controller
{
    public function index(){
        $pacientes = Patient::with('user.profile')->paginate(10);
        return view('doctor.pacientes.index', compact('pacientes'));
    }

    public function show($id){
        $historial = MedicalRecordDetail::with(['medicalRecord.patient.user.profile'])
            ->where('medical_record_id', $id)
            ->paginate(10);
        return view('doctor.pacientes.show', compact('historial'));
    }
}
