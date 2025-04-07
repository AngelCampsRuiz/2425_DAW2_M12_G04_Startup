<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Rol;

class RolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['nombre_rol' => 'Administrador'],
            ['nombre_rol' => 'Empresa'],
            ['nombre_rol' => 'Estudiante'],
            ['nombre_rol' => 'Tutor']
        ];

        foreach ($roles as $role) {
            Rol::create($role);
        }
    }
}
