<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            /* 'email' => 'required|email', */
            'document_id' => 'required|string|size:8', // DNI como identificador único
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            if(Auth::user()->role->name === 'paciente'){
                return redirect('/dashboard');
            }else{
                Auth::logout();
                return back()->with('error', 'Acceso no autorizado.')->withInput();
            }
        }
        
        return back()->with('error', 'Credenciales incorrectas.')->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function showLoginPersonalForm()
    {
        return view('auth.loginPersonal');
    }

    public function loginPersonal(Request $request)
    {
        $credentials = $request->validate([
            'document_id' => 'required|string|size:8', // DNI como identificador único
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            switch (Auth::user()->role->name) {
                case 'admin':
                    return redirect('/dashboard');
                case 'secretaria':
                    return redirect('/dashboard');
                case 'doctor':
                    return redirect('/dashboard');
                default:
                    Auth::logout();
                    return back()->with('error', 'Acceso no autorizado.')->withInput();
            }

            return redirect('/dashboard');
        }

        return back()->with('error', 'Credenciales incorrectas.')->withInput();
    }
}
