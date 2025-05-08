<?php

namespace App\Http\Controllers;

use App\Services\NotificationService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function getUnreadNotifications()
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json([], 401);
        }

        // Obtén las notificaciones no leídas
        $notifications = $user->unreadNotifications->map(function ($notification) {
            $data = $notification->data;
            $url = '#';
            // Lógica para la URL según el tipo
            switch ($data['type'] ?? null) {
                case 'mensaje_no_leido':
                case 'App\\Notifications\\MensajeNoLeidoNotification':
                    // Suponiendo que tienes el chat_id en $data['chat_id']
                    $url = isset($data['chat_id']) ? route('chat.show', $data['chat_id']) : '#';
                    break;
                case 'nueva_solicitud':
                case 'App\\Notifications\\AlumnoSuscritoNotification':
                    // Suponiendo que tienes publicacion_id
                    $url = isset($data['publicacion_id']) ? route('empresa.applications.view', $data['publicacion_id']) : '#';
                    break;
                case 'respuesta_publicacion':
                case 'App\\Notifications\\SolicitudEstadoNotification':
                case 'solicitud_estado':
                    // El estudiante puede ver la publicación
                    $url = isset($data['publicacion_id']) ? route('publication.show', $data['publicacion_id']) : '#';
                    break;
                default:
                    $url = '#';
            }
            return [
                'id' => $notification->id,
                'title' => $data['title'] ?? '',
                'message' => $data['message'] ?? '',
                'type' => $data['type'] ?? null,
                'estado' => $data['estado'] ?? null,
                'created_at' => $notification->created_at->toDateTimeString(),
                'url' => $url,
            ];
        });

        return response()->json($notifications);
    }

    public function markAsRead($id)
{
    $notification = auth()->user()->notifications()->find($id);
    if ($notification) {
        $notification->markAsRead(); // Esto actualiza el campo read_at
    }
    return response()->json(['success' => true]);
}

    public function markAllAsRead()
    {
        auth()->user()->notifications()->update(['is_read' => true]);
        return response()->json(['message' => 'All notifications marked as read']);
    }
}
