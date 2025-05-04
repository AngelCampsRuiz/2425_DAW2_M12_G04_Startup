<?php

namespace App\Http\Controllers;

use App\Models\Clase;
use App\Models\Docente;
use App\Models\Departamento;
use App\Models\Estudiante;
use App\Models\Institucion;
use App\Models\SolicitudEstudiante;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class InstitucionController extends Controller
{
    // Dashboard
    public function dashboard()
    {
        $institucion = Auth::user()->institucion;
        $totalDocentes = $institucion->docentes()->count();
        $totalEstudiantes = $institucion->estudiantes()->count();
        $totalDepartamentos = $institucion->departamentos()->count();
        $totalClases = $institucion->clases()->count();
        $solicitudesPendientes = $institucion->solicitudesPendientes()->count();

        return view('institucion.dashboard', compact(
            'institucion',
            'totalDocentes',
            'totalEstudiantes',
            'totalDepartamentos',
            'totalClases',
            'solicitudesPendientes'
        ));
    }

    // Perfil
    public function perfil()
    {
        $institucion = Auth::user()->institucion;
        return view('institucion.perfil', compact('institucion'));
    }

    // Actualizar perfil
    public function actualizarPerfil(Request $request)
    {
        $user = Auth::user();
        $institucion = $user->institucion;

        $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:user,email,' . $user->id,
            'telefono' => 'required|string|max:20',
            'tipo_institucion' => 'required|string|max:50',
            'direccion' => 'required|string|max:255',
            'provincia' => 'required|string|max:100',
            'codigo_postal' => 'required|string|max:10',
            'representante_legal' => 'required|string|max:255',
            'cargo_representante' => 'required|string|max:255',
        ]);

        // Actualizar usuario
        $user->update([
            'nombre' => $request->nombre,
            'email' => $request->email,
            'telefono' => $request->telefono,
        ]);

        // Actualizar institución
        $institucion->update([
            'tipo_institucion' => $request->tipo_institucion,
            'direccion' => $request->direccion,
            'provincia' => $request->provincia,
            'codigo_postal' => $request->codigo_postal,
            'representante_legal' => $request->representante_legal,
            'cargo_representante' => $request->cargo_representante,
        ]);

        return redirect()->route('institucion.perfil')->with('success', 'Perfil actualizado correctamente');
    }

    // Cambiar contraseña
    public function cambiarPassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        // Verificar contraseña actual
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'La contraseña actual no es correcta']);
        }

        // Actualizar contraseña
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('institucion.perfil')->with('success', 'Contraseña actualizada correctamente');
    }
} 