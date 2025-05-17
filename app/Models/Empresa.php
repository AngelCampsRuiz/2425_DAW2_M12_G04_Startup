<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Empresa extends Model
{
    use HasFactory;

    protected $table = 'empresas';

    protected $fillable = [
        'id',
        'cif',
        'direccion',
        'latitud',
        'longitud',
        'provincia',
        'show_cif'
    ];
    
    // Indicar que la clave primaria no es autoincremental
    public $incrementing = false;

    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'id');
    }

    public function convenios()
    {
        return $this->hasMany(Convenio::class);
    }

    public function publicaciones()
    {
        return $this->hasMany(Publication::class, 'empresa_id');
    }

    public function experiencias()
    {
        return $this->hasManyThrough(
            Experiencia::class,
            Estudiante::class,
            'id', // Clave foránea en estudiantes
            'alumno_id', // Clave foránea en experiencias
            'id', // Clave local en empresas
            'id' // Clave local en estudiantes
        )->where('empresa_nombre', 'like', '%' . $this->user->nombre . '%');
    }
}
