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
        $estudiantes = [
            // IES Juan de la Cierva
            [
                'nombre' => 'Carlos Rodríguez Martínez',
                'email' => 'estudiante1.juancierva@educacion.es',
                'fecha_nacimiento' => '2000-05-15',
                'ciudad' => 'Madrid',
                'dni' => '12345678Z',
                'telefono' => '611222333',
                'descripcion' => 'Estudiante de Desarrollo Web Full Stack con experiencia en React y Laravel.',
                'imagen' => 'carlos_rodriguez.jpg',
                'institucion' => 'IES Juan de la Cierva'
            ],
            [
                'nombre' => 'Laura Sánchez García',
                'email' => 'estudiante2.juancierva@educacion.es',
                'fecha_nacimiento' => '2001-03-22',
                'ciudad' => 'Madrid',
                'dni' => '23456789Y',
                'telefono' => '622333444',
                'descripcion' => 'Estudiante de Desarrollo Web especializada en diseño UI/UX.',
                'imagen' => 'laura_sanchez.jpg',
                'institucion' => 'IES Juan de la Cierva'
            ],
            [
                'nombre' => 'Roberto Fernández Ruiz',
                'email' => 'estudiante3.juancierva@educacion.es',
                'fecha_nacimiento' => '2000-08-30',
                'ciudad' => 'Madrid',
                'dni' => '34567890A',
                'telefono' => '633444555',
                'descripcion' => 'Estudiante de Desarrollo de Aplicaciones Multiplataforma.',
                'imagen' => 'roberto_fernandez.jpg',
                'institucion' => 'IES Juan de la Cierva'
            ],
            [
                'nombre' => 'Marina López Castro',
                'email' => 'estudiante4.juancierva@educacion.es',
                'fecha_nacimiento' => '2001-02-14',
                'ciudad' => 'Madrid',
                'dni' => '45678901B',
                'telefono' => '644555666',
                'descripcion' => 'Estudiante de Desarrollo Web con enfoque en backend.',
                'imagen' => 'marina_lopez.jpg',
                'institucion' => 'IES Juan de la Cierva'
            ],
            [
                'nombre' => 'Diego Martín Santos',
                'email' => 'estudiante5.juancierva@educacion.es',
                'fecha_nacimiento' => '2000-11-08',
                'ciudad' => 'Madrid',
                'dni' => '56789012C',
                'telefono' => '655666777',
                'descripcion' => 'Estudiante de Ciberseguridad y Redes.',
                'imagen' => 'diego_martin.jpg',
                'institucion' => 'IES Juan de la Cierva'
            ],
            
            // IES Mare Nostrum
            [
                'nombre' => 'Miguel Ángel López Navarro',
                'email' => 'estudiante1.marenostrum@educacion.es',
                'fecha_nacimiento' => '2000-08-10',
                'ciudad' => 'Alicante',
                'dni' => '67890123D',
                'telefono' => '666777888',
                'descripcion' => 'Estudiante de Ciberseguridad con conocimientos en ethical hacking.',
                'imagen' => 'miguel_lopez.jpg',
                'institucion' => 'IES Mare Nostrum'
            ],
            [
                'nombre' => 'Sofía Martín Pérez',
                'email' => 'estudiante2.marenostrum@educacion.es',
                'fecha_nacimiento' => '2001-11-05',
                'ciudad' => 'Alicante',
                'dni' => '78901234E',
                'telefono' => '677888999',
                'descripcion' => 'Estudiante de Marketing Digital especializada en SEO/SEM.',
                'imagen' => 'sofia_martin.jpg',
                'institucion' => 'IES Mare Nostrum'
            ],
            [
                'nombre' => 'Pablo García Ruiz',
                'email' => 'estudiante3.marenostrum@educacion.es',
                'fecha_nacimiento' => '2000-07-20',
                'ciudad' => 'Alicante',
                'dni' => '89012345F',
                'telefono' => '688999000',
                'descripcion' => 'Estudiante de Desarrollo de Aplicaciones Web.',
                'imagen' => 'pablo_garcia.jpg',
                'institucion' => 'IES Mare Nostrum'
            ],
            [
                'nombre' => 'Ana Belén Torres Mora',
                'email' => 'estudiante4.marenostrum@educacion.es',
                'fecha_nacimiento' => '2001-04-15',
                'ciudad' => 'Alicante',
                'dni' => '90123456G',
                'telefono' => '699000111',
                'descripcion' => 'Estudiante de Desarrollo Frontend con React.',
                'imagen' => 'ana_torres.jpg',
                'institucion' => 'IES Mare Nostrum'
            ],
            [
                'nombre' => 'Jorge Navarro Sanz',
                'email' => 'estudiante5.marenostrum@educacion.es',
                'fecha_nacimiento' => '2000-12-03',
                'ciudad' => 'Alicante',
                'dni' => '01234567H',
                'telefono' => '600111222',
                'descripcion' => 'Estudiante de Desarrollo Backend con Node.js.',
                'imagen' => 'jorge_navarro.jpg',
                'institucion' => 'IES Mare Nostrum'
            ],

            // IES Politécnico
            [
                'nombre' => 'David González Ruiz',
                'email' => 'estudiante1.politecnico@educacion.es',
                'fecha_nacimiento' => '2000-07-20',
                'ciudad' => 'Barcelona',
                'dni' => '12345678I',
                'telefono' => '611222334',
                'descripcion' => 'Estudiante de Desarrollo Móvil con experiencia en Flutter y React Native.',
                'imagen' => 'david_gonzalez.jpg',
                'institucion' => 'IES Politécnico'
            ],
            [
                'nombre' => 'Lucía Fernández Torres',
                'email' => 'estudiante2.politecnico@educacion.es',
                'fecha_nacimiento' => '2001-04-15',
                'ciudad' => 'Barcelona',
                'dni' => '23456789J',
                'telefono' => '622333445',
                'descripcion' => 'Estudiante de Inteligencia Artificial y Machine Learning.',
                'imagen' => 'lucia_fernandez.jpg',
                'institucion' => 'IES Politécnico'
            ],
            [
                'nombre' => 'Marcos Vidal Serra',
                'email' => 'estudiante3.politecnico@educacion.es',
                'fecha_nacimiento' => '2000-09-28',
                'ciudad' => 'Barcelona',
                'dni' => '34567890K',
                'telefono' => '633444556',
                'descripcion' => 'Estudiante de Desarrollo Full Stack con MERN.',
                'imagen' => 'marcos_vidal.jpg',
                'institucion' => 'IES Politécnico'
            ],
            [
                'nombre' => 'Andrea Costa Puig',
                'email' => 'estudiante4.politecnico@educacion.es',
                'fecha_nacimiento' => '2001-06-12',
                'ciudad' => 'Barcelona',
                'dni' => '45678901L',
                'telefono' => '644555667',
                'descripcion' => 'Estudiante de Desarrollo de Aplicaciones Móviles con iOS.',
                'imagen' => 'andrea_costa.jpg',
                'institucion' => 'IES Politécnico'
            ],
            [
                'nombre' => 'Xavier Prat Font',
                'email' => 'estudiante5.politecnico@educacion.es',
                'fecha_nacimiento' => '2000-03-25',
                'ciudad' => 'Barcelona',
                'dni' => '56789012M',
                'telefono' => '655666778',
                'descripcion' => 'Estudiante de DevOps y Cloud Computing.',
                'imagen' => 'xavier_prat.jpg',
                'institucion' => 'IES Politécnico'
            ],

            // IES Leonardo da Vinci
            [
                'nombre' => 'Pablo Jiménez Castro',
                'email' => 'estudiante1.leonardodavinci@educacion.es',
                'fecha_nacimiento' => '2000-09-30',
                'ciudad' => 'Valencia',
                'dni' => '67890123N',
                'telefono' => '666777889',
                'descripcion' => 'Estudiante de Desarrollo Backend con experiencia en Node.js y Python.',
                'imagen' => 'pablo_jimenez.jpg',
                'institucion' => 'IES Leonardo da Vinci'
            ],
            [
                'nombre' => 'María Torres Vega',
                'email' => 'estudiante2.leonardodavinci@educacion.es',
                'fecha_nacimiento' => '2001-06-25',
                'ciudad' => 'Valencia',
                'dni' => '78901234O',
                'telefono' => '677888990',
                'descripcion' => 'Estudiante de Diseño Gráfico y Desarrollo Frontend.',
                'imagen' => 'maria_torres.jpg',
                'institucion' => 'IES Leonardo da Vinci'
            ],
            [
                'nombre' => 'Alejandro Romero Gil',
                'email' => 'estudiante3.leonardodavinci@educacion.es',
                'fecha_nacimiento' => '2000-10-15',
                'ciudad' => 'Valencia',
                'dni' => '89012345P',
                'telefono' => '688999001',
                'descripcion' => 'Estudiante de Desarrollo de Aplicaciones Multiplataforma.',
                'imagen' => 'alejandro_romero.jpg',
                'institucion' => 'IES Leonardo da Vinci'
            ],
            [
                'nombre' => 'Isabel Moreno Sáez',
                'email' => 'estudiante4.leonardodavinci@educacion.es',
                'fecha_nacimiento' => '2001-07-08',
                'ciudad' => 'Valencia',
                'dni' => '90123456Q',
                'telefono' => '699000112',
                'descripcion' => 'Estudiante de Marketing Digital y SEO.',
                'imagen' => 'isabel_moreno.jpg',
                'institucion' => 'IES Leonardo da Vinci'
            ],
            [
                'nombre' => 'Víctor Navarro Costa',
                'email' => 'estudiante5.leonardodavinci@educacion.es',
                'fecha_nacimiento' => '2000-12-20',
                'ciudad' => 'Valencia',
                'dni' => '01234567R',
                'telefono' => '600111223',
                'descripcion' => 'Estudiante de Desarrollo Web Full Stack.',
                'imagen' => 'victor_navarro.jpg',
                'institucion' => 'IES Leonardo da Vinci'
            ],

            // IES Virgen de la Paloma
            [
                'nombre' => 'Javier Moreno Silva',
                'email' => 'estudiante1.virgendelapaloma@educacion.es',
                'fecha_nacimiento' => '2000-12-12',
                'ciudad' => 'Madrid',
                'dni' => '12345678S',
                'telefono' => '611222335',
                'descripcion' => 'Estudiante de Administración de Sistemas Cloud.',
                'imagen' => 'javier_moreno.jpg',
                'institucion' => 'IES Virgen de la Paloma'
            ],
            [
                'nombre' => 'Elena Díaz Romero',
                'email' => 'estudiante2.virgendelapaloma@educacion.es',
                'fecha_nacimiento' => '2001-01-18',
                'ciudad' => 'Madrid',
                'dni' => '23456789T',
                'telefono' => '622333446',
                'descripcion' => 'Estudiante de Desarrollo de Aplicaciones Multiplataforma.',
                'imagen' => 'elena_diaz.jpg',
                'institucion' => 'IES Virgen de la Paloma'
            ],
            [
                'nombre' => 'Alberto Sanz Martín',
                'email' => 'estudiante3.virgendelapaloma@educacion.es',
                'fecha_nacimiento' => '2000-05-30',
                'ciudad' => 'Madrid',
                'dni' => '34567890U',
                'telefono' => '633444557',
                'descripcion' => 'Estudiante de Desarrollo de Videojuegos.',
                'imagen' => 'alberto_sanz.jpg',
                'institucion' => 'IES Virgen de la Paloma'
            ],
            [
                'nombre' => 'Carmen Ortiz Vega',
                'email' => 'estudiante4.virgendelapaloma@educacion.es',
                'fecha_nacimiento' => '2001-03-15',
                'ciudad' => 'Madrid',
                'dni' => '45678901V',
                'telefono' => '644555668',
                'descripcion' => 'Estudiante de Inteligencia Artificial.',
                'imagen' => 'carmen_ortiz.jpg',
                'institucion' => 'IES Virgen de la Paloma'
            ],
            [
                'nombre' => 'Hugo Martínez Ruiz',
                'email' => 'estudiante5.virgendelapaloma@educacion.es',
                'fecha_nacimiento' => '2000-08-22',
                'ciudad' => 'Madrid',
                'dni' => '56789012W',
                'telefono' => '655666779',
                'descripcion' => 'Estudiante de Ciberseguridad y Ethical Hacking.',
                'imagen' => 'hugo_martinez.jpg',
                'institucion' => 'IES Virgen de la Paloma'
            ],

            // IES El Caminàs
            [
                'nombre' => 'Daniel Muñoz Ortiz',
                'email' => 'estudiante1.elcaminas@educacion.es',
                'fecha_nacimiento' => '2000-02-28',
                'ciudad' => 'Castellón',
                'dni' => '67890123X',
                'telefono' => '666777890',
                'descripcion' => 'Estudiante de Desarrollo de Videojuegos.',
                'imagen' => 'daniel_munoz.jpg',
                'institucion' => 'IES El Caminàs'
            ],
            [
                'nombre' => 'Paula Herrera Blanco',
                'email' => 'estudiante2.elcaminas@educacion.es',
                'fecha_nacimiento' => '2001-07-08',
                'ciudad' => 'Castellón',
                'dni' => '78901234Y',
                'telefono' => '677888991',
                'descripcion' => 'Estudiante de Desarrollo Web y Diseño UX/UI.',
                'imagen' => 'paula_herrera.jpg',
                'institucion' => 'IES El Caminàs'
            ],
            [
                'nombre' => 'Fernando Gil Torres',
                'email' => 'estudiante3.elcaminas@educacion.es',
                'fecha_nacimiento' => '2000-11-14',
                'ciudad' => 'Castellón',
                'dni' => '89012345Z',
                'telefono' => '688999002',
                'descripcion' => 'Estudiante de Desarrollo de Aplicaciones Móviles.',
                'imagen' => 'fernando_gil.jpg',
                'institucion' => 'IES El Caminàs'
            ],
            [
                'nombre' => 'Lucía Vidal Ramos',
                'email' => 'estudiante4.elcaminas@educacion.es',
                'fecha_nacimiento' => '2001-09-03',
                'ciudad' => 'Castellón',
                'dni' => '90123456A',
                'telefono' => '699000113',
                'descripcion' => 'Estudiante de Marketing Digital y Comercio Electrónico.',
                'imagen' => 'lucia_vidal.jpg',
                'institucion' => 'IES El Caminàs'
            ],
            [
                'nombre' => 'Mario Soler Prats',
                'email' => 'estudiante5.elcaminas@educacion.es',
                'fecha_nacimiento' => '2000-04-17',
                'ciudad' => 'Castellón',
                'dni' => '01234567B',
                'telefono' => '600111224',
                'descripcion' => 'Estudiante de Desarrollo Full Stack con Java.',
                'imagen' => 'mario_soler.jpg',
                'institucion' => 'IES El Caminàs'
            ],

            // IES Castelar
            [
                'nombre' => 'Adrián Castro López',
                'email' => 'estudiante1.castelar@educacion.es',
                'fecha_nacimiento' => '2000-10-05',
                'ciudad' => 'Badajoz',
                'dni' => '12345678C',
                'telefono' => '611222336',
                'descripcion' => 'Estudiante de Desarrollo de Aplicaciones Web.',
                'imagen' => 'adrian_castro.jpg',
                'institucion' => 'IES Castelar'
            ],
            [
                'nombre' => 'Clara Ramos Soto',
                'email' => 'estudiante2.castelar@educacion.es',
                'fecha_nacimiento' => '2001-09-15',
                'ciudad' => 'Badajoz',
                'dni' => '23456789D',
                'telefono' => '622333447',
                'descripcion' => 'Estudiante de Marketing Digital y Comercio Electrónico.',
                'imagen' => 'clara_ramos.jpg',
                'institucion' => 'IES Castelar'
            ],
            [
                'nombre' => 'Raúl Flores Mora',
                'email' => 'estudiante3.castelar@educacion.es',
                'fecha_nacimiento' => '2000-06-28',
                'ciudad' => 'Badajoz',
                'dni' => '34567890E',
                'telefono' => '633444558',
                'descripcion' => 'Estudiante de Desarrollo Backend con Python.',
                'imagen' => 'raul_flores.jpg',
                'institucion' => 'IES Castelar'
            ],
            [
                'nombre' => 'Nuria Santos Gil',
                'email' => 'estudiante4.castelar@educacion.es',
                'fecha_nacimiento' => '2001-05-12',
                'ciudad' => 'Badajoz',
                'dni' => '45678901F',
                'telefono' => '644555669',
                'descripcion' => 'Estudiante de Desarrollo Frontend con Angular.',
                'imagen' => 'nuria_santos.jpg',
                'institucion' => 'IES Castelar'
            ],
            [
                'nombre' => 'Óscar Vargas Ruiz',
                'email' => 'estudiante5.castelar@educacion.es',
                'fecha_nacimiento' => '2000-03-20',
                'ciudad' => 'Badajoz',
                'dni' => '56789012G',
                'telefono' => '655666780',
                'descripcion' => 'Estudiante de DevOps y Cloud Computing.',
                'imagen' => 'oscar_vargas.jpg',
                'institucion' => 'IES Castelar'
            ],

            // IES Zaidín-Vergeles
            [
                'nombre' => 'Álvaro Medina Ruiz',
                'email' => 'estudiante1.zaidinvergeles@educacion.es',
                'fecha_nacimiento' => '2000-04-20',
                'ciudad' => 'Granada',
                'dni' => '67890123H',
                'telefono' => '666777891',
                'descripcion' => 'Estudiante de Desarrollo Frontend con React.',
                'imagen' => 'alvaro_medina.jpg',
                'institucion' => 'IES Zaidín-Vergeles'
            ],
            [
                'nombre' => 'Carmen Ortega Vidal',
                'email' => 'estudiante2.zaidinvergeles@educacion.es',
                'fecha_nacimiento' => '2001-08-30',
                'ciudad' => 'Granada',
                'dni' => '78901234I',
                'telefono' => '677888992',
                'descripcion' => 'Estudiante de Desarrollo Backend con Java y Spring.',
                'imagen' => 'carmen_ortega.jpg',
                'institucion' => 'IES Zaidín-Vergeles'
            ],
            [
                'nombre' => 'Antonio Ruiz Mora',
                'email' => 'estudiante3.zaidinvergeles@educacion.es',
                'fecha_nacimiento' => '2000-07-15',
                'ciudad' => 'Granada',
                'dni' => '89012345J',
                'telefono' => '688999003',
                'descripcion' => 'Estudiante de Desarrollo de Aplicaciones Móviles.',
                'imagen' => 'antonio_ruiz.jpg',
                'institucion' => 'IES Zaidín-Vergeles'
            ],
            [
                'nombre' => 'Beatriz López Castro',
                'email' => 'estudiante4.zaidinvergeles@educacion.es',
                'fecha_nacimiento' => '2001-02-28',
                'ciudad' => 'Granada',
                'dni' => '90123456K',
                'telefono' => '699000114',
                'descripcion' => 'Estudiante de Diseño UX/UI y Frontend.',
                'imagen' => 'beatriz_lopez.jpg',
                'institucion' => 'IES Zaidín-Vergeles'
            ],
            [
                'nombre' => 'Manuel Torres Gil',
                'email' => 'estudiante5.zaidinvergeles@educacion.es',
                'fecha_nacimiento' => '2000-11-10',
                'ciudad' => 'Granada',
                'dni' => '01234567L',
                'telefono' => '600111225',
                'descripcion' => 'Estudiante de Ciberseguridad y Redes.',
                'imagen' => 'manuel_torres.jpg',
                'institucion' => 'IES Zaidín-Vergeles'
            ],

            // IES Nicolau Copèrnic
            [
                'nombre' => 'Rubén Santos Gil',
                'email' => 'estudiante1.nicolascopernic@educacion.es',
                'fecha_nacimiento' => '2000-06-12',
                'ciudad' => 'Terrassa',
                'dni' => '12345678M',
                'telefono' => '611222337',
                'descripcion' => 'Estudiante de DevOps y Cloud Computing.',
                'imagen' => 'ruben_santos.jpg',
                'institucion' => 'IES Nicolau Copèrnic'
            ],
            [
                'nombre' => 'Sara Vargas Molina',
                'email' => 'estudiante2.nicolascopernic@educacion.es',
                'fecha_nacimiento' => '2001-12-03',
                'ciudad' => 'Terrassa',
                'dni' => '23456789N',
                'telefono' => '622333448',
                'descripcion' => 'Estudiante de Desarrollo Full Stack MERN.',
                'imagen' => 'sara_vargas.jpg',
                'institucion' => 'IES Nicolau Copèrnic'
            ],
            [
                'nombre' => 'Marc Puig Costa',
                'email' => 'estudiante3.nicolascopernic@educacion.es',
                'fecha_nacimiento' => '2000-09-18',
                'ciudad' => 'Terrassa',
                'dni' => '34567890O',
                'telefono' => '633444559',
                'descripcion' => 'Estudiante de Desarrollo de Aplicaciones Móviles.',
                'imagen' => 'marc_puig.jpg',
                'institucion' => 'IES Nicolau Copèrnic'
            ],
            [
                'nombre' => 'Julia Serra Font',
                'email' => 'estudiante4.nicolascopernic@educacion.es',
                'fecha_nacimiento' => '2001-04-25',
                'ciudad' => 'Terrassa',
                'dni' => '45678901P',
                'telefono' => '644555670',
                'descripcion' => 'Estudiante de Diseño Web y UX/UI.',
                'imagen' => 'julia_serra.jpg',
                'institucion' => 'IES Nicolau Copèrnic'
            ],
            [
                'nombre' => 'Gerard Costa Vidal',
                'email' => 'estudiante5.nicolascopernic@educacion.es',
                'fecha_nacimiento' => '2000-07-30',
                'ciudad' => 'Terrassa',
                'dni' => '56789012Q',
                'telefono' => '655666781',
                'descripcion' => 'Estudiante de Inteligencia Artificial y Machine Learning.',
                'imagen' => 'gerard_costa.jpg',
                'institucion' => 'IES Nicolau Copèrnic'
            ],

            // IES Ingeniero de la Cierva
            [
                'nombre' => 'Iván Flores Parra',
                'email' => 'estudiante1.ingenierodacierva@educacion.es',
                'fecha_nacimiento' => '2000-03-25',
                'ciudad' => 'Murcia',
                'dni' => '67890123R',
                'telefono' => '666777892',
                'descripcion' => 'Estudiante de Ciberseguridad y Redes.',
                'imagen' => 'ivan_flores.jpg',
                'institucion' => 'IES Ingeniero de la Cierva'
            ],
            [
                'nombre' => 'Natalia Cruz Reyes',
                'email' => 'estudiante2.ingenierodacierva@educacion.es',
                'fecha_nacimiento' => '2001-05-28',
                'ciudad' => 'Murcia',
                'dni' => '78901234S',
                'telefono' => '677888993',
                'descripcion' => 'Estudiante de Desarrollo de Aplicaciones Móviles.',
                'imagen' => 'natalia_cruz.jpg',
                'institucion' => 'IES Ingeniero de la Cierva'
            ],
            [
                'nombre' => 'Francisco Martínez Soto',
                'email' => 'estudiante3.ingenierodacierva@educacion.es',
                'fecha_nacimiento' => '2000-08-14',
                'ciudad' => 'Murcia',
                'dni' => '89012345T',
                'telefono' => '688999004',
                'descripcion' => 'Estudiante de Desarrollo Web Full Stack.',
                'imagen' => 'francisco_martinez.jpg',
                'institucion' => 'IES Ingeniero de la Cierva'
            ],
            [
                'nombre' => 'Marina Sánchez López',
                'email' => 'estudiante4.ingenierodacierva@educacion.es',
                'fecha_nacimiento' => '2001-01-20',
                'ciudad' => 'Murcia',
                'dni' => '90123456U',
                'telefono' => '699000115',
                'descripcion' => 'Estudiante de Marketing Digital y SEO.',
                'imagen' => 'marina_sanchez.jpg',
                'institucion' => 'IES Ingeniero de la Cierva'
            ],
            [
                'nombre' => 'Jorge Ruiz Martínez',
                'email' => 'estudiante5.ingenierodacierva@educacion.es',
                'fecha_nacimiento' => '2000-10-05',
                'ciudad' => 'Murcia',
                'dni' => '01234567V',
                'telefono' => '600111226',
                'descripcion' => 'Estudiante de Desarrollo Backend con Python y Django.',
                'imagen' => 'jorge_ruiz.jpg',
                'institucion' => 'IES Ingeniero de la Cierva'
            ]
        ];

        foreach ($estudiantes as $estudiante) {
            User::create([
                'nombre' => $estudiante['nombre'],
                'email' => $estudiante['email'],
                'password' => Hash::make('password'),
                'role_id' => 3,
                'fecha_nacimiento' => $estudiante['fecha_nacimiento'],
                'ciudad' => $estudiante['ciudad'],
                'dni' => $estudiante['dni'],
                'activo' => true,
                'telefono' => $estudiante['telefono'],
                'descripcion' => $estudiante['descripcion'],
                'imagen' => $estudiante['imagen']
            ]);
        }
    }
}