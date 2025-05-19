<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clase extends Model
{
    use HasFactory;

    protected $table = 'clases';

    protected $fillable = [
        'institucion_id',
        'departamento_id',
        'docente_id',
        'nombre',
        'codigo',
        'nivel',
        'curso',
        'grupo',
        'descripcion',
        'capacidad',
        'horario',
        'activa',
        'nivel_educativo_id',
        'categoria_id'
    ];

    protected $casts = [
        'activa' => 'boolean',
        'capacidad' => 'integer'
    ];

    public function institucion()
    {
        return $this->belongsTo(Institucion::class);
    }

    public function departamento()
    {
        return $this->belongsTo(Departamento::class);
    }

    public function docente()
    {
        return $this->belongsTo(Docente::class);
    }

    /**
     * Relación directa con estudiantes (LEGACY) - Mantener por compatibilidad
     */
    public function estudiantesDirectos()
    {
        return $this->hasMany(Estudiante::class);
    }
    
    /**
     * Relación muchos a muchos con estudiantes a través de la tabla pivote
     */
    public function estudiantes()
    {
        return $this->belongsToMany(Estudiante::class, 'estudiante_clase')
                    ->withPivot('fecha_asignacion', 'fecha_finalizacion', 'estado', 'calificacion', 'comentarios')
                    ->withTimestamps();
    }
    
    /**
     * Obtiene las asignaciones de estudiantes a esta clase
     */
    public function estudiantesClase()
    {
        return $this->hasMany(EstudianteClase::class);
    }

    public function solicitudes()
    {
        return $this->hasMany(SolicitudEstudiante::class);
    }
} 