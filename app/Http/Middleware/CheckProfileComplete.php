<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckProfileComplete
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
        public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            
            // Verificar si el usuario tiene perfil completo
            if (
                !$user->profile ||
                !$user->profile->first_name ||
                !$user->profile->last_name ||
                !$user->profile->email
            ) {
                // Si está en el wizard, permitir continuar
                if ($request->routeIs('profile.wizard.*')) {
                    return $next($request);
                }
                
                // Si no está en el wizard, redirigir al paso 1
                return redirect()->route('profile.wizard.step1');
            }
        }

        return $next($request);
    }
}
