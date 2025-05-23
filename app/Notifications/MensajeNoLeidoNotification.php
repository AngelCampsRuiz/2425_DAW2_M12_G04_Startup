<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Chat;

class MensajeNoLeidoNotification extends Notification
{
    use Queueable;

    protected $chat;
    protected $sender;

    /**
     * Create a new notification instance.
     */
    public function __construct($chat, $sender)
    {
        $this->chat = $chat;
        $this->sender = $sender;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'title' => 'Tienes mensajes sin leer',
            'message' => 'Tienes un mensaje de ' . $this->sender->nombre . ' en el chat.',
            'sender_id' => $this->sender->id,
            'sender_name' => $this->sender->nombre,
            'chat_id' => $this->chat->id,
            'type' => 'mensaje_no_leido'
        ];
    }

    public function toArray($notifiable)
    {
        return [
            'title' => 'Tienes mensajes sin leer',
            'message' => 'Tienes un mensaje de ' . $this->sender->nombre . ' en el chat.',
            'sender_id' => $this->sender->id,
            'sender_name' => $this->sender->nombre,
            'chat_id' => $this->chat->id,
            'type' => 'mensaje_no_leido'
        ];
    }
}
