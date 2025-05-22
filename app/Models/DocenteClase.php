<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocenteClase extends Model
{
    use HasFactory;

    protected $table = 'docente_clase';

    protected $fillable = [
        'docente_id',
        'clase_id',
        'fecha_asignacion',
        'es_titular',
        'rol'
    ];

    protected $casts = [
        'fecha_asignacion' => 'datetime',
        'es_titular' => 'boolean',
    ];

    public function docente()
    {
        return $this->belongsTo(Docente::class);
    }

    public function clase()
    {
        return $this->belongsTo(Clase::class);
    }
}