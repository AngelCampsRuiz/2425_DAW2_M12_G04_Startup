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
            1 => ['Frontend', 'Backend', 'Full Stack'],
            2 => ['Android', 'iOS', 'Cross-platform'],
            3 => ['MySQL', 'PostgreSQL', 'MongoDB'],
            4 => ['Docker', 'Kubernetes', 'CI/CD'],
            5 => ['Machine Learning', 'Deep Learning', 'NLP']
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
