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
        return $this->hasMany(Categoria::class);
    }
} 