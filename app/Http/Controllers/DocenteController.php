<?php

namespace App\Http\Controllers;

use App\Models\Docente;
use App\Models\Departamento;
use App\Models\Rol;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DocenteController extends Controller
{
    // Listar docentes
    public function index()
    {
        $institucion = Auth::user()->institucion;
        $docentes = $institucion->docentes()->with(['user', 'departamentoObj'])->get();
        $departamentos = $institucion->departamentos;
        
        return view('institucion.docentes.index', compact('docentes', 'departamentos'));
    }

    // Formulario crear docente
    public function create()
    {
        $institucion = Auth::user()->institucion;
        $departamentos = $institucion->departamentos;
        
        return view('institucion.docentes.create', compact('departamentos'));
    }

    // Guardar docente
    public function store(Request $request)
    {
        $institucion = Auth::user()->institucion;
        
        $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:user,email',
            'dni' => 'required|string|max:20|unique:user,dni',
            'telefono' => 'required|string|max:20|unique:user,telefono',
            'departamento_id' => 'nullable|exists:departamentos,id',
            'especialidad' => 'required|string|max:255',
            'cargo' => 'required|string|max:100',
        ]);

        // Crear usuario
        $user = User::create([
            'nombre' => $request->nombre,
            'email' => $request->email,
            'password' => Hash::make(Str::random(10)),
            'role_id' => Rol::where('nombre_rol', 'docente')->first()->id,
            'fecha_nacimiento' => $request->fecha_nacimiento ?? now()->subYears(30),
            'ciudad' => $institucion->provincia,
            'dni' => $request->dni,
            'activo' => true,
            'telefono' => $request->telefono,
            'descripcion' => 'Docente de ' . $institucion->user->nombre,
        ]);

        // Crear docente
        $docente = Docente::create([
            'user_id' => $user->id,
            'institucion_id' => $institucion->id,
            'departamento_id' => $request->departamento_id,
            'departamento' => $request->departamento_id ? null : $request->departamento,
            'especialidad' => $request->especialidad,
            'cargo' => $request->cargo,
            'activo' => true,
        ]);

        // Enviar email con contraseña temporal
        // TODO: implementar envío de email

        return redirect()->route('institucion.docentes.index')
            ->with('success', 'Docente creado correctamente. Se ha enviado un email con las credenciales de acceso.');
    }

    // Ver docente
    public function show($id)
    {
        $institucion = Auth::user()->institucion;
        $docente = $institucion->docentes()->with(['user', 'departamentoObj', 'clases', 'estudiantes'])->findOrFail($id);
        
        return view('institucion.docentes.show', compact('docente'));
    }

    // Editar docente
    public function edit($id)
    {
        $institucion = Auth::user()->institucion;
        $docente = $institucion->docentes()->with('user')->findOrFail($id);
        $departamentos = $institucion->departamentos;
        
        return view('institucion.docentes.edit', compact('docente', 'departamentos'));
    }

    // Actualizar docente
    public function update(Request $request, $id)
    {
        $institucion = Auth::user()->institucion;
        $docente = $institucion->docentes()->findOrFail($id);
        $user = $docente->user;
        
        $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:user,email,' . $user->id,
            'dni' => 'required|string|max:20|unique:user,dni,' . $user->id,
            'telefono' => 'required|string|max:20|unique:user,telefono,' . $user->id,
            'departamento_id' => 'nullable|exists:departamentos,id',
            'especialidad' => 'required|string|max:255',
            'cargo' => 'required|string|max:100',
        ]);

        // Actualizar usuario
        $user->update([
            'nombre' => $request->nombre,
            'email' => $request->email,
            'dni' => $request->dni,
            'telefono' => $request->telefono,
        ]);

        // Actualizar docente
        $docente->update([
            'departamento_id' => $request->departamento_id,
            'departamento' => $request->departamento_id ? null : $request->departamento,
            'especialidad' => $request->especialidad,
            'cargo' => $request->cargo,
        ]);

        return redirect()->route('institucion.docentes.index')
            ->with('success', 'Docente actualizado correctamente');
    }

    // Eliminar docente
    public function destroy($id)
    {
        $institucion = Auth::user()->institucion;
        $docente = $institucion->docentes()->findOrFail($id);
        $user = $docente->user;
        
        // Eliminar docente
        $docente->delete();
        
        // Eliminar usuario
        $user->delete();
        
        return redirect()->route('institucion.docentes.index')
            ->with('success', 'Docente eliminado correctamente');
    }

    // Cambiar estado del docente
    public function toggleActive($id)
    {
        $institucion = Auth::user()->institucion;
        $docente = $institucion->docentes()->findOrFail($id);
        
        $docente->update([
            'activo' => !$docente->activo
        ]);
        
        return redirect()->route('institucion.docentes.index')
            ->with('success', 'Estado del docente actualizado correctamente');
    }

    // Resetear contraseña
    public function resetPassword($id)
    {
        $institucion = Auth::user()->institucion;
        $docente = $institucion->docentes()->findOrFail($id);
        $user = $docente->user;
        
        // Generar contraseña aleatoria
        $password = Str::random(8);
        
        // Actualizar contraseña
        $user->update([
            'password' => Hash::make($password)
        ]);
        
        // TODO: Enviar email con la nueva contraseña
        // En producción, implementar envío de correo
        
        return redirect()->route('institucion.docentes.show', $docente->id)
            ->with('success', 'Contraseña reseteada correctamente. Nueva contraseña temporal: ' . $password);
    }
} 