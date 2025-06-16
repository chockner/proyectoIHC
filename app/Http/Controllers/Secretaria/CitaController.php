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
        $sort = $request->input('sort', 'date'); // Ordenar por fecha por defecto
        $order = $request->input('order', 'asc'); // Orden ascendente por defecto

        // Consulta base con relaciones
        $query = Appointment::with(['patient.user', 'doctor.user']);

        // Aplicar filtro por estado si existe
        if ($status && in_array($status, ['programada', 'completada', 'cancelada'])) {
            $query->where('status', $status);
        }

        // Ordenar según parámetros
        switch ($sort) {
            case 'status':
                // Ordenar por estado (programadas primero)
                $query->orderByRaw("FIELD(status, 'programada', 'completada', 'cancelada')");
                break;
            case 'date':
            default:
                // Ordenar por fecha (más recientes primero o según el orden)
                $query->orderBy('appointment_date', $order);
                break;
        }

        // Paginar resultados
        $citas = $query->paginate(10);

        // Mantener parámetros de búsqueda en la paginación
        $citas->appends([
            'status' => $status,
            'sort' => $sort,
            'order' => $order
        ]);

        return view('secretaria.citas.index', compact('citas'));
    }
}
