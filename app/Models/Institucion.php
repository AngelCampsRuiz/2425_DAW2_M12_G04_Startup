<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Institucion extends Model
{
    use HasFactory;

    /**
     * Nombre de la tabla en la base de datos.
     *
     * @var string
     */
    protected $table = 'instituciones';

    /**
     * Los atributos que son asignables en masa.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'codigo_centro',
        'direccion',
        'ciudad',
        'codigo_postal',
        'representante_legal',
        'cargo_representante',
        'verificada',
    ];

    protected $casts = [
        'verificada' => 'boolean'
    ];

    /**
     * Obtener el usuario asociado a esta institución.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Obtiene los docentes de esta institución.
     */
    public function docentes()
    {
        return $this->hasMany(Docente::class);
    }

    public function estudiantes()
    {
        return $this->hasMany(Estudiante::class);
    }

    /**
     * Obtiene los departamentos de esta institución.
     */
    public function departamentos()
    {
        return $this->hasMany(Departamento::class);
    }

    /**
     * Obtiene las clases de esta institución.
     */
    public function clases()
    {
        return $this->hasMany(Clase::class);
    }

    public function solicitudesEstudiantes()
    {
        return $this->hasMany(SolicitudEstudiante::class);
    }

    /**
     * Obtiene los niveles educativos que imparte esta institución.
     */
    public function nivelesEducativos()
    {
        return $this->belongsToMany(NivelEducativo::class, 'institucion_nivel_educativo');
    }

    /**
     * Obtiene las categorías (ciclos formativos) que ofrece esta institución.
     */
    public function categorias()
    {
        return $this->belongsToMany(Categoria::class, 'institucion_categoria')
            ->withPivot('nivel_educativo_id', 'nombre_personalizado', 'descripcion', 'activo');
    }

    /**
     * Obtiene las categorías filtradas por nivel educativo.
     */
    public function categoriasPorNivel($nivelId)
    {
        return $this->categorias()->wherePivot('nivel_educativo_id', $nivelId);
    }

    // Métodos útiles
    
    // Obtener solicitudes pendientes
    public function solicitudesPendientes()
    {
        return $this->solicitudesEstudiantes()->where('estado', 'pendiente');
    }

    // Verificar si un estudiante ya ha enviado una solicitud
    public function tieneSolicitudDeEstudiante($estudiante_id)
    {
        return $this->solicitudesEstudiantes()
            ->where('estudiante_id', $estudiante_id)
            ->whereIn('estado', ['pendiente', 'aprobada'])
            ->exists();
    }
} 