<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    use HasFactory;

    protected $table = 'departamentos';

    protected $fillable = [
        'institucion_id',
        'nombre',
        'descripcion',
        'jefe_departamento_id'
    ];

    public function institucion()
    {
        return $this->belongsTo(Institucion::class);
    }

    public function jefeDepartamento()
    {
        return $this->belongsTo(Docente::class, 'jefe_departamento_id');
    }

    public function docentes()
    {
        return $this->hasMany(Docente::class);
    }

    public function clases()
    {
        return $this->hasMany(Clase::class);
    }
} 