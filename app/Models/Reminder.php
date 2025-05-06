<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reminder extends Model
{
    protected $fillable = [
        'empresa_id',
        'title',
        'description',
        'date',
        'color',
        'completed'
    ];

    protected $casts = [
        'date' => 'date',
        'completed' => 'boolean'
    ];

    // Asegurarse de que la fecha se devuelve en el formato correcto para el input date
    protected $appends = ['formatted_date'];

    public function getFormattedDateAttribute()
    {
        return $this->date->format('Y-m-d');
    }

    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }
} 