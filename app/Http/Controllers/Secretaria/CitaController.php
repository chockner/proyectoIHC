<?php

namespace App\Http\Controllers\Secretaria;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment; // Assuming you have an Appointment model

class CitaController extends Controller
{
    /* public function index()
    {
        // Aquí puedes implementar la lógica para mostrar las citas
        $citas = Appointment::with('patient.user', 'doctor.user')->paginate(10); // Assuming you have relationships set up

        //$citas = Appointment::all();

        return view('secretaria.citas.index', compact('citas'));
    } */

    public function index(Request $request)
    {
        // Obtener parámetros de búsqueda
        $status = $request->input('status');
        $fecha = $request->input('fecha');
    
        // Consulta base con relaciones
        $query = Appointment::with(['patient.user', 'doctor.user']);
    
        // Aplicar filtro por estado si existe
        if ($status && in_array($status, ['programada', 'completada', 'cancelada'])) {
            $query->where('status', $status);
        }
    
        // Aplicar filtro por fecha si existe
        if ($fecha) {
            $query->whereDate('appointment_date', $fecha);
        }
    
        // Ordenar por fecha (más recientes primero, descendente)
        $query->orderBy('appointment_date', 'desc');
    
        // Paginar resultados
        $citas = $query->paginate(10);
    
        // Mantener parámetros de búsqueda en la paginación
        $citas->appends([
            'status' => $status,
            'fecha' => $fecha
        ]);
    
        return view('secretaria.citas.index', compact('citas'));
    }
    

    public function show($id){
        $cita = Appointment::findOrFail($id);
        return view('secretaria.citas.show', compact('cita'));
    }
}
