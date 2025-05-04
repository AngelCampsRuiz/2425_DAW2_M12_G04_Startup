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

        // AGRUPAR ESTUDIANTES POR CENTRO EDUCATIVO
            $estudiantesPorCentro = [];
            foreach ($estudiantes as $estudiante) {
                $centro = $estudiante->centro_educativo;
                if (!isset($estudiantesPorCentro[$centro])) {
                    $estudiantesPorCentro[$centro] = [];
                }
                $estudiantesPorCentro[$centro][] = $estudiante;
            }

        // AGRUPAR TUTORES POR CENTRO ASIGNADO
            $tutoresPorCentro = [];
            foreach ($tutores as $tutor) {
                $centro = $tutor->centro_asignado;
                if (!isset($tutoresPorCentro[$centro])) {
                    $tutoresPorCentro[$centro] = [];
                }
                $tutoresPorCentro[$centro][] = $tutor;
            }

        // ASIGNAR TUTORES A ESTUDIANTES DEL MISMO CENTRO
            foreach ($estudiantesPorCentro as $centro => $estudiantesDelCentro) {
                // SI HAY TUTORES EN ESTE CENTRO
                    if (isset($tutoresPorCentro[$centro]) && count($tutoresPorCentro[$centro]) > 0) {
                        $tutoresDelCentro = $tutoresPorCentro[$centro];
                        
                        foreach ($estudiantesDelCentro as $estudiante) {
                            // ASIGNAR 1 O 2 TUTORES ALEATORIOS DEL MISMO CENTRO
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
                        // SI NO HAY TUTORES EN ESTE CENTRO, ASIGNAR TUTORES ALEATORIOS
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
