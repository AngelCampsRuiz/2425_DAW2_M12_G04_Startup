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
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role_id' => 1
        ]);

        // Crear usuarios empresa (role_id = 2)
        for ($j = 1; $j <= 5; $j++) {
            User::create([
                'name' => fake()->company,
                'email' => "empresa_{$j}@example.com",
                'password' => Hash::make('password'),
                'role_id' => 2
            ]);
        }

        // Crear usuarios estudiante y tutor (role_id = 3 y 4)
        for ($i = 3; $i <= 4; $i++) {
            for ($j = 1; $j <= 5; $j++) {
                User::create([
                    'name' => fake()->name,
                    'email' => "usuario{$i}_{$j}@example.com",
                    'password' => Hash::make('password'),
                    'role_id' => $i
                ]);
            }
        }
    }
}
