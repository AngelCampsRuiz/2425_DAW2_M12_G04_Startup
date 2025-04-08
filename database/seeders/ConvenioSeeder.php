<?php

namespace Database\Seeders;

use App\Models\Convenio;
use App\Models\Tutor;
use App\Models\Seguimiento;
use App\Models\Empresa;
use Illuminate\Database\Seeder;

class ConvenioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tutores = Tutor::all();
        $empresas = Empresa::all();
        // Solo obtener seguimientos aceptados
        $seguimientos = Seguimiento::where('estado', 'aceptado')->get();

        foreach ($seguimientos as $seguimiento) {
            // 70% de probabilidad de crear un convenio
            if (rand(1, 100) <= 70) {
                Convenio::create([
                    'documento_pdf' => 'convenio_' . fake()->uuid . '.pdf',
                    'activo' => true,
                    'fecha_aprobacion' => fake()->dateTimeBetween('-6 months', 'now'),
                    'tutor_id' => $tutores->random()->id,
                    'seguimiento_id' => $seguimiento->id,
                    'empresa_id' => $empresas->random()->id,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        }
    }
}
