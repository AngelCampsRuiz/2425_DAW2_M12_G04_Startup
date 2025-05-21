<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Estudiante;
use App\Models\Clase;
use App\Models\EstudianteClase;
use Illuminate\Support\Facades\DB;

class EstudianteClaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtenemos todos los estudiantes y clases
        $estudiantes = Estudiante::all();
        $clases = Clase::all();
        
        // Verificar si hay datos suficientes
        if ($estudiantes->isEmpty() || $clases->isEmpty()) {
            echo "Error: No hay suficientes estudiantes o clases para crear relaciones\n";
            return;
        }
        
        // Asignaciones predefinidas para garantizar consistencia
        $asignaciones = [
            // Clase DAW2 - Desarrollo de Aplicaciones Web
            ['estudiante_id' => 1, 'clase_id' => 1, 'fecha_asignacion' => '2024-09-15', 'fecha_finalizacion' => '2025-06-15', 'estado' => 'activo', 'comentarios' => 'Estudiante destacado en desarrollo frontend.'],
            ['estudiante_id' => 2, 'clase_id' => 1, 'fecha_asignacion' => '2024-09-15', 'fecha_finalizacion' => '2025-06-15', 'estado' => 'activo', 'comentarios' => 'Buenas aptitudes para el trabajo en equipo.'],
            ['estudiante_id' => 3, 'clase_id' => 1, 'fecha_asignacion' => '2024-09-15', 'fecha_finalizacion' => '2025-06-15', 'estado' => 'activo', 'comentarios' => 'Destaca en desarrollo backend con Laravel.'],
            ['estudiante_id' => 4, 'clase_id' => 1, 'fecha_asignacion' => '2024-09-15', 'fecha_finalizacion' => '2025-06-15', 'estado' => 'activo', 'comentarios' => 'Interesado en especializarse en APIs REST.'],
            ['estudiante_id' => 5, 'clase_id' => 1, 'fecha_asignacion' => '2024-09-15', 'fecha_finalizacion' => '2025-06-15', 'estado' => 'activo', 'comentarios' => 'Buen nivel en JavaScript y frameworks.'],
            
            // Clase DAM2 - Desarrollo de Aplicaciones Multiplataforma
            ['estudiante_id' => 6, 'clase_id' => 2, 'fecha_asignacion' => '2024-09-15', 'fecha_finalizacion' => '2025-06-15', 'estado' => 'activo', 'comentarios' => 'Especializado en desarrollo móvil Android.'],
            ['estudiante_id' => 7, 'clase_id' => 2, 'fecha_asignacion' => '2024-09-15', 'fecha_finalizacion' => '2025-06-15', 'estado' => 'activo', 'comentarios' => 'Gran capacidad para aprender nuevas tecnologías.'],
            ['estudiante_id' => 8, 'clase_id' => 2, 'fecha_asignacion' => '2024-09-15', 'fecha_finalizacion' => '2025-06-15', 'estado' => 'activo', 'comentarios' => 'Desarrollador de aplicaciones iOS con Swift.'],
            ['estudiante_id' => 9, 'clase_id' => 2, 'fecha_asignacion' => '2024-09-15', 'fecha_finalizacion' => '2025-06-15', 'estado' => 'activo', 'comentarios' => 'Experto en desarrollo multiplataforma con Flutter.'],
            ['estudiante_id' => 10, 'clase_id' => 2, 'fecha_asignacion' => '2024-09-15', 'fecha_finalizacion' => '2025-06-15', 'estado' => 'activo', 'comentarios' => 'Interesado en React Native y tecnologías híbridas.'],
            
            // Clase ASIR2 - Administración de Sistemas Informáticos en Red
            ['estudiante_id' => 11, 'clase_id' => 3, 'fecha_asignacion' => '2024-09-15', 'fecha_finalizacion' => '2025-06-15', 'estado' => 'activo', 'comentarios' => 'Especializado en administración de servidores Linux.'],
            ['estudiante_id' => 12, 'clase_id' => 3, 'fecha_asignacion' => '2024-09-15', 'fecha_finalizacion' => '2025-06-15', 'estado' => 'activo', 'comentarios' => 'Conocimientos avanzados en redes Cisco.'],
            ['estudiante_id' => 13, 'clase_id' => 3, 'fecha_asignacion' => '2024-09-15', 'fecha_finalizacion' => '2025-06-15', 'estado' => 'activo', 'comentarios' => 'Interesado en seguridad informática y pentesting.'],
            ['estudiante_id' => 14, 'clase_id' => 3, 'fecha_asignacion' => '2024-09-15', 'fecha_finalizacion' => '2025-06-15', 'estado' => 'activo', 'comentarios' => 'Enfocado en virtualización y contenedores.'],
            
            // Marketing Digital Avanzado
            ['estudiante_id' => 15, 'clase_id' => 4, 'fecha_asignacion' => '2024-09-15', 'fecha_finalizacion' => '2025-06-15', 'estado' => 'activo', 'comentarios' => 'Experiencia en campañas de SEO y SEM.'],
            ['estudiante_id' => 16, 'clase_id' => 4, 'fecha_asignacion' => '2024-09-15', 'fecha_finalizacion' => '2025-06-15', 'estado' => 'activo', 'comentarios' => 'Especializada en marketing de contenidos.'],
            ['estudiante_id' => 17, 'clase_id' => 4, 'fecha_asignacion' => '2024-09-15', 'fecha_finalizacion' => '2025-06-15', 'estado' => 'activo', 'comentarios' => 'Habilidades en analítica web y medición de resultados.'],
            
            // Diseño Gráfico y Web
            ['estudiante_id' => 18, 'clase_id' => 5, 'fecha_asignacion' => '2024-09-15', 'fecha_finalizacion' => '2025-06-15', 'estado' => 'activo', 'comentarios' => 'Portafolio sólido de diseño de interfaces.'],
            ['estudiante_id' => 19, 'clase_id' => 5, 'fecha_asignacion' => '2024-09-15', 'fecha_finalizacion' => '2025-06-15', 'estado' => 'activo', 'comentarios' => 'Especializado en diseño UX/UI.'],
            ['estudiante_id' => 20, 'clase_id' => 5, 'fecha_asignacion' => '2024-09-15', 'fecha_finalizacion' => '2025-06-15', 'estado' => 'activo', 'comentarios' => 'Habilidades en animación y motion graphics.'],
            
            // SMR2 - Sistemas Microinformáticos y Redes
            ['estudiante_id' => 1, 'clase_id' => 11, 'fecha_asignacion' => '2023-09-15', 'fecha_finalizacion' => '2024-06-15', 'estado' => 'finalizado', 'comentarios' => 'Completó con calificación sobresaliente.'],
            ['estudiante_id' => 6, 'clase_id' => 11, 'fecha_asignacion' => '2023-09-15', 'fecha_finalizacion' => '2024-06-15', 'estado' => 'finalizado', 'comentarios' => 'Demostró gran capacidad técnica.'],
            ['estudiante_id' => 11, 'clase_id' => 11, 'fecha_asignacion' => '2023-09-15', 'fecha_finalizacion' => '2024-06-15', 'estado' => 'finalizado', 'comentarios' => 'Destacó en configuración de redes.'],
            
            // Diferentes estados en otras clases
            ['estudiante_id' => 2, 'clase_id' => 6, 'fecha_asignacion' => '2024-09-15', 'fecha_finalizacion' => '2025-06-15', 'estado' => 'activo', 'comentarios' => 'Inscripción pendiente de confirmación.'],
            ['estudiante_id' => 3, 'clase_id' => 7, 'fecha_asignacion' => '2024-09-15', 'fecha_finalizacion' => '2025-06-15', 'estado' => 'activo', 'comentarios' => 'En lista de espera.'],
            ['estudiante_id' => 4, 'clase_id' => 8, 'fecha_asignacion' => '2024-02-01', 'fecha_finalizacion' => '2024-07-30', 'estado' => 'activo', 'comentarios' => 'Cursando como asignatura optativa.'],
            ['estudiante_id' => 5, 'clase_id' => 12, 'fecha_asignacion' => '2024-02-01', 'fecha_finalizacion' => '2024-05-30', 'estado' => 'finalizado', 'comentarios' => 'Curso de especialización completado con éxito.'],
        ];
        
        // Conjunto para rastrear combinaciones únicas de estudiante-clase
        $combinacionesExistentes = [];
        
        // Insertamos las asignaciones verificando que los IDs existan y no haya duplicados
        foreach ($asignaciones as $asignacion) {
            // Verificar que existan el estudiante y la clase
            $estudianteId = $asignacion['estudiante_id'];
            $claseId = $asignacion['clase_id'];
            
            // Ajustar IDs si no existen (para garantizar que no falle)
            if (!$estudiantes->contains('id', $estudianteId)) {
                $estudianteId = $estudiantes->first()->id;
            }
            
            if (!$clases->contains('id', $claseId)) {
                $claseId = $clases->first()->id;
            }
            
            // Verificar si esta combinación ya existe
            $clave = $estudianteId . '-' . $claseId;
            if (in_array($clave, $combinacionesExistentes)) {
                // Si ya existe, saltamos esta asignación
                continue;
            }
            
            // Registrar esta combinación
            $combinacionesExistentes[] = $clave;
            
            // Crear una calificación aleatoria para los finalizados
            $calificacion = $asignacion['estado'] === 'finalizado' ? rand(7, 10) : null;
            
            DB::table('estudiante_clase')->insert([
                'estudiante_id' => $estudianteId,
                'clase_id' => $claseId,
                'fecha_asignacion' => $asignacion['fecha_asignacion'],
                'fecha_finalizacion' => $asignacion['fecha_finalizacion'],
                'estado' => $asignacion['estado'],
                'calificacion' => $calificacion,
                'comentarios' => $asignacion['comentarios'],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
        
        // Añadir algunas asignaciones aleatorias para completar el conjunto de datos
        for ($i = 0; $i < 15; $i++) {
            $estudiante = $estudiantes->random();
            $clase = $clases->random();
            
            // Verificar que esta combinación no exista ya
            $clave = $estudiante->id . '-' . $clase->id;
            if (in_array($clave, $combinacionesExistentes)) {
                // Si ya existe, intentamos otra vez
                continue;
            }
            
            // Registrar esta combinación
            $combinacionesExistentes[] = $clave;
            
            // Determinar estado aleatorio (usando solo los valores permitidos en la tabla)
            $estadosPosibles = ['activo', 'finalizado', 'suspendido', 'cancelado'];
            $estado = $estadosPosibles[array_rand($estadosPosibles)];
            
            // Fecha de asignación (entre 6 meses atrás y hoy)
            $fechaAsignacion = now()->subDays(rand(0, 180))->format('Y-m-d');
            
            // Fecha de finalización (si es "finalizado", en el pasado, si no en el futuro)
            $fechaFinalizacion = null;
            if ($estado === 'finalizado') {
                $fechaFinalizacion = now()->subDays(rand(0, 30))->format('Y-m-d');
            } else if ($estado === 'activo') {
                $fechaFinalizacion = now()->addDays(rand(30, 180))->format('Y-m-d');
            }
            
            // Calificación solo para finalizados
            $calificacion = $estado === 'finalizado' ? rand(5, 10) : null;
            
            // Comentarios aleatorios
            $comentarios = $this->generarComentarioAleatorio($estado);
            
            DB::table('estudiante_clase')->insert([
                'estudiante_id' => $estudiante->id,
                'clase_id' => $clase->id,
                'fecha_asignacion' => $fechaAsignacion,
                'fecha_finalizacion' => $fechaFinalizacion,
                'estado' => $estado,
                'calificacion' => $calificacion,
                'comentarios' => $comentarios,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
    
    /**
     * Genera un comentario aleatorio según el estado
     */
    private function generarComentarioAleatorio($estado)
    {
        $comentariosActivo = [
            'Buen progreso en el curso.',
            'Participación activa en las clases.',
            'Buenas aptitudes para el trabajo en equipo.',
            'Demuestra interés y compromiso.',
            'Necesita mejorar en algunos aspectos.'
        ];
        
        $comentariosSuspendido = [
            'Suspensión temporal por bajo rendimiento.',
            'Suspendido por falta de asistencia.',
            'Suspendido por solicitud del estudiante.',
            'Curso pausado temporalmente.',
            'Suspendido por razones administrativas.'
        ];
        
        $comentariosFinalizado = [
            'Completó satisfactoriamente el curso.',
            'Excelente desempeño durante todo el curso.',
            'Destacó en los proyectos prácticos.',
            'Presentó un trabajo final sobresaliente.',
            'Superó las expectativas del profesorado.'
        ];
        
        $comentariosCancelado = [
            'Cancelado por decisión del estudiante.',
            'Cancelación por incompatibilidad de horarios.',
            'Cancelado por motivos personales.',
            'Baja voluntaria en el curso.',
            'Cancelado por traslado a otro centro.'
        ];
        
        switch ($estado) {
            case 'activo':
                return $comentariosActivo[array_rand($comentariosActivo)];
            case 'suspendido':
                return $comentariosSuspendido[array_rand($comentariosSuspendido)];
            case 'finalizado':
                return $comentariosFinalizado[array_rand($comentariosFinalizado)];
            case 'cancelado':
                return $comentariosCancelado[array_rand($comentariosCancelado)];
            default:
                return 'Sin comentarios adicionales.';
        }
    }
} 