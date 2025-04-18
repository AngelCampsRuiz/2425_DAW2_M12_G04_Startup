<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Chat extends Model
{
    use HasFactory;

    protected $table = 'chats';

    protected $fillable = ['empresa_id', 'solicitud_id'];

    public function mensajes()
    {
        return $this->hasMany(Mensaje::class);
    }

    public function solicitud()
    {
        return $this->belongsTo(Solicitud::class);
    }

    public function estudiante()
    {
        return $this->hasOneThrough(
            Estudiante::class,
            Solicitud::class,
            'id', // Clave foránea en solicitudes
            'id', // Clave local en estudiantes
            'solicitud_id', // Clave local en chats
            'estudiante_id' // Clave foránea en solicitudes
        );
    }

    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }
}
