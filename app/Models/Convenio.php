<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Convenio extends Model
{
    use HasFactory;

    protected $table = 'convenios';

    protected $fillable = [
        'documento_pdf',
        'activo',
        'fecha_aprobacion',
        'tutor_id',
        'seguimiento_id',
        'oferta_id',
        'estudiante_id',
        'empresa_id',
        'fecha_inicio',
        'fecha_fin',
        'horario_practica',
        'tutor_empresa',
        'tareas',
        'objetivos',
        'estado',
        'fecha_creacion'
    ];

    protected $casts = [
        'activo' => 'boolean',
        'fecha_aprobacion' => 'datetime',
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
        'fecha_creacion' => 'datetime'
    ];

    public function seguimiento()
    {
        return $this->belongsTo(Seguimiento::class);
    }

    public function tutor()
    {
        return $this->belongsTo(Tutor::class);
    }

    public function valoraciones()
    {
        return $this->hasMany(Valoracion::class);
    }

    public function oferta()
    {
        return $this->belongsTo(Publicacion::class, 'oferta_id');
    }

    public function estudiante()
    {
        return $this->belongsTo(User::class, 'estudiante_id');
    }
}
