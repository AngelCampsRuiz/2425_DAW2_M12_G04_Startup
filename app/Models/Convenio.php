<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Convenio extends Model
{
    use HasFactory;

    protected $table = 'convenios';

    protected $fillable = [
        'documento_pdf',
        'activo',
        'fecha_aprobacion',
        'tutor_id',
        'seguimiento_id'
    ];

    protected $casts = [
        'activo' => 'boolean',
        'fecha_aprobacion' => 'datetime'
    ];

    public function seguimiento()
    {
        return $this->belongsTo(Seguimiento::class);
    }

    public function tutor()
    {
        return $this->belongsTo(Tutor::class);
    }

    public function valoraciones()
    {
        return $this->hasMany(Valoracion::class);
    }
}
