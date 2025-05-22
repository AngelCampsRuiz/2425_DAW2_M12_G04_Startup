<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RestrictChatForInstitucion
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Si el usuario autenticado tiene role_id = 5 (Institución), redirigir al dashboard
        if (auth()->check() && auth()->user()->role_id == 5) {
            return redirect()->route('institucion.dashboard')
                ->with('error', 'Las instituciones no tienen acceso al módulo de chat.');
        }

        return $next($request);
    }
} 