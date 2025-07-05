<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MedicalRecord;

class HistorialMedicoController extends Controller
{
    public function index () 
    {
        $historiales = MedicalRecord::with(['patient.user.profile'])
            ->paginate(10);
        return view('admin.historialMedico.index',compact('historiales'));
    }
}
