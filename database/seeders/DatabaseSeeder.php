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
            RolSeeder::class,
            TituloSeeder::class,
            CategoriaSeeder::class,
            UserSeeder::class,
            EmpresaSeeder::class,
            EstudianteSeeder::class,
            TutorSeeder::class,
            AlumnoTutorSeeder::class,
            SubcategoriaSeeder::class,
            PublicacionSeeder::class,
            ChatSeeder::class,
            MensajeSeeder::class,
            SeguimientoSeeder::class,
            ConvenioSeeder::class,
            ExperienciaSeeder::class,
            ValoracionSeeder::class,
            FavoritoSeeder::class,
            SolicitudSeeder::class,
            InstitucionSeeder::class,
            DocenteSeeder::class,
        ]);
    }
}
