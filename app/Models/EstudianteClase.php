<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstudianteClase extends Model
{
    use HasFactory;

    protected $table = 'estudiante_clase';
    
    /**
     * Los atributos que son asignables masivamente.
     *
     * @var array
     */
    protected $fillable = [
        'estudiante_id',
        'clase_id',
        'fecha_asignacion',
        'fecha_finalizacion',
        'estado',
        'calificacion',
        'comentarios',
    ];

    /**
     * Los atributos que deben convertirse a tipos nativos.
     *
     * @var array
     */
    protected $casts = [
        'fecha_asignacion' => 'datetime',
        'fecha_finalizacion' => 'datetime',
    ];

    /**
     * Obtiene el estudiante asociado a esta relación.
     */
    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class);
    }

    /**
     * Obtiene la clase asociada a esta relación.
     */
    public function clase()
    {
        return $this->belongsTo(Clase::class);
    }
} 