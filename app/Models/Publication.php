<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publication extends Model
{
    use HasFactory;

    protected $table = 'publicaciones';

    protected $fillable = [
        'titulo',
        'descripcion',
        'horario',
        'horas_totales',
        'categoria_id',
        'subcategoria_id',
        'empresa_id',
        'activa',
        'fecha_publicacion'
    ];

    public function empresa()
    {
        return $this->belongsTo(User::class, 'empresa_id');
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

    public function subcategoria()
    {
        return $this->belongsTo(Subcategoria::class, 'subcategoria_id');
    }

    public function applications()
    {
        return $this->hasMany(Application::class, 'publicacion_id');
    }

    public function solicitudes()
    {
        return $this->hasMany(Solicitud::class, 'publicacion_id');
    }

    public function favorites()
    {
        return $this->belongsToMany(User::class, 'favorite_publication', 'publicacion_id', 'user_id');
    }

    public function isFavoritedBy($user)
    {
        return $this->favorites()->where('user_id', $user->id)->exists();
    }
}
