<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Seguimiento;
use App\Models\User;
use App\Models\Estudiante;
use App\Models\Empresa;
use Carbon\Carbon;

class SeguimientoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener estudiantes y empresas
        $estudiantes = User::where('role_id', 3)->get();
        $empresas = User::where('role_id', 2)->get();
        
        // Verificar si hay suficientes datos
        if ($estudiantes->isEmpty() || $empresas->isEmpty()) {
            echo "Error: No hay suficientes estudiantes o empresas para crear seguimientos\n";
            return;
        }
        
        // Estados posibles para un seguimiento
        $estados = ['pendiente', 'aceptado', 'rechazado'];
        
        // Empresas específicas que harán seguimiento a estudiantes específicos
        $seguimientosFijos = [
            [
                'empresa' => 'Telefónica España',
                'estudiante' => 'María Rodríguez',
                'fecha_inicio' => '2023-09-15', 
                'fecha_fin' => '2024-03-15',
                'estado' => 'aceptado',
                'notas' => 'Estudiante destacada en desarrollo frontend. Buen nivel de Angular y React. Ha completado satisfactoriamente las primeras tareas asignadas. Adaptación muy rápida al equipo.'
            ],
            [
                'empresa' => 'BBVA Tech',
                'estudiante' => 'Carlos Martínez',
                'fecha_inicio' => '2023-10-01',
                'fecha_fin' => '2024-04-01',
                'estado' => 'aceptado',
                'notas' => 'Excelente progreso en el área de ciberseguridad. Ha participado en un test de penetración y un análisis de vulnerabilidades. Muestra gran interés por la seguridad en aplicaciones web.'
            ],
            [
                'empresa' => 'Indra Sistemas',
                'estudiante' => 'Laura Fernández',
                'fecha_inicio' => '2023-11-01',
                'fecha_fin' => '2024-05-01',
                'estado' => 'aceptado',
                'notas' => 'Gran capacidad de aprendizaje en el desarrollo de aplicaciones móviles. Ha colaborado en la implementación de nuevas funcionalidades para la app corporativa. Excelente trabajo en equipo.'
            ],
            [
                'empresa' => 'CaixaBank Tech',
                'estudiante' => 'Antonio López',
                'fecha_inicio' => '2023-09-01',
                'fecha_fin' => '2024-03-01',
                'estado' => 'aceptado',
                'notas' => 'Ha completado con éxito su período de prácticas. Destacó en el desarrollo de microservicios con Spring Boot. Se le ha ofrecido continuar con un contrato de formación y aprendizaje.'
            ],
            [
                'empresa' => 'Mercadona IT',
                'estudiante' => 'Elena Gómez',
                'fecha_inicio' => '2023-10-15',
                'fecha_fin' => '2024-04-15',
                'estado' => 'aceptado',
                'notas' => 'Progreso adecuado en el departamento de análisis de datos. Ha participado en la implementación de dashboards con Power BI. Necesita reforzar conocimientos en SQL avanzado.'
            ],
            [
                'empresa' => 'Repsol Digital',
                'estudiante' => 'Javier Sánchez',
                'fecha_inicio' => '2023-11-15',
                'fecha_fin' => '2024-05-15',
                'estado' => 'pendiente',
                'notas' => 'Entrevista realizada con éxito. Perfil muy interesante para el departamento de desarrollo de aplicaciones IoT. Pendiente de asignación de tutor y proyecto.'
            ],
            [
                'empresa' => 'Iberdrola Digital',
                'estudiante' => 'Sofía Pérez',
                'fecha_inicio' => '2023-10-01',
                'fecha_fin' => '2024-04-01',
                'estado' => 'aceptado',
                'notas' => 'Desempeño sobresaliente en el área de data science. Ha contribuido al desarrollo de modelos predictivos para el consumo energético. Demuestra gran interés por el aprendizaje automático.'
            ],
            [
                'empresa' => 'Mapfre Tech',
                'estudiante' => 'Miguel Torres',
                'fecha_inicio' => '2024-01-15',
                'fecha_fin' => '2024-07-15',
                'estado' => 'rechazado',
                'notas' => 'El estudiante decidió no continuar con el proceso tras recibir una oferta de otra empresa. Perfil interesante para futuras convocatorias.'
            ],
            [
                'empresa' => 'Inditex IT',
                'estudiante' => 'Sara Navarro',
                'fecha_inicio' => '2023-09-15',
                'fecha_fin' => '2024-03-15',
                'estado' => 'aceptado',
                'notas' => 'Excelente progreso en el departamento de frontend. Ha participado en el rediseño de la web corporativa con React y Styled Components. Muy proactiva y con buenas habilidades de comunicación.'
            ],
            [
                'empresa' => 'Naturgy Innovación',
                'estudiante' => 'Daniel Ruiz',
                'fecha_inicio' => '2023-12-01',
                'fecha_fin' => '2024-06-01',
                'estado' => 'aceptado',
                'notas' => 'Buen desempeño en el desarrollo de aplicaciones para gestión energética. Ha colaborado en la implementación de APIs RESTful con Node.js. Necesita mejorar en testing automatizado.'
            ],
        ];
        
        // Crear seguimientos fijos
        foreach ($seguimientosFijos as $seguimientoData) {
            // Buscar empresa y estudiante por nombre
            $empresa = $empresas->where('nombre', $seguimientoData['empresa'])->first();
            $estudiante = $estudiantes->where('nombre', $seguimientoData['estudiante'])->first();
            
            // Si no encontramos alguna de las entidades específicas, utilizar alternativas aleatorias
            if (!$empresa) {
                $empresa = $empresas->random();
            }
            
            if (!$estudiante) {
                $estudiante = $estudiantes->random();
            }
            
            // Obtener IDs de las entidades Empresa y Estudiante
            $empresaID = $empresa->empresa->id ?? null;
            $estudianteID = $estudiante->estudiante->id ?? null;
            
            // Si no podemos obtener alguno de los IDs, continuamos con el siguiente seguimiento
            if (!$empresaID || !$estudianteID) {
                continue;
            }
            
            // Crear el seguimiento
            Seguimiento::create([
                'empresa_id' => $empresaID,
                'alumno_id' => $estudianteID,
                'fecha_solicitud' => Carbon::parse($seguimientoData['fecha_inicio'])->subDays(rand(1, 15)),
                'estado' => $seguimientoData['estado'],
                'created_at' => Carbon::parse($seguimientoData['fecha_inicio'])->subDays(rand(1, 15)),
                'updated_at' => Carbon::now()->subDays(rand(0, 30))
            ]);
        }
        
        // Crear seguimientos aleatorios adicionales
        $numSeguimientosAdicionales = 20;
        
        // Array para evitar duplicados
        $paresCreados = [];
        
        for ($i = 0; $i < $numSeguimientosAdicionales; $i++) {
            $empresa = $empresas->random();
            $estudiante = $estudiantes->random();
            
            // Obtener IDs de las entidades Empresa y Estudiante
            $empresaID = $empresa->empresa->id ?? null;
            $estudianteID = $estudiante->estudiante->id ?? null;
            
            // Si no podemos obtener alguno de los IDs, continuamos con el siguiente seguimiento
            if (!$empresaID || !$estudianteID) {
                continue;
            }
            
            // Verificar si ya existe este par empresa-estudiante
            $parKey = $empresaID . '-' . $estudianteID;
            if (in_array($parKey, $paresCreados)) {
                continue;
            }
            
            // Guardar el par para evitar duplicados
            $paresCreados[] = $parKey;
            
            // Generar fechas coherentes
            $fechaInicio = Carbon::now()->subMonths(rand(0, 6))->format('Y-m-d');
            $fechaFin = Carbon::parse($fechaInicio)->addMonths(6)->format('Y-m-d');
            
            // Determinar estado basado en las fechas
            $estado = $this->determinarEstado($fechaInicio, $fechaFin);
            
            // Crear el seguimiento
            Seguimiento::create([
                'empresa_id' => $empresaID,
                'alumno_id' => $estudianteID,
                'fecha_solicitud' => Carbon::parse($fechaInicio)->subDays(rand(1, 15)),
                'estado' => $estado,
                'created_at' => Carbon::parse($fechaInicio)->subDays(rand(1, 15)),
                'updated_at' => Carbon::now()->subDays(rand(0, 30))
            ]);
        }
    }
    
    /**
     * Determina el estado lógico basado en las fechas
     */
    private function determinarEstado($fechaInicio, $fechaFin)
    {
        $ahora = Carbon::now();
        $inicio = Carbon::parse($fechaInicio);
        $fin = Carbon::parse($fechaFin);
        
        if ($ahora < $inicio) {
            return 'pendiente';
        } elseif ($ahora > $fin) {
            return rand(0, 10) > 2 ? 'aceptado' : 'rechazado'; // 80% aceptado, 20% rechazado
        } else {
            return 'aceptado';
        }
    }
    
    /**
     * Genera notas de seguimiento según el estado
     */
    private function generarNotasSeguimiento($estado)
    {
        $notasPendiente = [
            'Estudiante seleccionado tras el proceso de entrevistas. Pendiente de asignación de proyecto y tutor.',
            'Perfil interesante para el departamento de desarrollo. Pendiente de concretar fecha de incorporación.',
            'Candidato/a con buen expediente académico. Entrevista realizada satisfactoriamente. En espera de confirmación final.',
            'Especialista en tecnologías frontend. Pendiente de asignación al equipo de UX/UI.',
            'Entrevista técnica superada. Pendiente de entrevista final con RRHH.'
        ];
        
        $notasEnProceso = [
            'Progreso adecuado. Buena adaptación al equipo. Muestra interés por aprender nuevas tecnologías.',
            'Desempeño destacado en las tareas asignadas. Ha solucionado varios bugs en la aplicación principal.',
            'Actitud proactiva. Ha propuesto mejoras en los procesos de desarrollo. Buena relación con el equipo.',
            'Está participando activamente en el desarrollo de nuevas funcionalidades. Demuestra buenas habilidades técnicas.',
            'Adaptación rápida a la metodología de trabajo. Cumple con los plazos establecidos. Muestra interés por el proyecto.'
        ];
        
        $notasFinalizados = [
            'Ha completado satisfactoriamente su período de prácticas. Buen nivel técnico y profesional.',
            'Excelente desempeño durante todo el período. Se le ha ofrecido continuar en la empresa tras finalizar las prácticas.',
            'Ha adquirido las competencias técnicas previstas. Buen trabajo en equipo y capacidad de resolución de problemas.',
            'Ha participado activamente en varios proyectos. Valoración positiva de su tutor y del equipo.',
            'Práctica finalizada con éxito. Ha implementado una funcionalidad completa que ya está en producción.'
        ];
        
        $notasRechazados = [
            'El estudiante decidió no continuar con el proceso por motivos personales.',
            'Incompatibilidad de horarios con sus estudios. Se ofreció flexibilidad pero no fue suficiente.',
            'Recibió otra oferta más alineada con sus intereses profesionales.',
            'No se alcanzaron los objetivos mínimos establecidos. Se recomienda formación adicional antes de volver a aplicar.',
            'Problemas de adaptación al ritmo de trabajo y metodología del equipo.'
        ];
        
        switch ($estado) {
            case 'pendiente':
                return $notasPendiente[array_rand($notasPendiente)];
            case 'aceptado':
                return $notasEnProceso[array_rand($notasEnProceso)];
            case 'aceptado':
                return $notasFinalizados[array_rand($notasFinalizados)];
            case 'rechazado':
                return $notasRechazados[array_rand($notasRechazados)];
            default:
                return 'Sin notas adicionales.';
        }
    }
}
