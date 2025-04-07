<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seguimiento extends Model
{
    protected $table = 'seguimiento';

    protected $fillable = [
        'estado',
        'fecha_solicitud',
        'empresa_id',
        'alumno_id'
    ];

    protected $casts = [
        'fecha_solicitud' => 'datetime'
    ];

    // Relación con Empresa
    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }

    // Relación con Estudiante
    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class, 'alumno_id');
    }

    // Relación con Convenio
    public function convenio()
    {
        return $this->hasOne(Convenio::class);
    }
}
