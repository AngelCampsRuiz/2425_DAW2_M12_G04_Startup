<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Favorito extends Model
{
    use HasFactory;

    protected $table = 'favoritos';

    protected $fillable = ['empresa_id', 'estudiante_id'];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }

    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class);
    }
}
