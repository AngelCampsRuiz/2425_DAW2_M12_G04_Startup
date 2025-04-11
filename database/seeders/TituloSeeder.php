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
            ['name_titulo' => 'Ingeniería Informática'],
            ['name_titulo' => 'Ingeniería de Telecomunicaciones'],
            ['name_titulo' => 'Ingeniería Industrial'],
            ['name_titulo' => 'Grado Superior de Desarrollo de Aplicaciones Web'],
            ['name_titulo' => 'Grado Superior de Administracion de Sistemas Informaticos'],
            ['name_titulo' => 'Grado Medio de Gestion administrativa']
        ];

        foreach ($titulos as $titulo) {
            Titulo::create($titulo);
        }
    }
}