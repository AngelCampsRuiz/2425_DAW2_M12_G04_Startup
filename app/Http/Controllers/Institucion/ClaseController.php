<?php

namespace App\Http\Controllers\Institucion;

use App\Http\Controllers\Controller;
use App\Models\Clase;
use App\Models\Estudiante;
use App\Models\Departamento;
use App\Models\Docente;
use App\Models\Categoria;
use App\Models\NivelEducativo;
use App\Models\EstudianteClase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ClaseController extends Controller
{
    /**
     * Muestra el listado de clases.
     */
    public function index(Request $request)
    {
        $institucion = Auth::user()->institucion;
        
        // Consulta base para clases de la institución
        $query = Clase::with(['departamento', 'docente.user', 'categoria'])
            ->where('institucion_id', $institucion->id)
            ->withCount('estudiantes');
        
        // Aplicar filtros si existen
        if ($request->has('search') && !empty($request->search)) {
            $query->where('nombre', 'like', '%' . $request->search . '%');
        }
        
        if ($request->has('departamento_id') && !empty($request->departamento_id)) {
            $query->where('departamento_id', $request->departamento_id);
        }
        
        if ($request->has('docente_id') && !empty($request->docente_id)) {
            $query->where('docente_id', $request->docente_id);
        }
        
        // Obtener resultados paginados
        $clases = $query->paginate(9);
        
        // Obtener datos para filtros
        $departamentos = Departamento::where('institucion_id', $institucion->id)->get();
        $docentes = Docente::with('user')->where('institucion_id', $institucion->id)->get();
        $categorias = Categoria::whereHas('instituciones', function($query) use ($institucion) {
            $query->where('instituciones.id', $institucion->id);
        })->get();
        
        return view('institucion.clases.index', compact('clases', 'departamentos', 'docentes', 'categorias'));
    }

    /**
     * Muestra el formulario para crear una nueva clase.
     */
    public function create()
    {
        $institucion = Auth::user()->institucion;
        
        $departamentos = Departamento::where('institucion_id', $institucion->id)->get();
        $docentes = Docente::with('user')->where('institucion_id', $institucion->id)->get();
        $nivelesEducativos = NivelEducativo::all();
        
        return view('institucion.clases.create', compact('departamentos', 'docentes', 'nivelesEducativos'));
    }

    /**
     * Almacena una nueva clase en la base de datos.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'codigo' => 'required|string|max:50|unique:clases',
            'nivel_educativo_id' => 'required|exists:nivel_educativo,id',
            'categoria_id' => 'required|exists:categorias,id',
            'departamento_id' => 'nullable|exists:departamentos,id',
            'docente_id' => 'nullable|exists:docentes,id',
            'grupo' => 'nullable|string|max:10',
            'descripcion' => 'nullable|string',
            'capacidad' => 'nullable|integer|min:1'
        ]);
        
        try {
            $clase = new Clase();
            $clase->nombre = $request->nombre;
            $clase->codigo = $request->codigo;
            $clase->descripcion = $request->descripcion;
            $clase->nivel_educativo_id = $request->nivel_educativo_id;
            $clase->categoria_id = $request->categoria_id;
            $clase->departamento_id = $request->departamento_id;
            $clase->docente_id = $request->docente_id;
            $clase->grupo = $request->grupo;
            $clase->capacidad = $request->capacidad;
            $clase->institucion_id = Auth::user()->institucion->id;
            $clase->activa = true;
            $clase->save();
            
            return redirect()->route('institucion.clases.show', $clase->id)
                ->with('success', 'Clase creada correctamente.');
        } catch (\Exception $e) {
            Log::error('Error al crear clase: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Error al crear la clase: ' . $e->getMessage());
        }
    }

    /**
     * Muestra los detalles de una clase específica.
     */
    public function show($id)
    {
        $institucion = Auth::user()->institucion;
        
        // Forzar una consulta fresca sin usar caché de relaciones
        $clase = Clase::with([
                'departamento', 
                'docente' => function($query) {
                    // Asegurarnos de que no usamos ninguna caché para la relación
                    $query->select('*')->with('user');
                }, 
                'categoria', 
                'estudiantes.user', 
                'estudiantes.categoria'
            ])
            ->where('institucion_id', $institucion->id)
            ->findOrFail($id);
        
        // Refrescar las relaciones para asegurar que tenemos los datos actualizados
        $clase->refresh();
        
        // Registrar información para depuración
        Log::info('Mostrando clase con ID: ' . $id, [
            'docente_id' => $clase->docente_id,
            'docente' => $clase->docente ? [
                'id' => $clase->docente->id,
                'nombre' => $clase->docente->user ? $clase->docente->user->nombre : 'Usuario no encontrado'
            ] : 'No asignado'
        ]);
        
        return view('institucion.clases.show', compact('clase'));
    }

    /**
     * Muestra el formulario para editar una clase existente.
     */
    public function edit($id)
    {
        $institucion = Auth::user()->institucion;
        
        $clase = Clase::where('institucion_id', $institucion->id)->findOrFail($id);
        
        $departamentos = Departamento::where('institucion_id', $institucion->id)->get();
        $docentes = Docente::with('user')->where('institucion_id', $institucion->id)->get();
        $nivelesEducativos = NivelEducativo::all();
        
        // Obtener categorías según el nivel educativo de la clase
        $categorias = Categoria::whereHas('nivel_educativo', function($query) use ($clase) {
            $query->where('niveles_educativos.id', $clase->nivel_educativo_id);
        })->get();
        
        return view('institucion.clases.edit', compact('clase', 'departamentos', 'docentes', 'nivelesEducativos', 'categorias'));
    }

    /**
     * Actualiza una clase existente en la base de datos.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'codigo' => 'required|string|max:50|unique:clases,codigo,' . $id,
            'nivel_educativo_id' => 'required|exists:niveles_educativos,id',
            'categoria_id' => 'required|exists:categorias,id',
            'departamento_id' => 'nullable|exists:departamentos,id',
            'docente_id' => 'nullable|exists:docentes,id',
            'grupo' => 'nullable|string|max:10',
            'descripcion' => 'nullable|string',
            'capacidad' => 'nullable|integer|min:1',
            'activa' => 'nullable|boolean'
        ]);
        
        try {
            $institucion = Auth::user()->institucion;
            
            // Registrar datos recibidos para depuración
            Log::info('Datos recibidos para actualizar clase', [
                'id' => $id,
                'request_data' => $request->all()
            ]);
            
            // Encontrar la clase
            $clase = Clase::where('institucion_id', $institucion->id)->findOrFail($id);
            
            // Preparar los datos para actualizar
            $data = [
                'nombre' => $request->nombre,
                'codigo' => $request->codigo,
                'descripcion' => $request->descripcion,
                'nivel_educativo_id' => $request->nivel_educativo_id,
                'categoria_id' => $request->categoria_id,
                'departamento_id' => $request->departamento_id,
                'docente_id' => $request->docente_id,
                'grupo' => $request->grupo,
                'capacidad' => $request->capacidad,
                'activa' => $request->has('activa') ? true : false
            ];
            
            // Actualizar la clase usando Eloquent
            $clase->update($data);
            
            // Verificar que la actualización se realizó correctamente
            $claseActualizada = Clase::find($id);
            Log::info('Clase actualizada correctamente: ', [
                'nombre' => $claseActualizada->nombre,
                'docente_id' => $claseActualizada->docente_id
            ]);
            
            return redirect()->route('institucion.clases.index')
                ->with('success', 'Clase actualizada correctamente.');
                
        } catch (\Exception $e) {
            Log::error('Error al actualizar clase: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString()
            ]);
            return back()->withInput()->with('error', 'Error al actualizar la clase: ' . $e->getMessage());
        }
    }

    /**
     * Elimina una clase.
     */
    public function destroy($id)
    {
        try {
            $institucion = Auth::user()->institucion;
            $clase = Clase::where('institucion_id', $institucion->id)->findOrFail($id);
            
            // Verificar si tiene estudiantes
            $countEstudiantes = $clase->estudiantes()->count();
            if ($countEstudiantes > 0) {
                return back()->with('error', 'No se puede eliminar la clase porque tiene estudiantes asignados.');
            }
            
            $clase->delete();
            
            return redirect()->route('institucion.clases.index')
                ->with('success', 'Clase eliminada correctamente.');
        } catch (\Exception $e) {
            Log::error('Error al eliminar clase: ' . $e->getMessage());
            return back()->with('error', 'Error al eliminar la clase: ' . $e->getMessage());
        }
    }
    
    /**
     * Muestra la pantalla para asignar estudiantes a la clase.
     */
    public function asignarEstudiantes(Request $request, $id)
    {
        $institucion = Auth::user()->institucion;
        
        $clase = Clase::with(['departamento', 'docente.user', 'categoria', 'estudiantes'])
            ->where('institucion_id', $institucion->id)
            ->findOrFail($id);
        
        // Obtener los IDs de los estudiantes ya asignados a esta clase
        $estudiantesAsignadosIds = $clase->estudiantes->pluck('id')->toArray();
        
        // Consulta base para estudiantes de la institución que no están asignados a esta clase
        $query = Estudiante::with(['user', 'categoria'])
            ->where('institucion_id', $institucion->id)
            ->where('estado', 'activo')
            ->whereNotIn('id', $estudiantesAsignadosIds);
        
        // Aplicar filtros si existen
        if ($request->has('search') && !empty($request->search)) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('nombre', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }
        
        if ($request->has('categoria_id') && !empty($request->categoria_id)) {
            $query->where('categoria_id', $request->categoria_id);
        }
        
        // Obtener resultados paginados
        $estudiantesDisponibles = $query->paginate(10);
        
        // Obtener categorías para filtros
        $categorias = Categoria::whereHas('instituciones', function($query) use ($institucion) {
            $query->where('instituciones.id', $institucion->id);
        })->get();
        
        return view('institucion.clases.asignar-estudiantes', compact('clase', 'estudiantesDisponibles', 'categorias'));
    }
    
    /**
     * Guarda la asignación de estudiantes a la clase.
     */
    public function guardarEstudiantes(Request $request, $id)
    {
        $request->validate([
            'estudiantes' => 'required|array',
            'estudiantes.*' => 'exists:estudiantes,id',
        ]);
        
        try {
            $institucion = Auth::user()->institucion;
            $clase = Clase::where('institucion_id', $institucion->id)->findOrFail($id);
            
            // Verificar capacidad de la clase si está establecida
            if ($clase->capacidad) {
                $estudiantesActuales = $clase->estudiantes()->count();
                $estudiantesNuevos = count($request->estudiantes);
                
                if (($estudiantesActuales + $estudiantesNuevos) > $clase->capacidad) {
                    return back()->with('error', 'La capacidad de la clase es de ' . $clase->capacidad . ' estudiantes. No se pueden añadir ' . $estudiantesNuevos . ' estudiantes más.');
                }
            }
            
            DB::beginTransaction();
            
            // Asignar cada estudiante a la clase
            foreach ($request->estudiantes as $estudianteId) {
                // Verificar que el estudiante pertenezca a la institución
                $estudiante = Estudiante::where('id', $estudianteId)
                    ->where('institucion_id', $institucion->id)
                    ->where('estado', 'activo')
                    ->first();
                
                if ($estudiante) {
                    // Verificar que el estudiante no esté ya asignado a esta clase
                    $existeAsignacion = EstudianteClase::where('estudiante_id', $estudianteId)
                        ->where('clase_id', $clase->id)
                        ->exists();
                    
                    if (!$existeAsignacion) {
                        // Crear la asignación
                        EstudianteClase::create([
                            'estudiante_id' => $estudianteId,
                            'clase_id' => $clase->id,
                            'fecha_asignacion' => now()
                        ]);
                    }
                }
            }
            
            DB::commit();
            
            return redirect()->route('institucion.clases.show', $clase->id)
                ->with('success', 'Se han asignado ' . count($request->estudiantes) . ' estudiantes a la clase.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al asignar estudiantes: ' . $e->getMessage());
            return back()->with('error', 'Error al asignar estudiantes: ' . $e->getMessage());
        }
    }
    
    /**
     * Elimina un estudiante de la clase.
     */
    public function eliminarEstudiante($id, $estudianteId)
    {
        try {
            $institucion = Auth::user()->institucion;
            $clase = Clase::where('institucion_id', $institucion->id)->findOrFail($id);
            
            // Verificar que el estudiante pertenezca a la institución
            $estudiante = Estudiante::where('id', $estudianteId)
                ->where('institucion_id', $institucion->id)
                ->firstOrFail();
            
            // Eliminar la asignación
            EstudianteClase::where('estudiante_id', $estudianteId)
                ->where('clase_id', $clase->id)
                ->delete();
            
            return back()->with('success', 'Estudiante eliminado de la clase correctamente.');
        } catch (\Exception $e) {
            Log::error('Error al eliminar estudiante de la clase: ' . $e->getMessage());
            return back()->with('error', 'Error al eliminar estudiante de la clase: ' . $e->getMessage());
        }
    }
    
    /**
     * Devuelve los datos de una clase en formato JSON.
     */
    public function getData($id)
    {
        $institucion = Auth::user()->institucion;
        
        $clase = Clase::where('institucion_id', $institucion->id)->findOrFail($id);
        $departamentos = Departamento::where('institucion_id', $institucion->id)->get();
        $docentes = Docente::with('user')->where('institucion_id', $institucion->id)->get();
        
        // Obtener solo los niveles educativos asignados a la institución
        $nivelesEducativos = $institucion->nivelesEducativos()->get();
        
        // Obtener categorías organizadas por nivel educativo
        $categoriasPorNivel = [];
        foreach ($nivelesEducativos as $nivel) {
            $categorias = DB::table('institucion_categoria')
                ->join('categorias', 'institucion_categoria.categoria_id', '=', 'categorias.id')
                ->where('institucion_categoria.institucion_id', $institucion->id)
                ->where('institucion_categoria.nivel_educativo_id', $nivel->id)
                ->where('institucion_categoria.activo', true)
                ->select('categorias.id', 'categorias.nombre_categoria', 'institucion_categoria.nombre_personalizado')
                ->get();
                
            $categoriasPorNivel[$nivel->id] = $categorias;
        }
        
        // Todas las categorías disponibles para la institución
        $categorias = Categoria::whereHas('instituciones', function($query) use ($institucion) {
            $query->where('instituciones.id', $institucion->id);
        })->get();
        
        return response()->json([
            'clase' => $clase,
            'departamentos' => $departamentos,
            'docentes' => $docentes,
            'nivelesEducativos' => $nivelesEducativos,
            'categorias' => $categorias,
            'categoriasPorNivel' => $categoriasPorNivel
        ]);
    }
}
