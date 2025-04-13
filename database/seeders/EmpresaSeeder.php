<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Empresa;

class EmpresaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $empresaUsers = User::where('role_id', 2)->get();

        foreach ($empresaUsers as $user) {
            Empresa::create([
                'id' => $user->id,
                'cif' => 'B' . str_pad(rand(1, 99999999), 8, '0', STR_PAD_LEFT),
                'direccion' => fake()->streetAddress,
                'latitud' => fake()->latitude(36, 43), // Latitud de España
                'longitud' => fake()->longitude(-9, 4), // Longitud de España
            ]);
        }
    }
}
