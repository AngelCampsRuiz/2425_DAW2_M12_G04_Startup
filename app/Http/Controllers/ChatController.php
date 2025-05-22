<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Mensaje;
use App\Models\Solicitud;
use App\Models\Estudiante;
use App\Models\Empresa;
use App\Models\Docente;
use App\Models\Clase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\MensajeNoLeidoNotification;
use App\Events\NotificacionPusher;
use App\Events\MessageSent;
use Illuminate\Support\Facades\Log;

class ChatController extends Controller
{
    /**
     * Crear un nuevo chat entre empresa y estudiante
     */
    public function createChat(Solicitud $solicitud)
    {
        // Verificar que la solicitud está aceptada
        if ($solicitud->estado !== 'aceptada') {
            return redirect()->back()->with('error', 'Solo se puede crear un chat para solicitudes aceptadas');
        }

        // Verificar que el usuario autenticado es la empresa de la solicitud
        $empresa_id = $solicitud->publicacion->empresa_id;
        if (Auth::id() != $empresa_id) {
            return redirect()->back()->with('error', 'No tienes permiso para crear este chat');
        }

        // Verificar si ya existe un chat para esta solicitud
        $existingChat = Chat::where('solicitud_id', $solicitud->id)->first();
        if ($existingChat) {
            return redirect()->route('chat.show', $existingChat->id);
        }

        // Crear nuevo chat
        $chat = Chat::create([
            'empresa_id' => $empresa_id,
            'solicitud_id' => $solicitud->id
        ]);

        return redirect()->route('chat.show', $chat->id)
            ->with('success', 'Chat creado correctamente');
    }

