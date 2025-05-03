@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-12">
    <div class="max-w-6xl mx-auto">
        <!-- Encabezado -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold bg-gradient-to-r from-primary to-purple-600 bg-clip-text text-transparent mb-4">{{ __('footer.student_guides') }}</h1>
            <p class="text-lg text-gray-600 max-w-3xl mx-auto">Recursos y guías diseñados para ayudarte a alcanzar tus objetivos profesionales y destacar frente a los reclutadores.</p>
        </div>
        
        <!-- Banner destacado -->
        <div class="bg-gradient-to-r from-primary/90 to-purple-700 rounded-2xl shadow-xl overflow-hidden mb-16 relative">
            <div class="absolute inset-0 opacity-10">
                <img src="https://images.unsplash.com/photo-1434030216411-0b793f4b4173?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1350&q=80" alt="Background" class="w-full h-full object-cover">
            </div>
            <div class="relative z-10 p-8 md:p-12 flex flex-col md:flex-row items-center">
                <div class="md:w-2/3 mb-8 md:mb-0 md:pr-8 text-white">
                    <div class="inline-block px-4 py-1 bg-white/20 rounded-full text-sm font-medium backdrop-blur-sm mb-4">Guía completa</div>
                    <h2 class="text-3xl md:text-4xl font-bold mb-4">Construye tu carrera profesional desde la universidad</h2>
                    <p class="text-white/90 text-lg mb-8">Una guía paso a paso con estrategias prácticas para desarrollar tu perfil profesional, conseguir prácticas relevantes y prepararte para el mercado laboral mientras estudias.</p>
                    <a href="#" class="inline-flex items-center px-6 py-3 bg-white text-primary rounded-xl hover:bg-opacity-90 transition font-medium shadow-md hover:shadow-lg group">
                        Descargar guía completa
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                </div>
                <div class="md:w-1/3 flex justify-center">
                    <img src="{{ asset('assets/images/career-guide.svg') }}" alt="Guía de carrera" class="w-72 h-auto drop-shadow-2xl">
                </div>
            </div>
        </div>
        
        <!-- Guías principales -->
        <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
            </svg>
            Guías esenciales
        </h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-16">
            <!-- Guía de CV -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden transition transform hover:scale-[1.02] hover:shadow-2xl duration-300 border border-gray-100 flex flex-col h-full">
                <div class="h-48 bg-gradient-to-r from-primary to-purple-800 flex items-center justify-center p-6 relative">
                    <div class="absolute inset-0 opacity-30">
                        <img src="https://images.unsplash.com/photo-1586281380349-632531db7ed4?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1350&q=80" alt="CV" class="w-full h-full object-cover">
                    </div>
                    <div class="relative z-10">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                </div>
                <div class="p-6 flex flex-col flex-grow">
                    <div class="mb-4">
                        <span class="inline-block px-3 py-1 bg-primary/10 text-primary text-sm font-medium rounded-full">Guía esencial</span>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-800 mb-3">Guía para crear un CV perfecto</h2>
                    <p class="text-gray-600 mb-6 flex-grow">Aprende a crear un currículum que destaque tus habilidades y experiencia para captar la atención de los reclutadores. Incluye plantillas y ejemplos reales para diferentes perfiles profesionales.</p>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-500">Tiempo de lectura: 15 min</span>
                        <a href="#" class="inline-flex items-center text-primary hover:text-primary-dark font-medium group">
                            Leer guía
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1 transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Guía de entrevistas -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden transition transform hover:scale-[1.02] hover:shadow-2xl duration-300 border border-gray-100 flex flex-col h-full">
                <div class="h-48 bg-gradient-to-r from-cyan-600 to-primary flex items-center justify-center p-6 relative">
                    <div class="absolute inset-0 opacity-30">
                        <img src="https://images.unsplash.com/photo-1573497620053-ea5300f94f21?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1350&q=80" alt="Entrevista" class="w-full h-full object-cover">
                    </div>
                    <div class="relative z-10">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                        </svg>
                    </div>
                </div>
                <div class="p-6 flex flex-col flex-grow">
                    <div class="mb-4">
                        <span class="inline-block px-3 py-1 bg-primary/10 text-primary text-sm font-medium rounded-full">Guía esencial</span>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-800 mb-3">Cómo brillar en las entrevistas</h2>
                    <p class="text-gray-600 mb-6 flex-grow">Consejos y técnicas para prepararte para las entrevistas y responder con seguridad a las preguntas más comunes. Incluye simulaciones de entrevistas y consejos de reclutadores profesionales.</p>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-500">Tiempo de lectura: 20 min</span>
                        <a href="#" class="inline-flex items-center text-primary hover:text-primary-dark font-medium group">
                            Leer guía
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1 transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Lista de recursos -->
        <div class="bg-white rounded-lg shadow-lg p-6 md:p-8">
            <h2 class="text-2xl font-semibold text-gray-800 mb-6">Recursos adicionales</h2>
            
            <ul class="space-y-4">
                <li class="border-b border-gray-100 pb-4">
                    <a href="#" class="flex items-start group">
                        <div class="bg-primary/10 p-3 rounded-lg mr-4 text-primary group-hover:bg-primary group-hover:text-white transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-800 group-hover:text-primary transition-colors">Mejora tus habilidades blandas</h3>
                            <p class="text-gray-600 text-sm mt-1">Descubre cómo desarrollar habilidades como comunicación, trabajo en equipo y liderazgo.</p>
                        </div>
                    </a>
                </li>
                
                <li class="border-b border-gray-100 pb-4">
                    <a href="#" class="flex items-start group">
                        <div class="bg-primary/10 p-3 rounded-lg mr-4 text-primary group-hover:bg-primary group-hover:text-white transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-800 group-hover:text-primary transition-colors">Técnicas de networking efectivo</h3>
                            <p class="text-gray-600 text-sm mt-1">Aprende a crear y mantener conexiones profesionales que pueden impulsar tu carrera.</p>
                        </div>
                    </a>
                </li>
                
                <li class="border-b border-gray-100 pb-4">
                    <a href="#" class="flex items-start group">
                        <div class="bg-primary/10 p-3 rounded-lg mr-4 text-primary group-hover:bg-primary group-hover:text-white transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-800 group-hover:text-primary transition-colors">Optimiza tu perfil de NextGen</h3>
                            <p class="text-gray-600 text-sm mt-1">Consejos para que tu perfil sea más visible para las empresas y aumente tus oportunidades.</p>
                        </div>
                    </a>
                </li>
                
                <li>
                    <a href="#" class="flex items-start group">
                        <div class="bg-primary/10 p-3 rounded-lg mr-4 text-primary group-hover:bg-primary group-hover:text-white transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-800 group-hover:text-primary transition-colors">Tendencias del mercado laboral</h3>
                            <p class="text-gray-600 text-sm mt-1">Información actualizada sobre las habilidades más demandadas y sectores en crecimiento.</p>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
@endsection 