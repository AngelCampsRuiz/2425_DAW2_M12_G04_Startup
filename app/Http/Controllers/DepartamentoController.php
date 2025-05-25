<?php

namespace App\Http\Controllers;

use App\Models\Departamento;
use App\Models\Docente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DepartamentoController extends Controller
{
    // Listar departamentos
    public function index()
    {
        $institucion = Auth::user()->institucion;
        $departamentos = $institucion->departamentos()->with('jefeDepartamento.user')->get();
        $docentes = $institucion->docentes()->with('user')->where('activo', true)->get();
        
        return view('institucion.departamentos.index', compact('departamentos', 'docentes'));
    }

    // Formulario crear departamento
    public function create()
    {
        $institucion = Auth::user()->institucion;
        $docentes = $institucion->docentes()->with('user')->where('activo', true)->get();
        
        return view('institucion.departamentos.create', compact('docentes'));
    }

    // Guardar departamento
    public function store(Request $request)
    {
        $institucion = Auth::user()->institucion;
        
        try {
            $validated = $request->validate([
                'nombre' => 'required|string|max:255',
                'codigo' => 'required|string|max:50|unique:departamentos,codigo',
                'descripcion' => 'nullable|string',
                'jefe_departamento_id' => 'nullable|exists:docentes,id',
            ]);

            // Crear departamento
            $departamento = Departamento::create([
                'institucion_id' => $institucion->id,
                'nombre' => $request->nombre,
                'codigo' => $request->codigo,
                'descripcion' => $request->descripcion,
                'jefe_departamento_id' => $request->jefe_departamento_id,
            ]);

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Departamento creado correctamente',
                    'departamento' => $departamento
                ], 200, ['Content-Type' => 'application/json']);
            }

            return redirect()->route('institucion.departamentos.index')
                ->with('success', 'Departamento creado correctamente');

        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error de validación',
                    'errors' => $e->errors()
                ], 422, ['Content-Type' => 'application/json']);
            }
            throw $e;
        } catch (\Exception $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al crear el departamento',
                    'error' => $e->getMessage()
                ], 500, ['Content-Type' => 'application/json']);
            }

            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al crear el departamento: ' . $e->getMessage());
        }
    }

    // Ver departamento
    public function show($id)
    {
        $institucion = Auth::user()->institucion;
        $departamento = $institucion->departamentos()->with(['jefeDepartamento.user', 'docentes.user', 'clases'])->findOrFail($id);
        
        return view('institucion.departamentos.show', compact('departamento'));
    }

    // Editar departamento
    public function edit($id)
    {
        $institucion = Auth::user()->institucion;
        $departamento = $institucion->departamentos()->findOrFail($id);
        $docentes = $institucion->docentes()->with('user')->where('activo', true)->get();
        
        return view('institucion.departamentos.edit', compact('departamento', 'docentes'));
    }

    // Actualizar departamento
    public function update(Request $request, $id)
    {
        $institucion = Auth::user()->institucion;
        $departamento = $institucion->departamentos()->findOrFail($id);
        
        $request->validate([
            'nombre' => 'required|string|max:255',
            'codigo' => 'required|string|max:50|unique:departamentos,codigo,' . $departamento->id,
            'descripcion' => 'nullable|string',
            'jefe_departamento_id' => 'nullable|exists:docentes,id',
        ]);

        // Actualizar departamento
        $departamento->update([
            'nombre' => $request->nombre,
            'codigo' => $request->codigo,
            'descripcion' => $request->descripcion,
            'jefe_departamento_id' => $request->jefe_departamento_id,
        ]);

        return redirect()->route('institucion.departamentos.index')
            ->with('success', 'Departamento actualizado correctamente');
    }

    // Eliminar departamento
    public function destroy($id)
    {
        $institucion = Auth::user()->institucion;
        $departamento = $institucion->departamentos()->findOrFail($id);
        
        // Verificar si tiene docentes asignados
        if ($departamento->docentes()->count() > 0) {
            return redirect()->route('institucion.departamentos.index')
                ->with('error', 'No se puede eliminar el departamento porque tiene docentes asignados');
        }
        
        // Verificar si tiene clases asignadas
        if ($departamento->clases()->count() > 0) {
            return redirect()->route('institucion.departamentos.index')
                ->with('error', 'No se puede eliminar el departamento porque tiene clases asignadas');
        }
        
        // Eliminar departamento
        $departamento->delete();
        
        return redirect()->route('institucion.departamentos.index')
            ->with('success', 'Departamento eliminado correctamente');
    }

    // Asignar docentes al departamento
    public function asignarDocentes($id)
    {
        $institucion = Auth::user()->institucion;
        $departamento = $institucion->departamentos()->findOrFail($id);
        $docentes = $institucion->docentes()->with('user')->where('activo', true)->get();
        $docentesAsignados = $departamento->docentes()->pluck('id')->toArray();
        
        return view('institucion.departamentos.asignar-docentes', compact('departamento', 'docentes', 'docentesAsignados'));
    }

    // Guardar asignación de docentes
    public function guardarAsignacionDocentes(Request $request, $id)
    {
        $institucion = Auth::user()->institucion;
        $departamento = $institucion->departamentos()->findOrFail($id);
        
        $request->validate([
            'docentes' => 'nullable|array',
            'docentes.*' => 'exists:docentes,id',
        ]);

        // Actualizar docentes asignados
        $docentes = $request->input('docentes', []);
        
        foreach ($institucion->docentes as $docente) {
            if (in_array($docente->id, $docentes)) {
                // Asignar al departamento
                $docente->update(['departamento_id' => $departamento->id]);
            } else if ($docente->departamento_id == $departamento->id) {
                // Desasignar del departamento
                $docente->update(['departamento_id' => null]);
            }
        }
        
        return redirect()->route('institucion.departamentos.show', $departamento->id)
            ->with('success', 'Docentes asignados correctamente');
    }

    // Obtener datos del departamento para edición AJAX
    public function getData($id)
    {
        $institucion = Auth::user()->institucion;
        $departamento = $institucion->departamentos()->with('jefeDepartamento.user')->findOrFail($id);
        
        return response()->json([
            'success' => true,
            'departamento' => $departamento
        ]);
    }
} 