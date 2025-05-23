<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    /**
     * Muestra el perfil de un usuario
     */
    public function show(User $user)
    {
        $user->load(['tutor', 'estudiante', 'empresa']);

        // Obtener las valoraciones recibidas por el usuario
        $valoracionesRecibidas = $user->valoracionesRecibidas()
            ->with(['emisor', 'convenio'])
            ->orderBy('fecha_valoracion', 'desc')
            ->get();

        // Obtener las valoraciones emitidas por el usuario
        $valoracionesEmitidas = $user->valoracionesEmitidas()
            ->with(['receptor', 'convenio'])
            ->orderBy('fecha_valoracion', 'desc')
            ->get();

        $data = [
            'user' => $user,
            'tutor' => $user->tutor,
            'estudiante' => $user->estudiante,
            'empresa' => $user->empresa,
            'valoracionesRecibidas' => $valoracionesRecibidas,
            'valoracionesEmitidas' => $valoracionesEmitidas
        ];

        if ($user->empresa) {
            $data['experiencias'] = $user->empresa->experiencias()->with('alumno.user')->get();
        }

        return view('profile', $data);
    }

    public function update(Request $request)
    {
        try {
            DB::beginTransaction();

            $user = Auth::user();

            $rules = [
                'nombre' => 'required|string|max:255',
                'email' => 'required|email|unique:user,email,' . $user->id,
                'descripcion' => 'nullable|string|max:1000',
                'telefono' => 'nullable|string|max:20',
                'ciudad' => 'nullable|string|max:255',
                'sitio_web' => 'nullable|url|max:255',
                'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
                'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
                'cv_pdf' => 'nullable|mimes:pdf|max:5120',
            ];

            $messages = [
                'imagen.image' => 'El archivo debe ser una imagen válida (jpeg, png, jpg, gif, webp).',
                'imagen.mimes' => 'El formato de imagen debe ser: jpeg, png, jpg, gif o webp.',
                'imagen.max' => 'La imagen no debe pesar más de 2MB.',
                'banner.image' => 'El archivo debe ser una imagen válida (jpeg, png, jpg, gif, webp).',
                'banner.mimes' => 'El formato de banner debe ser: jpeg, png, jpg, gif o webp.',
                'banner.max' => 'El banner no debe pesar más de 4MB.',
                'cv_pdf.mimes' => 'El archivo debe ser un PDF.',
                'cv_pdf.max' => 'El CV no debe pesar más de 5MB.',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            $validatedData = $validator->validated();

            // Manejar la subida de la imagen de perfil
            if ($request->hasFile('imagen')) {
                $imageName = time() . '_' . $request->file('imagen')->getClientOriginalName();
                $request->file('imagen')->move(public_path('profile_images'), $imageName);

                // Eliminar la imagen anterior si existe
                if ($user->imagen) {
                    $oldImagePath = public_path('profile_images/' . $user->imagen);
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }

                $validatedData['imagen'] = $imageName;
            }

            // Manejar la subida del banner
            if ($request->hasFile('banner')) {
                $bannerName = time() . '_banner_' . $request->file('banner')->getClientOriginalName();
                $request->file('banner')->move(public_path('profile_banners'), $bannerName);

                // Eliminar el banner anterior si existe
                if ($user->banner) {
                    $oldBannerPath = public_path('profile_banners/' . $user->banner);
                    if (file_exists($oldBannerPath)) {
                        unlink($oldBannerPath);
                    }
                }

                $validatedData['banner'] = $bannerName;
            }

            // Manejar la subida del CV para estudiantes
            if ($user->role_id == 3 && $request->hasFile('cv_pdf')) {
                $cvName = time() . '_' . $request->file('cv_pdf')->getClientOriginalName();

                // Asegurarse de que la carpeta cv existe
                if (!file_exists(public_path('cv'))) {
                    mkdir(public_path('cv'), 0777, true);
                }

                // Mover el CV a la carpeta public/cv
                $request->file('cv_pdf')->move(public_path('cv'), $cvName);

                // Eliminar el CV anterior si existe
                if ($user->estudiante && $user->estudiante->cv_pdf) {
                    $oldCvPath = public_path('cv/' . $user->estudiante->cv_pdf);
                    if (file_exists($oldCvPath)) {
                        unlink($oldCvPath);
                    }
                }

                // Actualizar el nombre del CV en la base de datos
                $user->estudiante()->update([
                    'cv_pdf' => $cvName
                ]);
            }

            // Actualizar datos básicos del usuario
            $updateData = [
                'nombre' => $validatedData['nombre'],
                'email' => $validatedData['email'],
                'descripcion' => $validatedData['descripcion'] ?? null,
                'telefono' => $validatedData['telefono'] ?? null,
                'ciudad' => $validatedData['ciudad'] ?? null,
                'sitio_web' => $validatedData['sitio_web'] ?? null,
                'show_telefono' => $request->boolean('show_telefono'),
                'show_cif' => $request->boolean('show_cif'),
                'show_ciudad' => $request->boolean('show_ciudad'),
                'show_direccion' => $request->boolean('show_direccion'),
                'show_web' => $request->boolean('show_web'),
            ];

            if (isset($validatedData['imagen'])) {
                $updateData['imagen'] = $validatedData['imagen'];
            }

            if (isset($validatedData['banner'])) {
                $updateData['banner'] = $validatedData['banner'];
            }

            // Si es una empresa, actualizar el CIF y show_cif
            if ($user->role_id == 2 && isset($validatedData['cif'])) {
                $user->empresa()->update([
                    'cif' => $validatedData['cif'],
                    'show_cif' => $request->boolean('show_cif')
                ]);
            } elseif (isset($validatedData['dni'])) {
                $updateData['dni'] = $validatedData['dni'];
            }

            // Remover show_cif del updateData si existe
            unset($updateData['show_cif']);

            $user->update($updateData);

            // Calcular el progreso del perfil
            $total_campos = 0;
            $campos_completados = 0;

            // Campos obligatorios
            $campos_obligatorios = ['nombre', 'email'];
            $total_campos += count($campos_obligatorios);
            foreach($campos_obligatorios as $campo) {
                if(!empty($user->$campo)) {
                    $campos_completados++;
                }
            }

            // Campos opcionales
            $campos_opcionales = [
                'descripcion' => 'Descripción personal',
                'telefono' => 'Teléfono',
                'ciudad' => 'Ciudad',
                'dni' => 'DNI',
                'imagen' => 'Foto de perfil'
            ];
            $total_campos += count($campos_opcionales);
            foreach($campos_opcionales as $campo => $nombre) {
                if(!empty($user->$campo)) {
                    $campos_completados++;
                }
            }

            // Si es estudiante, añadir CV
            if($user->role_id == 3) {
                $total_campos++;
                if(!empty($user->estudiante->cv_pdf)) {
                    $campos_completados++;
                }
            }

            $porcentaje = round(($campos_completados / $total_campos) * 100);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Perfil actualizado correctamente',
                'user' => $user->fresh()->load('empresa'),
                'porcentaje' => $porcentaje
            ]);

        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el perfil: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updateLocation(Request $request)
    {
        try {
            $validated = $request->validate([
                'lat' => 'required|numeric',
                'lng' => 'required|numeric',
                'direccion' => 'required|string|max:255',
                'ciudad' => 'required|string|max:255',
            ]);

            $user = auth()->user();

            // Actualizar los campos de ubicación
            $user->update([
                'lat' => $validated['lat'],
                'lng' => $validated['lng'],
                'direccion' => $validated['direccion'],
                'ciudad' => $validated['ciudad'],
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Ubicación actualizada correctamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar la ubicación: ' . $e->getMessage()
            ], 500);
        }
    }

    public function saved()
    {
        $user = auth()->user();

        // Obtén las publicaciones guardadas activas
        $saved = $user->favoritePublications()
            ->where('activa', 1)
            ->with('empresa')
            ->get();

        return view('publication.saved', compact('saved', 'user'));
    }

    public function savedPublication($id)
    {
        $user = auth()->user();
        $user->favoritePublications()->attach($id);

        return response()->json([
            'success' => true,
            'message' => 'Publicación guardada correctamente'
        ]);
    }

    public function deleteSavedPublication($id)
    {
        $user = auth()->user();
        $user->favoritePublications()->detach($id);

        return response()->json([
            'success' => true,
            'message' => 'Publicación eliminada de guardados correctamente'
        ]);
    }

}