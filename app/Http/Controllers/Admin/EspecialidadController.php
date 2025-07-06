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

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $especialidad = Specialty::findOrFail($id);
        $especialidad->name = $request->input('name');
        $especialidad->save();

        return redirect()->route('admin.especialidad.index')->with('success', 'Especialidad actualizada correctamente');
    }


    public function destroy($id)
    {
        $especialidad = Specialty::findOrFail($id);
        $especialidad->delete();

        return redirect()->route('admin.especialidad.index')->with('success', 'Especialidad eliminada exitosamente.');
    }

}
