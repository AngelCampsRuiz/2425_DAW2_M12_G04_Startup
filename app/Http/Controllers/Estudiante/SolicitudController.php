<?php

namespace App\Http\Controllers\Estudiante;

use App\Http\Controllers\Controller;
use App\Models\Solicitud;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SolicitudController extends Controller
{
    /**
     * Muestra el listado de solicitudes del estudiante
     */
    public function index()
    {
        // Solo cargar la vista, los datos se cargarán vía AJAX
        return view('estudiante.solicitudes.index');
    }
    
    /**
     * Muestra los detalles de una solicitud específica
     */
    public function show($id)
    {
        $estudiante = Auth::user()->estudiante;
        
        // Buscar la solicitud y verificar que pertenezca al estudiante
        $solicitud = Solicitud::where('id', $id)
            ->where('estudiante_id', $estudiante->id)
            ->with(['publicacion.empresa.user'])
            ->firstOrFail();
        
        return view('estudiante.solicitudes.show', compact('solicitud'));
    }
    
    /**
     * Cancela una solicitud pendiente
     */
    public function cancelar($id)
    {
        $estudiante = Auth::user()->estudiante;
        
        // Buscar la solicitud y verificar que pertenezca al estudiante
        $solicitud = Solicitud::where('id', $id)
            ->where('estudiante_id', $estudiante->id)
            ->firstOrFail();
        
        // Solo se pueden cancelar solicitudes pendientes
        if ($solicitud->estado !== 'pendiente') {
            return redirect()->route('estudiante.solicitudes.index')
                ->with('error', 'Solo puedes cancelar solicitudes pendientes');
        }
        
        // Actualizar estado a cancelada (usando 'rechazada')
        $solicitud->update([
            'estado' => 'rechazada',
            'respuesta_empresa' => 'Cancelada por el estudiante'
        ]);
        
        return redirect()->route('estudiante.solicitudes.index')
            ->with('success', 'Solicitud cancelada correctamente');
    }
} 