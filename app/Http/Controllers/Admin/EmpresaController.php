<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Models\Empresa;
use App\Models\User;
use App\Models\Rol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use App\Models\Publication;
use Illuminate\Support\Facades\Auth;

class EmpresaController extends BaseController
{
    /**
     * Muestra el listado de empresas
     */
    public function index()
    {
        $query = Empresa::with('user');

        // Aplicar filtro por nombre
        if (request()->has('nombre') && !empty(request()->nombre)) {
            $query->whereHas('user', function($q) {
                $q->where('nombre', 'like', '%' . request()->nombre . '%');
            });
        }

        // Aplicar filtro por CIF
        if (request()->has('cif') && !empty(request()->cif)) {
            $query->where('cif', 'like', '%' . request()->cif . '%');
        }

        // Aplicar filtro por estado
        if (request()->has('estado') && request()->estado !== '') {
            $query->whereHas('user', function($q) {
                $q->where('activo', request()->estado);
            });
        }

        // Aplicar filtro por ciudad
        if (request()->has('ciudad') && !empty(request()->ciudad)) {
            $query->whereHas('user', function($q) {
                $q->where('ciudad', request()->ciudad);
            });
        }

        // Obtener ciudades únicas para el selector
        $ciudades = User::whereHas('empresa')
                       ->whereNotNull('ciudad')
                       ->where('ciudad', '!=', '')
                       ->distinct()
                       ->pluck('ciudad')
                       ->sort()
                       ->values();

        $empresas = $query->orderBy('id', 'asc')->paginate(10);

        if (request()->ajax()) {
            // Generar la vista del panel
            $view = view('admin.empresas.index', compact('empresas', 'ciudades'))->render();
            
            // Extraer solo el contenedor de la tabla usando DOM
            $dom = new \DOMDocument();
            libxml_use_internal_errors(true); // Suprimir errores de HTML5
            $dom->loadHTML($view);
            libxml_clear_errors();
            
            $tablaContainer = $dom->getElementById('tabla-container');
            $tabla = $tablaContainer ? $dom->saveHTML($tablaContainer) : null;
            
            return response()->json([
                'tabla' => $tabla,
                'success' => true
            ]);
        }

        return view('admin.empresas.index', compact('empresas', 'ciudades'));
    }

    /**
     * Almacena una nueva empresa
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
            'cif' => 'required|string|max:255|unique:empresas,cif',
            'direccion' => 'required|string|max:255',
            'latitud' => 'nullable|numeric',
            'longitud' => 'nullable|numeric',
            'provincia' => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:500',
        ]);

        // Iniciar transacción
        DB::beginTransaction();

        try {
            // Obtener ID del rol Empresa
            $rolEmpresa = Rol::where('nombre_rol', 'Empresa')->first();

            if (!$rolEmpresa) {
                throw new \Exception('El rol Empresa no existe en el sistema');
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
                'descripcion' => $request->input('descripcion') ?? null,
                'role_id' => $rolEmpresa->id,
                'imagen' => $imagenPath,
            ]);

            // Crear empresa
            $empresa = Empresa::create([
                'id' => $user->id,
                'cif' => $request->input('cif'),
                'direccion' => $request->input('direccion'),
                'provincia' => $request->input('provincia') ?? null,
                'latitud' => $request->input('latitud') ?? 0,
                'longitud' => $request->input('longitud') ?? 0,
            ]);
            
            // Registrar actividad
            $this->logCreation($empresa, 'Se ha creado una nueva empresa: ' . $user->nombre);

            DB::commit();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Empresa creada correctamente',
                    'empresa' => $empresa
                ]);
            }

            return redirect()->route('admin.empresas.index')
                ->with('success', 'Empresa creada correctamente');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al crear empresa: ' . $e->getMessage());

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al crear la empresa: ' . $e->getMessage(),
                    'errors' => ['general' => ['Error al crear la empresa: ' . $e->getMessage()]]
                ], 500);
            }

            return redirect()->back()
                ->withErrors(['general' => 'Error al crear la empresa: ' . $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Obtiene los datos de una empresa para editar
     */
    public function edit($id)
    {
        $empresa = Empresa::with('user')->findOrFail($id);

        if (request()->ajax()) {
            return response()->json([
                'empresa' => $empresa
            ]);
        }

        return view('admin.empresas.edit', compact('empresa'));
    }

