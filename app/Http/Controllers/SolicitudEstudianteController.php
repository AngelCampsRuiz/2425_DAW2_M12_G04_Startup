<?php

namespace App\Http\Controllers;

use App\Models\Clase;
use App\Models\SolicitudEstudiante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SolicitudEstudianteController extends Controller
{
    // Listar solicitudes
    public function index(Request $request)
    {
        $institucion = Auth::user()->institucion;

        // Aplicar filtros si existen
        $query = $institucion->solicitudesEstudiantes()->with(['estudiante.user', 'clase']);

        // Filtrar por estado si se proporciona
        $filtro = $request->estado ?? 'todos';
        if ($filtro !== 'todos') {
            $query->where('estado', $filtro);
        }

        // Búsqueda por nombre o email
        $busqueda = $request->buscar ?? '';
        if (!empty($busqueda)) {
            $query->whereHas('estudiante.user', function($q) use ($busqueda) {
                $q->where('nombre', 'like', '%' . $busqueda . '%')
                  ->orWhere('email', 'like', '%' . $busqueda . '%');
            });
        }

        $solicitudes = $query->orderBy('estado')
            ->orderBy('created_at', 'desc')
            ->get();

        // Estadísticas para el resumen
        $stats = [
            'total' => $institucion->solicitudesEstudiantes()->count(),
            'pendientes' => $institucion->solicitudesEstudiantes()->where('estado', 'pendiente')->count(),
            'aprobadas' => $institucion->solicitudesEstudiantes()->where('estado', 'aprobada')->count(),
            'rechazadas' => $institucion->solicitudesEstudiantes()->where('estado', 'rechazada')->count(),
        ];

        return view('institucion.solicitudes.index', compact('solicitudes', 'stats', 'filtro', 'busqueda'));
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