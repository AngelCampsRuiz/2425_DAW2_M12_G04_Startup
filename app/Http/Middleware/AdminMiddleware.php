<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminMiddleware
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
        // Verificamos si hay un usuario autenticado
        if (!$request->user()) {
            return redirect('/');
        }

        // Verificamos si el usuario tiene un rol asignado
        if (!$request->user()->role) {
            return redirect('/')->with('error', 'No tienes un rol asignado');
        }

        // Obtenemos información del rol para depuración
        $rolId = $request->user()->role_id;
        $rolNombre = $request->user()->role->nombre_rol;
        
        // Registramos en el log para depuración
        Log::info("Usuario intentando acceder a ruta admin: ", [
            'user_id' => $request->user()->id,
            'role_id' => $rolId,
            'role_name' => $rolNombre
        ]);

        // Verificamos si el rol es de administrador (ID 1 según el LoginController)
        if ($rolId != 1) {
            return redirect('/')->with('error', 'No tienes permisos de administrador');
        }

        return $next($request);
    }
} 