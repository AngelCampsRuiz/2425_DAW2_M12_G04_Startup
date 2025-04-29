<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Publication;
use App\Models\Categoria;
use App\Models\Subcategoria;
use App\Models\Empresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Importar DB para SQL directo

class PublicacionController extends Controller
{
    /**
     * Muestra el listado de publicaciones
     */
    public function index()
    {
        $publicaciones = Publication::with(['empresa.user', 'categoria', 'subcategoria'])
                        ->orderBy('id', 'asc')
                        ->paginate(10);
        $categorias = Categoria::all();
        $subcategorias = Subcategoria::all();
        $empresas = Empresa::with('user')->get();
        
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
        // Registrar datos recibidos para debug
        \Log::info('Datos recibidos en creación de publicación:', $request->all());
        
        $validated = $request->validate([
            'titulo' => 'required|max:100',
            'descripcion' => 'required',
            'horario' => 'required|in:mañana,tarde',
            'horas_totales' => 'required|integer|min:1',
            'fecha_publicacion' => 'required|date',
            'activa' => 'boolean',
            'empresa_id' => 'required|exists:empresas,id',
            'categoria_id' => 'required|exists:categorias,id',
            'subcategoria_id' => 'required|exists:subcategorias,id',
        ]);

        // Ajuste para el checkbox
        $validated['activa'] = $request->has('activa') ? 1 : 0;
        
        // Verificar que la empresa exista antes de crear
        $empresa = \App\Models\Empresa::find($validated['empresa_id']);
        if (!$empresa) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'La empresa seleccionada no existe',
                    'errors' => ['empresa_id' => ['La empresa seleccionada no existe']]
                ], 422);
            }
            
            return redirect()->back()
                ->withErrors(['empresa_id' => 'La empresa seleccionada no existe'])
                ->withInput();
        }
        
        $publication = Publication::create($validated);
        \Log::info('Publicación creada:', $publication->toArray());

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Publicación creada correctamente',
                'publication' => $publication
            ]);
        }
        
        return redirect()->route('admin.publicaciones.index')
            ->with('success', 'Publicación creada correctamente');
    }

    /**
     * Obtiene los datos de una publicación para editar
     */
    public function edit($id)
    {
        $publicacion = Publication::with(['empresa.user', 'categoria', 'subcategoria'])->findOrFail($id);
        
        if (request()->ajax()) {
            return response()->json([
                'publicacion' => $publicacion
            ]);
        }
        
        $categorias = Categoria::all();
        $subcategorias = Subcategoria::all();
        $empresas = Empresa::with('user')->get();
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
            'horario' => 'required|in:mañana,tarde',
            'horas_totales' => 'required|integer|min:1',
            'fecha_publicacion' => 'required|date',
            'activa' => 'boolean',
            'empresa_id' => 'required|exists:empresas,id',
            'categoria_id' => 'required|exists:categorias,id',
            'subcategoria_id' => 'required|exists:subcategorias,id',
        ]);

        // Ajuste para el checkbox
        $validated['activa'] = $request->has('activa') ? 1 : 0;
        
        $publicacion->update($validated);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Publicación actualizada correctamente'
            ]);
        }
        
        return redirect()->route('admin.publicaciones.index')
            ->with('success', 'Publicación actualizada correctamente');
    }

    /**
     * Elimina una publicación
     */
    public function destroy($id)
    {
        $publicacion = Publication::findOrFail($id);
        $publicacion->delete();

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Publicación eliminada correctamente'
            ]);
        }
        
        return redirect()->route('admin.publicaciones.index')
            ->with('success', 'Publicación eliminada correctamente');
    }

    /**
     * Elimina una publicación mediante SQL directo
     */
    public function destroySQL($id)
    {
        try {
            // Registrar la solicitud para debug
            \Log::info('Intento de eliminación SQL para publicación ID: ' . $id);
            
            // Ejecutar SQL directo para eliminar
            $affected = DB::delete('DELETE FROM publications WHERE id = ?', [$id]);
            
            // Comprobar si se eliminó algún registro
            if ($affected > 0) {
                \Log::info('Publicación eliminada correctamente mediante SQL directo. ID: ' . $id);
                
                if (request()->ajax()) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Publicación eliminada correctamente mediante SQL directo'
                    ]);
                }
                
                return redirect()->route('admin.publicaciones.index')
                    ->with('success', 'Publicación eliminada correctamente mediante SQL directo');
            } else {
                \Log::warning('No se encontró la publicación para eliminar. ID: ' . $id);
                
                if (request()->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'No se encontró la publicación para eliminar'
                    ]);
                }
                
                return redirect()->route('admin.publicaciones.index')
                    ->with('error', 'No se encontró la publicación para eliminar');
            }
        } catch (\Exception $e) {
            \Log::error('Error al eliminar publicación mediante SQL: ' . $e->getMessage());
            
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al eliminar: ' . $e->getMessage()
                ]);
            }
            
            return redirect()->route('admin.publicaciones.index')
                ->with('error', 'Error al eliminar: ' . $e->getMessage());
        }
    }
} 