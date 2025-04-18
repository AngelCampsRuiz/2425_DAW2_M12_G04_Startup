<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Seguimiento;
use App\Models\Estudiante;
use App\Models\Empresa;

class SeguimientoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $estudiantes = Estudiante::all();
        $empresas = Empresa::all();
        $estados = ['pendiente', 'aceptado', 'rechazado'];

        foreach ($estudiantes as $estudiante) {
            // Cada estudiante tendrá entre 1 y 3 seguimientos
            $numSeguimientos = rand(1, 3);
            $empresasAleatorias = $empresas->random($numSeguimientos);

            foreach ($empresasAleatorias as $empresa) {
                // Asignar un estado aleatorio, con mayor probabilidad de "aceptado"
                $probabilidad = rand(1, 100);
                if ($probabilidad <= 60) {
                    $estado = 'aceptado';
                } elseif ($probabilidad <= 80) {
                    $estado = 'pendiente';
                } else {
                    $estado = 'rechazado';
                }

                Seguimiento::create([
                    'estado' => $estado,
                    'fecha_solicitud' => fake()->dateTimeBetween('-6 months', 'now'),
                    'empresa_id' => $empresa->id,
                    'alumno_id' => $estudiante->id,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        }
    }
}
