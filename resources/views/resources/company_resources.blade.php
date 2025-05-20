@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-12">
    <div class="max-w-6xl mx-auto">
        <h1 class="text-4xl font-bold bg-gradient-to-r from-primary to-purple-600 bg-clip-text text-transparent mb-3">Recursos de la empresa</h1>
        <p class="text-xl text-gray-600 mb-12 max-w-3xl">Recursos especializados para conectar tu empresa con el mejor talento joven y potenciar tu presencia en el mercado laboral.</p>
        
        <!-- Información principal -->
        <div class="bg-white rounded-2xl shadow-xl p-8 mb-16 transform transition-all duration-300 hover:shadow-2xl border border-gray-100">
            <div class="flex flex-col md:flex-row items-start gap-8 mb-10">
                <div class="md:w-3/5">
                    <h2 class="text-3xl font-bold text-gray-800 mb-6">Potencia tu estrategia de reclutamiento</h2>
                    <p class="text-gray-600 mb-8 text-lg leading-relaxed">En NextGen, facilitamos la conexión entre empresas y talento joven. Accede a recursos diseñados para optimizar tu experiencia en nuestra plataforma y maximizar tus oportunidades de encontrar los candidatos ideales para tu organización.</p>
                    <a href="#" class="inline-flex items-center px-6 py-3 bg-primary text-white rounded-xl hover:bg-primary-dark transition font-medium shadow-md hover:shadow-lg group">
                        Explorar todos los recursos
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                </div>
                <div class="md:w-2/5">
                    <img src="{{ asset('assets/images/hiring.svg') }}" alt="Reclutamiento" class="w-full h-auto rounded-xl shadow-lg">
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-gray-50 rounded-xl p-6 hover:bg-primary/5 transition-colors duration-300 shadow-sm hover:shadow-md transform hover:-translate-y-1 transition-transform border border-gray-100 hover:border-primary/20 group">
                    <div class="w-12 h-12 bg-primary/10 rounded-full flex items-center justify-center mb-4 group-hover:bg-primary/20 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-gray-800 mb-3 text-lg group-hover:text-primary transition-colors">Publicación de ofertas efectivas</h3>
                    <p class="text-gray-600">Estrategias y técnicas para crear ofertas que atraigan a los candidatos más cualificados para tus necesidades específicas.</p>
                    <a href="#" class="inline-flex items-center mt-4 text-primary font-medium group-hover:text-primary-dark transition-colors">
                        Leer más
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
                
                <div class="bg-gray-50 rounded-xl p-6 hover:bg-primary/5 transition-colors duration-300 shadow-sm hover:shadow-md transform hover:-translate-y-1 transition-transform border border-gray-100 hover:border-primary/20 group">
                    <div class="w-12 h-12 bg-primary/10 rounded-full flex items-center justify-center mb-4 group-hover:bg-primary/20 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-gray-800 mb-3 text-lg group-hover:text-primary transition-colors">Evaluación de candidatos</h3>
                    <p class="text-gray-600">Metodologías y herramientas para filtrar y seleccionar a los mejores candidatos para tu empresa de manera eficiente.</p>
                    <a href="#" class="inline-flex items-center mt-4 text-primary font-medium group-hover:text-primary-dark transition-colors">
                        Leer más
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
                
                <div class="bg-gray-50 rounded-xl p-6 hover:bg-primary/5 transition-colors duration-300 shadow-sm hover:shadow-md transform hover:-translate-y-1 transition-transform border border-gray-100 hover:border-primary/20 group">
                    <div class="w-12 h-12 bg-primary/10 rounded-full flex items-center justify-center mb-4 group-hover:bg-primary/20 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-gray-800 mb-3 text-lg group-hover:text-primary transition-colors">Optimización de perfiles</h3>
                    <p class="text-gray-600">Técnicas para presentar tu empresa de forma atractiva y destacar entre la competencia para atraer al mejor talento estudiantil.</p>
                    <a href="#" class="inline-flex items-center mt-4 text-primary font-medium group-hover:text-primary-dark transition-colors">
                        Leer más
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
                
                <div class="bg-gray-50 rounded-xl p-6 hover:bg-primary/5 transition-colors duration-300 shadow-sm hover:shadow-md transform hover:-translate-y-1 transition-transform border border-gray-100 hover:border-primary/20 group">
                    <div class="w-12 h-12 bg-primary/10 rounded-full flex items-center justify-center mb-4 group-hover:bg-primary/20 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-gray-800 mb-3 text-lg group-hover:text-primary transition-colors">Gestión de prácticas</h3>
                    <p class="text-gray-600">Guía completa para implementar programas de prácticas profesionales exitosos que beneficien tanto a estudiantes como a tu empresa.</p>
                    <a href="#" class="inline-flex items-center mt-4 text-primary font-medium group-hover:text-primary-dark transition-colors">
                        Leer más
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Guías y plantillas -->
        <div class="bg-gradient-to-br from-primary/10 via-purple-100 to-primary/5 rounded-2xl shadow-xl p-8 mb-16 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-br from-primary/20 to-purple-300/20 rounded-full -mr-32 -mt-32 blur-3xl"></div>
            <div class="absolute bottom-0 left-0 w-80 h-80 bg-gradient-to-tr from-purple-300/20 to-primary/10 rounded-full -ml-40 -mb-40 blur-3xl"></div>
            
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-10">
                    <div>
                        <h2 class="text-3xl font-bold text-gray-800 mb-3">Guías y plantillas</h2>
                        <p class="text-gray-600 max-w-2xl">Recursos listos para usar que te ayudarán a optimizar tus procesos de reclutamiento y gestión de talento.</p>
                    </div>
                    <a href="#" class="hidden md:inline-flex items-center px-4 py-2 bg-white text-primary rounded-lg hover:bg-gray-50 transition font-medium shadow-sm">
                        Ver todos los recursos
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-white rounded-xl p-6 shadow-md hover:shadow-lg transition-shadow transform hover:-translate-y-1 transition-transform duration-300 flex flex-col h-full">
                        <div class="bg-primary/10 text-primary p-4 rounded-lg mb-5 w-16 h-16 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <div class="flex-grow">
                            <h3 class="font-bold text-gray-800 text-xl mb-3">Plantilla de descripción de oferta</h3>
                            <p class="text-gray-600 mb-5">Estructura recomendada para crear ofertas claras y atractivas que generen un mayor número de candidatos cualificados.</p>
                        </div>
                        <a href="#" class="inline-flex items-center text-primary hover:text-primary-dark font-medium group">
                            <span>Descargar plantilla</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2 group-hover:translate-y-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                        </a>
                    </div>
                    
                    <div class="bg-white rounded-xl p-6 shadow-md hover:shadow-lg transition-shadow transform hover:-translate-y-1 transition-transform duration-300 flex flex-col h-full">
                        <div class="bg-primary/10 text-primary p-4 rounded-lg mb-5 w-16 h-16 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                            </svg>
                        </div>
                        <div class="flex-grow">
                            <h3 class="font-bold text-gray-800 text-xl mb-3">Guía de entrevistas efectivas</h3>
                            <p class="text-gray-600 mb-5">Metodología completa y preguntas clave para identificar el mejor talento durante el proceso de selección.</p>
                        </div>
                        <a href="#" class="inline-flex items-center text-primary hover:text-primary-dark font-medium group">
                            <span>Ver guía completa</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                            </svg>
                        </a>
                    </div>
                    
                    <div class="bg-white rounded-xl p-6 shadow-md hover:shadow-lg transition-shadow transform hover:-translate-y-1 transition-transform duration-300 flex flex-col h-full">
                        <div class="bg-primary/10 text-primary p-4 rounded-lg mb-5 w-16 h-16 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z" />
                            </svg>
                        </div>
                        <div class="flex-grow">
                            <h3 class="font-bold text-gray-800 text-xl mb-3">Modelo de feedback para prácticas</h3>
                            <p class="text-gray-600 mb-5">Estructura optimizada para proporcionar retroalimentación constructiva a los estudiantes y potenciar su desarrollo.</p>
                        </div>
                        <a href="#" class="inline-flex items-center text-primary hover:text-primary-dark font-medium group">
                            <span>Descargar modelo</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2 group-hover:translate-y-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                        </a>
                    </div>
                </div>
                
                <div class="md:hidden flex justify-center mt-8">
                    <a href="#" class="inline-flex items-center px-4 py-2 bg-white text-primary rounded-lg hover:bg-gray-50 transition font-medium shadow-sm">
                        Ver todos los recursos
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Soporte adicional -->
        <div class="bg-white rounded-2xl shadow-xl p-8 mb-16 border border-gray-100 overflow-hidden relative">
            <div class="absolute top-0 right-0 w-1/3 h-full bg-primary/5 -mr-20 rounded-l-full transform -skew-x-6"></div>
            
            <div class="flex flex-col md:flex-row items-center justify-between relative z-10">
                <div class="md:w-7/12 mb-8 md:mb-0 md:pr-8">
                    <span class="px-4 py-1 bg-primary/10 text-primary rounded-full text-sm font-medium inline-block mb-4">Soporte Premium</span>
                    <h2 class="text-3xl font-bold text-gray-800 mb-4">¿Necesitas ayuda personalizada?</h2>
                    <p class="text-gray-600 text-lg mb-6">Nuestro equipo de expertos está disponible para responder tus preguntas y ayudarte a optimizar tu estrategia de reclutamiento de talento joven.</p>
                    <div class="flex flex-wrap gap-4">
                        <a href="{{ route('help.center') }}" class="inline-flex items-center px-6 py-3 bg-primary text-white rounded-xl hover:bg-primary-dark transition shadow-md hover:shadow-lg group">
                            Contactar con soporte
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </a>
                        <a href="#" class="inline-flex items-center px-6 py-3 bg-white text-gray-700 border border-gray-200 rounded-xl hover:bg-gray-50 transition shadow-sm hover:shadow-md">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Preguntas frecuentes
                        </a>
                    </div>
                </div>
                <div class="md:w-5/12 flex justify-center">
                    <img src="{{ asset('assets/images/support.svg') }}" alt="Soporte" class="w-64 h-auto">
                </div>
            </div>
        </div>
        
        <!-- Estadísticas -->
        <div class="bg-gray-50 rounded-2xl shadow-lg p-8 mb-16 border border-gray-100">
            <div class="text-center mb-10">
                <h2 class="text-3xl font-bold text-gray-800 mb-3">Potencia tu presencia en NextGen</h2>
                <p class="text-gray-600 max-w-3xl mx-auto">Miles de empresas ya confían en nosotros para conectar con el talento universitario más cualificado.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="bg-white rounded-xl p-6 text-center shadow-md">
                    <div class="text-4xl font-bold text-primary mb-2">96%</div>
                    <p class="text-gray-600">De empresas encuentran candidatos cualificados en menos de 2 semanas</p>
                </div>
                
                <div class="bg-white rounded-xl p-6 text-center shadow-md">
                    <div class="text-4xl font-bold text-primary mb-2">10K+</div>
                    <p class="text-gray-600">Estudiantes activos buscando oportunidades profesionales</p>
                </div>
                
                <div class="bg-white rounded-xl p-6 text-center shadow-md">
                    <div class="text-4xl font-bold text-primary mb-2">85%</div>
                    <p class="text-gray-600">Tasa de retención en prácticas profesionales gestionadas</p>
                </div>
                
                <div class="bg-white rounded-xl p-6 text-center shadow-md">
                    <div class="text-4xl font-bold text-primary mb-2">24/7</div>
                    <p class="text-gray-600">Soporte técnico disponible para empresas partners</p>
                </div>
            </div>
            
            <div class="text-center mt-10">
                <a href="#" class="inline-flex items-center px-6 py-3 bg-primary text-white rounded-xl hover:bg-primary-dark transition shadow-md hover:shadow-lg">
                    Únete como empresa
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection 