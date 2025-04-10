<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Solicitud;
use App\Models\Estudiante;
use App\Models\Publicacion;

class SolicitudSeeder extends Seeder
{
    public function run(): void
    {
        $estudiantes = Estudiante::all();
        $publicaciones = Publicacion::all();
        $estados = ['pendiente', 'aceptada', 'rechazada'];

        foreach($publicaciones as $publicacion) {
            $numSolicitudes = rand(1, 3);
            
            // Asegurarse de no pedir más estudiantes de los que hay disponibles
            $numSolicitudes = min($numSolicitudes, $estudiantes->count());
            
            $estudiantesAleatorios = $estudiantes->random($numSolicitudes);
            
            foreach($estudiantesAleatorios as $estudiante) {
                Solicitud::create([
                    'estudiante_id' => $estudiante->id,
                    'publicacion_id' => $publicacion->id,
                    'estado' => $estados[array_rand($estados)],
                    'mensaje' => fake()->paragraph(),
                    'respuesta_empresa' => rand(0, 1) ? fake()->paragraph() : null,
                ]);
            }
        }
    }
}
