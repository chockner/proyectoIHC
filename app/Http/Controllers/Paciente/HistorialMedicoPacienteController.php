<?php

namespace App\Http\Controllers\Paciente;

use App\Http\Controllers\Controller;
use App\Models\MedicalRecord;
use App\Models\Patient;
use Illuminate\Http\Request;

class HistorialMedicoPacienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Obtener el id del usuario autenticado
        $user = auth()->user();
        $paciente = Patient::where('user_id', $user->id)->first();
        $historialMedico = MedicalRecord::where('patient_id', $paciente->id)->get();

        return view('paciente.historialMedico.index', compact('historialMedico'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
