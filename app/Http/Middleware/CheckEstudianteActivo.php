<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckEstudianteActivo
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->role_id === 3) {
            $estudiante = Auth::user()->estudiante;

            if ($estudiante && $estudiante->estado !== 'activo') {
                Auth::logout();
                return redirect()->route('login')->with('error', 'Tu cuenta está pendiente de activación. Por favor, contacta con tu institución.');
            }
        }

        return $next($request);
    }
}