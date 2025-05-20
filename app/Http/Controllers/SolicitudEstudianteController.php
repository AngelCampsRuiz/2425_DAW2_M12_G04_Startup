<?php

namespace App\Http\Controllers;

use App\Models\Clase;
use App\Models\SolicitudEstudiante;
use App\Models\SolicitudInstitucion;
use App\Models\Estudiante;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SolicitudEstudianteController extends Controller
{
    // Listar solicitudes
    public function index(Request $request)
    {
        $institucion = Auth::user()->institucion;
        $busqueda = $request->input('buscar', '');
        $filtro = $request->input('estado', 'todos');
        
        // Obtener solicitudes de estudiantes
        $query = SolicitudInstitucion::with(['estudiante.user'])
            ->where('institucion_id', $institucion->id);
        
        // Aplicar filtro por estado
        if ($filtro !== 'todos') {
            $query->where('estado', $filtro);
        }
        
        // Aplicar filtro por búsqueda
        if (!empty($busqueda)) {
            $query->whereHas('estudiante.user', function($q) use ($busqueda) {
                $q->where('nombre', 'like', "%{$busqueda}%")
                  ->orWhere('email', 'like', "%{$busqueda}%");
            });
        }
        
        $solicitudes = $query->orderBy('estado', 'asc')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        // Obtener estudiantes pendientes de activación
        $estudiantesPendientes = Estudiante::with(['user', 'categoria'])
            ->where('institucion_id', $institucion->id)
            ->whereHas('user', function($query) {
                $query->where('activo', false);
            })
            ->get();
        
        // Obtener todas las categorías para el modal de edición
        $categorias = Categoria::all();
        
        // Calcular estadísticas para el dashboard
        $stats = [
            'total' => $solicitudes->total(),
            'pendientes' => SolicitudInstitucion::where('institucion_id', $institucion->id)
                            ->where('estado', 'pendiente')->count(),
            'aprobadas' => SolicitudInstitucion::where('institucion_id', $institucion->id)
                            ->where('estado', 'aprobada')->count(),
            'rechazadas' => SolicitudInstitucion::where('institucion_id', $institucion->id)
                            ->where('estado', 'rechazada')->count(),
        ];
        
        return view('institucion.solicitudes.index', compact('solicitudes', 'estudiantesPendientes', 'categorias', 'stats', 'filtro', 'busqueda'));
    }

    // Ver solicitud
    public function show($id)
    {
        $institucion = Auth::user()->institucion;
        $solicitud = $institucion->solicitudesEstudiantes()
            ->with(['estudiante.user', 'clase'])
            ->findOrFail($id);

        $clases = $institucion->clases()->where('activa', true)->get();

        return view('institucion.solicitudes.show', compact('solicitud', 'clases'));
    }

    // Aprobar solicitud
    public function aprobar(Request $request, $id)
    {
        $institucion = Auth::user()->institucion;
        $solicitud = $institucion->solicitudesEstudiantes()->findOrFail($id);

        $request->validate([
            'respuesta' => 'nullable|string',
            'clase_id' => 'nullable|exists:clases,id',
        ]);

        // Verificar que la solicitud esté pendiente
        if ($solicitud->estado !== 'pendiente') {
            return redirect()->route('institucion.solicitudes.index')
                ->with('error', 'Esta solicitud ya ha sido procesada');
        }

        // Aprobar la solicitud
        $solicitud->aprobar($request->respuesta, $request->clase_id);


        return redirect()->route('institucion.solicitudes.index')
            ->with('success', 'Solicitud aprobada correctamente');
    }

    // Rechazar solicitud
    public function rechazar(Request $request, $id)
    {
        $institucion = Auth::user()->institucion;
        $solicitud = $institucion->solicitudesEstudiantes()->findOrFail($id);

        $request->validate([
            'respuesta' => 'nullable|string',
        ]);

        // Verificar que la solicitud esté pendiente
        if ($solicitud->estado !== 'pendiente') {
            return redirect()->route('institucion.solicitudes.index')
                ->with('error', 'Esta solicitud ya ha sido procesada');
        }

        // Rechazar la solicitud
        $solicitud->rechazar($request->respuesta);


        return redirect()->route('institucion.solicitudes.index')
            ->with('success', 'Solicitud rechazada correctamente');
    }

    // Estudiante: Crear solicitud para unirse a una institución
    public function crearSolicitud($institucion_id)
    {
        // Este método se implementará en el controlador de estudiantes
        return view('estudiante.solicitudes.create', compact('institucion_id'));
    }

    // Estudiante: Guardar solicitud
    public function guardarSolicitud(Request $request, $institucion_id)
    {
        // Este método se implementará en el controlador de estudiantes
        return redirect()->route('estudiante.solicitudes.index')
            ->with('success', 'Solicitud enviada correctamente');
    }
}