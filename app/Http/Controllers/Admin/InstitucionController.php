<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Models\Institucion;
use App\Models\User;
use App\Models\Rol;
use App\Models\NivelEducativo;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class InstitucionController extends BaseController
{
    /**
     * Muestra el listado de instituciones
     */
    public function index(Request $request)
    {
        $query = Institucion::with('user', 'nivelesEducativos');
        
        // Aplicar filtro por nombre
        if ($request->has('nombre') && !empty($request->nombre)) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('nombre', 'like', '%' . $request->nombre . '%');
            });
        }
        
        // Aplicar filtro por email
        if ($request->has('email') && !empty($request->email)) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('email', 'like', '%' . $request->email . '%');
            });
        }
        
        // Aplicar filtro por código de centro
        if ($request->has('codigo_centro') && !empty($request->codigo_centro)) {
            $query->where('codigo_centro', 'like', '%' . $request->codigo_centro . '%');
        }
        
        // Aplicar filtro por tipo de institución - Deshabilitado temporalmente
        /*if ($request->has('tipo_institucion') && !empty($request->tipo_institucion)) {
            $query->where('tipo_institucion', $request->tipo_institucion);
        }*/
        
        // Aplicar filtro por ciudad
        if ($request->has('ciudad') && !empty($request->ciudad)) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('ciudad', $request->ciudad);
            });
        }
        
        // Aplicar filtro por estado
        if ($request->has('estado') && $request->estado !== '') {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('activo', $request->estado);
            });
        }
        
        // Aplicar filtro por verificación
        if ($request->has('verificada') && $request->verificada !== '') {
            $query->where('verificada', $request->verificada);
        }

        // Obtener ciudades únicas para el selector de filtros
        $ciudades = User::whereHas('institucion')
                       ->whereNotNull('ciudad')
                       ->where('ciudad', '!=', '')
                       ->distinct()
                       ->pluck('ciudad')
                       ->sort()
                       ->values();
        
        // Obtener tipos de institución para el selector
        // Comentado temporalmente debido a que la columna no existe
        $tipos_institucion = []; // Array vacío como fallback
        /*$tipos_institucion = Institucion::whereNotNull('tipo_institucion')
                      ->where('tipo_institucion', '!=', '')
                      ->distinct()
                      ->pluck('tipo_institucion')
                      ->sort()
                      ->values();*/
                       
        $nivelesEducativos = NivelEducativo::all();
        
        $instituciones = $query->orderBy('id', 'desc')
                        ->paginate(10);
        
        if ($request->ajax()) {
            return response()->json([
                'tabla' => view('admin.instituciones.tabla', compact('instituciones'))->render(),
                'pagination' => $instituciones->links()->toHtml()
            ]);
        }
        
        return view('admin.instituciones.index', compact('instituciones', 'nivelesEducativos', 'ciudades', 'tipos_institucion'));
    }

    /**
     * Almacena una nueva institución
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:user,email',
            'password' => 'required|string|min:8',
            'password_confirmation' => 'required|same:password',
            'dni' => 'required|string|max:255|unique:user,dni',
            'telefono' => 'required|string|max:15',
            'codigo_centro' => 'required|string|max:20|unique:instituciones,codigo_centro',
            'tipo_institucion' => 'required|string|max:50',
            'direccion' => 'required|string|max:255',
            'ciudad' => 'required|string|max:100',
            'codigo_postal' => 'required|string|max:10',
            'representante_legal' => 'required|string|max:255',
            'cargo_representante' => 'required|string|max:255',
            'niveles_educativos' => 'nullable|array',
            'niveles_educativos.*' => 'exists:niveles_educativos,id',
        ]);
        
        if ($validator->fails()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error de validación',
                    'errors' => $validator->errors()
                ], 422);
            }
            
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Iniciar transacción
        DB::beginTransaction();
        
        try {
            // Obtener ID del rol Institución
            $rolInstitucion = Rol::where('nombre_rol', 'Institucion')->first();
            
            if (!$rolInstitucion) {
                throw new \Exception('El rol Institución no existe en el sistema');
            }
            
            // Procesar imagen si se proporciona
            $imagenPath = null;
            if ($request->hasFile('imagen')) {
                $imagen = $request->file('imagen');
                $nombreImagen = time() . '_' . $imagen->getClientOriginalName();
                $imagen->move(public_path('profile_images'), $nombreImagen);
                $imagenPath = $nombreImagen;
            }
            
            // Crear usuario
            $user = User::create([
                'nombre' => $request->input('nombre'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
                'fecha_nacimiento' => $request->input('fecha_nacimiento') ?? null,
                'ciudad' => $request->input('ciudad') ?? null,
                'dni' => $request->input('dni'),
                'activo' => true,
                'sitio_web' => $request->input('sitio_web') ?? null,
                'telefono' => $request->input('telefono') ?? null,
                'descripcion' => $request->input('descripcion') ?? 'Institución Educativa',
                'role_id' => $rolInstitucion->id,
                'imagen' => $imagenPath,
            ]);
            
            // Crear institución
            $institucion = Institucion::create([
                'user_id' => $user->id,
                'codigo_centro' => $request->input('codigo_centro'),
                'tipo_institucion' => $request->input('tipo_institucion'),
                'direccion' => $request->input('direccion'),
                'ciudad' => $request->input('ciudad'),
                'codigo_postal' => $request->input('codigo_postal'),
                'representante_legal' => $request->input('representante_legal'),
                'cargo_representante' => $request->input('cargo_representante'),
                'verificada' => $request->has('verificada') ? true : false,
            ]);
            
            // Asignar niveles educativos si se proporcionan
            if ($request->has('niveles_educativos')) {
                foreach ($request->niveles_educativos as $nivelId) {
                    DB::table('institucion_nivel_educativo')->insert([
                        'institucion_id' => $institucion->id,
                        'nivel_educativo_id' => $nivelId,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
            
            // Registrar actividad
            $this->logCreation($institucion, 'Se ha creado una nueva institución: ' . $user->nombre);
            
            DB::commit();
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Institución creada correctamente',
                    'institucion' => $institucion,
                    'redirect' => route('admin.instituciones.index')
                ]);
            }
            
            return redirect()->route('admin.instituciones.index')
                ->with('success', 'Institución creada correctamente');
                
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al crear institución: ' . $e->getMessage());
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al crear la institución: ' . $e->getMessage(),
                    'errors' => ['general' => ['Error al crear la institución: ' . $e->getMessage()]]
                ], 500);
            }
            
            return redirect()->back()
                ->withErrors(['general' => 'Error al crear la institución: ' . $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Obtiene los datos de una institución para editar
     */
    public function edit($id)
    {
        $institucion = Institucion::with('user', 'nivelesEducativos')->findOrFail($id);
        $nivelesEducativos = NivelEducativo::all();
        
        if (request()->ajax()) {
            return response()->json([
                'institucion' => $institucion,
                'niveles_seleccionados' => $institucion->nivelesEducativos->pluck('id')->toArray()
            ]);
        }
        
        return view('admin.instituciones.edit', compact('institucion', 'nivelesEducativos'));
    }

    /**
     * Actualiza una institución
     */
    public function update(Request $request, $id)
    {
        $institucion = Institucion::findOrFail($id);
        $user = User::findOrFail($institucion->user_id);

        $rules = [
            'nombre' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:user,email,'.$user->id,
            'dni' => 'required|string|max:255|unique:user,dni,'.$user->id,
            'telefono' => 'required|string|max:15',
            'codigo_centro' => 'required|string|max:20|unique:instituciones,codigo_centro,'.$institucion->id,
            'tipo_institucion' => 'required|string|max:50',
            'direccion' => 'required|string|max:255',
            'ciudad' => 'required|string|max:100',
            'codigo_postal' => 'required|string|max:10',
            'representante_legal' => 'required|string|max:255',
            'cargo_representante' => 'required|string|max:255',
            'niveles_educativos' => 'nullable|array',
            'niveles_educativos.*' => 'exists:niveles_educativos,id',
        ];

        if ($request->filled('password')) {
            $rules['password'] = 'string|min:8';
            $rules['password_confirmation'] = 'required|same:password';
        }

        $validator = Validator::make($request->all(), $rules);
        
        if ($validator->fails()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error de validación',
                    'errors' => $validator->errors()
                ], 422);
            }
            
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Iniciar transacción
        DB::beginTransaction();
        
        try {
            // Actualizar usuario
            $userData = [
                'nombre' => $request->input('nombre'),
                'email' => $request->input('email'),
                'fecha_nacimiento' => $request->input('fecha_nacimiento') ?? null,
                'ciudad' => $request->input('ciudad') ?? null,
                'dni' => $request->input('dni'),
                'activo' => $request->has('activo') ? true : false,
                'sitio_web' => $request->input('sitio_web') ?? null,
                'telefono' => $request->input('telefono') ?? null,
                'descripcion' => $request->input('descripcion') ?? 'Institución Educativa',
            ];
            
            // Procesamiento de imagen
            if ($request->hasFile('imagen')) {
                // Eliminar imagen anterior si existe
                if ($user->imagen) {
                    $imagenPath = public_path('profile_images/' . $user->imagen);
                    if (file_exists($imagenPath)) {
                        unlink($imagenPath);
                    }
                }
                
                // Guardar nueva imagen
                $imagen = $request->file('imagen');
                $nombreImagen = time() . '_' . $imagen->getClientOriginalName();
                $imagen->move(public_path('profile_images'), $nombreImagen);
                $imagenPath = $nombreImagen;
                $userData['imagen'] = $imagenPath;
            } elseif ($request->has('eliminar_imagen_actual') && $user->imagen) {
                // Si se solicita eliminar la imagen actual
                $imagenPath = public_path('profile_images/' . $user->imagen);
                if (file_exists($imagenPath)) {
                    unlink($imagenPath);
                }
                $userData['imagen'] = null;
            }
            
            // Si se proporcionó una nueva contraseña, actualizarla
            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->input('password'));
            }
            
            $user->update($userData);
            
            // Actualizar institución
            $institucion->update([
                'codigo_centro' => $request->input('codigo_centro'),
                'tipo_institucion' => $request->input('tipo_institucion'),
                'direccion' => $request->input('direccion'),
                'ciudad' => $request->input('ciudad'),
                'codigo_postal' => $request->input('codigo_postal'),
                'representante_legal' => $request->input('representante_legal'),
                'cargo_representante' => $request->input('cargo_representante'),
                'verificada' => $request->has('verificada') ? true : false,
            ]);
            
            // Actualizar niveles educativos
            if ($request->has('niveles_educativos')) {
                // Eliminar relaciones anteriores
                DB::table('institucion_nivel_educativo')->where('institucion_id', $institucion->id)->delete();
                
                // Crear nuevas relaciones
                foreach ($request->niveles_educativos as $nivelId) {
                    DB::table('institucion_nivel_educativo')->insert([
                        'institucion_id' => $institucion->id,
                        'nivel_educativo_id' => $nivelId,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            } else {
                // Si no se proporcionan niveles, eliminar todas las relaciones
                DB::table('institucion_nivel_educativo')->where('institucion_id', $institucion->id)->delete();
            }
            
            // Registrar actividad
            $this->logUpdate($institucion, 'Se ha actualizado la institución: ' . $user->nombre);
            
            DB::commit();
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Institución actualizada correctamente',
                    'redirect' => route('admin.instituciones.index')
                ]);
            }
            
            return redirect()->route('admin.instituciones.index')
                ->with('success', 'Institución actualizada correctamente');
                
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al actualizar institución: ' . $e->getMessage());
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al actualizar la institución: ' . $e->getMessage(),
                    'errors' => ['general' => ['Error al actualizar la institución: ' . $e->getMessage()]]
                ], 500);
            }
            
            return redirect()->back()
                ->withErrors(['general' => 'Error al actualizar la institución: ' . $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Elimina una institución
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            
            $institucion = Institucion::with('user')->findOrFail($id);
            
            // Guardar el nombre para el registro
            $nombreInstitucion = $institucion->user->nombre;
            
            // Desactivar en lugar de eliminar
            $institucion->user()->update(['activo' => false]);
            
            // Registrar actividad
            $this->logDeletion($institucion, 'Se ha desactivado la institución: ' . $nombreInstitucion);
            
            DB::commit();
            
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Institución desactivada correctamente'
                ]);
            }
            
            return redirect()->route('admin.instituciones.index')
                ->with('success', 'Institución desactivada correctamente');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al desactivar la institución: ' . $e->getMessage()
                ], 500);
            }
            
            return redirect()->route('admin.instituciones.index')
                ->with('error', 'Error al desactivar la institución: ' . $e->getMessage());
        }
    }

    /**
     * Cambia el estado (activo/inactivo) de una institución
     */
    public function toggleEstado($id)
    {
        try {
            DB::beginTransaction();
            
            $institucion = Institucion::findOrFail($id);
            $user = $institucion->user;
            
            // Cambiar estado del usuario asociado
            $estadoAnterior = $user->activo;
            $nuevoEstado = !$estadoAnterior;
            
            $user->activo = $nuevoEstado;
            $user->save();
            
            // Registrar actividad
            $estadoTexto = $nuevoEstado ? 'activado' : 'desactivado';
            $this->logUpdate($institucion, 'Se ha ' . $estadoTexto . ' la institución: ' . $user->nombre);
            
            DB::commit();
            
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Estado de la institución actualizado correctamente',
                    'estado' => $user->activo
                ]);
            }
            
            return redirect()->route('admin.instituciones.index')
                ->with('success', 'Estado de la institución actualizado correctamente');
                
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error al cambiar estado de la institución: ' . $e->getMessage());
            
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al cambiar estado de la institución: ' . $e->getMessage()
                ], 500);
            }
            
            return redirect()->route('admin.instituciones.index')
                ->with('error', 'Error al cambiar estado de la institución: ' . $e->getMessage());
        }
    }

    /**
     * Cambia el estado de verificación de una institución
     */
    public function toggleVerificacion($id)
    {
        try {
            $institucion = Institucion::findOrFail($id);
            
            $estadoAnterior = $institucion->verificada;
            $institucion->verificada = !$estadoAnterior;
            $institucion->save();
            
            // Registrar actividad
            $estadoTexto = $institucion->verificada ? 'verificado' : 'desverificado';
            $this->logUpdate($institucion, 'Se ha ' . $estadoTexto . ' la institución: ' . $institucion->user->nombre);
            
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'verificada' => $institucion->verificada,
                    'message' => 'Estado de verificación actualizado correctamente'
                ]);
            }
            
            return redirect()->route('admin.instituciones.index')
                ->with('success', 'Estado de verificación actualizado correctamente');
        } catch (\Exception $e) {
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al actualizar estado de verificación: ' . $e->getMessage()
                ], 500);
            }
            
            return redirect()->route('admin.instituciones.index')
                ->with('error', 'Error al actualizar estado de verificación: ' . $e->getMessage());
        }
    }

    /**
     * Obtiene las categorías asociadas a una institución, organizadas por nivel educativo
     */
    public function getCategorias($id)
    {
        try {
            $institucion = Institucion::with(['nivelesEducativos', 'categorias' => function($query) {
                $query->with('nivelEducativo');
            }])->findOrFail($id);
            
            // Obtener todos los niveles educativos de la institución
            $nivelesEducativos = $institucion->nivelesEducativos;
            
            // Obtener todas las categorías disponibles organizadas por nivel educativo
            $todasCategorias = [];
            foreach ($nivelesEducativos as $nivel) {
                $categoriasPorNivel = Categoria::where('nivel_educativo_id', $nivel->id)
                    ->orderBy('nombre_categoria')
                    ->get(['id', 'nombre_categoria', 'nivel_educativo_id']);
                
                $todasCategorias[$nivel->id] = $categoriasPorNivel;
            }
            
            // Obtener las categorías actuales de la institución agrupadas por nivel educativo
            $categoriasInstitucion = DB::table('institucion_categoria as ic')
                ->join('categorias as c', 'ic.categoria_id', '=', 'c.id')
                ->join('niveles_educativos as ne', 'ic.nivel_educativo_id', '=', 'ne.id')
                ->where('ic.institucion_id', $id)
                ->select(
                    'ic.id as pivot_id',
                    'c.id',
                    'c.nombre_categoria as nombre',
                    'ic.nombre_personalizado',
                    'ic.descripcion',
                    'ic.activo',
                    'ic.nivel_educativo_id'
                )
                ->orderBy('ne.nombre_nivel')
                ->orderBy('c.nombre_categoria')
                ->get();

            // Organizar por nivel educativo
            $categoriasAgrupadas = [];
            foreach ($categoriasInstitucion as $categoria) {
                if (!isset($categoriasAgrupadas[$categoria->nivel_educativo_id])) {
                    $categoriasAgrupadas[$categoria->nivel_educativo_id] = [];
                }
                $categoriasAgrupadas[$categoria->nivel_educativo_id][] = $categoria;
            }
            
            return response()->json([
                'success' => true,
                'institucion' => [
                    'id' => $institucion->id,
                    'nombre' => $institucion->user->nombre,
                ],
                'niveles_educativos' => $nivelesEducativos,
                'categorias_por_nivel' => $categoriasAgrupadas,
                'todas_categorias' => $todasCategorias
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener categorías: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Actualiza las categorías asociadas a una institución
     */
    public function updateCategorias(Request $request, $id)
    {
        DB::beginTransaction();
        
        try {
            $institucion = Institucion::findOrFail($id);
            
            // Validar los datos
            $validator = Validator::make($request->all(), [
                'categorias' => 'nullable|array',
                'categorias.*.nivel_id' => 'required_with:categorias|exists:niveles_educativos,id',
                'categorias.*.categoria_id' => 'required_with:categorias|exists:categorias,id',
                'categorias.*.activo' => 'boolean',
                'eliminar_categorias' => 'nullable|array',
                'eliminar_categorias.*' => 'integer',
            ]);
            
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error de validación',
                    'errors' => $validator->errors()
                ], 422);
            }
            
            // Eliminar categorías si es necesario
            if ($request->has('eliminar_categorias') && is_array($request->eliminar_categorias)) {
                foreach ($request->eliminar_categorias as $pivotId) {
                    DB::table('institucion_categoria')
                        ->where('id', $pivotId)
                        ->where('institucion_id', $id)
                        ->delete();
                }
            }
            
            // Agregar o actualizar categorías
            if ($request->has('categorias') && is_array($request->categorias)) {
                foreach ($request->categorias as $categoria) {
                    // Verificar si ya existe esta relación
                    $existente = DB::table('institucion_categoria')
                        ->where('institucion_id', $id)
                        ->where('categoria_id', $categoria['categoria_id'])
                        ->where('nivel_educativo_id', $categoria['nivel_id'])
                        ->first();
                    
                    if ($existente) {
                        // Actualizar
                        DB::table('institucion_categoria')
                            ->where('id', $existente->id)
                            ->update([
                                'activo' => isset($categoria['activo']) ? $categoria['activo'] : true,
                                'updated_at' => now(),
                            ]);
                    } else {
                        // Insertar
                        DB::table('institucion_categoria')->insert([
                            'institucion_id' => $id,
                            'categoria_id' => $categoria['categoria_id'],
                            'nivel_educativo_id' => $categoria['nivel_id'],
                            'nombre_personalizado' => null,
                            'descripcion' => null,
                            'activo' => isset($categoria['activo']) ? $categoria['activo'] : true,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            }
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Categorías actualizadas correctamente',
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al actualizar categorías: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar categorías: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Cambia el estado de activación de una categoría para una institución
     */
    public function toggleCategoriaActiva($institucionId, $categoriaId)
    {
        try {
            $relacion = DB::table('institucion_categoria')
                ->where('id', $categoriaId)
                ->where('institucion_id', $institucionId)
                ->first();
                
            if (!$relacion) {
                return response()->json([
                    'success' => false,
                    'message' => 'Relación no encontrada'
                ], 404);
            }
            
            // Cambiar el estado activo
            $nuevoEstado = !$relacion->activo;
            
            DB::table('institucion_categoria')
                ->where('id', $categoriaId)
                ->update([
                    'activo' => $nuevoEstado,
                    'updated_at' => now()
                ]);
                
            return response()->json([
                'success' => true,
                'activo' => $nuevoEstado,
                'message' => 'Estado de categoría actualizado correctamente'
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error al cambiar estado de categoría: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al cambiar estado de la categoría: ' . $e->getMessage()
            ], 500);
        }
    }
} 