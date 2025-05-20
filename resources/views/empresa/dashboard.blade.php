{{-- HEADER --}}
@extends('layouts.app')

{{-- CONTENIDO --}}
@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-purple-50">
    {{-- MIGAS DE PAN STICKY --}}
    <div class="bg-white shadow-sm sticky top-0 z-10">
        <div class="container mx-auto px-4 py-3">
            <div class="flex items-center text-sm">
                <a href="{{ route('home') }}" class="text-gray-500 hover:text-purple-700 transition-colors duration-200">
                    <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    Inicio
                </a>
                <span class="mx-2 text-gray-400">/</span>
                <span class="text-purple-700 font-medium">Dashboard</span>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">

        <div class="flex flex-col md:flex-row gap-6">
            <!-- Sidebar -->
            <div class="w-full md:w-1/4">
                <div class="bg-white rounded-xl shadow-lg p-6 mb-6 hover:shadow-xl transition-shadow duration-300">
                    <div class="flex items-center space-x-4 mb-6">
                        @if(Auth::user()->imagen)
                            <div class="relative flex items-center justify-center w-16 h-16 rounded-full bg-purple-50 border-2 border-purple-200 overflow-hidden">
                                <img src="{{ asset('profile_images/' . Auth::user()->imagen) }}" alt="Logo empresa" class="w-full h-full object-contain">
                                <div class="absolute bottom-0 right-0 w-4 h-4 bg-green-400 rounded-full border-2 border-white"></div>
                            </div>
                        @else
                            <div class="relative">
                                <div class="w-16 h-16 rounded-full bg-gradient-to-br from-purple-400 to-indigo-500 flex items-center justify-center text-white text-xl font-bold shadow-md">
                                    {{ strtoupper(substr(Auth::user()->nombre, 0, 2)) }}
                                </div>
                                <div class="absolute bottom-0 right-0 w-4 h-4 bg-green-400 rounded-full border-2 border-white"></div>
                            </div>
                        @endif
                        <div>
                            <h2 class="text-lg font-bold text-gray-800">{{ Auth::user()->nombre }}</h2>
                            <p class="text-indigo-600 font-medium">Empresa</p>
                        </div>
                    </div>
                    <div class="border-t pt-4">
                        <p class="text-gray-600 mb-2 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                            </svg>
                            CIF: <span class="font-medium text-gray-800 ml-1">{{ Auth::user()->empresa->cif ?? 'No especificado' }}</span>
                        </p>
                        {{-- <p class="text-gray-600 mb-2 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            Sector: <span class="font-medium text-gray-800 ml-1">{{ Auth::user()->empresa->sector ?? 'No especificado' }}</span>
                        </p> --}}
                        <p class="text-gray-600 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Estado: <span class="bg-gradient-to-r from-green-100 to-green-200 text-green-800 px-2 py-1 rounded-full text-xs font-medium ml-1 shadow-sm">Activa</span>
                        </p>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow duration-300">
                    <h3 class="font-bold text-lg mb-4 text-gray-800 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
                        </svg>
                        Menú
                    </h3>
                    <nav>
                        <ul class="space-y-2">
                            <li><a href="{{ route('empresa.dashboard') }}" class="flex items-center p-2 {{ Route::currentRouteName() == 'empresa.dashboard' ? 'bg-gradient-to-r from-purple-50 to-purple-100 text-purple-700 border-l-4 border-purple-600' : 'text-gray-700 hover:bg-gray-50' }} rounded-lg font-medium transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 {{ Route::currentRouteName() == 'empresa.dashboard' ? 'text-purple-600' : 'text-gray-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7m-14 0l2 2m0 0l7 7 7-7m-14 0l2-2" />
                                </svg>
                                Dashboard
                            </a></li>
                            <li><a href="{{ route('profile') }}" class="flex items-center p-2 {{ Route::currentRouteName() == 'profile' ? 'bg-gradient-to-r from-purple-50 to-purple-100 text-purple-700 border-l-4 border-purple-600' : 'text-gray-700 hover:bg-gray-50' }} rounded-lg transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 {{ Route::currentRouteName() == 'profile' ? 'text-purple-600' : 'text-gray-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                Perfil de empresa
                            </a></li>
                            <li><a href="{{ route('empresa.calendar') }}" class="flex items-center p-2 {{ Route::currentRouteName() == 'empresa.calendar' ? 'bg-gradient-to-r from-purple-50 to-purple-100 text-purple-700 border-l-4 border-purple-600' : 'text-gray-700 hover:bg-gray-50' }} rounded-lg transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 {{ Route::currentRouteName() == 'empresa.calendar' ? 'text-purple-600' : 'text-gray-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Calendario
                            </a></li>
                            <li><a href="javascript:void(0)" onclick="openSearchCandidatesModal()" class="flex items-center p-2 text-gray-700 hover:bg-gray-50 rounded-lg transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                Buscar candidatos
                            </a></li>
                            <li><a href="javascript:void(0)" onclick="openModal()" class="flex items-center p-2 {{ Route::currentRouteName() == 'empresa.offers.create' ? 'bg-gradient-to-r from-purple-50 to-purple-100 text-purple-700 border-l-4 border-purple-600' : 'text-gray-700 hover:bg-gray-50' }} rounded-lg transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 {{ Route::currentRouteName() == 'empresa.offers.create' ? 'text-purple-600' : 'text-gray-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                Publicar oferta
                            </a></li>
                            <li><a href="{{ route('empresa.offers.active') }}" class="flex items-center p-2 {{ Route::currentRouteName() == 'empresa.offers.active' ? 'bg-gradient-to-r from-purple-50 to-purple-100 text-purple-700 border-l-4 border-purple-600' : 'text-gray-700 hover:bg-gray-50' }} rounded-lg transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 {{ Route::currentRouteName() == 'empresa.offers.active' ? 'text-purple-600' : 'text-gray-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Ofertas Activas
                            </a></li>
                            <li><a href="{{ route('empresa.offers.inactive') }}" class="flex items-center p-2 {{ Route::currentRouteName() == 'empresa.offers.inactive' ? 'bg-gradient-to-r from-purple-50 to-purple-100 text-purple-700 border-l-4 border-purple-600' : 'text-gray-700 hover:bg-gray-50' }} rounded-lg transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 {{ Route::currentRouteName() == 'empresa.offers.inactive' ? 'text-purple-600' : 'text-gray-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Ofertas Inactivas
                            </a></li>
                            <li><a href="{{ route('empresa.convenios') }}" class="flex items-center p-2 {{ Route::currentRouteName() == 'empresa.convenios' ? 'bg-gradient-to-r from-purple-50 to-purple-100 text-purple-700 border-l-4 border-purple-600' : 'text-gray-700 hover:bg-gray-50' }} rounded-lg transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 {{ Route::currentRouteName() == 'empresa.convenios' ? 'text-purple-600' : 'text-gray-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Convenios
                            </a></li>
                            <li><a href="{{ route('chat.index') }}" class="flex items-center p-2 {{ Route::currentRouteName() == 'chat.index' ? 'bg-gradient-to-r from-purple-50 to-purple-100 text-purple-700 border-l-4 border-purple-600' : 'text-gray-700 hover:bg-gray-50' }} rounded-lg transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 {{ Route::currentRouteName() == 'chat.index' ? 'text-purple-600' : 'text-gray-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                </svg>
                                Mensajes
                            </a></li>
                        </ul>
                    </nav>
                </div>
            </div>

            <!-- Main Content -->
            <div class="w-full md:w-3/4">
                <div class="bg-white rounded-xl shadow-lg p-6 mb-6 hover:shadow-xl transition-shadow duration-300">
                    <h1 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 mr-3 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                        Panel de empresa
                    </h1>

                    <!-- Estadísticas -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                        <div class="bg-gradient-to-br from-purple-50 to-purple-100 p-5 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 border border-purple-100 transform hover:-translate-y-1">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="font-medium text-purple-800 mb-1">Ofertas activas</h3>
                                    <p class="text-3xl font-bold text-purple-900" id="activePublicationsCount">{{ $activePublications->count() }}</p>
                                </div>
                                <div class="bg-white p-3 rounded-lg shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="mt-4 text-sm text-purple-700">
                                <div class="flex items-center">
                                    <span class="font-medium">Activas</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gradient-to-br from-green-50 to-green-100 p-5 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 border border-green-100 transform hover:-translate-y-1">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="font-medium text-green-800 mb-1">Total solicitudes</h3>
                                    <p class="text-3xl font-bold text-green-900" id="totalSolicitudesCount">{{ $activePublications->sum('solicitudes_count') + $inactivePublications->sum('solicitudes_count') }}</p>
                                </div>
                                <div class="bg-white p-3 rounded-lg shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="mt-4 text-sm text-green-700">
                                <div class="flex items-center">
                                    <span class="font-medium">Solicitudes</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-5 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 border border-blue-100 transform hover:-translate-y-1">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="font-medium text-blue-800 mb-1">Solicitudes pendientes</h3>
                                    <p class="text-3xl font-bold text-blue-900" id="activeSolicitudesCount">{{ $activePublications->sum('solicitudes_count') }}</p>
                                </div>
                                <div class="bg-white p-3 rounded-lg shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="mt-4 text-sm text-blue-700">
                                <div class="flex items-center">
                                    <span class="font-medium">Pendientes de revisión</span>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gradient-to-br from-amber-50 to-amber-100 p-5 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 border border-amber-100 transform hover:-translate-y-1">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="font-medium text-amber-800 mb-1">Ofertas inactivas</h3>
                                    <p class="text-3xl font-bold text-amber-900" id="inactivePublicationsCount">{{ $inactivePublications->count() }}</p>
                                </div>
                                <div class="bg-white p-3 rounded-lg shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                                    </svg>
                                </div>
                            </div>
                            <div class="mt-4 text-sm text-amber-700">
                                <div class="flex items-center">
                                    <span class="font-medium">Inactivas</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Resumen de Actividad -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                        <!-- Gráfico de distribución de ofertas -->
                        <div class="bg-white p-6 rounded-xl shadow-md">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Distribución de Ofertas</h3>
                            <div class="relative" style="height: 300px;">
                                <canvas id="solicitudesChart"></canvas>
                            </div>
                            <!-- Estadísticas detalladas -->
                            <div class="mt-6 grid grid-cols-2 gap-4">
                                <div class="p-4 bg-purple-50 rounded-lg">
                                    <p class="text-sm text-purple-600 font-medium">Ofertas Activas</p>
                                    <p class="text-2xl font-bold text-purple-900" id="activePublicationsDetail">0</p>
                                </div>
                                <div class="p-4 bg-amber-50 rounded-lg">
                                    <p class="text-sm text-amber-600 font-medium">Ofertas Inactivas</p>
                                    <p class="text-2xl font-bold text-amber-900" id="inactivePublicationsDetail">0</p>
                                </div>
                            </div>
                        </div>

                        <!-- Gráfico de distribución de solicitudes -->
                        <div class="bg-white p-6 rounded-xl shadow-md">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Distribución de Solicitudes</h3>
                            <div class="relative" style="height: 300px;">
                                <canvas id="estadosChart"></canvas>
                            </div>
                            <!-- Estadísticas detalladas -->
                            <div class="mt-6 grid grid-cols-2 gap-4">
                                <div class="p-4 bg-green-50 rounded-lg">
                                    <p class="text-sm text-green-600 font-medium">Solicitudes Aceptadas</p>
                                    <p class="text-2xl font-bold text-green-900" id="activeSolicitudesDetail">0</p>
                                </div>
                                <div class="p-4 bg-blue-50 rounded-lg">
                                    <p class="text-sm text-blue-600 font-medium">Solicitudes Rechazadas</p>
                                    <p class="text-2xl font-bold text-blue-900" id="inactiveSolicitudesDetail">0</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Panel de Recomendaciones y Consejos -->
                    <div class="bg-gradient-to-br from-purple-50 via-indigo-50 to-purple-50 rounded-xl shadow-lg p-8 border border-purple-100">
                        <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 mr-3 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                            Consejos para Maximizar sus Ofertas
                        </h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="bg-white p-5 rounded-xl shadow-sm hover:shadow-md transition-all duration-300 border border-purple-100 transform hover:-translate-y-1">
                                <div class="flex items-center mb-4">
                                    <div class="bg-gradient-to-br from-purple-100 to-indigo-100 p-3 rounded-full mr-4 shadow-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                                        </svg>
                                    </div>
                                    <h3 class="text-lg font-semibold text-gray-800">Optimice sus descripciones</h3>
                                </div>
                                <p class="text-gray-600 leading-relaxed">Las ofertas con descripciones detalladas (más de 200 palabras) reciben un 70% más de solicitudes. Incluya requisitos, beneficios y tareas específicas.</p>
                            </div>

                            <div class="bg-white p-5 rounded-xl shadow-sm hover:shadow-md transition-all duration-300 border border-purple-100 transform hover:-translate-y-1">
                                <div class="flex items-center mb-4">
                                    <div class="bg-gradient-to-br from-purple-100 to-indigo-100 p-3 rounded-full mr-4 shadow-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <h3 class="text-lg font-semibold text-gray-800">Responda rápidamente</h3>
                                </div>
                                <p class="text-gray-600 leading-relaxed">Las empresas que responden a las solicitudes en menos de 48 horas tienen un 40% más de probabilidades de encontrar candidatos adecuados.</p>
                            </div>

                            <div class="bg-white p-5 rounded-xl shadow-sm hover:shadow-md transition-all duration-300 border border-purple-100 transform hover:-translate-y-1">
                                <div class="flex items-center mb-4">
                                    <div class="bg-gradient-to-br from-purple-100 to-indigo-100 p-3 rounded-full mr-4 shadow-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                        </svg>
                                    </div>
                                    <h3 class="text-lg font-semibold text-gray-800">Complete su perfil</h3>
                                </div>
                                <p class="text-gray-600 leading-relaxed">Las empresas con perfiles completos reciben un 85% más de solicitudes. Asegúrese de añadir una imagen, descripción y datos completos de su empresa.</p>
                            </div>

                            <div class="bg-white p-5 rounded-xl shadow-sm hover:shadow-md transition-all duration-300 border border-purple-100 transform hover:-translate-y-1">
                                <div class="flex items-center mb-4">
                                    <div class="bg-gradient-to-br from-purple-100 to-indigo-100 p-3 rounded-full mr-4 shadow-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                        </svg>
                                    </div>
                                    <h3 class="text-lg font-semibold text-gray-800">Use las subcategorías</h3>
                                </div>
                                <p class="text-gray-600 leading-relaxed">Las ofertas con subcategorías específicas reciben candidatos más relevantes. Seleccione las subcategorías más precisas para sus necesidades.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Nueva Oferta -->
