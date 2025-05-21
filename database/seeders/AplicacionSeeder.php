<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Aplicacion;
use App\Models\Publicacion;
use App\Models\User;
use Carbon\Carbon;

class AplicacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener publicaciones y estudiantes
        $publicaciones = Publicacion::all();
        $estudiantes = User::where('role_id', 3)->get();
        
        // Verificar si hay suficientes datos
        if ($publicaciones->isEmpty() || $estudiantes->isEmpty()) {
            echo "Error: No hay suficientes publicaciones o estudiantes para crear aplicaciones\n";
            return;
        }
        
        // Estados posibles para una aplicación
        $estados = ['pendiente', 'revisada', 'aceptada', 'rechazada', 'en_proceso', 'finalizada'];
        
        // Aplicaciones fijas para ciertas publicaciones y estudiantes
        $aplicacionesFijas = [
            [
                'publicacion_index' => 0, // Primera publicación
                'estudiante' => 'María Rodríguez',
                'estado' => 'aceptada',
                'fecha_aplicacion' => '2023-10-10',
                'mensaje' => 'Me interesa mucho esta oferta de prácticas ya que se alinea perfectamente con mi perfil de desarrolladora frontend. He realizado varios proyectos personales con React y estoy familiarizada con TypeScript. Actualmente curso el último año del ciclo formativo de DAW y busco realizar prácticas que me permitan aplicar y ampliar mis conocimientos en un entorno real.',
                'cv_path' => 'cvs/maria_rodriguez_cv.pdf'
            ],
            [
                'publicacion_index' => 0, // Primera publicación
                'estudiante' => 'Carlos Martínez',
                'estado' => 'rechazada',
                'fecha_aplicacion' => '2023-10-12',
                'mensaje' => 'Aunque mi especialidad principal es la ciberseguridad, tengo conocimientos sólidos de JavaScript y he trabajado en proyectos de frontend con React. Me interesa esta oportunidad para ampliar mi perfil profesional hacia el desarrollo web frontend mientras termino mis estudios.',
                'cv_path' => 'cvs/carlos_martinez_cv.pdf'
            ],
            [
                'publicacion_index' => 1, // Segunda publicación
                'estudiante' => 'Carlos Martínez',
                'estado' => 'aceptada',
                'fecha_aplicacion' => '2023-10-15',
                'mensaje' => 'Como estudiante especializado en ciberseguridad, esta oferta encaja perfectamente con mi perfil. Tengo conocimientos de análisis de vulnerabilidades, pentesting básico y he participado en CTFs. Mi objetivo es desarrollar una carrera en el ámbito de la seguridad informática y creo que esta oportunidad sería ideal para mi crecimiento profesional.',
                'cv_path' => 'cvs/carlos_martinez_cv.pdf'
            ],
            [
                'publicacion_index' => 2, // Tercera publicación
                'estudiante' => 'Laura Fernández',
                'estado' => 'aceptada',
                'fecha_aplicacion' => '2023-11-05',
                'mensaje' => 'Soy estudiante de DAM con especialización en desarrollo móvil. He creado aplicaciones tanto para Android (Java/Kotlin) como para iOS (Swift) y tengo experiencia con Flutter para desarrollo multiplataforma. Esta oferta se alinea perfectamente con mi perfil y estoy muy interesada en unirme a su equipo de desarrollo móvil.',
                'cv_path' => 'cvs/laura_fernandez_cv.pdf'
            ],
            [
                'publicacion_index' => 3, // Cuarta publicación
                'estudiante' => 'Antonio López',
                'estado' => 'finalizada',
                'fecha_aplicacion' => '2023-09-05',
                'mensaje' => 'Como estudiante de último año de DAM con enfoque en backend, me interesa particularmente esta posición. Tengo experiencia con Java, Spring Boot y bases de datos relacionales. He desarrollado varios microservicios y estoy familiarizado con arquitecturas orientadas a servicios. Estoy disponible para incorporarme inmediatamente.',
                'cv_path' => 'cvs/antonio_lopez_cv.pdf'
            ],
            [
                'publicacion_index' => 4, // Quinta publicación
                'estudiante' => 'Elena Gómez',
                'estado' => 'en_proceso',
                'fecha_aplicacion' => '2023-10-20',
                'mensaje' => 'Me especializo en análisis de datos y Business Intelligence. He trabajado con Power BI, Tableau y tengo conocimientos de Python para análisis de datos. Estoy cursando el último año de ASIR con especialización en Big Data y me interesa mucho esta oportunidad para aplicar mis conocimientos en un entorno empresarial real.',
                'cv_path' => 'cvs/elena_gomez_cv.pdf'
            ],
            [
                'publicacion_index' => 5, // Sexta publicación
                'estudiante' => 'Javier Sánchez',
                'estado' => 'pendiente',
                'fecha_aplicacion' => '2023-11-25',
                'mensaje' => 'Tengo experiencia en desarrollo de aplicaciones IoT con Arduino y Raspberry Pi. He trabajado con sensores diversos y creado sistemas domóticos. También tengo conocimientos de AWS IoT y Microsoft Azure IoT Hub. Estoy muy interesado en esta posición ya que se alinea perfectamente con mi formación y aspiraciones profesionales.',
                'cv_path' => 'cvs/javier_sanchez_cv.pdf'
            ],
            [
                'publicacion_index' => 6, // Séptima publicación
                'estudiante' => 'Sofía Pérez',
                'estado' => 'en_proceso',
                'fecha_aplicacion' => '2023-10-18',
                'mensaje' => 'Como estudiante de ciencia de datos, he trabajado con Python, Pandas, scikit-learn y TensorFlow. Tengo experiencia en análisis predictivo y visualización de datos. Esta posición representa una oportunidad ideal para aplicar mis conocimientos en un entorno real mientras completo mi formación académica.',
                'cv_path' => 'cvs/sofia_perez_cv.pdf'
            ],
            [
                'publicacion_index' => 7, // Octava publicación
                'estudiante' => 'Miguel Torres',
                'estado' => 'rechazada',
                'fecha_aplicacion' => '2024-01-10',
                'mensaje' => 'Soy estudiante de último año de ASIR especializado en administración de sistemas Linux y entornos cloud. Tengo certificaciones AWS y experiencia en Docker y Kubernetes. Me interesa esta posición para desarrollar mi carrera en DevOps y arquitecturas cloud modernas.',
                'cv_path' => 'cvs/miguel_torres_cv.pdf'
            ],
            [
                'publicacion_index' => 8, // Novena publicación
                'estudiante' => 'Sara Navarro',
                'estado' => 'aceptada',
                'fecha_aplicacion' => '2023-09-25',
                'mensaje' => 'Como desarrolladora frontend, he trabajado extensamente con React, Styled Components y arquitecturas modernas como Atomic Design. Tengo conocimientos de accesibilidad web y experiencia en optimización del rendimiento. Estoy muy interesada en esta oportunidad para continuar creciendo profesionalmente en una empresa líder del sector.',
                'cv_path' => 'cvs/sara_navarro_cv.pdf'
            ],
            [
                'publicacion_index' => 9, // Décima publicación
                'estudiante' => 'Daniel Ruiz',
                'estado' => 'revisada',
                'fecha_aplicacion' => '2023-12-05',
                'mensaje' => 'Soy desarrollador backend con experiencia en Node.js, Express y MongoDB. He implementado varias APIs RESTful y tengo conocimientos de arquitecturas basadas en microservicios. Esta posición es de gran interés para mí ya que se alinea con mi especialidad y objetivos profesionales.',
                'cv_path' => 'cvs/daniel_ruiz_cv.pdf'
            ],
        ];
        
        // Crear aplicaciones fijas
        foreach ($aplicacionesFijas as $aplicacionData) {
            // Buscar publicación y estudiante
            $publicacion = isset($publicaciones[$aplicacionData['publicacion_index']]) ? 
                            $publicaciones[$aplicacionData['publicacion_index']] : null;
            $estudiante = $estudiantes->where('nombre', $aplicacionData['estudiante'])->first();
            
            // Si no encontramos la publicación o estudiante, continuamos con la siguiente aplicación
            if (!$publicacion || !$estudiante) {
                continue;
            }
            
            // Obtener estudiante_id del estudiante (si existe la relación)
            $estudianteID = $estudiante->estudiante->id ?? null;
            
            // Si no podemos obtener el ID del estudiante, continuamos
            if (!$estudianteID) {
                continue;
            }
            
            // Crear la aplicación
            Aplicacion::create([
                'publicacion_id' => $publicacion->id,
                'estudiante_id' => $estudianteID,
                'estado' => $aplicacionData['estado'],
                'fecha_aplicacion' => $aplicacionData['fecha_aplicacion'],
                'mensaje' => $aplicacionData['mensaje'],
                'cv_path' => $aplicacionData['cv_path'],
                'created_at' => Carbon::parse($aplicacionData['fecha_aplicacion']),
                'updated_at' => Carbon::parse($aplicacionData['fecha_aplicacion'])->addDays(rand(1, 10))
            ]);
        }
        
        // Crear aplicaciones aleatorias adicionales
        // Asegurar que cada publicación tenga al menos una aplicación
        foreach ($publicaciones as $publicacion) {
            // Verificar si la publicación ya tiene aplicaciones
            $tieneAplicaciones = Aplicacion::where('publicacion_id', $publicacion->id)->exists();
            
            // Si no tiene aplicaciones, crear al menos una
            if (!$tieneAplicaciones) {
                $estudiante = $estudiantes->random();
                $estudianteID = $estudiante->estudiante->id ?? null;
                
                // Si no podemos obtener el ID del estudiante, continuamos
                if (!$estudianteID) {
                    continue;
                }
                
                // Fecha aleatoria dentro de un rango lógico
                $fechaAplicacion = Carbon::now()->subDays(rand(1, 60));
                
                Aplicacion::create([
                    'publicacion_id' => $publicacion->id,
                    'estudiante_id' => $estudianteID,
                    'estado' => $estados[array_rand($estados)],
                    'fecha_aplicacion' => $fechaAplicacion,
                    'mensaje' => $this->generarMensajeAplicacion(),
                    'cv_path' => 'cvs/estudiante_' . $estudianteID . '_cv.pdf',
                    'created_at' => $fechaAplicacion,
                    'updated_at' => $fechaAplicacion->copy()->addDays(rand(1, 10))
                ]);
            }
            
            // Añadir más aplicaciones aleatoriamente (entre 0 y 5 aplicaciones adicionales)
            $numAplicacionesAdicionales = rand(0, 5);
            
            // Estudiantes que ya han aplicado a esta publicación (para evitar duplicados)
            $estudiantesAplicados = Aplicacion::where('publicacion_id', $publicacion->id)
                                    ->pluck('estudiante_id')
                                    ->toArray();
            
            // Contador de intentos para evitar bucles infinitos
            $intentos = 0;
            $aplicacionesCreadas = 0;
            
            while ($aplicacionesCreadas < $numAplicacionesAdicionales && $intentos < 50) {
                $estudiante = $estudiantes->random();
                $estudianteID = $estudiante->estudiante->id ?? null;
                
                // Si no podemos obtener el ID del estudiante o ya ha aplicado, continuamos
                if (!$estudianteID || in_array($estudianteID, $estudiantesAplicados)) {
                    $intentos++;
                    continue;
                }
                
                // Añadir a la lista de estudiantes que han aplicado
                $estudiantesAplicados[] = $estudianteID;
                
                // Fecha aleatoria dentro de un rango lógico
                $fechaAplicacion = Carbon::now()->subDays(rand(1, 60));
                
                Aplicacion::create([
                    'publicacion_id' => $publicacion->id,
                    'estudiante_id' => $estudianteID,
                    'estado' => $estados[array_rand($estados)],
                    'fecha_aplicacion' => $fechaAplicacion,
                    'mensaje' => $this->generarMensajeAplicacion(),
                    'cv_path' => 'cvs/estudiante_' . $estudianteID . '_cv.pdf',
                    'created_at' => $fechaAplicacion,
                    'updated_at' => $fechaAplicacion->copy()->addDays(rand(1, 10))
                ]);
                
                $aplicacionesCreadas++;
            }
        }
    }
    
    /**
     * Genera un mensaje aleatorio para una aplicación
     */
    private function generarMensajeAplicacion()
    {
        $introduccionesPersonales = [
            'Soy estudiante de último año de',
            'Actualmente estoy cursando',
            'Me encuentro finalizando mis estudios de',
            'Como alumno avanzado de',
            'Estoy a punto de completar mi formación en'
        ];
        
        $estudios = [
            'Desarrollo de Aplicaciones Web (DAW)',
            'Desarrollo de Aplicaciones Multiplataforma (DAM)',
            'Administración de Sistemas Informáticos en Red (ASIR)',
            'Desarrollo Web Frontend',
            'Desarrollo de Aplicaciones Móviles',
            'Ciencia de Datos y Business Intelligence',
            'Ciberseguridad',
            'Full Stack Development'
        ];
        
        $experiencias = [
            'He participado en varios proyectos académicos utilizando tecnologías como ',
            'Cuento con experiencia en desarrollo de proyectos con tecnologías como ',
            'He realizado prácticas previas donde he trabajado con ',
            'Durante mi formación he adquirido habilidades en ',
            'He desarrollado proyectos personales implementando '
        ];
        
        $tecnologias = [
            'Java, Spring Boot y MySQL',
            'JavaScript, React y Node.js',
            'Python, Django y PostgreSQL',
            'HTML5, CSS3, Bootstrap y JavaScript',
            'React Native y Firebase',
            'Flutter y Dart',
            'PHP, Laravel y MySQL',
            'Python, Pandas y scikit-learn',
            'C#, .NET Core y SQL Server',
            'Vue.js, Vuex y Express'
        ];
        
        $motivaciones = [
            'Me interesa esta oferta porque se alinea perfectamente con mi formación y objetivos profesionales.',
            'Esta oportunidad representa un entorno ideal para aplicar mis conocimientos y continuar aprendiendo.',
            'Estoy muy interesado en esta vacante ya que me permitiría desarrollarme profesionalmente en el ámbito que más me apasiona.',
            'Considero que esta posición es ideal para comenzar mi carrera profesional y aportar valor con mis conocimientos.',
            'Me entusiasma la posibilidad de formar parte de su equipo y contribuir con mis habilidades al desarrollo de sus proyectos.'
        ];
        
        $disponibilidades = [
            'Estoy disponible para incorporarme inmediatamente.',
            'Podría comenzar las prácticas a partir del próximo mes.',
            'Mi disponibilidad es completa y me puedo adaptar a sus necesidades.',
            'Puedo incorporarme tan pronto como se requiera.',
            'Tengo disponibilidad total para iniciar cuando sea necesario.'
        ];
        
        // Construir un mensaje coherente
        $mensaje = $introduccionesPersonales[array_rand($introduccionesPersonales)] . ' ' .
                  $estudios[array_rand($estudios)] . '. ' .
                  $experiencias[array_rand($experiencias)] .
                  $tecnologias[array_rand($tecnologias)] . '. ' .
                  $motivaciones[array_rand($motivaciones)] . ' ' .
                  $disponibilidades[array_rand($disponibilidades)];
        
        return $mensaje;
    }
} 