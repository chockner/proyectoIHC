<?php

namespace App\Http\Controllers;

use App\Models\Specialty;
use App\Models\Doctor;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Obtener especialidades destacadas (las primeras 4)
        $featuredSpecialties = Specialty::take(4)->get();
        
        // Obtener todas las especialidades para la sección completa
        $allSpecialties = Specialty::all();
        
        // Obtener doctores destacados (los primeros 6)
        $featuredDoctors = Doctor::with(['user.profile', 'specialty'])
            ->take(6)
            ->get();
        
        // Estadísticas generales
        $stats = [
            'total_doctors' => Doctor::count(),
            'total_specialties' => Specialty::count(),
            'total_appointments' => \App\Models\Appointment::count(),
        ];

        return view('home', compact(
            'featuredSpecialties',
            'allSpecialties', 
            'featuredDoctors',
            'stats'
        ));
    }
} 