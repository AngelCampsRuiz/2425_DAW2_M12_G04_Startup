<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Publicacion extends Model
{
    use HasFactory;

    protected $table = 'publicaciones';

    protected $fillable = [
        'titulo',
        'descripcion',
        'horario',
        'horas_totales',
        'fecha_publicacion',
        'activa',
        'empresa_id',
        'categoria_id',
        'subcategoria_id'
    ];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }

    public function subcategoria()
    {
        return $this->belongsTo(Subcategoria::class);
    }

    public function favoritos()
    {
        return $this->hasMany(Favorito::class);
    }

    public function solicitudes()
    {
        return $this->hasMany(Solicitud::class, 'publicacion_id');
    }
}
