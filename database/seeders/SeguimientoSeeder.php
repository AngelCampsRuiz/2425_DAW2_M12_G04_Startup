<?php

namespace Database\Seeders;

use App\Models\Seguimiento;
use App\Models\Estudiante;
use App\Models\Empresa;
use Illuminate\Database\Seeder;

class SeguimientoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $estudiantes = Estudiante::all();
        $empresas = Empresa::all();

        foreach ($estudiantes as $estudiante) {
            // Cada estudiante tendrá entre 1 y 3 seguimientos
            $numSeguimientos = rand(1, 3);
            $empresasAleatorias = $empresas->random($numSeguimientos);

            foreach ($empresasAleatorias as $empresa) {
                Seguimiento::create([
                    'estado' => 'aceptado', // Para que puedan crearse convenios
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
