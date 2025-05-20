<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * La clase SolicitudInstitucion es ahora un alias de SolicitudEstudiante
 * para mantener compatibilidad con código existente.
 * 
 * @deprecated Use SolicitudEstudiante instead
 */
class SolicitudInstitucion extends SolicitudEstudiante
{
    use HasFactory;

    protected $table = 'solicitudes_estudiantes';

    protected $fillable = [
        'estudiante_id',
        'institucion_id',
        'clase_id',
        'estado',
        'mensaje',
        'respuesta',
        'fecha_respuesta',
        'clase_asignada',
        'respondido_por'
    ];

    protected $casts = [
        'fecha_respuesta' => 'datetime',
        'clase_asignada' => 'boolean'
    ];

    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class);
    }

    public function institucion()
    {
        return $this->belongsTo(Institucion::class);
    }

    public function clase()
    {
        return $this->belongsTo(Clase::class);
    }

    public function respondedor()
    {
        return $this->belongsTo(User::class, 'respondido_por');
    }

    /**
     * Aprueba una solicitud y opcionalmente asigna una clase
     */
    public function aprobar($respuesta = null, $clase_id = null)
    {
        $this->estado = 'aprobada';
        $this->respuesta = $respuesta;
        $this->fecha_respuesta = now();
        $this->respondido_por = auth()->id();
        
        if ($clase_id) {
            $this->clase_id = $clase_id;
            $this->clase_asignada = true;
        }
        
        $this->save();

        // Actualizar estudiante con la institución
        $estudiante = $this->estudiante;
        $estudiante->institucion_id = $this->institucion_id;
        
        if ($this->clase_id) {
            $estudiante->clase_id = $this->clase_id;
            $clase = Clase::find($this->clase_id);
            if ($clase && $clase->docente_id) {
                $estudiante->docente_id = $clase->docente_id;
            }
        }
        
        $estudiante->save();

        return $this;
    }

    /**
     * Rechaza una solicitud
     */
    public function rechazar($respuesta = null)
    {
        $this->estado = 'rechazada';
        $this->respuesta = $respuesta;
        $this->fecha_respuesta = now();
        $this->respondido_por = auth()->id();
        $this->save();

        return $this;
    }

    /**
     * Asigna una clase a un estudiante cuya solicitud ya ha sido aprobada
     */
    public function asignarClase($clase_id)
    {
        if ($this->estado !== 'aprobada') {
            throw new \Exception('Solo se pueden asignar clases a solicitudes aprobadas');
        }

        $this->clase_id = $clase_id;
        $this->clase_asignada = true;
        $this->save();

        // Actualizar estudiante con la clase
        $estudiante = $this->estudiante;
        $estudiante->clase_id = $this->clase_id;
        
        $clase = Clase::find($this->clase_id);
        if ($clase && $clase->docente_id) {
            $estudiante->docente_id = $clase->docente_id;
        }
        
        $estudiante->save();

        // Crear registro en la tabla pivote estudiante_clase
        if (!$estudiante->clases()->where('clase_id', $clase_id)->exists()) {
            $estudiante->clases()->attach($clase_id, [
                'fecha_asignacion' => now(),
                'estado' => 'activo'
            ]);
        }

        return $this;
    }
} 