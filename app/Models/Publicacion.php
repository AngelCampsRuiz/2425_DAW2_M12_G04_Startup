<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Validation\Rule;

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

    /**
     * Regla única que añade una combinación única de columnas
     * Esta regla se aplicará para validación a través de UniquePublicacionRule
     */
    public static function getUniqueRule($userId, $ignoreId = null)
    {
        $rule = Rule::unique('publicaciones')
            ->where(function ($query) use ($userId) {
                return $query->where('empresa_id', $userId)
                             ->where('created_at', '>=', now()->subHours(24));
            });
            
        if ($ignoreId) {
            $rule->ignore($ignoreId);
        }
            
        return $rule;
    }

    protected static function boot()
    {
        parent::boot();
        
        // Evento before save para evitar duplicados a nivel modelo
        static::saving(function ($publicacion) {
            $duplicado = static::where('empresa_id', $publicacion->empresa_id)
                ->where('titulo', $publicacion->titulo)
                ->where('created_at', '>=', now()->subHours(24))
                ->where('id', '!=', $publicacion->id)
                ->exists();
                
            if ($duplicado) {
                throw new \Exception('DUPLICADO BLOQUEADO: Ya existe una publicación similar en las últimas 24 horas');
            }
        });
    }

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

    public function favoritos()
    {
        return $this->hasMany(Favorito::class);
    }

    public function solicitudes()
    {
        return $this->hasMany(Solicitud::class, 'publicacion_id');
    }
}
