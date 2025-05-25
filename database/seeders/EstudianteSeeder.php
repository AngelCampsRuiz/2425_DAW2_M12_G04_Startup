<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Estudiante;
use App\Models\Categoria;
use App\Models\Clase;
use App\Models\Institucion;

class EstudianteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $estudianteUsers = User::where('role_id', 3)->get();
        $categorias = Categoria::all();
        $instituciones = Institucion::all();

        foreach ($estudianteUsers as $user) {
            // Seleccionar una institución aleatoria
            $institucion = $instituciones->random();
            
            $categoria = $categorias->random();
            $estudiante = Estudiante::create([
                'id' => $user->id,
                'centro_educativo' => $institucion->user->nombre,
                'cv_pdf' => 'cv_' . $user->id . '.pdf',
                'numero_seguridad_social' => 'SS' . str_pad(rand(1, 99999999), 8, '0', STR_PAD_LEFT),
                'categoria_id' => $categoria->id,
            ]);

            // Obtener clases de la institución
            $clases = Clase::where('institucion_id', $institucion->id)
                          ->where('activa', true)
                          ->inRandomOrder()
                          ->take(rand(1, 2)) // Asignar a 1 o 2 clases
                          ->get();

            // Asignar estudiante a las clases
            foreach ($clases as $clase) {
                $estudiante->clases()->attach($clase->id, [
                    'fecha_asignacion' => now(),
                    'estado' => 'Activo',
                    'calificacion' => null,
                    'comentarios' => null
                ]);
            }
        }
    }
}
