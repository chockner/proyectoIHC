<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Profile;
use App\Models\User;

class PacienteController extends Controller
{
    public function index()
    {
        $pacientes = Patient::with('user.profile')->paginate(10);
        return view('admin.paciente.index', compact('pacientes'));
    }
    public function create()
    {
        return view('admin.paciente.create');
    }

    public function edit($id)
    {
        $paciente = Patient::findOrFail($id);
        return view('admin.paciente.edit', compact('paciente'));
    }

    public function update(Request $request, $id)
    {
        $paciente = Patient::findOrFail($id);
        
        //$paciente->update([]); // Aquí puedes actualizar los campos específicos del paciente si es necesario
        
        $paciente->user->profile->update([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'phone' => $request->input('phone'),
            // mas datos del perfil si es necesario
        ]);

        // creo que el dni no debe permitir editar ahhhh

        return redirect()->route('admin.paciente.index')->with('success', 'Paciente actualizado correctamente.');
    }

    public function destroy($id)
    {
        $paciente = Patient::findOrFail($id);
        
        if ($paciente->user) {
            if($paciente->user->profile) {
                $paciente->user->profile->delete();
            }
            $paciente->user->delete();
        }
        $paciente->delete();
        
        return redirect()->route('admin.paciente.index')->with('success', 'Paciente eliminado correctamente.');
    }
}
