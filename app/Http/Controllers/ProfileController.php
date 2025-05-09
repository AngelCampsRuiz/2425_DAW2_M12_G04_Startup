<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

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
        $user = auth()->user();

        $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|unique:user,email,' . $user->id,
            'descripcion' => 'nullable|string|max:1000',
            'telefono' => 'nullable|string|max:20',
            'ciudad' => 'nullable|string|max:100',
            'dni' => 'nullable|string|max:20',
            'sitio_web' => 'nullable|url|max:255',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096',
            'show_telefono' => 'boolean',
            'show_dni' => 'boolean',
            'show_ciudad' => 'boolean',
            'show_direccion' => 'boolean',
            'show_web' => 'boolean',
        ]);

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

            $user->imagen = $imageName;
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

            $user->banner = $bannerName;
        }

        $user->update([
            'nombre' => $request->nombre,
            'email' => $request->email,
            'descripcion' => $request->descripcion,
            'telefono' => $request->telefono,
            'ciudad' => $request->ciudad,
            'dni' => $request->dni,
            'sitio_web' => $request->sitio_web,
            'show_telefono' => $request->has('show_telefono'),
            'show_dni' => $request->has('show_dni'),
            'show_ciudad' => $request->has('show_ciudad'),
            'show_direccion' => $request->has('show_direccion'),
            'show_web' => $request->has('show_web'),
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Perfil actualizado correctamente',
                'user' => $user,
                // Puedes agregar más datos si tu JS los necesita
            ]);
        } else {
            return redirect()->back()->with('success', 'Perfil actualizado correctamente');
        }
    }

    public function updateLocation(Request $request)
    {
        try {
            $user = auth()->user();
            $user->update([
                'lat' => $request->lat,
                'lng' => $request->lng,
                'direccion' => $request->direccion,
                'ciudad' => $request->ciudad
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