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
        // Creamos el usuario administrador
        User::create([
            'nombre' => 'Administrador',
            'email' => 'admin@nextgen.es',
            'password' => Hash::make('password'),
            'fecha_nacimiento' => '1990-01-01',
            'ciudad' => 'Madrid',
            'dni' => '12345678A',
            'activo' => true,
            'telefono' => '600000000',
            'descripcion' => 'Administrador principal del sistema NextGen',
            'imagen' => 'admin_profile.jpg',
            'banner' => 'admin_banner.jpg',
            'visibilidad' => true,
            'role_id' => 1,
            'remember_token' => Str::random(10),
            'lat' => 40.4167,
            'lng' => -3.7037,
            'direccion' => 'Calle Gran Vía 28, Madrid'
        ]);

        // Empresas (10 empresas reales)
        $empresas = [
            [
                'nombre' => 'Telefónica España',
                'email' => 'rrhh@telefonica.es',
                'ciudad' => 'Madrid',
                'telefono' => '910000001',
                'descripcion' => 'Empresa líder en telecomunicaciones con programas de formación para estudiantes',
                'dni' => 'A82018474',
                'lat' => 40.4380,
                'lng' => -3.6589,
                'direccion' => 'Gran Vía 28, Madrid'
            ],
            [
                'nombre' => 'BBVA Tech',
                'email' => 'talento@bbvatech.com',
                'ciudad' => 'Madrid',
                'telefono' => '910000002',
                'descripcion' => 'Departamento tecnológico del banco BBVA, especializado en IA y desarrollo web',
                'dni' => 'A48265169',
                'lat' => 40.4505,
                'lng' => -3.6922,
                'direccion' => 'Plaza San Nicolás, 4, Bilbao'
            ],
            [
                'nombre' => 'Indra Sistemas',
                'email' => 'seleccion@indra.es',
                'ciudad' => 'Madrid',
                'telefono' => '910000003',
                'descripcion' => 'Multinacional de consultoría y tecnología con programas de captación de talento joven',
                'dni' => 'A28599033',
                'lat' => 40.5148,
                'lng' => -3.8896,
                'direccion' => 'Avenida de Bruselas 35, Alcobendas'
            ],
            [
                'nombre' => 'Mercadona IT',
                'email' => 'itmercadona@mercadona.es',
                'ciudad' => 'Valencia',
                'telefono' => '960000004',
                'descripcion' => 'Departamento de tecnología de Mercadona, en expansión y con numerosas vacantes',
                'dni' => 'B46771680',
                'lat' => 39.4697,
                'lng' => -0.3774,
                'direccion' => 'Calle Valencia 5, Tavernes Blanques'
            ],
            [
                'nombre' => 'CaixaBank Tech',
                'email' => 'tech@caixabank.com',
                'ciudad' => 'Barcelona',
                'telefono' => '930000005',
                'descripcion' => 'Área tecnológica de CaixaBank, trabajando en soluciones financieras digitales',
                'dni' => 'A08663619',
                'lat' => 41.3887,
                'lng' => 2.1589,
                'direccion' => 'Av. Diagonal, 621, Barcelona'
            ],
            [
                'nombre' => 'Iberdrola Digital',
                'email' => 'digital@iberdrola.es',
                'ciudad' => 'Bilbao',
                'telefono' => '940000006',
                'descripcion' => 'División digital de Iberdrola, dedicada a la transformación energética sostenible',
                'dni' => 'A48010615',
                'lat' => 43.2630,
                'lng' => -2.9350,
                'direccion' => 'Plaza Euskadi 5, Bilbao'
            ],
            [
                'nombre' => 'Inditex IT',
                'email' => 'it@inditex.com',
                'ciudad' => 'A Coruña',
                'telefono' => '981000007',
                'descripcion' => 'Equipos tecnológicos del grupo Inditex, trabajando en e-commerce y tecnología retail',
                'dni' => 'A15075062',
                'lat' => 43.3719,
                'lng' => -8.4363,
                'direccion' => 'Av. de la Diputación, Arteixo'
            ],
            [
                'nombre' => 'Repsol Digital',
                'email' => 'digital@repsol.com',
                'ciudad' => 'Madrid',
                'telefono' => '910000008',
                'descripcion' => 'Hub digital de Repsol, impulsando la transformación hacia la energía sostenible',
                'dni' => 'A78374725',
                'lat' => 40.4588,
                'lng' => -3.6893,
                'direccion' => 'Calle Méndez Álvaro 44, Madrid'
            ],
            [
                'nombre' => 'Mapfre Tech',
                'email' => 'innovacion@mapfre.com',
                'ciudad' => 'Majadahonda',
                'telefono' => '910000009',
                'descripcion' => 'Centro de innovación tecnológica de Mapfre, especializado en insurtech',
                'dni' => 'A28141935',
                'lat' => 40.4722,
                'lng' => -3.8711,
                'direccion' => 'Carretera de Pozuelo, 52, Majadahonda'
            ],
            [
                'nombre' => 'Naturgy Innovación',
                'email' => 'innovacion@naturgy.com',
                'ciudad' => 'Barcelona',
                'telefono' => '930000010',
                'descripcion' => 'Hub de innovación de Naturgy, centrado en soluciones energéticas del futuro',
                'dni' => 'A08015497',
                'lat' => 41.3968,
                'lng' => 2.1976,
                'direccion' => 'Plaza del Gas, 1, Barcelona'
            ],
        ];

        foreach ($empresas as $empresa) {
            User::create([
                'nombre' => $empresa['nombre'],
                'email' => $empresa['email'],
                'password' => Hash::make('password'),
                'fecha_nacimiento' => '1990-01-01',
                'ciudad' => $empresa['ciudad'],
                'dni' => $empresa['dni'],
                'activo' => true,
                'telefono' => $empresa['telefono'],
                'descripcion' => $empresa['descripcion'],
                'imagen' => 'empresa_' . strtolower(preg_replace('/\s+/', '_', $empresa['nombre'])) . '.jpg',
                'banner' => 'banner_' . strtolower(preg_replace('/\s+/', '_', $empresa['nombre'])) . '.jpg',
                'visibilidad' => true,
                'role_id' => 2, // Rol de empresa
                'remember_token' => Str::random(10),
                'lat' => $empresa['lat'],
                'lng' => $empresa['lng'],
                'direccion' => $empresa['direccion']
            ]);
        }

        // Estudiantes (20 estudiantes ficticios)
        $estudiantes = [
            ['nombre' => 'Carlos Martínez', 'email' => 'carlos.martinez@alumno.es', 'ciudad' => 'Madrid', 'especialidad' => 'Desarrollo Web'],
            ['nombre' => 'Laura Gómez', 'email' => 'laura.gomez@alumno.es', 'ciudad' => 'Barcelona', 'especialidad' => 'Desarrollo de Aplicaciones Móviles'],
            ['nombre' => 'David Sánchez', 'email' => 'david.sanchez@alumno.es', 'ciudad' => 'Valencia', 'especialidad' => 'Administración de Sistemas'],
            ['nombre' => 'Marta López', 'email' => 'marta.lopez@alumno.es', 'ciudad' => 'Sevilla', 'especialidad' => 'Diseño UX/UI'],
            ['nombre' => 'Javier García', 'email' => 'javier.garcia@alumno.es', 'ciudad' => 'Madrid', 'especialidad' => 'Desarrollo Backend'],
            ['nombre' => 'Lucía Fernández', 'email' => 'lucia.fernandez@alumno.es', 'ciudad' => 'Barcelona', 'especialidad' => 'IA y Machine Learning'],
            ['nombre' => 'Pablo Díaz', 'email' => 'pablo.diaz@alumno.es', 'ciudad' => 'Valencia', 'especialidad' => 'Análisis de Datos'],
            ['nombre' => 'Sara Méndez', 'email' => 'sara.mendez@alumno.es', 'ciudad' => 'Madrid', 'especialidad' => 'Ciberseguridad'],
            ['nombre' => 'Alejandro Castillo', 'email' => 'alejandro.castillo@alumno.es', 'ciudad' => 'Barcelona', 'especialidad' => 'Desarrollo Frontend'],
            ['nombre' => 'Sofía Rodríguez', 'email' => 'sofia.rodriguez@alumno.es', 'ciudad' => 'Madrid', 'especialidad' => 'DevOps'],
            ['nombre' => 'Daniel González', 'email' => 'daniel.gonzalez@alumno.es', 'ciudad' => 'Valencia', 'especialidad' => 'Arquitectura de Software'],
            ['nombre' => 'Eva Torres', 'email' => 'eva.torres@alumno.es', 'ciudad' => 'Madrid', 'especialidad' => 'Gestión de Proyectos IT'],
            ['nombre' => 'Miguel Ruiz', 'email' => 'miguel.ruiz@alumno.es', 'ciudad' => 'Barcelona', 'especialidad' => 'Big Data'],
            ['nombre' => 'Ana Vázquez', 'email' => 'ana.vazquez@alumno.es', 'ciudad' => 'Sevilla', 'especialidad' => 'Blockchain'],
            ['nombre' => 'Alberto Serrano', 'email' => 'alberto.serrano@alumno.es', 'ciudad' => 'Madrid', 'especialidad' => 'Cloud Computing'],
            ['nombre' => 'Carmen Ortiz', 'email' => 'carmen.ortiz@alumno.es', 'ciudad' => 'Barcelona', 'especialidad' => 'Desarrollo Fullstack'],
            ['nombre' => 'Iván Moreno', 'email' => 'ivan.moreno@alumno.es', 'ciudad' => 'Valencia', 'especialidad' => 'IoT'],
            ['nombre' => 'Patricia Ramos', 'email' => 'patricia.ramos@alumno.es', 'ciudad' => 'Madrid', 'especialidad' => 'Marketing Digital'],
            ['nombre' => 'Roberto Navarro', 'email' => 'roberto.navarro@alumno.es', 'ciudad' => 'Barcelona', 'especialidad' => 'Desarrollo de Videojuegos'],
            ['nombre' => 'Natalia Jiménez', 'email' => 'natalia.jimenez@alumno.es', 'ciudad' => 'Madrid', 'especialidad' => 'Realidad Virtual y Aumentada'],
        ];

        foreach ($estudiantes as $index => $estudiante) {
            User::create([
                'nombre' => $estudiante['nombre'],
                'email' => $estudiante['email'],
                'password' => Hash::make('password'),
                'fecha_nacimiento' => date('Y-m-d', strtotime('-' . rand(20, 30) . ' years')),
                'ciudad' => $estudiante['ciudad'],
                'dni' => $this->generarDNI(),
                'activo' => true,
                'telefono' => '6' . rand(10000000, 99999999),
                'descripcion' => 'Estudiante de ' . $estudiante['especialidad'] . ' con interés en adquirir experiencia profesional en el sector.',
                'imagen' => 'estudiante_' . ($index + 1) . '.jpg',
                'banner' => 'banner_estudiante_' . ($index + 1) . '.jpg',
                'visibilidad' => true,
                'role_id' => 3, // Rol de estudiante
                'remember_token' => Str::random(10),
                'lat' => $this->getLatForCity($estudiante['ciudad']),
                'lng' => $this->getLngForCity($estudiante['ciudad']),
                'direccion' => 'Dirección de ejemplo, ' . $estudiante['ciudad']
            ]);
        }

        // Tutores (8 tutores ficticios)
        $tutores = [
            ['nombre' => 'Fernando Pérez', 'email' => 'fernando.perez@tutor.es', 'ciudad' => 'Madrid', 'especialidad' => 'Desarrollo Web'],
            ['nombre' => 'Elena Castro', 'email' => 'elena.castro@tutor.es', 'ciudad' => 'Barcelona', 'especialidad' => 'Desarrollo Móvil'],
            ['nombre' => 'Raúl Gutiérrez', 'email' => 'raul.gutierrez@tutor.es', 'ciudad' => 'Valencia', 'especialidad' => 'Sistemas y Redes'],
            ['nombre' => 'Cristina Delgado', 'email' => 'cristina.delgado@tutor.es', 'ciudad' => 'Sevilla', 'especialidad' => 'Diseño y UX'],
            ['nombre' => 'Antonio Molina', 'email' => 'antonio.molina@tutor.es', 'ciudad' => 'Madrid', 'especialidad' => 'Bases de Datos'],
            ['nombre' => 'Beatriz Navas', 'email' => 'beatriz.navas@tutor.es', 'ciudad' => 'Barcelona', 'especialidad' => 'Inteligencia Artificial'],
            ['nombre' => 'Óscar Calvo', 'email' => 'oscar.calvo@tutor.es', 'ciudad' => 'Valencia', 'especialidad' => 'Seguridad Informática'],
            ['nombre' => 'Silvia Blanco', 'email' => 'silvia.blanco@tutor.es', 'ciudad' => 'Madrid', 'especialidad' => 'Gestión de Proyectos'],
        ];

        foreach ($tutores as $index => $tutor) {
            User::create([
                'nombre' => $tutor['nombre'],
                'email' => $tutor['email'],
                'password' => Hash::make('password'),
                'fecha_nacimiento' => date('Y-m-d', strtotime('-' . rand(35, 55) . ' years')),
                'ciudad' => $tutor['ciudad'],
                'dni' => $this->generarDNI(),
                'activo' => true,
                'telefono' => '6' . rand(10000000, 99999999),
                'descripcion' => 'Tutor especializado en ' . $tutor['especialidad'] . ' con amplia experiencia en el sector y en la formación de estudiantes.',
                'imagen' => 'tutor_' . ($index + 1) . '.jpg',
                'banner' => 'banner_tutor_' . ($index + 1) . '.jpg',
                'visibilidad' => true,
                'role_id' => 4, // Rol de tutor
                'remember_token' => Str::random(10),
                'lat' => $this->getLatForCity($tutor['ciudad']),
                'lng' => $this->getLngForCity($tutor['ciudad']),
                'direccion' => 'Dirección de ejemplo, ' . $tutor['ciudad']
            ]);
        }

        // Instituciones (5 instituciones ficticias)
        $instituciones = [
            ['nombre' => 'IES Madrid Centro', 'email' => 'info@iesmadridentro.edu.es', 'ciudad' => 'Madrid'],
            ['nombre' => 'Centro FP Barcelona Tech', 'email' => 'info@barcatech.edu.es', 'ciudad' => 'Barcelona'],
            ['nombre' => 'Instituto Técnico Valencia', 'email' => 'info@tecvalencia.edu.es', 'ciudad' => 'Valencia'],
            ['nombre' => 'IES Informática Sevilla', 'email' => 'info@iessevilla.edu.es', 'ciudad' => 'Sevilla'],
            ['nombre' => 'Centro Superior de Formación Digital', 'email' => 'info@csfd.edu.es', 'ciudad' => 'Madrid'],
        ];

        foreach ($instituciones as $index => $institucion) {
            User::create([
                'nombre' => $institucion['nombre'],
                'email' => $institucion['email'],
                'password' => Hash::make('password'),
                'fecha_nacimiento' => '1990-01-01',
                'ciudad' => $institucion['ciudad'],
                'dni' => 'A' . rand(10000000, 99999999),
                'activo' => true,
                'telefono' => '9' . rand(10000000, 99999999),
                'descripcion' => 'Centro educativo especializado en formación profesional en el ámbito de la tecnología y la informática.',
                'imagen' => 'institucion_' . ($index + 1) . '.jpg',
                'banner' => 'banner_institucion_' . ($index + 1) . '.jpg',
                'visibilidad' => true,
                'role_id' => 4, // Rol de institución
                'remember_token' => Str::random(10),
                'lat' => $this->getLatForCity($institucion['ciudad']),
                'lng' => $this->getLngForCity($institucion['ciudad']),
                'direccion' => 'Dirección de ejemplo, ' . $institucion['ciudad']
            ]);
        }

        // Docentes (15 docentes ficticios)
        $docentes = [
            ['nombre' => 'Manuel Torres', 'email' => 'manuel.torres@docente.es', 'ciudad' => 'Madrid', 'especialidad' => 'Programación Web'],
            ['nombre' => 'Isabel Nieto', 'email' => 'isabel.nieto@docente.es', 'ciudad' => 'Barcelona', 'especialidad' => 'Programación Móvil'],
            ['nombre' => 'Jorge Pascual', 'email' => 'jorge.pascual@docente.es', 'ciudad' => 'Valencia', 'especialidad' => 'Administración de Sistemas'],
            ['nombre' => 'María Durán', 'email' => 'maria.duran@docente.es', 'ciudad' => 'Sevilla', 'especialidad' => 'Diseño Digital'],
            ['nombre' => 'Víctor Prieto', 'email' => 'victor.prieto@docente.es', 'ciudad' => 'Madrid', 'especialidad' => 'Bases de Datos'],
            ['nombre' => 'Nuria Cordero', 'email' => 'nuria.cordero@docente.es', 'ciudad' => 'Barcelona', 'especialidad' => 'Inteligencia Artificial'],
            ['nombre' => 'Luis Soto', 'email' => 'luis.soto@docente.es', 'ciudad' => 'Valencia', 'especialidad' => 'Seguridad Informática'],
            ['nombre' => 'Rosa Herrera', 'email' => 'rosa.herrera@docente.es', 'ciudad' => 'Madrid', 'especialidad' => 'Desarrollo Frontend'],
            ['nombre' => 'Emilio Lara', 'email' => 'emilio.lara@docente.es', 'ciudad' => 'Barcelona', 'especialidad' => 'Desarrollo Backend'],
            ['nombre' => 'Alicia Millán', 'email' => 'alicia.millan@docente.es', 'ciudad' => 'Madrid', 'especialidad' => 'Lenguajes de Marcas'],
            ['nombre' => 'Sergio Moya', 'email' => 'sergio.moya@docente.es', 'ciudad' => 'Valencia', 'especialidad' => 'Programación de Servicios'],
            ['nombre' => 'Diana Rivas', 'email' => 'diana.rivas@docente.es', 'ciudad' => 'Madrid', 'especialidad' => 'Sistemas de Gestión Empresarial'],
            ['nombre' => 'Adrián Cano', 'email' => 'adrian.cano@docente.es', 'ciudad' => 'Barcelona', 'especialidad' => 'Entornos de Desarrollo'],
            ['nombre' => 'Miriam Ibáñez', 'email' => 'miriam.ibanez@docente.es', 'ciudad' => 'Sevilla', 'especialidad' => 'Fundamentos de Hardware'],
            ['nombre' => 'Julián Rey', 'email' => 'julian.rey@docente.es', 'ciudad' => 'Madrid', 'especialidad' => 'Sistemas Operativos'],
        ];

        foreach ($docentes as $index => $docente) {
            User::create([
                'nombre' => $docente['nombre'],
                'email' => $docente['email'],
                'password' => Hash::make('password'),
                'fecha_nacimiento' => date('Y-m-d', strtotime('-' . rand(30, 60) . ' years')),
                'ciudad' => $docente['ciudad'],
                'dni' => $this->generarDNI(),
                'activo' => true,
                'telefono' => '6' . rand(10000000, 99999999),
                'descripcion' => 'Docente especializado en ' . $docente['especialidad'] . ' con experiencia en formación profesional y universitaria.',
                'imagen' => 'docente_' . ($index + 1) . '.jpg',
                'banner' => 'banner_docente_' . ($index + 1) . '.jpg',
                'visibilidad' => true,
                'role_id' => 5, // Rol de docente/profesor
                'remember_token' => Str::random(10),
                'lat' => $this->getLatForCity($docente['ciudad']),
                'lng' => $this->getLngForCity($docente['ciudad']),
                'direccion' => 'Dirección de ejemplo, ' . $docente['ciudad']
            ]);
        }
    }

    /**
     * Genera un DNI con letra válida
     */
    private function generarDNI()
    {
        $numero = rand(10000000, 99999999);
        $letras = "TRWAGMYFPDXBNJZSQVHLCKE";
        $letra = $letras[$numero % 23];
        return $numero . $letra;
    }

    /**
     * Obtiene una latitud aproximada para una ciudad
     */
    private function getLatForCity($ciudad)
    {
        $coordenadas = [
            'Madrid' => 40.4168,
            'Barcelona' => 41.3851,
            'Valencia' => 39.4699,
            'Sevilla' => 37.3891,
            'Bilbao' => 43.2630,
            'A Coruña' => 43.3713,
            'Majadahonda' => 40.4734
        ];

        return $coordenadas[$ciudad] ?? 40.4168; // Por defecto Madrid
    }

    /**
     * Obtiene una longitud aproximada para una ciudad
     */
    private function getLngForCity($ciudad)
    {
        $coordenadas = [
            'Madrid' => -3.7038,
            'Barcelona' => 2.1734,
            'Valencia' => -0.3773,
            'Sevilla' => -5.9845,
            'Bilbao' => -2.9350,
            'A Coruña' => -8.3960,
            'Majadahonda' => -3.8726
        ];

        return $coordenadas[$ciudad] ?? -3.7038; // Por defecto Madrid
    }
}