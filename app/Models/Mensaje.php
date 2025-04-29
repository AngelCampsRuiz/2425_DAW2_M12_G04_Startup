<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mensaje extends Model
{
    use HasFactory;

    protected $table = 'mensajes';

    protected $fillable = [
        'contenido',
        'chat_id',
        'user_id',
        'fecha_envio',
        'archivo_adjunto',
        'tipo_archivo',
        'nombre_archivo',
        'leido'
    ];

    protected $casts = [
        'leido' => 'boolean',
        'fecha_envio' => 'datetime'
    ];

    public function chat()
    {
        return $this->belongsTo(Chat::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
