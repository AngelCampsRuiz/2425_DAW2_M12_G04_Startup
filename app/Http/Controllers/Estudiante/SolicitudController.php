<?php

namespace App\Http\Controllers\Estudiante;

use App\Http\Controllers\Controller;
use App\Models\SolicitudEstudiante;
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
        $solicitud = SolicitudEstudiante::where('id', $id)
            ->where('estudiante_id', $estudiante->id)
            ->with(['institucion.user', 'clase'])
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
        $solicitud = SolicitudEstudiante::where('id', $id)
            ->where('estudiante_id', $estudiante->id)
            ->firstOrFail();
        
        // Solo se pueden cancelar solicitudes pendientes
        if ($solicitud->estado !== 'pendiente') {
            return redirect()->route('estudiante.solicitudes.index')
                ->with('error', 'Solo puedes cancelar solicitudes pendientes');
        }
        
        // Actualizar estado a cancelada
        $solicitud->estado = 'cancelada';
        $solicitud->respuesta = 'Cancelada por el estudiante';
        $solicitud->fecha_respuesta = now();
        $solicitud->save();
        
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
            'institucion_id' => 'required|exists:instituciones,id',
            'mensaje' => 'required|string|max:500',
        ]);

        // Verificar si ya existe una solicitud pendiente para esta institución
        $solicitudExistente = SolicitudEstudiante::where('estudiante_id', $estudiante->id)
            ->where('institucion_id', $request->institucion_id)
            ->where('estado', 'pendiente')
            ->first();

        if ($solicitudExistente) {
            return redirect()->back()->with('error', 'Ya tienes una solicitud pendiente para esta institución.');
        }

        // Crear la solicitud
        SolicitudEstudiante::create([
            'estudiante_id' => $estudiante->id,
            'institucion_id' => $request->institucion_id,
            'mensaje' => $request->mensaje,
            'estado' => 'pendiente',
        ]);

        return redirect()->route('estudiante.solicitudes.index')
            ->with('success', 'Solicitud enviada correctamente a la institución.');
    }
} 