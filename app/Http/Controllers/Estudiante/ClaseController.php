<?php

namespace App\Http\Controllers\Estudiante;

use App\Http\Controllers\Controller;
use App\Models\Clase;
use Illuminate\Http\Request;

class ClaseController extends Controller
{
    public function index()
    {
        $estudiante = auth()->user()->estudiante;

        if ($estudiante->estado !== 'activo') {
            return redirect()->route('estudiante.dashboard')
                ->with('error', 'Tu cuenta debe estar activa para ver las clases disponibles.');
        }

        $clases = Clase::with(['profesor.user', 'solicitudes' => function($query) use ($estudiante) {
            $query->where('estudiante_id', $estudiante->id);
        }])->get();

        return view('estudiante.clases.index', compact('clases'));
    }
} 