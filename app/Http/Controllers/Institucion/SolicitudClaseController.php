<?php

namespace App\Http\Controllers\Institucion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SolicitudInstitucion;
use App\Models\Clase;
use App\Models\EstudianteClase;
use App\Models\Departamento;
use App\Models\Docente;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Estudiante;
use App\Models\Categoria;

class SolicitudClaseController extends Controller
{
    /**
     * Muestra el formulario para asignar un estudiante a una clase
     */
    public function asignar(SolicitudInstitucion $solicitud)
    {
        // Verificar que la solicitud pertenece a la institución del usuario autenticado
        if ($solicitud->institucion_id !== Auth::user()->institucion->id) {
            return redirect()->route('institucion.solicitudes.index')
                ->with('error', 'No tienes permiso para acceder a esta solicitud');
        }

        // Verificar que la solicitud esté aprobada
        if ($solicitud->estado !== 'aprobada') {
            return redirect()->route('institucion.solicitudes.show', $solicitud->id)
                ->with('error', 'Solo se pueden asignar clases a solicitudes aprobadas');
        }

        // Obtener departamentos de la institución
        $departamentos = Departamento::where('institucion_id', Auth::user()->institucion->id)
            ->orderBy('nombre')
            ->get();

        // Obtener docentes de la institución
        $docentes = Docente::whereHas('user', function ($query) {
                $query->whereHas('institucion', function ($q) {
                    $q->where('id', Auth::user()->institucion->id);
                });
            })
            ->get();

        // Obtener clases disponibles con conteo de estudiantes
        $clases = Clase::where('institucion_id', Auth::user()->institucion->id)
            ->with(['departamento', 'docente.user'])
            ->withCount(['estudiantes as total_estudiantes'])
            ->orderBy('nombre')
            ->get();

        // Obtener todas las categorías para filtrar
        $categorias = Categoria::all();

        return view('institucion.solicitudes.asignar-clase', compact('solicitud', 'clases', 'departamentos', 'docentes', 'categorias'));
    }

    /**
     * Procesa la asignación del estudiante a la clase seleccionada
     */
    public function store(Request $request, SolicitudInstitucion $solicitud)
    {
        // Validar que la solicitud pertenece a la institución
        if ($solicitud->institucion_id !== Auth::user()->institucion->id) {
            return redirect()->route('institucion.solicitudes.index')
                ->with('error', 'No tienes permiso para acceder a esta solicitud');
        }

        // Validar el formulario
        $validated = $request->validate([
            'clase_id' => 'required|exists:clases,id',
        ], [
            'clase_id.required' => 'Debes seleccionar una clase',
            'clase_id.exists' => 'La clase seleccionada no existe',
        ]);

        // Verificar que la clase pertenece a la institución
        $clase = Clase::findOrFail($validated['clase_id']);
        if ($clase->institucion_id !== Auth::user()->institucion->id) {
            return back()->with('error', 'La clase seleccionada no pertenece a tu institución');
        }

        // Verificar si hay capacidad disponible en la clase
        if ($clase->capacidad) {
            $estudiantesActuales = EstudianteClase::where('clase_id', $clase->id)->count();
            if ($estudiantesActuales >= $clase->capacidad) {
                return back()->with('error', 'La clase seleccionada ha alcanzado su capacidad máxima');
            }
        }

        try {
            DB::beginTransaction();
            
            // Usar el método asignarClase del modelo SolicitudInstitucion
            $solicitud->asignarClase($validated['clase_id']);
            
            DB::commit();
            
            return redirect()->route('institucion.solicitudes.show', $solicitud->id)
                ->with('success', 'Estudiante asignado a la clase correctamente');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Ha ocurrido un error al asignar el estudiante: ' . $e->getMessage());
        }
    }

    public function index()
    {
        $institucion = auth()->user()->institucion;
        
        // Obtener solicitudes de clases
        $solicitudes = SolicitudInstitucion::with(['estudiante.user', 'clase'])
            ->where('institucion_id', $institucion->id)
            ->orderBy('created_at', 'desc')
            ->get();

        // Obtener estudiantes pendientes de activación
        $estudiantesPendientes = Estudiante::with(['user', 'titulo'])
            ->where('institucion_id', $institucion->id)
            ->whereHas('user', function($query) {
                $query->where('activo', false);
            })
            ->get();

        // Obtener todas las categorías para filtrar
        $categorias = Categoria::all();

        // Calcular estadísticas
        $stats = [
            'total' => $solicitudes->count(),
            'pendientes' => $solicitudes->where('estado', 'pendiente')->count(),
            'aprobadas' => $solicitudes->where('estado', 'aprobada')->count(),
            'rechazadas' => $solicitudes->where('estado', 'rechazada')->count(),
        ];

        return view('institucion.solicitudes.index', compact('solicitudes', 'estudiantesPendientes', 'categorias', 'stats'));
    }
} 