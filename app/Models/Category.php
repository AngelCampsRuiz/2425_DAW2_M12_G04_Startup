<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categorias';

    protected $fillable = [
        'nombre',
        'descripcion'
    ];

    public function publicaciones()
    {
        return $this->hasMany(Publication::class, 'categoria_id');
    }

    public function subcategorias()
    {
        return $this->hasMany(Subcategory::class, 'categoria_id');
    }
}
