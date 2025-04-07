<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Chat extends Model
{
    use HasFactory;

    protected $table = 'chats';

    protected $fillable = ['tutor_id', 'empresa_id', 'alumno_id'];

    public function mensajes()
    {
        return $this->hasMany(Mensaje::class);
    }

    public function usuario1()
    {
        return $this->belongsTo(User::class, 'user_id_1');
    }

    public function usuario2()
    {
        return $this->belongsTo(User::class, 'user_id_2');
    }

}
