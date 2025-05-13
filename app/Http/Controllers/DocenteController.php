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
use App\Models\Clase;
use App\Models\Estudiante;
use App\Models\SolicitudEstudiante;

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
        $docente = $institucion->docentes()->with(['user', 'clases', 'estudiantes.user', 'departamentoObj'])->findOrFail($id);
        $departamentos = $institucion->departamentos;
        
        // Obtener niveles educativos de la institución
        $nivelesEducativos = $institucion->nivelesEducativos;
        
        // Obtener categorías (cursos) organizadas por nivel educativo
        $categoriasPorNivel = [];
        foreach ($nivelesEducativos as $nivel) {
            $categoriasPorNivel[$nivel->id] = $institucion->categoriasPorNivel($nivel->id)->get();
        }
        
        return view('institucion.docentes.show', compact('docente', 'departamentos', 'nivelesEducativos', 'categoriasPorNivel'));
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

    // Obtener datos de docente para edición por AJAX
    public function getData($id)
    {
        $institucion = Auth::user()->institucion;
        $docente = $institucion->docentes()->with('user')->findOrFail($id);
        
        return response()->json([
            'success' => true,
            'docente' => $docente
        ]);
    }

    public function dashboard()
    {
        $user = Auth::user();
        $totalAlumnos = Estudiante::whereHas('clases', function($query) use ($user) {
            $query->where('docente_id', $user->id);
        })->count();

        $totalClases = Clase::where('docente_id', $user->id)->count();

        $solicitudesPendientes = SolicitudEstudiante::whereHas('clase', function($query) use ($user) {
            $query->where('docente_id', $user->id);
        })->where('estado', 'pendiente')->count();

        $clases = Clase::where('docente_id', $user->id)
            ->withCount('estudiantes')
            ->get();

        return view('docentes.dashboard', compact('totalAlumnos', 'totalClases', 'solicitudesPendientes', 'clases'));
    }

    public function alumnos()
    {
        $user = Auth::user();
        $alumnos = Estudiante::whereHas('clases', function($query) use ($user) {
            $query->where('docente_id', $user->id);
        })->paginate(10);

        $clases = Clase::where('docente_id', $user->id)->get();

        return view('docentes.alumnos.index', compact('alumnos', 'clases'));
    }

    public function showAlumno($id)
    {
        $alumno = Estudiante::findOrFail($id);
        return view('docentes.alumnos.show', compact('alumno'));
    }

    public function clases()
    {
        $user = Auth::user();
        $clases = Clase::where('docente_id', $user->id)->paginate(10);
        return view('docentes.clases.index', compact('clases'));
    }

    public function showClase($id)
    {
        $clase = Clase::findOrFail($id);
        return view('docentes.clases.show', compact('clase'));
    }

    public function clasesAlumnos($id)
    {
        $clase = Clase::findOrFail($id);
        $alumnos = $clase->estudiantes()->paginate(10);
        return view('docentes.clases.alumnos', compact('clase', 'alumnos'));
    }

    public function solicitudes(Request $request)
    {
        $user = Auth::user();
        $query = SolicitudEstudiante::whereHas('clase', function($query) use ($user) {
            $query->where('docente_id', $user->id);
        });

        // Filtrar por estado si se proporciona
        $filtro = $request->estado ?? 'todos';
        if ($filtro !== 'todos') {
            $query->where('estado', $filtro);
        }

        // Búsqueda por nombre o email
        $busqueda = $request->buscar ?? '';
        if (!empty($busqueda)) {
            $query->whereHas('estudiante.user', function($q) use ($busqueda) {
                $q->where('nombre', 'like', '%' . $busqueda . '%')
                  ->orWhere('email', 'like', '%' . $busqueda . '%');
            });
        }

        // Estadísticas para el resumen
        $stats = [
            'total' => SolicitudEstudiante::whereHas('clase', function($q) use ($user) {
                $q->where('docente_id', $user->id);
            })->count(),
            'pendientes' => SolicitudEstudiante::whereHas('clase', function($q) use ($user) {
                $q->where('docente_id', $user->id);
            })->where('estado', 'pendiente')->count(),
            'aprobadas' => SolicitudEstudiante::whereHas('clase', function($q) use ($user) {
                $q->where('docente_id', $user->id);
            })->where('estado', 'aprobada')->count(),
            'rechazadas' => SolicitudEstudiante::whereHas('clase', function($q) use ($user) {
                $q->where('docente_id', $user->id);
            })->where('estado', 'rechazada')->count(),
        ];

        $solicitudes = $query->with(['estudiante.user', 'clase'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('docentes.solicitudes.index', compact('solicitudes', 'stats', 'filtro', 'busqueda'));
    }

    public function showSolicitud($id)
    {
        $solicitud = SolicitudEstudiante::findOrFail($id);
        return view('docentes.solicitudes.show', compact('solicitud'));
    }

    public function aprobarSolicitud($id)
    {
        $solicitud = SolicitudEstudiante::findOrFail($id);
        $solicitud->estado = 'aprobada';
        $solicitud->fecha_respuesta = now();
        $solicitud->save();

        return redirect()->route('docente.solicitudes.index')
            ->with('success', 'Solicitud aprobada correctamente');
    }

    public function rechazarSolicitud($id, Request $request)
    {
        $solicitud = SolicitudEstudiante::findOrFail($id);
        $solicitud->estado = 'rechazada';
        $solicitud->mensaje_rechazo = $request->mensaje_rechazo;
        $solicitud->fecha_respuesta = now();
        $solicitud->save();

        return redirect()->route('docente.solicitudes.index')
            ->with('success', 'Solicitud rechazada correctamente');
    }
} 