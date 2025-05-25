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
        $instituciones = Institucion::all();

        foreach ($instituciones as $institucion) {
            // Lista de docentes para cada institución
            $docentes = [
                [
                    'nombre' => 'María López García',
                    'email' => 'docente1.' . strtolower(str_replace(' ', '', $institucion->user->nombre)) . '@educacion.es',
                    'dni' => 'D' . str_pad($institucion->id . '01', 8, '0', STR_PAD_LEFT) . 'X',
                    'telefono' => '6' . str_pad($institucion->id . '01', 8, '1', STR_PAD_LEFT),
                    'descripcion' => 'Profesora de Desarrollo Web',
                    'departamento' => 'Informática',
                    'especialidad' => 'Desarrollo Web',
                    'cargo' => 'Jefe de Departamento'
                ],
                [
                    'nombre' => 'Juan Martínez Sánchez',
                    'email' => 'docente2.' . strtolower(str_replace(' ', '', $institucion->user->nombre)) . '@educacion.es',
                    'dni' => 'D' . str_pad($institucion->id . '02', 8, '0', STR_PAD_LEFT) . 'X',
                    'telefono' => '6' . str_pad($institucion->id . '02', 8, '2', STR_PAD_LEFT),
                    'descripcion' => 'Profesor de Bases de Datos',
                    'departamento' => 'Informática',
                    'especialidad' => 'Bases de Datos',
                    'cargo' => 'Profesor'
                ],
                [
                    'nombre' => 'Ana Rodríguez Pérez',
                    'email' => 'docente3.' . strtolower(str_replace(' ', '', $institucion->user->nombre)) . '@educacion.es',
                    'dni' => 'D' . str_pad($institucion->id . '03', 8, '0', STR_PAD_LEFT) . 'X',
                    'telefono' => '6' . str_pad($institucion->id . '03', 8, '3', STR_PAD_LEFT),
                    'descripcion' => 'Profesora de Administración',
                    'departamento' => 'Administración',
                    'especialidad' => 'Gestión Administrativa',
                    'cargo' => 'Jefe de Departamento'
                ],
                [
                    'nombre' => 'Pedro González Ruiz',
                    'email' => 'docente4.' . strtolower(str_replace(' ', '', $institucion->user->nombre)) . '@educacion.es',
                    'dni' => 'D' . str_pad($institucion->id . '04', 8, '0', STR_PAD_LEFT) . 'X',
                    'telefono' => '6' . str_pad($institucion->id . '04', 8, '4', STR_PAD_LEFT),
                    'descripcion' => 'Profesor de Marketing',
                    'departamento' => 'Marketing',
                    'especialidad' => 'Marketing Digital',
                    'cargo' => 'Jefe de Departamento'
                ],
                [
                    'nombre' => 'Laura Fernández Castro',
                    'email' => 'docente5.' . strtolower(str_replace(' ', '', $institucion->user->nombre)) . '@educacion.es',
                    'dni' => 'D' . str_pad($institucion->id . '05', 8, '0', STR_PAD_LEFT) . 'X',
                    'telefono' => '6' . str_pad($institucion->id . '05', 8, '5', STR_PAD_LEFT),
                    'descripcion' => 'Profesora de Comercio',
                    'departamento' => 'Marketing',
                    'especialidad' => 'Comercio Internacional',
                    'cargo' => 'Profesor'
                ]
            ];

            foreach ($docentes as $docenteData) {
                // Crear usuario
                $user = User::create([
                    'nombre' => $docenteData['nombre'],
                    'email' => $docenteData['email'],
                    'password' => Hash::make('password'),
                    'fecha_nacimiento' => now()->subYears(rand(30, 60)),
                    'ciudad' => $institucion->ciudad,
                    'dni' => $docenteData['dni'],
                    'activo' => true,
                    'telefono' => $docenteData['telefono'],
                    'descripcion' => $docenteData['descripcion'],
                    'imagen' => null,
                    'visibilidad' => true,
                    'role_id' => 5, // ID del rol 'docente'
                ]);

                // Crear el docente
                Docente::create([
                    'user_id' => $user->id,
                    'institucion_id' => $institucion->id,
                    'departamento' => $docenteData['departamento'],
                    'especialidad' => $docenteData['especialidad'],
                    'cargo' => $docenteData['cargo'],
                    'activo' => true,
                ]);
            }
        }
    }
} 