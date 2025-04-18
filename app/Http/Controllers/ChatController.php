<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Mensaje;
use App\Models\Solicitud;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            'contenido' => 'required|string|max:1000'
        ]);

        // Crear el mensaje
        $mensaje = Mensaje::create([
            'contenido' => $request->contenido,
            'chat_id' => $chat->id,
            'user_id' => $user->id,
            'fecha_envio' => now()
        ]);

        return response()->json([
            'error' => false,
            'message' => 'Mensaje enviado correctamente',
            'mensaje' => $mensaje
        ]);
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

        // Obtener los mensajes
        $mensajes = Mensaje::where('chat_id', $chat->id)
            ->with('user')
            ->orderBy('created_at', 'asc')
            ->get();

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

        // Obtener los mensajes
        $mensajes = Mensaje::where('chat_id', $chat->id)
            ->with('user')
            ->orderBy('created_at', 'asc')
            ->get();

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
        $chats = [];
        
        // Si es empresa
        if ($user->empresa) {
            $chats = Chat::where('empresa_id', $user->empresa->id)
                ->with(['solicitud.estudiante.user', 'solicitud.publicacion'])
                ->get();
        }
        
        // Si es estudiante
        if ($user->estudiante) {
            $chats = Chat::whereHas('solicitud', function ($query) use ($user) {
                $query->where('estudiante_id', $user->estudiante->id);
            })->with(['solicitud.publicacion.empresa.user', 'solicitud.publicacion'])
              ->get();
        }
        
        return view('chat.index', compact('chats'));
    }
}
