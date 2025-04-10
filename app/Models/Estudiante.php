<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Estudiante extends Model
{
    use HasFactory;
    
    protected $table = 'estudiantes';

    protected $fillable = [
        'id',
        'centro_educativo',
        'cv_pdf',
        'numero_seguridad_social'
    ];
    
    // Indicar que la clave primaria no es autoincremental
    public $incrementing = false;

    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'id');
    }

    public function tutores()
    {
        return $this->belongsToMany(Tutor::class, 'alumno_tutores');
    }

    public function experiencias()
    {
        return $this->hasMany(Experiencia::class);
    }

    public function solicitudes()
    {
        return $this->hasMany(Solicitud::class);
    }
}
