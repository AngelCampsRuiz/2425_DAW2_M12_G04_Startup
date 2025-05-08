<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProfesorController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role_id', 4);

        // Aplicar filtro por nombre
        if ($request->has('nombre') && !empty($request->nombre)) {
            $query->where('nombre', 'like', '%' . $request->nombre . '%');
        }

        // Aplicar filtro por email
        if ($request->has('email') && !empty($request->email)) {
            $query->where('email', 'like', '%' . $request->email . '%');
        }

        // Aplicar filtro por DNI
        if ($request->has('dni') && !empty($request->dni)) {
            $query->where('dni', 'like', '%' . $request->dni . '%');
        }

        // Aplicar filtro por ciudad
        if ($request->has('ciudad') && !empty($request->ciudad)) {
            $query->where('ciudad', $request->ciudad);
        }

        // Aplicar filtro por estado
        if ($request->has('estado') && $request->estado !== '') {
            $query->where('activo', $request->estado);
        }

        // Obtener ciudades únicas para el selector
        $ciudades = User::where('role_id', 4)
                       ->whereNotNull('ciudad')
                       ->where('ciudad', '!=', '')
                       ->distinct()
                       ->pluck('ciudad')
                       ->sort()
                       ->values();

        $profesores = $query->select('id', 'nombre', 'email', 'dni', 'telefono', 'ciudad', 'activo', 'imagen', 'created_at')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        if ($request->ajax()) {
            return response()->json([
                'tabla' => view('admin.profesores.tabla', compact('profesores'))->render(),
                'pagination' => $profesores->links()->toHtml()
            ]);
        }

        return view('admin.profesores.index', compact('profesores', 'ciudades'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:user'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'dni' => ['required', 'string', 'max:20', 'unique:user'],
            'telefono' => ['nullable', 'string', 'max:20'],
            'ciudad' => ['nullable', 'string', 'max:100'],
            'fecha_nacimiento' => ['nullable', 'date'],
            'sitio_web' => ['nullable', 'url', 'max:255'],
            'descripcion' => ['nullable', 'string', 'max:1000'],
            'imagen' => ['nullable', 'image']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            // Procesar imagen si se proporciona
            $imagenPath = null;
            if ($request->hasFile('imagen')) {
                $imagen = $request->file('imagen');
                $nombreImagen = time() . '_' . $imagen->getClientOriginalName();
                $imagen->move(public_path('public/profile_images'), $nombreImagen);
                $imagenPath = $nombreImagen;
            }

            $user = User::create([
                'nombre' => $request->nombre,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'dni' => $request->dni,
                'telefono' => $request->telefono,
                'ciudad' => $request->ciudad,
                'fecha_nacimiento' => $request->fecha_nacimiento,
                'sitio_web' => $request->sitio_web,
                'descripcion' => $request->descripcion,
                'role_id' => 4,
                'activo' => true,
                'imagen' => $imagenPath
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Profesor creado correctamente'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            
            // Si se subió una imagen, eliminarla
            if (isset($imagenPath)) {
                $imagenPath = public_path('public/profile_images/' . $imagenPath);
                if (file_exists($imagenPath)) {
                    unlink($imagenPath);
                }
            }
            
            return response()->json([
                'success' => false,
                'message' => 'Error al crear el profesor: ' . $e->getMessage()
            ], 500);
        }
    }

    public function edit($id)
    {
        $profesor = User::where('role_id', 4)->findOrFail($id);

        return response()->json([
            'profesor' => [
                'id' => $profesor->id,
                'nombre' => $profesor->nombre,
                'email' => $profesor->email,
                'dni' => $profesor->dni,
                'telefono' => $profesor->telefono,
                'ciudad' => $profesor->ciudad,
                'fecha_nacimiento' => $profesor->fecha_nacimiento,
                'sitio_web' => $profesor->sitio_web,
                'descripcion' => $profesor->descripcion,
                'activo' => $profesor->activo,
                'imagen' => $profesor->imagen
            ]
        ]);
    }

    public function update(Request $request, $id)
    {
        $user = User::where('role_id', 4)->findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nombre' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('user')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'dni' => ['required', 'string', 'max:20', Rule::unique('user')->ignore($user->id)],
            'telefono' => ['nullable', 'string', 'max:20'],
            'ciudad' => ['nullable', 'string', 'max:100'],
            'fecha_nacimiento' => ['nullable', 'date'],
            'sitio_web' => ['nullable', 'url', 'max:255'],
            'descripcion' => ['nullable', 'string', 'max:1000'],
            'activo' => ['nullable', 'boolean'],
            'imagen' => ['nullable', 'image']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            // Procesar imagen si se proporciona una nueva
            if ($request->hasFile('imagen')) {
                // Eliminar imagen anterior si existe
                if ($user->imagen) {
                    $imagenPath = public_path('public/profile_images/' . $user->imagen);
                    if (file_exists($imagenPath)) {
                        unlink($imagenPath);
                    }
                }
                
                $imagen = $request->file('imagen');
                $nombreImagen = time() . '_' . $imagen->getClientOriginalName();
                $imagen->move(public_path('public/profile_images'), $nombreImagen);
                $user->imagen = $nombreImagen;
            } elseif ($request->has('eliminar_imagen_actual') && $request->eliminar_imagen_actual == '1') {
                // Eliminar la imagen actual si se ha solicitado
                if ($user->imagen) {
                    $imagenPath = public_path('public/profile_images/' . $user->imagen);
                    if (file_exists($imagenPath)) {
                        unlink($imagenPath);
                    }
                }
                $user->imagen = null;
            }

            $user->nombre = $request->nombre;
            $user->email = $request->email;
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }
            $user->dni = $request->dni;
            $user->telefono = $request->telefono;
            $user->ciudad = $request->ciudad;
            $user->fecha_nacimiento = $request->fecha_nacimiento;
            $user->sitio_web = $request->sitio_web;
            $user->descripcion = $request->descripcion;
            $user->activo = true;
            $user->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Profesor actualizado correctamente'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el profesor: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            
            $profesor = User::where('role_id', 4)->findOrFail($id);
            
            // Eliminar imagen si existe
            if ($profesor->imagen) {
                $imagenPath = public_path('public/profile_images/' . $profesor->imagen);
                if (file_exists($imagenPath)) {
                    unlink($imagenPath);
                }
            }
            
            $profesor->delete();
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Profesor eliminado correctamente'
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el profesor: ' . $e->getMessage()
            ], 500);
        }
    }

    public function eliminarSQL($id)
    {
        try {
            DB::beginTransaction();
            
            $profesor = User::where('role_id', 4)->findOrFail($id);
            
            // Eliminar imagen si existe
            if ($profesor->imagen) {
                $imagenPath = public_path('public/profile_images/' . $profesor->imagen);
                if (file_exists($imagenPath)) {
                    unlink($imagenPath);
                }
            }
            
            // Eliminar directamente de la base de datos
            DB::table('user')->where('id', $id)->where('role_id', 4)->delete();
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Profesor eliminado correctamente'
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el profesor: ' . $e->getMessage()
            ], 500);
        }
    }
} 