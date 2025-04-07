<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Chat;
use App\Models\Mensaje;

class MensajeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $chats = Chat::all();

        foreach ($chats as $chat) {
            // Obtener los IDs de los participantes del chat
            $participantes = [
                $chat->alumno_id,    // ID del estudiante
                $chat->tutor_id,     // ID del tutor
                $chat->empresa_id    // ID de la empresa
            ];

            // Generar entre 5 y 15 mensajes por chat
            $numMensajes = rand(5, 15);

            for ($i = 0; $i < $numMensajes; $i++) {
                // Seleccionar aleatoriamente quién envía el mensaje
                $sender_id = $participantes[array_rand($participantes)];

                Mensaje::create([
                    'contenido' => fake()->sentence,
                    'chat_id' => $chat->id,
                    'user_id' => $sender_id,
                    'fecha_envio' => fake()->dateTimeBetween('-6 months', 'now'),
                    'created_at' => fake()->dateTimeBetween('-6 months', 'now'),
                    'updated_at' => now()
                ]);
            }
        }
    }
}
