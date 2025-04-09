<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Publication;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Empresa;
use Illuminate\Http\Request;

class PublicacionController extends Controller
{
    /**
     * Muestra el listado de publicaciones
     */
    public function index()
    {
        $publicaciones = Publication::with(['empresa', 'categoria', 'subcategoria'])->get();
        $categorias = Category::all();
        $subcategorias = Subcategory::all();
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
        
        Publication::create($validated);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Publicación creada correctamente'
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
        $publicacion = Publication::findOrFail($id);
        
        if (request()->ajax()) {
            return response()->json([
                'publicacion' => $publicacion
            ]);
        }
        
        $categorias = Category::all();
        $subcategorias = Subcategory::all();
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
} 