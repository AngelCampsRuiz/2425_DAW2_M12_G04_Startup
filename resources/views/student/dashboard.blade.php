@extends('layouts.app')

@section('content')
    <head>
        <!-- Incluye FontAwesome desde un CDN -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
        <!-- Incluye noUiSlider desde un CDN -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.7.0/nouislider.min.css" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.7.0/nouislider.min.js"></script>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
        <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    </head>
    <div class="min-h-screen bg-gray-100">
        @if(isset($is_demo) && $is_demo)
        <!-- Banner de demostración -->
        <div class="bg-yellow-100 border-b border-yellow-200 p-4 text-center">
            <p class="text-yellow-800 font-medium">
                <span class="font-bold">Vista de demostración</span> - Así se vería la plataforma si fueras un estudiante.
                <a href="{{ route('register') }}" class="text-purple-700 underline font-bold">Regístrate ahora</a> para acceder a todas las funcionalidades.
            </p>
        </div>
        @endif

        {{-- BREADCRUMBS --}}
        <div class="bg-white shadow-sm">
            <div class="container mx-auto px-4 py-3">
                <div class="flex items-center text-sm">
                    <a href="{{ route('home') }}" class="text-gray-500 hover:text-[#5e0490]">
                        <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        Inicio
                    </a>
                    <span class="mx-2 text-gray-400">/</span>
                    <span class="text-[#5e0490] font-medium">Ofertas laborales</span>
                </div>
            </div>
        </div>

        {{-- CONTENIDO PRINCIPAL --}}
        <div class="container mx-auto px-4 py-8">
            {{-- CONTENEDOR DE OFERTAS --}}
            <div id="ofertas-container" class="flex flex-col md:flex-row gap-6">
                {{-- SIDEBAR DE FILTROS --}}
                <div class="w-full md:w-1/4">
                    <div class="bg-white rounded-lg shadow p-6">
                        <h2 class="text-lg font-semibold text-gray-800 mb-4">Filtros</h2>
                        <div class="space-y-4">
                            <!-- Filtro de Categoría y Subcategoría -->
                            <div>
                                <h3 class="text-sm font-medium text-gray-600 mb-2">Categoría</h3>
                                <div class="space-y-2">
                                    @foreach($categorias as $categoria)
                                        <div>
                                            <label class="flex items-center">
                                                <input type="checkbox" name="categoria[]" value="{{ $categoria->id }}" class="categoria-checkbox form-checkbox h-4 w-4 text-[#5e0490] rounded focus:ring-[#5e0490] border-gray-300">
                                                <span class="ml-2 text-sm text-gray-700">{{ $categoria->nombre_categoria }}</span>
                                            </label>
                                            @if($categoria->subcategorias->count() > 0)
                                            <div id="subcategorias-{{ $categoria->id }}" class="pl-6 mt-2 hidden">
                                                @foreach($categoria->subcategorias as $subcategoria)
                                                    <label class="flex items-center">
                                                        <input type="checkbox" name="subcategoria[]" value="{{ $subcategoria->id }}" class="form-checkbox h-4 w-4 text-[#5e0490] rounded focus:ring-[#5e0490] border-gray-300">
                                                        <span class="ml-2 text-sm text-gray-700">{{ $subcategoria->nombre_subcategoria }}</span>
                                                    </label>
                                                @endforeach
                                            </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Filtro de Fecha de Publicación -->
                            <div>
                                <h3 class="text-sm font-medium text-gray-600 mb-2">Fecha de Publicación</h3>
                                <div class="flex space-x-4">
                                    <input type="date" name="fecha_inicio" id="fechaInicio" class="w-1/2 border-gray-300 rounded-lg shadow-sm focus:ring-[#5e0490] focus:border-[#5e0490]">
                                    <input type="date" name="fecha_fin" id="fechaFin" class="w-1/2 border-gray-300 rounded-lg shadow-sm focus:ring-[#5e0490] focus:border-[#5e0490]">
                                </div>
                            </div>

                            <!-- Filtro de Horario -->
                            <div>
                                <h3 class="text-sm font-medium text-gray-600 mb-2">Horario</h3>
                                <div class="space-y-2">
                                    @foreach($horarios as $horario)
                                        <label class="flex items-center">
                                            <input type="checkbox" name="horario[]" value="{{ $horario }}" class="form-checkbox h-4 w-4 text-[#5e0490] rounded focus:ring-[#5e0490] border-gray-300">
                                            <span class="ml-2 text-sm text-gray-700">{{ ucfirst($horario) }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Filtro de Horas Totales -->
                            <div>
                                <h3 class="text-sm font-medium text-gray-600 mb-2">Horas Totales</h3>
                                <div class="mb-6">
                                    <div class="flex justify-between text-sm text-gray-600 mb-2">
                                        <span id="horasTotalesMinValue">{{ $horasTotalesMin }}</span>
                                        <span id="horasTotalesMaxValue">{{ $horasTotalesMax }}</span>
                                    </div>
                                    <!-- Contenedor para noUiSlider -->
                                    <div id="horasTotalesSlider" class="mt-4"></div>
                                    <!-- Campos ocultos para enviar los valores en el formulario -->
                                    <input type="hidden" id="horasTotalesMin" name="horas_totales_min" value="{{ $horasTotalesMin }}">
                                    <input type="hidden" id="horasTotalesMax" name="horas_totales_max" value="{{ $horasTotalesMax }}">
                                </div>
                            </div>

                            <!-- Filtro de Radio de Distancia -->
                            <div>
                                <h3 class="text-sm font-medium text-gray-600 mb-2">Radio de Distancia</h3>
                                <div class="mb-6">
                                    <!-- Mapa para mostrar el radio -->
                                    <div id="radiusMap" class="w-full h-48 rounded-lg mb-4"></div>
                                    
                                    <div class="flex justify-between text-sm text-gray-600 mb-2">
                                        <span>0 km</span>
                                        <span id="radioValue">50 km</span>
                                    </div>
                                    <!-- Contenedor para noUiSlider del radio -->
                                    <div id="radioSlider" class="mt-2"></div>
                                    <!-- Campo oculto para el radio -->
                                    <input type="hidden" id="radioDistancia" name="radio_distancia" value="50">
                                    <!-- Campos ocultos para la ubicación -->
                                    <input type="hidden" id="userLat" name="user_lat" value="">
                                    <input type="hidden" id="userLng" name="user_lng" value="">
                                    
                                    <!-- Botón de ubicación -->
                                    <div class="mt-4">
                                        <button type="button" id="obtenerUbicacion" 
                                                class="w-full px-4 py-2 bg-[#5e0490] text-white rounded-lg hover:bg-[#4a0370] transition-colors flex items-center justify-center gap-2">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                      d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            </svg>
                                            Usar mi ubicación
                                        </button>
                                        <p id="ubicacionStatus" class="mt-2 text-sm text-center hidden"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- CONTENIDO PRINCIPAL --}}
                <div class="w-full md:w-3/4">
                    {{-- BARRA DE BÚSQUEDA Y ORDENAMIENTO --}}
                    <div class="flex flex-col md:flex-row gap-4 mb-6">
                        <div class="flex-1">
                            <form id="searchForm" class="flex gap-4 items-center"
                                data-route="{{ isset($is_demo) && $is_demo ? route('demo.student') : route('student.dashboard') }}">
                                <div class="relative flex-1">
                                    <input type="text" name="search" id="searchInput" value="{{ request('search') }}"
                                    placeholder="Buscar publicaciones..."
                                        class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary focus:outline-none transition duration-200">
                                    <svg class="absolute left-3 top-2.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                    </svg>
                                </div>
                                <input type="hidden" name="order_by" id="orderBy" value="{{ request('order_by', 'fecha_publicacion') }}">
                                <input type="hidden" name="order_direction" id="orderDirection" value="{{ request('order_direction', 'desc') }}">
                                <button type="button" id="clearButton" class="flex items-center justify-center px-4 py-2 bg-[#5e0490] text-white rounded-lg hover:bg-[#4a0370] transition duration-200">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                        <div class="w-full md:w-48">
                            <div class="relative">
                                <select id="orderSelect" class="w-full pl-3 pr-10 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary focus:outline-none appearance-none transition duration-200">
                                <option value="{{ isset($is_demo) && $is_demo ?
                                    route('demo.student', ['order_by' => 'fecha_publicacion', 'order_direction' => 'desc']) :
                                    route('student.dashboard', ['order_by' => 'fecha_publicacion', 'order_direction' => 'desc']) }}"
                                    {{ request('order_by') == 'fecha_publicacion' && request('order_direction') == 'desc' ? 'selected' : '' }}>
                                    Más recientes
                                </option>
                                <option value="{{ isset($is_demo) && $is_demo ?
                                    route('demo.student', ['order_by' => 'fecha_publicacion', 'order_direction' => 'asc']) :
                                    route('student.dashboard', ['order_by' => 'fecha_publicacion', 'order_direction' => 'asc']) }}"
                                    {{ request('order_by') == 'fecha_publicacion' && request('order_direction') == 'asc' ? 'selected' : '' }}>
                                    Más antiguos
                                </option>
                                <option value="{{ isset($is_demo) && $is_demo ?
                                    route('demo.student', ['order_by' => 'horas_totales', 'order_direction' => 'desc']) :
                                    route('student.dashboard', ['order_by' => 'horas_totales', 'order_direction' => 'desc']) }}"
                                    {{ request('order_by') == 'horas_totales' && request('order_direction') == 'desc' ? 'selected' : '' }}>
                                    Mayor duración
                                </option>
                                <option value="{{ isset($is_demo) && $is_demo ?
                                    route('demo.student', ['order_by' => 'horas_totales', 'order_direction' => 'asc']) :
                                    route('student.dashboard', ['order_by' => 'horas_totales', 'order_direction' => 'asc']) }}"
                                    {{ request('order_by') == 'horas_totales' && request('order_direction') == 'asc' ? 'selected' : '' }}>
                                    Menor duración
                                </option>
                            </select>
                                <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- GRID DE PUBLICACIONES --}}
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        @foreach($publications as $publication)
                            <div class="bg-white rounded-lg shadow overflow-hidden relative"
                                 data-lat="{{ $publication->empresa->user->lat ?? '' }}"
                                 data-lng="{{ $publication->empresa->user->lng ?? '' }}">
                                <div class="flex">
                                    {{-- IMAGEN DE LA EMPRESA --}}
                                    <div class="w-1/3 relative overflow-hidden flex flex-col items-center justify-center" style="aspect-ratio: 1/1;">
                                        <img src="{{ asset('public/profile_images/' . ($publication->empresa->user->imagen ?? 'company-default.png')) }}"
                                            alt="{{ $publication->empresa->user->nombre }}"
                                            class="max-w-full max-h-full object-contain p-2 transition-all duration-300 hover:scale-105 m-auto">
                                        <div class="bg-gray-50 text-center w-full py-1 absolute bottom-0">
                                            <a href="{{ route('profile.show', $publication->empresa->user->id) }}" class="group">
                                                <p class="text-xs font-medium text-gray-700 hover:text-[#5e0490] truncate px-1 transition-colors duration-200">
                                                    {{ $publication->empresa->user->nombre }}
                                                </p>
                                            </a>
                                        </div>
                                    </div>
                                    {{-- INFORMACIÓN DE LA PUBLICACIÓN --}}
                                    <div class="w-2/3 p-4">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                @if(isset($is_demo) && $is_demo)
                                                <a href="{{ route('register') }}" class="hover:text-[#5e0490] transition-colors">
                                                    <h3 class="text-lg font-semibold text-gray-900">{{ $publication->titulo }}</h3>
                                                </a>
                                                @else
                                                <a href="{{ route('publication.show', $publication->id) }}" class="hover:text-[#5e0490] transition-colors">
                                                    <h3 class="text-lg font-semibold text-gray-900">{{ $publication->titulo }}</h3>
                                                </a>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="flex items-center text-sm text-gray-600 mb-2">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            {{ ucfirst($publication->horario) }}
                                        </div>
                                        <div class="flex items-center text-sm text-gray-600 mb-3">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            {{ $publication->horas_totales }} horas totales
                                        </div>
                                        <p class="text-sm text-gray-600 line-clamp-2">{{ $publication->descripcion }}</p>
                                    </div>
                                </div>
                                {{-- Añadir un elemento para mostrar la distancia --}}
                                <div class="distance-info text-sm text-gray-600 px-4 pb-2"></div>
                            </div>
                        @endforeach
                    </div>

                    {{-- PAGINACIÓN --}}
                    <div class="mt-8 flex justify-center">
                        <div class="pagination-container">
                            {{ $publications->onEachSide(1)->links() }}
                        </div>
                    </div>
                </div>
            </div>

            {{-- CONTENEDOR DE SOLICITUDES (inicialmente oculto) --}}
            <div id="solicitudes-container" class="hidden container mx-auto px-4 py-8">
                <meta name="csrf-token" content="{{ csrf_token() }}">
                <h1 class="text-2xl font-bold text-gray-800 mb-6">Mis Solicitudes</h1>
                
                {{-- ESTADÍSTICAS --}}
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                    <div class="bg-white rounded-lg shadow p-4">
                        <div class="flex items-center">
                            <div class="rounded-full bg-purple-100 p-3 mr-4">
                                <svg class="w-6 h-6 text-[#5e0490]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Total</p>
                                <p class="text-xl font-bold text-gray-800" id="stats-total">0</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-lg shadow p-4">
                        <div class="flex items-center">
                            <div class="rounded-full bg-yellow-100 p-3 mr-4">
                                <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Pendientes</p>
                                <p class="text-xl font-bold text-gray-800" id="stats-pendientes">0</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-lg shadow p-4">
                        <div class="flex items-center">
                            <div class="rounded-full bg-green-100 p-3 mr-4">
                                <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Aprobadas</p>
                                <p class="text-xl font-bold text-gray-800" id="stats-aprobadas">0</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-lg shadow p-4">
                        <div class="flex items-center">
                            <div class="rounded-full bg-red-100 p-3 mr-4">
                                <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Rechazadas</p>
                                <p class="text-xl font-bold text-gray-800" id="stats-rechazadas">0</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                {{-- FILTROS --}}
                <div class="bg-white rounded-lg shadow p-4 mb-6">
                    <div class="flex flex-col md:flex-row justify-between items-center mb-4">
                        <h2 class="text-lg font-semibold text-gray-800">Filtrar por estado</h2>
                        <div class="flex mt-2 md:mt-0">
                            <a href="#" data-estado="todos" class="estado-link px-4 py-2 rounded-lg bg-purple-100 text-[#5e0490] mr-2">
                                Todas
                            </a>
                            <a href="#" data-estado="pendiente" class="estado-link px-4 py-2 rounded-lg bg-gray-100 text-gray-700 hover:bg-gray-200 mr-2">
                                Pendientes
                            </a>
                            <a href="#" data-estado="aprobada" class="estado-link px-4 py-2 rounded-lg bg-gray-100 text-gray-700 hover:bg-gray-200 mr-2">
                                Aprobadas
                            </a>
                            <a href="#" data-estado="rechazada" class="estado-link px-4 py-2 rounded-lg bg-gray-100 text-gray-700 hover:bg-gray-200">
                                Rechazadas
                            </a>
                        </div>
                    </div>
                </div>
                
                {{-- TABLA DE SOLICITUDES CON AJAX --}}
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    {{-- INDICADOR DE CARGA --}}
                    <div id="loading-indicator" class="p-8 flex justify-center items-center">
                        <svg class="animate-spin h-10 w-10 text-[#5e0490]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </div>
                    
                    {{-- CONTENEDOR PARA LA TABLA --}}
                    <div id="solicitudes-table" class="overflow-x-auto">
                        <div id="solicitudes-data-container">
                            {{-- Aquí se cargará la tabla mediante AJAX --}}
                        </div>
                    </div>
                    
                    {{-- MENSAJE DE NO SOLICITUDES --}}
                    <div id="no-solicitudes" class="text-center py-10 hidden">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No hay solicitudes</h3>
                        <p class="mt-1 text-sm text-gray-500">
                            No se encontraron solicitudes con los filtros seleccionados.
                        </p>
                    </div>
                </div>
            </div>

            {{-- CONTENEDOR DE DETALLES DE SOLICITUD (inicialmente oculto) --}}
            <div id="solicitud-detalle-container" class="hidden container mx-auto px-4 py-8">
                {{-- INDICADOR DE CARGA --}}
                <div id="loading-indicator-detalle" class="p-8 flex justify-center items-center">
                    <svg class="animate-spin h-10 w-10 text-[#5e0490]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </div>
                
                {{-- CONTENIDO DE DETALLES --}}
                <div id="solicitud-detalle-content">
                    {{-- Aquí se cargará el detalle de la solicitud mediante AJAX --}}
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Estilos para noUiSlider */
        .noUi-connect {
            background: #5e0490 !important;
        }

        /* Estilos para las imágenes de empresas */
        .w-1/3.relative.overflow-hidden {
            min-height: 100px;
            max-height: 140px;
            border-right: 1px solid #f3f4f6;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 8px;
            padding-bottom: 25px; /* Espacio para el nombre de la empresa */
        }

        .w-1/3.relative.overflow-hidden img {
            object-position: center;
            object-fit: contain;
            max-width: 85%;
            max-height: 85%;
            width: auto;
            height: auto;
            position: relative;
            box-shadow: none;
            margin: 0 auto;
        }

        .bg-gray-50.text-center {
            box-shadow: 0 -2px 5px rgba(0,0,0,0.05);
        }

        .bg-gray-50.text-center p {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        @media (max-width: 640px) {
            .w-1/3.relative.overflow-hidden {
                min-height: 80px;
            }
        }

        .noUi-handle {
            border-radius: 50% !important;
            background-color: #5e0490 !important;
            border: 2px solid #fff !important;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2) !important;
            width: 20px !important;
            height: 20px !important;
            right: -10px !important;
            top: -7px !important;
            cursor: pointer !important;
            transition: transform 0.2s ease, box-shadow 0.2s ease !important;
        }

        .noUi-handle:hover {
            transform: scale(1.1);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3) !important;
        }

        .noUi-handle:active {
            transform: scale(1.2);
        }

        .noUi-handle:before, .noUi-handle:after {
            display: none !important;
        }

        .noUi-target {
            border-radius: 4px !important;
            border: none !important;
            background-color: #e2e8f0 !important;
            box-shadow: none !important;
            height: 8px !important;
        }

        .noUi-horizontal {
            height: 8px !important;
        }

        .noUi-tooltip {
            display: none !important;
        }

        /* Texto de los valores mínimo y máximo */
        .flex.justify-between.text-sm.text-gray-600 {
            margin-top: 8px; /* Espacio entre el slider y los valores */
        }

        /* Estilos para la paginación */
        .pagination-container nav {
            display: flex;
            justify-content: center;
        }

        .pagination-container .flex.justify-between.flex-1 {
            display: none; /* Ocultar el texto de paginación */
        }

        .pagination-container .relative.inline-flex.items-center {
            padding: 0.5rem 1rem;
            margin: 0 0.25rem;
            border-radius: 0.375rem;
            font-weight: 500;
            font-size: 0.875rem;
            color: #4b5563;
            background-color: #ffffff;
            border: 1px solid #d1d5db;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            transition: all 0.2s;
        }

        .pagination-container .relative.inline-flex.items-center:hover {
            background-color: #f3f4f6;
            color: #111827;
        }

        .pagination-container .relative.z-0.inline-flex.shadow-sm {
            border-radius: 0.375rem;
            overflow: hidden;
        }

        .pagination-container span[aria-current="page"] .relative.inline-flex.items-center {
            background-color: #5e0490;
            color: white;
            border-color: #5e0490;
        }

        /* Estilos para el botón de ubicación */
        #obtenerUbicacion:disabled {
            background-color: #9ca3af;
            cursor: not-allowed;
        }

        #ubicacionStatus {
            transition: all 0.3s ease;
        }

        #ubicacionStatus.text-green-600 {
            color: #059669;
        }

        #ubicacionStatus.text-red-600 {
            color: #dc2626;
        }

        /* Estilos adicionales para el slider de distancia */
        #radioSlider .noUi-connect {
            background: #5e0490;
        }

        #radioSlider .noUi-handle {
            background: #5e0490;
            border: 2px solid #fff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
            cursor: pointer;
        }

        #radioSlider .noUi-handle:hover {
            transform: scale(1.1);
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Inicializar el slider de rango para horas totales
            const horasTotalesSlider = document.getElementById('horasTotalesSlider');
            const horasTotalesMin = document.getElementById('horasTotalesMin');
            const horasTotalesMax = document.getElementById('horasTotalesMax');
            const horasTotalesMinValue = document.getElementById('horasTotalesMinValue');
            const horasTotalesMaxValue = document.getElementById('horasTotalesMaxValue');

            if (horasTotalesSlider) {
                const minValue = parseInt(horasTotalesMin.value);
                const maxValue = parseInt(horasTotalesMax.value);

                noUiSlider.create(horasTotalesSlider, {
                    start: [minValue, maxValue],
                    connect: true,
                    step: 1,
                    range: {
                        'min': minValue,
                        'max': maxValue
                    }
                });

                // Actualizar los valores mostrados y los campos ocultos
                horasTotalesSlider.noUiSlider.on('update', function(values, handle) {
                    const value = Math.round(values[handle]);
                    if (handle === 0) {
                        horasTotalesMinValue.textContent = value;
                        horasTotalesMin.value = value;
                    } else {
                        horasTotalesMaxValue.textContent = value;
                        horasTotalesMax.value = value;
                    }
                });

                // Ejecutar la búsqueda cuando el usuario suelta el control deslizante
                horasTotalesSlider.noUiSlider.on('change', function() {
                    fetchPublications();
                });
            }

            // Resto del código de dashboard.js
            let debounceTimer;
            const searchForm = document.getElementById('searchForm');
            const searchInput = document.getElementById('searchInput');
            const orderBy = document.getElementById('orderBy');
            const orderDirection = document.getElementById('orderDirection');
            const orderSelect = document.getElementById('orderSelect');
            const clearButton = document.getElementById('clearButton');
            const horarioCheckboxes = document.querySelectorAll('input[name="horario[]"]');
            const categoriaCheckboxes = document.querySelectorAll('.categoria-checkbox');
            const subcategoriaCheckboxes = document.querySelectorAll('input[name="subcategoria[]"]');
            const fechaInicio = document.getElementById('fechaInicio');
            const fechaFin = document.getElementById('fechaFin');
            const route = searchForm ? searchForm.getAttribute('data-route') : '';
            const favoriteButtons = document.querySelectorAll('.favorite-button');
            const favoritosCheckbox = document.getElementById('favoritosCheckbox');

            // Mostrar/ocultar subcategorías al seleccionar una categoría
            categoriaCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const subcategoriasDiv = document.getElementById(`subcategorias-${this.value}`);
                    if (subcategoriasDiv) {
                        if (this.checked) {
                            subcategoriasDiv.classList.remove('hidden');
                        } else {
                            subcategoriasDiv.classList.add('hidden');
                        }
                    }
                    fetchPublications();
                });
            });

            const fetchPublications = () => {
                if (!searchForm) return;

                const searchTerm = searchInput.value;
                const orderByValue = orderBy.value;
                const orderDirectionValue = orderDirection.value;
                const selectedHorarios = Array.from(horarioCheckboxes)
                    .filter(checkbox => checkbox.checked)
                    .map(checkbox => checkbox.value);
                const selectedCategorias = Array.from(categoriaCheckboxes)
                    .filter(checkbox => checkbox.checked)
                    .map(checkbox => checkbox.value);
                const selectedSubcategorias = Array.from(document.querySelectorAll('input[name="subcategoria[]"]'))
                    .filter(checkbox => checkbox.checked)
                    .map(checkbox => checkbox.value);
                const fechaInicioValue = fechaInicio.value;
                const fechaFinValue = fechaFin.value;
                const horasTotalesMinValue = horasTotalesMin.value;
                const horasTotalesMaxValue = horasTotalesMax.value;
                const favoritosValue = favoritosCheckbox && favoritosCheckbox.checked ? 'on' : 'off';

                const params = new URLSearchParams();
                if (searchTerm) params.append('search', searchTerm);
                if (orderByValue) params.append('order_by', orderByValue);
                if (orderDirectionValue) params.append('order_direction', orderDirectionValue);
                selectedHorarios.forEach(horario => params.append('horario[]', horario));
                selectedCategorias.forEach(categoria => params.append('categoria[]', categoria));
                selectedSubcategorias.forEach(subcategoria => params.append('subcategoria[]', subcategoria));
                if (fechaInicioValue) params.append('fecha_inicio', fechaInicioValue);
                if (fechaFinValue) params.append('fecha_fin', fechaFinValue);
                params.append('horas_totales_min', horasTotalesMinValue);
                params.append('horas_totales_max', horasTotalesMaxValue);
                params.append('favoritos', favoritosValue);

                fetch(`${route}?${params.toString()}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const newContent = doc.querySelector('.grid');
                    if (newContent) {
                        document.querySelector('.grid').innerHTML = newContent.innerHTML;
                    }

                    // Reinicializar los botones de favoritos después de actualizar el contenido
                    initFavoriteButtons();
                });
            };

            searchInput && searchInput.addEventListener('input', function() {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(fetchPublications, 300);
            });

            orderSelect && orderSelect.addEventListener('change', function(event) {
                const url = new URL(event.target.value);
                orderBy.value = url.searchParams.get('order_by');
                orderDirection.value = url.searchParams.get('order_direction');
                fetchPublications();
            });

            clearButton && clearButton.addEventListener('click', function() {
                searchInput.value = '';
                orderBy.value = 'fecha_publicacion';
                orderDirection.value = 'desc';
                orderSelect.value = `${route}?order_by=fecha_publicacion&order_direction=desc`;
                horarioCheckboxes.forEach(checkbox => checkbox.checked = false);
                categoriaCheckboxes.forEach(checkbox => {
                    checkbox.checked = false;
                    const categoriaId = checkbox.value;
                    const subcategoriasDiv = document.getElementById(`subcategorias-${categoriaId}`);
                    if (subcategoriasDiv) {
                        subcategoriasDiv.classList.add('hidden');
                        subcategoriasDiv.querySelectorAll('input[type="checkbox"]').forEach(subCheckbox => {
                            subCheckbox.checked = false;
                        });
                    }
                });
                fechaInicio.value = '';
                fechaFin.value = '';

                // Resetear el slider de rango
                if (horasTotalesSlider && horasTotalesSlider.noUiSlider) {
                    const minValue = parseInt(horasTotalesSlider.noUiSlider.options.range.min);
                    const maxValue = parseInt(horasTotalesSlider.noUiSlider.options.range.max);
                    horasTotalesSlider.noUiSlider.set([minValue, maxValue]);
                }

                fetchPublications();
            });

            horarioCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', fetchPublications);
            });

            subcategoriaCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', fetchPublications);
            });

            fechaInicio && fechaInicio.addEventListener('change', fetchPublications);
            fechaFin && fechaFin.addEventListener('change', fetchPublications);

            favoritosCheckbox && favoritosCheckbox.addEventListener('change', fetchPublications);

            // Función para inicializar los botones de favoritos
            function initFavoriteButtons() {
                const favoriteButtons = document.querySelectorAll('.favorite-button');
                favoriteButtons.forEach(button => {
                    // Eliminar eventos anteriores para evitar duplicados
                    const newButton = button.cloneNode(true);
                    button.parentNode.replaceChild(newButton, button);

                    newButton.addEventListener('click', function() {
                        const publicationId = this.dataset.publicationId;
                        const icon = this.querySelector('i');
                        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                        fetch(`/toggle-favorite/${publicationId}`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken,
                                'Content-Type': 'application/json'
                            }
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.status === 'added') {
                                icon.classList.remove('far');
                                icon.classList.add('fas', 'text-yellow-500');
                            } else {
                                icon.classList.remove('fas', 'text-yellow-500');
                                icon.classList.add('far');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                    });
                });
            }

            // Inicializar los botones de favoritos al cargar la página
            initFavoriteButtons();

            // Manejar la paginación con AJAX
            const paginationContainer = document.querySelector('.pagination-container');
            if (paginationContainer) {
                paginationContainer.addEventListener('click', function(e) {
                    e.preventDefault(); // Prevenir el comportamiento por defecto
                    
                    // Verificar si el clic fue en un enlace de paginación
                    const paginationLink = e.target.closest('a[href*="page="]');
                    if (!paginationLink) return;
                    
                    const pageUrl = paginationLink.getAttribute('href');
                    
                    // Mostrar spinner si existe
                    const searchSpinner = document.getElementById('searchSpinner');
                    if (searchSpinner) searchSpinner.classList.remove('hidden');
                    
                    // Hacer la petición AJAX
                    fetch(pageUrl, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.text())
                    .then(html => {
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(html, 'text/html');
                        
                        // Actualizar el contenido de las publicaciones
                        const newGridContent = doc.querySelector('.grid');
                        if (newGridContent) {
                            document.querySelector('.grid').innerHTML = newGridContent.innerHTML;
                        }
                        
                        // Actualizar la paginación
                        const newPagination = doc.querySelector('.pagination-container');
                        if (newPagination) {
                            paginationContainer.innerHTML = newPagination.innerHTML;
                        }
                        
                        // Reinicializar los botones de favoritos si la función existe
                        if (typeof initFavoriteButtons === 'function') {
                            initFavoriteButtons();
                        }
                        
                        // Actualizar la URL sin recargar la página
                        window.history.pushState({}, '', pageUrl);
                        
                        // Hacer scroll hacia arriba suavemente
                        window.scrollTo({
                            top: 0,
                            behavior: 'smooth'
                        });
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    })
                    .finally(() => {
                        // Ocultar spinner si existe
                        if (searchSpinner) searchSpinner.classList.add('hidden');
                    });
                });
            }

            // Nuevas funciones para gestionar la navegación por pestañas
            const ofertasBtn = document.getElementById('ofertas-btn');
            const solicitudesBtn = document.getElementById('solicitudes-btn');
            const ofertasContainer = document.getElementById('ofertas-container');
            const solicitudesContainer = document.getElementById('solicitudes-container');

            // Al hacer clic en el botón de ofertas
            ofertasBtn.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Cambiar clases de botones
                ofertasBtn.classList.add('text-[#5e0490]', 'border-b-2', 'border-[#5e0490]');
                ofertasBtn.classList.remove('text-gray-600', 'hover:text-[#5e0490]');
                
                solicitudesBtn.classList.remove('text-[#5e0490]', 'border-b-2', 'border-[#5e0490]');
                solicitudesBtn.classList.add('text-gray-600', 'hover:text-[#5e0490]');
                
                // Mostrar/ocultar contenido
                ofertasContainer.classList.remove('hidden');
                solicitudesContainer.classList.add('hidden');
                
                // Cambiar la URL sin recargar la página
                window.history.pushState({}, 'Ofertas Laborales', '{{ route("student.dashboard") }}');
            });

            // Al hacer clic en el botón de solicitudes
            solicitudesBtn.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Cambiar clases de botones
                solicitudesBtn.classList.add('text-[#5e0490]', 'border-b-2', 'border-[#5e0490]');
                solicitudesBtn.classList.remove('text-gray-600', 'hover:text-[#5e0490]');
                
                ofertasBtn.classList.remove('text-[#5e0490]', 'border-b-2', 'border-[#5e0490]');
                ofertasBtn.classList.add('text-gray-600', 'hover:text-[#5e0490]');
                
                // Mostrar/ocultar contenido
                ofertasContainer.classList.add('hidden');
                solicitudesContainer.classList.remove('hidden');
                
                // Cargar solicitudes si es la primera vez
                if (!solicitudesContainer.dataset.loaded) {
                    cargarSolicitudes();
                    solicitudesContainer.dataset.loaded = 'true';
                }
                
                // Cambiar la URL sin recargar la página
                window.history.pushState({}, 'Mis Solicitudes', '{{ route("student.dashboard") }}?tab=solicitudes');
            });

            // Funciones para gestionar las solicitudes
            const solicitudesTable = document.getElementById('solicitudes-table');
            const solicitudesDataContainer = document.getElementById('solicitudes-data-container');
            const statsTotal = document.getElementById('stats-total');
            const statsPendientes = document.getElementById('stats-pendientes');
            const statsAprobadas = document.getElementById('stats-aprobadas');
            const statsRechazadas = document.getElementById('stats-rechazadas');
            const estadoLinks = document.querySelectorAll('.estado-link');
            const loadingIndicator = document.getElementById('loading-indicator');
            const noSolicitudesMessage = document.getElementById('no-solicitudes');
            
            // Estado actual del filtro
            let currentFilter = 'todos';

            // Función para cargar las solicitudes
            function cargarSolicitudes(estado = 'todos') {
                // Mostrar indicador de carga
                if (loadingIndicator) loadingIndicator.classList.remove('hidden');
                
                // Ocultar mensaje de no solicitudes
                if (noSolicitudesMessage) noSolicitudesMessage.classList.add('hidden');
                
                // Actualizar links de filtro
                estadoLinks.forEach(link => {
                    const linkEstado = link.dataset.estado || 'todos';
                    if (linkEstado === estado) {
                        link.classList.add('bg-purple-100', 'text-[#5e0490]');
                        link.classList.remove('bg-gray-100', 'text-gray-700', 'hover:bg-gray-200');
                    } else {
                        link.classList.remove('bg-purple-100', 'text-[#5e0490]');
                        link.classList.add('bg-gray-100', 'text-gray-700', 'hover:bg-gray-200');
                    }
                });
                
                // Actualizar estado actual
                currentFilter = estado;
                
                // Construir URL con parámetros de filtro
                const url = new URL(`${window.location.origin}/estudiante/api/solicitudes`);
                if (estado !== 'todos') {
                    url.searchParams.append('estado', estado);
                }
                
                // Realizar petición AJAX
                fetch(url)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Error en la petición');
                        }
                        return response.json();
                    })
                    .then(data => {
                        // Actualizar estadísticas
                        if (statsTotal) statsTotal.textContent = data.stats.total;
                        if (statsPendientes) statsPendientes.textContent = data.stats.pendientes;
                        if (statsAprobadas) statsAprobadas.textContent = data.stats.aprobadas;
                        if (statsRechazadas) statsRechazadas.textContent = data.stats.rechazadas;
                        
                        // Actualizar tabla de solicitudes
                        if (solicitudesDataContainer) {
                            if (data.solicitudes.length > 0) {
                                solicitudesDataContainer.innerHTML = generarTabla(data.solicitudes);
                                initButtons();
                            } else {
                                // Mostrar mensaje de no solicitudes
                                if (noSolicitudesMessage) noSolicitudesMessage.classList.remove('hidden');
                                if (solicitudesTable) solicitudesTable.classList.add('hidden');
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        // Mostrar mensaje de error
                        if (solicitudesDataContainer) {
                            solicitudesDataContainer.innerHTML = `
                                <div class="text-center py-8">
                                    <p class="text-red-500">Error al cargar las solicitudes. Inténtalo de nuevo más tarde.</p>
                                </div>
                            `;
                        }
                    })
                    .finally(() => {
                        // Ocultar indicador de carga
                        if (loadingIndicator) loadingIndicator.classList.add('hidden');
                    });
            }
            
            // Función para generar el HTML de la tabla con los datos
            function generarTabla(solicitudes) {
                if (solicitudes.length === 0) {
                    return '';
                }
                
                if (solicitudesTable) solicitudesTable.classList.remove('hidden');
                
                let html = `
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Institución
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Clase
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Fecha solicitud
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Estado
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                `;
                
                solicitudes.forEach(solicitud => {
                    html += `
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <img class="h-10 w-10 rounded-full object-cover" 
                                            src="${window.location.origin}/public/profile_images/${solicitud.institucion.imagen}" 
                                            alt="${solicitud.institucion.nombre}">
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            ${solicitud.institucion.nombre}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    ${solicitud.clase ? solicitud.clase.nombre : 'No asignada'}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    ${solicitud.fecha_solicitud}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                    `;
                    
                    if (solicitud.estado === 'pendiente') {
                        html += `
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                Pendiente
                            </span>
                        `;
                    } else if (solicitud.estado === 'aprobada') {
                        html += `
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                Aprobada
                            </span>
                        `;
                    } else if (solicitud.estado === 'rechazada') {
                        html += `
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                Rechazada
                            </span>
                        `;
                    }
                    
                    html += `
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="#" data-solicitud-id="${solicitud.id}" class="ver-solicitud-btn text-[#5e0490] hover:text-[#4a0370] mr-3">
                                    Ver detalles
                                </a>
                    `;
                    
                    if (solicitud.estado === 'pendiente') {
                        html += `
                            <button data-solicitud-id="${solicitud.id}" class="cancel-btn text-red-600 hover:text-red-900">
                                Cancelar
                            </button>
                        `;
                    }
                    
                    html += `
                            </td>
                        </tr>
                    `;
                });
                
                html += `
                        </tbody>
                    </table>
                `;
                
                return html;
            }
            
            // Función para inicializar los botones de cancelar
            function initCancelButtons() {
                const cancelButtons = document.querySelectorAll('.cancel-btn');
                
                cancelButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        const solicitudId = this.dataset.solicitudId;
                        
                        if (confirm('¿Estás seguro de que deseas cancelar esta solicitud?')) {
                            // Obtener el token CSRF
                            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                            
                            // Realizar petición AJAX
                            fetch(`${window.location.origin}/estudiante/api/solicitudes/${solicitudId}/cancelar`, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': csrfToken
                                }
                            })
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error('Error en la petición');
                                }
                                return response.json();
                            })
                            .then(data => {
                                if (data.success) {
                                    // Recargar las solicitudes
                                    cargarSolicitudes(currentFilter);
                                    
                                    // Mostrar mensaje de éxito
                                    mostrarMensaje('Solicitud cancelada correctamente', 'success');
                                } else {
                                    throw new Error(data.message || 'Error al cancelar la solicitud');
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                // Mostrar mensaje de error
                                mostrarMensaje(error.message || 'Error al cancelar la solicitud', 'error');
                            });
                        }
                    });
                });
            }
            
            // Función para inicializar todos los botones
            function initButtons() {
                // Inicializar botones de cancelar
                initCancelButtons();
                
                // Inicializar botones de ver detalles
                const verButtons = document.querySelectorAll('.ver-solicitud-btn');
                verButtons.forEach(button => {
                    button.addEventListener('click', function(e) {
                        e.preventDefault();
                        const solicitudId = this.dataset.solicitudId;
                        
                        // Cargar detalle de solicitud
                        if (typeof cargarDetalleSolicitud === 'function') {
                            cargarDetalleSolicitud(solicitudId);
                        } else {
                            // Si la función no está disponible, redirigir a la página de detalles
                            window.location.href = `${window.location.origin}/estudiante/solicitudes/${solicitudId}`;
                        }
                    });
                });
            }
            
            // Función para mostrar mensajes
            function mostrarMensaje(mensaje, tipo) {
                // Crear elemento de mensaje
                const mensajeElement = document.createElement('div');
                mensajeElement.className = `fixed bottom-5 right-5 px-6 py-3 rounded shadow-lg z-50 ${tipo === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'}`;
                mensajeElement.innerHTML = mensaje;
                
                // Agregar elemento al DOM
                document.body.appendChild(mensajeElement);
                
                // Eliminar mensaje después de 3 segundos
                setTimeout(() => {
                    mensajeElement.remove();
                }, 3000);
            }
            
            // Inicializar filtros de estado
            estadoLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const estado = this.dataset.estado || 'todos';
                    cargarSolicitudes(estado);
                });
            });

            // Verificar si debemos cargar las solicitudes al iniciar (basado en la URL)
            const urlParams = new URLSearchParams(window.location.search);
            const solicitudId = urlParams.get('solicitud_id');
            
            if (window.location.search.includes('tab=solicitudes')) {
                solicitudesBtn.click();
                
                if (solicitudId) {
                    // Cargar detalle de solicitud después de cargar el listado
                    setTimeout(() => {
                        cargarDetalleSolicitud(solicitudId);
                    }, 500);
                }
            }

            // Exponer la función de cargar detalle para que esté disponible globalmente
            window.cargarDetalleSolicitud = function(id) {
                // Mostrar contenedor de detalles
                const detalleContainer = document.getElementById('solicitud-detalle-container');
                if (detalleContainer) detalleContainer.classList.remove('hidden');
                
                // Ocultar contenedor de listado
                const solicitudesContainer = document.getElementById('solicitudes-container');
                if (solicitudesContainer) solicitudesContainer.classList.add('hidden');
                
                // Cambiar la URL para permitir compartir el enlace
                window.history.pushState({}, 'Detalle de Solicitud', `${window.location.pathname}?tab=solicitudes&solicitud_id=${id}`);
                
                // Si el script de detalles de solicitud está cargado, usará esta URL para cargar los datos
            };
        });
    </script>
    <script src="{{ asset('js/distance-filter.js') }}"></script>
    
    {{-- CARGAR SCRIPT PARA DETALLES DE SOLICITUD --}}
    <script src="{{ asset('js/estudiante-solicitud-detalle.js') }}"></script>
@endsection
