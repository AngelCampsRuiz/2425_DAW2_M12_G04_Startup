<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Estudiante;
use App\Models\Empresa;
use App\Models\Favorito;

class FavoritoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $estudiantes = Estudiante::all();
        $empresas = Empresa::all();

        foreach ($estudiantes as $estudiante) {
            // Cada estudiante marca como favoritas entre 0 y 5 empresas aleatorias
            $numFavoritos = rand(0, 5);
            $empresasAleatorias = $empresas->random($numFavoritos);

            foreach ($empresasAleatorias as $empresa) {
                // Generar una fecha realista para el favorito
                $fecha = fake()->dateTimeBetween('-6 months', 'now');
                
                Favorito::create([
                    'alumno_id' => $estudiante->id,
                    'empresa_id' => $empresa->id,
                    'created_at' => $fecha,
                    'updated_at' => now()
                ]);
            }
        }
    }
}
