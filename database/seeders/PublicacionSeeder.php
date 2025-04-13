<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Publicacion;
use App\Models\Empresa;
use App\Models\Categoria;
use App\Models\Subcategoria;

class PublicacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $empresas = Empresa::all();
        $categorias = Categoria::all();
        $subcategorias = Subcategoria::all();
        $horarios = ['mañana', 'tarde'];
        
        // Títulos realistas para publicaciones
        $titulos = [
            'Desarrollador Frontend con React',
            'Desarrollador Backend con PHP y Laravel',
            'Desarrollador Full Stack Junior',
            'Desarrollador Móvil con Flutter',
            'Desarrollador iOS con Swift',
            'Desarrollador Android con Kotlin',
            'Administrador de Sistemas Linux',
            'Especialista en Ciberseguridad',
            'Analista de Datos y Business Intelligence',
            'Especialista en Marketing Digital',
            'Diseñador UI/UX para Aplicaciones Web',
            'Técnico en Gestión Administrativa',
            'Técnico en Logística y Transporte',
            'Técnico en Atención a Clientes',
            'Técnico en Comercio Internacional',
            'Técnico en Turismo y Hostelería',
            'Técnico en Sanidad y Enfermería',
            'Técnico en Servicios Sociales',
            'Técnico en Administración de Bases de Datos',
            'Técnico en DevOps y CI/CD'
        ];
        
        // Descripciones realistas para publicaciones
        $descripciones = [
            'Buscamos un desarrollador frontend con experiencia en React para unirse a nuestro equipo de desarrollo. El candidato ideal tendrá conocimientos en JavaScript, HTML, CSS y experiencia con frameworks modernos.',
            'Necesitamos un desarrollador backend con experiencia en PHP y Laravel para trabajar en proyectos web de mediana y gran escala. Se valorará experiencia en APIs RESTful y bases de datos SQL.',
            'Buscamos un desarrollador full stack junior con ganas de aprender y crecer profesionalmente. El candidato ideal tendrá conocimientos básicos en desarrollo web y estará dispuesto a formarse en nuevas tecnologías.',
            'Necesitamos un desarrollador móvil con experiencia en Flutter para crear aplicaciones multiplataforma. Se valorará experiencia en desarrollo de aplicaciones nativas para iOS y Android.',
            'Buscamos un desarrollador iOS con experiencia en Swift para crear aplicaciones nativas para iPhone y iPad. Se valorará experiencia en SwiftUI y arquitecturas MVVM.',
            'Necesitamos un desarrollador Android con experiencia en Kotlin para crear aplicaciones nativas para dispositivos Android. Se valorará experiencia en Jetpack Compose y arquitecturas limpias.',
            'Buscamos un administrador de sistemas Linux con experiencia en configuración y mantenimiento de servidores. Se valorará experiencia en virtualización, contenedores y automatización.',
            'Necesitamos un especialista en ciberseguridad para proteger nuestros sistemas y datos. Se valorará experiencia en análisis de vulnerabilidades, seguridad de redes y cumplimiento normativo.',
            'Buscamos un analista de datos con experiencia en business intelligence para ayudar a tomar decisiones basadas en datos. Se valorará experiencia en SQL, visualización de datos y herramientas de BI.',
            'Necesitamos un especialista en marketing digital para gestionar nuestras campañas online. Se valorará experiencia en SEO, SEM, redes sociales y análisis de métricas.',
            'Buscamos un diseñador UI/UX para crear interfaces intuitivas y atractivas. Se valorará experiencia en diseño de interfaces, prototipado y herramientas como Figma o Adobe XD.',
            'Necesitamos un técnico en gestión administrativa para apoyar en tareas de administración y contabilidad. Se valorará experiencia en gestión de documentación, facturación y atención al cliente.',
            'Buscamos un técnico en logística y transporte para gestionar el flujo de mercancías. Se valorará experiencia en planificación de rutas, gestión de almacenes y optimización de procesos logísticos.',
            'Necesitamos un técnico en atención a clientes para proporcionar un servicio de calidad. Se valorará experiencia en resolución de incidencias, comunicación efectiva y trabajo en equipo.',
            'Buscamos un técnico en comercio internacional para gestionar operaciones de importación y exportación. Se valorará experiencia en documentación aduanera, logística internacional y gestión de proveedores.',
            'Necesitamos un técnico en turismo y hostelería para gestionar servicios turísticos. Se valorará experiencia en atención al cliente, gestión de reservas y conocimiento de destinos turísticos.',
            'Buscamos un técnico en sanidad y enfermería para apoyar en tareas de atención sanitaria. Se valorará experiencia en primeros auxilios, cuidados básicos y trabajo en equipo en entornos sanitarios.',
            'Necesitamos un técnico en servicios sociales para apoyar a personas en situación de vulnerabilidad. Se valorará experiencia en intervención social, trabajo en equipo y empatía.',
            'Buscamos un técnico en administración de bases de datos para gestionar y optimizar nuestros sistemas de datos. Se valorará experiencia en SQL, administración de servidores y optimización de consultas.',
            'Necesitamos un técnico en DevOps y CI/CD para automatizar nuestros procesos de desarrollo y despliegue. Se valorará experiencia en Docker, Kubernetes, Jenkins y herramientas de automatización.'
        ];

        // Crear 30 publicaciones de prueba
        for ($i = 0; $i < 30; $i++) {
            $categoria = $categorias->random();
            // Obtener una subcategoría que pertenezca a la categoría seleccionada
            $subcategoria = $subcategorias->where('categoria_id', $categoria->id)->random();
            $empresa = $empresas->random();
            $tituloIndex = $i % count($titulos);
            $descripcionIndex = $i % count($descripciones);

            Publicacion::create([
                'titulo' => $titulos[$tituloIndex],
                'descripcion' => $descripciones[$descripcionIndex],
                'horario' => $horarios[array_rand($horarios)],
                'horas_totales' => rand(100, 500),
                'fecha_publicacion' => fake()->dateTimeBetween('-1 month', 'now'),
                'activa' => true,
                'empresa_id' => $empresa->id,
                'categoria_id' => $categoria->id,
                'subcategoria_id' => $subcategoria->id,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
