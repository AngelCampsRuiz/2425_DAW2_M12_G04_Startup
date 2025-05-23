<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\FavoritePublication;
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

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
        'fecha_nacimiento',
        'ciudad',
        'dni',
        'activo',
        'sitio_web',
        'telefono',
        'descripcion',
        'imagen',
        'banner',
        'visibilidad',
        'role_id',
        'show_telefono',
        'show_dni',
        'show_ciudad',
        'show_direccion',
        'show_web',
        'lat',
        'lng',
        'direccion'
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
        'activo' => 'boolean',
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'visibilidad' => 'boolean',
        'show_telefono' => 'boolean',
        'show_dni' => 'boolean',
        'show_ciudad' => 'boolean',
        'show_direccion' => 'boolean',
        'show_web' => 'boolean'
    ];

    public function role()
    {
        return $this->belongsTo(Rol::class, 'role_id');
    }

    // Método helper para verificar el rol
    public function hasRole($roleId)
    {
        return $this->role_id == $roleId;
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
        return $this->hasManyThrough(Experiencia::class, Estudiante::class, 'id', 'user_id', 'id', 'id');
    }

    public function tutor()
    {
        return $this->hasOne(Tutor::class, 'id', 'id');
    }

    public function institucion()
    {
        return $this->hasOne(Institucion::class, 'user_id');
    }

    public function docente()
    {
        return $this->hasOne(Docente::class, 'user_id');
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

    // Relación con las valoraciones recibidas
    public function valoracionesRecibidas()
    {
        return $this->hasMany(Valoracion::class, 'receptor_id');
    }

    // Relación con las valoraciones emitidas
    public function valoracionesEmitidas()
    {
        return $this->hasMany(Valoracion::class, 'emisor_id');
    }

    public function favoritePublications()
    {
        return $this->belongsToMany(
            Publication::class,           // Modelo relacionado
            'favorite_publication',       // Nombre de la tabla pivote
            'user_id',                    // Foreign key de este modelo en la tabla pivote
            'publicacion_id'              // Foreign key del modelo relacionado en la tabla pivote
        );
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
