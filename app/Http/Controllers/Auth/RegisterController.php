<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Patient;
use App\Models\Profile;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            /* 'email' => 'required|string|email|max:255|unique:users,email', */
            'document_id' => 'required|string|size:8|unique:users,document_id',
            'password' => 'required|string|min:8|confirmed',
            'terms' => 'required|accepted',
        ], [
            'terms.required' => 'Debe aceptar los términos y condiciones para continuar.',
            'terms.accepted' => 'Debe aceptar los términos y condiciones para continuar.',
        ]);

        // Crear el usuario
        $user = User::create([
            /* 'email' => $request->email, */
            'document_id' => $request->document_id,
            'password' => Hash::make($request->password),
            'role_id' => 3, // Paciente
        ]);

        // Crear el perfil del usuario
        Profile::create([
            'user_id' => $user->id,
            // Los demás campos se pueden completar después en el perfil
        ]);

        // Crear el registro de paciente
        Patient::create([
            'user_id' => $user->id,
            // Los demás campos se pueden completar después
        ]);

        return redirect()->route('login')->with('excelente', 'Registro exitoso. Ahora puedes iniciar sesión.');
    }
}
