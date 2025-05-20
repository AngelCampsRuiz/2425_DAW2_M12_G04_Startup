<?php

namespace App\Http\Controllers\Institucion;

use App\Http\Controllers\Controller;
use App\Models\Estudiante;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class EstudiantePendienteController extends Controller
{
    /**
     * Muestra la lista de estudiantes pendientes de activación
     */
    public function index()
    {
        $institucion = Auth::user()->institucion;
        
        $estudiantes = Estudiante::with(['user', 'categoria'])
            ->where('institucion_id', $institucion->id)
            ->where('estado', 'pendiente')
            ->get();
            
        $categorias = Categoria::all();
        
        return view('institucion.estudiantes.pendientes', compact('estudiantes', 'categorias'));
    }
    
    /**
     * Activa un estudiante pendiente
     */
    public function activar($id)
    {
        try {
            DB::beginTransaction();

            $estudiante = Estudiante::with('user')->findOrFail($id);
            
            // Actualizar estado del estudiante
            $estudiante->estado = 'activo';
            $estudiante->save();
            
            // Actualizar estado activo del usuario asociado
            if ($estudiante->user) {
                $estudiante->user->activo = true;
                $estudiante->user->save();
            }

            DB::commit();

            return redirect()->back()->with('success', 'Estudiante activado correctamente');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al activar estudiante: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al activar el estudiante: ' . $e->getMessage());
        }
    }
    
    /**
     * Actualiza los datos académicos del estudiante
     */
    public function actualizar(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $estudiante = Estudiante::findOrFail($id);
            $estudiante->categoria_id = $request->categoria_id;
            $estudiante->save();

            DB::commit();

            return redirect()->back()->with('success', 'Estudiante actualizado correctamente');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al actualizar estudiante: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al actualizar el estudiante');
        }
    }
    
    /**
     * Elimina un estudiante pendiente
     */
    public function eliminar($id)
    {
        try {
            DB::beginTransaction();

            $estudiante = Estudiante::findOrFail($id);
            $estudiante->delete();

            DB::commit();

            return redirect()->back()->with('success', 'Estudiante eliminado correctamente');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al eliminar estudiante: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al eliminar el estudiante');
        }
    }
} 