<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Convenio;
use App\Models\Valoracion;
use App\Models\Seguimiento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ValoracionController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'puntuacion' => 'required|integer|min:1|max:5',
            'comentario' => 'required|string',
            'seguimiento_id' => 'required|exists:seguimiento,id',
            'receptor_id' => 'required|exists:user,id',
            'tipo' => 'required|in:empresa_a_alumno,alumno_a_empresa',
        ]);

        // Obtener el convenio asociado al seguimiento
        $seguimiento = Seguimiento::findOrFail($request->seguimiento_id);
        $emisor = auth()->user();
        $receptorId = $request->receptor_id;
        $receptor = User::where('id', $receptorId)->firstOrFail();
        $convenio = $seguimiento->convenio;

        if (!$convenio) {
            return response()->json([
                'success' => false,
                'message' => 'No existe un convenio asociado a este seguimiento'
            ], 400);
        }

        $valoracion = Valoracion::create([
            'puntuacion' => $request->puntuacion,
            'comentario' => $request->comentario,
            'fecha_valoracion' => now(),
            'tipo' => $request->tipo,
            'emisor_id' => Auth::id(),
            'receptor_id' => $request->receptor_id,
            'convenio_id' => $convenio->id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Valoración enviada correctamente',
            'valoracion' => $valoracion
        ]);
    }

    public function getConvenios($receptorId)
    {
        $emisor = Auth::user();
        $receptor = User::where('id', $receptorId)->firstOrFail();

        // Si el emisor es estudiante y el receptor es empresa
        if ($emisor->role_id == 3 && $receptor->role_id == 2) {
            $seguimientos = Seguimiento::where('alumno_id', $emisor->estudiante->id)
                                ->where('empresa_id', $receptor->empresa->id)
                                ->where('estado', 'aceptado')
                                ->whereHas('convenio')
                                ->whereDoesntHave('convenio.valoraciones', function($query) use ($emisor, $receptor) {
                                    $query->where('emisor_id', $emisor->id)
                                          ->where('receptor_id', $receptor->id);
                                })
                                ->with('convenio')
                                ->get();
        }
        // Si el emisor es empresa y el receptor es estudiante
        elseif ($emisor->role_id == 2 && $receptor->role_id == 3) {
            $seguimientos = Seguimiento::where('empresa_id', $emisor->empresa->id)
                                ->where('alumno_id', $receptor->estudiante->id)
                                ->where('estado', 'aceptado')
                                ->whereHas('convenio')
                                ->whereDoesntHave('convenio.valoraciones', function($query) use ($emisor, $receptor) {
                                    $query->where('emisor_id', $emisor->id)
                                          ->where('receptor_id', $receptor->id);
                                })
                                ->with('convenio')
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
            'seguimientos' => $seguimientos
        ]);
    }

    public function update(Request $request, $id)
    {
        $valoracion = Valoracion::findOrFail($id);

        // Verificar que el usuario autenticado sea el emisor de la valoración
        if ($valoracion->emisor_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'No tienes permiso para editar esta valoración'
            ], 403);
        }

        $request->validate([
            'puntuacion' => 'required|integer|min:1|max:5',
            'comentario' => 'required|string'
        ]);

        $valoracion->update([
            'puntuacion' => $request->puntuacion,
            'comentario' => $request->comentario,
            'fecha_valoracion' => now()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Valoración actualizada correctamente',
            'valoracion' => $valoracion
        ]);
    }

    public function destroy($id)
    {
        $valoracion = Valoracion::findOrFail($id);

        // Verificar que el usuario autenticado sea el emisor de la valoración
        if ($valoracion->emisor_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'No tienes permiso para eliminar esta valoración'
            ], 403);
        }

        $valoracion->delete();

        return response()->json([
            'success' => true,
            'message' => 'Valoración eliminada correctamente'
        ]);
    }
}
