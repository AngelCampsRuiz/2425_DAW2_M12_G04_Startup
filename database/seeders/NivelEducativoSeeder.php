<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\NivelEducativo;

class NivelEducativoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $niveles = [
            'Ciclos de Grado Medio',
            'Ciclos de Grado Superior',
            'Universidades',
            'Máster'
        ];

        foreach ($niveles as $nivel) {
            NivelEducativo::create(['nombre_nivel' => $nivel]);
        }
    }
} 