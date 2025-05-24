<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class SolicitudEstudiante extends Model
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
        return $this->belongsTo(Estudiante::class, 'estudiante_id');
    }

    public function institucion()
    {
        return $this->belongsTo(Institucion::class);
    }

    public function clase()
    {
        return $this->belongsTo(Clase::class, 'clase_id');
    }

    public function publicacion()
    {
        return $this->belongsTo(Publicacion::class, 'publicacion_id');
    }

    public function respondedor()
    {
        return $this->belongsTo(User::class, 'respondido_por');
    }

    // Método para aprobar una solicitud
    public function aprobar($respuesta = null, $clase_id = null)
    {
        $this->estado = 'aprobada';
        $this->respuesta = $respuesta;
        $this->fecha_respuesta = now();
        $this->respondido_por = Auth::id();

        if ($clase_id) {
            $this->clase_id = $clase_id;
            $this->clase_asignada = true;
        }

        $this->save();

        // Actualizar estudiante con la institución
        $estudiante = $this->estudiante;
        $estudiante->institucion_id = $this->institucion_id;
        $estudiante->estado = 'activo'; // Asegurar que el estudiante esté activo

        if ($this->clase_id) {
            $estudiante->clase_id = $this->clase_id;
            $clase = Clase::find($this->clase_id);
            if ($clase && $clase->docente_id) {
                $estudiante->docente_id = $clase->docente_id;
            }
        }

        $estudiante->save();

        // Activar el usuario asociado
        if ($estudiante->user) {
            $estudiante->user->activo = true;
            $estudiante->user->save();
        }

        return $this;
    }

    // Método para rechazar una solicitud
    public function rechazar($respuesta = null)
    {
        $this->estado = 'rechazada';
        $this->respuesta = $respuesta;
        $this->fecha_respuesta = now();
        $this->respondido_por = Auth::id();
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

        // Crear registro en la tabla pivote estudiante_clase si no existe ya
        if (!$estudiante->clases()->where('clase_id', $clase_id)->exists()) {
            $estudiante->clases()->attach($clase_id, [
                'fecha_asignacion' => now(),
                'estado' => 'activo'
            ]);
        }

        return $this;
    }
}