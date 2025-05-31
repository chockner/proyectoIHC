<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Specialty;

class EspecialidadController extends Controller
{
    public function index()
    {
        $especialidades = Specialty::all();
        return view('admin.especialidad.index', compact('especialidades'));
    }

    public function create()
    {
        return view('admin.especialidad.create');
    }

}
