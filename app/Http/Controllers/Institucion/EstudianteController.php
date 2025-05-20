<?php

namespace App\Http\Controllers\Institucion;

use App\Http\Controllers\Controller;
use App\Models\Estudiante;
use App\Models\Categoria;
use App\Models\Clase;
use App\Models\EstudianteClase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EstudianteController extends Controller
{
    /**
     * Mostrar el listado de estudiantes de la institución.
     */
    public function index(Request $request)
    {
        $institucion = Auth::user()->institucion;
        
        $query = Estudiante::with(['user', 'categoria'])
            ->where('institucion_id', $institucion->id);
        
        // Filtrar por estado si se proporciona
        if ($request->has('estado') && !empty($request->estado)) {
            $query->where('estado', $request->estado);
        }
        
        // Búsqueda por nombre o email
        if ($request->has('buscar') && !empty($request->buscar)) {
            $search = $request->buscar;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }
        
        // Filtrar por clase
        if ($request->has('clase_id') && !empty($request->clase_id)) {
            $query->whereHas('clases', function($q) use ($request) {
                $q->where('clase_id', $request->clase_id);
            });
        }
        
        // Filtrar por categoría
        if ($request->has('categoria_id') && !empty($request->categoria_id)) {
            $query->where('categoria_id', $request->categoria_id);
        }
        
        $estudiantes = $query->paginate(10);
        
        // Obtener clases y categorías para los filtros
        $clases = Clase::where('institucion_id', $institucion->id)->get();
        $categorias = Categoria::all();
        
        // Estadísticas para el resumen
        $stats = [
            'total' => Estudiante::where('institucion_id', $institucion->id)->count(),
            'activos' => Estudiante::where('institucion_id', $institucion->id)
                        ->where('estado', 'activo')->count(),
            'pendientes' => Estudiante::where('institucion_id', $institucion->id)
                        ->where('estado', 'pendiente')->count(),
            'sin_clase' => Estudiante::where('institucion_id', $institucion->id)
                        ->where('estado', 'activo')
                        ->whereDoesntHave('clases')
                        ->count(),
        ];
        
        return view('institucion.estudiantes.index', [
            'estudiantes' => $estudiantes,
            'clases' => $clases,
            'categorias' => $categorias,
            'stats' => $stats,
            'filtro' => $request->estado ?? 'todos',
            'busqueda' => $request->buscar ?? ''
        ]);
    }

    /**
     * Mostrar estudiantes pendientes de activación.
     */
    public function pendientes()
    {
        $institucion = Auth::user()->institucion;
        
        $estudiantesPendientes = Estudiante::with(['user', 'categoria'])
            ->where('institucion_id', $institucion->id)
            ->where('estado', 'pendiente')
            ->get();
            
        $categorias = Categoria::all();
        
        return view('institucion.estudiantes.pendientes', compact('estudiantesPendientes', 'categorias'));
    }

    /**
     * Mostrar detalles de un estudiante específico.
     */
    public function show($id)
    {
        $estudiante = Estudiante::with([
            'user', 
            'categoria', 
            'clases.docente.user', 
            'clases.departamento',
            'experiencias',
            'solicitudes'
        ])->findOrFail($id);
        
        // Verificar que el estudiante pertenezca a la institución actual
        $institucion = Auth::user()->institucion;
        
        if ($estudiante->institucion_id !== $institucion->id) {
            return redirect()->route('institucion.estudiantes.index')
                ->with('error', 'No tienes permiso para ver este estudiante');
        }
        
        // Obtener clases disponibles para asignar
        $clasesDisponibles = Clase::where('institucion_id', $institucion->id)
            ->whereNotIn('id', $estudiante->clases->pluck('id')->toArray())
            ->get();
        
        // Obtener todas las categorías para el modal de edición
        $categorias = Categoria::all();
        
        return view('institucion.estudiantes.show', compact('estudiante', 'clasesDisponibles', 'categorias'));
    }

    /**
     * Mostrar formulario para editar un estudiante.
     */
    public function edit($id)
    {
        $estudiante = Estudiante::with(['user', 'categoria'])->findOrFail($id);
        
        // Verificar que el estudiante pertenezca a la institución actual
        $institucion = Auth::user()->institucion;
        
        if ($estudiante->institucion_id !== $institucion->id) {
            return redirect()->route('institucion.estudiantes.index')
                ->with('error', 'No tienes permiso para editar este estudiante');
        }
        
        $categorias = Categoria::all();
        
        return view('institucion.estudiantes.edit', compact('estudiante', 'categorias'));
    }

    /**
     * Actualizar información de un estudiante.
     */
    public function update(Request $request, $id)
    {
        $estudiante = Estudiante::findOrFail($id);
        
        // Verificar que el estudiante pertenezca a la institución actual
        $institucion = Auth::user()->institucion;
        
        if ($estudiante->institucion_id !== $institucion->id) {
            return redirect()->route('institucion.estudiantes.index')
                ->with('error', 'No tienes permiso para editar este estudiante');
        }
        
        $request->validate([
            'categoria_id' => 'required|exists:categorias,id',
            'conocimientos_previos' => 'nullable|string|max:1000',
            'intereses' => 'nullable|string|max:1000',
        ]);
        
        try {
            $estudiante->update($request->only(['categoria_id', 'conocimientos_previos', 'intereses']));
            
            return redirect()->route('institucion.estudiantes.show', $estudiante->id)
                ->with('success', 'Estudiante actualizado correctamente');
        } catch (\Exception $e) {
            Log::error('Error al actualizar estudiante: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Error al actualizar el estudiante: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Activar un estudiante pendiente.
     */
    public function activar($id)
    {
        try {
            DB::beginTransaction();

            $estudiante = Estudiante::with('user')->findOrFail($id);
            
            // Verificar que el estudiante pertenezca a la institución actual
            $institucion = Auth::user()->institucion;
            
            if ($estudiante->institucion_id !== $institucion->id) {
                return redirect()->route('institucion.estudiantes.pendientes')
                    ->with('error', 'No tienes permiso para activar este estudiante');
            }
            
            // Actualizar estado del estudiante
            $estudiante->estado = 'activo';
            $estudiante->save();
            
            // Actualizar estado activo del usuario asociado
            if ($estudiante->user) {
                $estudiante->user->activo = true;
                $estudiante->user->save();
            }

            DB::commit();

            return redirect()->back()->with('success', 'Estudiante activado correctamente');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al activar estudiante: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al activar el estudiante: ' . $e->getMessage());
        }
    }
    
    /**
     * Actualizar los datos académicos del estudiante pendiente.
     */
    public function actualizar(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $estudiante = Estudiante::findOrFail($id);
            
            // Verificar que el estudiante pertenezca a la institución actual
            $institucion = Auth::user()->institucion;
            
            if ($estudiante->institucion_id !== $institucion->id) {
                return redirect()->route('institucion.estudiantes.pendientes')
                    ->with('error', 'No tienes permiso para editar este estudiante');
            }
            
            $estudiante->categoria_id = $request->categoria_id;
            $estudiante->save();

            DB::commit();

            return redirect()->back()->with('success', 'Estudiante actualizado correctamente');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al actualizar estudiante: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al actualizar el estudiante');
        }
    }
    
    /**
     * Eliminar un estudiante pendiente.
     */
    public function eliminar($id)
    {
        try {
            DB::beginTransaction();

            $estudiante = Estudiante::findOrFail($id);
            
            // Verificar que el estudiante pertenezca a la institución actual
            $institucion = Auth::user()->institucion;
            
            if ($estudiante->institucion_id !== $institucion->id) {
                return redirect()->route('institucion.estudiantes.pendientes')
                    ->with('error', 'No tienes permiso para eliminar este estudiante');
            }
            
            // Eliminar al estudiante
            $estudiante->delete();

            DB::commit();

            return redirect()->back()->with('success', 'Estudiante eliminado correctamente');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al eliminar estudiante: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al eliminar el estudiante');
        }
    }
    
    /**
     * Asignar un estudiante a una clase.
     */
    public function asignarClase(Request $request, $id)
    {
        $request->validate([
            'clase_id' => 'required|exists:clases,id',
        ]);
        
        try {
            DB::beginTransaction();
            
            $estudiante = Estudiante::findOrFail($id);
            
            // Verificar que el estudiante pertenezca a la institución actual
            $institucion = Auth::user()->institucion;
            
            if ($estudiante->institucion_id !== $institucion->id) {
                return redirect()->route('institucion.estudiantes.index')
                    ->with('error', 'No tienes permiso para asignar este estudiante');
            }
            
            // Verificar que la clase pertenezca a la institución
            $clase = Clase::findOrFail($request->clase_id);
            
            if ($clase->institucion_id !== $institucion->id) {
                return redirect()->route('institucion.estudiantes.show', $estudiante->id)
                    ->with('error', 'La clase seleccionada no pertenece a esta institución');
            }
            
            // Verificar si el estudiante ya está asignado a la clase
            $existingAssignment = EstudianteClase::where('estudiante_id', $estudiante->id)
                ->where('clase_id', $clase->id)
                ->first();
                
            if ($existingAssignment) {
                return redirect()->route('institucion.estudiantes.show', $estudiante->id)
                    ->with('error', 'El estudiante ya está asignado a esta clase');
            }
            
            // Crear la asignación estudiante-clase
            EstudianteClase::create([
                'estudiante_id' => $estudiante->id,
                'clase_id' => $clase->id,
                'fecha_asignacion' => now(),
                'estado' => 'activo',
            ]);
            
            DB::commit();
            
            return redirect()->route('institucion.estudiantes.show', $estudiante->id)
                ->with('success', 'Estudiante asignado a la clase correctamente');
                
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al asignar estudiante a clase: ' . $e->getMessage());
            return redirect()->route('institucion.estudiantes.show', $id)
                ->with('error', 'Error al asignar estudiante a la clase: ' . $e->getMessage());
        }
    }
    
    /**
     * Eliminar asignación de un estudiante a una clase.
     */
    public function eliminarClase(Request $request, $id, $claseId)
    {
        try {
            DB::beginTransaction();
            
            $estudiante = Estudiante::findOrFail($id);
            
            // Verificar que el estudiante pertenezca a la institución actual
            $institucion = Auth::user()->institucion;
            
            if ($estudiante->institucion_id !== $institucion->id) {
                return redirect()->route('institucion.estudiantes.index')
                    ->with('error', 'No tienes permiso para modificar este estudiante');
            }
            
            // Eliminar la relación
            EstudianteClase::where('estudiante_id', $estudiante->id)
                ->where('clase_id', $claseId)
                ->delete();
            
            DB::commit();
            
            return redirect()->route('institucion.estudiantes.show', $estudiante->id)
                ->with('success', 'Asignación de clase eliminada correctamente');
                
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al eliminar asignación de clase: ' . $e->getMessage());
            return redirect()->route('institucion.estudiantes.show', $id)
                ->with('error', 'Error al eliminar asignación de clase: ' . $e->getMessage());
        }
    }

    /**
     * Actualizar información de un estudiante desde el modal.
     */
    public function updateModal(Request $request)
    {
        $request->validate([
            'estudiante_id' => 'required|exists:estudiantes,id',
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telefono' => 'nullable|string|max:20',
            'dni' => 'nullable|string|max:20',
            'fecha_nacimiento' => 'nullable|date',
            'ciudad' => 'nullable|string|max:100',
            'direccion' => 'nullable|string|max:255',
            'categoria_id' => 'required|exists:categorias,id',
            'conocimientos_previos' => 'nullable|string|max:1000',
            'intereses' => 'nullable|string|max:1000',
        ]);
        
        try {
            DB::beginTransaction();
            
            $estudiante = Estudiante::findOrFail($request->estudiante_id);
            
            // Verificar que el estudiante pertenezca a la institución actual
            $institucion = Auth::user()->institucion;
            
            if ($estudiante->institucion_id !== $institucion->id) {
                return redirect()->back()
                    ->with('error', 'No tienes permiso para editar este estudiante');
            }
            
            // Actualizar datos del estudiante
            $estudiante->update([
                'categoria_id' => $request->categoria_id,
                'conocimientos_previos' => $request->conocimientos_previos,
                'intereses' => $request->intereses
            ]);
            
            // Actualizar datos del usuario
            $user = $estudiante->user;
            $user->update([
                'nombre' => $request->nombre,
                'email' => $request->email,
                'telefono' => $request->telefono,
                'dni' => $request->dni,
                'fecha_nacimiento' => $request->fecha_nacimiento,
                'ciudad' => $request->ciudad,
                'direccion' => $request->direccion
            ]);
            
            DB::commit();
            
            return redirect()->back()->with('success', 'Estudiante actualizado correctamente');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al actualizar estudiante desde modal: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Error al actualizar el estudiante: ' . $e->getMessage())
                ->withInput();
        }
    }
}
