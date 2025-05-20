<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Chat extends Model
{
    use HasFactory;

    protected $table = 'chats';

    protected $fillable = [
        'empresa_id', 
        'solicitud_id',
        'docente_id',
        'estudiante_id',
        'tipo'
    ];

    public function mensajes()
    {
        return $this->hasMany(Mensaje::class);
    }

    public function solicitud()
    {
        return $this->belongsTo(Solicitud::class);
    }

    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class);
    }

    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }

    public function docente()
    {
        return $this->belongsTo(Docente::class);
    }

    public function getOtherUser()
    {
        $user = auth()->user();
        
        if ($user->role_id == 2) { // Empresa
            if ($this->tipo == 'empresa_estudiante') {
                return $this->estudiante->user;
            } elseif ($this->tipo == 'docente_empresa') {
                return $this->docente->user;
            }
        } elseif ($user->role_id == 3) { // Estudiante
            if ($this->tipo == 'empresa_estudiante') {
                return $this->empresa->user;
            } else {
                return $this->docente->user;
            }
        } elseif ($user->role_id == 4) { // Docente
            if ($this->tipo == 'docente_estudiante') {
                return $this->estudiante->user;
            } elseif ($this->tipo == 'docente_empresa') {
                return $this->empresa->user;
            }
        }
        
        return null;
    }
}
