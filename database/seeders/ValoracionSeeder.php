<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Valoracion;
use App\Models\User;
use App\Models\Empresa;
use App\Models\Estudiante;
use App\Models\Convenio;

class ValoracionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $convenios = Convenio::with(['seguimiento.estudiante', 'seguimiento.empresa'])->get();
        
        // Comentarios realistas para valoraciones
        $comentariosAlumnoEmpresa = [
            'Excelente experiencia de aprendizaje. El equipo es muy profesional y me han ayudado mucho.',
            'Las prácticas han superado mis expectativas. He aprendido mucho sobre desarrollo web en un entorno real.',
            'Buena empresa para hacer prácticas, aunque a veces la comunicación podría mejorar.',
            'Muy contento con la experiencia. El tutor de la empresa ha sido muy paciente y me ha enseñado mucho.',
            'Recomiendo esta empresa para hacer prácticas. El ambiente de trabajo es excelente y se aprende mucho.',
            'Las prácticas han sido muy útiles para mi formación. He podido aplicar lo aprendido en clase.',
            'Buena experiencia en general, aunque a veces las tareas eran un poco repetitivas.',
            'El equipo es muy acogedor y me han integrado perfectamente. He aprendido mucho sobre desarrollo frontend.',
            'Las prácticas han sido una gran oportunidad para conocer el mundo laboral. Muy recomendable.',
            'Empresa con buenos valores y compromiso con la formación de los estudiantes.'
        ];
        
        $comentariosEmpresaAlumno = [
            'Estudiante muy aplicado y con ganas de aprender. Se ha integrado perfectamente en el equipo.',
            'Buen desempeño en las tareas asignadas. Muestra iniciativa y capacidad de trabajo en equipo.',
            'Excelente estudiante, ha superado nuestras expectativas. Recomendamos su incorporación.',
            'Muy buen nivel técnico y capacidad de aprendizaje. Se adapta rápidamente a nuevas tecnologías.',
            'Estudiante responsable y puntual. Ha realizado un buen trabajo durante las prácticas.',
            'Buenas habilidades de comunicación y trabajo en equipo. Ha contribuido positivamente al proyecto.',
            'Muestra interés por aprender y mejorar. Tiene potencial para crecer profesionalmente.',
            'Estudiante con buenos conocimientos técnicos y capacidad para resolver problemas.',
            'Ha demostrado seriedad y compromiso durante las prácticas. Recomendamos su incorporación.',
            'Buen desempeño general. Ha cumplido con las expectativas y ha mostrado interés por aprender.'
        ];

        foreach ($convenios as $convenio) {
            // Crear valoración del alumno a la empresa (50% de probabilidad)
            if (rand(0, 1)) {
                $puntuacion = rand(3, 5); // Mayor probabilidad de puntuaciones altas
                $comentario = $comentariosAlumnoEmpresa[array_rand($comentariosAlumnoEmpresa)];
                
                Valoracion::create([
                    'puntuacion' => $puntuacion,
                    'comentario' => $comentario,
                    'fecha_valoracion' => fake()->dateTimeBetween('-6 months', 'now'),
                    'tipo' => 'alumno_a_empresa',
                    'emisor_id' => $convenio->seguimiento->estudiante->id,
                    'receptor_id' => $convenio->seguimiento->empresa->id,
                    'convenio_id' => $convenio->id,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }

            // Crear valoración de la empresa al alumno (50% de probabilidad)
            if (rand(0, 1)) {
                $puntuacion = rand(3, 5); // Mayor probabilidad de puntuaciones altas
                $comentario = $comentariosEmpresaAlumno[array_rand($comentariosEmpresaAlumno)];
                
                Valoracion::create([
                    'puntuacion' => $puntuacion,
                    'comentario' => $comentario,
                    'fecha_valoracion' => fake()->dateTimeBetween('-6 months', 'now'),
                    'tipo' => 'empresa_a_alumno',
                    'emisor_id' => $convenio->seguimiento->empresa->id,
                    'receptor_id' => $convenio->seguimiento->estudiante->id,
                    'convenio_id' => $convenio->id,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        }
    }
}
