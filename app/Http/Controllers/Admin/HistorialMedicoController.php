<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MedicalRecord;

class HistorialMedicoController extends Controller
{
    public function index () 
    {
        $historiales=MedicalRecord::all();
        return view('admin.historialMedico.index',compact('historiales'));
    }
}
