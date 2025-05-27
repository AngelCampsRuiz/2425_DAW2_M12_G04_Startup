<?php

namespace App\Models;

use App\Models\Experiencia;
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
        'show_cif',
        'activo'
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
        // Esta relación busca experiencias que mencionen el nombre de la empresa
        // Más eficiente usar una relación más directa en lugar de hasManyThrough
        return Experiencia::where('empresa_nombre', 'like', '%' . $this->user->nombre . '%');
    }
}
