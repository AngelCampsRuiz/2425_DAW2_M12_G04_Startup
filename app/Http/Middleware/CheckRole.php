<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!$request->user() || !$request->user()->role) {
            return redirect('/');
        }

        // Si el rol es numérico, comparamos por ID, de lo contrario por nombre
        if (is_numeric($role)) {
            if ($request->user()->role_id != $role) {
                return redirect('/');
            }
        } else {
            // Convert role names to match what's in the database
            $roleMap = [
                'student' => 'Estudiante',
                'admin' => 'Administrador',
                'empresa' => 'Empresa',
                'tutor' => 'Tutor',
                'institucion' => 'Institución',
                'docente' => 'Docente'
            ];

            $requiredRole = $roleMap[$role] ?? $role;

            if ($request->user()->role->nombre_rol !== $requiredRole) {
                return redirect('/');
            }
        }

        return $next($request);
    }
}
