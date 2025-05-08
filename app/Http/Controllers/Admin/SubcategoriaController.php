<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subcategoria;
use App\Models\Categoria;
use App\Models\Publication;
use App\Models\Publicacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubcategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Subcategoria::query();

        // Aplicar filtro por nombre
        if ($request->has('nombre') && !empty($request->nombre)) {
            $query->where('nombre_subcategoria', 'like', '%' . $request->nombre . '%');
        }

        // Aplicar filtro por categoría
        if ($request->has('categoria') && !empty($request->categoria)) {
            $query->where('categoria_id', $request->categoria);
        }

        // Aplicar filtro por publicaciones
        if ($request->has('publicaciones') && $request->publicaciones !== '') {
            if ($request->publicaciones === '0') {
                $query->whereDoesntHave('publicaciones');
            } elseif ($request->publicaciones === '1') {
                $query->whereHas('publicaciones');
            }
        }

        // Usar selectRaw para el conteo de publicaciones directamente
        $query->selectRaw('subcategorias.*, (SELECT COUNT(*) FROM publicaciones WHERE publicaciones.subcategoria_id = subcategorias.id) as publicaciones_count');

        $subcategorias = $query->with('categoria')
                              ->paginate(10);
        
        $categorias = Categoria::all();

        if ($request->ajax()) {
            $view = view('admin.subcategorias.tabla', compact('subcategorias'))->render();
            return response()->json(['tabla' => $view]);
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
            DB::beginTransaction();
            
            // Extraer el ID para la verificación
            $subcategoriaId = $subcategoria->id;
            
            // IMPORTANTE: No intentar usar relaciones o modelos directamente
            // En lugar de eso, usar query builder para verificar existencia de publicaciones
            $publicacionesExisten = DB::table('publicaciones')
                ->where('subcategoria_id', $subcategoriaId)
                ->exists();
            
            if ($publicacionesExisten) {
                DB::rollBack();
                // Obtener el conteo para el mensaje (solo si existen)
                $publicacionesCount = DB::table('publicaciones')
                    ->where('subcategoria_id', $subcategoriaId)
                    ->count();
                
                if (request()->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'No se puede eliminar la subcategoría porque tiene ' . $publicacionesCount . ' publicaciones asociadas'
                    ], 422);
                }
                return redirect()->route('admin.subcategorias.index')
                    ->with('error', 'No se puede eliminar la subcategoría porque tiene ' . $publicacionesCount . ' publicaciones asociadas');
            }
            
            // Si llegamos aquí, significa que no hay publicaciones asociadas
            // Eliminar la subcategoría con delete() del modelo
            $subcategoria->delete();
            
            // Confirmar la transacción
            DB::commit();
            
            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Subcategoría eliminada exitosamente'
                ]);
            }
            
            return redirect()->route('admin.subcategorias.index')
                ->with('success', 'Subcategoría eliminada exitosamente');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            // Registrar el error para depuración
            \Log::error('Error al eliminar subcategoría: ' . $e->getMessage());
            \Log::error('Trace: ' . $e->getTraceAsString());
            
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al eliminar la subcategoría: ' . $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ], 500);
            }
            
            return redirect()->route('admin.subcategorias.index')
                ->with('error', 'Error al eliminar la subcategoría: ' . $e->getMessage());
        }
    }

    /**
     * Método para depurar qué publicaciones están asociadas a una subcategoría
     */
    public function checkPublicaciones($id)
    {
        try {
            // Obtener la subcategoría
            $subcategoria = Subcategoria::findOrFail($id);
            
            // Consultar directamente la tabla publicaciones con query builder
            $publicacionesDB = DB::table('publicaciones')
                ->where('subcategoria_id', $id)
                ->get();
            
            // Verificar si existen
            $publicacionesExisten = DB::table('publicaciones')
                ->where('subcategoria_id', $id)
                ->exists();
                
            // También consultar con otros criterios para depuración
            $publicacionesDB_string = DB::table('publicaciones')
                ->where('subcategoria_id', (string)$id)
                ->get();
                
            // Intentar obtener con modelos (catch por separado)
            $publicacionesModel1 = [];
            $publicacionesModel2 = [];
            $error1 = null;
            $error2 = null;
            
            try {
                $publicacionesModel1 = Publicacion::where('subcategoria_id', $id)->get();
            } catch (\Exception $e) {
                $error1 = $e->getMessage();
            }
            
            try {
                $publicacionesModel2 = Publication::where('subcategoria_id', $id)->get();
            } catch (\Exception $e) {
                $error2 = $e->getMessage();
            }
            
            // Devolver resultados de depuración detallados
            return response()->json([
                'subcategoria' => $subcategoria->toArray(),
                'publicaciones_existen' => $publicacionesExisten,
                'publicaciones_db' => $publicacionesDB,
                'publicaciones_db_count' => $publicacionesDB->count(),
                'publicaciones_db_string' => $publicacionesDB_string,
                'publicaciones_db_string_count' => $publicacionesDB_string->count(),
                'publicaciones_model1' => $error1 ?? $publicacionesModel1,
                'publicaciones_model1_count' => $error1 ?? count($publicacionesModel1),
                'publicaciones_model2' => $error2 ?? $publicacionesModel2,
                'publicaciones_model2_count' => $error2 ?? count($publicacionesModel2),
                'mensaje' => "Hay {$publicacionesDB->count()} publicaciones en DB, " .
                           ($error1 ?? count($publicacionesModel1)) . " en Publicacion y " .
                           ($error2 ?? count($publicacionesModel2)) . " en Publication",
                'errores' => [
                    'model1' => $error1,
                    'model2' => $error2
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ], 500);
        }
    }

    /**
     * Método alternativo para eliminar subcategorías cuando el método normal falla
     */
    public function deleteDirecto($id)
    {
        try {
            // Iniciar transacción
            DB::beginTransaction();
            
            // Verificar si la subcategoría existe
            $subcategoria = Subcategoria::findOrFail($id);
            
            // Verificar si hay publicaciones asociadas con SQL directo
            $publicacionesCount = DB::selectOne("SELECT COUNT(*) as count FROM publicaciones WHERE subcategoria_id = ?", [$id])->count;
            
            if ($publicacionesCount > 0) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => "No se puede eliminar la subcategoría porque tiene {$publicacionesCount} publicaciones asociadas"
                ], 422);
            }
            
            // Eliminar directamente con SQL
            DB::statement("DELETE FROM subcategorias WHERE id = ?", [$id]);
            
            // Confirmar la transacción
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Subcategoría eliminada exitosamente mediante método alternativo'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error("Error en deleteDirecto: " . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar la subcategoría: ' . $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ], 500);
        }
    }

    /**
     * Obtiene las subcategorías por categoría para los selects dinámicos
     */
    public function getByCategoria($categoriaId)
    {
        $subcategorias = Subcategoria::where('categoria_id', $categoriaId)
            ->orderBy('nombre_subcategoria', 'asc')
            ->get();
            
        return response()->json([
            'success' => true,
            'subcategorias' => $subcategorias
        ]);
    }
}
