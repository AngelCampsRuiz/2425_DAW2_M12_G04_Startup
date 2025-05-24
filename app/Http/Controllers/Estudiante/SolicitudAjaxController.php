<?php

namespace App\Http\Controllers\Estudiante;

use App\Http\Controllers\Controller;
use App\Models\Solicitud;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SolicitudAjaxController extends Controller
{
    /**
     * Método para obtener todas las solicitudes del estudiante actual
     */
    public function getSolicitudes(Request $request)
    {
        try {
            $estudiante = Auth::user()->estudiante;

            if (!$estudiante) {
                return response()->json([
                    'success' => false,
                    'error' => 'No se encontró el estudiante'
                ], 404);
            }

            $estado = $request->query('estado', 'todos');

            $query = Solicitud::where('estudiante_id', $estudiante->id)
                ->with(['publicacion.empresa.user']);

            if ($estado !== 'todos') {
                // Si el filtro es "rechazada", incluye también "cancelada"
                if ($estado === 'rechazada') {
                    $query->whereIn('estado', ['rechazada', 'cancelada']);
                } else {
                    $query->where('estado', $estado);
                }
            }

            $solicitudes = $query->get();

            // Estadísticas (siempre sobre todas las solicitudes)
            $todas = Solicitud::where('estudiante_id', $estudiante->id)->get();
            $stats = [
                'total' => $todas->count(),
                'pendientes' => $todas->where('estado', 'pendiente')->count(),
                'aceptadas' => $todas->where('estado', 'aceptada')->count(),
                'rechazadas' => $todas->whereIn('estado', ['rechazada', 'cancelada'])->count(),
            ];

            return response()->json([
                'stats' => $stats,
                'solicitudes' => $solicitudes
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Error al obtener las solicitudes: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Método para obtener una solicitud específica
     */
    public function getSolicitud($id)
    {
        try {
        $estudiante = Auth::user()->estudiante;

            if (!$estudiante) {
                return response()->json([
                    'success' => false,
                    'error' => 'No se encontró el estudiante'
                ], 404);
            }

            $solicitud = Solicitud::where('id', $id)
            ->where('estudiante_id', $estudiante->id)
                                      ->with(['institucion.user', 'clase'])
            ->first();

        if (!$solicitud) {
            return response()->json([
                'success' => false,
                    'error' => 'No se encontró la solicitud'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'solicitud' => $solicitud
        ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Error al obtener la solicitud: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Método para cancelar una solicitud (versión AJAX)
     */
    public function cancelarSolicitud($id)
    {
        try {
        $estudiante = Auth::user()->estudiante;

            if (!$estudiante) {
                return response()->json([
                    'success' => false,
                    'error' => 'No se encontró el estudiante'
                ], 404);
            }

            $solicitud = Solicitud::where('id', $id)
            ->where('estudiante_id', $estudiante->id)
            ->first();

        if (!$solicitud) {
            return response()->json([
                'success' => false,
                    'error' => 'No se encontró la solicitud'
            ], 404);
        }

        // Solo se pueden cancelar solicitudes pendientes
        if ($solicitud->estado !== 'pendiente') {
            return response()->json([
                'success' => false,
                    'error' => 'Solo se pueden cancelar solicitudes pendientes'
            ], 400);
        }

            // Cambiar estado de la solicitud
            $solicitud->estado = 'rechazada';
            $solicitud->save();

        return response()->json([
            'success' => true,
            'message' => 'Solicitud cancelada correctamente'
        ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Error al cancelar la solicitud: ' . $e->getMessage()
            ], 500);
        }
    }
}