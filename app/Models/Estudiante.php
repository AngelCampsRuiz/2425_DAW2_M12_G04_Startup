<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Estudiante extends Model
{
    use HasFactory;
    
    protected $table = 'estudiantes';

    protected $fillable = [
        'curso',
        'ciclo'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id');
    }

    public function tutores()
    {
        return $this->belongsToMany(Tutor::class, 'alumno_tutores');
    }

    public function experiencias()
    {
        return $this->hasMany(Experiencia::class);
    }
}
