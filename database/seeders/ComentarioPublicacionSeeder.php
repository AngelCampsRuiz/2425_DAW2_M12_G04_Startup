<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ComentarioPublicacion;
use App\Models\Publicacion;
use App\Models\User;
use Carbon\Carbon;

class ComentarioPublicacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener las publicaciones y usuarios para generar comentarios
        $publicaciones = Publicacion::all();
        $usuarios = User::whereIn('role_id', [3, 4, 6])->get(); // Estudiantes, tutores y profesores
        
        // Verificar si hay suficientes datos
        if ($publicaciones->isEmpty() || $usuarios->isEmpty()) {
            echo "Error: No hay suficientes publicaciones o usuarios para crear comentarios\n";
            return;
        }
        
        // Comentarios fijos para algunas publicaciones
        $comentariosFijos = [
            [
                'publicacion_index' => 0, // Primera publicación
                'usuario_index' => 2, // Tercer usuario
                'contenido' => '¿Se requiere experiencia previa en desarrollo frontend o podría aplicar alguien que solo ha hecho proyectos personales con React?',
                'fecha' => Carbon::now()->subDays(12)
            ],
            [
                'publicacion_index' => 0, // Primera publicación
                'usuario_index' => 5, // Sexto usuario
                'contenido' => 'Me interesa mucho esta posición. ¿Habría posibilidad de realizar las prácticas en horario de tarde para compatibilizarlo con mis estudios?',
                'fecha' => Carbon::now()->subDays(10)
            ],
            [
                'publicacion_index' => 0, // Primera publicación
                'usuario_index' => 0, // Primer usuario (empresa)
                'contenido' => 'Hola a todos. Gracias por vuestro interés. No es necesaria experiencia profesional previa, valoramos más la capacidad de aprendizaje y el conocimiento demostrable en proyectos personales. En cuanto al horario, tenemos flexibilidad, podemos adaptarnos a horarios de tarde sin problema.',
                'fecha' => Carbon::now()->subDays(9)
            ],
            [
                'publicacion_index' => 1, // Segunda publicación
                'usuario_index' => 3, // Cuarto usuario
                'contenido' => '¿Podrían detallar qué tecnologías se utilizan específicamente en el departamento de ciberseguridad? Me interesa conocer si se trabaja con análisis de vulnerabilidades, pentesting o gestión de incidentes.',
                'fecha' => Carbon::now()->subDays(8)
            ],
            [
                'publicacion_index' => 2, // Tercera publicación
                'usuario_index' => 7, // Octavo usuario
                'contenido' => 'Esta posición encaja perfectamente con mi perfil y formación. ¿Cuál sería el proceso de selección para los candidatos? ¿Incluye alguna prueba técnica o es solo entrevista?',
                'fecha' => Carbon::now()->subDays(15)
            ],
            [
                'publicacion_index' => 2, // Tercera publicación
                'usuario_index' => 1, // Segundo usuario (empresa)
                'contenido' => 'El proceso consta de una primera entrevista con RRHH, una prueba técnica online de nivel medio (aprox. 1 hora) y una entrevista final con el equipo técnico. El proceso suele durar unas 2 semanas en total.',
                'fecha' => Carbon::now()->subDays(14)
            ],
            [
                'publicacion_index' => 3, // Cuarta publicación
                'usuario_index' => 9, // Décimo usuario
                'contenido' => '¿La remuneración de 400€ es bruta o neta? Además, ¿hay posibilidad de incorporación a la empresa una vez finalizadas las prácticas?',
                'fecha' => Carbon::now()->subDays(20)
            ],
            [
                'publicacion_index' => 4, // Quinta publicación
                'usuario_index' => 11, // Usuario 12
                'contenido' => 'Como profesor del ciclo de DAM, me gustaría saber si establecen algún tipo de convenio específico con centros educativos o si el proceso es individual para cada estudiante.',
                'fecha' => Carbon::now()->subDays(25)
            ],
            [
                'publicacion_index' => 4, // Quinta publicación
                'usuario_index' => 2, // Tercer usuario (empresa)
                'contenido' => 'Tenemos convenios con varios centros educativos, pero también aceptamos candidaturas individuales. Si su centro está interesado en establecer un acuerdo, pueden contactarnos directamente a través del correo de la oferta para formalizar la colaboración.',
                'fecha' => Carbon::now()->subDays(24)
            ],
            [
                'publicacion_index' => 5, // Sexta publicación
                'usuario_index' => 6, // Séptimo usuario
                'contenido' => 'Me interesa mucho esta oferta. Actualmente estoy terminando un curso de especialización en Cloud y tengo conocimientos de AWS. ¿Se valora alguna certificación específica?',
                'fecha' => Carbon::now()->subDays(18)
            ],
        ];
        
        // Crear comentarios fijos
        foreach ($comentariosFijos as $comentarioData) {
            // Obtener la publicación y usuario correspondientes
            if (isset($publicaciones[$comentarioData['publicacion_index']]) && isset($usuarios[$comentarioData['usuario_index']])) {
                $publicacion = $publicaciones[$comentarioData['publicacion_index']];
                $usuario = $usuarios[$comentarioData['usuario_index']];
                
                ComentarioPublicacion::create([
                    'publicacion_id' => $publicacion->id,
                    'user_id' => $usuario->id,
                    'contenido' => $comentarioData['contenido'],
                    'created_at' => $comentarioData['fecha'],
                    'updated_at' => $comentarioData['fecha']
                ]);
            }
        }
        
        // Generar comentarios aleatorios para el resto de publicaciones
        // Asegurar que cada publicación tenga al menos un comentario
        foreach ($publicaciones as $publicacion) {
            // Verificar si la publicación ya tiene comentarios
            $tieneComentarios = ComentarioPublicacion::where('publicacion_id', $publicacion->id)->exists();
            
            // Si no tiene comentarios, crear al menos uno
            if (!$tieneComentarios) {
                $usuario = $usuarios->random();
                
                ComentarioPublicacion::create([
                    'publicacion_id' => $publicacion->id,
                    'user_id' => $usuario->id,
                    'contenido' => $this->generarComentarioAleatorio(),
                    'created_at' => Carbon::now()->subDays(rand(1, 30)),
                    'updated_at' => Carbon::now()->subDays(rand(0, 30))
                ]);
            }
            
            // Añadir más comentarios aleatoriamente (entre 0 y 3 comentarios adicionales)
            $numComentariosAdicionales = rand(0, 3);
            
            for ($i = 0; $i < $numComentariosAdicionales; $i++) {
                $usuario = $usuarios->random();
                $fechaCreacion = Carbon::now()->subDays(rand(1, 30));
                
                ComentarioPublicacion::create([
                    'publicacion_id' => $publicacion->id,
                    'user_id' => $usuario->id,
                    'contenido' => $this->generarComentarioAleatorio(),
                    'created_at' => $fechaCreacion,
                    'updated_at' => $fechaCreacion
                ]);
            }
        }
    }
    
    /**
     * Genera un comentario aleatorio para una publicación
     */
    private function generarComentarioAleatorio()
    {
        $comentarios = [
            '¿Podríais indicar si el horario es flexible o hay un horario fijo establecido?',
            'Me interesa esta oferta. ¿Cuál sería la fecha de incorporación aproximada?',
            '¿Se requiere algún conocimiento específico que no esté listado en los requisitos?',
            'Excelente oportunidad. ¿Existe posibilidad de continuar en la empresa después de las prácticas?',
            '¿Las prácticas están orientadas a algún departamento o proyecto específico?',
            '¿Cuántas plazas están disponibles para esta oferta?',
            'Actualmente curso el segundo año del ciclo formativo. ¿Aceptan estudiantes que aún no han terminado la formación teórica?',
            '¿Podríais detallar más las tareas concretas a realizar durante las prácticas?',
            '¿Existe la posibilidad de realizar las prácticas en modalidad semipresencial?',
            'Me gustaría saber si las prácticas incluyen algún tipo de formación específica por parte de la empresa.',
            '¿Es necesario tener un nivel alto de inglés para esta posición?',
            '¿La empresa proporciona algún tipo de ayuda para el transporte o comidas?',
            'Esta oferta encaja perfectamente con mi perfil. ¿Cómo debería proceder para formalizar mi candidatura?',
            '¿Se realiza algún tipo de evaluación técnica durante el proceso de selección?',
            'Parece una gran oportunidad. ¿Qué competencias valoran más en los candidatos?',
            'Como tutor del ciclo formativo, me interesaría conocer las condiciones del convenio para mis alumnos.',
            '¿Hay posibilidad de adaptar el horario para compatibilizar con los estudios?',
            '¿Qué herramientas o software específico utilizáis en vuestro entorno de desarrollo?',
            '¿Cuánto tiempo suele durar el proceso de selección desde la aplicación hasta la incorporación?',
            '¿Se ofrece mentorización por parte de algún profesional senior durante las prácticas?'
        ];
        
        return $comentarios[array_rand($comentarios)];
    }
} 