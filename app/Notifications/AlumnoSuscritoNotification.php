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
    protected $publicacion;

    /**
     * Create a new notification instance.
     */
    public function __construct($alumno, $publicacion)
    {
        $this->alumno = $alumno;
        $this->publicacion = $publicacion;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Nueva solicitud de alumno')
            ->markdown('emails.notificacion', [
                'subject' => 'Nueva solicitud de alumno',
                'greeting' => '¡Hola ' . $notifiable->nombre . '!',
                'line1' => 'Has recibido una nueva solicitud de ' . $this->alumno->nombre . ' (' . $this->alumno->email . ') para tu publicación "' . $this->publicacion->titulo . '".',
                'actionText' => 'Ver solicitudes',
                'actionUrl' => url('/empresa/ofertas/' . $this->publicacion->id . '/solicitudes'),
                'actionColor' => 'primary',
                'line2' => '¡Entra en la plataforma para gestionarla!',
            ]);
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
            'publicacion_id' => $this->publicacion->id,
            'type' => 'nueva_solicitud'
        ];
    }
}
