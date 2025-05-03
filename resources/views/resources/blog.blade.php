@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-5xl mx-auto">
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-3xl font-bold text-primary">{{ __('footer.blog') }}</h1>
            
            <div class="relative">
                <input type="text" placeholder="Buscar artículos..." class="w-full md:w-64 pl-10 pr-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
        </div>
        
        <!-- Artículos destacados -->
        <div class="relative bg-gradient-to-r from-primary to-purple-700 rounded-xl overflow-hidden mb-12">
            <div class="absolute inset-0 bg-black opacity-50"></div>
            <div class="relative z-10 p-8 md:p-12 text-white">
                <span class="inline-block px-3 py-1 bg-white/20 backdrop-blur-sm rounded-full text-sm font-medium mb-4">Tendencias</span>
                <h2 class="text-2xl md:text-3xl font-bold mb-4">5 habilidades tecnológicas más demandadas en 2023</h2>
                <p class="mb-6 opacity-90 max-w-2xl">Descubre qué habilidades tecnológicas están buscando las empresas y cómo puedes desarrollarlas para destacar en el mercado laboral actual.</p>
                <div class="flex items-center mb-6">
                    <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Autor" class="w-10 h-10 rounded-full mr-3">
                    <div>
                        <p class="font-medium">Laura Martínez</p>
                        <p class="text-xs opacity-80">15 de mayo de 2023 · 8 min de lectura</p>
                    </div>
                </div>
                <a href="#" class="inline-flex items-center px-4 py-2 bg-white text-primary rounded-lg hover:bg-opacity-90 transition font-medium">
                    Leer artículo
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </a>
            </div>
        </div>
        
        <!-- Categorías -->
        <div class="flex flex-wrap gap-2 mb-8">
            <a href="#" class="px-4 py-2 bg-primary/10 text-primary rounded-full hover:bg-primary/20 transition">Todos</a>
            <a href="#" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-full hover:bg-gray-200 transition">Tecnología</a>
            <a href="#" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-full hover:bg-gray-200 transition">Desarrollo profesional</a>
            <a href="#" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-full hover:bg-gray-200 transition">Entrevistas</a>
            <a href="#" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-full hover:bg-gray-200 transition">Consejos</a>
            <a href="#" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-full hover:bg-gray-200 transition">Historias de éxito</a>
        </div>
        
        <!-- Lista de artículos -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Artículo 1 -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition">
                <img src="https://images.unsplash.com/photo-1531482615713-2afd69097998?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1770&q=80" alt="Imagen de artículo" class="w-full h-48 object-cover">
                <div class="p-6">
                    <span class="inline-block px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-medium mb-2">Entrevistas</span>
                    <h3 class="text-xl font-semibold mb-2">Cómo prepararte para una entrevista técnica</h3>
                    <p class="text-gray-600 mb-4 line-clamp-3">Los consejos de profesionales de RRHH para destacar en entrevistas técnicas y conseguir el trabajo de tus sueños.</p>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-500">10 de junio de 2023</span>
                        <a href="#" class="text-primary hover:text-primary-dark font-medium">Leer más</a>
                    </div>
                </div>
            </div>
            
            <!-- Artículo 2 -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition">
                <img src="https://images.unsplash.com/photo-1590402494610-2c378a9114c6?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1770&q=80" alt="Imagen de artículo" class="w-full h-48 object-cover">
                <div class="p-6">
                    <span class="inline-block px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium mb-2">Desarrollo profesional</span>
                    <h3 class="text-xl font-semibold mb-2">La importancia del networking para estudiantes</h3>
                    <p class="text-gray-600 mb-4 line-clamp-3">Cómo construir y mantener una red de contactos profesionales que impulse tu carrera desde la universidad.</p>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-500">2 de junio de 2023</span>
                        <a href="#" class="text-primary hover:text-primary-dark font-medium">Leer más</a>
                    </div>
                </div>
            </div>
            
            <!-- Artículo 3 -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition">
                <img src="https://images.unsplash.com/photo-1581291518633-83b4ebd1d83e?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1770&q=80" alt="Imagen de artículo" class="w-full h-48 object-cover">
                <div class="p-6">
                    <span class="inline-block px-3 py-1 bg-purple-100 text-purple-800 rounded-full text-xs font-medium mb-2">Tecnología</span>
                    <h3 class="text-xl font-semibold mb-2">Inteligencia Artificial: El futuro del trabajo</h3>
                    <p class="text-gray-600 mb-4 line-clamp-3">Analizamos cómo la IA está transformando el mercado laboral y qué habilidades necesitarás para adaptarte.</p>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-500">25 de mayo de 2023</span>
                        <a href="#" class="text-primary hover:text-primary-dark font-medium">Leer más</a>
                    </div>
                </div>
            </div>
            
            <!-- Artículo 4 -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition">
                <img src="https://images.unsplash.com/photo-1521737711867-e3b97375f902?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1770&q=80" alt="Imagen de artículo" class="w-full h-48 object-cover">
                <div class="p-6">
                    <span class="inline-block px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-medium mb-2">Historias de éxito</span>
                    <h3 class="text-xl font-semibold mb-2">De estudiante a CTO: La historia de Mario García</h3>
                    <p class="text-gray-600 mb-4 line-clamp-3">Conoce cómo un estudiante de informática consiguió convertirse en CTO de una startup exitosa en menos de 5 años.</p>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-500">18 de mayo de 2023</span>
                        <a href="#" class="text-primary hover:text-primary-dark font-medium">Leer más</a>
                    </div>
                </div>
            </div>
            
            <!-- Artículo 5 -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition">
                <img src="https://images.unsplash.com/photo-1527689368864-3a821dbccc34?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1770&q=80" alt="Imagen de artículo" class="w-full h-48 object-cover">
                <div class="p-6">
                    <span class="inline-block px-3 py-1 bg-red-100 text-red-800 rounded-full text-xs font-medium mb-2">Consejos</span>
                    <h3 class="text-xl font-semibold mb-2">Los 7 errores más comunes en el CV de un estudiante</h3>
                    <p class="text-gray-600 mb-4 line-clamp-3">Identifica y corrige estos errores frecuentes que pueden estar afectando tus oportunidades de conseguir entrevistas.</p>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-500">5 de mayo de 2023</span>
                        <a href="#" class="text-primary hover:text-primary-dark font-medium">Leer más</a>
                    </div>
                </div>
            </div>
            
            <!-- Artículo 6 -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition">
                <img src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1770&q=80" alt="Imagen de artículo" class="w-full h-48 object-cover">
                <div class="p-6">
                    <span class="inline-block px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-medium mb-2">Tecnología</span>
                    <h3 class="text-xl font-semibold mb-2">Las 10 herramientas que todo desarrollador debería conocer</h3>
                    <p class="text-gray-600 mb-4 line-clamp-3">Una revisión de las herramientas más útiles para desarrolladores que pueden mejorar tu productividad y empleabilidad.</p>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-500">28 de abril de 2023</span>
                        <a href="#" class="text-primary hover:text-primary-dark font-medium">Leer más</a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Paginación -->
        <div class="flex justify-center mt-12">
            <nav class="inline-flex rounded-md shadow">
                <a href="#" class="px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-l-md hover:bg-gray-50">Anterior</a>
                <a href="#" class="px-4 py-2 bg-primary text-white border border-primary hover:bg-primary-dark">1</a>
                <a href="#" class="px-4 py-2 bg-white border border-gray-300 text-gray-700 hover:bg-gray-50">2</a>
                <a href="#" class="px-4 py-2 bg-white border border-gray-300 text-gray-700 hover:bg-gray-50">3</a>
                <a href="#" class="px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-r-md hover:bg-gray-50">Siguiente</a>
            </nav>
        </div>
    </div>
</div>
@endsection 