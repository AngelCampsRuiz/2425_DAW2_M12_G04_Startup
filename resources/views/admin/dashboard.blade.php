{{-- HEADER --}}
@extends('layouts.app')

{{-- CONTENIDO --}}
    @section('content')
    <div class="container mx-auto px-4 py-6">
        <!-- Menú hamburguesa para móviles y título del CRUD actual -->
        <div class="flex justify-between items-center mb-6 bg-white rounded-lg shadow p-4">
            <div class="flex items-center">
                <button id="menu-toggle" class="md:hidden mr-4 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-800" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <h1 class="text-xl font-bold text-purple-800 md:hidden">
                    @if(request()->routeIs('admin.publicaciones.*'))
                        OFERTAS
                    @elseif(request()->routeIs('admin.categorias.*'))
                        CATEGORÍAS
                    @elseif(request()->routeIs('admin.subcategorias.*'))
                        SUBCATEGORÍAS
                    @elseif(request()->routeIs('admin.empresas.*'))
                        EMPRESAS
                    @elseif(request()->routeIs('admin.alumnos.*'))
                        ALUMNOS
                    @elseif(request()->routeIs('admin.profesores.*'))
                        PROFESORES
                    @else
                        PANEL DE ADMINISTRACIÓN
                    @endif
                </h1>
            </div>
            <!-- Título centrado para escritorio -->
            <div class="hidden md:block text-center flex-1">
                <h1 class="text-2xl font-bold text-purple-800">
                    @if(request()->routeIs('admin.publicaciones.*'))
                        OFERTAS
                    @elseif(request()->routeIs('admin.categorias.*'))
                        CATEGORÍAS
                    @elseif(request()->routeIs('admin.subcategorias.*'))
                        SUBCATEGORÍAS
                    @elseif(request()->routeIs('admin.empresas.*'))
                        EMPRESAS
                    @elseif(request()->routeIs('admin.alumnos.*'))
                        ALUMNOS
                    @elseif(request()->routeIs('admin.profesores.*'))
                        PROFESORES
                    @else
                        PANEL DE ADMINISTRACIÓN
                    @endif
                </h1>
            </div>
            <!-- Espacio vacío para mantener centrado el título en escritorio -->
            <div class="hidden md:block">
                <div class="w-6"></div>
            </div>
        </div>

        <!-- Menú de navegación -->
        <div class="bg-white shadow-md rounded-lg p-4 mb-6">
            <div class="flex justify-center space-x-4 py-4 border-b border-purple-200 overflow-x-auto">
                <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 {{ Request::routeIs('admin.dashboard') ? 'text-white bg-purple-600' : 'text-purple-600 hover:bg-purple-100' }} rounded-md transition-colors">Dashboard</a>
                <a href="{{ route('admin.publicaciones.index') }}" class="px-4 py-2 {{ Request::routeIs('admin.publicaciones.*') ? 'text-white bg-purple-600' : 'text-purple-600 hover:bg-purple-100' }} rounded-md transition-colors">Ofertas</a>
                <a href="{{ route('admin.categorias.index') }}" class="px-4 py-2 {{ Request::routeIs('admin.categorias.*') ? 'text-white bg-purple-600' : 'text-purple-600 hover:bg-purple-100' }} rounded-md transition-colors">Categorías</a>
                <a href="{{ route('admin.subcategorias.index') }}" class="px-4 py-2 {{ Request::routeIs('admin.subcategorias.*') ? 'text-white bg-purple-600' : 'text-purple-600 hover:bg-purple-100' }} rounded-md transition-colors">Subcategorías</a>
                <a href="{{ route('admin.empresas.index') }}" class="px-4 py-2 {{ Request::routeIs('admin.empresas.*') ? 'text-white bg-purple-600' : 'text-purple-600 hover:bg-purple-100' }} rounded-md transition-colors">Empresas</a>
                <a href="{{ route('admin.alumnos.index') }}" class="px-4 py-2 {{ Request::routeIs('admin.alumnos.*') ? 'text-white bg-purple-600' : 'text-purple-600 hover:bg-purple-100' }} rounded-md transition-colors">Alumnos</a>
                <a href="{{ route('admin.profesores.index') }}" class="px-4 py-2 {{ Request::routeIs('admin.profesores.*') ? 'text-white bg-purple-600' : 'text-purple-600 hover:bg-purple-100' }} rounded-md transition-colors">Profesores</a>
            </div>
        </div>

        @if(request()->routeIs('admin.dashboard'))
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-2xl font-semibold mb-6 text-purple-800">Panel de Administración</h2>
                
                <!-- Stats cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-500">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-sm text-gray-500 font-medium">Total Ofertas</p>
                                <p class="text-2xl font-bold text-gray-800">{{ \App\Models\Publication::count() }}</p>
                            </div>
                            <div class="bg-blue-100 p-3 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                        </div>
                        <div class="mt-2">
                            <p class="text-sm text-green-500">{{ \App\Models\Publication::where('activa', 1)->count() }} activas</p>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-green-500">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-sm text-gray-500 font-medium">Total Empresas</p>
                                <p class="text-2xl font-bold text-gray-800">{{ \App\Models\Empresa::count() }}</p>
                            </div>
                            <div class="bg-green-100 p-3 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                            </div>
                        </div>
                        <div class="mt-2">
                            <p class="text-sm text-green-500">{{ \App\Models\Empresa::count() }} totales</p>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-purple-500">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-sm text-gray-500 font-medium">Total Alumnos</p>
                                <p class="text-2xl font-bold text-gray-800">{{ \App\Models\Estudiante::count() }}</p>
                            </div>
                            <div class="bg-purple-100 p-3 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                            </div>
                        </div>
                        <div class="mt-2">
                            <p class="text-sm text-purple-500">{{ \App\Models\User::where('role_id', 3)->where('activo', 1)->count() }} activos</p>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-yellow-500">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-sm text-gray-500 font-medium">Total Profesores</p>
                                <p class="text-2xl font-bold text-gray-800">{{ \App\Models\User::where('role_id', 4)->count() }}</p>
                            </div>
                            <div class="bg-yellow-100 p-3 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                                </svg>
                            </div>
                        </div>
                        <div class="mt-2">
                            <p class="text-sm text-yellow-500">{{ \App\Models\User::where('role_id', 4)->where('activo', 1)->count() }} activos</p>
                        </div>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-blue-50 rounded-lg p-6 shadow-sm">
                        <div class="flex items-center mb-3">
                            <div class="bg-blue-100 p-3 rounded-full mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-800">Ofertas</h3>
                        </div>
                        <p class="text-gray-600">Gestiona las ofertas de prácticas para los estudiantes.</p>
                        <div class="mt-4">
                            <a href="{{ route('admin.publicaciones.index') }}" class="text-blue-600 hover:text-blue-800 font-medium">
                                Gestionar ofertas →
                            </a>
                        </div>
                    </div>
                    
                    <div class="bg-green-50 rounded-lg p-6 shadow-sm">
                        <div class="flex items-center mb-3">
                            <div class="bg-green-100 p-3 rounded-full mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-800">Empresas</h3>
                        </div>
                        <p class="text-gray-600">Administra las empresas colaboradoras con la plataforma.</p>
                        <div class="mt-4">
                            <a href="{{ route('admin.empresas.index') }}" class="text-green-600 hover:text-green-800 font-medium">
                                Gestionar empresas →
                            </a>
                        </div>
                    </div>
                    
                    <div class="bg-purple-50 rounded-lg p-6 shadow-sm">
                        <div class="flex items-center mb-3">
                            <div class="bg-purple-100 p-3 rounded-full mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-800">Alumnos</h3>
                        </div>
                        <p class="text-gray-600">Gestiona los perfiles de estudiantes registrados.</p>
                        <div class="mt-4">
                            <a href="{{ route('admin.alumnos.index') }}" class="text-purple-600 hover:text-purple-800 font-medium">
                                Gestionar alumnos →
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-yellow-50 rounded-lg p-6 shadow-sm">
                        <div class="flex items-center mb-3">
                            <div class="bg-yellow-100 p-3 rounded-full mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-800">Profesores</h3>
                        </div>
                        <p class="text-gray-600">Gestiona los perfiles de profesores y tutores.</p>
                        <div class="mt-4">
                            <a href="{{ route('admin.profesores.index') }}" class="text-yellow-600 hover:text-yellow-800 font-medium">
                                Gestionar profesores →
                            </a>
                        </div>
                    </div>
                    
                    <div class="bg-indigo-50 rounded-lg p-6 shadow-sm">
                        <div class="flex items-center mb-3">
                            <div class="bg-indigo-100 p-3 rounded-full mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-800">Categorías</h3>
                        </div>
                        <p class="text-gray-600">Gestiona categorías y subcategorías de ofertas.</p>
                        <div class="mt-4">
                            <a href="{{ route('admin.categorias.index') }}" class="text-indigo-600 hover:text-indigo-800 font-medium">
                                Gestionar categorías →
                            </a>
                        </div>
                    </div>
                    
                    <div class="bg-pink-50 rounded-lg p-6 shadow-sm">
                        <div class="flex items-center mb-3">
                            <div class="bg-pink-100 p-3 rounded-full mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-pink-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-800">Subcategorías</h3>
                        </div>
                        <p class="text-gray-600">Gestiona las subcategorías asociadas a cada categoría.</p>
                        <div class="mt-4">
                            <a href="{{ route('admin.subcategorias.index') }}" class="text-pink-600 hover:text-pink-800 font-medium">
                                Gestionar subcategorías →
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gray-50 p-6 rounded-lg shadow-sm">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Actividad reciente</h3>
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <div class="bg-blue-100 p-2 rounded-full mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-gray-800 font-medium">Nueva oferta de prácticas añadida</p>
                                <p class="text-gray-500 text-sm">Hace 2 horas</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="bg-green-100 p-2 rounded-full mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-gray-800 font-medium">Nueva empresa registrada</p>
                                <p class="text-gray-500 text-sm">Hace 1 día</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="bg-purple-100 p-2 rounded-full mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-gray-800 font-medium">Nuevo alumno registrado</p>
                                <p class="text-gray-500 text-sm">Hace 3 días</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Contenido principal -->
        <div class="bg-white shadow-md rounded-lg p-6">
            @yield('admin_content')
        </div>
    </div>

    <!-- JavaScript para el menú hamburguesa -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const menuToggle = document.getElementById('menu-toggle');
            const menuNav = document.getElementById('menu-nav');
            
            menuToggle.addEventListener('click', function() {
                menuNav.classList.toggle('hidden');
            });
            
            // Ocultar menú en pantallas pequeñas cuando se hace clic en un enlace
            const menuLinks = menuNav.querySelectorAll('a');
            menuLinks.forEach(link => {
                link.addEventListener('click', function() {
                    if (window.innerWidth < 768) { // 768px es el breakpoint md de Tailwind
                        menuNav.classList.add('hidden');
                    }
                });
            });
            
            // Ajustar visibilidad del menú en cambio de tamaño de ventana
            window.addEventListener('resize', function() {
                if (window.innerWidth >= 768) {
                    menuNav.classList.remove('hidden');
                } else {
                    menuNav.classList.add('hidden');
                }
            });
        });
    </script>
    
    <!-- CSRF token para AJAX -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    @yield('scripts')
    @endsection
