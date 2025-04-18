<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Chat;
use App\Models\Mensaje;

class MensajeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $chats = Chat::all();

        // Mensajes realistas para los chats
        $mensajesEstudiante = [
            'Hola, me interesa mucho la oferta de prácticas que han publicado. ¿Podrían darme más información?',
            'Buenos días, he enviado mi solicitud para las prácticas. ¿Cuánto tiempo suelen tardar en responder?',
            'Gracias por la información. ¿Podría saber qué tecnologías utilizan en el día a día?',
            'Me gustaría saber si las prácticas son presenciales o teletrabajo.',
            '¿Qué horario tienen las prácticas? ¿Es compatible con estudios?',
            'Hola, ¿podrían revisar mi CV? Lo he actualizado recientemente.',
            'Buenas tardes, ¿han recibido mi documentación?',
            '¿Cuál sería el proceso de selección para las prácticas?',
            'Me interesa mucho la empresa y el puesto. ¿Qué posibilidades hay de continuar después de las prácticas?',
            '¿Podrían darme más detalles sobre el proyecto en el que trabajaría?'
        ];

        $mensajesEmpresa = [
            'Hola, gracias por tu interés. Las prácticas son para desarrollar un proyecto web utilizando React y Node.js.',
            'Buenos días, hemos recibido tu solicitud y la estamos revisando. Te contactaremos en breve.',
            'Utilizamos principalmente React, Node.js, MongoDB y AWS para nuestros proyectos.',
            'Las prácticas pueden ser híbridas, con algunos días presenciales y otros de teletrabajo.',
            'El horario es de 9:00 a 14:00 de lunes a viernes, compatible con estudios.',
            'Hemos revisado tu CV y nos parece interesante tu perfil. ¿Podrías contarnos más sobre tu experiencia en desarrollo web?',
            'Sí, hemos recibido toda la documentación correctamente.',
            'El proceso consta de una entrevista inicial, una prueba técnica y una entrevista final con el equipo.',
            'Sí, tenemos un programa de incorporación para los mejores estudiantes que finalizan las prácticas con nosotros.',
            'El proyecto consiste en desarrollar una aplicación web para gestión de recursos internos.'
        ];

        $mensajesTutor = [
            'Hola, soy el tutor asignado. Estaré disponible para ayudarte durante todo el proceso de prácticas.',
            'Recuerda preparar bien la entrevista, revisa los conceptos básicos de desarrollo web.',
            'Te recomiendo investigar sobre las tecnologías que utilizan en la empresa.',
            'Las prácticas son una excelente oportunidad para aplicar lo aprendido en clase.',
            'No dudes en contactarme si tienes alguna duda sobre el proceso.',
            'Tu perfil se ajusta bien a lo que buscan, destaca tus habilidades en desarrollo frontend.',
            'Asegúrate de tener toda la documentación actualizada antes de la entrevista.',
            'La empresa tiene buena reputación en el sector, es una gran oportunidad.',
            'Recuerda ser puntual y profesional en todas las interacciones con la empresa.',
            'Te ayudaré a preparar la documentación necesaria para las prácticas.'
        ];

        foreach ($chats as $chat) {
            // Obtener los IDs de los participantes del chat
            $participantes = [
                $chat->alumno_id,    // ID del estudiante
                $chat->tutor_id,     // ID del tutor
                $chat->empresa_id    // ID de la empresa
            ];

            // Generar entre 5 y 15 mensajes por chat
            $numMensajes = rand(5, 15);
            $fechaBase = fake()->dateTimeBetween('-6 months', 'now');
            $fechaActual = clone $fechaBase;

            for ($i = 0; $i < $numMensajes; $i++) {
                // Seleccionar aleatoriamente quién envía el mensaje
                $sender_id = $participantes[array_rand($participantes)];
                
                // Seleccionar el mensaje según el tipo de usuario
                $mensaje = '';
                if ($sender_id == $chat->alumno_id) {
                    $mensaje = $mensajesEstudiante[array_rand($mensajesEstudiante)];
                } elseif ($sender_id == $chat->empresa_id) {
                    $mensaje = $mensajesEmpresa[array_rand($mensajesEmpresa)];
                } else {
                    $mensaje = $mensajesTutor[array_rand($mensajesTutor)];
                }

                // Avanzar la fecha para simular una conversación real
                $fechaActual->modify('+' . rand(1, 60) . ' minutes');

                Mensaje::create([
                    'contenido' => $mensaje,
                    'chat_id' => $chat->id,
                    'user_id' => $sender_id,
                    'fecha_envio' => clone $fechaActual,
                    'created_at' => clone $fechaActual,
                    'updated_at' => now()
                ]);
            }
        }
    }
}
