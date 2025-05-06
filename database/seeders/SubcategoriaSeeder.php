<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Subcategoria;
use App\Models\Categoria;
use App\Models\NivelEducativo;

class SubcategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // CICLOS DE GRADO MEDIO
        $this->crearSubcategoriasPorNombre('Gestión Administrativa', ['Contabilidad', 'Gestión Documental', 'Ofimática', 'Atención al Cliente', 'Recursos Humanos', 'Facturación']);
        $this->crearSubcategoriasPorNombre('Sistemas Microinformáticos y Redes', ['Redes Locales', 'Montaje y Mantenimiento de Equipos', 'Sistemas Operativos', 'Seguridad Informática', 'Aplicaciones Web', 'Servicios en Red']);
        $this->crearSubcategoriasPorNombre('Cocina y Gastronomía', ['Técnicas Culinarias', 'Preelaboración de Alimentos', 'Postres', 'Seguridad Alimentaria', 'Ofertas Gastronómicas', 'Vinos y Bebidas']);
        $this->crearSubcategoriasPorNombre('Farmacia y Parafarmacia', ['Dispensación de Productos', 'Operaciones Básicas de Laboratorio', 'Formulación Magistral', 'Primeros Auxilios', 'Promoción de la Salud', 'Homeopatía']);
        $this->crearSubcategoriasPorNombre('Actividades Comerciales', ['Marketing Comercial', 'Gestión de Compras', 'Dinamización de Punto de Venta', 'Técnicas de Almacén', 'Venta Técnica', 'Comercio Electrónico']);
        $this->crearSubcategoriasPorNombre('Electromecánica de Vehículos Automóviles', ['Motores', 'Sistemas Eléctricos', 'Sistemas de Transmisión', 'Sistemas de Frenos', 'Sistemas de Dirección', 'Sistemas de Carga y Arranque']);
        $this->crearSubcategoriasPorNombre('Instalaciones Eléctricas y Automáticas', ['Automatismos Industriales', 'Instalaciones de Interior', 'Instalaciones Solares', 'Máquinas Eléctricas', 'Electrotecnia', 'Electrónica']);
        $this->crearSubcategoriasPorNombre('Cuidados Auxiliares de Enfermería', ['Técnicas Básicas', 'Higiene', 'Alimentación y Nutrición', 'Primeros Auxilios', 'Apoyo Psicológico', 'Técnicas de Movilización']);
        $this->crearSubcategoriasPorNombre('Peluquería y Cosmética Capilar', ['Técnicas de Corte', 'Coloración', 'Peinados y Recogidos', 'Tratamientos Capilares', 'Imagen Corporal', 'Estética de Manos y Pies']);
        $this->crearSubcategoriasPorNombre('Atención a Personas en Situación de Dependencia', ['Atención Sanitaria', 'Apoyo Domiciliario', 'Atención Higiénica', 'Teleasistencia', 'Apoyo Psicosocial', 'Primeros Auxilios']);
        $this->crearSubcategoriasPorNombre('Guía en el Medio Natural y de Tiempo Libre', ['Senderismo', 'Técnicas de Orientación', 'Actividades Acuáticas', 'Ocio y Tiempo Libre', 'Primeros Auxilios', 'Medio Natural']);
        $this->crearSubcategoriasPorNombre('Carrocería', ['Reparación Estructural', 'Embellecimiento de Superficies', 'Preparación de Superficies', 'Elementos Fijos', 'Elementos Amovibles', 'Tratamientos Anticorrosión']);
        $this->crearSubcategoriasPorNombre('Instalaciones de Telecomunicaciones', ['Instalaciones de Telefonía', 'Instalaciones de Radiocomunicaciones', 'Sistemas de Seguridad', 'Redes de Datos', 'Sonido e Imagen', 'Electrónica Aplicada']);
        $this->crearSubcategoriasPorNombre('Emergencias Sanitarias', ['Evacuación y Traslado', 'Atención Sanitaria', 'Logística Sanitaria', 'Anatomofisiología', 'Apoyo Psicológico', 'Planes de Emergencia']);
        $this->crearSubcategoriasPorNombre('Soldadura y Calderería', ['Interpretación Gráfica', 'Soldadura en Atmósfera Natural', 'Soldadura en Atmósfera Protegida', 'Mecanizado', 'Trazado y Conformado', 'Montaje']);

        // CICLOS DE GRADO SUPERIOR
        $this->crearSubcategoriasPorNombre('Administración y Finanzas', ['Contabilidad Avanzada', 'Fiscalidad', 'Gestión Financiera', 'Recursos Humanos', 'Simulación Empresarial', 'Auditoría']);
        $this->crearSubcategoriasPorNombre('Desarrollo de Aplicaciones Web', ['Programación', 'Bases de Datos', 'Lenguajes de Marcas', 'JavaScript y Frontend', 'Despliegue de Aplicaciones', 'Frameworks Web']);
        $this->crearSubcategoriasPorNombre('Desarrollo de Aplicaciones Multiplataforma', ['Java', 'C#', 'Desarrollo de Interfaces', 'Acceso a Datos', 'Programación Multimedia', 'Desarrollo de Juegos']);
        $this->crearSubcategoriasPorNombre('Administración de Sistemas Informáticos en Red', ['Redes Corporativas', 'Servidores', 'Gestión de Bases de Datos', 'Seguridad y Alta Disponibilidad', 'Virtualización', 'Cloud Computing']);
        $this->crearSubcategoriasPorNombre('Marketing y Publicidad', ['Investigación Comercial', 'Medios y Soportes', 'Políticas de Marketing', 'Marketing Digital', 'Relaciones Públicas', 'Lanzamiento de Productos']);
        $this->crearSubcategoriasPorNombre('Automoción', ['Sistemas Eléctricos', 'Motores Térmicos', 'Elementos Amovibles', 'Tratamiento y Recubrimiento', 'Gestión y Logística', 'Estructuras del Vehículo']);
        $this->crearSubcategoriasPorNombre('Educación Infantil', ['Didáctica', 'Desarrollo Cognitivo', 'Autonomía Personal', 'Expresión y Comunicación', 'Juego Infantil', 'Intervención con Familias']);
        $this->crearSubcategoriasPorNombre('Integración Social', ['Mediación Comunitaria', 'Inserción Sociolaboral', 'Atención a Unidades de Convivencia', 'Sistemas Aumentativos', 'Apoyo a la Intervención', 'Promoción de la Autonomía']);
        $this->crearSubcategoriasPorNombre('Comercio Internacional', ['Marketing Internacional', 'Logística Internacional', 'Negociación Internacional', 'Financiación Internacional', 'Transporte Internacional', 'Medios de Pago']);
        $this->crearSubcategoriasPorNombre('Automatización y Robótica Industrial', ['Sistemas Eléctricos', 'Robótica Industrial', 'Sistemas Secuenciales', 'Comunicaciones Industriales', 'Integración de Sistemas', 'Sistemas de Medida']);
        $this->crearSubcategoriasPorNombre('Gestión de Ventas y Espacios Comerciales', ['Escaparatismo', 'Gestión de Productos', 'Organización de Equipos', 'Políticas de Marketing', 'Investigación Comercial', 'Logística de Almacenamiento']);
        $this->crearSubcategoriasPorNombre('Higiene Bucodental', ['Recepción y Logística', 'Exploración Bucodental', 'Intervención Bucodental', 'Epidemiología', 'Educación para la Salud', 'Fisiopatología']);
        $this->crearSubcategoriasPorNombre('Transporte y Logística', ['Gestión Administrativa', 'Gestión Económica', 'Comercialización del Transporte', 'Logística de Almacenamiento', 'Organización del Transporte', 'Comercio Internacional']);
        $this->crearSubcategoriasPorNombre('Animaciones 3D, Juegos y Entornos Interactivos', ['Modelado 3D', 'Animación', 'Desarrollo de Entornos', 'Realización Multimedia', 'Diseño Interactivo', 'Motor de Videojuegos']);
        $this->crearSubcategoriasPorNombre('Laboratorio Clínico y Biomédico', ['Análisis Bioquímico', 'Microbiología Clínica', 'Técnicas Analíticas', 'Biología Molecular', 'Fisiopatología', 'Gestión de Calidad']);

        // UNIVERSIDAD
        $this->crearSubcategoriasPorNombre('Administración y Dirección de Empresas', ['Contabilidad', 'Finanzas', 'Marketing', 'Recursos Humanos', 'Estrategia Empresarial', 'Economía', 'Derecho Mercantil']);
        $this->crearSubcategoriasPorNombre('Ingeniería Informática', ['Programación', 'Algoritmos', 'Bases de Datos', 'Redes', 'Inteligencia Artificial', 'Seguridad Informática', 'Ingeniería del Software']);
        $this->crearSubcategoriasPorNombre('Medicina', ['Anatomía', 'Fisiología', 'Patología', 'Farmacología', 'Cirugía', 'Pediatría', 'Psiquiatría', 'Medicina Interna']);
        $this->crearSubcategoriasPorNombre('Derecho', ['Derecho Civil', 'Derecho Penal', 'Derecho Administrativo', 'Derecho Internacional', 'Derecho Constitucional', 'Derecho Laboral']);
        $this->crearSubcategoriasPorNombre('Psicología', ['Psicología Clínica', 'Psicología Social', 'Neuropsicología', 'Psicología Educativa', 'Psicología del Desarrollo', 'Psicopatología']);
        $this->crearSubcategoriasPorNombre('Ciencia de Datos', ['Machine Learning', 'Big Data', 'Estadística', 'Visualización de Datos', 'Minería de Datos', 'Procesamiento de Lenguaje Natural', 'Data Engineering']);
        $this->crearSubcategoriasPorNombre('Arquitectura', ['Proyectos Arquitectónicos', 'Urbanismo', 'Historia de la Arquitectura', 'Construcción', 'Estructuras', 'Instalaciones', 'Sostenibilidad']);
        $this->crearSubcategoriasPorNombre('Biología', ['Genética', 'Biología Celular', 'Ecología', 'Biotecnología', 'Microbiología', 'Botánica', 'Zoología', 'Bioquímica']);
        $this->crearSubcategoriasPorNombre('Historia', ['Historia Antigua', 'Historia Medieval', 'Historia Moderna', 'Historia Contemporánea', 'Arqueología', 'Historia del Arte', 'Patrimonio']);
        $this->crearSubcategoriasPorNombre('Periodismo', ['Periodismo Digital', 'Reportaje', 'Periodismo de Investigación', 'Redacción', 'Comunicación Audiovisual', 'Ética Periodística', 'Nuevos Medios']);
        $this->crearSubcategoriasPorNombre('Economía', ['Microeconomía', 'Macroeconomía', 'Econometría', 'Economía Internacional', 'Política Monetaria', 'Desarrollo Económico', 'Hacienda Pública']);
        $this->crearSubcategoriasPorNombre('Enfermería', ['Anatomía', 'Fisiología', 'Farmacología', 'Cuidados Básicos', 'Enfermería Clínica', 'Salud Pública', 'Geriatría']);
        $this->crearSubcategoriasPorNombre('Química', ['Química Orgánica', 'Química Inorgánica', 'Química Analítica', 'Química Física', 'Bioquímica', 'Química Industrial', 'Materiales']);
        $this->crearSubcategoriasPorNombre('Física', ['Mecánica', 'Electromagnetismo', 'Termodinámica', 'Física Cuántica', 'Física Nuclear', 'Óptica', 'Astronomía']);
        $this->crearSubcategoriasPorNombre('Matemáticas', ['Álgebra', 'Análisis Matemático', 'Geometría', 'Estadística', 'Ecuaciones Diferenciales', 'Topología', 'Matemática Aplicada']);
        $this->crearSubcategoriasPorNombre('Educación Primaria', ['Didáctica', 'Psicología del Desarrollo', 'Sociología de la Educación', 'Necesidades Educativas', 'Enseñanza de Matemáticas', 'Enseñanza de Lengua']);
        $this->crearSubcategoriasPorNombre('Filosofía', ['Ética', 'Metafísica', 'Epistemología', 'Lógica', 'Historia de la Filosofía', 'Filosofía Política', 'Estética']);
        $this->crearSubcategoriasPorNombre('Fisioterapia', ['Anatomía', 'Fisiología', 'Valoración en Fisioterapia', 'Cinesiterapia', 'Terapia Manual', 'Fisioterapia Deportiva', 'Neurorehabilitación']);
        $this->crearSubcategoriasPorNombre('Ingeniería Civil', ['Estructuras', 'Hidráulica', 'Transportes', 'Geotecnia', 'Construcción', 'Urbanismo', 'Materiales']);
        $this->crearSubcategoriasPorNombre('Nutrición Humana y Dietética', ['Nutrición Básica', 'Dietoterapia', 'Alimentación Colectiva', 'Nutrición Deportiva', 'Bromatología', 'Seguridad Alimentaria', 'Nutrición Comunitaria']);

        // MÁSTER
        $this->crearSubcategoriasPorNombre('Marketing Digital', ['SEO/SEM', 'Redes Sociales', 'Analytics', 'Estrategia Digital', 'E-commerce', 'Content Marketing', 'UX/UI', 'Inbound Marketing']);
        $this->crearSubcategoriasPorNombre('Inteligencia Artificial y Big Data', ['Machine Learning Avanzado', 'Deep Learning', 'Procesamiento de Lenguaje Natural', 'Visión por Computador', 'Ética en IA', 'Ingeniería de Datos', 'Sistemas de Recomendación']);
        $this->crearSubcategoriasPorNombre('Dirección de Empresas (MBA)', ['Liderazgo', 'Estrategia', 'Finanzas Corporativas', 'Operaciones', 'Marketing Estratégico', 'Innovación y Emprendimiento', 'Gestión de Crisis']);
        $this->crearSubcategoriasPorNombre('Ciberseguridad', ['Gestión de Seguridad', 'Seguridad Ofensiva', 'Seguridad en Cloud', 'Análisis de Malware', 'Cumplimiento Normativo', 'Protección de Datos', 'Criptografía']);
        $this->crearSubcategoriasPorNombre('Recursos Humanos', ['Gestión del Talento', 'Desarrollo Organizacional', 'Relaciones Laborales', 'Compensación y Beneficios', 'Selección de Personal', 'Formación y Desarrollo']);
        $this->crearSubcategoriasPorNombre('Desarrollo Web', ['Frontend Avanzado', 'Backend Avanzado', 'DevOps', 'Arquitecturas Web', 'Rendimiento Web', 'Testing', 'Progressive Web Apps']);
        $this->crearSubcategoriasPorNombre('Finanzas', ['Gestión de Carteras', 'Valoración de Empresas', 'Mercados Financieros', 'Análisis de Inversiones', 'Gestión de Riesgos', 'Fintech', 'Banca']);
        $this->crearSubcategoriasPorNombre('Biotecnología', ['Genómica', 'Proteómica', 'Bioinformática', 'Ingeniería Genética', 'Bioética', 'Biotecnología Industrial', 'Biotecnología Médica']);
        $this->crearSubcategoriasPorNombre('Gestión de Proyectos', ['Metodologías Ágiles', 'PMP', 'Análisis de Riesgos', 'Negociación', 'Gestión de Equipos', 'Gestión del Tiempo', 'Liderazgo']);
        $this->crearSubcategoriasPorNombre('Energías Renovables', ['Energía Solar', 'Energía Eólica', 'Biomasa', 'Eficiencia Energética', 'Smart Grids', 'Almacenamiento de Energía', 'Hidrógeno']);
        $this->crearSubcategoriasPorNombre('Psicología Clínica', ['Evaluación Psicológica', 'Terapia Cognitivo-Conductual', 'Psicopatología Avanzada', 'Neuropsicología Clínica', 'Intervención en Crisis', 'Tratamiento de Adicciones']);
        $this->crearSubcategoriasPorNombre('Transformación Digital', ['Estrategia Digital', 'Cultura Digital', 'Nuevos Modelos de Negocio', 'Tecnologías Emergentes', 'Gestión del Cambio', 'Innovación Digital']);
        $this->crearSubcategoriasPorNombre('Abogacía', ['Práctica Procesal Civil', 'Práctica Procesal Penal', 'Asesoramiento Jurídico', 'Deontología Profesional', 'Fiscalidad', 'Derecho de Sociedades']);
        $this->crearSubcategoriasPorNombre('Comercio Internacional', ['Negociación Internacional', 'Marketing Internacional', 'Logística Global', 'Aduanas y Aranceles', 'Contratación Internacional', 'Geopolítica Comercial']);
        $this->crearSubcategoriasPorNombre('Logística', ['Gestión de la Cadena de Suministro', 'Transporte Internacional', 'Almacenamiento Avanzado', 'Logística Inversa', 'Distribución Urbana', 'Tecnología en Logística']);

        // Para las categorías restantes, asignamos subcategorías específicas para cada nivel educativo
        $this->crearSubcategoriasRestantes();
    }

    /**
     * Crea subcategorías para una categoría específica por nombre
     */
    private function crearSubcategoriasPorNombre($nombreCategoria, $subcategorias)
    {
        $categoria = Categoria::where('nombre_categoria', $nombreCategoria)->first();
        
        if ($categoria) {
            foreach ($subcategorias as $subcategoria) {
                Subcategoria::create([
                    'nombre_subcategoria' => $subcategoria,
                    'categoria_id' => $categoria->id
                ]);
            }
        }
    }

    /**
     * Crea subcategorías específicas para las categorías restantes según su nivel educativo
     */
    private function crearSubcategoriasRestantes()
    {
        // Obtenemos las categorías que ya tienen subcategorías específicas
        $categoriasConSubcategorias = Subcategoria::select('categoria_id')->distinct()->pluck('categoria_id')->toArray();
        
        // Subcategorías predeterminadas por nivel educativo
        $subcategoriasPorNivel = [
            'Ciclos de Grado Medio' => [
                'Fundamentos Básicos', 'Aplicaciones Prácticas', 'Tecnología Específica', 
                'Normativa y Regulación', 'Prácticas en Empresa', 'Proyecto Final'
            ],
            'Ciclos de Grado Superior' => [
                'Teoría Avanzada', 'Aplicaciones Profesionales', 'Gestión y Planificación', 
                'Técnicas Especializadas', 'Prácticas Profesionales', 'Proyecto Final'
            ],
            'Universidades' => [
                'Fundamentos Teóricos', 'Metodología', 'Especialización', 
                'Investigación', 'Prácticas Aplicadas', 'Innovación', 'Trabajo Fin de Grado'
            ],
            'Máster' => [
                'Especialización Avanzada', 'Metodologías de Investigación', 'Innovación', 
                'Casos Prácticos Profesionales', 'Gestión Especializada', 'Trabajo Fin de Máster'
            ]
        ];

        // Obtenemos todos los niveles educativos
        $niveles = NivelEducativo::all();
        
        foreach ($niveles as $nivel) {
            // Obtenemos todas las categorías de este nivel que aún no tienen subcategorías
            $categorias = Categoria::where('nivel_educativo_id', $nivel->id)
                                   ->whereNotIn('id', $categoriasConSubcategorias)
                                   ->get();
            
            foreach ($categorias as $categoria) {
                if (isset($subcategoriasPorNivel[$nivel->nombre_nivel])) {
                    // Creamos nombres más específicos basados en la categoría
                    $subcategoriasEspecificas = [];
                    
                    foreach ($subcategoriasPorNivel[$nivel->nombre_nivel] as $baseSubcategoria) {
                        // Adaptar la subcategoría según el contexto de la categoría
                        $subcategoria = $baseSubcategoria;
                        
                        // Si es una categoría técnica, añadimos subcategorías técnicas
                        if (strpos($categoria->nombre_categoria, 'Técnic') !== false || 
                            strpos($categoria->nombre_categoria, 'Informátic') !== false ||
                            strpos($categoria->nombre_categoria, 'Electrónic') !== false) {
                            $subcategoria = str_replace('Teóricos', 'Técnicos', $subcategoria);
                            $subcategoria = str_replace('Metodología', 'Procedimientos Técnicos', $subcategoria);
                        }
                        
                        // Si es una categoría de salud, adaptamos las subcategorías
                        if (strpos($categoria->nombre_categoria, 'Salud') !== false || 
                            strpos($categoria->nombre_categoria, 'Sanitari') !== false ||
                            strpos($categoria->nombre_categoria, 'Clínic') !== false) {
                            $subcategoria = str_replace('Aplicaciones', 'Procedimientos Clínicos', $subcategoria);
                            $subcategoria = str_replace('Tecnología', 'Asistencia Sanitaria', $subcategoria);
                        }
                        
                        // Si es una categoría artística
                        if (strpos($categoria->nombre_categoria, 'Art') !== false || 
                            strpos($categoria->nombre_categoria, 'Diseñ') !== false ||
                            strpos($categoria->nombre_categoria, 'Moda') !== false) {
                            $subcategoria = str_replace('Aplicaciones', 'Expresión Creativa', $subcategoria);
                            $subcategoria = str_replace('Gestión', 'Proceso Creativo', $subcategoria);
                        }
                        
                        $subcategoriasEspecificas[] = $subcategoria;
                    }
                    
                    // Añadimos subcategorías específicas para esta categoría
                    foreach ($subcategoriasEspecificas as $subcategoria) {
                Subcategoria::create([
                            'nombre_subcategoria' => $subcategoria,
                            'categoria_id' => $categoria->id
                ]);
                    }
                }
            }
        }
    }
}
