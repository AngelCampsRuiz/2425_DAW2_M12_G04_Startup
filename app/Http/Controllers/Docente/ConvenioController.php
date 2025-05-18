<?php

namespace App\Http\Controllers\Docente;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Convenio;
use App\Models\Estudiante;
use App\Models\Clase;
use Illuminate\Support\Facades\Auth;

class ConvenioController extends Controller
{
    /**
     * Muestra un listado de convenios que están relacionados con los estudiantes del docente.
     */
    public function index(Request $request)
    {
        $docenteId = Auth::id();
        
        // Obtenemos las clases del docente
        $clasesIds = Clase::where('docente_id', $docenteId)->pluck('id');
        
        // Obtenemos los ids de estudiantes que pertenecen a esas clases
        $estudiantesIds = Estudiante::whereHas('clases', function($query) use ($clasesIds) {
            $query->whereIn('clases.id', $clasesIds);
        })->pluck('id');
        
        // Consultamos convenios filtrando por los estudiantes del docente
        $query = Convenio::whereIn('estudiante_id', $estudiantesIds)
            ->with(['estudiante', 'empresa', 'oferta']);
        
        // Aplicar filtros si existen
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->whereHas('estudiante', function($sq) use ($search) {
                    $sq->where('nombre', 'LIKE', "%{$search}%")
                        ->orWhere('email', 'LIKE', "%{$search}%");
                })
                ->orWhereHas('empresa', function($sq) use ($search) {
                    $sq->where('nombre', 'LIKE', "%{$search}%");
                })
                ->orWhereHas('oferta', function($sq) use ($search) {
                    $sq->where('titulo', 'LIKE', "%{$search}%");
                });
            });
        }
        
        if ($request->filled('estado')) {
            $query->where('estado', $request->input('estado'));
        }
        
        // Obtener los convenios paginados
        $convenios = $query->orderBy('created_at', 'desc')->paginate(10);
        
        // Estadísticas para el dashboard
        $totalConvenios = Convenio::whereIn('estudiante_id', $estudiantesIds)->count();
        $conveniosPendientes = Convenio::whereIn('estudiante_id', $estudiantesIds)->where('estado', 'pendiente')->count();
        $conveniosActivos = Convenio::whereIn('estudiante_id', $estudiantesIds)->where('estado', 'activo')->count();
        $conveniosFinalizados = Convenio::whereIn('estudiante_id', $estudiantesIds)->where('estado', 'finalizado')->count();
        
        return view('docentes.convenios.index', compact(
            'convenios', 
            'totalConvenios', 
            'conveniosPendientes', 
            'conveniosActivos', 
            'conveniosFinalizados'
        ));
    }

    /**
     * Muestra el detalle de un convenio específico.
     */
    public function show(Convenio $convenio)
    {
        $docenteId = Auth::id();
        
        // Verificar que el convenio pertenece a un estudiante del docente
        $clasesIds = Clase::where('docente_id', $docenteId)->pluck('id');
        $estudiantesIds = Estudiante::whereHas('clases', function($query) use ($clasesIds) {
            $query->whereIn('clases.id', $clasesIds);
        })->pluck('id');
        
        if (!$estudiantesIds->contains($convenio->estudiante_id)) {
            abort(403, 'No tiene permisos para ver este convenio');
        }
        
        $convenio->load(['estudiante', 'empresa', 'oferta']);
        
        return view('docentes.convenios.show', compact('convenio'));
    }

    /**
     * Aprobar un convenio pendiente
     */
    public function aprobar(Convenio $convenio)
    {
        $docenteId = Auth::id();
        
        // Verificar que el convenio pertenece a un estudiante del docente
        $clasesIds = Clase::where('docente_id', $docenteId)->pluck('id');
        $estudiantesIds = Estudiante::whereHas('clases', function($query) use ($clasesIds) {
            $query->whereIn('clases.id', $clasesIds);
        })->pluck('id');
        
        if (!$estudiantesIds->contains($convenio->estudiante_id)) {
            abort(403, 'No tiene permisos para gestionar este convenio');
        }
        
        // Verificar que el convenio está pendiente
        if ($convenio->estado != 'pendiente') {
            return back()->with('error', 'Solo se pueden aprobar convenios en estado pendiente');
        }
        
        // Actualizar el estado del convenio
        $convenio->estado = 'activo';
        $convenio->aprobado_por = $docenteId;
        $convenio->fecha_aprobacion = now();
        $convenio->save();
        
        return redirect()->route('docente.convenios.show', $convenio)
            ->with('success', 'El convenio ha sido aprobado correctamente');
    }

    /**
     * Rechazar un convenio pendiente
     */
    public function rechazar(Convenio $convenio)
    {
        $docenteId = Auth::id();
        
        // Verificar que el convenio pertenece a un estudiante del docente
        $clasesIds = Clase::where('docente_id', $docenteId)->pluck('id');
        $estudiantesIds = Estudiante::whereHas('clases', function($query) use ($clasesIds) {
            $query->whereIn('clases.id', $clasesIds);
        })->pluck('id');
        
        if (!$estudiantesIds->contains($convenio->estudiante_id)) {
            abort(403, 'No tiene permisos para gestionar este convenio');
        }
        
        // Verificar que el convenio está pendiente
        if ($convenio->estado != 'pendiente') {
            return back()->with('error', 'Solo se pueden rechazar convenios en estado pendiente');
        }
        
        // Actualizar el estado del convenio
        $convenio->estado = 'rechazado';
        $convenio->aprobado_por = $docenteId; // Guardamos quien lo rechazó
        $convenio->fecha_aprobacion = now();
        $convenio->save();
        
        return redirect()->route('docente.convenios.show', $convenio)
            ->with('success', 'El convenio ha sido rechazado');
    }
    
    /**
     * Descargar el PDF del convenio
     */
    public function download(Convenio $convenio)
    {
        $docenteId = Auth::id();
        
        // Verificar que el convenio pertenece a un estudiante del docente
        $clasesIds = Clase::where('docente_id', $docenteId)->pluck('id');
        $estudiantesIds = Estudiante::whereHas('clases', function($query) use ($clasesIds) {
            $query->whereIn('clases.id', $clasesIds);
        })->pluck('id');
        
        if (!$estudiantesIds->contains($convenio->estudiante_id)) {
            abort(403, 'No tiene permisos para descargar este convenio');
        }
        
        // Código para generar el PDF
        // Esta implementación dependerá de cómo se generen los PDFs en tu aplicación
        
        // Ejemplo: Si hay una ruta ya implementada para empresa, podríamos redireccionar
        return redirect()->route('empresa.convenios.download', $convenio->id);
    }
} 