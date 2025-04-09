<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $table = 'user';
    protected $fillable = [
        'nombre',
        'email',
        'password',
        'role_id',
        'pais',
        'fecha_nacimiento',
        'ciudad',
        'dni',
        'sitio_web',
        'activo',
        'telefono'
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
        'activo' => 'boolean',
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function role()
    {
        return $this->belongsTo(Rol::class, 'role_id');
    }

    // Relaciones polimórficas
    public function empresa()
    {
        return $this->hasOne(Empresa::class, 'id');
    }

    public function estudiante()
    {
        return $this->hasOne(Estudiante::class, 'id');
    }

    public function tutor()
    {
        return $this->hasOne(Tutor::class, 'id');
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function favorites()
    {
        return $this->belongsToMany(Publication::class, 'favorite_publication');
    }

    // Removed duplicate casts method
}
