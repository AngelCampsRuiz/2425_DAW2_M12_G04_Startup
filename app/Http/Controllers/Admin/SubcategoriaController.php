<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Models\Subcategoria;
use App\Models\Categoria;
use App\Models\Publication;
use App\Models\Publicacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubcategoriaController extends BaseController
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
        
        // Aplicar filtro por estado activo/inactivo
        if ($request->has('activo') && $request->activo !== '') {
            $query->where('activo', $request->activo);
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

        try {
            DB::beginTransaction();
            
            $subcategoria = Subcategoria::create($validated);
            
            // Registrar la actividad
            $this->logCreation($subcategoria, 'Se ha creado una nueva subcategoría: ' . $subcategoria->nombre_subcategoria);
            
            DB::commit();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Subcategoría creada exitosamente',
                    'subcategoria' => $subcategoria
                ]);
            }

            return redirect()->route('admin.subcategorias.index')
                ->with('success', 'Subcategoría creada exitosamente');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al crear la subcategoría: ' . $e->getMessage()
                ], 500);
            }
            
            return redirect()->back()
                ->with('error', 'Error al crear la subcategoría: ' . $e->getMessage())
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
        // Si la solicitud solo contiene el campo 'activo', es una operación de activar/desactivar
        if ($request->has('activo') && count($request->all()) <= 3) {
            try {
                DB::beginTransaction();
                
                $subcategoria->update([
                    'activo' => $request->activo
                ]);
                
                // Registrar la actividad de cambio de estado
                $this->logUpdate($subcategoria, 'Se ha ' . ($request->activo ? 'activado' : 'desactivado') . ' la subcategoría: ' . $subcategoria->nombre_subcategoria);
                
                DB::commit();

                $mensaje = $request->activo ? 'Subcategoría activada exitosamente' : 'Subcategoría desactivada exitosamente';

                if ($request->ajax()) {
                    return response()->json([
                        'success' => true,
                        'message' => $mensaje
                    ]);
                }

                return redirect()->route('admin.subcategorias.index')
                    ->with('success', $mensaje);
                    
            } catch (\Exception $e) {
                DB::rollBack();
                // Manejar error
            }
        }

        // Si no, es una actualización normal
        $request->validate([
            'nombre_subcategoria' => 'required|string|max:255',
            'categoria_id' => 'required|exists:categorias,id'
        ]);

        try {
            DB::beginTransaction();
            
            // Guardar nombre anterior para el registro
            $nombreAnterior = $subcategoria->nombre_subcategoria;
            
            $subcategoria->update([
                'nombre_subcategoria' => $request->nombre_subcategoria,
                'categoria_id' => $request->categoria_id
            ]);
            
            // Registrar la actividad
            $this->logUpdate($subcategoria, 'Se ha actualizado la subcategoría: ' . $subcategoria->nombre_subcategoria);
            
            DB::commit();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Subcategoría actualizada exitosamente'
                ]);
            }

            return redirect()->route('admin.subcategorias.index')
                ->with('success', 'Subcategoría actualizada exitosamente');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al actualizar la subcategoría: ' . $e->getMessage()
                ], 500);
            }
            
            return redirect()->back()
                ->with('error', 'Error al actualizar la subcategoría: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subcategoria $subcategoria)
    {
        try {
            DB::beginTransaction();
            
            // Guardar el nombre antes de desactivar para el registro
            $nombreSubcategoria = $subcategoria->nombre_subcategoria;
            
            // Desactivar la subcategoría en lugar de eliminarla
            $subcategoria->update(['activo' => false]);
            
            // Registrar la actividad
            $this->logDeletion($subcategoria, 'Se ha desactivado la subcategoría: ' . $nombreSubcategoria);
            
            DB::commit();
            
            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Subcategoría desactivada exitosamente'
                ]);
            }
            
            return redirect()->route('admin.subcategorias.index')
                ->with('success', 'Subcategoría desactivada exitosamente');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            // Registrar el error para depuración
            \Log::error('Error al desactivar subcategoría: ' . $e->getMessage());
            
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al desactivar la subcategoría: ' . $e->getMessage()
                ], 500);
            }
            
            return redirect()->route('admin.subcategorias.index')
                ->with('error', 'Error al desactivar la subcategoría: ' . $e->getMessage());
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
