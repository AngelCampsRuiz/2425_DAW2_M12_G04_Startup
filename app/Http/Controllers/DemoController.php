<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Publication;
use App\Models\Empresa;

class DemoController extends Controller
{
    /**
     * Muestra una vista de demostración del dashboard de estudiante
     */
    public function demoStudent()
    {
        // Obtener algunas publicaciones para mostrar en la demo
        $publicaciones = Publication::where('activa', true)
            ->with('empresa')
            ->take(6)
            ->get();
            
        // Pasar un flag para indicar que es una vista de demostración
        return view('demo.student', compact('publicaciones'));
    }

    /**
     * Muestra una vista de demostración del dashboard de empresa
     */
    public function demoCompany()
    {
        // Obtener algunas empresas para mostrar en la demo
        $empresa = Empresa::with('user')->first();
        
        // Obtener algunas estadísticas ficticias para la demo
        $stats = [
            'totalConvenios' => rand(5, 20),
            'alumnosContratados' => rand(3, 15),
            'ofertasActivas' => rand(2, 8),
            'candidatosRecibidos' => rand(10, 50)
        ];
        
        // Pasar un flag para indicar que es una vista de demostración
        return view('demo.company', compact('empresa', 'stats'));
    }

    /**
     * Redirecciona al formulario de registro cuando se intenta realizar una acción
     * que requiere autenticación
     */
    public function redirectToRegister(Request $request)
    {
        $type = $request->type ?? 'alumno';
        
        if ($type == 'empresa') {
            return redirect()->route('register.empresa')->with('demo_message', 'Para realizar esta acción, necesitas registrarte como empresa.');
        } else {
            return redirect()->route('register.alumno')->with('demo_message', 'Para realizar esta acción, necesitas registrarte como estudiante.');
        }
    }
}
