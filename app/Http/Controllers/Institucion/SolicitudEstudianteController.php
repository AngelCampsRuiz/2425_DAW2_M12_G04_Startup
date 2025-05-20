<?php

namespace App\Http\Controllers\Institucion;

use App\Http\Controllers\Controller;
use App\Models\SolicitudEstudiante;
use App\Models\Estudiante;
use App\Models\Categoria;
use App\Models\Clase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class SolicitudEstudianteController extends Controller
{
    /**
     * Muestra un listado de solicitudes de estudiantes
     */
    public function index(Request $request)
    {
        $institucion = Auth::user()->institucion;
        
        // Verificar que se tiene una institución válida
        if (!$institucion || !$institucion->id) {
            Log::error('Usuario sin institución válida intentó acceder a SolicitudEstudianteController@index', [
                'user_id' => Auth::id()
            ]);
            return redirect()->route('institucion.dashboard')
                ->with('error', 'No se encontró una institución asociada a su cuenta.');
        }
        
        $institucionId = $institucion->id;
        
        // Crear una clave única para la caché basada en los parámetros de la solicitud
        $cacheKey = 'solicitudes_' . $institucionId . '_' . md5(json_encode($request->all()));
        
        // Intentar obtener el resultado de la caché primero (por 5 minutos)
        if (Cache::has($cacheKey) && !config('app.debug')) {
            $data = Cache::get($cacheKey);
            return view('institucion.solicitudes.index', $data);
        }
        
        // Si no está en caché, realizar la consulta
        $query = SolicitudEstudiante::where('institucion_id', $institucionId)
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
        
        // Aplicar límite de paginación y ejecutar consulta
        $solicitudes = $query->latest()->paginate(10);
        
        // Estadísticas para el resumen - Utilizando una única consulta para optimizar
        $stats = DB::table('solicitudes_estudiantes')
            ->select(
                DB::raw('COUNT(*) as total'),
                DB::raw('SUM(CASE WHEN estado = "pendiente" THEN 1 ELSE 0 END) as pendientes'),
                DB::raw('SUM(CASE WHEN estado = "aprobada" THEN 1 ELSE 0 END) as aprobadas'),
                DB::raw('SUM(CASE WHEN estado = "rechazada" THEN 1 ELSE 0 END) as rechazadas')
            )
            ->where('institucion_id', $institucionId)
            ->first();
            
        // Verificar que las estadísticas no son nulas y convertir a enteros
        $statsArray = [
            'total' => (int)($stats->total ?? 0),
            'pendientes' => (int)($stats->pendientes ?? 0),
            'aprobadas' => (int)($stats->aprobadas ?? 0),
            'rechazadas' => (int)($stats->rechazadas ?? 0),
        ];
        
        // Obtener estudiantes pendientes de activación con consulta optimizada
        $estudiantesPendientes = Estudiante::select('estudiantes.*')
            ->with(['user:id,nombre,email,imagen,activo', 'categoria:id,nombre_categoria'])
            ->join('user', 'estudiantes.id', '=', 'user.id')
            ->where('estudiantes.institucion_id', $institucionId)
            ->where('user.activo', false)
            ->get();

        // Crear solicitudes automáticamente para estudiantes pendientes que no tienen solicitud
        $solicitudesCreadas = false;
        foreach ($estudiantesPendientes as $estudiante) {
            // Verificar si ya existe una solicitud para este estudiante
            $solicitudExistente = SolicitudEstudiante::where('estudiante_id', $estudiante->id)
                ->where('institucion_id', $institucionId)
                ->first();
            
            // Si no existe solicitud, crear una nueva
            if (!$solicitudExistente) {
                SolicitudEstudiante::create([
                    'estudiante_id' => $estudiante->id,
                    'institucion_id' => $institucionId,
                    'estado' => 'pendiente',
                    'mensaje' => 'Solicitud generada automáticamente para estudiante pendiente de activación',
                ]);
                $solicitudesCreadas = true;
            }
        }

        // Recalcular estadísticas si se crearon nuevas solicitudes
        if ($solicitudesCreadas) {
            // Estadísticas para el resumen - Utilizando una única consulta para optimizar
            $stats = DB::table('solicitudes_estudiantes')
                ->select(
                    DB::raw('COUNT(*) as total'),
                    DB::raw('SUM(CASE WHEN estado = "pendiente" THEN 1 ELSE 0 END) as pendientes'),
                    DB::raw('SUM(CASE WHEN estado = "aprobada" THEN 1 ELSE 0 END) as aprobadas'),
                    DB::raw('SUM(CASE WHEN estado = "rechazada" THEN 1 ELSE 0 END) as rechazadas')
                )
                ->where('institucion_id', $institucionId)
                ->first();
                
            // Actualizar estadísticas
            $statsArray = [
                'total' => (int)($stats->total ?? 0),
                'pendientes' => (int)($stats->pendientes ?? 0),
                'aprobadas' => (int)($stats->aprobadas ?? 0),
                'rechazadas' => (int)($stats->rechazadas ?? 0),
            ];
            
            // También actualizar la consulta de solicitudes
            $solicitudes = SolicitudEstudiante::where('institucion_id', $institucionId)
                ->with(['estudiante.user', 'clase'])
                ->latest()
                ->paginate(10);
        }

        // Obtener solo las categorías necesarias para el formulario
        $categorias = Categoria::select('id', 'nombre_categoria')->get();
        
        // Preparar los datos para la vista
        $data = [
            'solicitudes' => $solicitudes,
            'stats' => $statsArray,
            'filtro' => $request->estado ?? 'todos',
            'busqueda' => $request->buscar ?? '',
            'estudiantesPendientes' => $estudiantesPendientes,
            'categorias' => $categorias
        ];
        
        // Guardar en caché por 5 minutos (excepto en modo debug)
        if (!config('app.debug')) {
            Cache::put($cacheKey, $data, 300);
        }
        
        return view('institucion.solicitudes.index', $data);
    }

    /**
     * Muestra los detalles de una solicitud específica
     */
    public function show($id)
    {
        $solicitud = SolicitudEstudiante::with(['estudiante.user', 'clase.departamento', 'clase.docente.user'])
            ->findOrFail($id);
        
        // Verificar que la solicitud pertenezca a la institución actual
        $institucion = Auth::user()->institucion;
        
        if ($solicitud->institucion_id !== $institucion->id) {
            return redirect()->route('institucion.solicitudes.index')
                ->with('error', 'No tienes permiso para ver esta solicitud');
        }
        
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
            
            // Limpiar la caché después de actualizar
            $this->clearSolicitudesCache();
            
            // Redirigir al usuario a la página de asignación de clase o de vista del estudiante
            return redirect()->route('institucion.estudiantes.show', $solicitud->estudiante->id)
                ->with('success', 'Solicitud aprobada correctamente. El estudiante ha sido activado y ahora puede acceder a la plataforma. Puedes asignarle a una clase desde esta página.');
                
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
        
        // Limpiar la caché después de actualizar
        $this->clearSolicitudesCache();
        
        return redirect()->route('institucion.solicitudes.index')
            ->with('success', 'Solicitud rechazada correctamente');
    }
    
    /**
     * Limpia la caché de solicitudes
     */
    private function clearSolicitudesCache()
    {
        $institucionId = Auth::user()->institucion->id ?? 0;
        $cacheKey = 'solicitudes_' . $institucionId . '_*';
        
        // Simplemente olvidar la clave específica para esta institución
        Cache::forget('solicitudes_' . $institucionId);
        
        // Y también la versión con filtros si existe
        Cache::forget('solicitudes_' . $institucionId . '_' . md5(json_encode(request()->all())));
    }
} 