<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use App\Models\User;
use App\Models\Empresa;
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
                'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096',
            ];

            // Añadir reglas específicas según el rol
            if ($user->role_id == 2) {
                $rules['cif'] = 'nullable|string|max:9';
            } else {
                $rules['dni'] = 'nullable|string|max:9';
            }

            $validatedData = $request->validate($rules);

            // Manejar la subida de la imagen de perfil
            if ($request->hasFile('imagen')) {
                $imageName = time() . '_' . $request->file('imagen')->getClientOriginalName();
                $request->file('imagen')->move(public_path('profile_images'), $imageName);

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

                if ($user->banner) {
                    $oldBannerPath = public_path('profile_banners/' . $user->banner);
                    if (file_exists($oldBannerPath)) {
                        unlink($oldBannerPath);
                    }
                }

                $validatedData['banner'] = $bannerName;
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
                'show_ciudad' => $request->boolean('show_ciudad'),
                'show_direccion' => $request->boolean('show_direccion'),
                'show_web' => $request->boolean('show_web'),
            ];

            // Solo incluir show_cif si es una empresa
            if ($user->role_id == 2) {
                $updateData['show_cif'] = $request->boolean('show_cif');
            }

            if (isset($validatedData['imagen'])) {
                $updateData['imagen'] = $validatedData['imagen'];
            }

            if (isset($validatedData['banner'])) {
                $updateData['banner'] = $validatedData['banner'];
            }

            // Si es una empresa
            if ($user->role_id == 2) {
                // Crear o actualizar la empresa usando el ID del usuario
                $empresa = Empresa::firstOrNew(['id' => $user->id]);
                $empresa->cif = $validatedData['cif'] ?? $empresa->cif;
                $empresa->show_cif = $request->boolean('show_cif');
                $empresa->save();
            } elseif (isset($validatedData['dni'])) {
                $updateData['dni'] = $validatedData['dni'];
            }
            
            $user->fill($updateData);
            $user->save();

            DB::commit();

            // Recargar el usuario con sus relaciones
            $user = $user->load('empresa');

            return response()->json([
                'success' => true,
                'message' => 'Perfil actualizado correctamente',
                'user' => $user
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