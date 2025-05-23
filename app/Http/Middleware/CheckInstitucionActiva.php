<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckInstitucionActiva
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role_id == 2) {
            if (!Auth::user()->activo) {
                Auth::logout();
                return redirect()->route('login')->with('error', 'Debes completar el pago para acceder.');
            }
        }

        $response = $next($request);
        $response->headers->set('Cache-Control','no-store, no-cache, must-revalidate, max-age=0');
        $response->headers->set('Pragma','no-cache');
        $response->headers->set('Expires','Sat, 01 Jan 2000 00:00:00 GMT');
        return $response;
    }
}
