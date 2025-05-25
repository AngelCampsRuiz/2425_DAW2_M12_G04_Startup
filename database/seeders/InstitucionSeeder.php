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
        $instituciones = [
            [
                'nombre' => 'IES Juan de la Cierva',
                'email' => 'info@juandelacierva.es',
                'ciudad' => 'Madrid',
                'dni' => 'I28020934',
                'sitio_web' => 'https://www.iesjuandelacierva.com',
                'telefono' => '912802093',
                'descripcion' => 'Centro educativo especializado en formación profesional de tecnología y comunicaciones',
                'codigo_centro' => '28020934',
                'direccion' => 'Calle de la Caoba, 1',
                'codigo_postal' => '28003',
                'representante_legal' => 'Ana Martínez López',
                'cargo_representante' => 'Directora'
            ],
            [
                'nombre' => 'IES Mare Nostrum',
                'email' => 'info@iesmarenostrum.es',
                'ciudad' => 'Alicante',
                'dni' => 'I03012736',
                'sitio_web' => 'https://www.iesmarenostrum.com',
                'telefono' => '960301273',
                'descripcion' => 'Centro de formación profesional especializado en tecnologías de la información',
                'codigo_centro' => '03012736',
                'direccion' => 'Carrer Dafne, 6',
                'codigo_postal' => '03007',
                'representante_legal' => 'José Ruiz Navarro',
                'cargo_representante' => 'Director'
            ],
            [
                'nombre' => 'IES Politécnico',
                'email' => 'secretaria@iespolitecnico.cat',
                'ciudad' => 'Barcelona',
                'dni' => 'I08034205',
                'sitio_web' => 'https://www.iespolitecnico.cat',
                'telefono' => '930803420',
                'descripcion' => 'Centro educativo líder en formación profesional industrial y tecnológica',
                'codigo_centro' => '08034205',
                'direccion' => 'Carrer d\'Urgell, 187',
                'codigo_postal' => '08036',
                'representante_legal' => 'Montserrat Vila Serra',
                'cargo_representante' => 'Directora'
            ],
            [
                'nombre' => 'IES Leonardo da Vinci',
                'email' => 'info@iesleonardo.es',
                'ciudad' => 'Valencia',
                'dni' => 'I46018133',
                'sitio_web' => 'https://www.iesleonardo.edu.es',
                'telefono' => '964601813',
                'descripcion' => 'Instituto especializado en formación profesional de nuevas tecnologías',
                'codigo_centro' => '46018133',
                'direccion' => 'Carrer del Clariano, 1',
                'codigo_postal' => '46021',
                'representante_legal' => 'Francisco Pérez García',
                'cargo_representante' => 'Director'
            ],
            [
                'nombre' => 'IES Virgen de la Paloma',
                'email' => 'info@paloma.es',
                'ciudad' => 'Madrid',
                'dni' => 'I28020341',
                'sitio_web' => 'https://www.iesvirgendelapaloma.es',
                'telefono' => '912802034',
                'descripcion' => 'Centro histórico de formación profesional con amplia oferta educativa',
                'codigo_centro' => '28020341',
                'direccion' => 'Calle Francos Rodríguez, 106',
                'codigo_postal' => '28039',
                'representante_legal' => 'Carmen Sánchez Ruiz',
                'cargo_representante' => 'Directora'
            ],
            [
                'nombre' => 'IES El Caminàs',
                'email' => 'info@iescaminas.es',
                'ciudad' => 'Castellón',
                'dni' => 'I12004217',
                'sitio_web' => 'https://www.iescaminas.org',
                'telefono' => '961200421',
                'descripcion' => 'Centro de referencia en formación profesional de la Comunidad Valenciana',
                'codigo_centro' => '12004217',
                'direccion' => 'Camí Caminàs, 37',
                'codigo_postal' => '12003',
                'representante_legal' => 'Vicente Martí Cervera',
                'cargo_representante' => 'Director'
            ],
            [
                'nombre' => 'IES Castelar',
                'email' => 'secretaria@iescastelar.es',
                'ciudad' => 'Badajoz',
                'dni' => 'I06001238',
                'sitio_web' => 'https://www.iescastelar.es',
                'telefono' => '960600123',
                'descripcion' => 'Centro educativo especializado en tecnología y comunicaciones',
                'codigo_centro' => '06001238',
                'direccion' => 'Avenida Ramón y Cajal, 2',
                'codigo_postal' => '06001',
                'representante_legal' => 'María López Sánchez',
                'cargo_representante' => 'Directora'
            ],
            [
                'nombre' => 'IES Zaidín-Vergeles',
                'email' => 'info@ieszaidin.es',
                'ciudad' => 'Granada',
                'dni' => 'I18009389',
                'sitio_web' => 'https://www.ieszaidin.org',
                'telefono' => '951800938',
                'descripcion' => 'Centro de formación profesional con amplia trayectoria en Granada',
                'codigo_centro' => '18009389',
                'direccion' => 'Calle Primavera, 26',
                'codigo_postal' => '18008',
                'representante_legal' => 'Antonio Ramírez Torres',
                'cargo_representante' => 'Director'
            ],
            [
                'nombre' => 'IES Nicolau Copèrnic',
                'email' => 'info@iesnicopernic.cat',
                'ciudad' => 'Terrassa',
                'dni' => 'I08034059',
                'sitio_web' => 'https://www.iesnicopernic.cat',
                'telefono' => '930803405',
                'descripcion' => 'Centro educativo especializado en tecnología y ciencias',
                'codigo_centro' => '08034059',
                'direccion' => 'Carrer Torrent del Batlle, 10',
                'codigo_postal' => '08225',
                'representante_legal' => 'Jordi Puig Costa',
                'cargo_representante' => 'Director'
            ],
            [
                'nombre' => 'IES Ingeniero de la Cierva',
                'email' => 'info@iesingeniero.es',
                'ciudad' => 'Murcia',
                'dni' => 'I30010978',
                'sitio_web' => 'https://www.iesingeniero.es',
                'telefono' => '963001097',
                'descripcion' => 'Centro de referencia en formación profesional de la Región de Murcia',
                'codigo_centro' => '30010978',
                'direccion' => 'Calle La Iglesia, s/n',
                'codigo_postal' => '30012',
                'representante_legal' => 'Isabel Martínez Cano',
                'cargo_representante' => 'Directora'
            ]
        ];

        foreach ($instituciones as $inst) {
            // Crear usuario de institución
            $user = User::create([
                'nombre' => $inst['nombre'],
                'email' => $inst['email'],
                'password' => Hash::make('password'),
                'fecha_nacimiento' => null,
                'ciudad' => $inst['ciudad'],
                'dni' => $inst['dni'],
                'activo' => true,
                'sitio_web' => $inst['sitio_web'],
                'telefono' => $inst['telefono'],
                'descripcion' => $inst['descripcion'],
                'imagen' => strtolower(str_replace(' ', '_', $inst['nombre'])) . '.jpg',
                'visibilidad' => true,
                'role_id' => 4,
            ]);

            // Crear la institución
            Institucion::create([
                'user_id' => $user->id,
                'codigo_centro' => $inst['codigo_centro'],
                'direccion' => $inst['direccion'],
                'ciudad' => $inst['ciudad'],
                'codigo_postal' => $inst['codigo_postal'],
                'representante_legal' => $inst['representante_legal'],
                'cargo_representante' => $inst['cargo_representante'],
                'verificada' => true,
            ]);
        }
    }
} 