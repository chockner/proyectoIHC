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
        ]);

        User::create([
            /* 'email' => $request->email, */
            'document_id' => $request->document_id,
            'password' => Hash::make($request->password),
            'role_id' => 3,
        ]);

        return redirect()->route('login')->with('excelente', 'Registro exitoso. Ahora puedes iniciar sesión.');
    }
}
