<?php

namespace App\Http\Controllers\Institucion;

use App\Http\Controllers\Controller;
use App\Models\SolicitudEstudiante;
use App\Models\Estudiante;
use App\Models\Titulo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
        
        // Búsqueda por nombre de estudiante o email
        if ($request->has('buscar') && !empty($request->buscar)) {
            $search = $request->buscar;
            $query->whereHas('estudiante.user', function ($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }
        
        // Filtrar por período de fecha
        if ($request->has('fecha') && !empty($request->fecha)) {
            $now = Carbon::now();
            
            switch ($request->fecha) {
                case 'hoy':
                    $query->whereDate('created_at', $now->toDateString());
                    break;
                case 'semana':
                    $query->where('created_at', '>=', $now->startOfWeek()->toDateString());
                    break;
                case 'mes':
                    $query->where('created_at', '>=', $now->startOfMonth()->toDateString());
                    break;
                case 'trimestre':
                    $query->where('created_at', '>=', $now->subMonths(3)->toDateString());
                    break;
            }
        }
        
        // Filtrar por asignación de clase
        if ($request->has('con_clase') && $request->con_clase) {
            $query->whereNotNull('clase_id');
        }
        
        if ($request->has('sin_clase') && $request->sin_clase) {
            $query->whereNull('clase_id');
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
        
        // Obtener estudiantes pendientes de activación
        $estudiantesPendientes = Estudiante::with(['user', 'titulo'])
            ->where('institucion_id', $institucion->id)
            ->whereHas('user', function($query) {
                $query->where('activo', false);
            })
            ->get();

        // Obtener todos los títulos para el modal de edición
        $titulos = Titulo::all();
        
        return view('institucion.solicitudes.index', [
            'solicitudes' => $solicitudes,
            'stats' => $stats,
            'filtro' => $request->estado ?? 'todos',
            'busqueda' => $request->buscar ?? '',
            'estudiantesPendientes' => $estudiantesPendientes,
            'titulos' => $titulos
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
        
        try {
            DB::beginTransaction();
            
            // Actualizar estado de la solicitud
            $solicitud->update([
                'estado' => 'aprobada',
                'fecha_respuesta' => Carbon::now(),
                'respondido_por' => Auth::id()
            ]);
            
            // Activar al estudiante y su usuario asociado
            if ($solicitud->estudiante && $solicitud->estudiante->user) {
                // Actualizar estudiante
                $estudiante = $solicitud->estudiante;
                $estudiante->estado = 'activo';
                $estudiante->save();
                
                // Actualizar usuario
                $user = $solicitud->estudiante->user;
                $user->activo = true;
                $user->save();
            }
            
            DB::commit();
            
            // Enviar notificación al estudiante (implementar después)
            // event(new SolicitudAprobadaEvent($solicitud));
            
            return redirect()->route('institucion.solicitudes.show', $solicitud->id)
                ->with('success', 'Solicitud aprobada correctamente. Asigna al estudiante a una clase.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al aprobar solicitud: ' . $e->getMessage());
            return redirect()->route('institucion.solicitudes.index')
                ->with('error', 'Error al aprobar la solicitud: ' . $e->getMessage());
        }
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