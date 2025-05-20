<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Models\Publication;
use App\Models\Categoria;
use App\Models\Subcategoria;
use App\Models\Empresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Importar DB para SQL directo
use Illuminate\Support\Facades\Log; // Importar Log para registros

class PublicacionController extends BaseController
{
    /**
     * Muestra el listado de publicaciones
     */
    public function index(Request $request)
    {
        $query = Publication::with(['empresa.user', 'categoria', 'subcategoria']);

        // Aplicar filtros sumativos
        if ($request->filled('titulo')) {
            $query->where('titulo', 'like', '%' . $request->titulo . '%');
        }

        if ($request->filled('empresa')) {
            $query->whereHas('empresa.user', function($q) use ($request) {
                $q->where('nombre', 'like', '%' . $request->empresa . '%');
            });
        }

        if ($request->filled('categoria_id')) {
            $query->where('categoria_id', $request->categoria_id);
        }

        if ($request->filled('subcategoria_id')) {
            $query->where('subcategoria_id', $request->subcategoria_id);
        }
        
        // Filtrar por estado activo/inactivo
        if ($request->filled('activa')) {
            $query->where('activa', $request->activa);
        }

        $publicaciones = $query->orderBy('id', 'asc')->paginate(10);
        $empresas = Empresa::with('user')->get();
        $categorias = Categoria::all();

        if ($request->ajax()) {
            return response()->json([
                'tabla' => view('admin.publicaciones.tabla', compact('publicaciones'))->render()
            ]);
        }

        return view('admin.publicaciones.index', compact('publicaciones', 'empresas', 'categorias'));
    }

