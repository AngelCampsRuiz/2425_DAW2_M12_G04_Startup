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
            return [
                'id' => $notification->id,
                'title' => $data['title'] ?? '',
                'message' => $data['message'] ?? '',
                'created_at' => $notification->created_at->toDateTimeString(),
                // Puedes agregar más campos si lo necesitas
            ];
        });

        return response()->json($notifications);
    }

    public function markAsRead($id)
    {
        $notification = $this->notificationService->markAsRead($id);
        return response()->json($notification);
    }

    public function markAllAsRead()
    {
        auth()->user()->notifications()->update(['is_read' => true]);
        return response()->json(['message' => 'All notifications marked as read']);
    }
}
