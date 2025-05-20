<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Mensaje;
use App\Models\Solicitud;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\MensajeNoLeidoNotification;
use App\Events\NotificacionPusher;
use App\Events\MessageSent;

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

            // Determinar destinatario según el usuario autenticado y tipo de chat
            $destinatario = null;
            
            if ($chat->tipo == 'empresa_estudiante') {
                if (auth()->user()->empresa) {
                    // Si el que envía es empresa, destinatario es el estudiante
                    $destinatario = $chat->solicitud->estudiante->user ?? null;
                } else {
                    // Si el que envía es estudiante, destinatario es la empresa
                    $destinatario = $chat->solicitud->publicacion->empresa->user ?? null;
                }
            } else if ($chat->tipo == 'docente_estudiante') {
                if (auth()->user()->role_id == 4) {
                    // Si el que envía es docente, destinatario es el estudiante
                    $destinatario = $chat->estudiante->user ?? null;
                } else {
                    // Si el que envía es estudiante, destinatario es el docente
                    $destinatario = $chat->docente->user ?? null;
                }
            } else if ($chat->tipo == 'docente_empresa') {
                if (auth()->user()->role_id == 4) {
                    // Si el que envía es docente, destinatario es la empresa
                    $destinatario = $chat->empresa->user ?? null;
                } else {
                    // Si el que envía es empresa, destinatario es el docente
                    $destinatario = $chat->docente->user ?? null;
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

        // Si es empresa
        if ($user->role_id == 2) {
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
                if ($chat->mensajes->isNotEmpty()) {
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
        if ($user->role_id == 3) {
            // Incluir consulta para obtener chats incluso si no los ha visto antes
            $query = Chat::whereHas('solicitud', function($query) use ($user) {
                $query->where('estudiante_id', $user->estudiante->id);
            });
            
            // Si solicitó refrescar, forzar la búsqueda de chats no vistos antes
            if ($request->has('refresh')) {
                // Asegurarse de que todas las solicitudes aceptadas tienen un chat
                $solicitudesAceptadas = Solicitud::where('estudiante_id', $user->estudiante->id)
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
            }
            
            $chats = $query->with(['solicitud.publicacion.empresa.user', 'solicitud.publicacion', 'mensajes' => function($query) {
                $query->orderBy('created_at', 'desc');
            }])
            ->get();
            
            // Verificar si hay mensajes sin leer
            foreach ($chats as $chat) {
                if ($chat->mensajes->isNotEmpty()) {
                    $ultimoMensaje = $chat->mensajes->first(); // Ya ordenados desc
                    if ($ultimoMensaje->user_id !== $user->id && 
                        ($ultimoMensaje->read_at === null || $ultimoMensaje->leido === false)) {
                        $tienesNuevosMensajes = true;
                        break;
                    }
                }
            }
        }

        // Si es docente
        if ($user->role_id == 4) {
            $docente = \App\Models\Docente::where('user_id', $user->id)->first();
            if ($docente) {
                // Obtener todos los estudiantes de las clases del docente
                $estudiantes = \App\Models\Estudiante::whereHas('clases', function($query) use ($docente) {
                    $query->where('docente_id', $docente->id);
                })->with(['user', 'clases' => function($query) use ($docente) {
                    $query->where('docente_id', $docente->id);
                }])->get();

                // Obtener todas las empresas que tienen convenios o publicaciones
                $empresas = \App\Models\Empresa::with('user')->get();

                // Obtener los chats existentes
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
                    if ($chat->mensajes->isNotEmpty()) {
                        $ultimoMensaje = $chat->mensajes->first(); // Ya ordenados desc
                        if ($ultimoMensaje->user_id !== $user->id && 
                            ($ultimoMensaje->read_at === null || $ultimoMensaje->leido === false)) {
                            $tienesNuevosMensajes = true;
                            break;
                        }
                    }
                }

                return view('chat.index', compact('chats', 'estudiantes', 'empresas', 'tienesNuevosMensajes'));
            }
        }

        return view('chat.index', compact('chats', 'tienesNuevosMensajes'));
    }

    public function createDocenteChat(Request $request)
    {
        $user = Auth::user();
        if ($user->role_id != 4) {
            return redirect()->back()->with('error', 'No tienes permiso para crear este chat');
        }

        $docente = \App\Models\Docente::where('user_id', $user->id)->first();
        if (!$docente) {
            return redirect()->back()->with('error', 'No se encontró el docente');
        }

        $request->validate([
            'estudiante_id' => 'required|exists:estudiantes,id'
        ]);

        // Verificar si el estudiante está en alguna clase del docente
        $estudiante = \App\Models\Estudiante::whereHas('clases', function($query) use ($docente) {
            $query->where('docente_id', $docente->id);
        })->find($request->estudiante_id);

        if (!$estudiante) {
            return redirect()->back()->with('error', 'No tienes permiso para chatear con este estudiante');
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

