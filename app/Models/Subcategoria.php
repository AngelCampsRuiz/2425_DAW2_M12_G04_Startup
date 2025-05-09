<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subcategoria extends Model
{
    use HasFactory;

    protected $table = 'subcategorias';

    protected $fillable = ['nombre_subcategoria', 'categoria_id'];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function publicaciones()
    {
        return $this->hasMany(Publicacion::class, 'subcategoria_id');
    }

    public function publications()
    {
        return $this->hasMany(Publication::class, 'subcategoria_id');
    }
}
