<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Chat;
use App\Models\User;
use App\Models\Empresa;
use App\Models\Estudiante;
use App\Models\Tutor;

class ChatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $estudiantes = Estudiante::all();
        $tutores = Tutor::all();
        $empresas = Empresa::all();

        // Crear algunos chats de ejemplo
        foreach ($estudiantes as $estudiante) {
            // Cada estudiante tendrá al menos un chat
            Chat::create([
                'alumno_id' => $estudiante->id,
                'tutor_id' => $tutores->random()->id,
                'empresa_id' => $empresas->random()->id,
                'created_at' => fake()->dateTimeBetween('-6 months', 'now'),
                'updated_at' => now()
            ]);

            // 50% de probabilidad de tener un chat adicional
            if (rand(0, 1)) {
                Chat::create([
                    'alumno_id' => $estudiante->id,
                    'tutor_id' => $tutores->random()->id,
                    'empresa_id' => $empresas->random()->id,
                    'created_at' => fake()->dateTimeBetween('-6 months', 'now'),
                    'updated_at' => now()
                ]);
            }
        }
    }
}
