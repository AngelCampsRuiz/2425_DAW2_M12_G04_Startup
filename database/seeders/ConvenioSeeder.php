<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Convenio;
use App\Models\User;
use App\Models\Institucion;
use App\Models\Empresa;

class ConvenioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener empresas e instituciones
        $empresas = User::where('role_id', 2)->get();
        $instituciones = User::where('role_id', 5)->get();
        
        // Verificar si hay suficientes datos
        if ($empresas->isEmpty() || $instituciones->isEmpty()) {
            echo "Error: No hay suficientes empresas o instituciones para crear convenios\n";
            return;
        }
        
        // Definir tipos de convenios
        $tiposConvenio = ['FCT', 'Dual', 'Colaboración', 'Investigación'];
        
        // Definir estados posibles
        $estadosConvenio = ['activo', 'pendiente', 'finalizado', 'cancelado'];
        
        // Convenios fijos para las empresas principales
        $conveniosFijos = [
            [
                'empresa' => 'Telefónica España',
                'institucion' => 'IES Madrid Centro',
                'tipo' => 'FCT',
                'descripcion' => 'Convenio para prácticas de estudiantes de Desarrollo de Aplicaciones Web. Los estudiantes se integrarán en equipos de desarrollo frontend y backend, participando en proyectos reales bajo la supervisión de tutores designados por ambas partes.',
                'fecha_inicio' => '2023-09-01',
                'fecha_fin' => '2025-07-31',
                'condiciones' => 'Prácticas de 400 horas durante el último trimestre del curso. Horario compatible con estudios. Ayuda al transporte de 250€ mensuales.',
                'documento' => 'convenio_telefonica_ies_madrid.pdf',
                'estado' => 'activo'
            ],
            [
                'empresa' => 'BBVA Tech',
                'institucion' => 'IES Madrid Centro',
                'tipo' => 'Dual',
                'descripcion' => 'Convenio de FP Dual en especialidades de Administración de Sistemas Informáticos en Red y Ciberseguridad. Los estudiantes alternarán formación en el centro educativo y en la empresa durante dos cursos académicos.',
                'fecha_inicio' => '2023-09-01',
                'fecha_fin' => '2025-07-31',
                'condiciones' => 'Formación remunerada con beca de 450€ mensuales durante el tiempo en empresa. Posibilidad de contratación para los mejores perfiles.',
                'documento' => 'convenio_bbva_ies_madrid.pdf',
                'estado' => 'activo'
            ],
            [
                'empresa' => 'Indra Sistemas',
                'institucion' => 'Centro FP Barcelona Tech',
                'tipo' => 'FCT',
                'descripcion' => 'Acuerdo para realizar prácticas en el departamento de desarrollo móvil de Indra. Los estudiantes participarán en el ciclo completo de desarrollo de aplicaciones iOS y Android, con especial atención a la experiencia de usuario.',
                'fecha_inicio' => '2023-09-15',
                'fecha_fin' => '2025-06-30',
                'condiciones' => 'Prácticas de 6 meses con posibilidad de prórroga. Horario de media jornada. Ayuda económica de 500€ mensuales.',
                'documento' => 'convenio_indra_barcelona_tech.pdf',
                'estado' => 'activo'
            ],
            [
                'empresa' => 'CaixaBank Tech',
                'institucion' => 'Centro FP Barcelona Tech',
                'tipo' => 'Dual',
                'descripcion' => 'Programa de FP Dual para estudiantes de Desarrollo de Aplicaciones Multiplataforma. Formación específica en tecnologías bancarias y desarrollo de aplicaciones para el sector financiero.',
                'fecha_inicio' => '2023-10-01',
                'fecha_fin' => '2025-06-30',
                'condiciones' => 'Alternancia entre centro formativo y empresa. Beca de 500€ mensuales. Tutorización personalizada y proyecto final en entorno real.',
                'documento' => 'convenio_caixabank_barcelona_tech.pdf',
                'estado' => 'activo'
            ],
            [
                'empresa' => 'Mercadona IT',
                'institucion' => 'Instituto Técnico Valencia',
                'tipo' => 'FCT',
                'descripcion' => 'Convenio para la realización de la Formación en Centros de Trabajo de los ciclos formativos de Informática. Especialización en sistemas ERP y gestión de procesos empresariales.',
                'fecha_inicio' => '2023-09-01',
                'fecha_fin' => '2024-06-30',
                'condiciones' => 'Prácticas de 370 horas. Bolsa de ayuda de 300€ mensuales y gastos de desplazamiento. Formación específica en tecnologías propietarias.',
                'documento' => 'convenio_mercadona_valencia.pdf',
                'estado' => 'activo'
            ],
            [
                'empresa' => 'Repsol Digital',
                'institucion' => 'IES Madrid Centro',
                'tipo' => 'Colaboración',
                'descripcion' => 'Marco de colaboración para el desarrollo conjunto de proyectos innovadores en el ámbito de las energías renovables y la transformación digital. Incluye charlas, talleres y mentorización de proyectos finales.',
                'fecha_inicio' => '2023-01-15',
                'fecha_fin' => '2024-12-31',
                'condiciones' => 'Programa de mentorización para proyectos destacados. Equipamiento tecnológico para el centro. Visitas a instalaciones de Repsol.',
                'documento' => 'convenio_colaboracion_repsol_ies_madrid.pdf',
                'estado' => 'activo'
            ],
            [
                'empresa' => 'Iberdrola Digital',
                'institucion' => 'Instituto Técnico Valencia',
                'tipo' => 'Investigación',
                'descripcion' => 'Acuerdo para el desarrollo de proyectos de investigación en el ámbito de las smart grids y eficiencia energética. Participación de estudiantes y profesores en proyectos reales de la compañía.',
                'fecha_inicio' => '2023-03-01',
                'fecha_fin' => '2025-02-28',
                'condiciones' => 'Financiación de equipamiento para laboratorios. Becas para estudiantes destacados. Publicación conjunta de resultados de investigación.',
                'documento' => 'convenio_investigacion_iberdrola_valencia.pdf',
                'estado' => 'activo'
            ],
            [
                'empresa' => 'Mapfre Tech',
                'institucion' => 'IES Informática Sevilla',
                'tipo' => 'FCT',
                'descripcion' => 'Convenio para prácticas formativas en las áreas de ciberseguridad, analítica de datos y desarrollo de software. Integración en equipos multidisciplinares con proyectos en entornos de preproducción.',
                'fecha_inicio' => '2023-09-01',
                'fecha_fin' => '2024-08-31',
                'condiciones' => 'Duración de 400 horas. Apoyo económico de 350€/mes. Posibilidad de incorporación mediante programa de graduados.',
                'documento' => 'convenio_mapfre_sevilla.pdf',
                'estado' => 'activo'
            ],
            [
                'empresa' => 'Inditex IT',
                'institucion' => 'Centro Superior de Formación Digital',
                'tipo' => 'Dual',
                'descripcion' => 'Programa de FP Dual para estudiantes de Desarrollo de Aplicaciones Web y Big Data. Formación en tecnologías de e-commerce, logística y análisis de datos en el sector retail.',
                'fecha_inicio' => '2023-09-01',
                'fecha_fin' => '2025-07-31',
                'condiciones' => 'Alternancia entre centro y empresa (60%/40%). Beca de 600€ mensuales durante la estancia en empresa. Plan de carrera para los mejores expedientes.',
                'documento' => 'convenio_inditex_csfd.pdf',
                'estado' => 'activo'
            ],
            [
                'empresa' => 'Naturgy Innovación',
                'institucion' => 'Centro FP Barcelona Tech',
                'tipo' => 'Investigación',
                'descripcion' => 'Acuerdo para desarrollar proyectos innovadores en el ámbito de la transición energética y las smart cities. Colaboración en prototipos de aplicaciones para gestión energética eficiente.',
                'fecha_inicio' => '2023-01-01',
                'fecha_fin' => '2024-12-31',
                'condiciones' => 'Dotación de laboratorio específico. Programa de becas para proyectos destacados. Posibilidad de comercialización de resultados.',
                'documento' => 'convenio_naturgy_barcelona_tech.pdf',
                'estado' => 'activo'
            ],
        ];
        
        // Crear convenios fijos
        foreach ($conveniosFijos as $convenioData) {
            // Buscar empresa e institución por nombre
            $empresa = $empresas->where('nombre', $convenioData['empresa'])->first();
            $institucion = $instituciones->where('nombre', $convenioData['institucion'])->first();
            
            // Si no encontramos alguna de las entidades específicas, utilizar alternativas aleatorias
            if (!$empresa) {
                $empresa = $empresas->random();
            }
            
            if (!$institucion) {
                $institucion = $instituciones->random();
            }
            
            // Obtener IDs de las entidades Empresa e Institucion
            $empresaID = $empresa->id;
            $institucionID = $institucion->institucion->id ?? null;
            
            // Si no podemos obtener el ID de la institución, continuamos con el siguiente convenio
            if (!$institucionID) {
                continue;
            }
            
            // Crear el convenio
            Convenio::create([
                'empresa_id' => $empresaID,
                'institucion_id' => $institucionID,
                'tipo' => $convenioData['tipo'],
                'descripcion' => $convenioData['descripcion'],
                'fecha_inicio' => $convenioData['fecha_inicio'],
                'fecha_fin' => $convenioData['fecha_fin'],
                'condiciones' => $convenioData['condiciones'],
                'documento' => $convenioData['documento'],
                'estado' => $convenioData['estado'],
                'created_at' => now()->subDays(rand(30, 180)),
                'updated_at' => now()->subDays(rand(1, 30))
            ]);
        }
        
        // Crear algunos convenios adicionales aleatorios
        $numConveniosAdicionales = 10;
        
        // Convenios entre empresas e instituciones aleatorias
        for ($i = 0; $i < $numConveniosAdicionales; $i++) {
            $empresa = $empresas->random();
            $institucion = $instituciones->random();
            
            // Obtener IDs de las entidades Empresa e Institucion
            $empresaID = $empresa->id;
            $institucionID = $institucion->institucion->id ?? null;
            
            // Si no podemos obtener el ID de la institución, continuamos con el siguiente convenio
            if (!$institucionID) {
                continue;
            }
            
            // Fechas aleatorias lógicas
            $fechaInicio = now()->subMonths(rand(1, 24))->format('Y-m-d');
            $fechaFin = now()->addMonths(rand(1, 36))->format('Y-m-d');
            
            // Estado basado en las fechas
            if (strtotime($fechaInicio) > time()) {
                $estado = 'pendiente';
            } elseif (strtotime($fechaFin) < time()) {
                $estado = 'finalizado';
            } else {
                $estado = $estadosConvenio[array_rand($estadosConvenio)];
            }
            
            // Generar datos aleatorios para el convenio
            Convenio::create([
                'empresa_id' => $empresaID,
                'institucion_id' => $institucionID,
                'tipo' => $tiposConvenio[array_rand($tiposConvenio)],
                'descripcion' => $this->generarDescripcionConvenio($tiposConvenio[array_rand($tiposConvenio)]),
                'fecha_inicio' => $fechaInicio,
                'fecha_fin' => $fechaFin,
                'condiciones' => $this->generarCondicionesConvenio(),
                'documento' => 'convenio_' . $empresa->id . '_' . $institucionID . '.pdf',
                'estado' => $estado,
                'created_at' => now()->subDays(rand(30, 180)),
                'updated_at' => now()->subDays(rand(1, 30))
            ]);
        }
    }
    
    /**
     * Genera una descripción aleatoria para un convenio según su tipo
     */
    private function generarDescripcionConvenio($tipo)
    {
        $descripciones = [
            'FCT' => [
                'Convenio para la realización de la Formación en Centros de Trabajo para estudiantes del centro educativo. Los alumnos se integrarán en diferentes departamentos para completar su formación práctica.',
                'Acuerdo para prácticas formativas en empresa, permitiendo a los estudiantes aplicar y complementar los conocimientos adquiridos en su formación académica.',
                'Convenio de cooperación educativa para la realización de prácticas curriculares. Los estudiantes desarrollarán competencias técnicas y transversales en un entorno profesional real.'
            ],
            'Dual' => [
                'Programa de Formación Profesional Dual que combina la formación en el centro educativo con la actividad laboral remunerada en la empresa.',
                'Acuerdo para el desarrollo de un programa de FP Dual, alternando la formación teórica en el centro con la formación práctica en la empresa durante dos cursos académicos.',
                'Convenio para la implementación de ciclos formativos en modalidad dual, favoreciendo la inserción laboral mediante un modelo de aprendizaje basado en la empresa.'
            ],
            'Colaboración' => [
                'Acuerdo marco para el desarrollo de actividades formativas complementarias: charlas, talleres, visitas y mentorización de proyectos.',
                'Convenio de colaboración para fomentar la transferencia de conocimiento entre el ámbito educativo y empresarial mediante actividades conjuntas.',
                'Marco de cooperación para el desarrollo de acciones formativas complementarias y actualización curricular según las necesidades del mercado laboral.'
            ],
            'Investigación' => [
                'Acuerdo para el desarrollo conjunto de proyectos de investigación aplicada, con participación de estudiantes avanzados y profesorado.',
                'Convenio para la realización de proyectos de I+D+i que permitan la transferencia de conocimiento y el desarrollo de soluciones innovadoras.',
                'Marco de colaboración para investigación aplicada, permitiendo a estudiantes y docentes participar en proyectos reales con aplicación industrial.'
            ]
        ];
        
        return $descripciones[$tipo][array_rand($descripciones[$tipo])];
    }
    
    /**
     * Genera condiciones aleatorias para un convenio
     */
    private function generarCondicionesConvenio()
    {
        $duraciones = ['370 horas', '400 horas', '3 meses', '6 meses', '9 meses', '1 año', '2 años'];
        $ayudas = ['300€ mensuales', '350€ mensuales', '400€ mensuales', '450€ mensuales', '500€ mensuales', 'Sin remuneración'];
        $beneficios = [
            'Formación complementaria en tecnologías específicas',
            'Tutorización personalizada por parte de profesionales de la empresa',
            'Posibilidad de contratación al finalizar el período formativo',
            'Acceso a formación interna de la empresa',
            'Participación en proyectos reales',
            'Plan de carrera para perfiles destacados'
        ];
        
        return 'Duración: ' . $duraciones[array_rand($duraciones)] . '. ' .
               'Ayuda económica: ' . $ayudas[array_rand($ayudas)] . '. ' .
               'Beneficios adicionales: ' . $beneficios[array_rand($beneficios)] . '.';
    }
}