    /**
     * Enviar un mensaje en el chat
     */
    public function sendMessage(Request $request, Chat $chat)
    {
        try {
            // Verificar que el usuario tiene acceso al chat
            $user = Auth::user();
            $hasAccess = false;

            // Si es empresa en chat empresa-estudiante
            if ($user->empresa && $chat->tipo == 'empresa_estudiante' && $user->empresa->id == $chat->empresa_id) {
                $hasAccess = true;
            }

            // Si es empresa en chat docente-empresa
            if ($user->empresa && $chat->tipo == 'docente_empresa' && $user->empresa->id == $chat->empresa_id) {
                $hasAccess = true;
            }

            // Si es estudiante en chat empresa-estudiante
            if ($user->estudiante && $chat->tipo == 'empresa_estudiante' && $chat->solicitud && $chat->solicitud->estudiante_id == $user->estudiante->id) {
                $hasAccess = true;
            }

            // Si es docente en chat docente-estudiante
            if ($user->role_id == 4 && $chat->tipo == 'docente_estudiante') {
                $docente = \App\Models\Docente::where('user_id', $user->id)->first();
                if ($docente && $chat->docente_id == $docente->id) {
                    $hasAccess = true;
                }
            }
            
            // Si es docente en chat docente-empresa
            if ($user->role_id == 4 && $chat->tipo == 'docente_empresa') {
                $docente = \App\Models\Docente::where('user_id', $user->id)->first();
                if ($docente && $chat->docente_id == $docente->id) {
                    $hasAccess = true;
                }
            }
            
            // Si es estudiante en chat docente-estudiante
            if ($user->estudiante && $chat->tipo == 'docente_estudiante' && $chat->estudiante_id == $user->estudiante->id) {
                $hasAccess = true;
            }
            
            // Si es institución en chat institución-docente o institución-empresa
            if ($user->role_id == 5 && $chat->institucion_id == $user->institucion->id) {
                $hasAccess = true;
            }

            if (!$hasAccess) {
                return response()->json([
                    'error' => true,
                    'message' => 'No tienes permiso para enviar mensajes en este chat'
                ], 403);
            }

            // Validar el mensaje
            $request->validate([
                'contenido' => 'required_without:archivo|string|max:1000',
                'archivo' => 'required_without:contenido|file|max:10240', // 10MB máximo
            ]);

            // Crear datos base del mensaje
            $mensajeData = [
                'contenido' => $request->contenido ?? '',
                'chat_id' => $chat->id,
                'user_id' => $user->id,
                'fecha_envio' => now()
            ];

            // Manejar archivo adjunto si existe
            if ($request->hasFile('archivo')) {
                $file = $request->file('archivo');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $fileType = $file->getClientMimeType();

                // Determinar la carpeta según el tipo de archivo
                $folder = 'chat_files';

                // Si es imagen, guardar en una carpeta específica
                if (strpos($fileType, 'image/') === 0) {
                    $folder = 'chat_images';
                }

                // Mover el archivo a la carpeta pública
                $file->move(public_path($folder), $fileName);

                // Añadir información del archivo al mensaje
                $mensajeData['archivo_adjunto'] = $folder . '/' . $fileName;
                $mensajeData['tipo_archivo'] = $fileType;
                $mensajeData['nombre_archivo'] = $file->getClientOriginalName();
            }

            // Crear el mensaje
            $mensaje = Mensaje::create($mensajeData);

            // Cargar relación de usuario para el evento
            $mensaje->load('user');

            // Transmitir el mensaje a través de Pusher usando el evento MessageSent
            broadcast(new MessageSent($mensaje, $user))->toOthers();
            
            // Guardar un registro de actividad para fines de depuración
            Log::info('Mensaje enviado por broadcast', [
                'mensaje_id' => $mensaje->id,
                'chat_id' => $chat->id,
                'user_id' => $user->id,
                'timestamp' => now()->toDateTimeString()
            ]);

            // Determinar destinatario según el usuario autenticado y tipo de chat
            $destinatario = null;
            
            if ($chat->tipo == 'empresa_estudiante') {
                if ($user->empresa) {
                    // Si el que envía es empresa, destinatario es el estudiante
                    $destinatario = $chat->solicitud->estudiante->user ?? null;
                } else {
                    // Si el que envía es estudiante, destinatario es la empresa
                    $destinatario = $chat->solicitud->publicacion->empresa->user ?? null;
                }
            } else if ($chat->tipo == 'docente_estudiante') {
                if ($user->role_id == 4) {
                    // Si el que envía es docente, destinatario es el estudiante
                    $destinatario = $chat->estudiante->user ?? null;
                } else {
                    // Si el que envía es estudiante, destinatario es el docente
                    $destinatario = $chat->docente->user ?? null;
                }
            } else if ($chat->tipo == 'docente_empresa') {
                if ($user->role_id == 4) {
                    // Si el que envía es docente, destinatario es la empresa
                    $destinatario = $chat->empresa->user ?? null;
                } else {
                    // Si el que envía es empresa, destinatario es el docente
                    $destinatario = $chat->docente->user ?? null;
                }
            } else if ($chat->tipo == 'institucion_docente') {
                if ($user->role_id == 5) {
                    // Si el que envía es institución, destinatario es el docente
                    $destinatario = $chat->docente->user ?? null;
                } else {
                    // Si el que envía es docente, destinatario es la institución
                    $destinatario = $chat->institucion->user ?? null;
                }
            } else if ($chat->tipo == 'institucion_empresa') {
                if ($user->role_id == 5) {
                    // Si el que envía es institución, destinatario es la empresa
                    $destinatario = $chat->empresa->user ?? null;
                } else {
                    // Si el que envía es empresa, destinatario es la institución
                    $destinatario = $chat->institucion->user ?? null;
                }
            }

            if ($destinatario) {
                $remitente = Auth::user();
                $destinatario->notify(new MensajeNoLeidoNotification($chat, $remitente));
                event(new NotificacionPusher($destinatario->id));
            }

            // Si tiene archivo adjunto, generar la URL completa para la respuesta
            if (!empty($mensaje->archivo_adjunto)) {
                $mensaje->archivo_adjunto = url($mensaje->archivo_adjunto);
            }

            return response()->json([
                'error' => false,
                'message' => 'Mensaje enviado correctamente',
                'mensaje' => $mensaje
            ]);
        } catch (\Exception $e) {
            Log::error('Error al hacer broadcast del mensaje', [
                'mensaje_id' => $mensaje->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ], 500);
        }
    }

