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
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function subcategoria()
    {
        return $this->belongsTo(Subcategoria::class);
    }
    
    public function subcategorias()
    {
        return $this->belongsToMany(Subcategoria::class, 'publicacion_subcategoria', 'publicacion_id', 'subcategoria_id')
                    ->withTimestamps();
    }

    public function favoritos()
    {
        return $this->hasMany(Favorito::class);
    }

    public function solicitudes()
    {
        return $this->hasMany(Solicitud::class, 'publicacion_id');
    }
    
    public function candidatosAceptados()
    {
        return $this->hasManyThrough(
            User::class,
            Solicitud::class,
            'publicacion_id', // Foreign key on Solicitud table...
            'id', // Foreign key on User table...
            'id', // Local key on Publicacion table...
            'estudiante_id' // Local key on Solicitud table...
        )->where('solicitudes.estado', 'aceptada');
    }
}
