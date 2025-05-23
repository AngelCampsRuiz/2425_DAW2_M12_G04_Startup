<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role)
    {
        if (!Auth::check()) {
            return redirect('login');
        }

        $roles = [
            'admin' => 'Administrador',
            'empresa' => 'Empresa',
            'student' => 'Estudiante',
            'docente' => 'Docente',
            'institucion' => 'Institución'
        ];

        if (!isset($roles[$role]) || Auth::user()->role->nombre_rol !== $roles[$role]) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No tienes permiso para realizar esta acción'
                ], 403);
            }
            return redirect()->back()->with('error', 'No tienes permiso para realizar esta acción');
        }

        return $next($request);
    }
}
