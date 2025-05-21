<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\GameScore;
use App\Models\User;

class GameScoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtenemos los estudiantes
        $estudiantes = User::where('role_id', 3)->get();
        
        // Nombres de juegos educativos disponibles en la plataforma
        $juegos = [
            'Coding Challenge',
            'Quiz Tecnológico',
            'Puzzle Lógico',
            'Memory Match',
            'Debug Race'
        ];
        
        // Datos de puntuaciones fijas para estudiantes específicos
        $puntuacionesFijas = [
            // Los mejores jugadores con puntuaciones altas
            [
                'user_id' => 3, // ID de un estudiante
                'game_name' => 'Coding Challenge',
                'score' => 8750,
                'difficulty' => 'hard',
                'time_spent' => 450, // segundos
                'completed' => true
            ],
            [
                'user_id' => 4, // ID de un estudiante
                'game_name' => 'Coding Challenge',
                'score' => 8200,
                'difficulty' => 'hard',
                'time_spent' => 480, // segundos
                'completed' => true
            ],
            [
                'user_id' => 5, // ID de un estudiante
                'game_name' => 'Coding Challenge',
                'score' => 7950,
                'difficulty' => 'hard',
                'time_spent' => 470, // segundos
                'completed' => true
            ],
            
            // Puntuaciones medias
            [
                'user_id' => 6, // ID de un estudiante
                'game_name' => 'Quiz Tecnológico',
                'score' => 6500,
                'difficulty' => 'medium',
                'time_spent' => 300, // segundos
                'completed' => true
            ],
            [
                'user_id' => 7, // ID de un estudiante
                'game_name' => 'Quiz Tecnológico',
                'score' => 6200,
                'difficulty' => 'medium',
                'time_spent' => 320, // segundos
                'completed' => true
            ],
            
            // Puntuaciones para diferentes juegos y dificultades
            [
                'user_id' => 8, // ID de un estudiante
                'game_name' => 'Puzzle Lógico',
                'score' => 4800,
                'difficulty' => 'easy',
                'time_spent' => 180, // segundos
                'completed' => true
            ],
            [
                'user_id' => 9, // ID de un estudiante
                'game_name' => 'Memory Match',
                'score' => 3750,
                'difficulty' => 'easy',
                'time_spent' => 150, // segundos
                'completed' => true
            ],
            [
                'user_id' => 10, // ID de un estudiante
                'game_name' => 'Debug Race',
                'score' => 7200,
                'difficulty' => 'medium',
                'time_spent' => 360, // segundos
                'completed' => true
            ],
            
            // Juegos no completados
            [
                'user_id' => 11, // ID de un estudiante
                'game_name' => 'Coding Challenge',
                'score' => 3200,
                'difficulty' => 'hard',
                'time_spent' => 200, // segundos
                'completed' => false
            ],
            [
                'user_id' => 12, // ID de un estudiante
                'game_name' => 'Debug Race',
                'score' => 2800,
                'difficulty' => 'medium',
                'time_spent' => 180, // segundos
                'completed' => false
            ]
        ];
        
        // Insertamos las puntuaciones fijas
        foreach ($puntuacionesFijas as $puntuacion) {
            GameScore::create([
                'user_id' => $puntuacion['user_id'],
                'game_name' => $puntuacion['game_name'],
                'score' => $puntuacion['score'],
                'difficulty' => $puntuacion['difficulty'],
                'time_spent' => $puntuacion['time_spent'],
                'completed' => $puntuacion['completed'],
                'created_at' => now()->subDays(rand(1, 30)),
                'updated_at' => now()->subDays(rand(0, 1))
            ]);
        }
        
        // Generar algunas puntuaciones adicionales aleatorias para el resto de estudiantes
        // para garantizar que todos tengan alguna puntuación
        foreach ($estudiantes as $estudiante) {
            // Verificar si el estudiante ya tiene puntuaciones
            $tienePuntuacion = false;
            foreach ($puntuacionesFijas as $puntuacion) {
                if ($puntuacion['user_id'] == $estudiante->id) {
                    $tienePuntuacion = true;
                    break;
                }
            }
            
            // Si no tiene puntuación, crear una
            if (!$tienePuntuacion) {
                // Asignamos aleatoriamente un juego
                $juego = $juegos[array_rand($juegos)];
                
                // Definimos la dificultad
                $dificultades = ['easy', 'medium', 'hard'];
                $dificultad = $dificultades[array_rand($dificultades)];
                
                // Calculamos puntuación según dificultad
                $puntuacionBase = match($dificultad) {
                    'easy' => rand(2000, 5000),
                    'medium' => rand(4000, 7000),
                    'hard' => rand(6000, 9000)
                };
                
                // Tiempo invertido según dificultad
                $tiempoBase = match($dificultad) {
                    'easy' => rand(120, 240),
                    'medium' => rand(240, 360),
                    'hard' => rand(360, 500)
                };
                
                // Determinar si completó o no
                $completado = rand(0, 10) > 2; // 80% de probabilidad de completar
                
                // Si no completó, reducir la puntuación
                if (!$completado) {
                    $puntuacionBase = intval($puntuacionBase * (rand(30, 60) / 100));
                    $tiempoBase = intval($tiempoBase * (rand(30, 80) / 100));
                }
                
                GameScore::create([
                    'user_id' => $estudiante->id,
                    'game_name' => $juego,
                    'score' => $puntuacionBase,
                    'difficulty' => $dificultad,
                    'time_spent' => $tiempoBase,
                    'completed' => $completado,
                    'created_at' => now()->subDays(rand(1, 30)),
                    'updated_at' => now()->subDays(rand(0, 1))
                ]);
            }
        }
        
        // Añadir intentos adicionales para los mismos juegos (mejoras de puntuación)
        $usuariosConMejoras = [3, 5, 7, 9, 11];
        
        foreach ($usuariosConMejoras as $userId) {
            // Obtener la puntuación anterior
            $puntuacionAnterior = GameScore::where('user_id', $userId)->first();
            
            if ($puntuacionAnterior) {
                // Crear una mejora con fecha posterior
                GameScore::create([
                    'user_id' => $userId,
                    'game_name' => $puntuacionAnterior->game_name,
                    'score' => intval($puntuacionAnterior->score * (rand(110, 130) / 100)), // Aumento del 10-30%
                    'difficulty' => $puntuacionAnterior->difficulty,
                    'time_spent' => intval($puntuacionAnterior->time_spent * (rand(80, 95) / 100)), // Reducción del 5-20%
                    'completed' => true,
                    'created_at' => now()->subDays(rand(1, 5)),
                    'updated_at' => now()
                ]);
            }
        }
    }
} 