<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Docente;
use App\Models\Institucion;
use Illuminate\Support\Facades\Hash;

class DocenteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener la primera institución
        $institucion = Institucion::first();

        // Crear usuario de docente
        $user = User::create([
            'nombre' => 'María López García',
            'email' => 'docente@example.com',
            'password' => Hash::make('password'),
            'fecha_nacimiento' => '1980-05-15',
            'ciudad' => 'Cornellà de Llobregat',
            'dni' => '12345678Z',
            'activo' => true,
            'sitio_web' => null,
            'telefono' => '666555444',
            'descripcion' => 'Profesora de Desarrollo de Aplicaciones Web',
            'imagen' => null,
            'visibilidad' => true,
            'role_id' => 5, // ID del rol 'docente'
        ]);

        // Crear el docente
        Docente::create([
            'user_id' => $user->id,
            'institucion_id' => $institucion->id,
            'departamento' => 'Informática',
            'especialidad' => 'Desarrollo Web',
            'cargo' => 'Tutor de DAW',
            'activo' => true,
        ]);

        // Crear usuario de docente 2
        $user2 = User::create([
            'nombre' => 'Juan Martínez Sánchez',
            'email' => 'docente2@example.com',
            'password' => Hash::make('password'),
            'fecha_nacimiento' => '1975-08-20',
            'ciudad' => 'Barcelona',
            'dni' => '87654321Y',
            'activo' => true,
            'sitio_web' => null,
            'telefono' => '666444333',
            'descripcion' => 'Profesor de Bases de Datos',
            'imagen' => null,
            'visibilidad' => true,
            'role_id' => 5, // ID del rol 'docente'
        ]);

        // Crear el docente 2
        Docente::create([
            'user_id' => $user2->id,
            'institucion_id' => $institucion->id,
            'departamento' => 'Informática',
            'especialidad' => 'Bases de Datos',
            'cargo' => 'Jefe de Departamento',
            'activo' => true,
        ]);
    }
} 