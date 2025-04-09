<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyRegistrationSteps
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, int $requiredStep): Response
    {
        $registrationData = $request->session()->get('registration_data');
        
        // Verificar que existan datos de registro y que el paso actual sea al menos el requerido
        if (!$registrationData || !isset($registrationData['step']) || $registrationData['step'] < $requiredStep) {
            return redirect()->route('register')
                ->withErrors(['error' => 'Por favor complete todos los pasos del registro en orden']);
        }
        
        return $next($request);
    }
}
