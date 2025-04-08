<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    use HasFactory;

    protected $table = 'subcategorias';

    protected $fillable = [
        'nombre',
        'descripcion',
        'categoria_id'
    ];

    public function categoria()
    {
        return $this->belongsTo(Category::class, 'categoria_id');
    }

    public function publicaciones()
    {
        return $this->hasMany(Publication::class, 'subcategoria_id');
    }
}
