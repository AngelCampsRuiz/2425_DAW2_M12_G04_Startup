<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Mensaje;
use App\Models\Solicitud;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\MensajeNoLeidoNotification;
use App\Events\NotificacionPusher;

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

            // Determinar destinatario según el usuario autenticado
            if (auth()->user()->empresa) {
                // Si el que envía es empresa, destinatario es el estudiante
                $destinatario = $chat->solicitud->estudiante->user ?? null;
            } else {
                // Si el que envía es estudiante, destinatario es la empresa
                $destinatario = $chat->solicitud->publicacion->empresa->user ?? null;
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

        // Determinar el otro usuario del chat
        $otherUser = null;
        if ($user->empresa) {
            $otherUser = $solicitud->estudiante->user;
        } else {
            $otherUser = $solicitud->publicacion->empresa->user;
        }

        return view('chat.show', compact('chat', 'mensajes', 'otherUser', 'solicitud'));
    }

    /**
     * Listar todos los chats del usuario
     */
    public function index()
    {
        $user = Auth::user();
        // Asegurarnos de que el rol está cargado
        $user->load('role');
        $chats = collect();

        // Si es empresa
        if ($user->role_id == 2) {
            $chats = Chat::where('empresa_id', $user->empresa->id)
                ->where('tipo', 'empresa_estudiante')
                ->with(['solicitud.estudiante.user', 'solicitud.publicacion'])
                ->get();
        }

        // Si es estudiante
        if ($user->role_id == 3) {
            $chats = Chat::where('estudiante_id', $user->estudiante->id)
                ->with(['solicitud.publicacion.empresa.user', 'solicitud.publicacion', 'docente.user'])
                ->get();
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

                // Obtener los chats existentes
                $chats = Chat::where('docente_id', $docente->id)
                    ->where('tipo', 'docente_estudiante')
                    ->with(['estudiante.user'])
                    ->get();

                return view('chat.index', compact('chats', 'estudiantes'));
            }
        }

        return view('chat.index', compact('chats'));
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
}
