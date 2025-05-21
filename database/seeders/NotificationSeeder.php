<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtenemos todos los usuarios
        $users = User::all();
        
        // Lista de tipos de notificaciones
        $tiposNotificacion = [
            'App\\Notifications\\SolicitudAceptada',
            'App\\Notifications\\ValoracionRecibida',
            'App\\Notifications\\MensajeRecibido',
            'App\\Notifications\\RecordatorioEntrevista',
            'App\\Notifications\\NuevaOferta',
            'App\\Notifications\\ConvenioFinalizado',
            'App\\Notifications\\RecordatorioEvaluacion',
            'App\\Notifications\\NuevaEmpresaInteresada',
            'App\\Notifications\\AlumnoContratado',
            'App\\Notifications\\SeguimientoPendiente',
        ];
        
        // Crear notificaciones para un subconjunto de usuarios
        $usuariosSeleccionados = $users->random(min(20, count($users)));
        
        foreach ($usuariosSeleccionados as $user) {
            // Número de notificaciones por usuario (entre 1 y 5)
            $numNotificaciones = rand(1, 5);
            
            for ($i = 0; $i < $numNotificaciones; $i++) {
                // Seleccionar un tipo de notificación aleatorio
                $tipoNotificacion = $tiposNotificacion[array_rand($tiposNotificacion)];
                
                // Determinar si la notificación ha sido leída (70% no leídas, 30% leídas)
                $readAt = rand(1, 10) <= 3 ? now()->subMinutes(rand(5, 120)) : null;
                
                // Generar datos para la notificación
                $datos = [
                    'mensaje' => $this->generarMensajeNotificacion($tipoNotificacion),
                    'enlace' => $this->generarEnlaceNotificacion($tipoNotificacion),
                    'fecha' => now()->subHours(rand(1, 72))->format('Y-m-d H:i:s'),
                    'prioridad' => rand(1, 3),
                ];
                
                // Insertar la notificación
                DB::table('notifications')->insert([
                    'id' => Str::uuid()->toString(),
                    'type' => $tipoNotificacion,
                    'notifiable_type' => 'App\\Models\\User',
                    'notifiable_id' => $user->id,
                    'data' => json_encode($datos),
                    'read_at' => $readAt,
                    'created_at' => now()->subHours(rand(1, 72)),
                    'updated_at' => now(),
                ]);
            }
        }
    }
    
    /**
     * Genera un mensaje para la notificación basado en su tipo
     */
    private function generarMensajeNotificacion($tipo)
    {
        $mensajes = [
            'App\\Notifications\\SolicitudAceptada' => 'Tu solicitud ha sido aceptada. Ya puedes proceder con el siguiente paso.',
            'App\\Notifications\\ValoracionRecibida' => 'Has recibido una nueva valoración de 5 estrellas.',
            'App\\Notifications\\MensajeRecibido' => 'Tienes un nuevo mensaje de un contacto.',
            'App\\Notifications\\RecordatorioEntrevista' => 'Recuerda que tienes una entrevista programada para mañana.',
            'App\\Notifications\\NuevaOferta' => 'Se ha publicado una nueva oferta que coincide con tu perfil.',
            'App\\Notifications\\ConvenioFinalizado' => 'Un convenio ha finalizado. Considera renovarlo pronto.',
            'App\\Notifications\\RecordatorioEvaluacion' => 'Es momento de evaluar a los estudiantes que finalizan este mes.',
            'App\\Notifications\\NuevaEmpresaInteresada' => 'Una nueva empresa está interesada en establecer convenio.',
            'App\\Notifications\\AlumnoContratado' => 'Felicidades, uno de tus alumnos ha sido contratado tras las prácticas.',
            'App\\Notifications\\SeguimientoPendiente' => 'Tienes pendiente realizar el seguimiento mensual de tus alumnos.',
        ];
        
        return $mensajes[$tipo] ?? 'Tienes una nueva notificación.';
    }
    
    /**
     * Genera un enlace para la notificación basado en su tipo
     */
    private function generarEnlaceNotificacion($tipo)
    {
        $enlaces = [
            'App\\Notifications\\SolicitudAceptada' => '/solicitudes/' . rand(1, 100),
            'App\\Notifications\\ValoracionRecibida' => '/valoraciones/' . rand(1, 50),
            'App\\Notifications\\MensajeRecibido' => '/mensajes/' . rand(1, 150),
            'App\\Notifications\\RecordatorioEntrevista' => '/entrevistas/' . rand(1, 30),
            'App\\Notifications\\NuevaOferta' => '/ofertas/' . rand(1, 80),
            'App\\Notifications\\ConvenioFinalizado' => '/convenios/' . rand(1, 25),
            'App\\Notifications\\RecordatorioEvaluacion' => '/evaluaciones/' . rand(1, 40),
            'App\\Notifications\\NuevaEmpresaInteresada' => '/empresas/' . rand(1, 60),
            'App\\Notifications\\AlumnoContratado' => '/alumnos/contratados/' . rand(1, 20),
            'App\\Notifications\\SeguimientoPendiente' => '/seguimientos/pendientes',
        ];
        
        return $enlaces[$tipo] ?? '/notificaciones/' . rand(1, 200);
    }
} 