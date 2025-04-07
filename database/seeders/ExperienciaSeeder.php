<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Estudiante;
use App\Models\Experiencia;

class ExperienciaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $estudiantes = Estudiante::all();
        $puestos = ['Desarrollador Junior', 'Analista', 'Programador Web', 'Desarrollador Full Stack'];
        $especializaciones = ['PHP', 'JavaScript', 'Python', 'Java', '.NET'];

        foreach ($estudiantes as $estudiante) {
            // Cada estudiante puede tener 0-3 experiencias
            $numExperiencias = rand(0, 3);

            for ($i = 0; $i < $numExperiencias; $i++) {
                $fechaInicio = fake()->dateTimeBetween('-2 years', '-6 months');
                $fechaFin = fake()->dateTimeBetween($fechaInicio, 'now');

                Experiencia::create([
                    'empresa_nombre' => fake()->company,
                    'puesto' => $puestos[array_rand($puestos)],
                    'fecha_inicio' => $fechaInicio,
                    'fecha_fin' => $fechaFin,
                    'especializacion' => $especializaciones[array_rand($especializaciones)],
                    'alumno_id' => $estudiante->id,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        }
    }
}
