<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Estudiante;
use App\Models\Categoria;

class EstudianteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $estudianteUsers = User::where('role_id', 3)->get();
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

        foreach ($estudianteUsers as $user) {
            $categoria = $categorias->random();
            Estudiante::create([
                'id' => $user->id,
                'centro_educativo' => $centros[array_rand($centros)],
                'cv_pdf' => 'cv_' . $user->id . '.pdf',
                'numero_seguridad_social' => 'SS' . str_pad(rand(1, 99999999), 8, '0', STR_PAD_LEFT),
                'categoria_id' => $categoria->id,
            ]);
        }
    }
}
