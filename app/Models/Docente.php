<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class Docente extends Model
{
    use HasFactory;

    protected $table = 'docentes';

    protected $fillable = [
        'user_id',
        'institucion_id',
        'departamento_id',
        'departamento',
        'especialidad',
        'cargo',
        'activo'
    ];

    protected $casts = [
        'activo' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function institucion()
    {
        return $this->belongsTo(Institucion::class);
    }

    public function departamentoObj()
    {
        return $this->belongsTo(Departamento::class, 'departamento_id');
    }

    public function estudiantes()
    {
        return $this->hasMany(Estudiante::class);
    }

    public function clases()
    {
        return $this->belongsToMany(Clase::class, 'docente_clase')
                    ->withPivot('fecha_asignacion', 'es_titular', 'rol')
                    ->withTimestamps();
    }

    /**
     * Obtiene las asignaciones de clases para este docente
     */
    public function docenteClases()
    {
        return $this->hasMany(DocenteClase::class);
    }

    public function departamentosJefe()
    {
        return $this->hasMany(Departamento::class, 'jefe_departamento_id');
    }

    public function esJefeDepartamento()
    {
        // Verificar si la columna jefe_departamento_id existe en la tabla departamentos
        if (Schema::hasColumn('departamentos', 'jefe_departamento_id')) {
            return $this->departamentosJefe()->count() > 0;
        }
        
        // Si la columna no existe, no puede ser jefe de departamento
        return false;
    }
} 