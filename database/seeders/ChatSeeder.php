<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Chat;
use App\Models\User;
use App\Models\Empresa;
use App\Models\Estudiante;
use App\Models\Solicitud;

class ChatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $solicitudes = Solicitud::all();
        $empresas = Empresa::all();

        // Crear algunos chats de ejemplo
        foreach ($solicitudes as $solicitud) {
            Chat::create([
                'empresa_id' => $solicitud->empresa_id,
                'solicitud_id' => $solicitud->id,
                'created_at' => fake()->dateTimeBetween('-6 months', 'now'),
                'updated_at' => now()
            ]);
        }
    }
}
