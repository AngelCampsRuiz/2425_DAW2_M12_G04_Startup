<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Valoracion;
use App\Models\User;
use App\Models\Empresa;
use App\Models\Estudiante;
use App\Models\Convenio;

class ValoracionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $convenios = Convenio::with(['seguimiento.estudiante', 'seguimiento.empresa'])->get();

        foreach ($convenios as $convenio) {
            // Crear valoración del alumno a la empresa (50% de probabilidad)
            if (rand(0, 1)) {
                Valoracion::create([
                    'puntuacion' => rand(1, 5),
                    'comentario' => fake()->sentence,
                    'fecha_valoracion' => fake()->dateTimeBetween('-6 months', 'now'),
                    'tipo' => 'alumno',
                    'alumno_id' => $convenio->seguimiento->estudiante->id,
                    'empresa_id' => $convenio->seguimiento->empresa->id,
                    'convenio_id' => $convenio->id,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }

            // Crear valoración de la empresa al alumno (50% de probabilidad)
            if (rand(0, 1)) {
                Valoracion::create([
                    'puntuacion' => rand(1, 5),
                    'comentario' => fake()->sentence,
                    'fecha_valoracion' => fake()->dateTimeBetween('-6 months', 'now'),
                    'tipo' => 'empresa',
                    'alumno_id' => $convenio->seguimiento->estudiante->id,
                    'empresa_id' => $convenio->seguimiento->empresa->id,
                    'convenio_id' => $convenio->id,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        }
    }
}
