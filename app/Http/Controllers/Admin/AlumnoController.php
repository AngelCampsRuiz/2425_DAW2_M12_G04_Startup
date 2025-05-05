<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Alumno;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AlumnoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $alumnos = User::where('role_id', 3)
            ->select('id', 'nombre', 'email', 'dni', 'telefono', 'ciudad', 'activo', 'imagen', 'created_at')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        if ($request->ajax()) {
            return response()->json([
                'tabla' => view('admin.alumnos.tabla', compact('alumnos'))->render(),
                'pagination' => $alumnos->links()->toHtml()
            ]);
        }

        return view('admin.alumnos.index', compact('alumnos'));
    }

    /**
     * Store a newly created resource in storage.
     */
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
            'imagen' => ['nullable', 'image', 'max:2048'] // 2MB máximo
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
                'role_id' => 3,
                'activo' => true,
                'imagen' => $imagenPath
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Alumno creado correctamente'
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
                'message' => 'Error al crear el alumno: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $alumno = User::where('role_id', 3)->findOrFail($id);

        return response()->json([
            'alumno' => [
                'id' => $alumno->id,
                'nombre' => $alumno->nombre,
                'email' => $alumno->email,
                'dni' => $alumno->dni,
                'telefono' => $alumno->telefono,
                'ciudad' => $alumno->ciudad,
                'fecha_nacimiento' => $alumno->fecha_nacimiento,
                'sitio_web' => $alumno->sitio_web,
                'descripcion' => $alumno->descripcion,
                'activo' => $alumno->activo
            ]
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $user = User::where('role_id', 3)->findOrFail($id);

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
            'activo' => ['required', 'boolean'],
            'imagen' => ['nullable', 'image', 'max:2048'] // 2MB máximo
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
            $user->activo = $request->activo;
            $user->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Alumno actualizado correctamente'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el alumno: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $user = User::where('role_id', 3)->findOrFail($id);
            
            // Eliminar la imagen si existe
            if ($user->imagen) {
                $imagenPath = public_path('public/profile_images/' . $user->imagen);
                if (file_exists($imagenPath)) {
                    unlink($imagenPath);
                }
            }
            
            $user->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Alumno eliminado correctamente'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el alumno: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage using direct SQL.
     */
    public function destroySQL($id)
    {
        try {
            DB::beginTransaction();

            DB::statement("DELETE FROM user WHERE id = ? AND role_id = 3", [$id]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Alumno eliminado correctamente mediante SQL'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el alumno mediante SQL: ' . $e->getMessage()
            ], 500);
        }
    }
} 