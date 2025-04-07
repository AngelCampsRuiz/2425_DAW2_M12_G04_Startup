<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Experiencia extends Model
{
    use HasFactory;

    protected $table = 'experiencias';

    protected $fillable = ['titulo', 'empresa_nombre', 'especializacion', 'fecha_inicio', 'fecha_fin', 'estudiante_id'];

    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class);
    }

}
