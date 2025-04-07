<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin
        User::create([
            'nombre' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'pais' => 'España',
            'fecha_nacimiento' => '1990-01-01',
            'ciudad' => 'Barcelona',
            'dni' => '12345678A',
            'sitio_web' => 'http://admin.com',
            'activo' => true,
            'telefono' => '123456789',
            'role_id' => 1
        ]);

        // Crear usuarios para cada rol (empresa, estudiante, tutor)
        for ($i = 2; $i <= 4; $i++) {
            for ($j = 1; $j <= 5; $j++) {
                User::create([
                    'nombre' => fake()->name,
                    'email' => "usuario{$i}_{$j}@example.com",
                    'password' => Hash::make('password'),
                    'pais' => 'España',
                    'fecha_nacimiento' => fake()->date,
                    'ciudad' => fake()->city,
                    'dni' => fake()->numerify('########') . fake()->randomLetter,
                    'sitio_web' => fake()->url,
                    'activo' => true,
                    'telefono' => fake()->phoneNumber,
                    'role_id' => $i
                ]);
            }
        }
    }
}
