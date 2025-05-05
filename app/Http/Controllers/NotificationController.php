<?php

namespace App\Http\Controllers;

use App\Services\NotificationService;
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
        if (!auth()->check()) {
            return response()->json([], 401); // No autorizado
        }
        $notifications = $this->notificationService->getUnreadNotifications(auth()->id());
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
