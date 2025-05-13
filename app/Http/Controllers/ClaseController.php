<?php

namespace App\Http\Controllers;

use App\Models\Clase;
use App\Models\Docente;
use App\Models\Departamento;
use App\Models\Estudiante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ClaseController extends Controller
{
    // Listar clases
    public function index()
    {
        $institucion = Auth::user()->institucion;
        $clases = $institucion->clases()->with(['docente.user', 'departamento'])->get();
        $departamentos = $institucion->departamentos;
        $docentes = $institucion->docentes()->with('user')->get();
        $estudiantes = $institucion->estudiantes()->count();
        
        // Obtener niveles educativos de la institución
        $nivelesEducativos = $institucion->nivelesEducativos;
        
        // Obtener categorías (cursos) organizadas por nivel educativo
        $categoriasPorNivel = [];
        foreach ($nivelesEducativos as $nivel) {
            $categoriasPorNivel[$nivel->id] = $institucion->categoriasPorNivel($nivel->id)->get();
        }
        
        return view('institucion.clases.index', compact(
            'clases', 
            'departamentos', 
            'docentes', 
            'estudiantes', 
            'nivelesEducativos', 
            'categoriasPorNivel'
        ));
    }

    // Formulario crear clase
    public function create()
    {
        return redirect()->route('institucion.clases.index', ['openModal' => true]);
    }

    // Guardar clase
    public function store(Request $request)
    {
        $institucion = Auth::user()->institucion;
        
        $request->validate([
            'nombre' => 'required|string|max:255',
            'codigo' => 'required|string|max:255|unique:clases,codigo',
            'nivel_educativo_id' => 'required|exists:niveles_educativos,id',
            'categoria_id' => 'required|exists:categorias,id',
            'grupo' => 'nullable|string|max:255',
            'descripcion' => 'nullable|string',
            'departamento_id' => 'nullable|exists:departamentos,id',
            'docente_id' => 'nullable|exists:docentes,id',
        ]);

        // Obtener el nivel educativo
        $nivelEducativo = $institucion->nivelesEducativos()
            ->where('niveles_educativos.id', $request->nivel_educativo_id)
            ->first();
        
        // Obtener la categoría (curso)
        $categoria = $institucion->categorias()
            ->where('categorias.id', $request->categoria_id)
            ->where('institucion_categoria.nivel_educativo_id', $request->nivel_educativo_id)
            ->first();
        
        if (!$nivelEducativo || !$categoria) {
            return redirect()->back()->with('error', 'El nivel educativo o curso seleccionado no es válido para esta institución.');
        }
        
        // Usar nombres de nivel y categoría almacenados
        $nombreNivel = $nivelEducativo->nombre_nivel;
        $nombreCurso = $categoria->pivot->nombre_personalizado ?: $categoria->nombre_categoria;

        // Crear clase
        $clase = Clase::create([
            'institucion_id' => $institucion->id,
            'departamento_id' => $request->departamento_id,
            'docente_id' => $request->docente_id,
            'nombre' => $request->nombre,
            'codigo' => $request->codigo,
            'nivel' => $nombreNivel,
            'curso' => $nombreCurso,
            'grupo' => $request->grupo,
            'descripcion' => $request->descripcion,
            'activa' => true,
            'nivel_educativo_id' => $request->nivel_educativo_id,
            'categoria_id' => $request->categoria_id,
        ]);

        return redirect()->route('institucion.clases.index')
            ->with('success', 'Clase creada correctamente');
    }

    // Ver clase
    public function show($id)
    {
        $institucion = Auth::user()->institucion;
        $clase = $institucion->clases()->with(['docente.user', 'departamento', 'estudiantes.user'])->findOrFail($id);
        
        return view('institucion.clases.show', compact('clase'));
    }

    // Editar clase
    public function edit($id)
    {
        return redirect()->route('institucion.clases.index', ['editModal' => true, 'id' => $id]);
    }

    // Obtener datos de la clase para edición por AJAX
    public function getData($id)
    {
        $institucion = Auth::user()->institucion;
        $clase = $institucion->clases()->findOrFail($id);
        
        return response()->json([
            'success' => true,
            'clase' => $clase
        ]);
    }

    // Actualizar clase
    public function update(Request $request, $id)
    {
        $institucion = Auth::user()->institucion;
        $clase = $institucion->clases()->findOrFail($id);
        
        $request->validate([
            'nombre' => 'required|string|max:255',
            'codigo' => 'required|string|max:255|unique:clases,codigo,' . $clase->id,
            'nivel_educativo_id' => 'required|exists:niveles_educativos,id',
            'categoria_id' => 'required|exists:categorias,id',
            'grupo' => 'nullable|string|max:255',
            'descripcion' => 'nullable|string',
            'departamento_id' => 'nullable|exists:departamentos,id',
            'docente_id' => 'nullable|exists:docentes,id',
        ]);

        // Obtener el nivel educativo
        $nivelEducativo = $institucion->nivelesEducativos()
            ->where('niveles_educativos.id', $request->nivel_educativo_id)
            ->first();
        
        // Obtener la categoría (curso)
        $categoria = $institucion->categorias()
            ->where('categorias.id', $request->categoria_id)
            ->where('institucion_categoria.nivel_educativo_id', $request->nivel_educativo_id)
            ->first();
        
        if (!$nivelEducativo || !$categoria) {
            return redirect()->back()->with('error', 'El nivel educativo o curso seleccionado no es válido para esta institución.');
        }
        
        // Usar nombres de nivel y categoría almacenados
        $nombreNivel = $nivelEducativo->nombre_nivel;
        $nombreCurso = $categoria->pivot->nombre_personalizado ?: $categoria->nombre_categoria;

        // Actualizar clase
        $clase->update([
            'departamento_id' => $request->departamento_id,
            'docente_id' => $request->docente_id,
            'nombre' => $request->nombre,
            'codigo' => $request->codigo,
            'nivel' => $nombreNivel,
            'curso' => $nombreCurso,
            'grupo' => $request->grupo,
            'descripcion' => $request->descripcion,
            'nivel_educativo_id' => $request->nivel_educativo_id,
            'categoria_id' => $request->categoria_id,
        ]);

        return redirect()->route('institucion.clases.index')
            ->with('success', 'Clase actualizada correctamente');
    }

    // Eliminar clase
    public function destroy($id)
    {
        $institucion = Auth::user()->institucion;
        $clase = $institucion->clases()->findOrFail($id);
        
        // Verificar si tiene estudiantes asignados
        if ($clase->estudiantes()->count() > 0) {
            return redirect()->route('institucion.clases.index')
                ->with('error', 'No se puede eliminar la clase porque tiene estudiantes asignados');
        }
        
        // Eliminar clase
        $clase->delete();
        
        return redirect()->route('institucion.clases.index')
            ->with('success', 'Clase eliminada correctamente');
    }

    // Cambiar estado de la clase
    public function toggleActive($id)
    {
        $institucion = Auth::user()->institucion;
        $clase = $institucion->clases()->findOrFail($id);
        
        $clase->update([
            'activa' => !$clase->activa
        ]);
        
        return redirect()->route('institucion.clases.index')
            ->with('success', 'Estado de la clase actualizado correctamente');
    }

    // Asignar estudiantes a la clase
    public function asignarEstudiantes($id)
    {
        $institucion = Auth::user()->institucion;
        $clase = $institucion->clases()->findOrFail($id);
        $estudiantes = $institucion->estudiantes()->with('user')->get();
        $estudiantesAsignados = $clase->estudiantes()->pluck('id')->toArray();
        
        return view('institucion.clases.asignar-estudiantes', compact('clase', 'estudiantes', 'estudiantesAsignados'));
    }

    // Guardar asignación de estudiantes
    public function guardarAsignacionEstudiantes(Request $request, $id)
    {
        $institucion = Auth::user()->institucion;
        $clase = $institucion->clases()->findOrFail($id);
        
        $request->validate([
            'estudiantes' => 'nullable|array',
            'estudiantes.*' => 'exists:estudiantes,id',
        ]);

        // Actualizar estudiantes asignados
        $estudiantes = $request->input('estudiantes', []);
        
        foreach ($institucion->estudiantes as $estudiante) {
            if (in_array($estudiante->id, $estudiantes)) {
                // Asignar a la clase
                $estudiante->update([
                    'clase_id' => $clase->id,
                    'docente_id' => $clase->docente_id,
                ]);
            } else if ($estudiante->clase_id == $clase->id) {
                // Desasignar de la clase
                $estudiante->update([
                    'clase_id' => null,
                    'docente_id' => null,
                ]);
            }
        }
        
        return redirect()->route('institucion.clases.show', $clase->id)
            ->with('success', 'Estudiantes asignados correctamente');
    }
} 