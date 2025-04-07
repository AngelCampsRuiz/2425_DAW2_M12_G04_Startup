<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Estudiante;
use App\Models\Tutor;
use Illuminate\Support\Facades\DB;
class AlumnoTutorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $estudiantes = Estudiante::all();
        $tutores = Tutor::all();

        // Asignar a cada estudiante 1 o 2 tutores aleatorios
        foreach ($estudiantes as $estudiante) {
            $numTutores = rand(1, 2);
            $tutoresAsignados = $tutores->random($numTutores);

            foreach ($tutoresAsignados as $tutor) {
                DB::table('alumno_tutores')->insert([
                    'alumno_id' => $estudiante->id,
                    'tutor_id' => $tutor->id,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        }
    }
}
