<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NivelEducativo extends Model
{
    use HasFactory;

    /**
     * Nombre de la tabla en la base de datos.
     *
     * @var string
     */
    protected $table = 'niveles_educativos';

    /**
     * Los atributos que son asignables en masa.
     *
     * @var array
     */
    protected $fillable = [
        'nombre_nivel',
    ];

    /**
     * Obtiene las instituciones que ofrecen este nivel educativo.
     */
    public function instituciones()
    {
        return $this->belongsToMany(Institucion::class, 'institucion_nivel_educativo');
    }

    /**
     * Obtiene las categorías asociadas a este nivel educativo.
     */
    public function categorias()
    {
        return $this->belongsToMany(Categoria::class, 'institucion_categoria');
    }

    // Relación a través de categorías para obtener publicaciones
    public function publicaciones()
    {
        return $this->hasManyThrough(
            Publicacion::class,
            Categoria::class,
            'nivel_educativo_id', // Clave externa en categorias
            'categoria_id', // Clave externa en publicaciones
            'id', // Clave local en niveles_educativos
            'id' // Clave local en categorias
        );
    }
} 