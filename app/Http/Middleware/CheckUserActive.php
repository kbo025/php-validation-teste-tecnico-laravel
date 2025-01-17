<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckUserActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Verifica si el usuario está autenticado
        if (Auth::check()) {
            // Obtén el usuario autenticado
            $user = Auth::user();
            
            // Verifica si el usuario está activo
            if (!$user->active) {
                // Deslogea al usuario
                Auth::guard('web')->logout();
                
                // Redirige al usuario a la página de inicio de sesión con un mensaje
                return redirect('/login')->withErrors(['message' => 'Inactive account.']);
            }
        }

        return $next($request);
    }
}
