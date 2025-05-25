<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Estudiante;
use App\Models\Empresa;
use App\Models\Favorito;
use Carbon\Carbon;

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
                // Generar una fecha realista para el favorito usando Carbon
                $fecha = Carbon::now()->subMonths(rand(1, 6))->format('Y-m-d H:i:s');
                
                Favorito::create([
                    'alumno_id' => $estudiante->id,
                    'empresa_id' => $empresa->id,
                    'created_at' => $fecha,
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ]);
            }
        }
    }
}
