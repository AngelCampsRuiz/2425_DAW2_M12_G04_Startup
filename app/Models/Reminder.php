<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reminder extends Model
{
    protected $fillable = [
        'empresa_id',
        'title',
        'description',
        'date'
    ];

    protected $casts = [
        'date' => 'date'
    ];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }
}
