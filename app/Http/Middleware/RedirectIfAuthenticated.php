<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::user();
                $roleName = $user->role ? $user->role->nombre_rol : null;

                switch($roleName) {
                    case 'Estudiante':
                        return redirect()->route('student.dashboard');
                    case 'Administrador':
                        return redirect()->route('admin.dashboard');
                    case 'Empresa':
                        return redirect()->route('empresa.dashboard');
                    case 'Institución':
                        return redirect()->route('institucion.dashboard');
                    case 'Docente':
                        return redirect()->route('docente.dashboard');
                    default:
                        return redirect('/');
                }
            }
        }

        return $next($request);
    }
}
