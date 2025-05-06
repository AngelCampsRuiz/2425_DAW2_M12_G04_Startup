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

    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }
} 