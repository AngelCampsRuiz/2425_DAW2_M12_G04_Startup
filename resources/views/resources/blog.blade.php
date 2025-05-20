@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-12">
    <div class="max-w-5xl mx-auto">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6 mb-12">
            <h1 class="text-4xl font-bold bg-gradient-to-r from-primary to-purple-600 bg-clip-text text-transparent">Blog</h1>
            
            <div class="relative w-full md:w-auto">
                <input type="text" placeholder="Buscar artículos..." class="w-full md:w-72 pl-10 pr-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary/40 focus:border-primary shadow-sm transition-all duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
        </div>
        
        <!-- Artículos destacados -->
        <div class="relative bg-gradient-to-r from-primary to-purple-700 rounded-2xl overflow-hidden mb-16 shadow-xl transform transition-all duration-300 hover:scale-[1.01] group">
            <div class="absolute inset-0 bg-black opacity-60 group-hover:opacity-50 transition-opacity duration-300"></div>
            <img src="https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1770&q=80" alt="Featured post background" class="absolute inset-0 w-full h-full object-cover opacity-30">
            <div class="relative z-10 p-8 md:p-12 text-white">
                <span class="inline-block px-3 py-1 bg-white/20 backdrop-blur-sm rounded-full text-sm font-medium mb-4 animate-pulse">Tendencias</span>
                <h2 class="text-2xl md:text-4xl font-bold mb-6 leading-tight">5 habilidades tecnológicas más demandadas en 2023</h2>
                <p class="mb-8 opacity-90 max-w-2xl text-lg">Descubre qué habilidades tecnológicas están buscando las empresas y cómo puedes desarrollarlas para destacar en el mercado laboral actual.</p>
                <div class="flex items-center mb-8">
                    <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Autor" class="w-12 h-12 rounded-full border-2 border-white mr-4">
                    <div>
                        <p class="font-medium text-lg">Laura Martínez</p>
                        <p class="text-sm opacity-80">15 de mayo de 2023 · 8 min de lectura</p>
                    </div>
                </div>
                <a href="#" class="inline-flex items-center px-6 py-3 bg-white text-primary rounded-xl hover:bg-opacity-90 transition font-medium shadow-md hover:shadow-lg group">
                    Leer artículo
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </a>
            </div>
        </div>
        
        <!-- Categorías -->
        <div class="flex flex-wrap gap-3 mb-12">
            <a href="#" class="px-5 py-2.5 bg-primary text-white rounded-full hover:bg-primary-dark transition-all duration-200 font-medium shadow-sm hover:shadow-md flex items-center space-x-1.5">
                <span class="inline-block w-2 h-2 bg-white rounded-full"></span>
                <span>Todos</span>
            </a>
            <a href="#" class="px-5 py-2.5 bg-gray-100 text-gray-700 rounded-full hover:bg-gray-200 transition-all duration-200 font-medium shadow-sm hover:shadow-md flex items-center space-x-1.5">
                <span class="inline-block w-2 h-2 bg-blue-500 rounded-full"></span>
                <span>Tecnología</span>
            </a>
            <a href="#" class="px-5 py-2.5 bg-gray-100 text-gray-700 rounded-full hover:bg-gray-200 transition-all duration-200 font-medium shadow-sm hover:shadow-md flex items-center space-x-1.5">
                <span class="inline-block w-2 h-2 bg-green-500 rounded-full"></span>
                <span>Desarrollo profesional</span>
            </a>
            <a href="#" class="px-5 py-2.5 bg-gray-100 text-gray-700 rounded-full hover:bg-gray-200 transition-all duration-200 font-medium shadow-sm hover:shadow-md flex items-center space-x-1.5">
                <span class="inline-block w-2 h-2 bg-purple-500 rounded-full"></span>
                <span>Entrevistas</span>
            </a>
            <a href="#" class="px-5 py-2.5 bg-gray-100 text-gray-700 rounded-full hover:bg-gray-200 transition-all duration-200 font-medium shadow-sm hover:shadow-md flex items-center space-x-1.5">
                <span class="inline-block w-2 h-2 bg-red-500 rounded-full"></span>
                <span>Consejos</span>
            </a>
            <a href="#" class="px-5 py-2.5 bg-gray-100 text-gray-700 rounded-full hover:bg-gray-200 transition-all duration-200 font-medium shadow-sm hover:shadow-md flex items-center space-x-1.5">
                <span class="inline-block w-2 h-2 bg-yellow-500 rounded-full"></span>
                <span>Historias de éxito</span>
            </a>
        </div>
        
        <!-- Lista de artículos -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Artículo 1 -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 group">
                <div class="relative overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1531482615713-2afd69097998?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1770&q=80" alt="Imagen de artículo" class="w-full h-52 object-cover transform group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute top-0 right-0 m-4">
                        <span class="inline-block px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-medium shadow-sm">Entrevistas</span>
                    </div>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold mb-3 group-hover:text-primary transition-colors duration-200">Cómo prepararte para una entrevista técnica</h3>
                    <p class="text-gray-600 mb-4 line-clamp-3">Los consejos de profesionales de RRHH para destacar en entrevistas técnicas y conseguir el trabajo de tus sueños.</p>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span class="text-sm text-gray-500">10 de junio de 2023</span>
                        </div>
                        <a href="#" class="text-primary hover:text-primary-dark font-medium inline-flex items-center group">
                            <span>Leer más</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1 transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Artículo 2 -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 group">
                <div class="relative overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1590402494610-2c378a9114c6?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1770&q=80" alt="Imagen de artículo" class="w-full h-52 object-cover transform group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute top-0 right-0 m-4">
                        <span class="inline-block px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium shadow-sm">Desarrollo profesional</span>
                    </div>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold mb-3 group-hover:text-primary transition-colors duration-200">La importancia del networking para estudiantes</h3>
                    <p class="text-gray-600 mb-4 line-clamp-3">Cómo construir y mantener una red de contactos profesionales que impulse tu carrera desde la universidad.</p>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span class="text-sm text-gray-500">2 de junio de 2023</span>
                        </div>
                        <a href="#" class="text-primary hover:text-primary-dark font-medium inline-flex items-center group">
                            <span>Leer más</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1 transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Artículo 3 -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 group">
                <div class="relative overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1581291518633-83b4ebd1d83e?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1770&q=80" alt="Imagen de artículo" class="w-full h-52 object-cover transform group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute top-0 right-0 m-4">
                        <span class="inline-block px-3 py-1 bg-purple-100 text-purple-800 rounded-full text-xs font-medium shadow-sm">Tecnología</span>
                    </div>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold mb-3 group-hover:text-primary transition-colors duration-200">Inteligencia Artificial: El futuro del trabajo</h3>
                    <p class="text-gray-600 mb-4 line-clamp-3">Analizamos cómo la IA está transformando el mercado laboral y qué habilidades necesitarás para adaptarte.</p>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span class="text-sm text-gray-500">25 de mayo de 2023</span>
                        </div>
                        <a href="#" class="text-primary hover:text-primary-dark font-medium inline-flex items-center group">
                            <span>Leer más</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1 transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Artículo 4 -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 group">
                <div class="relative overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1521737711867-e3b97375f902?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1770&q=80" alt="Imagen de artículo" class="w-full h-52 object-cover transform group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute top-0 right-0 m-4">
                        <span class="inline-block px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-medium shadow-sm">Historias de éxito</span>
                    </div>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold mb-3 group-hover:text-primary transition-colors duration-200">De estudiante a CTO: La historia de Mario García</h3>
                    <p class="text-gray-600 mb-4 line-clamp-3">Conoce cómo un estudiante de informática consiguió convertirse en CTO de una startup exitosa en menos de 5 años.</p>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span class="text-sm text-gray-500">18 de mayo de 2023</span>
                        </div>
                        <a href="#" class="text-primary hover:text-primary-dark font-medium inline-flex items-center group">
                            <span>Leer más</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1 transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Artículo 5 -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 group">
                <div class="relative overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1527689368864-3a821dbccc34?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1770&q=80" alt="Imagen de artículo" class="w-full h-52 object-cover transform group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute top-0 right-0 m-4">
                        <span class="inline-block px-3 py-1 bg-red-100 text-red-800 rounded-full text-xs font-medium shadow-sm">Consejos</span>
                    </div>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold mb-3 group-hover:text-primary transition-colors duration-200">Los 7 errores más comunes en el CV de un estudiante</h3>
                    <p class="text-gray-600 mb-4 line-clamp-3">Identifica y corrige estos errores frecuentes que pueden estar afectando tus oportunidades de conseguir entrevistas.</p>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span class="text-sm text-gray-500">5 de mayo de 2023</span>
                        </div>
                        <a href="#" class="text-primary hover:text-primary-dark font-medium inline-flex items-center group">
                            <span>Leer más</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1 transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Artículo 6 -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 group">
                <div class="relative overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1770&q=80" alt="Imagen de artículo" class="w-full h-52 object-cover transform group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute top-0 right-0 m-4">
                        <span class="inline-block px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-medium shadow-sm">Tecnología</span>
                    </div>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold mb-3 group-hover:text-primary transition-colors duration-200">Las 10 herramientas que todo desarrollador debería conocer</h3>
                    <p class="text-gray-600 mb-4 line-clamp-3">Una revisión de las herramientas más útiles para desarrolladores que pueden mejorar tu productividad y empleabilidad.</p>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span class="text-sm text-gray-500">28 de abril de 2023</span>
                        </div>
                        <a href="#" class="text-primary hover:text-primary-dark font-medium inline-flex items-center group">
                            <span>Leer más</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1 transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Paginación -->
        <div class="flex justify-center mt-16">
            <nav class="inline-flex rounded-xl shadow-md overflow-hidden">
                <a href="#" class="px-5 py-3 bg-white border border-gray-200 text-gray-600 font-medium hover:bg-gray-50 transition-colors flex items-center space-x-1 rounded-l-xl">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    <span>Anterior</span>
                </a>
                <a href="#" class="px-5 py-3 bg-primary text-white border border-primary font-medium hover:bg-primary-dark transition-colors">1</a>
                <a href="#" class="px-5 py-3 bg-white border border-gray-200 text-gray-700 font-medium hover:bg-gray-50 transition-colors">2</a>
                <a href="#" class="px-5 py-3 bg-white border border-gray-200 text-gray-700 font-medium hover:bg-gray-50 transition-colors">3</a>
                <a href="#" class="px-5 py-3 bg-white border border-gray-200 text-gray-600 font-medium hover:bg-gray-50 transition-colors flex items-center space-x-1 rounded-r-xl">
                    <span>Siguiente</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </nav>
        </div>

        <!-- Newsletter signup -->
        <div class="mt-16 bg-gradient-to-br from-gray-100 to-gray-200 rounded-2xl p-8 shadow-md">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="md:w-2/3">
                    <h3 class="text-2xl font-bold mb-2">Mantente al día con nuestras novedades</h3>
                    <p class="text-gray-600">Recibe nuestros mejores artículos y recursos directamente en tu bandeja de entrada, sin spam.</p>
                </div>
                <div class="md:w-1/3">
                    <div class="flex">
                        <input type="email" placeholder="Tu email" class="w-full rounded-l-lg px-4 py-3 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary">
                        <button class="bg-primary hover:bg-primary-dark text-white font-medium px-4 py-3 rounded-r-lg transition-colors">
                            Suscribirse
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 