    /**
     * Obtener los mensajes de un chat
     */
    public function getMessages(Chat $chat)
    {
        // Verificar que el usuario tiene acceso al chat
        $user = Auth::user();
        $solicitud = $chat->solicitud;

        $hasAccess = false;

        // Si es empresa
        if ($user->empresa && $user->empresa->id == $chat->empresa_id) {
            $hasAccess = true;
        }

        // Si es estudiante
        if ($user->estudiante && $user->estudiante->id == $solicitud->estudiante_id) {
            $hasAccess = true;
        }

        if (!$hasAccess) {
            return response()->json([
                'error' => true,
                'message' => 'No tienes permiso para ver este chat'
            ], 403);
        }

        // Marcar como leídos los mensajes del otro usuario
        Mensaje::where('chat_id', $chat->id)
            ->where('user_id', '!=', $user->id)
            ->where('leido', false)
            ->update(['leido' => true]);

        // Obtener los mensajes
        $mensajes = Mensaje::where('chat_id', $chat->id)
            ->with('user')
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(function ($mensaje) {
                // Si tiene archivo adjunto, preparar la URL completa
                if ($mensaje->archivo_adjunto) {
                    $mensaje->archivo_adjunto = url($mensaje->archivo_adjunto);
                }
                return $mensaje;
            });

        return response()->json([
            'error' => false,
            'mensajes' => $mensajes
        ]);
    }

    /**
     * Ver la vista del chat
     */
    public function showChat(Chat $chat)
    {
        // Verificar que el usuario tiene acceso al chat
        $user = Auth::user();
        $hasAccess = false;

        // Si es empresa y es una conversación empresa-estudiante
        if ($user->empresa && $chat->tipo == 'empresa_estudiante' && $user->empresa->id == $chat->empresa_id) {
            $hasAccess = true;
            $solicitud = $chat->solicitud;
            $otherUser = $solicitud->estudiante->user;
        }
        
        // Si es empresa y es una conversación docente-empresa
        if ($user->empresa && $chat->tipo == 'docente_empresa' && $user->empresa->id == $chat->empresa_id) {
            $hasAccess = true;
            $solicitud = null;
            $otherUser = $chat->docente->user;
        }

        // Si es estudiante en una conversación empresa-estudiante
        if ($user->estudiante && $chat->tipo == 'empresa_estudiante' && $chat->solicitud && $chat->solicitud->estudiante_id == $user->estudiante->id) {
            $hasAccess = true;
            $solicitud = $chat->solicitud;
            $otherUser = $solicitud->publicacion->empresa->user;
        }
        
        // Si es docente en una conversación docente-estudiante
        if ($user->role_id == 4 && $chat->tipo == 'docente_estudiante') {
            $docente = \App\Models\Docente::where('user_id', $user->id)->first();
            if ($docente && $chat->docente_id == $docente->id) {
                $hasAccess = true;
                $solicitud = null; // No hay solicitud en los chats docente-estudiante
                $otherUser = $chat->estudiante->user;
            }
        }
        
        // Si es docente en una conversación docente-empresa
        if ($user->role_id == 4 && $chat->tipo == 'docente_empresa') {
            $docente = \App\Models\Docente::where('user_id', $user->id)->first();
            if ($docente && $chat->docente_id == $docente->id) {
                $hasAccess = true;
                $solicitud = null;
                $otherUser = $chat->empresa->user;
            }
        }
        
        // Si es estudiante en una conversación docente-estudiante
        if ($user->estudiante && $chat->tipo == 'docente_estudiante' && $chat->estudiante_id == $user->estudiante->id) {
            $hasAccess = true;
            $solicitud = null; // No hay solicitud en los chats docente-estudiante
            $otherUser = $chat->docente->user;
        }
        
        // Si es institución en una conversación institución-docente o institución-empresa
        if ($user->role_id == 5 && $chat->institucion_id == $user->institucion->id) {
            $hasAccess = true;
            $solicitud = null;
            if ($chat->tipo == 'institucion_docente') {
                $otherUser = $chat->docente->user;
            } else if ($chat->tipo == 'institucion_empresa') {
                $otherUser = $chat->empresa->user;
            }
        }

        if (!$hasAccess) {
            return redirect()->back()->with('error', 'No tienes permiso para ver este chat');
        }

        // Marcar como leídos los mensajes del otro usuario
        Mensaje::where('chat_id', $chat->id)
            ->where('user_id', '!=', $user->id)
            ->where('leido', false)
            ->update(['leido' => true]);

        // Obtener los mensajes
        $mensajes = Mensaje::where('chat_id', $chat->id)
            ->with('user')
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(function ($mensaje) {
                // Si tiene archivo adjunto, preparar la URL completa
                if ($mensaje->archivo_adjunto) {
                    $mensaje->archivo_adjunto = url($mensaje->archivo_adjunto);
                }
                return $mensaje;
            });

        return view('chat.show', compact('chat', 'mensajes', 'otherUser', 'solicitud'));
    }

