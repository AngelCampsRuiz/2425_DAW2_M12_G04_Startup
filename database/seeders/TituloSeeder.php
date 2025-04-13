<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Tutor;
use App\Models\Titulo;

class TituloSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $titulos = [
            // Grados Superiores
            ['name_titulo' => 'Desarrollo de Aplicaciones Web'],
            ['name_titulo' => 'Desarrollo de Aplicaciones Multiplataforma'],
            ['name_titulo' => 'Administración de Sistemas Informáticos en Red'],
            ['name_titulo' => 'Ciberseguridad en Entornos de las Tecnologías de la Información'],
            ['name_titulo' => 'Inteligencia Artificial y Big Data'],
            ['name_titulo' => 'Diseño y Edición de Publicaciones Impresas y Multimedia'],
            ['name_titulo' => 'Marketing Digital'],
            ['name_titulo' => 'Comercio Internacional'],
            ['name_titulo' => 'Transporte y Logística'],
            ['name_titulo' => 'Gestión de Ventas y Espacios Comerciales'],
            
            // Grados Medios
            ['name_titulo' => 'Sistemas Microinformáticos y Redes'],
            ['name_titulo' => 'Aplicaciones Web'],
            ['name_titulo' => 'Gestión Administrativa'],
            ['name_titulo' => 'Actividades Comerciales'],
            ['name_titulo' => 'Atención a Personas en Situación de Dependencia'],
            ['name_titulo' => 'Cuidados Auxiliares de Enfermería'],
            ['name_titulo' => 'Farmacia y Parafarmacia'],
            ['name_titulo' => 'Gestión de Alojamientos Turísticos'],
            ['name_titulo' => 'Agencias de Viajes y Gestión de Eventos'],
            ['name_titulo' => 'Servicios en Restauración']
        ];

        foreach ($titulos as $titulo) {
            Titulo::create($titulo);
        }
    }
}