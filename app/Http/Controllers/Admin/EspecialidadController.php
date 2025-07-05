<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Specialty;
use Illuminate\Support\Facades\Validator;


class EspecialidadController extends Controller
{
    public function index()
    {
        $especialidades = Specialty::with('doctors')->paginate(10);
        return view('admin.especialidad.index', compact('especialidades'));
    }

    public function create()
    {
        return view('admin.especialidad.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:specialties,name',
        ]);

        Specialty::create([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.especialidad.index')->with('success', 'Especialidad creada exitosamente.');
    }

}
