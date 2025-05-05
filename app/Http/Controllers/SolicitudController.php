<?php

namespace App\Http\Controllers;

use App\Models\Solicitud;
use App\Models\Publication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\AlumnoSuscritoNotification;

class SolicitudController extends Controller
{
    public function store(Request $request, Publication $publication)
    {
        // Verificar si ya existe una solicitud
        $solicitudExistente = Solicitud::where('estudiante_id', Auth::id())
            ->where('publicacion_id', $publication->id)
            ->first();

        if ($solicitudExistente) {
            return response()->json([
                'status' => 'error',
                'message' => 'Ya has enviado una solicitud para esta oferta'
            ], 400);
        }

        // Crear nueva solicitud
        $solicitud = Solicitud::create([
            'estudiante_id' => Auth::id(),
            'publicacion_id' => $publication->id,
            'estado' => 'pendiente',
            'mensaje' => $request->mensaje
        ]);

        // Obtener el estudiante (remitente)
        $alumno = Auth::user();

        // Obtener la empresa de la publicación
        $empresa = $publication->empresa;

        // Obtener el usuario de la empresa
        $usuarioEmpresa = $empresa->user;

        // Notificar a la empresa
        if ($usuarioEmpresa) {
            $usuarioEmpresa->notify(new AlumnoSuscritoNotification($alumno));
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Solicitud enviada correctamente',
            'solicitud' => $solicitud
        ]);
    }
}