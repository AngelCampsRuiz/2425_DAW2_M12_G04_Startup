<?php

namespace App\Events;

use App\Models\Mensaje;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $mensaje;
    public $user;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Mensaje $mensaje, User $user)
    {
        $this->mensaje = $mensaje;
        $this->user = $user;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('chat.' . $this->mensaje->chat_id);
    }

    /**
     * Get the data to broadcast.
     *
     * @return array
     */
    public function broadcastWith()
    {
        // Preparar datos estructurados para el frontend
        $data = [
            'id' => $this->mensaje->id,
            'contenido' => $this->mensaje->contenido,
            'user_id' => $this->mensaje->user_id,
            'chat_id' => $this->mensaje->chat_id,
            'created_at' => $this->mensaje->created_at,
            'leido' => $this->mensaje->leido,
            'user' => [
                'id' => $this->user->id,
                'nombre' => $this->user->nombre,
                'imagen' => $this->user->imagen,
                'role_id' => $this->user->role_id
            ]
        ];

        // Si hay un archivo adjunto, agregar la URL completa
        if ($this->mensaje->archivo_adjunto) {
            $data['archivo_adjunto'] = url($this->mensaje->archivo_adjunto);
            $data['tipo_archivo'] = $this->mensaje->tipo_archivo;
            $data['nombre_archivo'] = $this->mensaje->nombre_archivo;
        }

        return $data;
    }
} 