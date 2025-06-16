<?php

namespace App\Http\Controllers\Paciente;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AgendarCitaController extends Controller
{
    public function create()
    {
        // Aquí puedes implementar la lógica para mostrar el formulario de agendar cita
        return view('paciente.agendarCita.create');
    }
    public function store(Request $request)
    {
        
        return redirect()->route('dashboard')->with('success', 'Cita agendada exitosamente.');
    }
}
