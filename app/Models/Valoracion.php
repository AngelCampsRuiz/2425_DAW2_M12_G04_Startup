<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Valoracion extends Model
{
    use HasFactory;

    protected $table = 'valoraciones';

    protected $fillable = [
        'puntuacion',
        'comentario',
        'fecha_valoracion',
        'tipo',
        'emisor_id',
        'receptor_id',
        'convenio_id'
    ];

    protected $casts = [
        'fecha_valoracion' => 'datetime',
        'puntuacion' => 'integer'
    ];

    // Relación con el usuario que emite la valoración
    public function emisor()
    {
        return $this->belongsTo(User::class, 'emisor_id');
    }

    // Relación con el usuario que recibe la valoración
    public function receptor()
    {
        return $this->belongsTo(User::class, 'receptor_id');
    }

    // Relación con el convenio
    public function convenio()
    {
        return $this->belongsTo(Convenio::class);
    }
}
