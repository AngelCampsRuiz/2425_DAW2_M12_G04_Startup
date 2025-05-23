@extends('layouts.app')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <!-- Banner de demostración -->
    <div class="bg-yellow-100 border-b border-yellow-200 p-4 text-center">
        <p class="text-yellow-800 font-medium">
            <span class="font-bold">Vista de demostración</span> - Así se vería la plataforma si fueras una empresa.
            <a href="{{ route('register.empresa') }}" class="text-purple-700 underline font-bold">Regístrate ahora</a> para acceder a todas las funcionalidades.
        </p>
    </div>

    <div class="container mx-auto px-4 py-8">
        <!-- Breadcrumbs -->
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

        <div class="flex flex-col md:flex-row gap-6">
            <!-- Sidebar -->
            <div class="w-full md:w-1/4">
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <div class="flex items-center space-x-4 mb-6">
                        <div class="w-16 h-16 rounded-full bg-purple-200 flex items-center justify-center text-purple-700 text-xl font-bold">
                            DE
                        </div>
                        <div>
                            <h2 class="text-lg font-bold">Demo Empresa</h2>
                            <p class="text-gray-600">Empresa</p>
                        </div>
                    </div>
                    <div class="border-t pt-4">
                        <p class="text-gray-600 mb-2">CIF: <span class="font-medium">B12345678</span></p>
                        <p class="text-gray-600">Estado: <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs font-medium">Activa</span></p>
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
                            <li><a href="{{ route('register.empresa') }}" class="flex items-center p-2 {{ Route::currentRouteName() == 'empresa.dashboard' ? 'bg-gradient-to-r from-purple-50 to-purple-100 text-purple-700 border-l-4 border-purple-600' : 'text-gray-700 hover:bg-gray-50' }} rounded-lg font-medium transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 {{ Route::currentRouteName() == 'empresa.dashboard' ? 'text-purple-600' : 'text-gray-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7m-14 0l2 2m0 0l7 7 7-7m-14 0l2-2" />
                                </svg>
                                Dashboard
                            </a></li>
                            <li><a href="{{ route('register.empresa') }}" class="flex items-center p-2 {{ Route::currentRouteName() == 'profile' ? 'bg-gradient-to-r from-purple-50 to-purple-100 text-purple-700 border-l-4 border-purple-600' : 'text-gray-700 hover:bg-gray-50' }} rounded-lg transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 {{ Route::currentRouteName() == 'profile' ? 'text-purple-600' : 'text-gray-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                Perfil de empresa
                            </a></li>
                            <li><a href="{{ route('register.empresa') }}" class="flex items-center p-2 {{ Route::currentRouteName() == 'empresa.calendar' ? 'bg-gradient-to-r from-purple-50 to-purple-100 text-purple-700 border-l-4 border-purple-600' : 'text-gray-700 hover:bg-gray-50' }} rounded-lg transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 {{ Route::currentRouteName() == 'empresa.calendar' ? 'text-purple-600' : 'text-gray-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Calendario
                            </a></li>
                            <!-- <li><a href="{{ route('register.empresa') }}" onclick="openSearchCandidatesModal()" class="flex items-center p-2 text-gray-700 hover:bg-gray-50 rounded-lg transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                Buscar candidatos
                            </a></li> -->
                            <li><a href="{{ route('register.empresa') }}" onclick="openModal()" class="flex items-center p-2 {{ Route::currentRouteName() == 'empresa.offers.create' ? 'bg-gradient-to-r from-purple-50 to-purple-100 text-purple-700 border-l-4 border-purple-600' : 'text-gray-700 hover:bg-gray-50' }} rounded-lg transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 {{ Route::currentRouteName() == 'empresa.offers.create' ? 'text-purple-600' : 'text-gray-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                Publicar oferta
                            </a></li>
                            <li><a href="{{ route('register.empresa') }}" class="flex items-center p-2 {{ Route::currentRouteName() == 'empresa.offers.active' ? 'bg-gradient-to-r from-purple-50 to-purple-100 text-purple-700 border-l-4 border-purple-600' : 'text-gray-700 hover:bg-gray-50' }} rounded-lg transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 {{ Route::currentRouteName() == 'empresa.offers.active' ? 'text-purple-600' : 'text-gray-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Ofertas Activas
                            </a></li>
                            <li><a href="{{ route('register.empresa') }}" class="flex items-center p-2 {{ Route::currentRouteName() == 'empresa.offers.inactive' ? 'bg-gradient-to-r from-purple-50 to-purple-100 text-purple-700 border-l-4 border-purple-600' : 'text-gray-700 hover:bg-gray-50' }} rounded-lg transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 {{ Route::currentRouteName() == 'empresa.offers.inactive' ? 'text-purple-600' : 'text-gray-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Ofertas Inactivas
                            </a></li>
                            <li><a href="{{ route('register.empresa') }}" class="flex items-center p-2 {{ Route::currentRouteName() == 'empresa.offers.accepted-candidates' ? 'bg-gradient-to-r from-purple-50 to-purple-100 text-purple-700 border-l-4 border-purple-600' : 'text-gray-700 hover:bg-gray-50' }} rounded-lg transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 {{ Route::currentRouteName() == 'empresa.offers.accepted-candidates' ? 'text-purple-600' : 'text-green-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                                Candidatos Aceptados
                            </a></li>
                            <li><a href="{{ route('register.empresa') }}" class="flex items-center p-2 {{ Route::currentRouteName() == 'empresa.convenios' ? 'bg-gradient-to-r from-purple-50 to-purple-100 text-purple-700 border-l-4 border-purple-600' : 'text-gray-700 hover:bg-gray-50' }} rounded-lg transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 {{ Route::currentRouteName() == 'empresa.convenios' ? 'text-purple-600' : 'text-gray-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Convenios
                            </a></li>
                            <li><a href="{{ route('register.empresa') }}" class="flex items-center p-2 {{ Route::currentRouteName() == 'chat.index' ? 'bg-gradient-to-r from-purple-50 to-purple-100 text-purple-700 border-l-4 border-purple-600' : 'text-gray-700 hover:bg-gray-50' }} rounded-lg transition-colors">
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
                                    <p class="text-3xl font-bold text-purple-900" id="activePublicationsCount">37</p>
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
                                    <p class="text-3xl font-bold text-green-900" id="totalSolicitudesCount">45</p>
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
                                    <p class="text-3xl font-bold text-blue-900" id="activeSolicitudesCount">24</p>
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
                                    <p class="text-3xl font-bold text-amber-900" id="inactivePublicationsCount">0</p>
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
                                    <p class="text-2xl font-bold text-purple-900" id="activePublicationsDetail">37</p>
                                </div>
                                <div class="p-4 bg-amber-50 rounded-lg">
                                    <p class="text-sm text-amber-600 font-medium">Ofertas Inactivas</p>
                                    <p class="text-2xl font-bold text-amber-900" id="inactivePublicationsDetail">3</p>
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
                                    <p class="text-2xl font-bold text-green-900" id="activeSolicitudesDetail">24</p>
                                </div>
                                <div class="p-4 bg-blue-50 rounded-lg">
                                    <p class="text-sm text-blue-600 font-medium">Solicitudes Rechazadas</p>
                                    <p class="text-2xl font-bold text-blue-900" id="inactiveSolicitudesDetail">21</p>
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

<!-- Añadir Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<!-- Sweet Alert, Chart.js y Scripts -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-material-ui@5/material-ui.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<script src="{{ asset('js/demo_empresa.js') }}"></script>
@endsection
