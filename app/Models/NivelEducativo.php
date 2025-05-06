<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NivelEducativo extends Model
{
    use HasFactory;

    protected $table = 'niveles_educativos';

    protected $fillable = ['nombre_nivel'];

    public function categorias()
    {
        return $this->hasMany(Categoria::class, 'nivel_educativo_id');
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