    /**
     * Listar todos los chats del usuario
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        
        $chats = collect();
        $tienesNuevosMensajes = false;
        $estudiantes = collect();
        $empresas = collect();
        $docentes = collect();

        // Si es empresa
        if ($user->role_id == 2) {
            // Obtener chats existentes (tanto con estudiantes como con docentes)
            $chats = Chat::where('empresa_id', $user->empresa->id)
                ->where(function($query) {
                    $query->where('tipo', 'empresa_estudiante')
                          ->orWhere('tipo', 'docente_empresa');
                })
                ->with(['solicitud.estudiante.user', 'solicitud.publicacion', 'docente.user', 'mensajes' => function($query) {
                    $query->orderBy('created_at', 'desc');
                }])
                ->get();
                
            // Verificar si hay mensajes sin leer
            foreach ($chats as $chat) {
                if ($chat->mensajes && $chat->mensajes->isNotEmpty()) {
                    $ultimoMensaje = $chat->mensajes->first(); // Ya ordenados desc
                    if ($ultimoMensaje->user_id !== $user->id && 
                        ($ultimoMensaje->read_at === null || $ultimoMensaje->leido === false)) {
                        $tienesNuevosMensajes = true;
                        break;
                    }
                }
            }
        }

        // Si es estudiante
        else if ($user->role_id == 3) {
            $estudiante = Estudiante::where('id', $user->estudiante->id)->first();
            
            if ($estudiante) {
                // 1. Chats con empresas (solicitudes aceptadas)
                $chatsSolicitudes = Chat::whereHas('solicitud', function($query) use ($estudiante) {
                    $query->where('estudiante_id', $estudiante->id)
                          ->where('estado', 'aceptada');
                })
                ->with(['solicitud.publicacion.empresa.user', 'solicitud', 'mensajes' => function($query) {
                    $query->orderBy('created_at', 'desc');
                }])
                ->get();
                
                // 2. Chats con docentes
                $chatsDocentes = Chat::where('tipo', 'docente_estudiante')
                    ->where('estudiante_id', $estudiante->id)
                    ->with(['docente.user', 'mensajes' => function($query) {
                        $query->orderBy('created_at', 'desc');
                    }])
                    ->get();
                    
                // Combinar los dos tipos de chat
                $chats = $chatsSolicitudes->concat($chatsDocentes);
                
                // Si solicitó refrescar, forzar la búsqueda de chats no vistos antes
                if ($request->has('refresh')) {
                    // Asegurarse de que todas las solicitudes aceptadas tienen un chat
                    $solicitudesAceptadas = Solicitud::where('estudiante_id', $estudiante->id)
                        ->where('estado', 'aceptada')
                        ->get();
                        
                    foreach ($solicitudesAceptadas as $solicitud) {
                        $chatExistente = Chat::where('solicitud_id', $solicitud->id)->first();
                        if (!$chatExistente) {
                            // Crear el chat automáticamente
                            Chat::create([
                                'empresa_id' => $solicitud->publicacion->empresa_id,
                                'solicitud_id' => $solicitud->id,
                                'tipo' => 'empresa_estudiante'
                            ]);
                        }
                    }
                    
                    // Verificar que exista un chat con cada docente de las clases del estudiante
                    $clases = $estudiante->clases()->get();
                    $docentesIds = [];
                    
                    foreach ($clases as $clase) {
                        $docentesDeClase = $clase->docentes()->pluck('docentes.id')->toArray();
                        $docentesIds = array_merge($docentesIds, $docentesDeClase);
                    }
                    
                    $docentesIds = array_unique($docentesIds);
                    
                    foreach ($docentesIds as $docenteId) {
                        $chatExistente = Chat::where('docente_id', $docenteId)
                            ->where('estudiante_id', $estudiante->id)
                            ->where('tipo', 'docente_estudiante')
                            ->first();
                            
                        if (!$chatExistente) {
                            // Crear el chat automáticamente
                            Chat::create([
                                'docente_id' => $docenteId,
                                'estudiante_id' => $estudiante->id,
                                'tipo' => 'docente_estudiante'
                            ]);
                        }
                    }
                    
                    // Refrescar la lista de chats después de crear los nuevos
                    return redirect()->route('chat.index');
                }
                
                // 3. Obtener los docentes de sus clases que aún no tienen chat
                $docentesIds = [];
                $clases = $estudiante->clases()->get();
                
                // Asegúrate de que hay clases asignadas
                if ($clases->isNotEmpty()) {
                    foreach ($clases as $clase) {
                        // Verificamos que la relación docentes() exista y esté cargada correctamente
                        $docentesDeClase = $clase->docentes()->pluck('docentes.id')->toArray();
                        $docentesIds = array_merge($docentesIds, $docentesDeClase);
                    }
                    
                    $docentesIds = array_unique($docentesIds);
                    
                    // Si no hay docentes asignados a sus clases, intentamos obtener el docente titular
                    if (empty($docentesIds)) {
                        foreach ($clases as $clase) {
                            if ($clase->docente_id) {
                                $docentesIds[] = $clase->docente_id;
                            }
                        }
                        $docentesIds = array_unique($docentesIds);
                    }
                    
                    $docentesConChat = Chat::where('tipo', 'docente_estudiante')
                        ->where('estudiante_id', $estudiante->id)
                        ->pluck('docente_id')
                        ->toArray();
                        
                    $docentesSinChat = array_diff($docentesIds, $docentesConChat);
                    
                    if (!empty($docentesSinChat)) {
                        $docentes = Docente::whereIn('id', $docentesSinChat)
                            ->with('user')
                            ->get();
                    } else {
                        // Mostrar todos los docentes relacionados con el estudiante si no hay chats creados
                        $docentes = Docente::whereIn('id', $docentesIds)
                            ->with('user')
                            ->get();
                    }
                } else {
                    // Si el estudiante no tiene clases asignadas, intentamos mostrar el docente del campo docente_id
                    if ($estudiante->docente_id) {
                        $docentes = Docente::where('id', $estudiante->docente_id)
                            ->with('user')
                            ->get();
                    }
                }
                
                // Verificar si hay mensajes sin leer
                foreach ($chats as $chat) {
                    if ($chat->mensajes && $chat->mensajes->isNotEmpty()) {
                        $ultimoMensaje = $chat->mensajes->first(); // Ya ordenados desc
                        if ($ultimoMensaje->user_id !== $user->id && 
                            ($ultimoMensaje->read_at === null || $ultimoMensaje->leido === false)) {
                            $tienesNuevosMensajes = true;
                            break;
                        }
                    }
                }
            }
        }

        // Si es docente
        else if ($user->role_id == 4) {
            $docente = Docente::where('user_id', $user->id)->first();
            if ($docente) {
                // 1. Obtener todos los estudiantes de las clases del docente
                $clases = $docente->clases()->get();
                $estudiantesIds = [];
                
                foreach ($clases as $clase) {
                    // Utilizamos la relación correcta para obtener estudiantes de cada clase
                    $estudiantesDeClase = $clase->estudiantes()->pluck('estudiantes.id')->toArray();
                    $estudiantesIds = array_merge($estudiantesIds, $estudiantesDeClase);
                }
                
                // Si no encontramos estudiantes a través de la relación muchos a muchos,
                // intentamos con el método alternativo por si las clases tienen docente_id
                if (empty($estudiantesIds)) {
                    // Obtener clases donde el docente es el titular
                    $clasesTitular = Clase::where('docente_id', $docente->id)->get();
                    
                    foreach ($clasesTitular as $clase) {
                        $estudiantesDeClase = $clase->estudiantes()->pluck('estudiantes.id')->toArray();
                        $estudiantesIds = array_merge($estudiantesIds, $estudiantesDeClase);
                    }
                }
                
                $estudiantesIds = array_unique($estudiantesIds);
                
                // Si aún no hay estudiantes, buscar por relación directa
                if (empty($estudiantesIds)) {
                    $estudiantesDirectos = Estudiante::where('docente_id', $docente->id)->pluck('id')->toArray();
                    $estudiantesIds = array_merge($estudiantesIds, $estudiantesDirectos);
                    $estudiantesIds = array_unique($estudiantesIds);
                }
                
                $estudiantes = Estudiante::whereIn('id', $estudiantesIds)
                    ->with('user', 'clases')
                    ->get();

                // 2. Obtener todas las empresas para mostrar
                $empresas = Empresa::with('user')->get();

                // 3. Obtener los chats existentes (tanto con estudiantes como con empresas)
                $chats = Chat::where('docente_id', $docente->id)
                    ->where(function($query) {
                        $query->where('tipo', 'docente_estudiante')
                              ->orWhere('tipo', 'docente_empresa');
                    })
                    ->with(['estudiante.user', 'empresa.user', 'mensajes' => function($query) {
                        $query->orderBy('created_at', 'desc');
                    }])
                    ->get();
                    
                // Verificar si hay mensajes sin leer
                foreach ($chats as $chat) {
                    if ($chat->mensajes && $chat->mensajes->isNotEmpty()) {
                        $ultimoMensaje = $chat->mensajes->first(); // Ya ordenados desc
                        if ($ultimoMensaje->user_id !== $user->id && 
                            ($ultimoMensaje->read_at === null || $ultimoMensaje->leido === false)) {
                            $tienesNuevosMensajes = true;
                            break;
                        }
                    }
                }
            }
        }
        
        // Si es institución
        else if ($user->role_id == 5) {
            $institucion = $user->institucion;
            if ($institucion) {
                // 1. Obtener todos los docentes de la institución
                $docentes = Docente::where('institucion_id', $institucion->id)
                    ->with('user')
                    ->get();
                
                // 2. Obtener empresas con convenios con esta institución
                $empresas = Empresa::whereHas('convenios', function($query) use ($institucion) {
                    $query->where('institucion_id', $institucion->id);
                })
                ->with('user')
                ->get();
                
                // 3. Obtener los chats existentes de la institución
                $chats = Chat::where('institucion_id', $institucion->id)
                    ->with(['docente.user', 'empresa.user', 'mensajes' => function($query) {
                        $query->orderBy('created_at', 'desc');
                    }])
                    ->get();
                
                // Verificar si hay mensajes sin leer
                foreach ($chats as $chat) {
                    if ($chat->mensajes && $chat->mensajes->isNotEmpty()) {
                        $ultimoMensaje = $chat->mensajes->first(); // Ya ordenados desc
                        if ($ultimoMensaje->user_id !== $user->id && 
                            ($ultimoMensaje->read_at === null || $ultimoMensaje->leido === false)) {
                            $tienesNuevosMensajes = true;
                            break;
                        }
                    }
                }
            }
        }
        
        return view('chat.index', compact('chats', 'tienesNuevosMensajes', 'estudiantes', 'empresas', 'docentes'));
    }

    public function createDocenteChat(Request $request)
    {
        $user = Auth::user();
        
        // Si el usuario es un docente
        if ($user->role_id == 4) {
            $docente = \App\Models\Docente::where('user_id', $user->id)->first();
            if (!$docente) {
                return redirect()->back()->with('error', 'No se encontró el docente');
            }

            $request->validate([
                'estudiante_id' => 'required|exists:estudiantes,id'
            ]);

            // Verificar si el estudiante está en alguna clase del docente
            $estudiante = \App\Models\Estudiante::whereHas('clases', function($query) use ($docente) {
                $query->whereHas('docentes', function($q) use ($docente) {
                    $q->where('docentes.id', $docente->id);
                });
            })->find($request->estudiante_id);

            if (!$estudiante) {
                // Verificar si el estudiante está en alguna clase donde el docente es el titular
                $estudiante = \App\Models\Estudiante::whereHas('clases', function($query) use ($docente) {
                    $query->where('docente_id', $docente->id);
                })->find($request->estudiante_id);
                
                if (!$estudiante) {
                    return redirect()->back()->with('error', 'No tienes permiso para chatear con este estudiante');
                }
            }

            // Verificar si ya existe un chat
            $existingChat = Chat::where('docente_id', $docente->id)
                ->where('estudiante_id', $estudiante->id)
                ->where('tipo', 'docente_estudiante')
                ->first();

            if ($existingChat) {
                return redirect()->route('chat.show', $existingChat->id);
            }

            // Crear nuevo chat
            $chat = Chat::create([
                'docente_id' => $docente->id,
                'estudiante_id' => $estudiante->id,
                'tipo' => 'docente_estudiante'
            ]);
        } 
        // Si el usuario es un estudiante
        elseif ($user->role_id == 3) {
            $estudiante = \App\Models\Estudiante::where('user_id', $user->id)->first();
            if (!$estudiante) {
                return redirect()->back()->with('error', 'No se encontró el estudiante');
            }

            $request->validate([
                'docente_id' => 'required|exists:docentes,id'
            ]);

            $docente = \App\Models\Docente::find($request->docente_id);
            if (!$docente) {
                return redirect()->back()->with('error', 'No se encontró el docente');
            }
            
            // Verificar si el estudiante está en alguna clase del docente
            $estudianteEnClases = false;
            
            // 1. Comprobar por relación muchos a muchos (docente_clase y estudiante_clase)
            $clasesDelDocente = $docente->clases()->pluck('clases.id')->toArray();
            $clasesDelEstudiante = $estudiante->clases()->pluck('clases.id')->toArray();
            $clasesComunes = array_intersect($clasesDelDocente, $clasesDelEstudiante);
            
            if (!empty($clasesComunes)) {
                $estudianteEnClases = true;
            }
            
            // 2. Comprobar si el docente es titular de alguna clase del estudiante
            if (!$estudianteEnClases) {
                $estudianteEnClases = $estudiante->clases()
                    ->where('docente_id', $docente->id)
                    ->exists();
            }
            
            // 3. Comprobar si hay relación directa entre estudiante y docente
            if (!$estudianteEnClases && $estudiante->docente_id == $docente->id) {
                $estudianteEnClases = true;
            }
            
            // Si no hay relación, permitimos crear el chat de todas formas
            // ya que el docente está listado para el estudiante en la vista

            // Verificar si ya existe un chat
            $existingChat = Chat::where('docente_id', $docente->id)
                ->where('estudiante_id', $estudiante->id)
                ->where('tipo', 'docente_estudiante')
                ->first();

            if ($existingChat) {
                return redirect()->route('chat.show', $existingChat->id);
            }

            // Crear nuevo chat
            $chat = Chat::create([
                'docente_id' => $docente->id,
                'estudiante_id' => $estudiante->id,
                'tipo' => 'docente_estudiante'
            ]);
        } else {
            return redirect()->back()->with('error', 'No tienes permiso para crear este chat');
        }

        return redirect()->route('chat.show', $chat->id)
            ->with('success', 'Chat creado correctamente');
    }

    /**
     * Verificar si hay mensajes nuevos para el usuario autenticado
     */
    public function checkNewMessages()
    {
        $user = Auth::user();
        $hasNewChats = false;
        
        if ($user->role_id == 2) { // Empresa
            $hasNewChats = Chat::where(function($query) use ($user) {
                    $query->where('empresa_id', $user->empresa->id)
                          ->where(function($q) {
                              $q->where('tipo', 'empresa_estudiante')
                                ->orWhere('tipo', 'docente_empresa');
                          });
                })
                ->whereHas('mensajes', function($query) use ($user) {
                    $query->where('user_id', '!=', $user->id)
                          ->where(function($q) {
                              $q->whereNull('read_at')
                                ->orWhere('leido', false);
                          });
                })
                ->exists();
        } elseif ($user->role_id == 3) { // Estudiante
            $hasNewChats = Chat::whereHas('solicitud', function($query) use ($user) {
                $query->where('estudiante_id', $user->estudiante->id);
            })
            ->whereHas('mensajes', function($query) use ($user) {
                $query->where('user_id', '!=', $user->id)
                      ->where(function($q) {
                          $q->whereNull('read_at')
                            ->orWhere('leido', false);
                      });
            })
            ->exists();
        } elseif ($user->role_id == 4) { // Docente
            $docente = \App\Models\Docente::where('user_id', $user->id)->first();
            if ($docente) {
                $hasNewChats = Chat::where(function($query) use ($docente) {
                        $query->where('docente_id', $docente->id)
                              ->where(function($q) {
                                  $q->where('tipo', 'docente_estudiante')
                                    ->orWhere('tipo', 'docente_empresa');
                              });
                    })
                    ->whereHas('mensajes', function($query) use ($user) {
                        $query->where('user_id', '!=', $user->id)
                              ->where(function($q) {
                                  $q->whereNull('read_at')
                                    ->orWhere('leido', false);
                              });
                    })
                    ->exists();
            }
        } elseif ($user->role_id == 5) { // Institución
            $institucion = $user->institucion;
            if ($institucion) {
                $hasNewChats = Chat::where('institucion_id', $institucion->id)
                    ->whereHas('mensajes', function($query) use ($user) {
                        $query->where('user_id', '!=', $user->id)
                              ->where(function($q) {
                                  $q->whereNull('read_at')
                                    ->orWhere('leido', false);
                              });
                    })
                    ->exists();
            } else {
                $hasNewChats = false;
            }
        }
        
        return response()->json([
            'has_new_chats' => $hasNewChats
        ]);
    }
    
