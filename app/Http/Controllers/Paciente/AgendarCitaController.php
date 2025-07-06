<?php

namespace App\Http\Controllers\Paciente;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AgendarCitaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Obtener las citas del paciente autenticado paginadas

        $paciente = auth()->user()->patient;
        $citas = $paciente->appointments()->paginate(10);
        return view('paciente.citas.index', compact('citas'));
    }
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
