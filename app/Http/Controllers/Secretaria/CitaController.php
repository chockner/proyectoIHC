<?php

namespace App\Http\Controllers\Secretaria;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;

class CitaController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->input('status');
        $fecha = $request->input('fecha');
    
        $query = Appointment::with(['patient.user.profile', 'doctor.user.profile', 'doctor.specialty']);
    
        if ($status && in_array($status, ['programada', 'completada', 'cancelada'])) {
            $query->where('status', $status);
        }
    
        if ($fecha) {
            $query->whereDate('appointment_date', $fecha);
        }
    
        $query->orderBy('appointment_date', 'desc');
    
        $citas = $query->paginate(10);
    
        $citas->appends([
            'status' => $status,
            'fecha' => $fecha
        ]);
    
        return view('secretaria.citas.index', compact('citas'));
    }

    public function show($id)
    {
        $cita = Appointment::with([
            'doctor.user.profile',
            'patient.user.profile',
            'doctor.specialty',
            'payment'
        ])->findOrFail($id);

        return view('secretaria.citas.show', compact('cita'));
    }

    public function validatePayment($id)
    {
        $cita = Appointment::with('payment')->findOrFail($id);

        if (!$cita->payment) {
            return redirect()->route('secretaria.citas.show', $id)->with('error', 'No existe un comprobante de pago para esta cita.');
        }

        if ($cita->payment->status !== 'pendiente') {
            return redirect()->route('secretaria.citas.show', $id)->with('error', 'El comprobante ya ha sido procesado.');
        }

        $cita->payment->update(['status' => 'validado']);

        return redirect()->route('secretaria.citas.show', $id)->with('success', 'Comprobante validado correctamente.');
    }

    public function rejectPayment($id)
    {
        $cita = Appointment::with('payment')->findOrFail($id);

        if (!$cita->payment) {
            return redirect()->route('secretaria.citas.show', $id)->with('error', 'No existe un comprobante de pago para esta cita.');
        }

        if ($cita->payment->status !== 'pendiente') {
            return redirect()->route('secretaria.citas.show', $id)->with('error', 'El comprobante ya ha sido procesado.');
        }

        $cita->payment->update(['status' => 'rechazado']);

        return redirect()->route('secretaria.citas.show', $id)->with('success', 'Comprobante rechazado correctamente.');
    }
}