    /**
     * Refrescar la vista de chats (útil para cuando el estudiante no ve los chats nuevos)
     */
    public function refreshChats()
    {
        // Simplemente redirigimos a la vista de chats con un indicador para forzar la consulta
        return redirect()->route('chat.index', ['refresh' => true])
            ->with('info', 'Lista de conversaciones actualizada');
    }

    /**
     * Marcar un mensaje como leído
     */
    public function markMessageAsRead($messageId)
    {
        $mensaje = Mensaje::findOrFail($messageId);
        $user = Auth::user();
        
        // Verificar que el usuario tenga acceso al mensaje
        $chat = $mensaje->chat;
        $hasAccess = false;
        
        // Si es empresa en chat empresa-estudiante
        if ($user->empresa && $chat->tipo == 'empresa_estudiante' && $user->empresa->id == $chat->empresa_id) {
            $hasAccess = true;
        }
        
        // Si es estudiante en chat empresa-estudiante
        if ($user->estudiante && $chat->tipo == 'empresa_estudiante' && $chat->solicitud && $chat->solicitud->estudiante_id == $user->estudiante->id) {
            $hasAccess = true;
        }
        
        // Si es docente en chat docente-estudiante
        if ($user->role_id == 4 && $chat->tipo == 'docente_estudiante') {
            $docente = \App\Models\Docente::where('user_id', $user->id)->first();
            if ($docente && $chat->docente_id == $docente->id) {
                $hasAccess = true;
            }
        }
        
        // Si es estudiante en chat docente-estudiante
        if ($user->estudiante && $chat->tipo == 'docente_estudiante' && $chat->estudiante_id == $user->estudiante->id) {
            $hasAccess = true;
        }
        
        if (!$hasAccess) {
            return response()->json(['error' => true, 'message' => 'No tienes acceso a este mensaje'], 403);
        }
        
        // Solo marcar como leído si no soy yo quien lo envió
        if ($mensaje->user_id != $user->id) {
            $mensaje->leido = true;
            $mensaje->read_at = now();
            $mensaje->save();
        }
        
        return response()->json(['success' => true]);
    }

    /**
     * Crear un chat entre docente y empresa
     */
    public function createDocenteEmpresaChat(Request $request)
    {
        $user = Auth::user();
        
        // Verificar que el usuario sea un docente
        if ($user->role_id != 4) {
            return redirect()->back()->with('error', 'No tienes permiso para crear este chat');
        }

        $docente = \App\Models\Docente::where('user_id', $user->id)->first();
        if (!$docente) {
            return redirect()->back()->with('error', 'No se encontró el docente');
        }

        $request->validate([
            'empresa_id' => 'required|exists:empresas,id'
        ]);

        // Verificar si ya existe un chat
        $existingChat = Chat::where('docente_id', $docente->id)
            ->where('empresa_id', $request->empresa_id)
            ->where('tipo', 'docente_empresa')
            ->first();

        if ($existingChat) {
            return redirect()->route('chat.show', $existingChat->id);
        }

        // Crear nuevo chat
        $chat = Chat::create([
            'docente_id' => $docente->id,
            'empresa_id' => $request->empresa_id,
            'tipo' => 'docente_empresa'
        ]);

        return redirect()->route('chat.show', $chat->id)
            ->with('success', 'Chat creado correctamente');
    }
}

