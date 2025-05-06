<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Convenio;
use App\Models\Seguimiento;
use App\Models\Empresa;
use App\Models\Estudiante;

class ConvenioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener todos los seguimientos
        $seguimientos = Seguimiento::all();
        $empresas = Empresa::all();

        foreach ($seguimientos as $seguimiento) {
            // 70% de probabilidad de crear un convenio
            if (rand(1, 100) <= 70) {
                // Obtener la empresa y el estudiante
                $empresa = $empresas->find($seguimiento->empresa_id);
                $estudiante = Estudiante::find($seguimiento->estudiante_id);

                if ($empresa && $estudiante && $empresa->user && $estudiante->user) {
                    // Generar un nombre de archivo realista para el convenio
                    $nombreEmpresa = str_replace(' ', '_', $empresa->user->nombre);
                    $nombreEstudiante = str_replace(' ', '_', $estudiante->user->nombre);
                    $fecha = fake()->dateTimeBetween('-6 months', 'now')->format('Y-m-d');

                    Convenio::create([
                        'documento_pdf' => 'convenio_' . $nombreEmpresa . '_' . $nombreEstudiante . '_' . $fecha . '.pdf',
                        'fecha_firma' => $fecha,
                        'estado' => fake()->randomElement(['pendiente', 'firmado', 'rechazado']),
                        'empresa_id' => $seguimiento->empresa_id,
                        'estudiante_id' => $seguimiento->estudiante_id,
                        'seguimiento_id' => $seguimiento->id,
                    ]);
                }
            }
        }
    }
}
