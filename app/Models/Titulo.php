<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Titulo extends Model
{
    use HasFactory;

    protected $table = 'titulos';

    protected $fillable = ['centro_asignado', 'categoria_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'id');
    }

    public function estudiantes()
    {
        return $this->belongsToMany(Estudiante::class, 'alumno_tutores');
    }

    public function categorias()
    {
        return $this->belongsToMany(Categoria::class, 'categoria_tutor');
    }
}
