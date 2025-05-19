<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Categoria extends Model
{
    use HasFactory;

    /**
     * Nombre de la tabla en la base de datos.
     *
     * @var string
     */
    protected $table = 'categorias';

    /**
     * Los atributos que son asignables en masa.
     *
     * @var array
     */
    protected $fillable = [
        'nombre_categoria',
        'nivel_educativo_id',
        'activo',
    ];

    /**
     * Obtiene el nivel educativo al que pertenece esta categoría.
     */
    public function nivelEducativo()
    {
        return $this->belongsTo(NivelEducativo::class, 'nivel_educativo_id');
    }

    /**
     * Obtiene las subcategorías de esta categoría.
     */
    public function subcategorias()
    {
        return $this->hasMany(Subcategoria::class);
    }

    /**
     * Obtiene las publicaciones de esta categoría.
     */
    public function publicaciones()
    {
        return $this->hasMany(Publicacion::class);
    }

    /**
     * Obtiene los niveles educativos relacionados con esta categoría.
     */
    public function nivelesEducativos()
    {
        return $this->belongsToMany(NivelEducativo::class, 'institucion_categoria');
    }

    /**
     * Obtiene las instituciones que ofrecen esta categoría.
     */
    public function instituciones()
    {
        return $this->belongsToMany(Institucion::class, 'institucion_categoria')
            ->withPivot('nivel_educativo_id', 'nombre_personalizado', 'descripcion', 'activo');
    }
}
