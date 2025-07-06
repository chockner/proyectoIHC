<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MedicalRecord;
use App\Models\MedicalRecordDetail;

class HistorialMedicoController extends Controller
{
    public function index () 
    {
        $historiales = MedicalRecord::with(['patient.user.profile'])
            ->paginate(10);
        return view('admin.historialMedico.index',compact('historiales'));
    }

    public function show($id)
    {
        /* $historiales = MedicalRecord::findOrFail($id)->paginate(10); */
        $historiales = MedicalRecordDetail::with(['medicalRecord.patient.user.profile'/* , 'appointment.doctor.user.profile', 'appointment.specialty' */])
            ->where('medical_record_id', $id)
            ->paginate(10);
        return view('admin.historialMedico.show', compact('historiales'));
    }

    public function show_detail($id)
    {
        $historial = MedicalRecordDetail::findOrFail($id);
        return view('admin.historialMedico.show_detail', compact('historial'));
    }

    public function edit_detail($id)
    {
        $historial = MedicalRecordDetail::findOrFail($id);
        return view('admin.historialMedico.edit_detail', compact('historial'));
    }

    public function destroy($id)
    {
        $historial = MedicalRecord::findOrFail($id);
        $historial->delete();
        return redirect()->route('admin.historialMedico.index')
            ->with('success', 'Historial médico eliminado correctamente.');
    }

    public function update_detail(Request $request, $id){
        $detalleCita = MedicalRecordDetail::findOrFail($id);

        $detalleCita->update([
            'diagnosis' => $request->diagnosis,
            'treatment' =>  $request->treatment,
            'notes' => $request->notes,
        ]);

        return redirect()->route('admin.historialMedico.show', $detalleCita->id)->with('success', 'Cita actualizada correctamente.');
    }
}
