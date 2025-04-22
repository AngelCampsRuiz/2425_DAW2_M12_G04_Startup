<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Convenio;
use App\Models\Valoracion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ValoracionController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'receptor_id' => 'required|exists:user,id',
            'convenio_id' => 'required|exists:convenios,id',
            'puntuacion' => 'required|integer|min:1|max:5',
            'comentario' => 'required|string|max:500',
        ]);

        // Verificar que el convenio existe y está relacionado con ambos usuarios
        $convenio = Convenio::findOrFail($request->convenio_id);
        $emisor = Auth::user();
        $receptor = User::findOrFail($request->receptor_id);

        // Determinar el tipo de valoración basado en los roles
        $tipo = ($emisor->role_id == 3 && $receptor->role_id == 2) ? 'alumno_a_empresa' : 'empresa_a_alumno';

        // Verificar que no exista una valoración previa para este convenio y usuario
        $valoracionExistente = Valoracion::where([
            'emisor_id' => $emisor->id,
            'receptor_id' => $receptor->id,
            'convenio_id' => $convenio->id
        ])->first();

        if ($valoracionExistente) {
            return response()->json([
                'success' => false,
                'message' => 'Ya has valorado a este usuario para este convenio.'
            ], 422);
        }

        // Crear la valoración
        $valoracion = Valoracion::create([
            'emisor_id' => $emisor->id,
            'receptor_id' => $receptor->id,
            'convenio_id' => $convenio->id,
            'puntuacion' => $request->puntuacion,
            'comentario' => $request->comentario,
            'tipo' => $tipo,
            'fecha_valoracion' => now()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Valoración enviada correctamente',
            'valoracion' => $valoracion->load('emisor', 'receptor')
        ]);
    }

    public function getConvenios($receptorId)
    {
        $emisor = Auth::user();
        $receptor = User::findOrFail($receptorId);

        // Si el emisor es estudiante y el receptor es empresa
        if ($emisor->role_id == 3 && $receptor->role_id == 2) {
            $convenios = Convenio::where('estudiante_id', $emisor->id)
                                ->where('empresa_id', $receptor->empresa->id)
                                ->whereDoesntHave('valoraciones', function($query) use ($emisor, $receptor) {
                                    $query->where('emisor_id', $emisor->id)
                                          ->where('receptor_id', $receptor->id);
                                })
                                ->get();
        }
        // Si el emisor es empresa y el receptor es estudiante
        elseif ($emisor->role_id == 2 && $receptor->role_id == 3) {
            $convenios = Convenio::where('empresa_id', $emisor->empresa->id)
                                ->where('estudiante_id', $receptor->id)
                                ->whereDoesntHave('valoraciones', function($query) use ($emisor, $receptor) {
                                    $query->where('emisor_id', $emisor->id)
                                          ->where('receptor_id', $receptor->id);
                                })
                                ->get();
        }
        else {
            return response()->json([
                'success' => false,
                'message' => 'No tienes permisos para valorar a este usuario'
            ], 403);
        }

        return response()->json([
            'success' => true,
            'convenios' => $convenios
        ]);
    }
}
