<?php

namespace App\Models;

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
        'provincia'
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
}
