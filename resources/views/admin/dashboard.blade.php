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
                    @elseif(request()->routeIs('admin.instituciones.*'))
                        INSTITUCIONES
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
                    @elseif(request()->routeIs('admin.instituciones.*'))
                        INSTITUCIONES
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
            <!-- Menú para escritorio -->
            <div class="hidden md:flex justify-center space-x-4 py-4 border-b border-purple-200">
                <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 {{ request()->routeIs('admin.dashboard') ? 'text-white bg-purple-600' : 'text-purple-600 hover:bg-purple-100' }} rounded-md transition-colors">Dashboard</a>
                <a href="{{ route('admin.publicaciones.index') }}" class="px-4 py-2 {{ request()->routeIs('admin.publicaciones.*') ? 'text-white bg-purple-600' : 'text-purple-600 hover:bg-purple-100' }} rounded-md transition-colors">Ofertas</a>
                <a href="{{ route('admin.categorias.index') }}" class="px-4 py-2 {{ request()->routeIs('admin.categorias.*') ? 'text-white bg-purple-600' : 'text-purple-600 hover:bg-purple-100' }} rounded-md transition-colors">Categorías</a>
                <a href="{{ route('admin.subcategorias.index') }}" class="px-4 py-2 {{ request()->routeIs('admin.subcategorias.*') ? 'text-white bg-purple-600' : 'text-purple-600 hover:bg-purple-100' }} rounded-md transition-colors">Subcategorías</a>
                <a href="{{ route('admin.empresas.index') }}" class="px-4 py-2 {{ request()->routeIs('admin.empresas.*') ? 'text-white bg-purple-600' : 'text-purple-600 hover:bg-purple-100' }} rounded-md transition-colors">Empresas</a>
                <a href="{{ route('admin.instituciones.index') }}" class="px-4 py-2 {{ request()->routeIs('admin.instituciones.*') ? 'text-white bg-purple-600' : 'text-purple-600 hover:bg-purple-100' }} rounded-md transition-colors">Instituciones</a>
                <a href="{{ route('admin.alumnos.index') }}" class="px-4 py-2 {{ request()->routeIs('admin.alumnos.*') ? 'text-white bg-purple-600' : 'text-purple-600 hover:bg-purple-100' }} rounded-md transition-colors">Alumnos</a>
                <a href="{{ route('admin.profesores.index') }}" class="px-4 py-2 {{ request()->routeIs('admin.profesores.*') ? 'text-white bg-purple-600' : 'text-purple-600 hover:bg-purple-100' }} rounded-md transition-colors">Profesores</a>
            </div>
            
            <!-- Menú móvil desplegable -->
            <div id="mobile-menu" class="md:hidden">
                <div class="space-y-2 py-3">
                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 {{ request()->routeIs('admin.dashboard') ? 'text-white bg-purple-600' : 'text-purple-600 hover:bg-purple-100' }} rounded-md transition-colors">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            Dashboard
                        </div>
                    </a>
                    <a href="{{ route('admin.publicaciones.index') }}" class="block px-4 py-2 {{ request()->routeIs('admin.publicaciones.*') ? 'text-white bg-purple-600' : 'text-purple-600 hover:bg-purple-100' }} rounded-md transition-colors">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Ofertas
                        </div>
                    </a>
                    <a href="{{ route('admin.categorias.index') }}" class="block px-4 py-2 {{ request()->routeIs('admin.categorias.*') ? 'text-white bg-purple-600' : 'text-purple-600 hover:bg-purple-100' }} rounded-md transition-colors">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                            </svg>
                            Categorías
                        </div>
                    </a>
                    <a href="{{ route('admin.subcategorias.index') }}" class="block px-4 py-2 {{ request()->routeIs('admin.subcategorias.*') ? 'text-white bg-purple-600' : 'text-purple-600 hover:bg-purple-100' }} rounded-md transition-colors">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2" />
                            </svg>
                            Subcategorías
                        </div>
                    </a>
                    <a href="{{ route('admin.empresas.index') }}" class="block px-4 py-2 {{ request()->routeIs('admin.empresas.*') ? 'text-white bg-purple-600' : 'text-purple-600 hover:bg-purple-100' }} rounded-md transition-colors">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            Empresas
                        </div>
                    </a>
                    <a href="{{ route('admin.instituciones.index') }}" class="block px-4 py-2 {{ request()->routeIs('admin.instituciones.*') ? 'text-white bg-purple-600' : 'text-purple-600 hover:bg-purple-100' }} rounded-md transition-colors">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" />
                            </svg>
                            Instituciones
                        </div>
                    </a>
                    <a href="{{ route('admin.alumnos.index') }}" class="block px-4 py-2 {{ request()->routeIs('admin.alumnos.*') ? 'text-white bg-purple-600' : 'text-purple-600 hover:bg-purple-100' }} rounded-md transition-colors">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                            Alumnos
                        </div>
                    </a>
                    <a href="{{ route('admin.profesores.index') }}" class="block px-4 py-2 {{ request()->routeIs('admin.profesores.*') ? 'text-white bg-purple-600' : 'text-purple-600 hover:bg-purple-100' }} rounded-md transition-colors">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                            </svg>
                            Profesores
                        </div>
                    </a>
                </div>
            </div>
        </div>

        @if(request()->routeIs('admin.dashboard'))
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-2xl font-semibold mb-6 text-purple-800">Panel de Administración</h2>
                
                <!-- Resumen de estadísticas -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                    <!-- Tarjeta de Ofertas -->
                    <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg shadow-md overflow-hidden border border-blue-200">
                        <div class="p-5">
                            <div class="flex justify-between items-center mb-3">
                            <div>
                                    <p class="text-sm text-blue-600 font-medium">Total Ofertas</p>
                                    <p class="text-2xl font-bold text-blue-800">{{ $stats['ofertas']['total'] }}</p>
                            </div>
                            <div class="bg-blue-100 p-3 rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                        </div>
                            <div class="flex items-center">
                                <div class="w-full">
                                    <div class="flex justify-between mb-1 text-xs text-blue-700">
                                        <span>{{ $stats['ofertas']['activas'] }} activas</span>
                                        <span>{{ $stats['ofertas']['total'] > 0 ? round(($stats['ofertas']['activas'] / $stats['ofertas']['total']) * 100) : 0 }}%</span>
                                    </div>
                                    <div class="w-full bg-blue-200 rounded-full h-2">
                                        <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $stats['ofertas']['total'] > 0 ? ($stats['ofertas']['activas'] / $stats['ofertas']['total']) * 100 : 0 }}%"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3 text-xs font-medium">
                                @if($stats['ofertas']['crecimiento'] > 0)
                                <span class="text-green-600 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                                    </svg>
                                    +{{ $stats['ofertas']['crecimiento'] }}% en la última semana
                                </span>
                                @elseif($stats['ofertas']['crecimiento'] < 0)
                                <span class="text-red-600 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                                    </svg>
                                    {{ $stats['ofertas']['crecimiento'] }}% en la última semana
                                </span>
                                @else
                                <span class="text-gray-600 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14" />
                                    </svg>
                                    Sin cambios en la última semana
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <!-- Tarjeta de Empresas -->
                    <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-lg shadow-md overflow-hidden border border-green-200">
                        <div class="p-5">
                            <div class="flex justify-between items-center mb-3">
                            <div>
                                    <p class="text-sm text-green-600 font-medium">Total Empresas</p>
                                    <p class="text-2xl font-bold text-green-800">{{ $stats['empresas']['total'] }}</p>
                            </div>
                            <div class="bg-green-100 p-3 rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                            </div>
                        </div>
                            <div class="flex items-center">
                                <div class="w-full">
                                    <div class="flex justify-between mb-1 text-xs text-green-700">
                                        <span>{{ $stats['empresas']['activas'] }} activas</span>
                                        <span>{{ $stats['empresas']['total'] > 0 ? round(($stats['empresas']['activas'] / $stats['empresas']['total']) * 100) : 0 }}%</span>
                                    </div>
                                    <div class="w-full bg-green-200 rounded-full h-2">
                                        <div class="bg-green-600 h-2 rounded-full" style="width: {{ $stats['empresas']['total'] > 0 ? ($stats['empresas']['activas'] / $stats['empresas']['total']) * 100 : 0 }}%"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3 text-xs font-medium">
                                @if($stats['empresas']['crecimiento'] > 0)
                                <span class="text-green-600 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                                    </svg>
                                    +{{ $stats['empresas']['crecimiento'] }}% en la última semana
                                </span>
                                @elseif($stats['empresas']['crecimiento'] < 0)
                                <span class="text-red-600 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                                    </svg>
                                    {{ $stats['empresas']['crecimiento'] }}% en la última semana
                                </span>
                                @else
                                <span class="text-gray-600 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14" />
                                    </svg>
                                    Sin cambios en la última semana
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <!-- Tarjeta de Alumnos -->
                    <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-lg shadow-md overflow-hidden border border-purple-200">
                        <div class="p-5">
                            <div class="flex justify-between items-center mb-3">
                            <div>
                                    <p class="text-sm text-purple-600 font-medium">Total Alumnos</p>
                                    <p class="text-2xl font-bold text-purple-800">{{ $stats['alumnos']['total'] }}</p>
                            </div>
                            <div class="bg-purple-100 p-3 rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                            </div>
                        </div>
                            <div class="flex items-center">
                                <div class="w-full">
                                    <div class="flex justify-between mb-1 text-xs text-purple-700">
                                        <span>{{ $stats['alumnos']['activos'] }} activos</span>
                                        <span>{{ $stats['alumnos']['total'] > 0 ? round(($stats['alumnos']['activos'] / $stats['alumnos']['total']) * 100) : 0 }}%</span>
                                    </div>
                                    <div class="w-full bg-purple-200 rounded-full h-2">
                                        <div class="bg-purple-600 h-2 rounded-full" style="width: {{ $stats['alumnos']['total'] > 0 ? ($stats['alumnos']['activos'] / $stats['alumnos']['total']) * 100 : 0 }}%"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3 text-xs font-medium">
                                @if($stats['alumnos']['crecimiento'] > 0)
                                <span class="text-green-600 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                                    </svg>
                                    +{{ $stats['alumnos']['crecimiento'] }}% en la última semana
                                </span>
                                @elseif($stats['alumnos']['crecimiento'] < 0)
                                <span class="text-red-600 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                                    </svg>
                                    {{ $stats['alumnos']['crecimiento'] }}% en la última semana
                                </span>
                                @else
                                <span class="text-gray-600 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14" />
                                    </svg>
                                    Sin cambios en la última semana
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <!-- Tarjeta de Profesores -->
                    <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-lg shadow-md overflow-hidden border border-yellow-200">
                        <div class="p-5">
                            <div class="flex justify-between items-center mb-3">
                            <div>
                                    <p class="text-sm text-yellow-600 font-medium">Total Profesores</p>
                                    <p class="text-2xl font-bold text-yellow-800">{{ $stats['profesores']['total'] }}</p>
                            </div>
                            <div class="bg-yellow-100 p-3 rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                                </svg>
                            </div>
                        </div>
                            <div class="flex items-center">
                                <div class="w-full">
                                    <div class="flex justify-between mb-1 text-xs text-yellow-700">
                                        <span>{{ $stats['profesores']['activos'] }} activos</span>
                                        <span>{{ $stats['profesores']['total'] > 0 ? round(($stats['profesores']['activos'] / $stats['profesores']['total']) * 100) : 0 }}%</span>
                                    </div>
                                    <div class="w-full bg-yellow-200 rounded-full h-2">
                                        <div class="bg-yellow-600 h-2 rounded-full" style="width: {{ $stats['profesores']['total'] > 0 ? ($stats['profesores']['activos'] / $stats['profesores']['total']) * 100 : 0 }}%"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3 text-xs font-medium">
                                @if($stats['profesores']['crecimiento'] > 0)
                                <span class="text-green-600 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                                    </svg>
                                    +{{ $stats['profesores']['crecimiento'] }}% en la última semana
                                </span>
                                @elseif($stats['profesores']['crecimiento'] < 0)
                                <span class="text-red-600 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                                    </svg>
                                    {{ $stats['profesores']['crecimiento'] }}% en la última semana
                                </span>
                                @else
                                <span class="text-gray-600 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14" />
                                    </svg>
                                    Sin cambios en la última semana
                                </span>
                                @endif
                            </div>
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
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-yellow-50 rounded-lg p-6 shadow-sm">
                        <div class="flex items-center mb-3">
                            <div class="bg-yellow-100 p-3 rounded-full mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-800">Instituciones</h3>
                        </div>
                        <p class="text-gray-600">Administra las instituciones educativas de la plataforma.</p>
                        <div class="mt-4">
                            <a href="{{ route('admin.instituciones.index') }}" class="text-yellow-600 hover:text-yellow-800 font-medium">
                                Gestionar instituciones →
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Últimas Ofertas -->
                <div class="bg-gradient-to-r from-purple-50 to-indigo-50 rounded-lg p-6 shadow-md border border-purple-200 mb-8">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-xl font-semibold text-purple-800">Últimas Ofertas Publicadas</h3>
                        <a href="{{ route('admin.publicaciones.index') }}" class="bg-purple-600 hover:bg-purple-700 text-white text-sm font-medium px-4 py-2 rounded transition-colors">Ver todas</a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-purple-200">
                            <thead class="bg-purple-100">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-purple-800 uppercase tracking-wider">Título</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-purple-800 uppercase tracking-wider">Empresa</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-purple-800 uppercase tracking-wider">Categoría</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-purple-800 uppercase tracking-wider">Estado</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-purple-800 uppercase tracking-wider">Fecha</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-purple-100">
                                @forelse($ultimas_ofertas as $oferta)
                                <tr class="hover:bg-purple-50 transition-colors">
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <div class="text-sm font-medium text-purple-900">{{ $oferta->titulo }}</div>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $oferta->empresa->user->nombre }}</div>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $oferta->categoria->nombre }}</div>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $oferta->activa ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $oferta->activa ? 'Activa' : 'Inactiva' }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                        {{ $oferta->created_at->format('d/m/Y') }}
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-3 text-center text-gray-500">
                                        No hay ofertas recientes
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <!-- Widgets de estadísticas importantes y usuarios recientes -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                    <!-- Columna 1: Últimos usuarios -->
                    <div class="bg-gradient-to-br from-purple-50 to-indigo-50 rounded-lg p-6 shadow-md border border-purple-200">
                        <h3 class="text-xl font-semibold text-purple-800 mb-4">Últimos Usuarios</h3>
                    <div class="space-y-4">
                            @forelse($nuevos_usuarios as $usuario)
                            <div class="flex items-center bg-white p-3 rounded-lg shadow-sm">
                                <div class="flex-shrink-0">
                                    @if($usuario->imagen)
                                        <img class="h-10 w-10 rounded-full object-cover" src="{{ asset('profile_images/' . $usuario->imagen) }}" alt="{{ $usuario->nombre }}">
                                    @else
                                        <div class="h-10 w-10 rounded-full bg-purple-100 flex items-center justify-center">
                                            <span class="text-purple-800 font-medium">{{ substr($usuario->nombre, 0, 2) }}</span>
                                        </div>
                                    @endif
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-800">{{ $usuario->nombre }}</p>
                                    <p class="text-xs text-gray-500">
                                        @switch($usuario->role_id)
                                            @case(1)
                                                <span class="text-red-600">Administrador</span>
                                                @break
                                            @case(2)
                                                <span class="text-green-600">Empresa</span>
                                                @break
                                            @case(3)
                                                <span class="text-purple-600">Estudiante</span>
                                                @break
                                            @case(4)
                                                <span class="text-yellow-600">Profesor</span>
                                                @break
                                            @case(5)
                                                <span class="text-blue-600">Institución</span>
                                                @break
                                            @default
                                                Usuario
                                        @endswitch
                                        - {{ $usuario->created_at->diffForHumans() }}
                                    </p>
                                </div>
                            </div>
                            @empty
                            <div class="text-center text-gray-500">
                                No hay usuarios recientes
                            </div>
                            @endforelse
                        </div>
                    </div>
                    
                    <!-- Columna 2: Resumen de estadísticas -->
                    <div class="bg-gradient-to-br from-purple-50 to-indigo-50 rounded-lg p-6 shadow-md border border-purple-200">
                        <h3 class="text-xl font-semibold text-purple-800 mb-4">Resumen del Sistema</h3>
                        <div class="space-y-4">
                            <div class="bg-white p-4 rounded-lg shadow-sm">
                                <div class="flex justify-between items-center">
                                    <div class="flex items-center">
                                        <div class="bg-purple-100 p-2 rounded-full mr-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                        </div>
                                        <p class="font-medium text-gray-700">Categorías activas</p>
                                    </div>
                                    <p class="text-lg font-bold text-purple-700">{{ $stats['categorias']['total'] }}</p>
                                </div>
                            </div>
                            
                            <div class="bg-white p-4 rounded-lg shadow-sm">
                                <div class="flex justify-between items-center">
                                    <div class="flex items-center">
                                        <div class="bg-purple-100 p-2 rounded-full mr-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4" />
                                            </svg>
                                        </div>
                                        <p class="font-medium text-gray-700">Subcategorías activas</p>
                                    </div>
                                    <p class="text-lg font-bold text-purple-700">{{ $stats['subcategorias']['total'] }}</p>
                            </div>
                        </div>
                        
                            <div class="bg-white p-4 rounded-lg shadow-sm">
                                <div class="flex justify-between items-center">
                                    <div class="flex items-center">
                                        <div class="bg-purple-100 p-2 rounded-full mr-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" />
                                </svg>
                                        </div>
                                        <p class="font-medium text-gray-700">Instituciones registradas</p>
                                    </div>
                                    <p class="text-lg font-bold text-purple-700">{{ $stats['instituciones']['total'] }}</p>
                                </div>
                            </div>
                            
                            <div class="bg-white p-4 rounded-lg shadow-sm">
                                <div class="flex justify-between items-center">
                                    <div class="flex items-center">
                                        <div class="bg-purple-100 p-2 rounded-full mr-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4" />
                                            </svg>
                                        </div>
                                        <p class="font-medium text-gray-700">Tasa de conversión</p>
                                    </div>
                                    <p class="text-lg font-bold text-purple-700">
                                        {{ $stats['ofertas']['total'] > 0 ? round(($stats['ofertas']['activas'] / $stats['ofertas']['total']) * 100) : 0 }}%
                                    </p>
                                </div>
                            </div>
                            </div>
                        </div>
                        
                    <!-- Columna 3: Actividad reciente -->
                    <div class="bg-gradient-to-br from-purple-50 to-indigo-50 rounded-lg p-6 shadow-md border border-purple-200">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-xl font-semibold text-purple-800">Actividad Reciente</h3>
                            <span id="timestamp" class="text-xs text-purple-500 font-medium bg-purple-50 px-2 py-1 rounded"></span>
                        </div>
                        <div class="divide-y divide-purple-100">
                            @forelse($actividad_reciente as $actividad)
                            <div class="py-3 flex items-start bg-white p-3 my-2 rounded-lg shadow-sm">
                                <div class="mr-3">
                                    {!! $actividad->getIconHtml() !!}
                                </div>
                                <div class="flex-1">
                                    <div class="flex justify-between">
                                        <p class="text-gray-800 font-medium">{{ $actividad->description }}</p>
                                        <span class="text-xs text-gray-500">{{ $actividad->getTimeAgo() }}</span>
                                    </div>
                                    <p class="text-sm text-gray-600">
                                        @if($actividad->user)
                                            <span class="font-medium text-purple-600">{{ $actividad->user->nombre }}</span>
                                        @else
                                            <span class="font-medium text-gray-600">Sistema</span>
                                        @endif
                                        - {{ ucfirst($actividad->type) }} {{ $actividad->subject_type }}
                                    </p>
                                </div>
                            </div>
                            @empty
                            <div class="py-4 text-center text-gray-600 bg-white rounded-lg shadow-sm">
                                <div class="flex flex-col items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-purple-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <p class="text-purple-600 font-medium mb-1">No hay actividad reciente para mostrar</p>
                                    <p class="text-sm">Los registros de actividad aparecerán aquí cuando se realicen cambios en el sistema</p>
                                </div>
                            </div>
                            @endforelse
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
            const mobileMenu = document.getElementById('mobile-menu');
            let isMenuVisible = false;

            // Inicialmente ocultar el menú móvil
            mobileMenu.style.display = 'none';

            menuToggle.addEventListener('click', function() {
                isMenuVisible = !isMenuVisible;
                
                // Cambiar el ícono del botón
                if (isMenuVisible) {
                    menuToggle.innerHTML = `
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-800" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    `;
                    mobileMenu.style.display = 'block';
                    
                    // Añadir animación de entrada
                    mobileMenu.classList.add('animate-fade-in-down');
                } else {
                    menuToggle.innerHTML = `
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-800" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    `;
                    
                    // Añadir animación de salida
                    mobileMenu.classList.add('animate-fade-out-up');
                    setTimeout(() => {
                        mobileMenu.style.display = 'none';
                        mobileMenu.classList.remove('animate-fade-out-up');
                    }, 200);
                }
            });

            // Cerrar el menú al hacer clic en un enlace
            const mobileLinks = mobileMenu.querySelectorAll('a');
            mobileLinks.forEach(link => {
                link.addEventListener('click', () => {
                    isMenuVisible = false;
                    mobileMenu.style.display = 'none';
                    menuToggle.innerHTML = `
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-800" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    `;
                });
            });

            // Actualizar la hora de España
            function actualizarHoraEspana() {
                const timestamp = document.getElementById('timestamp');
                if (timestamp) {
                    // Crear fecha con hora de España (UTC+1)
                    const now = new Date();
                    // Ajustar a la hora de España (UTC+1 o UTC+2 según horario de verano)
                    const horaEspana = new Date();
                    timestamp.textContent = horaEspana.toLocaleTimeString('es-ES');
                }
            }

            // Actualizar hora inicialmente
            actualizarHoraEspana();
            
            // Actualizar cada segundo
            setInterval(actualizarHoraEspana, 1000);
            
            // Actualizar actividad reciente cada minuto (simulación)
            function actualizarActividadReciente() {
                // Aquí puedes hacer una petición AJAX para obtener datos actualizados
                // Esta es la parte que necesitaría implementarse para actualizar la actividad en tiempo real
                console.log('Actualizando actividad reciente...');
            }
            
            // Actualizar cada 60 segundos la actividad
            setInterval(actualizarActividadReciente, 60000);
        });
    </script>
    
    <!-- CSRF token para AJAX -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    @if(request()->routeIs('admin.dashboard'))
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Configuración de colores
            const colors = {
                blue: {
                    primary: '#3b82f6',
                    secondary: 'rgba(59, 130, 246, 0.1)',
                    border: 'rgba(59, 130, 246, 0.5)'
                },
                purple: {
                    primary: '#8b5cf6',
                    secondary: 'rgba(139, 92, 246, 0.1)',
                    border: 'rgba(139, 92, 246, 0.5)'
                },
                green: {
                    primary: '#10b981',
                    secondary: 'rgba(16, 185, 129, 0.1)',
                    border: 'rgba(16, 185, 129, 0.5)'
                },
                yellow: {
                    primary: '#f59e0b',
                    secondary: 'rgba(245, 158, 11, 0.1)',
                    border: 'rgba(245, 158, 11, 0.5)'
                },
                red: {
                    primary: '#ef4444',
                    secondary: 'rgba(239, 68, 68, 0.1)',
                    border: 'rgba(239, 68, 68, 0.5)'
                },
                indigo: {
                    primary: '#6366f1',
                    secondary: 'rgba(99, 102, 241, 0.1)',
                    border: 'rgba(99, 102, 241, 0.5)'
                },
                pink: {
                    primary: '#ec4899',
                    secondary: 'rgba(236, 72, 153, 0.1)',
                    border: 'rgba(236, 72, 153, 0.5)'
                }
            };
            
            // Gráfico de Ofertas por Mes
            const ofertasCtx = document.getElementById('ofertasMensualesChart').getContext('2d');
            const ofertasData = @json($chartData['ofertas_mensuales']);
            
            new Chart(ofertasCtx, {
                type: 'line',
                data: {
                    labels: ofertasData.labels,
                    datasets: [{
                        label: 'Ofertas Publicadas',
                        data: ofertasData.data,
                        backgroundColor: colors.blue.secondary,
                        borderColor: colors.blue.primary,
                        borderWidth: 2,
                        tension: 0.3,
                        pointBackgroundColor: colors.blue.primary,
                        pointRadius: 3,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false,
                            backgroundColor: '#fff',
                            titleColor: '#1f2937',
                            bodyColor: '#1f2937',
                            borderColor: '#e5e7eb',
                            borderWidth: 1,
                            padding: 10,
                            titleFont: {
                                size: 14,
                                weight: 'bold'
                            },
                            bodyFont: {
                                size: 13
                            },
                            callbacks: {
                                label: function(context) {
                                    return `Ofertas: ${context.raw}`;
                                }
                            }
                        }
                    }
                }
            });
            
            // Gráfico de Ofertas por Día (última semana)
            const ofertasDiariasCtx = document.getElementById('ofertasDiariasChart').getContext('2d');
            const ofertasDiariasData = @json($chartData['ofertas_por_dia']);
            
            new Chart(ofertasDiariasCtx, {
                type: 'bar',
                data: {
                    labels: ofertasDiariasData.labels,
                    datasets: [{
                        label: 'Ofertas Publicadas',
                        data: ofertasDiariasData.data,
                        backgroundColor: colors.indigo.primary,
                        borderColor: colors.indigo.border,
                        borderWidth: 2,
                        borderRadius: 5,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: '#fff',
                            titleColor: '#1f2937',
                            bodyColor: '#1f2937',
                            borderColor: '#e5e7eb',
                            borderWidth: 1,
                            padding: 10,
                            callbacks: {
                                label: function(context) {
                                    return `Ofertas: ${context.raw}`;
                                }
                            }
                        }
                    }
                }
            });
            
            // Gráfico de Usuarios por Rol
            const usuariosCtx = document.getElementById('usuariosPorRolChart').getContext('2d');
            const usuariosData = @json($chartData['usuarios_por_rol']);
            
            new Chart(usuariosCtx, {
                type: 'doughnut',
                data: {
                    labels: usuariosData.labels,
                    datasets: [{
                        data: usuariosData.data,
                        backgroundColor: [
                            colors.purple.primary,
                            colors.green.primary,
                            colors.blue.primary,
                            colors.yellow.primary,
                            colors.indigo.primary
                        ],
                        borderColor: '#fff',
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        },
                        tooltip: {
                            backgroundColor: '#fff',
                            titleColor: '#1f2937',
                            bodyColor: '#1f2937',
                            borderColor: '#e5e7eb',
                            borderWidth: 1,
                            padding: 10,
                            callbacks: {
                                label: function(context) {
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const percentage = Math.round((context.raw / total) * 100);
                                    return `${context.label}: ${context.raw} (${percentage}%)`;
                                }
                            }
                        }
                    }
                }
            });
            
            // Actualizar datos en tiempo real (simulación)
            function actualizarDatosEnTiempoReal() {
                // Aquí puedes hacer una petición AJAX para obtener datos actualizados
                // Por ahora, solo actualizamos el contador de actualización
                const timestamp = document.querySelector('#timestamp');
                if (timestamp) {
                    timestamp.textContent = new Date().toLocaleTimeString();
                }
            }
            
            // Actualizar cada 60 segundos
            setInterval(actualizarDatosEnTiempoReal, 60000);
        });
    </script>
    @endpush
    @endif
    @endsection

<style>
    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeOutUp {
        from {
            opacity: 1;
            transform: translateY(0);
        }
        to {
            opacity: 0;
            transform: translateY(-10px);
        }
    }

    .animate-fade-in-down {
        animation: fadeInDown 0.2s ease-out forwards;
    }

    .animate-fade-out-up {
        animation: fadeOutUp 0.2s ease-out forwards;
    }
</style>
