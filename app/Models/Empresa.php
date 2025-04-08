<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Empresa extends Model
{
    use HasFactory;

    protected $table = 'empresas';

    protected $fillable = [
        'cif',
        'direccion',
        'latitud',
        'longitud',
        'provincia',
        'usuario_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id');
    }

    public function convenios()
    {
        return $this->hasMany(Convenio::class);
    }
}
