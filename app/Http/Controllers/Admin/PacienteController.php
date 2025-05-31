<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Patient;

class PacienteController extends Controller
{
    public function index()
    {
        $pacientes = Patient::all();
        return view('admin.paciente.index', compact('pacientes'));
    }
    public function create()
    {
        return view('admin.paciente.create');
    }
}
