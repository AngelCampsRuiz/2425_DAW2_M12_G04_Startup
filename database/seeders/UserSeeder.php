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
            'nombre' => 'Administrador',
            'email' => 'admin@sistema.com',
            'password' => Hash::make('password'),
            'role_id' => 1,
            'fecha_nacimiento' => now()->subYears(45),
            'ciudad' => 'Madrid',
            'dni' => '12345678A',
            'activo' => true,
            'telefono' => '912345678',
            'descripcion' => 'Administrador del sistema de gestión de prácticas',
            'imagen' => 'admin/profile.jpg'
        ]);

        // Crear usuarios empresa (role_id = 2)
        $empresas = [
            ['nombre' => 'Indra Sistemas', 'email' => 'contacto@indra.es', 'ciudad' => 'Madrid', 'dni' => 'B12345678', 'telefono' => '913456789', 'sitio_web' => 'https://www.indracompany.com', 'descripcion' => 'Empresa líder en tecnología y consultoría en España.', 'imagen' => 'indra.png'],
            ['nombre' => 'Telefónica', 'email' => 'info@telefonica.com', 'ciudad' => 'Madrid', 'dni' => 'B23456789', 'telefono' => '914567890', 'sitio_web' => 'https://www.telefonica.com', 'descripcion' => 'Compañía global de telecomunicaciones con presencia en más de 170 países.', 'imagen' => 'telefonica.webp'],
            ['nombre' => 'Accenture', 'email' => 'contacto@accenture.es', 'ciudad' => 'Barcelona', 'dni' => 'B34567890', 'telefono' => '934567891', 'sitio_web' => 'https://www.accenture.com', 'descripcion' => 'Consultora global de servicios profesionales con amplia experiencia en transformación digital.', 'imagen' => 'Accenture.png'],
            ['nombre' => 'BBVA', 'email' => 'info@bbva.es', 'ciudad' => 'Bilbao', 'dni' => 'B45678901', 'telefono' => '944567892', 'sitio_web' => 'https://www.bbva.es', 'descripcion' => 'Banco global con fuerte presencia en España y Latinoamérica.', 'imagen' => 'BBVA.png'],
            ['nombre' => 'Mercadona', 'email' => 'contacto@mercadona.es', 'ciudad' => 'Valencia', 'dni' => 'B56789012', 'telefono' => '964567893', 'sitio_web' => 'https://www.mercadona.es', 'descripcion' => 'Cadena de supermercados líder en España.', 'imagen' => 'Mercadona.png'],
            ['nombre' => 'Iberdrola', 'email' => 'info@iberdrola.es', 'ciudad' => 'Bilbao', 'dni' => 'B67890123', 'telefono' => '944567894', 'sitio_web' => 'https://www.iberdrola.es', 'descripcion' => 'Compañía energética global con fuerte compromiso con las renovables.', 'imagen' => 'iberdrola.png'],
            ['nombre' => 'El Corte Inglés', 'email' => 'contacto@elcorteingles.es', 'ciudad' => 'Madrid', 'dni' => 'B78901234', 'telefono' => '915678905', 'sitio_web' => 'https://www.elcorteingles.es', 'descripcion' => 'Grupo de distribución líder en España.', 'imagen' => 'corteingles.png'],
            ['nombre' => 'CaixaBank', 'email' => 'info@caixabank.es', 'ciudad' => 'Barcelona', 'dni' => 'B89012345', 'telefono' => '935678906', 'sitio_web' => 'https://www.caixabank.es', 'descripcion' => 'Banco líder en España con amplia red de oficinas.', 'imagen' => 'caixa.png'],
            ['nombre' => 'Repsol', 'email' => 'contacto@repsol.com', 'ciudad' => 'Madrid', 'dni' => 'B90123456', 'telefono' => '916789007', 'sitio_web' => 'https://www.repsol.com', 'descripcion' => 'Compañía energética global con sede en España.', 'imagen' => 'repsol.png'],
            ['nombre' => 'Zara', 'email' => 'info@zara.com', 'ciudad' => 'A Coruña', 'dni' => 'B01234567', 'telefono' => '981678908', 'sitio_web' => 'https://www.zara.com', 'descripcion' => 'Marca de moda global del grupo Inditex.', 'imagen' => 'zara.svg']
        ];

        foreach ($empresas as $index => $empresa) {
            User::create([
                'nombre' => $empresa['nombre'],
                'email' => $empresa['email'],
                'password' => Hash::make('password'),
                'role_id' => 2,
                'fecha_nacimiento' => now()->subYears(rand(30, 60)),
                'ciudad' => $empresa['ciudad'],
                'dni' => $empresa['dni'],
                'activo' => true,
                'sitio_web' => $empresa['sitio_web'],
                'telefono' => $empresa['telefono'],
                'descripcion' => $empresa['descripcion'],
                'imagen' => $empresa['imagen']
            ]);
        }

        // Crear usuarios tutor (role_id = 4)
        $tutores = [
            ['nombre' => 'María García López', 'email' => 'maria.garcia@educacion.es', 'ciudad' => 'Madrid', 'dni' => '23456789B', 'telefono' => '912345679', 'descripcion' => 'Tutora de prácticas con experiencia en Desarrollo Web y Aplicaciones Móviles.'],
            ['nombre' => 'Juan Martínez Sánchez', 'email' => 'juan.martinez@educacion.es', 'ciudad' => 'Barcelona', 'dni' => '34567890C', 'telefono' => '934567890', 'descripcion' => 'Tutor especializado en Administración de Sistemas y Ciberseguridad.'],
            ['nombre' => 'Ana Rodríguez Pérez', 'email' => 'ana.rodriguez@educacion.es', 'ciudad' => 'Valencia', 'dni' => '45678901D', 'telefono' => '964567891', 'descripcion' => 'Tutora con amplia experiencia en Marketing Digital y Comercio Internacional.'],
            ['nombre' => 'Carlos López Fernández', 'email' => 'carlos.lopez@educacion.es', 'ciudad' => 'Sevilla', 'dni' => '56789012E', 'telefono' => '954567892', 'descripcion' => 'Tutor especializado en Inteligencia Artificial y Big Data.'],
            ['nombre' => 'Laura Sánchez Gómez', 'email' => 'laura.sanchez@educacion.es', 'ciudad' => 'Bilbao', 'dni' => '67890123F', 'telefono' => '944567893', 'descripcion' => 'Tutora con experiencia en Diseño Gráfico y Publicaciones Multimedia.']
        ];

        foreach ($tutores as $index => $tutor) {
            User::create([
                'nombre' => $tutor['nombre'],
                'email' => $tutor['email'],
                'password' => Hash::make('password'),
                'role_id' => 4,
                'fecha_nacimiento' => now()->subYears(rand(35, 55)),
                'ciudad' => $tutor['ciudad'],
                'dni' => $tutor['dni'],
                'activo' => true,
                'telefono' => $tutor['telefono'],
                'descripcion' => $tutor['descripcion'],
                'imagen' => 'tutores/perfil_' . ($index + 1) . '.jpg'
            ]);
        }

        // Crear usuarios estudiante (role_id = 3)
        $nombres = ['Carlos', 'Laura', 'Miguel', 'Sofía', 'David', 'Lucía', 'Pablo', 'María', 'Javier', 'Elena', 
                   'Daniel', 'Paula', 'Adrián', 'Clara', 'Álvaro', 'Carmen', 'Rubén', 'Sara', 'Iván', 'Natalia'];
        $apellidos = ['García', 'Martínez', 'López', 'González', 'Rodríguez', 'Fernández', 'Sánchez', 'Pérez', 
                     'Gómez', 'Martín', 'Jiménez', 'Hernández', 'Díaz', 'Moreno', 'Álvarez', 'Muñoz', 'Romero', 
                     'Alonso', 'Gutiérrez', 'Navarro'];
        $ciudades = ['Madrid', 'Barcelona', 'Valencia', 'Sevilla', 'Bilbao', 'Málaga', 'Zaragoza', 'Alicante', 
                    'Granada', 'Murcia', 'Palma', 'Valladolid', 'Córdoba', 'Vigo', 'Gijón', 'Elche', 'A Coruña', 
                    'Cartagena', 'Terrassa', 'Jerez de la Frontera'];
        
        // Crear 20 estudiantes
        for ($i = 1; $i <= 20; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante' . $i . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => str_replace(' ', '_', strtolower($nombre)) . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 1
        for ($i = 1; $i <= 20; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat1_' . $i . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 1,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' =>  $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 2
        for ($i = 21; $i <= 40; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat2_' . ($i-20) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 2,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 3
        for ($i = 41; $i <= 60; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat3_' . ($i-40) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 3,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 4
        for ($i = 61; $i <= 80; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat4_' . ($i-60) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 4,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 5
        for ($i = 81; $i <= 100; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat5_' . ($i-80) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 5,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 6
        for ($i = 101; $i <= 120; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat6_' . ($i-100) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 6,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 7
        for ($i = 121; $i <= 140; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat7_' . ($i-120) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 7,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 8
        for ($i = 141; $i <= 160; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat8_' . ($i-140) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 8,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 9
        for ($i = 161; $i <= 180; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat9_' . ($i-160) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 9,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 10
        for ($i = 181; $i <= 200; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat10_' . ($i-180) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 10,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 11
        for ($i = 201; $i <= 220; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat11_' . ($i-200) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 11,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 12
        for ($i = 221; $i <= 240; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat12_' . ($i-220) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 12,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 13
        for ($i = 241; $i <= 260; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat13_' . ($i-240) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 13,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 15
        for ($i = 261; $i <= 280; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat15_' . ($i-260) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 15,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 16
        for ($i = 281; $i <= 300; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat16_' . ($i-280) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 16,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 17
        for ($i = 301; $i <= 320; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat17_' . ($i-300) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 17,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 18
        for ($i = 321; $i <= 340; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat18_' . ($i-320) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 18,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 20
        for ($i = 341; $i <= 360; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat20_' . ($i-340) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 20,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 21
        for ($i = 361; $i <= 380; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat21_' . ($i-360) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 21,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 22
        for ($i = 381; $i <= 400; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat22_' . ($i-380) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 22,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 23
        for ($i = 401; $i <= 420; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat23_' . ($i-400) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 23,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 24
        for ($i = 421; $i <= 440; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat24_' . ($i-420) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 24,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 25
        for ($i = 441; $i <= 460; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat25_' . ($i-440) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 25,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 26
        for ($i = 461; $i <= 480; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat26_' . ($i-460) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 26,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 27
        for ($i = 481; $i <= 500; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat27_' . ($i-480) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 27,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 28
        for ($i = 501; $i <= 520; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat28_' . ($i-500) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 28,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 29
        for ($i = 521; $i <= 540; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat29_' . ($i-520) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 29,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 30
        for ($i = 541; $i <= 560; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat30_' . ($i-540) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 30,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 31
        for ($i = 561; $i <= 580; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat31_' . ($i-560) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 31,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 32
        for ($i = 581; $i <= 600; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat32_' . ($i-580) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 32,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 33
        for ($i = 601; $i <= 620; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat33_' . ($i-600) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 33,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 34
        for ($i = 621; $i <= 640; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat34_' . ($i-620) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 34,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 35
        for ($i = 641; $i <= 660; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat35_' . ($i-640) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 35,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 36
        for ($i = 661; $i <= 680; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat36_' . ($i-660) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 36,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 37
        for ($i = 681; $i <= 700; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat37_' . ($i-680) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 37,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 38
        for ($i = 701; $i <= 720; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat38_' . ($i-700) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 38,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 39
        for ($i = 721; $i <= 740; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat39_' . ($i-720) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 39,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 40
        for ($i = 741; $i <= 760; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat40_' . ($i-740) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 40,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 41
        for ($i = 761; $i <= 780; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat41_' . ($i-760) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 41,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 42
        for ($i = 781; $i <= 800; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat42_' . ($i-780) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 42,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 43
        for ($i = 801; $i <= 820; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat43_' . ($i-800) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 43,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 44
        for ($i = 821; $i <= 840; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat44_' . ($i-820) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 44,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 45
        for ($i = 841; $i <= 860; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat45_' . ($i-840) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 45,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 46
        for ($i = 861; $i <= 880; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat46_' . ($i-860) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 46,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 47
        for ($i = 881; $i <= 900; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat47_' . ($i-880) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 47,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 48
        for ($i = 901; $i <= 920; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat48_' . ($i-900) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 48,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 49
        for ($i = 921; $i <= 940; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat49_' . ($i-920) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 49,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 50
        for ($i = 941; $i <= 960; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat50_' . ($i-940) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 50,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 61
        for ($i = 961; $i <= 980; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat61_' . ($i-960) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 61,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 62
        for ($i = 981; $i <= 1000; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat62_' . ($i-980) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 62,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 63
        for ($i = 1001; $i <= 1020; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat63_' . ($i-1000) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 63,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 64
        for ($i = 1021; $i <= 1040; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat64_' . ($i-1020) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 64,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 65
        for ($i = 1041; $i <= 1060; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat65_' . ($i-1040) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 65,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 66
        for ($i = 1061; $i <= 1080; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat66_' . ($i-1060) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 66,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 67
        for ($i = 1081; $i <= 1100; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat67_' . ($i-1080) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 67,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 68
        for ($i = 1101; $i <= 1120; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat68_' . ($i-1100) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 68,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 69
        for ($i = 1121; $i <= 1140; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat69_' . ($i-1120) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 69,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 70
        for ($i = 1141; $i <= 1160; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat70_' . ($i-1140) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 70,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 51
        for ($i = 1161; $i <= 1180; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat51_' . ($i-1160) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 51,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 52
        for ($i = 1181; $i <= 1200; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat52_' . ($i-1180) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 52,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 53
        for ($i = 1201; $i <= 1220; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat53_' . ($i-1200) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 53,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 54
        for ($i = 1221; $i <= 1240; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat54_' . ($i-1220) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 54,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 55
        for ($i = 1241; $i <= 1260; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat55_' . ($i-1240) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 55,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 56
        for ($i = 1261; $i <= 1280; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat56_' . ($i-1260) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 56,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 57
        for ($i = 1281; $i <= 1300; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat57_' . ($i-1280) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 57,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 58
        for ($i = 1301; $i <= 1320; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat58_' . ($i-1300) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 58,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 59
        for ($i = 1321; $i <= 1340; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat59_' . ($i-1320) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 59,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 60
        for ($i = 1341; $i <= 1360; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat60_' . ($i-1340) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 60,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 71
        for ($i = 1361; $i <= 1380; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat71_' . ($i-1360) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 71,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 72
        for ($i = 1381; $i <= 1400; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat72_' . ($i-1380) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 72,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 73
        for ($i = 1401; $i <= 1420; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat73_' . ($i-1400) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 73,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 74
        for ($i = 1421; $i <= 1440; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat74_' . ($i-1420) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 74,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 75
        for ($i = 1441; $i <= 1460; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat75_' . ($i-1440) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 75,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 76
        for ($i = 1461; $i <= 1480; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat76_' . ($i-1460) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 76,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 77
        for ($i = 1481; $i <= 1500; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat77_' . ($i-1480) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 77,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 78
        for ($i = 1501; $i <= 1520; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat78_' . ($i-1500) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 78,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 79
        for ($i = 1521; $i <= 1540; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat79_' . ($i-1520) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 79,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 80
        for ($i = 1541; $i <= 1560; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat80_' . ($i-1540) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 80,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 81
        for ($i = 1561; $i <= 1580; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat81_' . ($i-1560) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 81,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 82
        for ($i = 1581; $i <= 1600; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat82_' . ($i-1580) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 82,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 83
        for ($i = 1601; $i <= 1620; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat83_' . ($i-1600) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 83,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 84
        for ($i = 1621; $i <= 1640; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat84_' . ($i-1620) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 84,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 85
        for ($i = 1641; $i <= 1660; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat85_' . ($i-1640) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 85,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 86
        for ($i = 1661; $i <= 1680; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat86_' . ($i-1660) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 86,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 87
        for ($i = 1681; $i <= 1700; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat87_' . ($i-1680) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 87,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 88
        for ($i = 1701; $i <= 1720; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat88_' . ($i-1700) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 88,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 89
        for ($i = 1721; $i <= 1740; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat89_' . ($i-1720) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 89,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 90
        for ($i = 1741; $i <= 1760; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat90_' . ($i-1740) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 90,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 91
        for ($i = 1761; $i <= 1780; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat91_' . ($i-1760) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 91,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 92
        for ($i = 1781; $i <= 1800; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat92_' . ($i-1780) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 92,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 93
        for ($i = 1801; $i <= 1820; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat93_' . ($i-1800) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 93,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 94
        for ($i = 1821; $i <= 1840; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat94_' . ($i-1820) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 94,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 95
        for ($i = 1841; $i <= 1860; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat95_' . ($i-1840) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 95,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 96
        for ($i = 1861; $i <= 1880; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat96_' . ($i-1860) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 96,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 97
        for ($i = 1881; $i <= 1900; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat97_' . ($i-1880) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 97,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 98
        for ($i = 1901; $i <= 1920; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat98_' . ($i-1900) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 98,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 99
        for ($i = 1921; $i <= 1940; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat99_' . ($i-1920) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 99,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 100
        for ($i = 1941; $i <= 1960; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat100_' . ($i-1940) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 100,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 101
        for ($i = 1961; $i <= 1980; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat101_' . ($i-1960) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 101,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 102
        for ($i = 1981; $i <= 2000; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat102_' . ($i-1980) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 102,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 103
        for ($i = 2001; $i <= 2020; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat103_' . ($i-2000) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 103,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 104
        for ($i = 2021; $i <= 2040; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat104_' . ($i-2020) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 104,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 105
        for ($i = 2041; $i <= 2060; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat105_' . ($i-2040) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 105,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 106
        for ($i = 2061; $i <= 2080; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat106_' . ($i-2060) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 106,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 107
        for ($i = 2081; $i <= 2100; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat107_' . ($i-2080) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 107,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 108
        for ($i = 2101; $i <= 2120; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat108_' . ($i-2100) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 108,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 109
        for ($i = 2121; $i <= 2140; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat109_' . ($i-2120) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 109,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 110
        for ($i = 2141; $i <= 2160; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat110_' . ($i-2140) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 110,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 111
        for ($i = 2161; $i <= 2180; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat111_' . ($i-2160) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 111,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 112
        for ($i = 2181; $i <= 2200; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat112_' . ($i-2180) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 112,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 113
        for ($i = 2201; $i <= 2220; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat113_' . ($i-2200) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 113,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 114
        for ($i = 2221; $i <= 2240; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat114_' . ($i-2220) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 114,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 115
        for ($i = 2241; $i <= 2260; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat115_' . ($i-2240) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 115,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 116
        for ($i = 2261; $i <= 2280; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat116_' . ($i-2260) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 116,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 117
        for ($i = 2281; $i <= 2300; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat117_' . ($i-2280) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 117,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 118
        for ($i = 2301; $i <= 2320; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat118_' . ($i-2300) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 118,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 119
        for ($i = 2321; $i <= 2340; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat119_' . ($i-2320) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 119,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 120
        for ($i = 2341; $i <= 2360; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat120_' . ($i-2340) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 120,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 121
        for ($i = 2361; $i <= 2380; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat121_' . ($i-2360) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 121,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 122
        for ($i = 2381; $i <= 2400; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat122_' . ($i-2380) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 122,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 123
        for ($i = 2401; $i <= 2420; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat123_' . ($i-2400) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 123,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 124
        for ($i = 2421; $i <= 2440; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat124_' . ($i-2420) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 124,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 125
        for ($i = 2441; $i <= 2460; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat125_' . ($i-2440) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 125,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 126
        for ($i = 2461; $i <= 2480; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat126_' . ($i-2460) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 126,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 127
        for ($i = 2481; $i <= 2500; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat127_' . ($i-2480) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 127,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 128
        for ($i = 2501; $i <= 2520; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat128_' . ($i-2500) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 128,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 129
        for ($i = 2521; $i <= 2540; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat129_' . ($i-2520) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 129,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 130
        for ($i = 2541; $i <= 2560; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat130_' . ($i-2540) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 130,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 131
        for ($i = 2561; $i <= 2580; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat131_' . ($i-2560) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 131,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 132
        for ($i = 2581; $i <= 2600; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat132_' . ($i-2580) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 132,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 133
        for ($i = 2601; $i <= 2620; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat133_' . ($i-2600) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 133,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 134
        for ($i = 2621; $i <= 2640; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat134_' . ($i-2620) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 134,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 135
        for ($i = 2641; $i <= 2660; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat135_' . ($i-2640) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 135,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 136
        for ($i = 2661; $i <= 2680; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat136_' . ($i-2660) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 136,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 137
        for ($i = 2681; $i <= 2700; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat137_' . ($i-2680) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 137,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 138
        for ($i = 2701; $i <= 2720; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat138_' . ($i-2700) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 138,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 139
        for ($i = 2721; $i <= 2740; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat139_' . ($i-2720) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 139,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Crear 20 estudiantes con category_id = 140
        for ($i = 2741; $i <= 2760; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat140_' . ($i-2740) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 140,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }
        for ($i = 2761; $i <= 2780; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat140_' . ($i-2740) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 141,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }
        for ($i = 2781; $i <= 2800; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat140_' . ($i-2740) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 142,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Categoría 143
        for ($i = 2801; $i <= 2820; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat143_' . ($i-2800) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 143,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Categoría 144
        for ($i = 2821; $i <= 2840; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat144_' . ($i-2820) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 144,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }

        // Categoría 145
        for ($i = 2841; $i <= 2860; $i++) {
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
            $ciudad = $ciudades[array_rand($ciudades)];
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            User::create([
                'nombre' => $nombre,
                'email' => 'estudiante_cat145_' . ($i-2840) . '@educacion.es',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'category_id' => 145,
                'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                'ciudad' => $ciudad,
                'dni' => $dni,
                'activo' => true,
                'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                'imagen' => $i . '.jpg'
            ]);
        }
        
        // Continuando con el resto de categorías...
        // Categorías 146 a 210
        for ($categoria = 146; $categoria <= 210; $categoria++) {
            $inicio = 2800 + ($categoria - 142) * 20 + 1;
            $fin = $inicio + 19;
            
            for ($i = $inicio; $i <= $fin; $i++) {
                $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)] . ' ' . $apellidos[array_rand($apellidos)];
                $ciudad = $ciudades[array_rand($ciudades)];
                $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
                
                User::create([
                    'nombre' => $nombre,
                    'email' => 'estudiante_cat' . $categoria . '_' . ($i - ($inicio - 1)) . '@educacion.es',
                    'password' => Hash::make('password'),
                    'role_id' => 3,
                    'category_id' => $categoria,
                    'fecha_nacimiento' => now()->subYears(rand(18, 25)),
                    'ciudad' => $ciudad,
                    'dni' => $dni,
                    'activo' => true,
                    'telefono' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                    'descripcion' => 'Estudiante de ' . fake()->randomElement(['Desarrollo Web', 'Desarrollo Móvil', 'Administración de Sistemas', 'Marketing Digital', 'Diseño Gráfico']) . 
                                    ' con interés en ' . fake()->randomElement(['desarrollo frontend', 'desarrollo backend', 'ciberseguridad', 'inteligencia artificial', 'marketing digital', 'diseño UI/UX']) . '.',
                    'imagen' => $i . '.jpg'
                ]);
            }
        }
    }
}