<div id="modalNuevaOferta" class="fixed inset-0 bg-black bg-opacity-50 hidden overflow-y-auto h-full w-full z-50 backdrop-blur-sm transition-all duration-300">
    <div class="relative top-20 mx-auto p-0 w-full max-w-2xl transform transition-all duration-300">
        <div class="bg-white rounded-xl shadow-2xl overflow-hidden">
            <div class="bg-gradient-to-r from-purple-600 to-indigo-600 py-4 px-6 flex justify-between items-center">
                <h3 class="text-xl font-bold text-white flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Publicar Nueva Oferta
                </h3>
                <button onclick="closeModal()" class="text-white hover:text-gray-200 focus:outline-none transition-colors">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <form id="formNuevaOferta" class="p-6">
                @csrf
                <!-- Información básica -->
                <div class="mb-6">
                    <h4 class="text-md font-medium text-gray-800 mb-3 flex items-center">
                        <div class="w-8 h-8 flex items-center justify-center bg-purple-100 rounded-full mr-2 text-purple-600">1</div>
                        Información básica
                    </h4>
                    <div class="bg-gray-50 p-4 rounded-lg space-y-4">
                        <div>
                            <label for="titulo" class="block text-sm font-medium text-gray-700 mb-1">Título de la oferta *</label>
                            <input type="text" name="titulo" id="titulo" required
                                   class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 text-sm transition-all">
                            <p class="mt-1 text-xs text-gray-500">Un buen título aumenta la visibilidad de su oferta (máx. 100 caracteres)</p>
                        </div>

                        <div>
                            <label for="descripcion" class="block text-sm font-medium text-gray-700 mb-1">Descripción *</label>
                            <textarea name="descripcion" id="descripcion" rows="4" required
                                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 text-sm transition-all"></textarea>
                            <p class="mt-1 text-xs text-gray-500">Incluya detalles sobre tareas, requisitos y beneficios para el estudiante</p>
                        </div>
                    </div>
                </div>

                <!-- Detalles de la práctica -->
                <div class="mb-6">
                    <h4 class="text-md font-medium text-gray-800 mb-3 flex items-center">
                        <div class="w-8 h-8 flex items-center justify-center bg-purple-100 rounded-full mr-2 text-purple-600">2</div>
                        Detalles de la práctica
                    </h4>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="horario" class="block text-sm font-medium text-gray-700 mb-1">Horario *</label>
                                <select name="horario" id="horario" required
                                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 text-sm transition-all">
                                    <option value="">Seleccionar horario</option>
                                    <option value="mañana">Mañana</option>
                                    <option value="tarde">Tarde</option>
                                    <option value="flexible">Flexible</option>
                                </select>
                            </div>

                            <div>
                                <label for="horas_totales" class="block text-sm font-medium text-gray-700 mb-1">Horas totales *</label>
                                <input type="number" name="horas_totales" id="horas_totales" min="100" max="400" required
                                       class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 text-sm transition-all">
                                <p class="mt-1 text-xs text-gray-500">Entre 100 y 400 horas</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Categorización -->
                <div class="mb-6">
                    <h4 class="text-md font-medium text-gray-800 mb-3 flex items-center">
                        <div class="w-8 h-8 flex items-center justify-center bg-purple-100 rounded-full mr-2 text-purple-600">3</div>
                        Categorización
                    </h4>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="categoria_id" class="block text-sm font-medium text-gray-700 mb-1">Categoría *</label>
                                <select name="categoria_id" id="categoria_id" required onchange="cargarSubcategorias()"
                                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 text-sm transition-all">
                                    <option value="">Seleccionar categoría</option>
                                    @foreach($categorias as $categoria)
                                        <option value="{{ $categoria->id }}">{{ $categoria->nombre_categoria }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="subcategoria_id" class="block text-sm font-medium text-gray-700 mb-1">Subcategoría *</label>
                                <select name="subcategoria_id" id="subcategoria_id" required
                                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 text-sm transition-all">
                                    <option value="">Primero seleccione una categoría</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end space-x-3 pt-4 border-t">
                    <button type="button" onclick="closeModal()"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-all">
                        Cancelar
                    </button>
                    <button type="submit" id="submitButton"
                            class="px-4 py-2 text-sm font-medium text-white bg-gradient-to-r from-purple-600 to-indigo-600 border border-transparent rounded-lg hover:from-purple-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-all shadow-lg">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Publicar oferta
                        </div>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal de Búsqueda de Candidatos -->
<div id="modalSearchCandidates" class="fixed inset-0 bg-black bg-opacity-50 hidden overflow-y-auto h-full w-full z-50 backdrop-blur-sm transition-all duration-300">
    <div class="relative top-20 mx-auto p-0 w-full max-w-5xl transform transition-all duration-300">
        <div class="bg-white rounded-xl shadow-2xl overflow-hidden">
            <div class="bg-gradient-to-r from-purple-600 to-indigo-600 py-4 px-6 flex justify-between items-center">
                <h3 class="text-xl font-bold text-white flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    Búsqueda de Candidatos
                </h3>
                <button onclick="closeSearchCandidatesModal()" class="text-white hover:text-gray-200 focus:outline-none transition-colors">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <div class="p-6">
                <!-- Barra de búsqueda principal -->
                <div class="mb-6">
                    <div class="flex flex-col md:flex-row gap-4">
                        <div class="flex-1">
                            <div class="relative">
                                <input type="text" id="searchCandidatesInput" placeholder="Buscar candidatos por nombre, habilidades, formación..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary">
                                <svg class="absolute left-3 top-2.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                        </div>
                        <button id="searchCandidatesButton" class="px-5 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            Buscar
                        </button>
                        <button id="clearCandidateSearchButton" class="px-5 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Limpiar
                        </button>
                    </div>
                </div>

                <div class="flex flex-col md:flex-row gap-6">
                    <!-- Filtros -->
                    <div class="w-full md:w-1/4">
                        <div class="bg-gray-50 rounded-lg p-4">
                            <h3 class="text-lg font-medium text-gray-800 mb-4">Filtros</h3>

                            <!-- Filtro de Nivel de Estudios (ahora primero) -->
                            <div class="mb-4">
                                <h4 class="text-sm font-medium text-gray-600 mb-2">Nivel de Estudios</h4>
                                <div class="space-y-2">
                                    @foreach($nivelesEducativos ?? [] as $nivel)
                                    <div class="flex items-center">
                                        <input type="checkbox" id="education_{{ $nivel->id }}" name="nivel_educativo[]" value="{{ $nivel->id }}" class="nivel-educativo-checkbox form-checkbox h-4 w-4 text-purple-600 rounded" onchange="filtrarCategoriasPorNivel()">
                                        <label for="education_{{ $nivel->id }}" class="ml-2 text-sm text-gray-700">{{ $nivel->nombre_nivel }}</label>
                                    </div>
                                    @endforeach

                                    @if(empty($nivelesEducativos))
                                    <div class="text-sm text-gray-500">No hay niveles educativos disponibles</div>
                                    @endif
                                </div>
                            </div>

                            <!-- Filtro de Habilidades (ahora muestra categorías filtradas por nivel) -->
                            <div class="mb-4">
                                <h4 class="text-sm font-medium text-gray-600 mb-2">Habilidades</h4>
                                <div id="categorias-container" class="space-y-2">
                                    @foreach($categorias ?? [] as $categoria)
                                    <div class="flex items-center categoria-item" data-nivel-id="{{ $categoria->nivel_educativo_id }}">
                                        <input type="checkbox" id="skill_{{ $categoria->id }}" name="categoria[]" value="{{ $categoria->id }}" class="form-checkbox h-4 w-4 text-purple-600 rounded">
                                        <label for="skill_{{ $categoria->id }}" class="ml-2 text-sm text-gray-700">{{ $categoria->nombre_categoria }}</label>
                                    </div>
                                    @endforeach

                                    <div id="no-categorias-message" class="hidden text-sm text-gray-500">
                                        Selecciona al menos un Nivel de Estudios para ver las categorías disponibles
                                    </div>

                                    @if(empty($categorias))
                                    <div class="text-sm text-gray-500">No hay categorías disponibles</div>
                                    @endif
                                </div>
                            </div>

                            <!-- Filtro de Disponibilidad -->
                            <div class="mb-4">
                                <h4 class="text-sm font-medium text-gray-600 mb-2">Disponibilidad</h4>
                                <div class="space-y-2">
                                    <div class="flex items-center">
                                        <input type="checkbox" id="availability_morning" class="form-checkbox h-4 w-4 text-purple-600 rounded">
                                        <label for="availability_morning" class="ml-2 text-sm text-gray-700">Mañana</label>
                                    </div>
                                    <div class="flex items-center">
                                        <input type="checkbox" id="availability_afternoon" class="form-checkbox h-4 w-4 text-purple-600 rounded">
                                        <label for="availability_afternoon" class="ml-2 text-sm text-gray-700">Tarde</label>
                                    </div>
                                    <div class="flex items-center">
                                        <input type="checkbox" id="availability_flexible" class="form-checkbox h-4 w-4 text-purple-600 rounded">
                                        <label for="availability_flexible" class="ml-2 text-sm text-gray-700">Flexible</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Filtro de Ubicación -->
                            <div>
                                <h4 class="text-sm font-medium text-gray-600 mb-2">Ubicación</h4>
                                <select id="location_select" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 text-sm">
                                    <option value="">Todas las ubicaciones</option>
                                    @foreach($ciudades ?? [] as $ciudad)
                                    <option value="{{ $ciudad->id }}">{{ $ciudad->nombre }}</option>
                                    @endforeach

                                    @if(empty($ciudades))
                                    <option value="barcelona">Barcelona</option>
                                    <option value="madrid">Madrid</option>
                                    <option value="valencia">Valencia</option>
                                    <option value="sevilla">Sevilla</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Resultados de búsqueda -->
                    <div class="w-full md:w-3/4">
                        <div id="searchResults" class="bg-white rounded-lg">
                            <!-- Inicialmente mostrar mensaje de búsqueda -->
                            <div id="initialSearchMessage" class="text-center py-12">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                <h3 class="text-xl font-medium text-gray-800 mb-2">Busca candidatos para tus ofertas</h3>
                                <p class="text-gray-500 max-w-md mx-auto">
                                    Utiliza los filtros para encontrar estudiantes que se ajusten a tus necesidades
                                </p>
                            </div>

                            <!-- Spinner de carga (oculto inicialmente) -->
                            <div id="loadingResults" class="hidden text-center py-12">
                                <svg class="animate-spin h-10 w-10 mx-auto text-purple-600 mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <p class="text-gray-500">Buscando candidatos...</p>
                            </div>

                            <!-- Contenedor de resultados (oculto inicialmente) -->
                            <div id="resultsContainer" class="hidden">
                                <div class="mb-4 p-4 border-b border-gray-200">
                                    <div class="flex justify-between items-center">
                                        <h3 class="text-lg font-medium text-gray-800">Resultados de búsqueda</h3>
                                        <div class="text-sm text-gray-500">
                                            <span id="resultCount">0</span> candidatos encontrados
                                        </div>
                                    </div>
                                </div>

                                <!-- Lista de candidatos -->
                                <div id="candidatesList" class="divide-y divide-gray-200">
                                    <!-- Los resultados se cargarán dinámicamente aquí -->
                                </div>
                            </div>

                            <!-- Mensaje de no resultados (oculto inicialmente) -->
                            <div id="noResults" class="hidden text-center py-12">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <h3 class="text-xl font-medium text-gray-800 mb-2">No se encontraron candidatos</h3>
                                <p class="text-gray-500 max-w-md mx-auto">
                                    Prueba a cambiar los filtros o utilizar otros términos de búsqueda
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Sweet Alert, Chart.js y Scripts -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-material-ui@5/material-ui.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>

<script>
    // Verificar que estamos en la página correcta antes de ejecutar el script
    document.addEventListener('DOMContentLoaded', function() {
        // Renderizar gráficos si existen los elementos
        if (document.getElementById('solicitudesChart')) {
            initializeCharts();
        }

        // Inicialización del filtro de categorías (ocultar todas inicialmente)
        const categoriasItems = document.querySelectorAll('.categoria-item');
        categoriasItems.forEach(item => {
            item.classList.add('hidden');
        });

        // Mostrar mensaje de no categorías al inicio
        const noCategoriasMensaje = document.getElementById('no-categorias-message');
        if (noCategoriasMensaje) {
            noCategoriasMensaje.classList.remove('hidden');
        }

        // Configuración para el modal
        const modalNuevaOferta = document.getElementById('modalNuevaOferta');
        const formNuevaOferta = document.getElementById('formNuevaOferta');

        // Configurar botones para abrir el modal
        document.querySelectorAll('#btnNuevaOferta, #btnPrimeraOferta').forEach(button => {
            if (button) {
                button.addEventListener('click', function() {
                    openModal();
                });
            }
        });

        // Función para abrir el modal
        window.openModal = function() {
            if (modalNuevaOferta) {
                modalNuevaOferta.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');

                // Animación de entrada
                setTimeout(() => {
                    const modalContent = modalNuevaOferta.querySelector('.relative');
                    if (modalContent) {
                        modalContent.classList.add('animate-fadeIn');
                    }
                }, 10);

                // Scroll al inicio del modal y focus primer input
                setTimeout(() => {
                    const firstInput = modalNuevaOferta.querySelector('input, select, textarea');
                    if (firstInput) firstInput.focus();
                }, 300);
            }
        };

        // Función para cerrar el modal
        window.closeModal = function() {
            if (modalNuevaOferta) {
                // Animación de salida
                const modalContent = modalNuevaOferta.querySelector('.relative');
                if (modalContent) {
                    modalContent.classList.remove('animate-fadeIn');
                    modalContent.classList.add('animate-fadeOut');
                }

                setTimeout(() => {
                    modalNuevaOferta.classList.add('hidden');
                    document.body.classList.remove('overflow-hidden');

                    if (modalContent) {
                        modalContent.classList.remove('animate-fadeOut');
                    }

                    if (formNuevaOferta) {
                        formNuevaOferta.reset();
                        delete formNuevaOferta.dataset.processing;
                    }
                }, 200);
            }
        };

        // Cerrar modal al hacer clic fuera
        if (modalNuevaOferta) {
            modalNuevaOferta.addEventListener('click', function(e) {
                if (e.target === this) {
                    closeModal();
                }
            });

            // Cerrar con tecla Escape
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && !modalNuevaOferta.classList.contains('hidden')) {
                    closeModal();
                }
            });
        }

        // Función para cargar subcategorías
        window.cargarSubcategorias = function() {
            const categoriaId = document.getElementById('categoria_id');
            if (!categoriaId) return;

            const subcategoriasSelect = document.getElementById('subcategoria_id');
            if (!subcategoriasSelect) return;

            if (!categoriaId.value) {
                subcategoriasSelect.innerHTML = '<option value="">Primero seleccione una categoría</option>';
                return;
            }

            subcategoriasSelect.innerHTML = '<option value="">Cargando subcategorías...</option>';
            subcategoriasSelect.disabled = true;

            const baseUrl = '{{ url('/') }}';
            const url = `${baseUrl}/empresa/get-subcategorias/${categoriaId.value}`;

            fetch(url, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                credentials: 'same-origin'
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(response => {
                if (response.error) {
                    throw new Error(response.message);
                }

                subcategoriasSelect.innerHTML = '<option value="">Seleccionar subcategoría</option>';

                const subcategorias = response.data || [];
                if (subcategorias.length === 0) {
                    subcategoriasSelect.innerHTML = '<option value="">No hay subcategorías disponibles</option>';
                    return;
                }

                // Usar un Set para evitar duplicados
                const addedIds = new Set();

                subcategorias.forEach(subcategoria => {
                    if (!addedIds.has(subcategoria.id)) {
                        addedIds.add(subcategoria.id);
                        subcategoriasSelect.innerHTML += `
                            <option value="${subcategoria.id}">${subcategoria.nombre_subcategoria}</option>
                        `;
                    }
                });
            })
            .catch(error => {
                console.error('Error al cargar subcategorías:', error);
                if (window.Swal) {
                    Swal.fire({
                        title: '¡Error!',
                        text: 'No se pudieron cargar las subcategorías: ' + error.message,
                        icon: 'error',
                        confirmButtonText: 'Entendido',
                        confirmButtonColor: '#7E22CE'
                    });
                }
                subcategoriasSelect.innerHTML = '<option value="">Error al cargar subcategorías</option>';
            })
            .finally(() => {
                subcategoriasSelect.disabled = false;
            });
        };

        // Manejar envío del formulario
        if (formNuevaOferta) {
            const requestsInProgress = new Set();

            formNuevaOferta.addEventListener('submit', function(e) {
                e.preventDefault();

                // Verificar si el formulario ya está siendo procesado
                if (this.dataset.processing === 'true') {
                    console.log('Formulario ya está siendo procesado, ignorando envío duplicado');
                    return false;
                }

                // Validaciones adicionales en el cliente
                const titulo = this.querySelector('#titulo').value.trim();
                const descripcion = this.querySelector('#descripcion').value.trim();

                if (titulo.length < 5) {
                    Swal.fire({
                        title: 'Validación',
                        text: 'El título debe tener al menos 5 caracteres',
                        icon: 'warning',
                        confirmButtonColor: '#7E22CE'
                    });
                    return false;
                }

                if (descripcion.length < 50) {
                    Swal.fire({
                        title: 'Validación',
                        text: 'La descripción debe ser más detallada (mínimo 50 caracteres)',
                        icon: 'warning',
                        confirmButtonColor: '#7E22CE'
                    });
                    return false;
                }

                // Verificar si hay una solicitud idéntica en progreso usando datos del formulario como identificador
                const formData = new FormData(this);
                const requestId = Array.from(formData.entries())
                    .map(([key, value]) => `${key}=${value}`)
                    .join('&');

                if (requestsInProgress.has(requestId)) {
                    console.log('Solicitud idéntica ya en progreso, ignorando');
                    return false;
                }

                // Marcar el formulario como en procesamiento
                this.dataset.processing = 'true';
                requestsInProgress.add(requestId);

                // Deshabilitar el botón de submit y mostrar estado de carga
                const submitButton = document.getElementById('submitButton');
                if (submitButton) {
                    submitButton.disabled = true;
                    submitButton.innerHTML = '<div class="flex items-center"><svg class="animate-spin -ml-1 mr-2 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Publicando...</div>';
                }

                // Datos para el seguimiento de la petición
                const uniqueId = Date.now().toString();
                console.log(`[${uniqueId}] Iniciando envío del formulario`);

                fetch('{{ route('empresa.offers.store') }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'X-Request-ID': uniqueId,
                        'X-Request-Unique': requestId
                    }
                })
                .then(response => {
                    console.log(`[${uniqueId}] Respuesta recibida, status: ${response.status}`);

                    if (!response.ok) {
                        throw new Error(`Error en la respuesta del servidor: ${response.status}`);
                    }

                    const contentType = response.headers.get('content-type');
                    if (contentType && contentType.includes('application/json')) {
                        return response.json().then(data => {
                            console.log(`[${uniqueId}] Datos JSON recibidos:`, data);

                            if (data.success) {
                                closeModal();
                                if (window.Swal) {
                                    Swal.fire({
                                        title: '¡Éxito!',
                                        text: data.message || 'Oferta creada exitosamente',
                                        icon: 'success',
                                        confirmButtonText: 'Continuar',
                                        confirmButtonColor: '#7E22CE'
                                    });

                                    // Actualizar los contadores y gráficos sin recargar
                                    if (document.getElementById('solicitudesChart')) {
                                        initializeCharts();
                                    }
                                } else {
                                    alert(data.message || 'Oferta creada exitosamente');
                                }
                            } else {
                                throw new Error(data.message || 'Error al crear la oferta');
                            }
                        });
                    } else {
                        console.log(`[${uniqueId}] Respuesta no es JSON`);
                        closeModal();
                        Swal.fire({
                            title: '¡Éxito!',
                            text: 'Oferta creada exitosamente',
                            icon: 'success',
                            confirmButtonText: 'Continuar',
                            confirmButtonColor: '#7E22CE'
                        });

                        // Actualizar los contadores y gráficos sin recargar
                        if (document.getElementById('solicitudesChart')) {
                            initializeCharts();
                        }
                    }
                })
                .catch(error => {
                    console.error(`[${uniqueId}] Error:`, error);

                    if (window.Swal) {
                        Swal.fire({
                            title: '¡Error!',
                            text: error.message || 'Ha ocurrido un error al publicar la oferta',
                            icon: 'error',
                            confirmButtonText: 'Entendido',
                            confirmButtonColor: '#7E22CE'
                        });
                    } else {
                        alert(error.message || 'Ha ocurrido un error al publicar la oferta');
                    }
                })
                .finally(() => {
                    console.log(`[${uniqueId}] Finalizada la petición`);

                    // Eliminar la solicitud del conjunto de solicitudes en progreso
                    requestsInProgress.delete(requestId);

                    // Restablecer el estado del botón y formulario después de 2 segundos
                    setTimeout(() => {
                        delete formNuevaOferta.dataset.processing;

                        if (submitButton) {
                            submitButton.disabled = false;
                            submitButton.innerHTML = '<div class="flex items-center"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg> Publicar oferta</div>';
                        }
                    }, 2000);
                });
            });
        }

        // Inicializar gráficos con estilos mejorados y animaciones
        function initializeCharts() {
            // Destruir gráficos existentes si existen
            const existingSolicitudesChart = Chart.getChart('solicitudesChart');
            if (existingSolicitudesChart) {
                existingSolicitudesChart.destroy();
            }

            const existingEstadosChart = Chart.getChart('estadosChart');
            if (existingEstadosChart) {
                existingEstadosChart.destroy();
            }

            // Obtener datos actualizados mediante AJAX
            fetch('/empresa/get-dashboard-stats', {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                // Actualizar los contadores en la interfaz
                document.getElementById('activePublicationsCount').textContent = data.activePublications;
                document.getElementById('totalSolicitudesCount').textContent = data.activeSolicitudes + data.inactiveSolicitudes;
                document.getElementById('activeSolicitudesCount').textContent = data.activeSolicitudes;
                document.getElementById('inactivePublicationsCount').textContent = data.inactivePublications;

                // Actualizar los números detallados
                document.getElementById('activePublicationsDetail').textContent = data.activePublications;
                document.getElementById('inactivePublicationsDetail').textContent = data.inactivePublications;
                document.getElementById('activeSolicitudesDetail').textContent = data.activeSolicitudes;
                document.getElementById('inactiveSolicitudesDetail').textContent = data.inactiveSolicitudes;

                // Paleta de colores personalizada con degradados
                const chartPalette = {
                    purple: {
                        primary: 'rgba(124, 58, 237, 0.9)',
                        secondary: 'rgba(139, 92, 246, 0.6)',
                        gradient: createGradient('solicitudesChart', [
                            'rgba(124, 58, 237, 0.7)',
                            'rgba(139, 92, 246, 0.3)'
                        ])
                    },
                    amber: {
                        primary: 'rgba(217, 119, 6, 0.9)',
                        secondary: 'rgba(245, 158, 11, 0.6)',
                        gradient: createGradient('solicitudesChart', [
                            'rgba(217, 119, 6, 0.7)',
                            'rgba(251, 191, 36, 0.3)'
                        ])
                    }
                };

                // Crear gráfico de distribución de ofertas
                const solicitudesChart = new Chart(
                    document.getElementById('solicitudesChart'),
                    {
                        type: 'doughnut',
                        data: {
                            labels: ['Ofertas Activas', 'Ofertas Inactivas'],
                            datasets: [{
                                data: [data.activePublications, data.inactivePublications],
                                backgroundColor: [
                                    chartPalette.purple.gradient,
                                    chartPalette.amber.gradient
                                ],
                                borderWidth: 0,
                                borderRadius: 4
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            layout: {
                                padding: 20
                            },
                            plugins: {
                                legend: {
                                    position: 'bottom',
                                    labels: {
                                        usePointStyle: true,
                                        padding: 20
                                    }
                                }
                            }
                        }
                    }
                );

                // Crear gráfico de distribución de solicitudes
                const estadosChart = new Chart(
                    document.getElementById('estadosChart'),
                    {
                        type: 'bar',
                        data: {
                            labels: ['Solicitudes Aceptadas', 'Solicitudes Rechazadas'],
                            datasets: [{
                                data: [data.activeSolicitudes, data.inactiveSolicitudes],
                                backgroundColor: [
                                    'rgba(34, 197, 94, 0.7)',
                                    'rgba(239, 68, 68, 0.7)'
                                ],
                                borderWidth: 0,
                                borderRadius: 4
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            layout: {
                                padding: 20
                            },
                            plugins: {
                                legend: {
                                    display: false
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    grid: {
                                        display: true,
                                        color: 'rgba(0, 0, 0, 0.1)'
                                    }
                                },
                                x: {
                                    grid: {
                                        display: false
                                    }
                                }
                            }
                        }
                    }
                );
            })
            .catch(error => {
                console.error('Error al obtener las estadísticas:', error);
            });
        }

        // Crear degradados para los gráficos
        function createGradient(chartId, colorStops) {
            const ctx = document.getElementById(chartId).getContext('2d');
            const gradient = ctx.createLinearGradient(0, 0, 0, 400);

            colorStops.forEach((color, index) => {
                gradient.addColorStop(index / (colorStops.length - 1), color);
            });

            return gradient;
        }

        // Inicializar los gráficos cuando se carga la página
        document.addEventListener('DOMContentLoaded', function() {
            initializeCharts();
        });

        // Actualizar los gráficos cada 5 minutos
        setInterval(initializeCharts, 300000);

        // Estas funciones ya no se usan
        function renderizarGraficos() {
            // Reemplazado por initializeCharts
        }

        // Función para abrir el modal de búsqueda de candidatos
        window.openSearchCandidatesModal = function() {
            const modalSearchCandidates = document.getElementById('modalSearchCandidates');
            if (modalSearchCandidates) {
                modalSearchCandidates.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');

                // Animación de entrada
                setTimeout(() => {
                    const modalContent = modalSearchCandidates.querySelector('.relative');
                    if (modalContent) {
                        modalContent.classList.add('animate-fadeIn');
                    }
                }, 10);

                // Focus en el campo de búsqueda
                setTimeout(() => {
                    const searchInput = document.getElementById('searchCandidatesInput');
                    if (searchInput) searchInput.focus();
                }, 300);
                
                // Cargar automáticamente todos los candidatos al abrir el modal
                buscarCandidatos();
            }
        };
        
        // Función para cerrar el modal de búsqueda de candidatos
        window.closeSearchCandidatesModal = function() {
            const modalSearchCandidates = document.getElementById('modalSearchCandidates');
            if (modalSearchCandidates) {
                // Animación de salida
                const modalContent = modalSearchCandidates.querySelector('.relative');
                if (modalContent) {
                    modalContent.classList.remove('animate-fadeIn');
                    modalContent.classList.add('animate-fadeOut');
                }

                setTimeout(() => {
                    modalSearchCandidates.classList.add('hidden');
                    document.body.classList.remove('overflow-hidden');

                    if (modalContent) {
                        modalContent.classList.remove('animate-fadeOut');
                    }
                }, 200);
            }
        };
        
        // Nueva función para buscar candidatos
        function buscarCandidatos(page = 1) {
            // Ocultar mensaje inicial
            const initialSearchMessage = document.getElementById('initialSearchMessage');
            if (initialSearchMessage) initialSearchMessage.classList.add('hidden');

            // Mostrar spinner de carga
            const loadingResults = document.getElementById('loadingResults');
            if (loadingResults) loadingResults.classList.remove('hidden');

            // Ocultar otros contenedores
            const resultsContainer = document.getElementById('resultsContainer');
            const noResults = document.getElementById('noResults');
            if (resultsContainer) resultsContainer.classList.add('hidden');
            if (noResults) noResults.classList.add('hidden');

            // Recoger valores de los filtros
            const searchTerm = document.getElementById('searchCandidatesInput')?.value.trim() || '';
            const selectedNiveles = Array.from(document.querySelectorAll('input[name="nivel_educativo[]"]:checked')).map(cb => cb.value);
            const selectedCategorias = Array.from(document.querySelectorAll('input[name="categoria[]"]:checked')).map(cb => cb.value);
            const selectedDisponibilidad = Array.from(document.querySelectorAll('input[id^="availability_"]:checked')).map(cb => cb.id.replace('availability_', ''));
            const ubicacion = document.getElementById('location_select')?.value || '';

            // Preparar datos para la petición
            const searchData = {
                search: searchTerm,
                niveles: selectedNiveles,
                categorias: selectedCategorias,
                disponibilidad: selectedDisponibilidad,
                ubicacion: ubicacion,
                page: page,
                _token: '{{ csrf_token() }}'
            };

            console.log('Buscando con los parámetros:', searchData);

            // Realizar petición AJAX a la API
            fetch('{{ route("api.estudiantes.search") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: JSON.stringify(searchData)
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`Error en la respuesta: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                // Ocultar spinner
                if (loadingResults) loadingResults.classList.add('hidden');

                if (!data.estudiantes || data.estudiantes.length === 0) {
                    // Mostrar mensaje de no resultados
                    if (noResults) noResults.classList.remove('hidden');
                } else {
                    // Mostrar resultados
                    const candidatesList = document.getElementById('candidatesList');
                    if (candidatesList) {
                        // Limpiar resultados anteriores
                        candidatesList.innerHTML = '';

                        // Actualizar contador
                        const resultCount = document.getElementById('resultCount');
                        if (resultCount) resultCount.textContent = data.total || data.estudiantes.length;

                        // Mostrar cada estudiante
                        data.estudiantes.forEach(estudiante => {
                            // Verificar si hay habilidades disponibles
                            const habilidadesHTML = estudiante.habilidades && estudiante.habilidades.length > 0
                                ? estudiante.habilidades.map(habilidad => `
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                        ${habilidad}
                                    </span>
                                `).join('')
                                : '<span class="text-xs text-gray-500">No se han especificado habilidades</span>';

                            // Crear elemento HTML para el estudiante
                            const estudianteElement = document.createElement('div');
                            estudianteElement.className = 'p-4 hover:bg-gray-50 transition-colors';
                            estudianteElement.innerHTML = `
                                <div class="flex items-start">
                                    <div class="flex-shrink-0 mr-4">
                                        ${estudiante.imagen
                                            ? `<img src="{{ asset('profile_images/') }}/${estudiante.imagen}" class="h-12 w-12 rounded-full object-cover border-2 border-purple-100">`
                                            : `<div class="h-12 w-12 rounded-full bg-purple-100 flex items-center justify-center text-purple-700 font-bold text-lg">
                                                ${estudiante.nombre ? estudiante.nombre.split(' ').map(n => n[0]).slice(0, 2).join('').toUpperCase() : 'N/A'}
                                              </div>`
                                        }
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="text-lg font-medium text-gray-900">${estudiante.nombre || 'Sin nombre'}</h4>
                                        <p class="text-sm text-gray-500">${estudiante.titulo || 'Sin formación'} ${estudiante.ubicacion ? '· ' + estudiante.ubicacion : ''}</p>
                                        <div class="mt-2 flex flex-wrap gap-1">
                                            ${habilidadesHTML}
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <button class="px-3 py-1 bg-purple-600 text-white text-sm rounded hover:bg-purple-700 transition-colors" 
                                                onclick="verPerfilEstudiante(${estudiante.id})">
                                            Ver perfil
                                        </button>
                                    </div>
                                </div>
                            `;

                            candidatesList.appendChild(estudianteElement);
                        });
                        
                        // Añadir paginación si existe
                        if (data.last_page && data.last_page > 1) {
                            const paginationContainer = document.createElement('div');
                            paginationContainer.className = 'flex justify-center items-center mt-6 mb-4 space-x-1';
                            
                            // Botón anterior
                            if (data.current_page > 1) {
                                const prevButton = document.createElement('button');
                                prevButton.className = 'px-3 py-1 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 transition-colors';
                                prevButton.textContent = 'Anterior';
                                prevButton.onclick = function() {
                                    buscarCandidatos(data.current_page - 1);
                                };
                                paginationContainer.appendChild(prevButton);
                            }
                            
                            // Números de página
                            for (let i = 1; i <= data.last_page; i++) {
                                const pageButton = document.createElement('button');
                                if (i === data.current_page) {
                                    pageButton.className = 'px-3 py-1 bg-purple-600 text-white rounded';
                                } else {
                                    pageButton.className = 'px-3 py-1 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 transition-colors';
                                }
                                pageButton.textContent = i;
                                pageButton.onclick = function() {
                                    buscarCandidatos(i);
                                };
                                paginationContainer.appendChild(pageButton);
                            }
                            
                            // Botón siguiente
                            if (data.current_page < data.last_page) {
                                const nextButton = document.createElement('button');
                                nextButton.className = 'px-3 py-1 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 transition-colors';
                                nextButton.textContent = 'Siguiente';
                                nextButton.onclick = function() {
                                    buscarCandidatos(data.current_page + 1);
                                };
                                paginationContainer.appendChild(nextButton);
                            }
                            
                            candidatesList.appendChild(paginationContainer);
                        }

                        // Mostrar contenedor de resultados
                        if (resultsContainer) resultsContainer.classList.remove('hidden');
                    }
                }
            })
            .catch(error => {
                console.error('Error en la búsqueda de estudiantes:', error);
                
                // Ocultar spinner
                if (loadingResults) loadingResults.classList.add('hidden');
                
                // Mostrar mensaje de error
                if (noResults) {
                    noResults.classList.remove('hidden');
                    
                    // Actualizar el mensaje para indicar que hubo un error
                    const errorTitle = noResults.querySelector('h3');
                    const errorMsg = noResults.querySelector('p');
                    
                    if (errorTitle) errorTitle.textContent = '¡Ha ocurrido un error!';
                    if (errorMsg) errorMsg.textContent = 'No se pudo completar la búsqueda. Intente de nuevo más tarde.';
                }
                
                // Mostrar una alerta al usuario
                if (window.Swal) {
                    Swal.fire({
                        title: 'Error',
                        text: 'No se pudieron obtener los resultados: ' + error.message,
                        icon: 'error',
                        confirmButtonColor: '#7E22CE'
                    });
                }
            });
        }

        // Simulación de búsqueda de candidatos
        const searchCandidatesButton = document.getElementById('searchCandidatesButton');
        const clearCandidateSearchButton = document.getElementById('clearCandidateSearchButton');

        if (searchCandidatesButton) {
            searchCandidatesButton.addEventListener('click', function() {
                buscarCandidatos();
            });
        }

        // Función para ver el perfil de un estudiante
        window.verPerfilEstudiante = function(estudianteId) {
            // Redireccionar a la página de perfil del estudiante
            window.location.href = `{{ url('/empresa/estudiante') }}/${estudianteId}`;
        };

        // Limpiar búsqueda
        if (clearCandidateSearchButton) {
            clearCandidateSearchButton.addEventListener('click', function() {
                // Limpiar campo de búsqueda
                const searchInput = document.getElementById('searchCandidatesInput');
                if (searchInput) searchInput.value = '';

                // Limpiar checkboxes de categorías y niveles educativos
                const checkboxesCategorias = document.querySelectorAll('input[name="categoria[]"]');
                const checkboxesNiveles = document.querySelectorAll('input[name="nivel_educativo[]"]');
                checkboxesCategorias.forEach(checkbox => checkbox.checked = false);
                checkboxesNiveles.forEach(checkbox => checkbox.checked = false);

                // Restaurar visibilidad de todas las categorías
                const categoriasItems = document.querySelectorAll('.categoria-item');
                categoriasItems.forEach(item => {
                    item.classList.remove('hidden');
                });
                document.getElementById('no-categorias-message').classList.add('hidden');

                // Resetear selector de ubicación
                const locationSelect = document.getElementById('location_select');
                if (locationSelect) locationSelect.value = '';

                // Mostrar mensaje inicial
                const initialSearchMessage = document.getElementById('initialSearchMessage');
                const loadingResults = document.getElementById('loadingResults');
                const resultsContainer = document.getElementById('resultsContainer');
                const noResults = document.getElementById('noResults');

                if (initialSearchMessage) initialSearchMessage.classList.remove('hidden');
                if (loadingResults) loadingResults.classList.add('hidden');
                if (resultsContainer) resultsContainer.classList.add('hidden');
                if (noResults) noResults.classList.add('hidden');
            });
        }

        // Inicializar la función para filtrar categorías por nivel educativo
        window.filtrarCategoriasPorNivel = function() {
            const checkboxesNiveles = document.querySelectorAll('.nivel-educativo-checkbox:checked');
            const categoriasItems = document.querySelectorAll('.categoria-item');
            const noCategoriasMensaje = document.getElementById('no-categorias-message');

            // Si no hay niveles seleccionados, ocultar todas las categorías y mostrar mensaje
            if (checkboxesNiveles.length === 0) {
                categoriasItems.forEach(item => {
                    item.classList.add('hidden');
                });
                noCategoriasMensaje.classList.remove('hidden');
                return;
            }

            // Crear array con los IDs de los niveles seleccionados
            const nivelesSeleccionados = Array.from(checkboxesNiveles).map(checkbox => checkbox.value);

            // Contador para categorías visibles
            let categoriasVisibles = 0;

            // Filtrar las categorías según los niveles seleccionados
            categoriasItems.forEach(item => {
                const nivelId = item.getAttribute('data-nivel-id');

                // Comprobamos si el ID está en el array - convertimos a string para asegurar comparación correcta
                if (nivelesSeleccionados.includes(nivelId) || nivelesSeleccionados.includes(String(nivelId))) {
                    item.classList.remove('hidden');
                    categoriasVisibles++;
                } else {
                    item.classList.add('hidden');
                }
            });

            // Mostrar/ocultar mensaje si no hay categorías disponibles
            if (categoriasVisibles === 0) {
                noCategoriasMensaje.classList.remove('hidden');
            } else {
                noCategoriasMensaje.classList.add('hidden');
            }

            console.log('Niveles seleccionados:', nivelesSeleccionados);
            console.log('Categorías visibles:', categoriasVisibles);
        };
    });
</script>

<style>
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes fadeOut {
        from { opacity: 1; transform: translateY(0); }
        to { opacity: 0; transform: translateY(-20px); }
    }

    .animate-fadeIn {
        animation: fadeIn 0.3s ease-out forwards;
    }

    .animate-fadeOut {
        animation: fadeOut 0.2s ease-in forwards;
    }
</style>
@endsection

