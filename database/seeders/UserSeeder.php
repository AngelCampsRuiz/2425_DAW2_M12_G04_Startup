<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

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
            'role_id' => 1,
            'pais' => 'España',
            'fecha_nacimiento' => now()->subYears(30),
            'ciudad' => 'Barcelona',
            'dni' => '12345678A',
            'sitio_web' => 'https://admin.example.com',
            'activo' => true,
            'telefono' => '123456789'
        ]);

        // Crear usuarios empresa (role_id = 2)
        for ($j = 1; $j <= 5; $j++) {
            User::create([
                'nombre' => fake()->company,
                'email' => "empresa_{$j}@example.com",
                'password' => Hash::make('password'),
                'role_id' => 2,
                'pais' => fake()->country,
                'fecha_nacimiento' => fake()->dateTimeBetween('-60 years', '-25 years'),
                'ciudad' => fake()->city,
                'dni' => fake()->numerify('########') . fake()->randomLetter(),
                'sitio_web' => fake()->url,
                'activo' => true,
                'telefono' => fake()->phoneNumber
            ]);
        }

        // Crear usuarios estudiante y tutor (role_id = 3 y 4)
        for ($i = 3; $i <= 4; $i++) {
            for ($j = 1; $j <= 5; $j++) {
                User::create([
                    'nombre' => fake()->name,
                    'email' => "usuario{$i}_{$j}@example.com",
                    'password' => Hash::make('password'),
                    'role_id' => $i,
                    'pais' => fake()->country,
                    'fecha_nacimiento' => fake()->dateTimeBetween('-60 years', '-18 years'),
                    'ciudad' => fake()->city,
                    'dni' => fake()->numerify('########') . fake()->randomLetter(),
                    'sitio_web' => fake()->url,
                    'activo' => true,
                    'telefono' => fake()->phoneNumber
                ]);
            }
        }
    }
}
