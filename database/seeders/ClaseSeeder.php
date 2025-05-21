<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Clase;
use App\Models\Departamento;
use App\Models\NivelEducativo;
use App\Models\Categoria;
use App\Models\Institucion;
use App\Models\Docente;

class ClaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtenemos referencias a las entidades relacionadas
        $departamentos = Departamento::all();
        $nivelesEducativos = NivelEducativo::all();
        $categorias = Categoria::all();
        $instituciones = Institucion::all();
        $docentes = Docente::all();

        // Si no hay suficientes datos, no podemos continuar
        if ($departamentos->isEmpty() || $nivelesEducativos->isEmpty() || 
            $categorias->isEmpty() || $instituciones->isEmpty() || $docentes->isEmpty()) {
            // Log error si no hay datos suficientes
            echo "Error: No hay suficientes datos en las tablas relacionadas para crear clases\n";
            return;
        }

        // Array de datos de clases fijas para que siempre creen los mismos
        $clases = [
            [
                'nombre' => 'DAW2 - Desarrollo de Aplicaciones Web',
                'codigo' => 'DAW2A',
                'nivel' => 'Formación Profesional',
                'curso' => '2º',
                'grupo' => 'A',
                'descripcion' => 'Clase de segundo año de Desarrollo de Aplicaciones Web. Enfocada en tecnologías web avanzadas.',
                'capacidad' => 25,
                'horario' => 'Lunes a Viernes, 08:00-14:00',
                'departamento_id' => 1, // Informática y Comunicaciones
                'nivel_educativo_id' => 3, // Formación Profesional Superior
                'categoria_id' => 1, // Informática
                'institucion_id' => 1
            ],
            [
                'nombre' => 'DAM2 - Desarrollo de Aplicaciones Multiplataforma',
                'codigo' => 'DAM2A',
                'nivel' => 'Formación Profesional',
                'curso' => '2º',
                'grupo' => 'A',
                'descripcion' => 'Clase de segundo año de Desarrollo de Aplicaciones Multiplataforma. Especializada en desarrollo de software para diversas plataformas.',
                'capacidad' => 30,
                'horario' => 'Lunes a Viernes, 15:00-21:00',
                'departamento_id' => 1, // Informática y Comunicaciones
                'nivel_educativo_id' => 3, // Formación Profesional Superior
                'categoria_id' => 1, // Informática
                'institucion_id' => 2
            ],
            [
                'nombre' => 'ASIR2 - Administración de Sistemas Informáticos en Red',
                'codigo' => 'ASIR2A',
                'nivel' => 'Formación Profesional',
                'curso' => '2º',
                'grupo' => 'A',
                'descripcion' => 'Clase de segundo año de Administración de Sistemas. Centrada en gestión de infraestructuras y ciberseguridad.',
                'capacidad' => 28,
                'horario' => 'Lunes a Viernes, 08:00-14:00',
                'departamento_id' => 1, // Informática y Comunicaciones
                'nivel_educativo_id' => 3, // Formación Profesional Superior
                'categoria_id' => 2, // Sistemas
                'institucion_id' => 3 % count($instituciones) + 1
            ],
            [
                'nombre' => 'Marketing Digital Avanzado',
                'codigo' => 'MKT2A',
                'nivel' => 'Formación Profesional',
                'curso' => '2º',
                'grupo' => 'A',
                'descripcion' => 'Clase especializada en estrategias de marketing en medios digitales y análisis de datos.',
                'capacidad' => 25,
                'horario' => 'Lunes a Viernes, 15:00-21:00',
                'departamento_id' => 2 % count($departamentos) + 1, // Marketing y Comunicación
                'nivel_educativo_id' => 3, // Formación Profesional Superior
                'categoria_id' => 5 % count($categorias) + 1, // Marketing
                'institucion_id' => 1
            ],
            [
                'nombre' => 'Diseño Gráfico y Web',
                'codigo' => 'DGW2A',
                'nivel' => 'Formación Profesional',
                'curso' => '2º',
                'grupo' => 'A',
                'descripcion' => 'Clase avanzada de diseño gráfico y creación de interfaces web con enfoque UX/UI.',
                'capacidad' => 20,
                'horario' => 'Lunes a Viernes, 08:00-14:00',
                'departamento_id' => 3 % count($departamentos) + 1, // Diseño y Artes Gráficas
                'nivel_educativo_id' => 3, // Formación Profesional Superior
                'categoria_id' => 4 % count($categorias) + 1, // Diseño
                'institucion_id' => 2
            ],
            [
                'nombre' => 'Comercio Internacional y Logística',
                'codigo' => 'CIL2A',
                'nivel' => 'Formación Profesional',
                'curso' => '2º',
                'grupo' => 'A',
                'descripcion' => 'Formación en procesos logísticos internacionales y gestión aduanera.',
                'capacidad' => 22,
                'horario' => 'Lunes a Viernes, 15:00-21:00',
                'departamento_id' => 4 % count($departamentos) + 1, // Comercio Internacional
                'nivel_educativo_id' => 3, // Formación Profesional Superior
                'categoria_id' => 7 % count($categorias) + 1, // Comercio
                'institucion_id' => 1
            ],
            [
                'nombre' => 'Administración y Finanzas',
                'codigo' => 'ADF2A',
                'nivel' => 'Formación Profesional',
                'curso' => '2º',
                'grupo' => 'A',
                'descripcion' => 'Clase especializada en gestión contable, fiscal y financiera de empresas.',
                'capacidad' => 30,
                'horario' => 'Lunes a Viernes, 08:00-14:00',
                'departamento_id' => 5 % count($departamentos) + 1, // Administración y Finanzas
                'nivel_educativo_id' => 3, // Formación Profesional Superior
                'categoria_id' => 6 % count($categorias) + 1, // Administración
                'institucion_id' => 2
            ],
            [
                'nombre' => 'Sistemas Electrónicos y Automáticos',
                'codigo' => 'SEA2A',
                'nivel' => 'Formación Profesional',
                'curso' => '2º',
                'grupo' => 'A',
                'descripcion' => 'Clase centrada en el desarrollo y mantenimiento de sistemas de automatización industrial.',
                'capacidad' => 24,
                'horario' => 'Lunes a Viernes, 15:00-21:00',
                'departamento_id' => 6 % count($departamentos) + 1, // Electrónica y Automatización
                'nivel_educativo_id' => 3, // Formación Profesional Superior
                'categoria_id' => 3 % count($categorias) + 1, // Electrónica
                'institucion_id' => 1
            ],
            [
                'nombre' => 'Producción Audiovisual',
                'codigo' => 'PAV2A',
                'nivel' => 'Formación Profesional',
                'curso' => '2º',
                'grupo' => 'A',
                'descripcion' => 'Clase enfocada en técnicas de producción audiovisual y edición multimedia.',
                'capacidad' => 18,
                'horario' => 'Lunes a Viernes, 08:00-14:00',
                'departamento_id' => 7 % count($departamentos) + 1, // Imagen y Sonido
                'nivel_educativo_id' => 3, // Formación Profesional Superior
                'categoria_id' => 8 % count($categorias) + 1, // Audiovisual
                'institucion_id' => 2
            ],
            [
                'nombre' => 'Gestión Hostelera y Turística',
                'codigo' => 'GHT2A',
                'nivel' => 'Formación Profesional',
                'curso' => '2º',
                'grupo' => 'A',
                'descripcion' => 'Clase especializada en dirección de establecimientos turísticos y hosteleros.',
                'capacidad' => 25,
                'horario' => 'Lunes a Viernes, 15:00-21:00',
                'departamento_id' => 8 % count($departamentos) + 1, // Hostelería y Turismo
                'nivel_educativo_id' => 3, // Formación Profesional Superior
                'categoria_id' => 6 % count($categorias) + 1, // Administración (Turística)
                'institucion_id' => 1
            ],
            [
                'nombre' => 'SMR2 - Sistemas Microinformáticos y Redes',
                'codigo' => 'SMR2A',
                'nivel' => 'Formación Profesional',
                'curso' => '2º',
                'grupo' => 'A',
                'descripcion' => 'Clase de segundo año de Sistemas Microinformáticos. Enfocada en mantenimiento de sistemas y redes.',
                'capacidad' => 30,
                'horario' => 'Lunes a Viernes, 08:00-14:00',
                'departamento_id' => 1, // Informática y Comunicaciones
                'nivel_educativo_id' => 2, // Formación Profesional Media
                'categoria_id' => 2, // Sistemas
                'institucion_id' => 2
            ],
            [
                'nombre' => 'Desarrollo Web Frontend',
                'codigo' => 'DWF1A',
                'nivel' => 'Formación Profesional',
                'curso' => '1º',
                'grupo' => 'A',
                'descripcion' => 'Especialización en desarrollo frontend con HTML, CSS y JavaScript avanzado.',
                'capacidad' => 20,
                'horario' => 'Lunes a Viernes, 15:00-21:00',
                'departamento_id' => 1, // Informática y Comunicaciones
                'nivel_educativo_id' => 4, // Formación Profesional Especialización
                'categoria_id' => 1, // Informática
                'institucion_id' => 1
            ]
        ];

        // Asignamos docentes a las clases de forma coherente
        $docentesAsignados = [];
        
        foreach ($clases as $index => $claseData) {
            // Asegurar que todas las referencias existan usando valores por defecto si no hay suficientes
            $departamentoId = isset($departamentos[$claseData['departamento_id'] - 1]) 
                ? $departamentos[$claseData['departamento_id'] - 1]->id 
                : $departamentos[0]->id;
                
            $nivelEducativoId = isset($nivelesEducativos[$claseData['nivel_educativo_id'] - 1])
                ? $nivelesEducativos[$claseData['nivel_educativo_id'] - 1]->id
                : $nivelesEducativos[0]->id;
                
            $categoriaId = isset($categorias[$claseData['categoria_id'] - 1])
                ? $categorias[$claseData['categoria_id'] - 1]->id
                : $categorias[0]->id;
                
            $institucionId = isset($instituciones[$claseData['institucion_id'] - 1])
                ? $instituciones[$claseData['institucion_id'] - 1]->id
                : $instituciones[0]->id;
            
            // Si no hay suficientes docentes, asignamos de forma cíclica
            if ($index >= count($docentes)) {
                $docenteId = $docentes[$index % count($docentes)]->id;
            } else {
                $docenteId = $docentes[$index]->id;
            }
            
            $docentesAsignados[$index] = $docenteId;
            
            // Creamos la clase
            Clase::create([
                'nombre' => $claseData['nombre'],
                'codigo' => $claseData['codigo'],
                'nivel' => $claseData['nivel'],
                'curso' => $claseData['curso'],
                'grupo' => $claseData['grupo'],
                'descripcion' => $claseData['descripcion'],
                'capacidad' => $claseData['capacidad'],
                'horario' => $claseData['horario'],
                'departamento_id' => $departamentoId,
                'nivel_educativo_id' => $nivelEducativoId,
                'categoria_id' => $categoriaId,
                'institucion_id' => $institucionId,
                'docente_id' => $docenteId,
                'activa' => true
            ]);
        }
    }
} 