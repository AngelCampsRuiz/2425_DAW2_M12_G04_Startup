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
        // Si la solicitud solo contiene el campo 'activo', es una operación de activar/desactivar
        if ($request->has('activo') && count($request->all()) <= 3) {
            $categoria->update([
                'activo' => $request->activo
            ]);

            $mensaje = $request->activo ? 'Categoría activada exitosamente' : 'Categoría desactivada exitosamente';

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => $mensaje
                ]);
            }

            return redirect()->route('admin.categorias.index')
                ->with('success', $mensaje);
        }

        // Si no, es una actualización normal del nombre
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
            // Desactivar la categoría en lugar de eliminarla
            $categoria->update(['activo' => false]);
            
            // También podríamos desactivar todas sus subcategorías
            $categoria->subcategorias()->update(['activo' => false]);
            
            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Categoría desactivada exitosamente'
                ]);
            }

            return redirect()->route('admin.categorias.index')
                ->with('success', 'Categoría desactivada exitosamente');
        } catch (\Exception $e) {
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al desactivar la categoría: ' . $e->getMessage()
                ], 500);
            }
            
            return redirect()->route('admin.categorias.index')
                ->with('error', 'Error al desactivar la categoría: ' . $e->getMessage());
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
