<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Categoria extends Model
{
    use HasFactory;

    protected $table = 'categorias';

    protected $fillable = ['nombre_categoria'];

    public function subcategorias()
    {
        return $this->hasMany(Subcategoria::class);
    }

    public function tutores()
    {
        return $this->belongsToMany(Tutor::class, 'categoria_tutor');
    }
}
