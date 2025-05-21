<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            // Seeders base (entidades fundamentales)
            RolSeeder::class,
            NivelEducativoSeeder::class,
            CategoriaSeeder::class,
            SubcategoriaSeeder::class,
            
            // Usuario y entidades relacionadas
            UserSeeder::class,
            InstitucionSeeder::class,
            EmpresaSeeder::class,
            EstudianteSeeder::class,
            TutorSeeder::class,
            DocenteSeeder::class,
            
            // Estructuras educativas
            DepartamentoSeeder::class,
            ClaseSeeder::class,
            EstudianteClaseSeeder::class,
            
            // Publicaciones
            PublicacionSeeder::class,
            
            // Funcionalidades adicionales
            NotificationSeeder::class,
            GameScoreSeeder::class,
        ]);
    }
}
