<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Publication;
use App\Models\Categoria;
use App\Models\Subcategoria;
use App\Models\Empresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PublicacionController extends Controller
{
    /**
     * Muestra el listado de publicaciones
     */
    public function index()
    {
        $publicaciones = Publication::with(['empresa', 'categoria', 'subcategoria', 'subcategorias'])
                        ->orderBy('id', 'asc')
                        ->paginate(10);
        $categorias = Categoria::all();
        $subcategorias = Subcategoria::all();
        $empresas = Empresa::all();
        
        if (request()->ajax()) {
            return response()->json([
                'tabla' => view('admin.publicaciones.tabla', compact('publicaciones'))->render()
            ]);
        }
        
        return view('admin.publicaciones.index', compact('publicaciones', 'categorias', 'subcategorias', 'empresas'));
    }

    /**
     * Almacena una nueva publicación
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'titulo' => 'required|max:100',
            'descripcion' => 'required',
            'horario' => 'required|in:mañana,tarde,flexible',
            'horas_totales' => 'required|integer|min:1',
            'fecha_publicacion' => 'required|date',
            'activa' => 'boolean',
            'empresa_id' => 'required|exists:empresas,id',
            'categoria_id' => 'required|exists:categorias,id',
            'subcategoria_id' => 'required|exists:subcategorias,id',
            'subcategorias' => 'required|array',
            'subcategorias.*' => 'exists:subcategorias,id',
        ]);

        // Ajuste para el checkbox
        $validated['activa'] = $request->has('activa') ? 1 : 0;
        
        try {
            DB::beginTransaction();
            
            // Crear la publicación
            $publicacion = Publication::create($validated);
            
            // Asociar subcategorías
            $publicacion->subcategorias()->sync($request->subcategorias);
            
            DB::commit();
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Publicación creada correctamente'
                ]);
            }
            
            return redirect()->route('admin.publicaciones.index')
                ->with('success', 'Publicación creada correctamente');
        } catch (\Exception $e) {
            DB::rollBack();
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al crear la publicación: ' . $e->getMessage()
                ], 500);
            }
            
            return redirect()->back()
                ->with('error', 'Error al crear la publicación: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Obtiene los datos de una publicación para editar
     */
    public function edit($id)
    {
        $publicacion = Publication::with('subcategorias')->findOrFail($id);
        
        if (request()->ajax()) {
            return response()->json([
                'publicacion' => $publicacion,
                'subcategorias_seleccionadas' => $publicacion->subcategorias->pluck('id')->toArray()
            ]);
        }
        
        $categorias = Categoria::all();
        $subcategorias = Subcategoria::all();
        $empresas = Empresa::all();
        return view('admin.publicaciones.edit', compact('publicacion', 'categorias', 'subcategorias', 'empresas'));
    }

    /**
     * Actualiza una publicación
     */
    public function update(Request $request, $id)
    {
        $publicacion = Publication::findOrFail($id);
        
        $validated = $request->validate([
            'titulo' => 'required|max:100',
            'descripcion' => 'required',
            'horario' => 'required|in:mañana,tarde,flexible',
            'horas_totales' => 'required|integer|min:1',
            'fecha_publicacion' => 'required|date',
            'activa' => 'boolean',
            'empresa_id' => 'required|exists:empresas,id',
            'categoria_id' => 'required|exists:categorias,id',
            'subcategoria_id' => 'required|exists:subcategorias,id',
            'subcategorias' => 'required|array',
            'subcategorias.*' => 'exists:subcategorias,id',
        ]);

        // Ajuste para el checkbox
        $validated['activa'] = $request->has('activa') ? 1 : 0;
        
        try {
            DB::beginTransaction();
            
            // Actualizar la publicación
            $publicacion->update($validated);
            
            // Actualizar subcategorías
            $publicacion->subcategorias()->sync($request->subcategorias);
            
            DB::commit();
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Publicación actualizada correctamente'
                ]);
            }
            
            return redirect()->route('admin.publicaciones.index')
                ->with('success', 'Publicación actualizada correctamente');
        } catch (\Exception $e) {
            DB::rollBack();
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al actualizar la publicación: ' . $e->getMessage()
                ], 500);
            }
            
            return redirect()->back()
                ->with('error', 'Error al actualizar la publicación: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Elimina una publicación
     */
    public function destroy($id)
    {
        $publicacion = Publication::findOrFail($id);
        
        try {
            DB::beginTransaction();
            
            // Eliminar relaciones con subcategorías
            $publicacion->subcategorias()->detach();
            
            // Eliminar la publicación
            $publicacion->delete();
            
            DB::commit();
            
            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Publicación eliminada correctamente'
                ]);
            }
            
            return redirect()->route('admin.publicaciones.index')
                ->with('success', 'Publicación eliminada correctamente');
        } catch (\Exception $e) {
            DB::rollBack();
            
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al eliminar la publicación: ' . $e->getMessage()
                ], 500);
            }
            
            return redirect()->route('admin.publicaciones.index')
                ->with('error', 'Error al eliminar la publicación: ' . $e->getMessage());
        }
    }
    
    /**
     * Obtiene las subcategorías de una categoría
     */
    public function getSubcategorias($categoriaId)
    {
        $subcategorias = Subcategoria::where('categoria_id', $categoriaId)->get();
        return response()->json($subcategorias);
    }
} 