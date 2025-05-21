<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Publicacion;
use App\Models\Categoria;
use App\Models\Subcategoria;
use App\Models\Empresa;
use App\Models\User;

class PublicacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener empresas, categorías y subcategorías
        $empresas = Empresa::all();
        if ($empresas->isEmpty()) {
            echo "Error: No hay empresas para asociar a las publicaciones\n";
            return;
        }

        $categorias = Categoria::all();
        if ($categorias->isEmpty()) {
            echo "Error: No hay categorías para clasificar las publicaciones\n";
            return;
        }

        $subcategorias = Subcategoria::all();
        if ($subcategorias->isEmpty()) {
            echo "Error: No hay subcategorías disponibles\n";
            return;
        }

        // Crear algunas ofertas para empresas específicas
        $ofertas = [
            [
                'empresa_nombre' => 'Telefónica España',
                'titulo' => 'Desarrollador Frontend para prácticas',
                'descripcion' => 'Buscamos estudiantes para realizar prácticas en nuestro departamento de desarrollo frontend. Trabajarás con React, TypeScript y herramientas modernas de desarrollo web.',
                'categoria_id' => 1, // Desarrollo web
                'subcategoria_id' => 1, // Frontend
            ],
            [
                'empresa_nombre' => 'BBVA Tech',
                'titulo' => 'Becario para el departamento de ciberseguridad',
                'descripcion' => 'Ofrecemos prácticas en nuestro equipo de ciberseguridad. Participarás en análisis de vulnerabilidades, pruebas de penetración y desarrollo de protocolos de seguridad.',
                'categoria_id' => 3, // Ciberseguridad
                'subcategoria_id' => 16, // Seguridad web
            ],
            [
                'empresa_nombre' => 'Indra Sistemas',
                'titulo' => 'Desarrollador de aplicaciones móviles en prácticas',
                'descripcion' => 'Buscamos un estudiante para nuestro equipo de desarrollo móvil. Trabajarás en aplicaciones nativas para iOS y Android, así como en soluciones multiplataforma con Flutter.',
                'categoria_id' => 2, // Desarrollo móvil
                'subcategoria_id' => 6, // Android
            ],
            [
                'empresa_nombre' => 'CaixaBank Tech',
                'titulo' => 'Prácticas en desarrollo backend con Java',
                'descripcion' => 'Únete a nuestro equipo de backend para desarrollar servicios bancarios con Java, Spring Boot y arquitecturas de microservicios. Ofrecemos formación continua y posibilidad de contratación.',
                'categoria_id' => 1, // Desarrollo web
                'subcategoria_id' => 2, // Backend
            ],
            [
                'empresa_nombre' => 'Mercadona IT',
                'titulo' => 'Analista de datos en prácticas',
                'descripcion' => 'Buscamos un estudiante para nuestro departamento de Business Intelligence. Trabajarás con grandes volúmenes de datos utilizando SQL, Power BI y herramientas de reporting.',
                'categoria_id' => 4, // Data Science
                'subcategoria_id' => 21, // Business Intelligence
            ]
        ];

        foreach ($ofertas as $oferta) {
            // Buscar la empresa por nombre
            $empresa = $empresas->first(function($emp) use ($oferta) {
                $user = User::find($emp->user_id);
                return $user && $user->nombre === $oferta['empresa_nombre'];
            });

            // Si no encontramos la empresa específica, usar una aleatoria
            if (!$empresa) {
                $empresa = $empresas->random();
            }

            // Crear la publicación
            Publicacion::create([
                'titulo' => $oferta['titulo'],
                'descripcion' => $oferta['descripcion'],
                'horario' => array_rand(['mañana' => 'mañana', 'tarde' => 'tarde']),
                'horas_totales' => 300,
                'activa' => true,
                'empresa_id' => $empresa->id,
                'categoria_id' => $oferta['categoria_id'],
                'subcategoria_id' => $oferta['subcategoria_id'],
                'fecha_publicacion' => now()->subDays(rand(1, 30)),
                'created_at' => now()->subDays(rand(30, 60)),
                'updated_at' => now()->subDays(rand(1, 29))
            ]);
        }

        // Crear publicaciones aleatorias adicionales (2-3 por empresa)
        foreach ($empresas as $empresa) {
            $numPublicaciones = rand(2, 3);
            
            for ($i = 0; $i < $numPublicaciones; $i++) {
                // Seleccionar categoría y subcategoría aleatoria
                $categoria = $categorias->random();
                $subcategoriasPosibles = $subcategorias->where('categoria_id', $categoria->id);
                
                // Si no hay subcategorías para esta categoría, saltar a la siguiente iteración
                if ($subcategoriasPosibles->isEmpty()) {
                    continue;
                }
                
                $subcategoria = $subcategoriasPosibles->random();
                
                // Crear publicación
                Publicacion::create([
                    'titulo' => $this->generarTitulo($categoria->id),
                    'descripcion' => $this->generarDescripcion($categoria->id),
                    'horario' => array_rand(['mañana' => 'mañana', 'tarde' => 'tarde']),
                    'horas_totales' => 300,
                    'activa' => true,
                    'empresa_id' => $empresa->id,
                    'categoria_id' => $categoria->id,
                    'subcategoria_id' => $subcategoria->id,
                    'fecha_publicacion' => now()->subDays(rand(1, 30)),
                    'created_at' => now()->subDays(rand(30, 60)),
                    'updated_at' => now()->subDays(rand(1, 29))
                ]);
            }
        }
    }

    /**
     * Genera un título aleatorio según la categoría
     */
    private function generarTitulo($categoriaId)
    {
        $titulos = [
            1 => [ // Desarrollo web
                'Desarrollador/a Full Stack para prácticas',
                'Becario/a en Desarrollo Web Frontend',
                'Prácticas de Programación Backend',
                'Estudiante para Desarrollo Web con React',
                'Prácticas en Tecnologías Cloud y Web'
            ],
            2 => [ // Desarrollo móvil
                'Desarrollador/a de Apps para prácticas',
                'Becario/a para desarrollo iOS',
                'Prácticas en desarrollo Android',
                'Estudiante para equipo móvil multiplataforma',
                'Prácticas en Flutter y React Native'
            ],
            3 => [ // Ciberseguridad
                'Prácticas en Departamento de Ciberseguridad',
                'Becario/a para Análisis de Vulnerabilidades',
                'Estudiante para Ethical Hacking',
                'Prácticas en Seguridad de Aplicaciones',
                'Becario/a para equipo de Pentesting'
            ],
            4 => [ // Data Science
                'Becario/a en Ciencia de Datos',
                'Prácticas de Machine Learning',
                'Estudiante para proyecto de Big Data',
                'Becario/a para análisis de datos',
                'Prácticas en departamento de BI'
            ],
            5 => [ // DevOps
                'Prácticas en equipo de DevOps',
                'Becario/a para automatización CI/CD',
                'Estudiante para administración de sistemas',
                'Prácticas en entornos Cloud (AWS/Azure)',
                'Becario/a para equipo de Infraestructura'
            ]
        ];

        // Si no hay títulos para esta categoría, devolver un título genérico
        if (!isset($titulos[$categoriaId])) {
            return 'Becario/a para prácticas en empresa tecnológica';
        }

        return $titulos[$categoriaId][array_rand($titulos[$categoriaId])];
    }

    /**
     * Genera una descripción aleatoria según la categoría
     */
    private function generarDescripcion($categoriaId)
    {
        $descripciones = [
            1 => 'Buscamos un estudiante para realizar prácticas en nuestro departamento de desarrollo web. Te incorporarás a un equipo ágil donde trabajarás en proyectos reales. Requisitos: conocimientos de HTML, CSS, JavaScript y frameworks modernos. Valorable experiencia con React, Angular o Vue.',
            2 => 'Ofrecemos prácticas para estudiantes de desarrollo móvil. Trabajarás con nuestro equipo en la creación y mantenimiento de aplicaciones nativas y multiplataforma. Requisitos: conocimientos de desarrollo iOS o Android. Valorable experiencia con Swift, Kotlin o Flutter.',
            3 => 'Buscamos estudiante para prácticas en nuestro departamento de ciberseguridad. Participarás en análisis de vulnerabilidades y proyectos de seguridad informática. Requisitos: conocimientos de seguridad en redes y aplicaciones. Valorable experiencia en pentesting y herramientas de análisis.',
            4 => 'Ofrecemos prácticas en nuestro departamento de ciencia de datos. Trabajarás con grandes volúmenes de información y técnicas de análisis avanzado. Requisitos: conocimientos de Python, R o SQL. Valorable experiencia con librerías de machine learning y visualización de datos.',
            5 => 'Buscamos un estudiante para prácticas en DevOps. Te incorporarás a nuestro equipo y participarás en la automatización de procesos y despliegues. Requisitos: conocimientos de Linux, Docker y herramientas CI/CD. Valorable experiencia con Kubernetes, AWS o Azure.'
        ];

        // Si no hay descripción para esta categoría, devolver una descripción genérica
        if (!isset($descripciones[$categoriaId])) {
            return 'Buscamos estudiante para realizar prácticas en nuestra empresa. Ofrecemos un entorno formativo, tutorización personalizada y posibilidad de incorporación. Requisitos: estudios relacionados y ganas de aprender.';
        }

        return $descripciones[$categoriaId];
    }
}
