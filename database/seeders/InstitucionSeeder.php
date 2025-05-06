<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Institucion;
use Illuminate\Support\Facades\Hash;

class InstitucionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear usuario de institución
        $user = User::create([
            'nombre' => 'IES Esteve Terradas i Illa',
            'email' => 'institucion@example.com',
            'password' => Hash::make('password'),
            'fecha_nacimiento' => null,
            'ciudad' => 'Cornellà de Llobregat',
            'dni' => 'B98765432',
            'activo' => true,
            'sitio_web' => 'https://www.iesesteveterradas.cat',
            'telefono' => '934740700',
            'descripcion' => 'Instituto de Educación Secundaria con ciclos formativos de grado superior',
            'imagen' => null,
            'visibilidad' => true,
            'role_id' => 4, // ID del rol 'institucion'
        ]);

        // Crear la institución
        Institucion::create([
            'user_id' => $user->id,
            'codigo_centro' => '08012345',
            'tipo_institucion' => 'Instituto de Educación Secundaria',
            'direccion' => 'Carrer de l\'Aviació, 2',
            'provincia' => 'Barcelona',
            'codigo_postal' => '08940',
            'representante_legal' => 'José García Pérez',
            'cargo_representante' => 'Director',
            'verificada' => true,
        ]);

        // Crear usuario de institución 2
        $user2 = User::create([
            'nombre' => 'Universidad Politécnica de Cataluña',
            'email' => 'institucion2@example.com',
            'password' => Hash::make('password'),
            'fecha_nacimiento' => null,
            'ciudad' => 'Barcelona',
            'dni' => 'B87654321',
            'activo' => true,
            'sitio_web' => 'https://www.upc.edu',
            'telefono' => '934017000',
            'descripcion' => 'Universidad pública especializada en ingeniería y arquitectura',
            'imagen' => null,
            'visibilidad' => true,
            'role_id' => 4, // ID del rol 'institucion'
        ]);

        // Crear la institución 2
        Institucion::create([
            'user_id' => $user2->id,
            'codigo_centro' => '08098765',
            'tipo_institucion' => 'Universidad',
            'direccion' => 'Campus Nord, C/Jordi Girona, 1-3',
            'provincia' => 'Barcelona',
            'codigo_postal' => '08034',
            'representante_legal' => 'Daniel Crespo Artiaga',
            'cargo_representante' => 'Rector',
            'verificada' => true,
        ]);
    }
} 