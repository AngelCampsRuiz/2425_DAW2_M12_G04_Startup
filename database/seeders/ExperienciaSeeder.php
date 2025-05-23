<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Estudiante;
use App\Models\Experiencia;

class ExperienciaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $estudiantes = Estudiante::all();
        $puestos = [
            'Desarrollador Junior', 'Analista', 'Programador Web', 'Desarrollador Full Stack',
            'Desarrollador Frontend', 'Desarrollador Backend', 'Técnico de Soporte', 'Administrador de Sistemas',
            'Diseñador Web', 'Community Manager', 'Técnico en Marketing Digital', 'Asistente Administrativo',
            'Técnico en Logística', 'Técnico en Atención al Cliente', 'Técnico en Turismo'
        ];
        $especializaciones = [
            'PHP', 'JavaScript', 'Python', 'Java', '.NET', 'React', 'Angular', 'Vue.js', 'Node.js',
            'Laravel', 'Django', 'Spring', 'MySQL', 'PostgreSQL', 'MongoDB', 'Docker', 'Kubernetes',
            'AWS', 'Azure', 'Linux', 'Windows Server', 'SEO', 'SEM', 'Redes Sociales', 'Diseño UI/UX',
            'HTML/CSS', 'Bootstrap', 'Tailwind CSS', 'Git', 'DevOps', 'Ciberseguridad', 'Big Data',
            'Machine Learning', 'Inteligencia Artificial', 'Blockchain', 'IoT', 'Mobile Development',
            'Flutter', 'React Native', 'Swift', 'Kotlin', 'WordPress', 'Shopify', 'Magento', 'Prestashop'
        ];

        foreach ($estudiantes as $estudiante) {
            // Cada estudiante puede tener 0-3 experiencias
            $numExperiencias = rand(0, 3);

            for ($i = 0; $i < $numExperiencias; $i++) {
                $fechaInicio = fake()->dateTimeBetween('-2 years', '-6 months');
                $fechaFin = fake()->dateTimeBetween($fechaInicio, 'now');

                // Seleccionar un puesto y especialización aleatorios
                $puesto = $puestos[array_rand($puestos)];
                $especializacion = $especializaciones[array_rand($especializaciones)];

                // Generar un nombre de empresa realista
                $empresa = fake()->randomElement([
                    'TechSolutions', 'DigitalWorks', 'WebCrafters', 'CodeMasters', 'DevPro', 'ByteLogic',
                    'DataFlow', 'CloudSystems', 'NetSolutions', 'AppBuilders', 'SoftTech', 'WebMasters',
                    'DigitalLogic', 'CodeCrafters', 'DevLogic', 'ByteWorks', 'DataLogic', 'CloudLogic',
                    'NetLogic', 'AppLogic', 'SoftLogic', 'WebLogic', 'DigitalFlow', 'CodeFlow', 'DevFlow',
                    'ByteFlow', 'DataSystems', 'CloudWorks', 'NetWorks', 'AppWorks', 'SoftWorks', 'WebWorks'
                ]);

                Experiencia::create([
                    'empresa_nombre' => $empresa,
                    'puesto' => $puesto,
                    'fecha_inicio' => $fechaInicio,
                    'fecha_fin' => $fechaFin,
                    'descripcion' => $especializacion,
                    'user_id' => $estudiante->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                    'oculto' => false,
                ]);
            }
        }
    }
}
