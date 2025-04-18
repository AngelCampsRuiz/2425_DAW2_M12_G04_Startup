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

        // Agrupar estudiantes por centro educativo
        $estudiantesPorCentro = [];
        foreach ($estudiantes as $estudiante) {
            $centro = $estudiante->centro_educativo;
            if (!isset($estudiantesPorCentro[$centro])) {
                $estudiantesPorCentro[$centro] = [];
            }
            $estudiantesPorCentro[$centro][] = $estudiante;
        }

        // Agrupar tutores por centro asignado
        $tutoresPorCentro = [];
        foreach ($tutores as $tutor) {
            $centro = $tutor->centro_asignado;
            if (!isset($tutoresPorCentro[$centro])) {
                $tutoresPorCentro[$centro] = [];
            }
            $tutoresPorCentro[$centro][] = $tutor;
        }

        // Asignar tutores a estudiantes del mismo centro
        foreach ($estudiantesPorCentro as $centro => $estudiantesDelCentro) {
            // Si hay tutores en este centro
            if (isset($tutoresPorCentro[$centro]) && count($tutoresPorCentro[$centro]) > 0) {
                $tutoresDelCentro = $tutoresPorCentro[$centro];
                
                foreach ($estudiantesDelCentro as $estudiante) {
                    // Asignar 1 o 2 tutores aleatorios del mismo centro
                    $numTutores = rand(1, min(2, count($tutoresDelCentro)));
                    $tutoresAsignados = collect($tutoresDelCentro)->random($numTutores);
                    
                    foreach ($tutoresAsignados as $tutor) {
                        DB::table('alumno_tutores')->insert([
                            'alumno_id' => $estudiante->id,
                            'tutor_id' => $tutor->id,
                            'created_at' => now(),
                            'updated_at' => now()
                        ]);
                    }
                }
            } else {
                // Si no hay tutores en este centro, asignar tutores aleatorios
                foreach ($estudiantesDelCentro as $estudiante) {
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
    }
}
