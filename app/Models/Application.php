<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $table = 'solicitudes';

    protected $fillable = [
        'estudiante_id',
        'publicacion_id',
        'estado',
        'mensaje'
    ];

    protected $attributes = [
        'estado' => 'pendiente'
    ];

    public function student()
    {
        return $this->belongsTo(Estudiante::class, 'estudiante_id');
    }

    public function publication()
    {
        return $this->belongsTo(Publication::class, 'publicacion_id');
    }
} 