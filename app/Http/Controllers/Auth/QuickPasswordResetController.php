<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class QuickPasswordResetController extends Controller
{
    // Mostrar el formulario para restablecer la contraseña
    public function showForm()
    {
        return view('auth.quick-reset');
    }

    // Procesar el restablecimiento de la contraseña
    public function resetPassword(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'document_id' => 'required|string|size:8',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
        ]);

         // Buscar al usuario con el DNI y los nombres y apellidos en el profile
         $user = User::where('document_id', $request->document_id)
            ->whereHas('profile', function ($query) use ($request) {
                $query->where('first_name', $request->first_name)
                    ->where('last_name', $request->last_name);
                })
            ->first();

        if (!$user) {
            return back()->with('error', 'No se encontró un usuario con esos datos.');
        }

        // Restablecer la contraseña del usuario al DNI
        $user->password = Hash::make($request->document_id);
        $user->save();

        return back()->with('status', 'Contraseña restablecida exitosamente. Ahora puedes iniciar sesión con tu DNI.');
    }
}
