<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Estudiante;

class EstudianteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $estudianteUsers = User::where('role_id', 3)->get();
        $centros = ['IES Ejemplo 1', 'IES Ejemplo 2', 'IES Ejemplo 3'];

        foreach ($estudianteUsers as $user) {
            Estudiante::create([
                'id' => $user->id,
                'centro_educativo' => fake()->randomElement($centros),
                'cv_pdf' => 'cv.pdf',
                'numero_seguridad_social' => 'SS' . str_pad(rand(1, 99999999), 8, '0', STR_PAD_LEFT),
            ]);
        }
    }
}
