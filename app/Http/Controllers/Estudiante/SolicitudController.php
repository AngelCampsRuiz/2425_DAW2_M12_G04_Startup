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

    public function store(Request $request)
    {
        $estudiante = auth()->user()->estudiante;

        if ($estudiante->estado !== 'activo') {
            return redirect()->back()->with('error', 'Tu cuenta debe estar activa para realizar solicitudes.');
        }

        $request->validate([
            'clase_id' => 'required|exists:clases,id',
            'motivo' => 'required|string|max:500',
        ]);

        // Verificar si ya existe una solicitud pendiente para esta clase
        $solicitudExistente = Solicitud::where('estudiante_id', $estudiante->id)
            ->where('clase_id', $request->clase_id)
            ->where('estado', 'pendiente')
            ->first();

        if ($solicitudExistente) {
            return redirect()->back()->with('error', 'Ya tienes una solicitud pendiente para esta clase.');
        }

        // Crear la solicitud
        Solicitud::create([
            'estudiante_id' => $estudiante->id,
            'clase_id' => $request->clase_id,
            'motivo' => $request->motivo,
            'estado' => 'pendiente',
        ]);

        return redirect()->route('estudiante.solicitudes.index')
            ->with('success', 'Solicitud enviada correctamente.');
    }
} 