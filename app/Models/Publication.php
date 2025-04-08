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
        return $this->belongsTo(Category::class, 'categoria_id');
    }

    public function subcategoria()
    {
        return $this->belongsTo(Subcategory::class, 'subcategoria_id');
    }
}
