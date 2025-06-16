<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Doctor;
use App\Models\Secretary;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\Specialty;
use App\Models\Payment;

class DashboardController extends Controller
{
    public function index()
    {
        $role = Auth::user()->role->name;

        return match ($role){
            'admin' => view('dashboard.admin'),
            'doctor' => view('dashboard.doctor'),
            'paciente' => view('dashboard.paciente'),
            'secretaria' => view('dashboard.secretaria'),
            default => abort(403, 'Unauthorized action.'),
        };
    }

    public function adminDashboard()
    {
        return view('dashboard.admin', [
            'totalDoctores' => Doctor::count(),
            'totalSecretarias' => Secretary::count(),
            'totalPacientes' => Patient::count(),
            'totalEspecialidades' => Specialty::count(),
            'totalCitas' => Appointment::count(),
            'totalPagos' => Payment::count(),
        ]);
    }

    public function secretariaDashboard()
    {
        return view('dashboard.secretaria', [
            'totalCitas' => Appointment::count(),
            'totalCitasProgramadas' => Appointment::where('status', 'programada')->count(),
            'totalCitasCompletadas' => Appointment::where('status', 'completada')->count(),
        ]);
    }

    public function doctorDashboard()
    {
        return view('dashboard.doctor', [
            'totalPacientes' => Patient::count(),
        ]);
    }

    public function pacienteDashboard()
    {
        $patientId = Auth::user()->patient->id;
        
        return view('dashboard.paciente', [
            'totalCitas' => Appointment::where('patient_id', $patientId)->count(),
            'totalCitasProgramadas' => Appointment::where('patient_id', $patientId)->where('status', 'programada')->count(),
            'totalCitasCompletadas' => Appointment::where('patient_id', $patientId)->where('status', 'completada')->count(),
        ]);
    }
}
