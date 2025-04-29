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

    public function update(UpdateProfileRequest $request)
    {
        $user = Auth::user();
        
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

                if ($user->estudiante && $user->estudiante->cv_pdf && file_exists(public_path('cv/' . $user->estudiante->cv_pdf))) {
                    unlink(public_path('cv/' . $user->estudiante->cv_pdf));
                }
                
                $file = $request->file('cv_pdf');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('cv'), $filename);
                
                if ($user->estudiante) {
                    $user->estudiante->cv_pdf = $filename;
                    $user->estudiante->save();
                }
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
            if($user->role_id == 3 && $user->estudiante) {
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
        } catch (\Illuminate\Database\QueryException $e) {
            // Capturar errores específicos de la base de datos (como duplicados)
            $errorCode = $e->errorInfo[1];
            $errorMsg = $e->getMessage();
            
            // Código 1062 es para errores de duplicados en MySQL
            if ($errorCode === 1062) {
                if ($request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => $errorMsg
                    ], 422);
                }
                return redirect()->back()->withInput()->with('error', 'Error de duplicado: ' . $errorMsg);
            }
            
            // Otros errores de base de datos
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error en la base de datos: ' . $errorMsg
                ], 500);
            }
            
            return redirect()->back()->withInput()->with('error', 'Error en la base de datos: ' . $errorMsg);
        } catch (\Exception $e) {
            // Errores generales
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al actualizar el perfil: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()->withInput()->with('error', 'Error al actualizar el perfil: ' . $e->getMessage());
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
} 