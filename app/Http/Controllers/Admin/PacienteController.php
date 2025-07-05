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
