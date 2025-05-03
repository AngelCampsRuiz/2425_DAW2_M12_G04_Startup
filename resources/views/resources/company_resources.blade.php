@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold text-primary mb-6">{{ __('footer.company_resources') }}</h1>
        
        <!-- Información principal -->
        <div class="bg-white rounded-lg shadow-lg p-6 md:p-8 mb-8">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Recursos para empresas</h2>
            <p class="text-gray-600 mb-6">En NextGen, facilitamos la conexión entre empresas y talento joven. Aquí encontrarás recursos para optimizar tu experiencia en nuestra plataforma y maximizar tus oportunidades de encontrar los candidatos ideales.</p>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="border border-gray-200 rounded-lg p-4 hover:border-primary hover:bg-primary/5 transition-colors duration-300">
                    <h3 class="font-medium text-primary mb-2">Publicación de ofertas efectivas</h3>
                    <p class="text-gray-600 text-sm">Cómo crear ofertas que atraigan a los candidatos más cualificados para tus necesidades.</p>
                </div>
                
                <div class="border border-gray-200 rounded-lg p-4 hover:border-primary hover:bg-primary/5 transition-colors duration-300">
                    <h3 class="font-medium text-primary mb-2">Evaluación de candidatos</h3>
                    <p class="text-gray-600 text-sm">Estrategias para filtrar y seleccionar a los mejores candidatos para tu empresa.</p>
                </div>
                
                <div class="border border-gray-200 rounded-lg p-4 hover:border-primary hover:bg-primary/5 transition-colors duration-300">
                    <h3 class="font-medium text-primary mb-2">Optimización de perfiles corporativos</h3>
                    <p class="text-gray-600 text-sm">Cómo presentar tu empresa para atraer al mejor talento estudiantil.</p>
                </div>
                
                <div class="border border-gray-200 rounded-lg p-4 hover:border-primary hover:bg-primary/5 transition-colors duration-300">
                    <h3 class="font-medium text-primary mb-2">Gestión de prácticas profesionales</h3>
                    <p class="text-gray-600 text-sm">Guía para implementar programas de prácticas exitosos para estudiantes.</p>
                </div>
            </div>
        </div>
        
        <!-- Guías y plantillas -->
        <div class="bg-gradient-to-br from-primary/10 to-primary/5 rounded-lg shadow-lg p-6 md:p-8 mb-8">
            <h2 class="text-2xl font-semibold text-gray-800 mb-6">Guías y plantillas</h2>
            
            <div class="space-y-6">
                <div class="bg-white rounded-lg p-5 shadow-sm flex items-start">
                    <div class="bg-primary text-white p-3 rounded-lg mr-4 flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-800 mb-1">Plantilla de descripción de oferta</h3>
                        <p class="text-gray-600 text-sm mb-3">Estructura recomendada para crear ofertas claras y atractivas.</p>
                        <a href="#" class="inline-flex items-center text-sm text-primary hover:text-primary-dark">
                            Descargar plantilla
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                        </a>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg p-5 shadow-sm flex items-start">
                    <div class="bg-primary text-white p-3 rounded-lg mr-4 flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-800 mb-1">Guía de entrevistas efectivas</h3>
                        <p class="text-gray-600 text-sm mb-3">Metodología y preguntas clave para identificar el mejor talento.</p>
                        <a href="#" class="inline-flex items-center text-sm text-primary hover:text-primary-dark">
                            Ver guía completa
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                            </svg>
                        </a>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg p-5 shadow-sm flex items-start">
                    <div class="bg-primary text-white p-3 rounded-lg mr-4 flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-800 mb-1">Modelo de feedback para prácticas</h3>
                        <p class="text-gray-600 text-sm mb-3">Estructura para proporcionar retroalimentación constructiva a los estudiantes.</p>
                        <a href="#" class="inline-flex items-center text-sm text-primary hover:text-primary-dark">
                            Descargar modelo
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Soporte adicional -->
        <div class="bg-white rounded-lg shadow-lg p-6 md:p-8">
            <div class="flex flex-col md:flex-row items-center justify-between">
                <div class="mb-6 md:mb-0 md:mr-8">
                    <h2 class="text-2xl font-semibold text-gray-800 mb-3">¿Necesitas ayuda adicional?</h2>
                    <p class="text-gray-600">Nuestro equipo está disponible para responder tus preguntas y ayudarte a sacar el máximo provecho de NextGen.</p>
                    <a href="{{ route('help.center') }}" class="mt-4 inline-flex items-center px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary-dark transition shadow-sm">
                        Contactar con soporte
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                </div>
                <div class="w-full md:w-auto">
                    <img src="{{ asset('assets/images/support.svg') }}" alt="Soporte" class="w-48 mx-auto">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 