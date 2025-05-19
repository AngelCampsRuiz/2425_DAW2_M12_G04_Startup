<?php

namespace App\Http\Controllers\Estudiante;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $estudiante = auth()->user()->estudiante;
        $mensaje = null;

        if ($estudiante->estado === 'pendiente') {
            $mensaje = 'Tu cuenta está pendiente de activación. Por favor, contacta con tu institución para activar tu cuenta.';
        }

        return view('estudiante.dashboard', compact('mensaje'));
    }
} 