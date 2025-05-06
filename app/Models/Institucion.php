<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Institucion extends Model
{
    use HasFactory;

    protected $table = 'instituciones';

    protected $fillable = [
        'user_id',
        'codigo_centro',
        'tipo_institucion',
        'direccion',
        'provincia',
        'codigo_postal',
        'representante_legal',
        'cargo_representante',
        'verificada'
    ];

    protected $casts = [
        'verificada' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function docentes()
    {
        return $this->hasMany(Docente::class);
    }

    public function estudiantes()
    {
        return $this->hasMany(Estudiante::class);
    }

    public function departamentos()
    {
        return $this->hasMany(Departamento::class);
    }

    public function clases()
    {
        return $this->hasMany(Clase::class);
    }

    public function solicitudesEstudiantes()
    {
        return $this->hasMany(SolicitudEstudiante::class);
    }

    // Métodos útiles
    
    // Obtener solicitudes pendientes
    public function solicitudesPendientes()
    {
        return $this->solicitudesEstudiantes()->where('estado', 'pendiente');
    }

    // Verificar si un estudiante ya ha enviado una solicitud
    public function tieneSolicitudDeEstudiante($estudiante_id)
    {
        return $this->solicitudesEstudiantes()
            ->where('estudiante_id', $estudiante_id)
            ->whereIn('estado', ['pendiente', 'aprobada'])
            ->exists();
    }
} 