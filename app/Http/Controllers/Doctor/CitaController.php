<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;


class CitaController extends Controller
{
    public function index(){
        $user = Auth::user();
        $doctorId = $user->doctor->id;
        $citas = Appointment::where('doctor_id', $doctorId)
            ->orderByRaw('FIELD(status, "programada") DESC')
            ->orderBy('appointment_date','desc')
            ->paginate(10);

        return view('doctor.citas.index',compact('citas'));
    }

    public function show($id){
        $cita = Appointment::findOrFail($id);
        return view('doctor.citas.show', compact('cita'));
    }
}
