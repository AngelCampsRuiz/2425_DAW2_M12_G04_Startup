<?php

namespace Database\Seeders;

use App\Models\Categoria;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Tutor;
use App\Models\Titulo;

class TutorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tutorUsers = User::where('role_id', 4)->get();
        $centros = ['IES Example 1', 'IES Example 2', 'IES Example 3'];
        $categorias = Categoria::all();

        foreach ($tutorUsers as $user) {
            $categoria = $categorias->random();
            Tutor::create([
                'id' => $user->id,
                'centro_asignado' => $centros[array_rand($centros)],
                'categoria_id' => $categoria->id,
            ]);
        }
    }
}