    /**
     * Actualiza una empresa
     */
    public function update(Request $request, $id)
    {
        $empresa = Empresa::findOrFail($id);
        $user = $empresa->user;

        // Si la solicitud solo contiene el campo 'activo', es una operación de activar/desactivar
        if ($request->has('activo') && count(array_filter($request->except(['_method', '_token']))) <= 1) {
            try {
                DB::beginTransaction();
                
                // Actualizar estado de la empresa
                $empresa->update([
                    'activo' => $request->activo
                ]);
                
                // Actualizar estado del usuario asociado
                $user->update([
                    'activo' => $request->activo
                ]);
                
                // Registrar actividad
                $estadoTexto = $request->activo ? 'activado' : 'desactivado';
                $this->logUpdate($empresa, 'Se ha ' . $estadoTexto . ' la empresa: ' . $user->nombre);
                
                DB::commit();
                
                $mensaje = $request->activo ? 'Empresa activada exitosamente' : 'Empresa desactivada exitosamente';
                
                if ($request->ajax()) {
                    return response()->json([
                        'success' => true,
                        'message' => $mensaje
                    ]);
                }
                
                return redirect()->route('admin.empresas.index')
                    ->with('success', $mensaje);
            } catch (\Exception $e) {
                DB::rollBack();
                
                if ($request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Error al actualizar el estado de la empresa: ' . $e->getMessage()
                    ], 500);
                }
                
                return redirect()->back()
                    ->with('error', 'Error al actualizar el estado de la empresa: ' . $e->getMessage())
                    ->withInput();
            }
        }

        $rules = [
            'nombre' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:user,email,'.$user->id,
            'dni' => 'required|string|max:255|unique:user,dni,'.$user->id,
            'telefono' => 'required|string|max:15',
            'cif' => 'required|string|max:255|unique:empresas,cif,'.$empresa->id,
            'direccion' => 'required|string|max:255',
            'latitud' => 'nullable|numeric',
            'longitud' => 'nullable|numeric',
            'provincia' => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:500',
        ];

        if ($request->filled('password')) {
            $rules['password'] = 'string|min:8';
            $rules['password_confirmation'] = 'required|same:password';
        }

        $validator = Validator::make($request->all(), $rules);

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
                'activo' => $request->has('activo'),
                'sitio_web' => $request->input('sitio_web') ?? null,
                'telefono' => $request->input('telefono') ?? null,
                'descripcion' => $request->input('descripcion') ?? null,
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
            
            // Actualizar contraseña si se proporciona
            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->input('password'));
            }

            $user->update($userData);

            // Actualizar empresa
            $empresa->update([
                'cif' => $request->input('cif'),
                'direccion' => $request->input('direccion'),
                'provincia' => $request->input('provincia'),
                'latitud' => $request->input('latitud') ?? 0,
                'longitud' => $request->input('longitud') ?? 0,
                'activo' => $request->has('activo'),
            ]);

            // Registrar actividad
            $this->logUpdate($empresa, 'Se ha actualizado la empresa: ' . $user->nombre);

            DB::commit();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Empresa actualizada correctamente'
                ]);
            }

            return redirect()->route('admin.empresas.index')
                ->with('success', 'Empresa actualizada correctamente');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al actualizar empresa: ' . $e->getMessage());

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al actualizar la empresa: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()
                ->withErrors(['general' => 'Error al actualizar la empresa: ' . $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Desactiva una empresa en lugar de eliminarla
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            
            $empresa = Empresa::with('user')->findOrFail($id);
            
            // Guardar nombre de la empresa para el registro
            $nombreEmpresa = $empresa->user->nombre;
            
            // Desactivar la empresa en lugar de eliminarla físicamente
            $empresa->update(['activo' => false]);
            
            // También desactivar el usuario asociado
            if ($empresa->user) {
                $empresa->user->update(['activo' => false]);
            }
            
            // Registrar actividad
            $this->logDeletion($empresa, 'Se ha desactivado la empresa: ' . $nombreEmpresa);
            
            DB::commit();
            
            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Empresa desactivada correctamente'
                ]);
            }
            
            return redirect()->route('admin.empresas.index')
                ->with('success', 'Empresa desactivada correctamente');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al desactivar la empresa: ' . $e->getMessage()
                ], 500);
            }
            
            return redirect()->route('admin.empresas.index')
                ->with('error', 'Error al desactivar la empresa: ' . $e->getMessage());
        }
    }

    /**
     * Elimina una empresa mediante SQL directo
     */
    public function destroySQL($id)
    {
        try {
            // Registrar la solicitud para debug
            \Log::info('Intento de eliminación SQL para empresa ID: ' . $id);

            // Iniciar transacción
            DB::beginTransaction();

            // Buscar la empresa para obtener la imagen antes de eliminarla
            $empresa = Empresa::with('user')->find($id);

            // Eliminar la imagen si existe
            if ($empresa && $empresa->user && $empresa->user->imagen) {
                $imagenPath = public_path('profile_images/' . $empresa->user->imagen);
                if (file_exists($imagenPath)) {
                    unlink($imagenPath);
                }
            }

            // Primero eliminar registros relacionados en empresa
            $affectedEmpresa = DB::delete('DELETE FROM empresas WHERE id = ?', [$id]);

            if ($affectedEmpresa > 0) {
                // Luego eliminar el usuario
                $affectedUser = DB::delete('DELETE FROM user WHERE id = ?', [$id]);

                if ($affectedUser == 0) {
                    throw new \Exception('Se eliminó la empresa pero no se encontró el usuario asociado');
                }

                DB::commit();
                \Log::info('Empresa y usuario eliminados correctamente mediante SQL directo. ID: ' . $id);

                if (request()->ajax()) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Empresa eliminada correctamente mediante SQL directo'
                    ]);
                }

                return redirect()->route('admin.empresas.index')
                    ->with('success', 'Empresa eliminada correctamente mediante SQL directo');
            } else {
                DB::rollBack();
                \Log::warning('No se encontró la empresa para eliminar. ID: ' . $id);

                if (request()->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'No se encontró la empresa para eliminar'
                    ]);
                }

                return redirect()->route('admin.empresas.index')
                    ->with('error', 'No se encontró la empresa para eliminar');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error al eliminar empresa mediante SQL: ' . $e->getMessage());

            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al eliminar: ' . $e->getMessage()
                ]);
            }

            return redirect()->route('admin.empresas.index')
                ->with('error', 'Error al eliminar: ' . $e->getMessage());
        }
    }

    public function getActiveOffers(Request $request)
    {
        $query = Publication::where('activa', true)
            ->where('empresa_id', Auth::user()->empresa->id);

        // Aplicar filtros
        if ($request->titulo) {
            $query->where('titulo', 'like', '%' . $request->titulo . '%');
        }

        if ($request->horario) {
            $query->where('horario', $request->horario);
        }

        if ($request->categoria_id) {
            $query->where('categoria_id', $request->categoria_id);
        }

        // Ordenar
        $sortField = $request->sort_field ?? 'created_at';
        $sortDirection = $request->sort_direction ?? 'desc';
        $query->orderBy($sortField, $sortDirection);

        // Paginar
        $perPage = $request->per_page ?? 4;
        $publications = $query->with('categoria')
            ->withCount('solicitudes')
            ->paginate($perPage);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'data' => $publications->items(),
                'pagination' => [
                    'total' => $publications->total(),
                    'per_page' => $publications->perPage(),
                    'current_page' => $publications->currentPage(),
                    'last_page' => $publications->lastPage(),
                    'from' => $publications->firstItem(),
                    'to' => $publications->lastItem()
                ]
            ]);
        }

        return view('empresa.active-offers', compact('publications'));
    }
}
