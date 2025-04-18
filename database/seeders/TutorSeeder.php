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
        $centros = [
            'IES Virgen de la Paloma', 'IES Francisco de Quevedo', 'IES San Isidro', 
            'IES Ramiro de Maeztu', 'IES Beatriz Galindo', 'IES Lope de Vega',
            'IES Juan de la Cierva', 'IES Miguel Catalán', 'IES La Serna',
            'IES El Greco', 'IES Marqués de Comares', 'IES La Rosaleda',
            'IES La Merced', 'IES Salvador Dalí', 'IES La Salle',
            'IES La Magdalena', 'IES La Laboral', 'IES La Vaguada',
            'IES La Dehesa', 'IES La Albuera'
        ];
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
