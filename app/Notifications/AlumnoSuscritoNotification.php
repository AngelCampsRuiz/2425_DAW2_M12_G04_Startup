<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AlumnoSuscritoNotification extends Notification
{
    use Queueable;

    protected $alumno;

    /**
     * Create a new notification instance.
     */
    public function __construct($alumno)
    {
        $this->alumno = $alumno;
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
            'title' => 'Nueva solicitud de alumno',
            'message' => 'Has recibido una solicitud de ' . $this->alumno->nombre . ' (' . $this->alumno->email . ')',
            'alumno_id' => $this->alumno->id,
            'type' => 'alumno_suscrito'
        ];
    }
}
