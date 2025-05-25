<?php

namespace App\Http\Controllers;

use App\Models\Experiencia;
use Illuminate\Http\Request;

class ExperienciaController extends Controller
{
    /**
     * Store a newly created experience in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'puesto' => 'required|string|max:255',
            'empresa_nombre' => 'required|string|max:255',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'nullable|date|after:fecha_inicio',
            'descripcion' => 'required|string',
        ]);

        $experiencia = new Experiencia();
        $experiencia->user_id = auth()->id();
        $experiencia->puesto = $request->puesto;
        $experiencia->empresa_nombre = $request->empresa_nombre;
        $experiencia->fecha_inicio = $request->fecha_inicio;
        $experiencia->fecha_fin = $request->fecha_fin;
        $experiencia->descripcion = $request->descripcion;
        $experiencia->save();

        return response()->json([
            'success' => true,
            'message' => 'Experiencia creada con éxito',
            'experiencia' => $experiencia
        ]);
    }
}
