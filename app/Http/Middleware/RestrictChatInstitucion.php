<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RestrictChatInstitucion
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role_id == 5) {
            return redirect()->route('institucion.dashboard')
                ->with('error', 'Las instituciones no tienen acceso al sistema de chat.');
        }

        return $next($request);
    }
} 