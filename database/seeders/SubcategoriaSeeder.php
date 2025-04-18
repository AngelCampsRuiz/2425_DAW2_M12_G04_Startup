<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Subcategoria;

class SubcategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subcategorias = [
            // Desarrollo Web
            1 => ['Frontend', 'Backend', 'Full Stack', 'Desarrollo Web Responsive', 'Desarrollo Web Progresivo (PWA)'],
            
            // Desarrollo Móvil
            2 => ['Android', 'iOS', 'Cross-platform', 'Desarrollo de Aplicaciones Híbridas', 'Desarrollo de Aplicaciones Nativas'],
            
            // Bases de Datos
            3 => ['MySQL', 'PostgreSQL', 'MongoDB', 'Oracle', 'SQL Server', 'Redis', 'Elasticsearch'],
            
            // DevOps
            4 => ['Docker', 'Kubernetes', 'CI/CD', 'Jenkins', 'GitLab CI', 'Terraform', 'Ansible', 'Prometheus', 'Grafana'],
            
            // Inteligencia Artificial
            5 => ['Machine Learning', 'Deep Learning', 'NLP', 'Computer Vision', 'Reinforcement Learning', 'Data Mining', 'Big Data'],
            
            // Marketing Digital
            6 => ['SEO', 'SEM', 'Redes Sociales', 'Email Marketing', 'Content Marketing', 'Analítica Web', 'Marketing de Afiliados'],
            
            // Administración de Sistemas
            7 => ['Windows Server', 'Linux', 'Virtualización', 'Cloud Computing', 'Redes', 'Seguridad', 'Backup y Recuperación'],
            
            // Ciberseguridad
            8 => ['Seguridad de Redes', 'Seguridad de Aplicaciones', 'Criptografía', 'Forense Digital', 'Pentesting', 'Cumplimiento Normativo'],
            
            // Diseño Gráfico
            9 => ['Diseño UI', 'Diseño UX', 'Diseño de Interfaz', 'Diseño de Experiencia', 'Diseño de Producto', 'Diseño de Marca'],
            
            // Gestión Administrativa
            10 => ['Contabilidad', 'Recursos Humanos', 'Gestión de Proyectos', 'Logística', 'Compras', 'Ventas', 'Atención al Cliente'],
            
            // Comercio
            11 => ['Comercio Electrónico', 'Comercio Minorista', 'Comercio Mayorista', 'Marketing de Productos', 'Gestión de Inventario', 'Logística Comercial'],
            
            // Turismo
            12 => ['Gestión Hotelera', 'Agencias de Viajes', 'Turismo Rural', 'Turismo Cultural', 'Eventos y Congresos', 'Restauración'],
            
            // Sanidad
            13 => ['Enfermería', 'Farmacia', 'Odontología', 'Fisioterapia', 'Nutrición', 'Técnicas de Laboratorio', 'Técnicas de Imagen'],
            
            // Servicios Sociales
            14 => ['Atención a Personas Mayores', 'Atención a Personas con Discapacidad', 'Atención a la Infancia', 'Mediación Social', 'Intervención Social'],
            
            // Logística
            15 => ['Transporte', 'Almacenamiento', 'Distribución', 'Gestión de Flotas', 'Cadena de Suministro', 'Comercio Internacional']
        ];

        foreach ($subcategorias as $categoria_id => $subs) {
            foreach ($subs as $nombre) {
                Subcategoria::create([
                    'nombre_subcategoria' => $nombre,
                    'categoria_id' => $categoria_id
                ]);
            }
        }
    }
}
