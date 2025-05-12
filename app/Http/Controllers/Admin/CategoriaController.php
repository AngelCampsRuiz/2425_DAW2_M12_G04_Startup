<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\Publication;
use App\Models\NivelEducativo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Categoria::query()->with('subcategorias');

        if ($request->has('nombre')) {
            $query->where('nombre_categoria', 'like', '%' . $request->nombre . '%');
        }

        if ($request->has('subcategorias')) {
            if ($request->subcategorias === '0') {
                $query->doesntHave('subcategorias');
            } elseif ($request->subcategorias === '1') {
                $query->has('subcategorias');
            }
        }

        $categorias = $query->paginate(10);

        if ($request->ajax()) {
            $view = view('admin.categorias.tabla', compact('categorias'))->render();
            return response()->json(['tabla' => $view]);
        }

        return view('admin.categorias.index', compact('categorias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.categorias.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre_categoria' => 'required|string|max:255|unique:categorias'
        ]);

        try {
            DB::beginTransaction();
            
            $categoria = Categoria::create([
                'nombre_categoria' => $request->nombre_categoria,
                'nivel_educativo_id' => 1 // Establecer nivel educativo por defecto a 1
            ]);
            
            DB::commit();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Categoría creada exitosamente'
                ]);
            }

            return redirect()->route('admin.categorias.index')
                ->with('success', 'Categoría creada exitosamente');

        } catch (\Exception $e) {
            DB::rollBack();
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al crear la categoría: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()
                ->with('error', 'Error al crear la categoría: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Categoria $categoria)
    {
        if (request()->ajax()) {
            return response()->json([
                'categoria' => $categoria->load('nivelEducativo')
            ]);
        }
        return view('admin.categorias.edit', compact('categoria'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Categoria $categoria)
    {
        $request->validate([
            'nombre_categoria' => 'required|string|max:255|unique:categorias,nombre_categoria,' . $categoria->id
        ]);

        $categoria->update([
            'nombre_categoria' => $request->nombre_categoria,
            'nivel_educativo_id' => $categoria->nivel_educativo_id // Mantener el nivel educativo existente
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Categoría actualizada exitosamente'
            ]);
        }

        return redirect()->route('admin.categorias.index')
            ->with('success', 'Categoría actualizada exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Categoria $categoria)
    {
        try {
            // Iniciar transacción para asegurar que todo se elimine correctamente
            DB::beginTransaction();
            
            // Verificar si hay publicaciones asociadas a alguna subcategoría de esta categoría
            $subcategoriasIds = $categoria->subcategorias()->pluck('id')->toArray();
            
            if (!empty($subcategoriasIds)) {
                $publicacionesAsociadas = Publication::whereIn('subcategoria_id', $subcategoriasIds)->exists();
                
                if ($publicacionesAsociadas) {
                    DB::rollBack();
                    if (request()->ajax()) {
                        return response()->json([
                            'success' => false,
                            'message' => 'No se puede eliminar la categoría porque tiene publicaciones asociadas a sus subcategorías'
                        ], 422);
                    }
                    return redirect()->route('admin.categorias.index')
                        ->with('error', 'No se puede eliminar la categoría porque tiene publicaciones asociadas a sus subcategorías');
                }
                
                // Si no hay publicaciones, eliminar todas las subcategorías
                $categoria->subcategorias()->delete();
            }
            
            // Eliminar la categoría
            $categoria->delete();
            
            // Confirmar la transacción
            DB::commit();

            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Categoría y sus subcategorías eliminadas exitosamente'
                ]);
            }

            return redirect()->route('admin.categorias.index')
                ->with('success', 'Categoría y sus subcategorías eliminadas exitosamente');
        } catch (\Exception $e) {
            // Si hay algún error, hacer rollback
            DB::rollBack();
            
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al eliminar la categoría: ' . $e->getMessage()
                ], 500);
            }
            
            return redirect()->route('admin.categorias.index')
                ->with('error', 'Error al eliminar la categoría: ' . $e->getMessage());
        }
    }
    
    /**
     * Obtiene las subcategorías de una categoría específica.
     */
    public function getSubcategorias(Categoria $categoria)
    {
        $subcategorias = $categoria->subcategorias;
        
        return response()->json([
            'subcategorias' => $subcategorias
        ]);
    }
}
