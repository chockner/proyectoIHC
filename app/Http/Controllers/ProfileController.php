<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;
use App\Models\User;
use App\Models\Patient;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        
        if(!$user->profile) {
            // Si el perfil no existe
            $user->profile()->create([
                'user_id' => $user->id,
            ]);
        }

        if($user->role->name == 'paciente' && !$user->patient) {
            // Si el paciente no existe
            $user->patient()->create([
                'user_id' => $user->id,
            ]);
        }

        return view('perfil.edit');
    }

    public function update(Request $request)
    {
        $request->validate([
            /* 'document_id' => 'required|string|max:8|unique:profiles,document_id,' . Auth::user()->profile->id, */
            'email' => 'required|string|email|max:255|unique:profiles,email,' . Auth::user()->profile->id,
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'phone' => 'nullable|string|max:9',
            'birthdate' => 'nullable|date',
            'address' => 'nullable|string|max:255',
            'gender' => 'nullable|string|max:1',
            'civil_status' => 'nullable|string|max:1',
            'region' => 'nullable|string|max:100',
            'province' => 'nullable|string|max:100',
            'district' => 'nullable|string|max:100',
        ]);

        // si el usuario es rapido puede guardar datos en minusculas
    
        $profile = Auth::user()->profile;
    
        // Recoge los nombres de la región, provincia y distrito desde los campos ocultos
        $data['region'] = $request->input('region_nombre');
        $data['province'] = $request->input('province_nombre');
        $data['district'] = $request->input('district_nombre');
    
        $profile->update($request->all() + $data);
    
        return redirect()->route('dashboard')->with('success', 'Perfil actualizado correctamente.');
    }
    
}
