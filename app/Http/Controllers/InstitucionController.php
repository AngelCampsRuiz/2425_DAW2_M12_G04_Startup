<?php

namespace App\Http\Controllers;

use App\Models\Clase;
use App\Models\Docente;
use App\Models\Departamento;
use App\Models\Estudiante;
use App\Models\Institucion;
use App\Models\SolicitudEstudiante;
use App\Models\User;
use App\Models\NivelEducativo;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class InstitucionController extends BaseController
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
        $departamentos = $institucion->departamentos()->get();
        $docentes = $institucion->docentes()->with('user')->get();

        return view('institucion.dashboard', compact(
            'institucion',
            'totalDocentes',
            'totalEstudiantes',
            'totalDepartamentos',
            'totalClases',
            'solicitudesPendientes',
            'departamentos',
            'docentes'
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

        try {
            DB::beginTransaction();
            
            // Guardar datos anteriores para el registro
            $nombreAnterior = $user->nombre;
            $emailAnterior = $user->email;
            
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
            
            // Registrar la actividad
            $this->logUpdate($institucion, 'Se ha actualizado el perfil de la institución: ' . $user->nombre);
            
            DB::commit();

            return redirect()->route('institucion.perfil')->with('success', 'Perfil actualizado correctamente');
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al actualizar perfil de institución', [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);
            
            return redirect()->back()
                ->with('error', 'Error al actualizar el perfil: ' . $e->getMessage())
                ->withInput();
        }
    }

    // Cambiar contraseña
    public function cambiarPassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();
        $institucion = $user->institucion;

        // Verificar contraseña actual
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'La contraseña actual no es correcta']);
        }

        try {
            DB::beginTransaction();
            
            // Actualizar contraseña
            $user->update([
                'password' => Hash::make($request->password),
            ]);
            
            // Registrar la actividad
            $this->logUpdate($institucion, 'Se ha actualizado la contraseña de la institución: ' . $user->nombre);
            
            DB::commit();

            return redirect()->route('institucion.perfil')->with('success', 'Contraseña actualizada correctamente');
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al cambiar contraseña de institución', [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);
            
            return redirect()->back()
                ->with('error', 'Error al actualizar la contraseña: ' . $e->getMessage())
                ->withInput();
        }
    }
    
    /**
     * Obtiene las categorías (cursos) para un nivel educativo específico.
     * 
     * @param int $nivel_id ID del nivel educativo
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCategoriasPorNivel($nivel_id)
    {
        try {
            $institucion = Auth::user()->institucion;
            
            // Obtener las categorías asociadas a la institución y al nivel educativo específico
            $categorias = DB::table('institucion_categoria as ic')
                ->join('categorias as c', 'ic.categoria_id', '=', 'c.id')
                ->where('ic.institucion_id', $institucion->id)
                ->where('ic.nivel_educativo_id', $nivel_id)
                ->where('ic.activo', true)
                ->select('c.id', 'c.nombre_categoria', 'ic.nombre_personalizado')
                ->get()
                ->map(function($categoria) {
                    return [
                        'id' => $categoria->id,
                        'nombre_categoria' => $categoria->nombre_personalizado ?: $categoria->nombre_categoria
                    ];
                });
            
            // Registrar para depuración
            Log::info('Categorías obtenidas para nivel ' . $nivel_id, [
                'institucion_id' => $institucion->id,
                'categorias' => $categorias,
                'count' => $categorias->count()
            ]);
            
            return response()->json($categorias);
            
        } catch (\Exception $e) {
            Log::error('Error al obtener categorías por nivel', [
                'nivel_id' => $nivel_id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json(['error' => 'Error al cargar las categorías: ' . $e->getMessage()], 500);
        }
    }
} 