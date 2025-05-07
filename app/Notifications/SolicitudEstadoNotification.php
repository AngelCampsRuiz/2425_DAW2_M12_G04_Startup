<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SolicitudEstadoNotification extends Notification
{
    use Queueable;

    protected $estado;
    protected $empresa;
    protected $publicacion;

    /**
     * Create a new notification instance.
     */
    public function __construct($estado, $empresa, $publicacion)
    {
        $this->estado = $estado; // 'aceptada' o 'rechazada'
        $this->empresa = $empresa; // objeto empresa
        $this->publicacion = $publicacion; // objeto publicación
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
        $estadoTexto = $this->estado === 'aceptada' ? 'aceptada' : 'rechazada';
        $color = $this->estado === 'aceptada' ? 'success' : 'error';

        return (new MailMessage)
            ->subject('Estado de tu solicitud')
            ->markdown('emails.notificacion', [
                'subject' => 'Estado de tu solicitud',
                'greeting' => '¡Hola ' . $notifiable->nombre . '!',
                'line1' => 'Tu solicitud ha sido ' . $estadoTexto . ' en la publicación "' . $this->publicacion->titulo . '" de la empresa ' . $this->empresa->user->nombre . '.',
                'actionText' => 'Ver publicación',
                'actionUrl' => url('/publication/' . $this->publicacion->id),
                'actionColor' => $color,
                'line2' => '¡Gracias por usar NextGen!',
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
            'title' => 'Estado de tu solicitud',
            'message' => 'Tu solicitud ha sido ' . $this->estado . ' en la publicación "' . $this->publicacion->titulo . '" de la empresa ' . $this->empresa->user->nombre,
            'estado' => $this->estado,
            'empresa_id' => $this->empresa->id,
            'publicacion_id' => $this->publicacion->id,
            'type' => 'respuesta_publicacion'
        ];
    }
}
