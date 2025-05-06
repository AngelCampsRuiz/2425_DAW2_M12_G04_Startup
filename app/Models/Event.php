<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'empresa_id',
        'title',
        'description',
        'start',
        'end',
        'color'
    ];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }
}
