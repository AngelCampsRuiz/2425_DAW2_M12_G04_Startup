<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subcategoria;
use App\Models\Categoria;
use Illuminate\Http\Request;

class SubcategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subcategorias = Subcategoria::with('categoria')->paginate(10);
        $categorias = Categoria::all();
        
        if (request()->ajax()) {
            return response()->json([
                'tabla' => view('admin.subcategorias.tabla', compact('subcategorias'))->render()
            ]);
        }
        
        return view('admin.subcategorias.index', compact('subcategorias', 'categorias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categorias = Categoria::all();
        return view('admin.subcategorias.form', compact('categorias'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre_subcategoria' => 'required|string|max:255',
            'categoria_id' => 'required|exists:categorias,id'
        ]);

        $subcategoria = Subcategoria::create($validated);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Subcategoría creada exitosamente',
                'subcategoria' => $subcategoria
            ]);
        }

        return redirect()->route('admin.subcategorias.index')
            ->with('success', 'Subcategoría creada exitosamente');
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
    public function edit(Subcategoria $subcategoria)
    {
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'subcategoria' => $subcategoria
            ]);
        }

        $categorias = Categoria::all();
        return view('admin.subcategorias.form', compact('subcategoria', 'categorias'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subcategoria $subcategoria)
    {
        $validated = $request->validate([
            'nombre_subcategoria' => 'required|string|max:255',
            'categoria_id' => 'required|exists:categorias,id'
        ]);

        $subcategoria->update($validated);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Subcategoría actualizada exitosamente',
                'subcategoria' => $subcategoria
            ]);
        }

        return redirect()->route('admin.subcategorias.index')
            ->with('success', 'Subcategoría actualizada exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subcategoria $subcategoria)
    {
        try {
            if ($subcategoria->publicaciones()->exists()) {
                if (request()->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'No se puede eliminar la subcategoría porque tiene publicaciones asociadas'
                    ], 422);
                }
                return redirect()->route('admin.subcategorias.index')
                    ->with('error', 'No se puede eliminar la subcategoría porque tiene publicaciones asociadas');
            }

            $subcategoria->delete();

            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Subcategoría eliminada exitosamente'
                ]);
            }

            return redirect()->route('admin.subcategorias.index')
                ->with('success', 'Subcategoría eliminada exitosamente');
        } catch (\Exception $e) {
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al eliminar la subcategoría: ' . $e->getMessage()
                ], 500);
            }
            
            return redirect()->route('admin.subcategorias.index')
                ->with('error', 'Error al eliminar la subcategoría');
        }
    }
}
