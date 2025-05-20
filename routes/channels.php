<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\Chat;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

// Canal para mensajes de chat
Broadcast::channel('chat.{chatId}', function ($user, $chatId) {
    $chat = Chat::find($chatId);
    
    if (!$chat) {
        return false;
    }
    
    // Verificar si el usuario tiene acceso al chat
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
    
    // Si es docente en chat docente-empresa
    if ($user->role_id == 4 && $chat->tipo == 'docente_empresa') {
        $docente = \App\Models\Docente::where('user_id', $user->id)->first();
        if ($docente && $chat->docente_id == $docente->id) {
            $hasAccess = true;
        }
    }
    
    // Si es empresa en chat docente-empresa
    if ($user->empresa && $chat->tipo == 'docente_empresa' && $user->empresa->id == $chat->empresa_id) {
        $hasAccess = true;
    }
    
    // Si es estudiante en chat docente-estudiante
    if ($user->estudiante && $chat->tipo == 'docente_estudiante' && $chat->estudiante_id == $user->estudiante->id) {
        $hasAccess = true;
    }
    
    return $hasAccess;
});

// Canal para notificaciones de usuario
Broadcast::channel('user.{userId}', function ($user, $userId) {
    return (int) $user->id === (int) $userId;
}); 