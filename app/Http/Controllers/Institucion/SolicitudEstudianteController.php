<?php

namespace App\Http\Controllers\Institucion;

use App\Http\Controllers\Controller;
use App\Models\SolicitudEstudiante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class SolicitudEstudianteController extends Controller
{
    /**
     * Muestra un listado de solicitudes de estudiantes
     */
    public function index(Request $request)
    {
        $institucion = Auth::user()->institucion;
        
        $query = SolicitudEstudiante::where('institucion_id', $institucion->id)
            ->with(['estudiante.user', 'clase']);
        
        // Filtrar por estado si se proporciona
        if ($request->has('estado') && $request->estado !== 'todos') {
            $query->where('estado', $request->estado);
        }
        
        // Búsqueda por nombre de estudiante
        if ($request->has('buscar') && !empty($request->buscar)) {
            $search = $request->buscar;
            $query->whereHas('estudiante.user', function ($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }
        
        $solicitudes = $query->latest()->paginate(10);
        
        // Estadísticas para el resumen
        $stats = [
            'total' => SolicitudEstudiante::where('institucion_id', $institucion->id)->count(),
            'pendientes' => SolicitudEstudiante::where('institucion_id', $institucion->id)
                            ->where('estado', 'pendiente')->count(),
            'aprobadas' => SolicitudEstudiante::where('institucion_id', $institucion->id)
                            ->where('estado', 'aprobada')->count(),
            'rechazadas' => SolicitudEstudiante::where('institucion_id', $institucion->id)
                            ->where('estado', 'rechazada')->count(),
        ];
        
        return view('institucion.solicitudes.index', [
            'solicitudes' => $solicitudes,
            'stats' => $stats,
            'filtro' => $request->estado ?? 'todos',
            'busqueda' => $request->buscar ?? ''
        ]);
    }

    /**
     * Muestra los detalles de una solicitud específica
     */
    public function show($id)
    {
        $solicitud = SolicitudEstudiante::findOrFail($id);
        
        // Verificar que la solicitud pertenezca a la institución actual
        $institucion = Auth::user()->institucion;
        
        if ($solicitud->institucion_id !== $institucion->id) {
            return redirect()->route('institucion.solicitudes.index')
                ->with('error', 'No tienes permiso para ver esta solicitud');
        }
        
        // Cargar relaciones necesarias
        $solicitud->load(['estudiante.user', 'clase.departamento', 'clase.docente.user']);
        
        return view('institucion.solicitudes.show', [
            'solicitud' => $solicitud
        ]);
    }

    /**
     * Aprueba una solicitud de estudiante
     */
    public function aprobar($id)
    {
        $solicitud = SolicitudEstudiante::findOrFail($id);
        
        // Verificar que la solicitud pertenezca a la institución actual
        $institucion = Auth::user()->institucion;
        
        if ($solicitud->institucion_id !== $institucion->id) {
            return redirect()->route('institucion.solicitudes.index')
                ->with('error', 'No tienes permiso para modificar esta solicitud');
        }
        
        // Solo se pueden aprobar solicitudes pendientes
        if ($solicitud->estado !== 'pendiente') {
            return redirect()->route('institucion.solicitudes.show', $solicitud->id)
                ->with('error', 'Esta solicitud ya ha sido procesada anteriormente');
        }
        
        $solicitud->update([
            'estado' => 'aprobada',
            'fecha_respuesta' => Carbon::now(),
            'respondido_por' => Auth::id()
        ]);
        
        // Enviar notificación al estudiante (implementar después)
        // event(new SolicitudAprobadaEvent($solicitud));
        
        return redirect()->route('institucion.solicitudes.show', $solicitud->id)
            ->with('success', 'Solicitud aprobada correctamente. Asigna al estudiante a una clase.');
    }

    /**
     * Rechaza una solicitud de estudiante
     */
    public function rechazar(Request $request, $id)
    {
        $solicitud = SolicitudEstudiante::findOrFail($id);
        
        // Verificar que la solicitud pertenezca a la institución actual
        $institucion = Auth::user()->institucion;
        
        if ($solicitud->institucion_id !== $institucion->id) {
            return redirect()->route('institucion.solicitudes.index')
                ->with('error', 'No tienes permiso para modificar esta solicitud');
        }
        
        // Solo se pueden rechazar solicitudes pendientes
        if ($solicitud->estado !== 'pendiente') {
            return redirect()->route('institucion.solicitudes.show', $solicitud->id)
                ->with('error', 'Esta solicitud ya ha sido procesada anteriormente');
        }
        
        $solicitud->update([
            'estado' => 'rechazada',
            'fecha_respuesta' => Carbon::now(),
            'respondido_por' => Auth::id(),
            'respuesta' => $request->mensaje_rechazo
        ]);
        
        // Enviar notificación al estudiante (implementar después)
        // event(new SolicitudRechazadaEvent($solicitud));
        
        return redirect()->route('institucion.solicitudes.index')
            ->with('success', 'Solicitud rechazada correctamente');
    }
} 