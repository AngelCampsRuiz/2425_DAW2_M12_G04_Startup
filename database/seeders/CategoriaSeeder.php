<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Categoria;
use App\Models\NivelEducativo;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get nivel educativo IDs
        $gradoMedio = NivelEducativo::where('nombre_nivel', 'Ciclos de Grado Medio')->first()->id;
        $gradoSuperior = NivelEducativo::where('nombre_nivel', 'Ciclos de Grado Superior')->first()->id;
        $universidad = NivelEducativo::where('nombre_nivel', 'Universidades')->first()->id;
        $master = NivelEducativo::where('nombre_nivel', 'Máster')->first()->id;

        $categorias = [
            // Ciclos de Grado Medio
            ['nombre_categoria' => 'Desarrollo Web', 'nivel_educativo_id' => $gradoMedio],
            ['nombre_categoria' => 'Administración de Sistemas', 'nivel_educativo_id' => $gradoMedio],
            ['nombre_categoria' => 'Comercio', 'nivel_educativo_id' => $gradoMedio],
            ['nombre_categoria' => 'Gestión Administrativa', 'nivel_educativo_id' => $gradoMedio],
            
            // Ciclos de Grado Superior
            ['nombre_categoria' => 'Desarrollo Móvil', 'nivel_educativo_id' => $gradoSuperior],
            ['nombre_categoria' => 'Bases de Datos', 'nivel_educativo_id' => $gradoSuperior],
            ['nombre_categoria' => 'DevOps', 'nivel_educativo_id' => $gradoSuperior],
            ['nombre_categoria' => 'Diseño Gráfico', 'nivel_educativo_id' => $gradoSuperior],
            ['nombre_categoria' => 'Turismo', 'nivel_educativo_id' => $gradoSuperior],
            
            // Universidades
            ['nombre_categoria' => 'Inteligencia Artificial', 'nivel_educativo_id' => $universidad],
            ['nombre_categoria' => 'Ciberseguridad', 'nivel_educativo_id' => $universidad],
            ['nombre_categoria' => 'Sanidad', 'nivel_educativo_id' => $universidad],
            ['nombre_categoria' => 'Servicios Sociales', 'nivel_educativo_id' => $universidad],
            
            // Máster
            ['nombre_categoria' => 'Marketing Digital', 'nivel_educativo_id' => $master],
            ['nombre_categoria' => 'Logística', 'nivel_educativo_id' => $master]
        ];

        foreach ($categorias as $categoria) {
            Categoria::create($categoria);
        }
    }
}
