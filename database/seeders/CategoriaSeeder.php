<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Categoria;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categorias = [
            'Desarrollo Web',
            'Desarrollo Móvil',
            'Bases de Datos',
            'DevOps',
            'Inteligencia Artificial',
            'Marketing Digital',
            'Administración de Sistemas',
            'Ciberseguridad',
            'Diseño Gráfico',
            'Gestión Administrativa',
            'Comercio',
            'Turismo',
            'Sanidad',
            'Servicios Sociales',
            'Logística'
        ];

        foreach ($categorias as $categoria) {
            Categoria::create(['nombre_categoria' => $categoria]);
        }
    }
}
