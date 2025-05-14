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
    }
}
