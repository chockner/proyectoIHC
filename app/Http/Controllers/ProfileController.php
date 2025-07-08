<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;
use App\Models\User;
use App\Models\Patient;
use App\Models\Doctor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;


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
        try {
            $user = Auth::user();
            $profile = $user->profile;
            $role = $user->role->name;

            // Validaciones generales
            $request->validate([
                'document_id' => 'required|string|max:8',
                'first_name' => 'required|string|max:100|regex:/^[A-Za-zÁáÉéÍíÓóÚúÑñ\s]+$/',
                'last_name' => 'required|string|max:100|regex:/^[A-Za-zÁáÉéÍíÓóÚúÑñ\s]+$/',
                'phone' => 'nullable|string|max:20',
                'birthdate' => 'nullable|date',
                'address' => 'nullable|string|max:255',
                'gender' => 'nullable|string|max:1',
                'civil_status' => 'nullable|string|max:1',
                // 'region' => 'nullable|string|max:100',
                // 'province' => 'nullable|string|max:100',
                // 'district' => 'nullable|string|max:100',
                // Foto de perfil
                'photo' => 'nullable|image|max:5120', // 5MB
            ], [
                'document_id.required' => 'El DNI es requerido.',
                'document_id.max' => 'El DNI no puede tener más de 8 caracteres.',
                'first_name.required' => 'El nombre es requerido.',
                'first_name.regex' => 'El nombre solo puede contener letras y espacios.',
                'last_name.required' => 'Los apellidos son requeridos.',
                'last_name.regex' => 'Los apellidos solo pueden contener letras y espacios.',
            ]);

            // Validaciones específicas por rol
            if ($role === 'paciente') {
                $request->validate([
                    'emergency_contact' => 'nullable|string|max:100',
                    'emergency_phone' => 'nullable|string|max:20',
                ]);
            }

            // Actualizar datos del usuario (DNI)
            $user->document_id = $request->input('document_id');
            $user->save();

            // Actualizar foto de perfil si se subió
            if ($request->hasFile('photo')) {
                // Eliminar foto anterior si existe
                if ($profile->photo && Storage::disk('public')->exists($profile->photo)) {
                    Storage::disk('public')->delete($profile->photo);
                }
                $path = $request->file('photo')->store('profile_photos', 'public');
                $profile->photo = $path;
            }

            // Actualizar datos generales del perfil
            $profile->first_name = $request->input('first_name');
            $profile->last_name = $request->input('last_name');
            $profile->phone = $request->input('phone');
            $profile->birthdate = $request->input('birthdate');
            $profile->address = $request->input('address');
            $profile->gender = $request->input('gender');
            $profile->civil_status = $request->input('civil_status');
            // $profile->region = $request->input('region');
            // $profile->province = $request->input('province');
            // $profile->district = $request->input('district');
            $profile->save();

            // Actualizar datos específicos por rol
            if ($role === 'paciente') {
                $user->patient()->updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'emergency_contact' => $request->input('emergency_contact'),
                        'emergency_phone' => $request->input('emergency_phone'),
                    ]
                );
            } elseif ($role === 'doctor') {
                $user->doctor()->updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'license_code' => $request->input('license_code'),
                        'experience_years' => $request->input('experience_years'),
                        'professional_bio' => $request->input('professional_bio'),
                    ]
                );
            }
            // Para secretaria no hay campos adicionales editables

            return redirect()->route('perfil.edit')->with('success', 'Perfil actualizado correctamente.');
            
        } catch (\Exception $e) {
            \Log::error('Error al actualizar perfil: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Error al actualizar el perfil: ' . $e->getMessage());
        }
    }
    
}