    /**
     * Almacena una nueva publicación
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'empresa_id' => 'required|exists:empresas,id',
            'categoria_id' => 'required|exists:categorias,id',
            'subcategoria_id' => 'required|exists:subcategorias,id',
            'horario' => 'required|in:mañana,tarde,flexible',
            'horas_totales' => 'required|integer|min:1',
            'fecha_publicacion' => 'required|date'
        ]);
        
        $validated['activa'] = $request->has('activa') ? 1 : 0;
        
        // Verificar que la empresa exista antes de crear
        $empresa = Empresa::find($validated['empresa_id']);
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
        
        try {
            DB::beginTransaction();
            
            $publication = Publication::create($validated);
            Log::info('Publicación creada:', $publication->toArray());
            
            // Registrar la actividad
            $this->logCreation($publication, 'Se ha creado una nueva oferta: ' . $publication->titulo);
            
            DB::commit();
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Publicación creada correctamente',
                    'publication' => $publication
                ]);
            }
            
            return redirect()->route('admin.publicaciones.index')
                ->with('success', 'Publicación creada correctamente');
                
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al crear publicación: ' . $e->getMessage());
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al crear la publicación: ' . $e->getMessage(),
                    'errors' => ['general' => ['Error al crear la publicación: ' . $e->getMessage()]]
                ], 500);
            }
            
            return redirect()->back()
                ->withErrors(['general' => 'Error al crear la publicación: ' . $e->getMessage()])
                ->withInput();
        }
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
        $empresas = Empresa::all();
        
        return view('admin.publicaciones.edit', compact('publicacion', 'categorias', 'subcategorias', 'empresas'));
    }

    /**
     * Actualiza una publicación existente
     */
    public function update(Request $request, $id)
    {
        $publicacion = Publication::findOrFail($id);
        
        // Si la solicitud solo contiene el campo 'activa', es una operación de activar/desactivar
        if ($request->has('activa') && count($request->except(['_method', '_token'])) <= 1) {
            try {
                $publicacion->update([
                    'activa' => $request->activa
                ]);
                
                $mensaje = $request->activa ? 'Oferta activada exitosamente' : 'Oferta desactivada exitosamente';
                
                // Registrar la actividad de cambio de estado
                $this->logUpdate($publicacion, 'Se ha ' . ($request->activa ? 'activado' : 'desactivado') . ' la oferta: ' . $publicacion->titulo);
                
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json([
                        'success' => true,
                        'message' => $mensaje
                    ]);
                }
                
                return redirect()->route('admin.publicaciones.index')
                    ->with('success', $mensaje);
            } catch (\Exception $e) {
                \Log::error('Error al cambiar estado de la publicación: ' . $e->getMessage());
                
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Error al actualizar el estado de la oferta: ' . $e->getMessage()
                    ], 500);
                }
                
                return redirect()->back()
                    ->with('error', 'Error al actualizar el estado de la oferta: ' . $e->getMessage())
                    ->withInput();
            }
        }

        // Validación para actualización normal
        $validated = $request->validate([
            'titulo' => 'required|max:100',
            'descripcion' => 'required',
            'horario' => 'required|in:mañana,tarde,flexible',
            'horas_totales' => 'required|integer|min:1',
            'fecha_publicacion' => 'required|date',
            'empresa_id' => 'required|exists:empresas,id',
            'categoria_id' => 'required|exists:categorias,id',
            'subcategoria_id' => 'required|exists:subcategorias,id'
        ]);

        // Ajuste para el checkbox
        $validated['activa'] = $request->has('activa') ? 1 : 0;
        
        try {
            DB::beginTransaction();
            
            // Guardar título antes de actualizar para el registro
            $tituloAnterior = $publicacion->titulo;
            
            // Actualizar la publicación
            $publicacion->update($validated);
            
            // Registrar la actividad
            $this->logUpdate($publicacion, 'Se ha actualizado la oferta: ' . $publicacion->titulo);
            
            DB::commit();
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Oferta actualizada correctamente'
                ]);
            }
            
            return redirect()->route('admin.publicaciones.index')
                ->with('success', 'Oferta actualizada correctamente');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error al actualizar publicación: ' . $e->getMessage());
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al actualizar la oferta: ' . $e->getMessage()
                ], 500);
            }
            
            return redirect()->back()
                ->with('error', 'Error al actualizar la oferta: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Elimina una publicación
     */
    public function destroy($id)
    {
        $publicacion = Publication::findOrFail($id);
        $tituloPublicacion = $publicacion->titulo; // Guardar título antes de cambiar estado
        
        try {
            DB::beginTransaction();
            
            // Desactivar la publicación en lugar de eliminarla
            $publicacion->update(['activa' => false]);
            
            // Registrar la actividad
            $this->logDeletion($publicacion, 'Se ha desactivado la oferta: ' . $tituloPublicacion);
            
            DB::commit();
            
            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Oferta desactivada correctamente'
                ]);
            }
            
            return redirect()->route('admin.publicaciones.index')
                ->with('success', 'Oferta desactivada correctamente');
        } catch (\Exception $e) {
            DB::rollBack();
            
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al desactivar la oferta: ' . $e->getMessage()
                ], 500);
            }
            
            return redirect()->route('admin.publicaciones.index')
                ->with('error', 'Error al desactivar la oferta: ' . $e->getMessage());
        }
    }
    
    /**
     * Obtiene las subcategorías de una categoría
     */
    public function getSubcategorias($categoriaId)
    {
        try {
            $subcategorias = Subcategoria::where('categoria_id', $categoriaId)
                ->orderBy('nombre_subcategoria', 'asc')
                ->get();
            
            if ($subcategorias->isEmpty()) {
                return response()->json([
                    'error' => true,
                    'message' => 'No se encontraron subcategorías para esta categoría'
                ], 404);
            }
            
            return response()->json([
                'error' => false,
                'data' => $subcategorias
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => 'Error al obtener subcategorías'
            ], 500);
        }
    }

    /**
     * Elimina una publicación mediante SQL directo
     */
    public function destroySQL($id)
    {
        try {
            // Obtener información de la publicación antes de eliminarla
            $publicacion = Publication::find($id);
            $tituloPublicacion = $publicacion ? $publicacion->titulo : 'ID: ' . $id;
            
            // Registrar la solicitud para debug
            Log::info('Intento de eliminación SQL para publicación ID: ' . $id);
            
            // Ejecutar SQL directo para eliminar
            $affected = DB::delete('DELETE FROM publications WHERE id = ?', [$id]);
            
            // Comprobar si se eliminó algún registro
            if ($affected > 0) {
                Log::info('Publicación eliminada correctamente mediante SQL directo. ID: ' . $id);
                
                // Registrar la actividad (usando un objeto genérico ya que la publicación ya no existe)
                if ($publicacion) {
                    $this->logDeletion($publicacion, 'Se ha eliminado la oferta: ' . $tituloPublicacion);
                }
                
                if (request()->ajax()) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Publicación eliminada correctamente mediante SQL directo'
                    ]);
                }
                
                return redirect()->route('admin.publicaciones.index')
                    ->with('success', 'Publicación eliminada correctamente mediante SQL directo');
            } else {
                Log::warning('No se encontró la publicación para eliminar. ID: ' . $id);
                
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
            Log::error('Error al eliminar publicación mediante SQL: ' . $e->getMessage());
            
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