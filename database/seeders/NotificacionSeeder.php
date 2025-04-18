<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Notificacion;
use App\Models\User;
use App\Models\Empresa;
use App\Models\Estudiante;
use App\Models\Tutor;

class NotificacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $empresas = Empresa::all();
        $estudiantes = Estudiante::all();
        $tutores = Tutor::all();

        $tiposNotificacion = [
            'nueva_publicacion' => [
                'título' => 'Nueva publicación de trabajo',
                'mensaje' => 'Se ha publicado una nueva oferta de trabajo que podría interesarte'
            ],
            'mensaje_nuevo' => [
                'título' => 'Nuevo mensaje recibido',
                'mensaje' => 'Has recibido un nuevo mensaje en el chat'
            ],
            'seguimiento_actualizado' => [
                'título' => 'Actualización de seguimiento',
                'mensaje' => 'Tu solicitud de seguimiento ha sido actualizada'
            ],
            'convenio_aprobado' => [
                'título' => 'Convenio aprobado',
                'mensaje' => 'Tu convenio ha sido aprobado por el tutor'
            ],
            'nueva_valoracion' => [
                'título' => 'Nueva valoración recibida',
                'mensaje' => 'Has recibido una nueva valoración'
            ]
        ];

        // Generar notificaciones para estudiantes
        foreach ($estudiantes as $estudiante) {
            $numNotificaciones = rand(1, 5);
            
            for ($i = 0; $i < $numNotificaciones; $i++) {
                $tipo = array_rand($tiposNotificacion);
                $fecha = fake()->dateTimeBetween('-3 months', 'now');
                
                Notificacion::create([
                    'titulo' => $tiposNotificacion[$tipo]['título'],
                    'mensaje' => $tiposNotificacion[$tipo]['mensaje'],
                    'leida' => fake()->boolean(70), // 70% de probabilidad de estar leída
                    'user_id' => $estudiante->user_id,
                    'created_at' => $fecha,
                    'updated_at' => now()
                ]);
            }
        }

        // Generar notificaciones para tutores
        foreach ($tutores as $tutor) {
            $numNotificaciones = rand(1, 3);
            
            for ($i = 0; $i < $numNotificaciones; $i++) {
                $tipo = array_rand($tiposNotificacion);
                $fecha = fake()->dateTimeBetween('-3 months', 'now');
                
                Notificacion::create([
                    'titulo' => $tiposNotificacion[$tipo]['título'],
                    'mensaje' => $tiposNotificacion[$tipo]['mensaje'],
                    'leida' => fake()->boolean(80), // 80% de probabilidad de estar leída
                    'user_id' => $tutor->user_id,
                    'created_at' => $fecha,
                    'updated_at' => now()
                ]);
            }
        }

        // Generar notificaciones para empresas
        foreach ($empresas as $empresa) {
            $numNotificaciones = rand(1, 4);
            
            for ($i = 0; $i < $numNotificaciones; $i++) {
                $tipo = array_rand($tiposNotificacion);
                $fecha = fake()->dateTimeBetween('-3 months', 'now');
                
                Notificacion::create([
                    'titulo' => $tiposNotificacion[$tipo]['título'],
                    'mensaje' => $tiposNotificacion[$tipo]['mensaje'],
                    'leida' => fake()->boolean(75), // 75% de probabilidad de estar leída
                    'user_id' => $empresa->user_id,
                    'created_at' => $fecha,
                    'updated_at' => now()
                ]);
            }
        }
    }
} 