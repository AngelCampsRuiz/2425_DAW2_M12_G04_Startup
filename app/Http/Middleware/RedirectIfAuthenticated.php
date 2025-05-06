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
                $role = $user->role->id;

                if ($role == 3) {
                    return redirect()->route('student.dashboard');
                } elseif($role == 1) {
                    return redirect()->route('admin.dashboard');
                } elseif ($role == 2) {
                    return redirect()->route('empresa.dashboard');
                }
                
                return redirect('/');
            }
        }

        return $next($request);
    }
}
