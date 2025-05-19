<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Estudiante extends Model
{
    use HasFactory;

    protected $table = 'estudiantes';

    protected $fillable = [
        'id',
        'user_id',
        'institucion_id',
        'docente_id',
        'clase_id',
        'curso',
        'grupo',
        'centro_educativo',
        'cv_pdf',
        'numero_seguridad_social',
        'titulo_id',
        'conocimientos_previos',
        'intereses',
        'activo'
    ];

    // Indicar que la clave primaria no es autoincremental
    public $incrementing = false;

    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'id');
    }

    public function institucion()
    {
        return $this->belongsTo(Institucion::class);
    }

    public function docente()
    {
        return $this->belongsTo(Docente::class);
    }

    /**
     * Relación directa con una clase (LEGACY) - Mantener por compatibilidad
     */
    public function clase()
    {
        return $this->belongsTo(Clase::class);
    }

    /**
     * Relación muchos a muchos con clases a través de la tabla pivote
     */
    public function clases()
    {
        return $this->belongsToMany(Clase::class, 'estudiante_clase')
                    ->withPivot('fecha_asignacion', 'fecha_finalizacion', 'estado', 'calificacion', 'comentarios')
                    ->withTimestamps();
    }

    /**
     * Obtiene las asignaciones de este estudiante a clases
     */
    public function estudianteClases()
    {
        return $this->hasMany(EstudianteClase::class);
    }

    public function tutores()
    {
        return $this->belongsToMany(Tutor::class, 'alumno_tutores');
    }

    public function experiencias()
    {
        return $this->hasMany(Experiencia::class);
    }

    public function solicitudes()
    {
        return $this->hasMany(Solicitud::class);
    }

    public function solicitudesInstituciones()
    {
        return $this->hasMany(SolicitudEstudiante::class);
    }

    public function titulo()
    {
        return $this->belongsTo(Titulo::class, 'titulo_id');
    }
}
