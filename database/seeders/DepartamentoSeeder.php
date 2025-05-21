<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Departamento;
use App\Models\Institucion;

class DepartamentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Primero debemos verificar que haya instituciones
        $instituciones = Institucion::all();
        
        // Si no hay instituciones, no podemos crear departamentos
        if ($instituciones->isEmpty()) {
            // Creamos instituciones temporales si no existen
            $institucion1 = Institucion::create([
                'user_id' => 1, // Admin
                'nombre' => 'IES Madrid Centro',
                'cif' => 'A12345678',
                'direccion' => 'Calle Principal 123',
                'codigo_postal' => '28001',
                'ciudad' => 'Madrid',
                'provincia' => 'Madrid',
                'telefono' => '912345678',
                'email' => 'info@iesmadridentro.edu.es',
                'web' => 'https://www.iesmadridentro.edu.es',
                'logo' => 'logo_centro.png'
            ]);
            
            $institucion2 = Institucion::create([
                'user_id' => 2, // Otro usuario
                'nombre' => 'IES Barcelona Tech',
                'cif' => 'B87654321',
                'direccion' => 'Avenida Diagonal 456',
                'codigo_postal' => '08001',
                'ciudad' => 'Barcelona',
                'provincia' => 'Barcelona',
                'telefono' => '932345678',
                'email' => 'info@iesbarcelonatech.edu.es',
                'web' => 'https://www.iesbarcelonatech.edu.es',
                'logo' => 'logo_centro2.png'
            ]);
            
            $instituciones = [$institucion1, $institucion2];
        }
        
        // Departamentos a crear
        $departamentos = [
            [
                'nombre' => 'Informática y Comunicaciones',
                'codigo' => 'INF',
                'descripcion' => 'Departamento dedicado a la enseñanza de tecnologías de la información, programación y redes.'
            ],
            [
                'nombre' => 'Administración y Finanzas',
                'codigo' => 'ADM',
                'descripcion' => 'Departamento especializado en contabilidad, gestión empresarial y finanzas.'
            ],
            [
                'nombre' => 'Marketing y Comunicación',
                'codigo' => 'MKT',
                'descripcion' => 'Departamento enfocado en marketing digital, publicidad y relaciones públicas.'
            ],
            [
                'nombre' => 'Diseño y Artes Gráficas',
                'codigo' => 'DIS',
                'descripcion' => 'Departamento dedicado al diseño gráfico, web y audiovisual.'
            ],
            [
                'nombre' => 'Electrónica y Automatización',
                'codigo' => 'ELE',
                'descripcion' => 'Departamento especializado en sistemas electrónicos, robótica y automatización industrial.'
            ],
            [
                'nombre' => 'Comercio Internacional',
                'codigo' => 'COM',
                'descripcion' => 'Departamento enfocado en el comercio exterior, logística y distribución.'
            ],
            [
                'nombre' => 'Hostelería y Turismo',
                'codigo' => 'HOS',
                'descripcion' => 'Departamento dedicado a la formación en gestión turística y servicios de restauración.'
            ],
            [
                'nombre' => 'Sanidad',
                'codigo' => 'SAN',
                'descripcion' => 'Departamento especializado en formación sanitaria y asistencial.'
            ],
            [
                'nombre' => 'Servicios Socioculturales',
                'codigo' => 'SOC',
                'descripcion' => 'Departamento enfocado en integración social, educación infantil y atención a la dependencia.'
            ],
            [
                'nombre' => 'Imagen y Sonido',
                'codigo' => 'IMG',
                'descripcion' => 'Departamento dedicado a la producción audiovisual, sonido e iluminación.'
            ]
        ];

        // Distribuimos los departamentos entre las instituciones disponibles
        foreach ($departamentos as $index => $departamento) {
            // Asignamos cada departamento a una institución de forma cíclica
            $institucionId = $instituciones[$index % count($instituciones)]->id;
            
            Departamento::create([
                'institucion_id' => $institucionId,
                'nombre' => $departamento['nombre'],
                'codigo' => $departamento['codigo'],
                'descripcion' => $departamento['descripcion'],
                'activo' => true
            ]);
        }
    }
} 