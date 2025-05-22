<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    protected $table = 'pagos';

    protected $fillable = [
        'institucion_id',
        'stripe_session_id',
        'monto',
        'estado',
        'moneda',
        'fecha_pago'
    ];

    protected $casts = [
        'fecha_pago' => 'datetime',
        'monto' => 'decimal:2'
    ];

    public function institucion()
    {
        return $this->belongsTo(Institucion::class);
    }
}
