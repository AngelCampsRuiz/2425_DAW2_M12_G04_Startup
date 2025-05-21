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
use Illuminate\Support\Facades\DB;

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
        return redirect()->route('institucion.dashboard')->with('open_modal', 'docente');
    }

    // Guardar docente
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|unique:user,email',
            'dni' => 'required|string|max:15|unique:user,dni',
            'telefono' => 'required|string|max:15|unique:user,telefono',
            'especialidad' => 'required|string|max:255',
            'cargo' => 'required|string|max:100',
        ], [
            'nombre.required' => 'El nombre del docente es obligatorio',
            'email.required' => 'El correo electrónico es obligatorio',
            'email.email' => 'El correo electrónico debe tener un formato válido',
            'email.unique' => 'Este correo electrónico ya está registrado en el sistema',
            'dni.required' => 'El DNI/NIE es obligatorio',
            'dni.unique' => 'Este DNI/NIE ya está registrado en el sistema',
            'telefono.required' => 'El teléfono es obligatorio',
            'telefono.unique' => 'Este teléfono ya está registrado en el sistema',
            'especialidad.required' => 'La especialidad es obligatoria',
            'cargo.required' => 'El cargo es obligatorio',
        ]);

        // Generar una contraseña aleatoria segura
        $password = Str::random(10);

        try {
            DB::beginTransaction();
            
            // Crear el usuario
            $user = new User();
            $user->nombre = $request->nombre;
            $user->email = $request->email;
            $user->dni = $request->dni;
            $user->telefono = $request->telefono;
            $user->password = Hash::make($password);
            $user->role_id = Rol::where('nombre_rol', 'Docente')->first()->id;
            $user->activo = true;
            $user->save();
            
            // Crear el docente
            $docente = new Docente();
            $docente->id = $user->id;
            $docente->user_id = $user->id;
            $docente->institucion_id = Auth::user()->institucion->id;
            $docente->departamento_id = $request->departamento_id ?: null;
            $docente->departamento = empty($request->departamento_id) ? $request->departamento : null;
            $docente->especialidad = $request->especialidad;
            $docente->cargo = $request->cargo;
            $docente->activo = true;
            $docente->save();
            
            DB::commit();
            
            // Guardar credenciales para mostrarlas
            // Ideal: enviar un correo electrónico con las credenciales
            session(['email' => $user->email, 'password' => $password]);
            
            return redirect()->route('institucion.docentes.index')
                ->with('success', 'Docente creado correctamente. Las credenciales se han generado automáticamente.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            // Capturar errores de base de datos específicos
            if ($e instanceof \Illuminate\Database\QueryException) {
                $errorCode = $e->errorInfo[1];
                
                // Errores comunes de MySQL
                if ($errorCode == 1062) { // Duplicate entry
                    $errorMessage = $e->errorInfo[2];
                    if (stripos($errorMessage, 'email')) {
                        return redirect()->back()
                            ->withInput()
                            ->withErrors(['email' => 'Este correo electrónico ya está registrado en el sistema']);
                    } elseif (stripos($errorMessage, 'dni')) {
                        return redirect()->back()
                            ->withInput()
                            ->withErrors(['dni' => 'Este DNI/NIE ya está registrado en el sistema']);
                    } elseif (stripos($errorMessage, 'telefono')) {
                        return redirect()->back()
                            ->withInput()
                            ->withErrors(['telefono' => 'Este teléfono ya está registrado en el sistema']);
                    }
                }
            }
            
            // Error genérico
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Error al crear el docente: ' . $e->getMessage()]);
        }
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
            'fecha_nacimiento' => 'nullable|date',
            'ciudad' => 'nullable|string|max:100',
            'direccion' => 'nullable|string|max:255',
            'sitio_web' => 'nullable|url|max:255',
            'descripcion' => 'nullable|string|max:1000',
        ]);

        // Actualizar usuario con los datos básicos
        $userData = [
            'nombre' => $request->nombre,
            'email' => $request->email,
            'dni' => $request->dni,
            'telefono' => $request->telefono,
        ];
        
        // Añadir campos adicionales si están presentes
        if ($request->has('fecha_nacimiento')) {
            $userData['fecha_nacimiento'] = $request->fecha_nacimiento;
        }
        if ($request->has('ciudad')) {
            $userData['ciudad'] = $request->ciudad;
        }
        if ($request->has('direccion')) {
            $userData['direccion'] = $request->direccion;
        }
        if ($request->has('sitio_web')) {
            $userData['sitio_web'] = $request->sitio_web;
        }
        if ($request->has('descripcion')) {
            $userData['descripcion'] = $request->descripcion;
        }
        
        // Opciones de visibilidad
        $userData['show_telefono'] = $request->has('show_telefono');
        $userData['show_dni'] = $request->has('show_dni');
        $userData['show_ciudad'] = $request->has('show_ciudad');
        $userData['show_direccion'] = $request->has('show_direccion');
        $userData['show_web'] = $request->has('show_web');
        
        $user->update($userData);

        // Actualizar docente
        $docente->update([
            'departamento_id' => $request->departamento_id,
            'especialidad' => $request->especialidad,
            'cargo' => $request->cargo,
            'activo' => $request->has('activo'),
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
        
        // Obtener las clases del docente
        $clasesDocente = Clase::where('docente_id', $user->id)->withCount('estudiantes')->get();
        $clasesIds = $clasesDocente->pluck('id')->toArray();
        
        // Obtener las categorías (ciclos) que imparte el docente a través de sus clases
        $categoriasDocente = $clasesDocente->pluck('categoria_id')->filter()->unique()->toArray();
        
        // Obtener total de alumnos en las clases del docente
        $totalAlumnos = Estudiante::whereHas('clases', function($query) use ($clasesIds) {
            $query->whereIn('clases.id', $clasesIds);
        })->count();

        // Obtener total de clases del docente
        $totalClases = $clasesDocente->count();

        // Obtener solicitudes pendientes (ahora incluyendo por categoría)
        $solicitudesPendientes = SolicitudEstudiante::where(function($q) use ($user, $categoriasDocente) {
            // Solicitudes para clases del docente
            $q->whereHas('clase', function($query) use ($user) {
            $query->where('docente_id', $user->id);
            });
            
            // O solicitudes de estudiantes que han seleccionado una categoría que imparte el docente
            if (!empty($categoriasDocente)) {
                $q->orWhereHas('estudiante', function($query) use ($categoriasDocente) {
                    $query->whereIn('categoria_id', $categoriasDocente);
                });
            }
        })->where('estado', 'pendiente')->count();
        
        // Obtener los IDs de estudiantes que pertenecen a esas clases
        $estudiantesIds = Estudiante::whereHas('clases', function($query) use ($clasesIds) {
            $query->whereIn('clases.id', $clasesIds);
        })->pluck('id');
        
        // Obtener los convenios pendientes relacionados con los estudiantes del docente
        $conveniosPendientes = \App\Models\Convenio::whereIn('estudiante_id', $estudiantesIds)
            ->where('estado', 'pendiente')
            ->with(['estudiante', 'empresa', 'oferta'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Asignar $clasesDocente a $clases para usar en la vista
        $clases = $clasesDocente;

        return view('docentes.dashboard', compact(
            'totalAlumnos', 
            'totalClases', 
            'solicitudesPendientes', 
            'clases',
            'conveniosPendientes'
        ));
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
        
        // Obtener las clases del docente
        $clasesDocente = Clase::where('docente_id', $user->id)->get();
        
        // Obtener las categorías (ciclos) que imparte el docente a través de sus clases
        $categoriasDocente = $clasesDocente->pluck('categoria_id')->filter()->unique()->toArray();
        
        // Consulta base para las solicitudes
        $query = SolicitudEstudiante::where(function($q) use ($user, $categoriasDocente) {
            // Incluir solicitudes donde el docente es tutor de la clase asignada
            $q->whereHas('clase', function($query) use ($user) {
            $query->where('docente_id', $user->id);
            });
            
            // O incluir solicitudes donde el estudiante ha seleccionado una categoría que imparte el docente
            if (!empty($categoriasDocente)) {
                $q->orWhereHas('estudiante', function($query) use ($categoriasDocente) {
                    $query->whereIn('categoria_id', $categoriasDocente);
                });
            }
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
            'total' => SolicitudEstudiante::where(function($q) use ($user, $categoriasDocente) {
                $q->whereHas('clase', function($subQ) use ($user) {
                    $subQ->where('docente_id', $user->id);
                });
                if (!empty($categoriasDocente)) {
                    $q->orWhereHas('estudiante', function($subQ) use ($categoriasDocente) {
                        $subQ->whereIn('categoria_id', $categoriasDocente);
                    });
                }
            })->count(),
            'pendientes' => SolicitudEstudiante::where(function($q) use ($user, $categoriasDocente) {
                $q->whereHas('clase', function($subQ) use ($user) {
                    $subQ->where('docente_id', $user->id);
                });
                if (!empty($categoriasDocente)) {
                    $q->orWhereHas('estudiante', function($subQ) use ($categoriasDocente) {
                        $subQ->whereIn('categoria_id', $categoriasDocente);
                    });
                }
            })->where('estado', 'pendiente')->count(),
            'aprobadas' => SolicitudEstudiante::where(function($q) use ($user, $categoriasDocente) {
                $q->whereHas('clase', function($subQ) use ($user) {
                    $subQ->where('docente_id', $user->id);
                });
                if (!empty($categoriasDocente)) {
                    $q->orWhereHas('estudiante', function($subQ) use ($categoriasDocente) {
                        $subQ->whereIn('categoria_id', $categoriasDocente);
                    });
                }
            })->where('estado', 'aprobada')->count(),
            'rechazadas' => SolicitudEstudiante::where(function($q) use ($user, $categoriasDocente) {
                $q->whereHas('clase', function($subQ) use ($user) {
                    $subQ->where('docente_id', $user->id);
                });
                if (!empty($categoriasDocente)) {
                    $q->orWhereHas('estudiante', function($subQ) use ($categoriasDocente) {
                        $subQ->whereIn('categoria_id', $categoriasDocente);
                    });
                }
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

    /**
     * Calificar a un estudiante en una clase específica
     */
    public function calificarEstudiante(Request $request, $estudianteId, $claseId)
    {
        // Validar que sea el docente de la clase
        $user = Auth::user();
        $clase = Clase::where('id', $claseId)
            ->where('docente_id', $user->id)
            ->firstOrFail();
            
        $estudiante = Estudiante::findOrFail($estudianteId);
        
        // Validar entrada
        $validated = $request->validate([
            'calificacion' => 'nullable|numeric|min:0|max:10',
            'comentarios' => 'nullable|string|max:1000',
        ]);
        
        // Actualizar la calificación en la tabla pivote
        $estudiante->clases()->updateExistingPivot($claseId, [
            'calificacion' => $validated['calificacion'],
            'comentarios' => $validated['comentarios'],
            'updated_at' => now(),
        ]);
        
        return redirect()->route('docente.clases.alumnos', $claseId)
            ->with('success', "Calificación actualizada para {$estudiante->user->nombre}");
    }
    
    /**
     * Cambiar el estado de un estudiante en una clase específica
     */
    public function cambiarEstadoEstudiante(Request $request, $estudianteId, $claseId)
    {
        // Validar que sea el docente de la clase
        $user = Auth::user();
        $clase = Clase::where('id', $claseId)
            ->where('docente_id', $user->id)
            ->firstOrFail();
            
        $estudiante = Estudiante::findOrFail($estudianteId);
        
        // Validar entrada
        $validated = $request->validate([
            'estado' => 'required|string|in:activo,inactivo,completado,pendiente',
        ]);
        
        // Actualizar el estado en la tabla pivote
        $estudiante->clases()->updateExistingPivot($claseId, [
            'estado' => $validated['estado'],
            'updated_at' => now(),
        ]);
        
        return redirect()->route('docente.clases.alumnos', $claseId)
            ->with('success', "Estado actualizado para {$estudiante->user->nombre}");
    }
} 