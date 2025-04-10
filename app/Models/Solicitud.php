<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Solicitud extends Model
{
    use HasFactory;

    protected $table = 'solicitudes';

    protected $fillable = [
        'estudiante_id',
        'publicacion_id',
        'estado',
        'mensaje',
        'respuesta_empresa'
    ];

    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class);
    }

    public function publicacion()
    {
        return $this->belongsTo(Publicacion::class, 'publicacion_id');
    }
}