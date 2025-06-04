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
        $pacientes = Patient::all();
        return view('admin.paciente.index', compact('pacientes'));
    }
    public function create()
    {
        return view('admin.paciente.create');
    }
    public function destroy($id)
    {
        $paciente = Patient::findOrFail($id);
        
        if ($paciente->user) {
            $perfil = Profile::where('user_id', $paciente->user_id)->first();
            $user = User::findOrFail($paciente->user_id);

            // Eliminar datos
            $paciente->delete();
            $perfil->delete();
            $user->delete();
        } else {
            // En caso de que no haya usuario asociado
            $paciente->delete();
        }
        
        return redirect()->route('admin.paciente.index')->with('success', 'Paciente eliminado correctamente.');
    }
}
