<?php

namespace App\Http\Controllers\Estudiante;

use App\Http\Controllers\Controller;
use App\Models\Solicitud;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SolicitudAjaxController extends Controller
{
    /**
     * Obtiene las solicitudes del estudiante autenticado (para AJAX)
     */
    public function getSolicitudes(Request $request)
    {
        $estudiante = Auth::user()->estudiante;
        
        // Construir la consulta base
        $query = Solicitud::where('estudiante_id', $estudiante->id)
            ->with(['publicacion.empresa.user']);
        
        // Filtrar por estado si se proporciona
        if ($request->has('estado') && $request->estado !== 'todos') {
            $query->where('estado', $request->estado);
        }
        
        // Ordenar por fecha (más recientes primero)
        $solicitudes = $query->orderBy('created_at', 'desc')->get();
        
        // Estadísticas
        $stats = [
            'total' => Solicitud::where('estudiante_id', $estudiante->id)->count(),
            'pendientes' => Solicitud::where('estudiante_id', $estudiante->id)
                ->where('estado', 'pendiente')->count(),
            'aprobadas' => Solicitud::where('estudiante_id', $estudiante->id)
                ->where('estado', 'aceptada')->count(),
            'rechazadas' => Solicitud::where('estudiante_id', $estudiante->id)
                ->where('estado', 'rechazada')->count(),
        ];
        
        // Devolver los datos en formato JSON
        return response()->json([
            'success' => true,
            'solicitudes' => $solicitudes,
            'stats' => $stats
        ]);
    }
    
    /**
     * Obtiene una solicitud específica (para AJAX)
     */
    public function getSolicitud($id)
    {
        $estudiante = Auth::user()->estudiante;
        
        // Buscar la solicitud y verificar que pertenezca al estudiante
        $solicitud = Solicitud::where('id', $id)
            ->where('estudiante_id', $estudiante->id)
            ->with(['publicacion.empresa.user'])
            ->first();
        
        if (!$solicitud) {
            return response()->json([
                'success' => false,
                'message' => 'Solicitud no encontrada'
            ], 404);
        }
        
        return response()->json([
            'success' => true,
            'solicitud' => $solicitud
        ]);
    }
    
    /**
     * Cancela una solicitud pendiente (para AJAX)
     */
    public function cancelarSolicitud($id)
    {
        $estudiante = Auth::user()->estudiante;
        
        // Buscar la solicitud y verificar que pertenezca al estudiante
        $solicitud = Solicitud::where('id', $id)
            ->where('estudiante_id', $estudiante->id)
            ->first();
        
        if (!$solicitud) {
            return response()->json([
                'success' => false,
                'message' => 'Solicitud no encontrada'
            ], 404);
        }
        
        // Solo se pueden cancelar solicitudes pendientes
        if ($solicitud->estado !== 'pendiente') {
            return response()->json([
                'success' => false,
                'message' => 'Solo puedes cancelar solicitudes pendientes'
            ], 400);
        }
        
        // Actualizar estado a rechazada (equivalente a cancelar)
        $solicitud->update([
            'estado' => 'rechazada',
            'respuesta_empresa' => 'Cancelada por el estudiante'
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Solicitud cancelada correctamente'
        ]);
    }
} 