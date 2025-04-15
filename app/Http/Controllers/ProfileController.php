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
            // Eliminar la imagen anterior si existe
            if ($user->imagen && file_exists(public_path('public/profile_images/' . $user->imagen))) {
                unlink(public_path('public/profile_images/' . $user->imagen));
            }
            
            // Obtener el archivo
            $file = $request->file('imagen');
            
            // Generar un nombre único para el archivo
            $filename = time() . '_' . $file->getClientOriginalName();
            
            // Crear el directorio si no existe
            if (!file_exists(public_path('public/profile_images'))) {
                mkdir(public_path('public/profile_images'), 0755, true);
            }
            
            // Guardar el archivo en la carpeta public/profile_images
            $file->move(public_path('public/profile_images'), $filename);
            
            // Guardar solo el nombre del archivo en la base de datos
            $user->imagen = $filename;
        }

        // Manejar el CV para estudiantes
        if ($user->role_id == 3 && $request->hasFile('cv_pdf')) {
            // Crear el directorio si no existe
            if (!file_exists(public_path('cv'))) {
                mkdir(public_path('cv'), 0755, true);
            }

            // Eliminar el CV anterior si existe
            if ($user->estudiante->cv_pdf && file_exists(public_path('cv/' . $user->estudiante->cv_pdf))) {
                unlink(public_path('cv/' . $user->estudiante->cv_pdf));
            }
            
            // Obtener el archivo
            $file = $request->file('cv_pdf');
            
            // Generar un nombre único para el archivo
            $filename = time() . '_' . $file->getClientOriginalName();
            
            // Guardar el archivo
            $file->move(public_path('cv'), $filename);
            
            // Actualizar el CV en la base de datos
            $user->estudiante->cv_pdf = $filename;
            $user->estudiante->save();
        }

        // Manejar información específica de empresa
        if ($user->role_id == 2) {
            $user->empresa->direccion = $request->direccion;
            $user->empresa->sitio_web = $request->sitio_web;

            if ($request->hasFile('logo')) {
                if ($user->empresa->logo_url) {
                    Storage::delete('public/' . $user->empresa->logo_url);
                }
                $path = $request->file('logo')->store('company_logos', 'public');
                $user->empresa->logo_url = $path;
            }

            $user->empresa->save();
        }

        // Guardar los cambios del usuario
        $user->save();

        return redirect()->back()->with('success', 'Perfil actualizado correctamente');
    }
} 