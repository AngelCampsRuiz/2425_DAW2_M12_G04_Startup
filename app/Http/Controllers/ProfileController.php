<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function update(Request $request)
    {
        $user = Auth::user();
        
        // Validación de campos
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:1000',
            'telefono' => 'nullable|string|max:20',
            'ciudad' => 'nullable|string|max:100',
            'dni' => 'nullable|string|max:20',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'cv_pdf' => 'nullable|file|mimes:pdf|max:5120',
            'show_telefono' => 'nullable|boolean',
            'show_dni' => 'nullable|boolean',
            'show_ciudad' => 'nullable|boolean',
            'show_direccion' => 'nullable|boolean',
            'show_web' => 'nullable|boolean',
        ]);

        try {
            // Actualizar campos básicos
            $user->nombre = $request->nombre;
            $user->descripcion = $request->descripcion;
            $user->telefono = $request->telefono;
            $user->ciudad = $request->ciudad;
            $user->dni = $request->dni;

            // Actualizar campos de visibilidad
            $user->show_telefono = $request->has('show_telefono');
            $user->show_dni = $request->has('show_dni');
            $user->show_ciudad = $request->has('show_ciudad');
            $user->show_direccion = $request->has('show_direccion');
            $user->show_web = $request->has('show_web');

            // Manejar la imagen de perfil
            if ($request->hasFile('imagen')) {
                if ($user->imagen && file_exists(public_path('public/profile_images/' . $user->imagen))) {
                    unlink(public_path('public/profile_images/' . $user->imagen));
                }
                
                $file = $request->file('imagen');
                $filename = time() . '_' . $file->getClientOriginalName();
                
                if (!file_exists(public_path('public/profile_images'))) {
                    mkdir(public_path('public/profile_images'), 0755, true);
                }
                
                $file->move(public_path('public/profile_images'), $filename);
                $user->imagen = $filename;
            }

            // Manejar el CV para estudiantes
            if ($user->role_id == 3 && $request->hasFile('cv_pdf')) {
                if (!file_exists(public_path('cv'))) {
                    mkdir(public_path('cv'), 0755, true);
                }

                if ($user->estudiante->cv_pdf && file_exists(public_path('cv/' . $user->estudiante->cv_pdf))) {
                    unlink(public_path('cv/' . $user->estudiante->cv_pdf));
                }
                
                $file = $request->file('cv_pdf');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('cv'), $filename);
                
                $user->estudiante->cv_pdf = $filename;
                $user->estudiante->save();
            }

            // Guardar los cambios del usuario
            $user->save();

            // Calcular el nuevo porcentaje de completado
            $total_campos = 0;
            $campos_completados = 0;
            
            // Campos obligatorios
            $campos_obligatorios = ['nombre', 'email'];
            $total_campos += count($campos_obligatorios);
            foreach($campos_obligatorios as $campo) {
                if(!empty($user->$campo)) $campos_completados++;
            }
            
            // Campos opcionales
            $campos_opcionales = ['descripcion', 'telefono', 'ciudad', 'dni', 'imagen'];
            $total_campos += count($campos_opcionales);
            foreach($campos_opcionales as $campo) {
                if(!empty($user->$campo)) $campos_completados++;
            }
            
            // Si es estudiante, añadir CV
            if($user->role_id == 3) {
                $total_campos++;
                if(!empty($user->estudiante->cv_pdf)) $campos_completados++;
            }
            
            $porcentaje = round(($campos_completados / $total_campos) * 100);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Perfil actualizado correctamente',
                    'porcentaje' => $porcentaje,
                    'user' => $user->fresh()
                ]);
            }

            return redirect()->back()->with('success', 'Perfil actualizado correctamente');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al actualizar el perfil: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()->with('error', 'Error al actualizar el perfil: ' . $e->getMessage());
        }
    }
} 