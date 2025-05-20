@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-12">
    <div class="max-w-5xl mx-auto">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold bg-gradient-to-r from-primary to-purple-600 bg-clip-text text-transparent mb-4">Centro de ayuda</h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">Encuentra respuestas a tus preguntas y obtén el soporte que necesitas para aprovechar al máximo la plataforma NextGen.</p>
        </div>
        
        <!-- Tarjetas de acceso rápido -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-16">
            <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow transform hover:-translate-y-1 duration-300 border border-gray-100 text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-primary/10 text-primary rounded-full mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold mb-2">Preguntas Frecuentes</h3>
                <p class="text-gray-600 mb-4">Resolvemos tus dudas más comunes sobre la plataforma.</p>
                <a href="#faqs" class="inline-flex items-center text-primary font-medium hover:text-primary-dark">
                    Ver preguntas
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </a>
            </div>
            
            <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow transform hover:-translate-y-1 duration-300 border border-gray-100 text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-primary/10 text-primary rounded-full mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold mb-2">Guías de Usuario</h3>
                <p class="text-gray-600 mb-4">Tutoriales paso a paso para navegar por NextGen.</p>
                <a href="#" class="inline-flex items-center text-primary font-medium hover:text-primary-dark">
                    Ver guías
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </a>
            </div>
            
            <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow transform hover:-translate-y-1 duration-300 border border-gray-100 text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-primary/10 text-primary rounded-full mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold mb-2">Contacto Directo</h3>
                <p class="text-gray-600 mb-4">Ponte en contacto con nuestro equipo de soporte.</p>
                <a href="#contact" class="inline-flex items-center text-primary font-medium hover:text-primary-dark">
                    Contáctanos
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </a>
            </div>
        </div>
        
        <div class="bg-white rounded-2xl shadow-xl p-8 mb-16">
            <!-- Sección FAQ -->
            <section id="faqs" class="mb-12">
                <div class="flex items-center mb-8">
                    <div class="bg-primary/10 p-3 rounded-full mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-800">Preguntas Frecuentes</h2>
                </div>
                
                <div class="space-y-4">
                    <div class="border border-gray-200 rounded-xl p-6 hover:border-primary/30 hover:bg-gray-50 transition-colors duration-300">
                        <h3 class="font-bold text-gray-800 text-lg mb-3">¿Cómo funciona NextGen?</h3>
                        <p class="text-gray-600">NextGen es una plataforma que conecta estudiantes con empresas para oportunidades laborales y prácticas. Las empresas publican ofertas y los estudiantes pueden aplicar directamente a ellas. Nuestro sistema de matching optimiza la búsqueda para ambas partes, asegurando que las empresas encuentren el talento adecuado y los estudiantes las oportunidades que mejor se adapten a sus habilidades.</p>
                    </div>
                    
                    <div class="border border-gray-200 rounded-xl p-6 hover:border-primary/30 hover:bg-gray-50 transition-colors duration-300">
                        <h3 class="font-bold text-gray-800 text-lg mb-3">¿Cómo puedo crear una cuenta?</h3>
                        <p class="text-gray-600">Puedes registrarte como estudiante, empresa o institución educativa. Simplemente haz clic en "Registro" en la barra de navegación y sigue los pasos según tu perfil. El proceso de registro es rápido y sencillo, solicitando solo la información esencial para comenzar. Una vez completado, podrás acceder a tu panel personalizado y configurar los detalles adicionales de tu perfil.</p>
                    </div>
                    
                    <div class="border border-gray-200 rounded-xl p-6 hover:border-primary/30 hover:bg-gray-50 transition-colors duration-300">
                        <h3 class="font-bold text-gray-800 text-lg mb-3">¿Qué información debo incluir en mi perfil?</h3>
                        <p class="text-gray-600">Para los estudiantes, recomendamos incluir tus habilidades, educación, experiencia y proyectos. Las empresas deben detallar su sector, ubicación y cultura empresarial. Un perfil completo aumenta significativamente tus posibilidades de conseguir conexiones exitosas. Recuerda que la calidad de la información es más importante que la cantidad, así que enfócate en destacar tus puntos fuertes y lo que te hace único.</p>
                    </div>
                    
                    <div class="border border-gray-200 rounded-xl p-6 hover:border-primary/30 hover:bg-gray-50 transition-colors duration-300">
                        <h3 class="font-bold text-gray-800 text-lg mb-3">¿Cómo aplico a una oferta?</h3>
                        <p class="text-gray-600">Navega por las ofertas disponibles, haz clic en "Ver detalles" de la que te interese y luego presiona el botón "Aplicar". Podrás incluir un mensaje personalizado para la empresa, explicando por qué eres un buen candidato para la posición. Te recomendamos personalizar cada aplicación según los requisitos específicos de la oferta, aumentando así tus posibilidades de ser seleccionado para las siguientes fases del proceso.</p>
                    </div>
                </div>
                
                <div class="mt-8 text-center">
                    <a href="#" class="inline-flex items-center px-6 py-3 bg-primary/10 text-primary rounded-xl hover:bg-primary/20 transition font-medium">
                        Ver todas las preguntas frecuentes
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                </div>
            </section>
            
            <!-- Sección Contacto -->
            <section id="contact" class="mb-12">
                <div class="flex items-center mb-8">
                    <div class="bg-primary/10 p-3 rounded-full mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-800">Contacta con Nosotros</h2>
                </div>
                
                <div class="bg-gradient-to-br from-gray-50 to-primary/5 rounded-xl p-8 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-48 h-48 bg-primary/10 rounded-full -mr-24 -mt-24 blur-3xl"></div>
                    
                    <div class="relative z-10">
                        <div class="max-w-3xl">
                            <p class="text-lg text-gray-700 mb-6">Si no encuentras respuesta a tu pregunta, nuestro equipo de soporte está disponible para ayudarte. Contáctanos a través de los siguientes canales:</p>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                                <div class="bg-white rounded-xl p-6 shadow-md flex items-start">
                                    <div class="bg-primary text-white p-3 rounded-xl mr-4 flex-shrink-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-gray-800 text-lg mb-2">Correo Electrónico</h3>
                                        <p class="text-gray-600 mb-2">Tiempo de respuesta: 24-48 horas</p>
                                        <a href="mailto:soporte@nextgen.com" class="text-primary font-medium hover:underline">soporte@nextgen.com</a>
                                    </div>
                                </div>
                                
                                <div class="bg-white rounded-xl p-6 shadow-md flex items-start">
                                    <div class="bg-primary text-white p-3 rounded-xl mr-4 flex-shrink-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-gray-800 text-lg mb-2">Teléfono</h3>
                                        <p class="text-gray-600 mb-2">Lunes a Viernes: 9:00 - 18:00</p>
                                        <a href="tel:+34931234567" class="text-primary font-medium hover:underline">+34 93 123 45 67</a>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="bg-white rounded-xl p-6 shadow-md">
                                <h3 class="font-bold text-gray-800 text-lg mb-4">Envíanos un mensaje</h3>
                                <form class="space-y-4">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nombre</label>
                                            <input type="text" id="name" name="name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary">
                                        </div>
                                        <div>
                                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                            <input type="email" id="email" name="email" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary">
                                        </div>
                                    </div>
                                    <div>
                                        <label for="subject" class="block text-sm font-medium text-gray-700 mb-1">Asunto</label>
                                        <input type="text" id="subject" name="subject" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary">
                                    </div>
                                    <div>
                                        <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Mensaje</label>
                                        <textarea id="message" name="message" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary"></textarea>
                                    </div>
                                    <div>
                                        <button type="submit" class="px-6 py-3 bg-primary text-white rounded-xl hover:bg-primary-dark transition shadow-md hover:shadow-lg">
                                            Enviar mensaje
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        
        <!-- Búsqueda Avanzada -->
        <div class="bg-white rounded-2xl shadow-xl p-8 mb-16 text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-primary/10 text-primary rounded-full mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-gray-800 mb-4">¿No encontraste lo que buscabas?</h2>
            <p class="text-gray-600 max-w-2xl mx-auto mb-6">Utiliza nuestra herramienta de búsqueda avanzada para encontrar respuestas específicas a tus preguntas.</p>
            
            <div class="max-w-2xl mx-auto">
                <div class="flex items-center">
                    <input type="text" placeholder="Escribe tu pregunta o palabras clave..." class="w-full px-4 py-3 border border-gray-300 rounded-l-xl focus:ring-primary focus:border-primary">
                    <button class="bg-primary hover:bg-primary-dark text-white font-medium px-6 py-3 rounded-r-xl transition-colors">
                        Buscar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 