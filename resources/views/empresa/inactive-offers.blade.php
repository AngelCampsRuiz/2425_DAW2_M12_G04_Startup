{{-- HEADER --}}
@extends('layouts.app')

{{-- CONTENIDO --}}
@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-purple-50">
    <div class="container mx-auto px-4 py-8">
        <!-- Breadcrumbs -->
        @component('components.breadcrumb')
            @slot('items')
                [{"name": "Dashboard", "url": "{{ route('empresa.dashboard') }}"}, {"name": "Ofertas Inactivas"}]
            @endslot
        @endcomponent

        <div class="flex flex-col md:flex-row gap-6">
            <!-- Sidebar -->
            <div class="w-full md:w-1/4">
                <div class="bg-white rounded-xl shadow-lg p-6 mb-6 hover:shadow-xl transition-shadow duration-300">
                    <div class="flex items-center space-x-4 mb-6">
                        @if(Auth::user()->imagen)
                            <div class="relative flex items-center justify-center w-16 h-16 rounded-full bg-purple-50 border-2 border-purple-200 overflow-hidden">
                                <img src="{{ asset('public/profile_images/' . Auth::user()->imagen) }}" alt="Logo empresa" class="w-full h-full object-contain">
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
                <!-- Ofertas Inactivas -->
                <div class="bg-white rounded-xl shadow-lg p-6 mb-6 hover:shadow-xl transition-shadow duration-300">
                    <h1 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 mr-3 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Ofertas Inactivas
                    </h1>

                    <!-- Filtros -->
                    <div class="bg-white p-5 rounded-xl mb-6 border border-gray-200 shadow-sm">
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4">
                            <h3 class="text-md font-semibold text-gray-800 mb-2 sm:mb-0 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                                </svg>
                                Filtrar ofertas
                            </h3>
                            <button id="btnResetFilters" class="text-sm text-purple-600 hover:text-purple-800 flex items-center bg-purple-50 hover:bg-purple-100 px-3 py-1.5 rounded-lg transition-colors duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                                Limpiar filtros
                            </button>
                        </div>
                        
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-100 mb-4">
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                <div class="col-span-2">
                                    <div class="relative">
                                        <label for="filter_titulo" class="block text-sm font-medium text-gray-700 mb-1 flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18" />
                                            </svg>
                                            Título
                                        </label>
                                        <div class="relative rounded-md shadow-sm">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                                </svg>
                                            </div>
                                            <input type="text" id="filter_titulo" class="block w-full pl-10 pr-3 py-2 rounded-lg border-gray-300 focus:border-purple-500 focus:ring-purple-500 text-sm transition-all duration-200" placeholder="Buscar por título o palabras clave...">
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <label for="filter_horario" class="block text-sm font-medium text-gray-700 mb-1 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Horario
                                    </label>
                                    <select id="filter_horario" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 text-sm transition-all duration-200">
                                        <option value="">Todos los horarios</option>
                                        <option value="mañana">Mañana</option>
                                        <option value="tarde">Tarde</option>
                                        <option value="flexible">Flexible</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="filter_categoria" class="block text-sm font-medium text-gray-700 mb-1 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                        </svg>
                                        Categoría
                                    </label>
                                    <select id="filter_categoria" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 text-sm transition-all duration-200">
                                        <option value="">Todas las categorías</option>
                                        @foreach($categorias as $categoria)
                                            <option value="{{ $categoria->id }}">{{ $categoria->nombre_categoria }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex justify-between items-center">
                            <p class="text-sm text-gray-600" id="offersCount">Gestiona tus ofertas de prácticas inactivas</p>
                            <div class="flex items-center space-x-3">
                                <button id="btnApplyFilters" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors text-sm flex items-center shadow-sm hover:shadow-md transition-all duration-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                                    </svg>
                                    Aplicar filtros
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-between items-center mb-6">
                        <p class="text-gray-600" id="offersCount">Consulta y reactiva tus ofertas inactivas</p>
                        <button id="btnNuevaOferta" onclick="openModal()" class="group flex items-center text-white bg-purple-600 hover:bg-purple-700 px-4 py-2 rounded-lg text-sm font-medium shadow-md hover:shadow-lg transition-all duration-300">
                            <span class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1.5 group-hover:animate-pulse" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                Publicar nueva
                            </span>
                        </button>
                    </div>

                    <!-- Contenedor para la tabla de ofertas cargada por Ajax -->
                    <div id="offersTableContainer">
                        <!-- Spinner de carga -->
                        <div id="loadingSpinner" class="text-center py-12 hidden">
                            <div class="flex flex-col items-center justify-center">
                                <div class="relative w-16 h-16">
                                    <div class="absolute top-0 left-0 w-full h-full border-4 border-gray-200 rounded-full"></div>
                                    <div class="absolute top-0 left-0 w-full h-full border-4 border-t-purple-600 border-r-transparent border-b-transparent border-l-transparent rounded-full animate-spin"></div>
                                </div>
                                <p class="mt-4 text-gray-600 font-medium">Cargando ofertas...</p>
                                <p class="text-sm text-gray-500">Por favor, espere un momento.</p>
                            </div>
                        </div>

                        <!-- Tabla de ofertas inactivas y paginación -->
                        <div id="offersTableContent">
                            @if($inactivePublications->isEmpty())
                                <div class="bg-white text-center py-10 rounded-xl shadow-md border border-gray-100">
                                    <div class="inline-flex items-center justify-center p-3 bg-gray-100 rounded-full mb-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                                        </svg>
                                    </div>
                                    <h3 class="text-xl font-medium text-gray-800 mb-2">No hay ofertas inactivas</h3>
                                    <p class="text-gray-500 max-w-md mx-auto">Todas tus ofertas publicadas están actualmente activas.</p>
                                </div>
                            @else
                                <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100 mb-6">
                                    <!-- Diseño moderno de tarjetas para ofertas -->
                                    <div id="offersTableBody" class="divide-y divide-gray-100">
                                        @foreach($inactivePublications as $publication)
                                            <div class="offer-card p-5 hover:bg-gray-50 transition-all duration-200">
                                                <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4">
                                                    <!-- Información principal -->
                                                    <div class="flex-1">
                                                        <div class="flex items-start mb-2">
                                                            <div class="flex-shrink-0 mt-1">
                                                                <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                                    </svg>
                                                                </div>
                                                            </div>
                                                            <div class="ml-3 flex-1">
                                                                <h3 class="text-lg font-semibold text-gray-900 group">
                                                                    {{ $publication->titulo }}
                                                                    <span class="px-2.5 py-0.5 ml-2 text-xs font-medium rounded-full bg-gray-100 text-gray-800 inline-flex items-center">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                                                                        </svg>
                                                                        Inactiva
                                                                    </span>
                                                                </h3>
                                                                <p class="text-sm text-gray-600 mt-1 line-clamp-2">{{ $publication->descripcion }}</p>
                                                            </div>
                                                        </div>
                                                        
                                                        <!-- Detalles y meta información -->
                                                        <div class="flex flex-wrap gap-3 mt-3 ml-13">
                                                            <div class="inline-flex items-center px-3 py-1 rounded-md bg-gray-100 text-sm text-gray-700">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                </svg>
                                                                {{ ucfirst($publication->horario) }} • {{ $publication->horas_totales }} horas
                                                            </div>
                                                            
                                                            <div class="inline-flex items-center px-3 py-1 rounded-md bg-blue-50 text-sm text-blue-700">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                                                </svg>
                                                                {{ $publication->solicitudes_count }} {{ $publication->solicitudes_count == 1 ? 'solicitud' : 'solicitudes' }}
                                                            </div>
                                                            
                                                            @if($publication->categoria)
                                                            <div class="inline-flex items-center px-3 py-1 rounded-md bg-purple-50 text-sm text-purple-700">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                                                </svg>
                                                                {{ $publication->categoria->nombre_categoria ?? 'Categoría' }}
                                                            </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    
                                                    <!-- Acciones -->
                                                    <div class="flex flex-row md:flex-col gap-2 mt-2 md:mt-0 justify-end md:min-w-[120px]">
                                                        <a href="{{ route('empresa.applications.view', $publication->id) }}" class="inline-flex items-center justify-center px-4 py-2 bg-white border border-purple-300 rounded-lg text-purple-600 hover:bg-purple-50 hover:border-purple-400 transition-colors shadow-sm">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                            </svg>
                                                            Ver detalles
                                                        </a>
                                                        <form action="{{ route('empresa.offers.toggle', $publication->id) }}" method="POST" class="inline toggle-form">
                                                            @csrf
                                                            <button type="button" data-id="{{ $publication->id }}" class="toggle-button inline-flex items-center justify-center w-full px-4 py-2 bg-white border border-green-300 rounded-lg text-green-600 hover:bg-green-50 hover:border-green-400 transition-colors shadow-sm">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                </svg>
                                                                Activar
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                
                                <!-- Paginación -->
                                <div class="mt-6 bg-white p-4 rounded-xl border border-gray-100 shadow-sm">
                                    <div class="flex flex-col sm:flex-row justify-between items-center">
                                        <div class="text-sm text-gray-600 mb-3 sm:mb-0" id="paginationInfo">
                                            Mostrando <span class="font-medium text-gray-900" id="paginationFrom">{{ $inactivePublications->firstItem() ?? 0 }}</span> a 
                                            <span class="font-medium text-gray-900" id="paginationTo">{{ $inactivePublications->lastItem() ?? 0 }}</span> de 
                                            <span class="font-medium text-gray-900" id="paginationTotal">{{ $inactivePublications->total() }}</span> ofertas
                                        </div>
                                        <div class="flex space-x-2" id="paginationControls">
                                            <button type="button" id="prevPageBtn" class="px-3 py-1 rounded border border-gray-300 text-gray-600 hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed flex items-center text-sm transition-colors {{ $inactivePublications->onFirstPage() ? 'opacity-50 cursor-not-allowed' : '' }}" {{ $inactivePublications->onFirstPage() ? 'disabled' : '' }} data-page="{{ $inactivePublications->currentPage() - 1 }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                                </svg>
                                                Anterior
                                            </button>
                                            <div class="flex space-x-1" id="paginationPages">
                                                @for ($i = 1; $i <= $inactivePublications->lastPage(); $i++)
                                                    <button type="button" class="pagination-page-btn w-8 h-8 flex items-center justify-center rounded {{ $inactivePublications->currentPage() == $i ? 'bg-purple-600 text-white' : 'border border-gray-300 text-gray-600 hover:bg-gray-50' }} text-sm" data-page="{{ $i }}">
                                                        {{ $i }}
                                                    </button>
                                                @endfor
                                            </div>
                                            <button type="button" id="nextPageBtn" class="px-3 py-1 rounded border border-gray-300 text-gray-600 hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed flex items-center text-sm transition-colors {{ $inactivePublications->hasMorePages() ? '' : 'opacity-50 cursor-not-allowed' }}" {{ !$inactivePublications->hasMorePages() ? 'disabled' : '' }} data-page="{{ $inactivePublications->currentPage() + 1 }}">
                                                Siguiente
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Variables para el estado del filtro y paginación
        let currentPage = 1;
        let debounceTimer;
        const debounceDelay = 300; // Delay before searching after typing (in ms)
        let sortField = 'created_at';
        let sortDirection = 'desc';
        const itemsPerPage = 4; // Mostrar 4 publicaciones por página

        // Referencias a elementos de filtro - con seguridad para prevenir errores
        const filterTitulo = document.getElementById('filter_titulo');
        const filterHorario = document.getElementById('filter_horario');
        const filterCategoria = document.getElementById('filter_categoria');
        const btnApplyFilters = document.getElementById('btnApplyFilters');
        const btnResetFilters = document.getElementById('btnResetFilters');

        // Delegación de eventos para los botones de paginación y toggle (evento global)
        document.addEventListener('click', function(e) {
            // Botón "Anterior"
            if (e.target.closest('#prevPageBtn') && !e.target.closest('#prevPageBtn').disabled) {
                currentPage--;
                fetchData();
                return;
            }
            
            // Botón "Siguiente"
            if (e.target.closest('#nextPageBtn') && !e.target.closest('#nextPageBtn').disabled) {
                currentPage++;
                fetchData();
                return;
            }
            
            // Botones de número de página
            const pageBtn = e.target.closest('.pagination-page-btn');
            if (pageBtn) {
                const page = parseInt(pageBtn.dataset.page);
                if (currentPage !== page) {
                    currentPage = page;
                    fetchData();
                }
                return;
            }
            
            // Botones de toggle para activar publicación
            const toggleButton = e.target.closest('.toggle-button');
            if (toggleButton) {
                e.preventDefault();
                const publicationId = toggleButton.dataset.id;
                togglePublicationStatus(publicationId);
                return;
            }
        });
        
        // Función principal para cargar datos mediante fetch
        function fetchData() {
            showLoading();
            
            const params = new URLSearchParams({
                page: currentPage,
                per_page: itemsPerPage,
                sort_field: sortField,
                sort_direction: sortDirection
            });
            
            // Add filter values if they exist and have values
            if (filterTitulo && filterTitulo.value.trim() !== '') {
                params.append('titulo', filterTitulo.value.trim());
            }
            
            if (filterHorario && filterHorario.value !== '') {
                params.append('horario', filterHorario.value);
            }
            
            if (filterCategoria && filterCategoria.value !== '') {
                params.append('categoria_id', filterCategoria.value);
            }
            
            fetch(`/empresa/ofertas/inactivas?${params.toString()}`, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`Error: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    renderTable(data.data);
                    renderPagination(data.pagination);
                    updateOffersCount(data.pagination.total);
                } else {
                    throw new Error('Error en la respuesta del servidor');
                }
            })
            .catch(error => {
                console.error('Error al cargar datos:', error);
                showNotification('Error al cargar datos: ' + error.message, 'error');
                renderEmptyTable();
            })
            .finally(() => {
                hideLoading();
            });
        }
        
        // Función para renderizar la tabla con los datos
        function renderTable(data) {
            const tableBody = document.getElementById('offersTableBody');
            tableBody.innerHTML = '';
            
            if (!data || data.length === 0) {
                renderEmptyTable();
                return;
            }
            
            // Renderizar filas de datos como cards
            data.forEach(offer => {
                const offerCard = document.createElement('div');
                offerCard.className = 'offer-card p-5 hover:bg-gray-50 transition-all duration-200';
                
                offerCard.innerHTML = `
                    <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4">
                        <!-- Información principal -->
                        <div class="flex-1">
                            <div class="flex items-start mb-2">
                                <div class="flex-shrink-0 mt-1">
                                    <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-3 flex-1">
                                    <h3 class="text-lg font-semibold text-gray-900 group">
                                        ${offer.titulo}
                                        <span class="px-2.5 py-0.5 ml-2 text-xs font-medium rounded-full bg-gray-100 text-gray-800 inline-flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                                            </svg>
                                            Inactiva
                                        </span>
                                    </h3>
                                    <p class="text-sm text-gray-600 mt-1 line-clamp-2">${offer.descripcion}</p>
                                </div>
                            </div>
                            
                            <!-- Detalles y meta información -->
                            <div class="flex flex-wrap gap-3 mt-3 ml-13">
                                <div class="inline-flex items-center px-3 py-1 rounded-md bg-gray-100 text-sm text-gray-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    ${capitalizeFirstLetter(offer.horario)} • ${offer.horas_totales} horas
                                </div>
                                
                                <div class="inline-flex items-center px-3 py-1 rounded-md bg-blue-50 text-sm text-blue-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    ${offer.solicitudes_count} ${offer.solicitudes_count == 1 ? 'solicitud' : 'solicitudes'}
                                </div>
                                
                                ${offer.categoria ? 
                                    `<div class="inline-flex items-center px-3 py-1 rounded-md bg-purple-50 text-sm text-purple-700">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                        </svg>
                                        ${offer.categoria.nombre_categoria || 'Categoría'}
                                    </div>` : ''
                                }
                            </div>
                        </div>
                        
                        <!-- Acciones -->
                        <div class="flex flex-row md:flex-col gap-2 mt-2 md:mt-0 justify-end md:min-w-[120px]">
                            <a href="/empresa/ofertas/${offer.id}/solicitudes" class="inline-flex items-center justify-center px-4 py-2 bg-white border border-purple-300 rounded-lg text-purple-600 hover:bg-purple-50 hover:border-purple-400 transition-colors shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                Ver detalles
                            </a>
                            <form action="/empresa/ofertas/${offer.id}/toggle" method="POST" class="inline toggle-form">
                                @csrf
                                <button type="button" data-id="${offer.id}" class="toggle-button inline-flex items-center justify-center w-full px-4 py-2 bg-white border border-green-300 rounded-lg text-green-600 hover:bg-green-50 hover:border-green-400 transition-colors shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Activar
                                </button>
                            </form>
                        </div>
                    </div>
                `;
                
                tableBody.appendChild(offerCard);
            });
        }
        
        // Función para renderizar un mensaje cuando no hay datos
        function renderEmptyTable() {
            const offersTableContent = document.getElementById('offersTableContent');
            offersTableContent.innerHTML = `
                <div class="bg-white text-center py-10 rounded-xl shadow-md border border-gray-100">
                    <div class="inline-flex items-center justify-center p-3 bg-gray-100 rounded-full mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-medium text-gray-800 mb-2">No hay ofertas inactivas</h3>
                    <p class="text-gray-500 max-w-md mx-auto">Todas tus ofertas publicadas están actualmente activas.</p>
                </div>
            `;
        }
        
        // Función para renderizar la paginación
        function renderPagination(pagination) {
            const paginationInfo = document.getElementById('paginationInfo');
            const paginationPages = document.getElementById('paginationPages');
            const prevButton = document.getElementById('prevPageBtn');
            const nextButton = document.getElementById('nextPageBtn');
            
            if (!pagination || pagination.total === 0) {
                paginationInfo.innerHTML = 'No hay ofertas que mostrar';
                prevButton.disabled = true;
                nextButton.disabled = true;
                paginationPages.innerHTML = '';
                return;
            }
            
            // Actualizar información de paginación
            paginationInfo.innerHTML = `Mostrando <span class="font-medium text-gray-900">${pagination.from}</span> a 
                <span class="font-medium text-gray-900">${pagination.to}</span> de 
                <span class="font-medium text-gray-900">${pagination.total}</span> ofertas`;
            
            // Actualizar estado de botones
            prevButton.disabled = pagination.current_page <= 1;
            nextButton.disabled = pagination.current_page >= pagination.last_page;
            
            // Actualizar clases visuales para los botones de navegación
            if (pagination.current_page <= 1) {
                prevButton.classList.add('opacity-50', 'cursor-not-allowed');
            } else {
                prevButton.classList.remove('opacity-50', 'cursor-not-allowed');
            }
            
            if (pagination.current_page >= pagination.last_page) {
                nextButton.classList.add('opacity-50', 'cursor-not-allowed');
            } else {
                nextButton.classList.remove('opacity-50', 'cursor-not-allowed');
            }
            
            // Actualizar atributos data-page para los botones de navegación
            prevButton.setAttribute('data-page', pagination.current_page - 1);
            nextButton.setAttribute('data-page', pagination.current_page + 1);
            
            // Generar botones de páginas
            paginationPages.innerHTML = '';
            
            // Estrategia para mostrar páginas (máximo 5 botones)
            let startPage = Math.max(1, pagination.current_page - 2);
            let endPage = Math.min(pagination.last_page, startPage + 4);
            
            if (endPage - startPage < 4 && pagination.last_page > 5) {
                startPage = Math.max(1, endPage - 4);
            }
            
            // Añadir botones de páginas
            for (let i = startPage; i <= endPage; i++) {
                const pageButton = document.createElement('button');
                pageButton.type = 'button';
                pageButton.className = `pagination-page-btn w-8 h-8 flex items-center justify-center rounded ${
                    i === pagination.current_page
                        ? 'bg-purple-600 text-white'
                        : 'border border-gray-300 text-gray-600 hover:bg-gray-50'
                } text-sm`;
                pageButton.dataset.page = i;
                pageButton.textContent = i;
                paginationPages.appendChild(pageButton);
            }
        }
        
        // Función para actualizar el contador de ofertas
        function updateOffersCount(total) {
            const offersCount = document.getElementById('offersCount');
            if (offersCount) {
                if (total === 0) {
                    offersCount.textContent = 'No hay ofertas inactivas';
                } else if (total === 1) {
                    offersCount.textContent = '1 oferta inactiva';
                } else {
                    offersCount.textContent = `${total} ofertas inactivas`;
                }
            }
        }
        
        // Función para cambiar estado de publicación con Ajax
        function togglePublicationStatus(publicationId) {
            showLoading();
            
            // Crear FormData para enviar el token CSRF correctamente
            const formData = new FormData();
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            formData.append('_token', csrfToken);
            
            fetch(`/empresa/ofertas/${publicationId}/toggle`, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                body: formData,
                credentials: 'same-origin'
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`Error: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // Mostrar notificación de éxito
                    showNotification('Oferta activada correctamente', 'success');
                    
                    // Volver a cargar los datos
                    fetchData();
                } else {
                    showNotification(data.message || 'Error al cambiar el estado de la oferta', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Error de conexión: ' + error.message, 'error');
            })
            .finally(() => {
                hideLoading();
            });
        }
        
        // Funciones auxiliares
        function limitText(text, length) {
            return text.length > length ? text.substring(0, length) + '...' : text;
        }
        
        function capitalizeFirstLetter(string) {
            return string.charAt(0).toUpperCase() + string.slice(1);
        }
        
        function showLoading() {
            document.getElementById('loadingSpinner').classList.remove('hidden');
        }
        
        function hideLoading() {
            document.getElementById('loadingSpinner').classList.add('hidden');
        }
        
        function showNotification(message, type = 'success') {
            // Crear elemento de notificación
            const notification = document.createElement('div');
            notification.className = `fixed bottom-4 right-4 px-6 py-3 rounded-lg shadow-lg text-white ${
                type === 'success' ? 'bg-green-600' : 'bg-red-600'
            } transition-opacity duration-500 flex items-center z-50`;
            
            // Icono según tipo
            const iconSvg = type === 'success' 
                ? `<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                   </svg>`
                : `<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                   </svg>`;
            
            notification.innerHTML = iconSvg + message;
            document.body.appendChild(notification);
            
            // Ocultar después de 3 segundos
            setTimeout(() => {
                notification.classList.add('opacity-0');
                setTimeout(() => {
                    notification.remove();
                }, 500);
            }, 3000);
        }

        // Configure event listeners for filters only if they exist
        if (filterTitulo) {
            filterTitulo.addEventListener('input', function() {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(() => {
                    currentPage = 1; // Reset to first page
                    fetchData();
                }, debounceDelay);
            });
        }

        if (filterHorario) {
            filterHorario.addEventListener('change', function() {
                currentPage = 1;
                fetchData();
            });
        }

        if (filterCategoria) {
            filterCategoria.addEventListener('change', function() {
                currentPage = 1;
                fetchData();
            });
        }

        // Reset filters event
        if (btnResetFilters) {
            btnResetFilters.addEventListener('click', function() {
                if (filterTitulo) filterTitulo.value = '';
                if (filterHorario) filterHorario.value = '';
                if (filterCategoria) filterCategoria.value = '';
                currentPage = 1;
                fetchData();
            });
        }

        // Apply filters button event
        if (btnApplyFilters) {
            btnApplyFilters.addEventListener('click', function() {
                currentPage = 1;
                fetchData();
            });
        }

        // Iniciar la carga de datos de ofertas inactivas
        fetchData();
    });

    function openModal() {
        window.location.href = "{{ route('empresa.dashboard') }}";
        setTimeout(() => {
            if (window.openModal) {
                window.openModal();
            }
        }, 300);
    }
</script>
@endsection 