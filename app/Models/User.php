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
        'fecha_nacimiento',
        'ciudad',
        'dni',
        'activo',
        'telefono',
        'show_telefono',
        'show_dni',
        'show_ciudad',
        'show_direccion',
        'show_web',
        'descripcion',
        'imagen'
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
        return $this->hasOne(Estudiante::class, 'id', 'id');
    }

    public function experiencias()
    {
        return $this->hasManyThrough(Experiencia::class, Estudiante::class, 'id', 'alumno_id', 'id', 'id');
    }

    public function tutor()
    {
        return $this->hasOne(Tutor::class, 'id', 'id');
    }

    public function categoria()
    {
        return $this->hasOneThrough(Categoria::class, Tutor::class, 'id', 'id', 'id', 'categoria_id');
    }

    /**
     * Verifica que el usuario tenga todos los campos requeridos completos
     *
     * @return bool
     */
    public function hasRequiredFields(): bool
    {
        return !is_null($this->nombre) &&
               !is_null($this->email) &&
               !is_null($this->password) &&
               !is_null($this->fecha_nacimiento) &&
               !is_null($this->ciudad) &&
               !is_null($this->dni) &&
               !is_null($this->telefono) &&
               !is_null($this->role_id);
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
        return $this->belongsToMany(Publication::class, 'favorite_publication', 'user_id', 'publicacion_id');
    }

    // Removed duplicate casts method
}
