@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold text-primary mb-6">{{ __('footer.student_guides') }}</h1>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <!-- Guía de CV -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden transition transform hover:scale-[1.02] duration-300">
                <div class="h-40 bg-gradient-to-r from-primary to-purple-800 flex items-center justify-center p-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <div class="p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-2">Guía para crear un CV perfecto</h2>
                    <p class="text-gray-600 mb-4">Aprende a crear un currículum que destaque tus habilidades y experiencia para captar la atención de los reclutadores.</p>
                    <a href="#" class="inline-flex items-center text-primary hover:text-primary-dark font-medium">
                        Leer guía
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>
            
            <!-- Guía de entrevistas -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden transition transform hover:scale-[1.02] duration-300">
                <div class="h-40 bg-gradient-to-r from-cyan-600 to-primary flex items-center justify-center p-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <div class="p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-2">Cómo brillar en las entrevistas</h2>
                    <p class="text-gray-600 mb-4">Consejos y técnicas para prepararte para las entrevistas y responder con seguridad a las preguntas más comunes.</p>
                    <a href="#" class="inline-flex items-center text-primary hover:text-primary-dark font-medium">
                        Leer guía
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
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