<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ActivityLog;
use App\Models\User;

class ActivityLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtenemos todos los usuarios
        $users = User::all();
        
        // Tipos de actividades comunes
        $tiposActividad = [
            'login' => [
                'type' => 'auth',
                'action' => 'login',
                'subject_type' => 'User',
                'description' => 'Ha iniciado sesión en el sistema'
            ],
            'logout' => [
                'type' => 'auth',
                'action' => 'logout',
                'subject_type' => 'User',
                'description' => 'Ha cerrado sesión en el sistema'
            ],
            'profile_update' => [
                'type' => 'update',
                'action' => 'updated',
                'subject_type' => 'User',
                'description' => 'Ha actualizado su perfil'
            ],
            'password_change' => [
                'type' => 'update',
                'action' => 'updated',
                'subject_type' => 'User',
                'description' => 'Ha cambiado su contraseña'
            ],
            'publicacion_create' => [
                'type' => 'create',
                'action' => 'created',
                'subject_type' => 'Publicacion',
                'description' => 'Ha creado una nueva publicación'
            ],
            'publicacion_update' => [
                'type' => 'update',
                'action' => 'updated',
                'subject_type' => 'Publicacion',
                'description' => 'Ha actualizado una publicación'
            ],
            'solicitud_create' => [
                'type' => 'create',
                'action' => 'created',
                'subject_type' => 'Solicitud',
                'description' => 'Ha enviado una solicitud'
            ],
            'solicitud_update' => [
                'type' => 'update',
                'action' => 'updated',
                'subject_type' => 'Solicitud',
                'description' => 'Ha actualizado el estado de una solicitud'
            ],
            'chat_create' => [
                'type' => 'create',
                'action' => 'created',
                'subject_type' => 'Chat',
                'description' => 'Ha iniciado una conversación'
            ],
            'mensaje_create' => [
                'type' => 'create',
                'action' => 'created',
                'subject_type' => 'Mensaje',
                'description' => 'Ha enviado un mensaje'
            ],
            'valoracion_create' => [
                'type' => 'create',
                'action' => 'created',
                'subject_type' => 'Valoracion',
                'description' => 'Ha realizado una valoración'
            ],
            'convenio_create' => [
                'type' => 'create',
                'action' => 'created',
                'subject_type' => 'Convenio',
                'description' => 'Ha creado un nuevo convenio'
            ],
            'convenio_update' => [
                'type' => 'update',
                'action' => 'updated',
                'subject_type' => 'Convenio',
                'description' => 'Ha actualizado un convenio'
            ],
            'seguimiento_create' => [
                'type' => 'create',
                'action' => 'created',
                'subject_type' => 'Seguimiento',
                'description' => 'Ha registrado un seguimiento'
            ],
            'favorito_create' => [
                'type' => 'create',
                'action' => 'created',
                'subject_type' => 'Favorito',
                'description' => 'Ha marcado como favorito'
            ],
            'favorito_delete' => [
                'type' => 'delete',
                'action' => 'deleted',
                'subject_type' => 'Favorito',
                'description' => 'Ha eliminado un favorito'
            ],
            'game_play' => [
                'type' => 'create',
                'action' => 'played',
                'subject_type' => 'GameScore',
                'description' => 'Ha jugado a un juego educativo'
            ],
            'clase_update' => [
                'type' => 'update',
                'action' => 'updated',
                'subject_type' => 'Clase',
                'description' => 'Ha actualizado información de una clase'
            ],
        ];
        
        // Fechas para generar actividades cronológicamente
        $fechaInicio = now()->subMonths(3);
        $fechaFin = now();
        
        // Array para almacenar actividades predefinidas
        $actividades = [];
        
        // Generamos actividades para todos los usuarios
        foreach ($users as $user) {
            // Determinar cantidad de registros según el tipo de usuario
            $cantidadRegistros = match($user->role_id) {
                1 => rand(40, 60), // Admin (más activo)
                2 => rand(30, 50), // Empresa
                3 => rand(50, 70), // Estudiante (muy activo)
                4 => rand(20, 35), // Tutor
                5 => rand(25, 40), // Institución
                6 => rand(30, 45), // Docente
                default => rand(20, 30)
            };
            
            // Actividades específicas según rol
            $actividadesRol = $tiposActividad;
            
            // Eliminar actividades que no apliquen al rol
            if ($user->role_id != 2 && $user->role_id != 3) { // No es empresa ni estudiante
                unset($actividadesRol['solicitud_create']);
            }
            
            if ($user->role_id != 2 && $user->role_id != 5) { // No es empresa ni institución
                unset($actividadesRol['convenio_create']);
                unset($actividadesRol['convenio_update']);
            }
            
            if ($user->role_id != 4 && $user->role_id != 6) { // No es tutor ni docente
                unset($actividadesRol['seguimiento_create']);
            }
            
            if ($user->role_id != 3) { // No es estudiante
                unset($actividadesRol['game_play']);
            }
            
            if ($user->role_id != 6) { // No es docente
                unset($actividadesRol['clase_update']);
            }
            
            // Generamos actividades distribuidas en el tiempo
            $fechasActividad = [];
            for ($i = 0; $i < $cantidadRegistros; $i++) {
                $diasAtras = rand(0, 90); // Hasta 3 meses atrás
                $horasAtras = rand(0, 23);
                $minutosAtras = rand(0, 59);
                
                $fecha = now()->subDays($diasAtras)->subHours($horasAtras)->subMinutes($minutosAtras);
                $fechasActividad[] = $fecha;
            }
            
            // Ordenamos cronológicamente
            sort($fechasActividad);
            
            // Aseguramos que haya login y logout en orden lógico
            $sesiones = intval($cantidadRegistros / 10); // Aproximadamente 1 sesión cada 10 actividades
            $sesionesCreadas = 0;
            $sesionActiva = false;
            
            for ($i = 0; $i < count($fechasActividad); $i++) {
                $fecha = $fechasActividad[$i];
                
                // Determinar si es login o logout, o una actividad normal
                if (!$sesionActiva && $sesionesCreadas < $sesiones && rand(0, 5) > 3) {
                    // Login
                    $actividades[] = [
                        'user_id' => $user->id,
                        'type' => 'auth',
                        'action' => 'login',
                        'subject_type' => 'User',
                        'subject_id' => $user->id,
                        'description' => $tiposActividad['login']['description'],
                        'data' => json_encode(['ip' => '192.168.' . rand(0, 255) . '.' . rand(0, 255)]),
                        'ip_address' => '192.168.' . rand(0, 255) . '.' . rand(0, 255),
                        'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/' . rand(80, 120) . '.0.' . rand(1000, 5000) . '.' . rand(100, 200) . ' Safari/537.36',
                        'created_at' => $fecha,
                        'updated_at' => $fecha
                    ];
                    $sesionActiva = true;
                } 
                elseif ($sesionActiva && rand(0, 10) > 8) {
                    // Logout (ocasional)
                    $actividades[] = [
                        'user_id' => $user->id,
                        'type' => 'auth',
                        'action' => 'logout',
                        'subject_type' => 'User',
                        'subject_id' => $user->id,
                        'description' => $tiposActividad['logout']['description'],
                        'data' => json_encode(['ip' => '192.168.' . rand(0, 255) . '.' . rand(0, 255)]),
                        'ip_address' => '192.168.' . rand(0, 255) . '.' . rand(0, 255),
                        'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/' . rand(80, 120) . '.0.' . rand(1000, 5000) . '.' . rand(100, 200) . ' Safari/537.36',
                        'created_at' => $fecha,
                        'updated_at' => $fecha
                    ];
                    $sesionActiva = false;
                    $sesionesCreadas++;
                } 
                else {
                    // Actividad normal
                    // Seleccionar actividad aleatoria (excepto login/logout)
                    $actividadesDisponibles = array_diff_key($actividadesRol, ['login' => '', 'logout' => '']);
                    $tipoActividadKey = array_rand($actividadesDisponibles);
                    $tipoActividad = $actividadesRol[$tipoActividadKey];
                    
                    // Generar un subject_id credible según el tipo
                    $subjectId = match($tipoActividad['subject_type']) {
                        'User' => $user->id,
                        default => rand(1, 20) // ID genérico para otros modelos
                    };
                    
                    $actividades[] = [
                        'user_id' => $user->id,
                        'type' => $tipoActividad['type'],
                        'action' => $tipoActividad['action'],
                        'subject_type' => $tipoActividad['subject_type'],
                        'subject_id' => $subjectId,
                        'description' => $tipoActividad['description'],
                        'data' => json_encode(['timestamp' => $fecha->timestamp]),
                        'ip_address' => '192.168.' . rand(0, 255) . '.' . rand(0, 255),
                        'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/' . rand(80, 120) . '.0.' . rand(1000, 5000) . '.' . rand(100, 200) . ' Safari/537.36',
                        'created_at' => $fecha,
                        'updated_at' => $fecha
                    ];
                }
            }
            
            // Asegurar que la última sesión se cierre
            if ($sesionActiva) {
                $actividades[] = [
                    'user_id' => $user->id,
                    'type' => 'auth',
                    'action' => 'logout',
                    'subject_type' => 'User',
                    'subject_id' => $user->id,
                    'description' => $tiposActividad['logout']['description'],
                    'data' => json_encode(['ip' => '192.168.' . rand(0, 255) . '.' . rand(0, 255)]),
                    'ip_address' => '192.168.' . rand(0, 255) . '.' . rand(0, 255),
                    'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/' . rand(80, 120) . '.0.' . rand(1000, 5000) . '.' . rand(100, 200) . ' Safari/537.36',
                    'created_at' => end($fechasActividad),
                    'updated_at' => end($fechasActividad)
                ];
            }
        }
        
        // Insertar todas las actividades en la base de datos
        foreach ($actividades as $actividad) {
            ActivityLog::create($actividad);
        }
    }
} 