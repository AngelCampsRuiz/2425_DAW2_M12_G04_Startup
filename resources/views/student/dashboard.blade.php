@extends('layouts.app')

@section('content')
    <head>
        <!-- Incluye FontAwesome desde un CDN -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
        <!-- Incluye noUiSlider desde un CDN -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.7.0/nouislider.min.css" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.7.0/nouislider.min.js"></script>
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>
    <div class="min-h-screen bg-gray-100">
        {{-- CONTENIDO PRINCIPAL --}}
        <div class="container mx-auto px-4 py-8">
            <div class="flex flex-col md:flex-row gap-6">
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
                                            <div id="subcategorias-{{ $categoria->id }}" class="pl-6 mt-2 hidden">
                                                @foreach($categoria->subcategorias as $subcategoria)
                                                    <label class="flex items-center">
                                                        <input type="checkbox" name="subcategoria[]" value="{{ $subcategoria->id }}" class="form-checkbox h-4 w-4 text-[#5e0490] rounded focus:ring-[#5e0490] border-gray-300">
                                                        <span class="ml-2 text-sm text-gray-700">{{ $subcategoria->nombre_subcategoria }}</span>
                                                    </label>
                                                @endforeach
                                            </div>
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
                                <div class="relative">
                                    <div class="flex justify-between text-sm text-gray-600 mb-2">
                                        <span id="horasTotalesMinValue">{{ $horasTotalesMin }}</span>
                                        <span id="horasTotalesMaxValue">{{ $horasTotalesMax }}</span>
                                    </div>
                                    <div class="relative w-full h-2 bg-gray-200 rounded-full">
                                        <input type="range" id="horasTotalesMin" name="horas_totales_min" min="{{ $horasTotalesMin }}" max="{{ $horasTotalesMax }}" value="{{ $horasTotalesMin }}" class="absolute w-full h-2 bg-transparent appearance-none pointer-events-none">
                                        <input type="range" id="horasTotalesMax" name="horas_totales_max" min="{{ $horasTotalesMin }}" max="{{ $horasTotalesMax }}" value="{{ $horasTotalesMax }}" class="absolute w-full h-2 bg-transparent appearance-none pointer-events-none">
                                        <div class="absolute h-2 bg-[#5e0490] rounded-full" id="horasTotalesRange"></div>
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
                            <form id="searchForm" class="flex gap-4 items-center" data-route="{{ route('student.dashboard') }}">
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
                                <option value="{{ route('student.dashboard', ['order_by' => 'fecha_publicacion', 'order_direction' => 'desc']) }}"
                                    {{ request('order_by') == 'fecha_publicacion' && request('order_direction') == 'desc' ? 'selected' : '' }}>
                                    Más recientes
                                </option>
                                <option value="{{ route('student.dashboard', ['order_by' => 'fecha_publicacion', 'order_direction' => 'asc']) }}"
                                    {{ request('order_by') == 'fecha_publicacion' && request('order_direction') == 'asc' ? 'selected' : '' }}>
                                    Más antiguos
                                </option>
                                <option value="{{ route('student.dashboard', ['order_by' => 'horas_totales', 'order_direction' => 'desc']) }}"
                                    {{ request('order_by') == 'horas_totales' && request('order_direction') == 'desc' ? 'selected' : '' }}>
                                    Mayor duración
                                </option>
                                <option value="{{ route('student.dashboard', ['order_by' => 'horas_totales', 'order_direction' => 'asc']) }}"
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
                            <div class="bg-white rounded-lg shadow overflow-hidden relative">
                                <div class="flex">
                                    {{-- IMAGEN DE LA EMPRESA --}}
                                    <div class="w-1/3">
                                        <img src="{{ $publication->empresa->logo_url ?? asset('assets/images/company-default.png') }}" 
                                            alt="{{ $publication->empresa->nombre }}"
                                            class="w-full h-full object-cover">
                                    </div>
                                    {{-- INFORMACIÓN DE LA PUBLICACIÓN --}}
                                    <div class="w-2/3 p-4">
                                        <h3 class="text-lg font-semibold text-gray-800 mb-2">{{ $publication->titulo }}</h3>
                                        <p class="text-primary font-medium mb-2">{{ $publication->empresa->nombre }}</p>
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
                                {{-- Botón de Favorito --}}
                                <button class="favorite-button absolute top-2 right-2 p-2 bg-white rounded-full shadow-md hover:bg-gray-100 transition duration-200" data-publication-id="{{ $publication->id }}">
                                    <i class="far fa-star {{ $publication->isFavoritedBy(auth()->user()) ? 'fas text-yellow-500' : '' }}"></i>
                                </button>
                            </div>
                        @endforeach
                    </div>

                    {{-- PAGINACIÓN --}}
                    <div class="mt-6">
                        {{ $publications->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Contenedor del slider */
        .relative.w-full.h-2.bg-gray-200.rounded-full {
            position: relative;
            height: 8px; /* Aumentamos la altura de la línea */
            background-color: #e2e8f0; /* Color de fondo de la línea */
            border-radius: 4px; /* Bordes redondeados */
        }

        /* Línea de rango seleccionado */
        #horasTotalesRange {
            position: absolute;
            top: 0;
            height: 8px; /* Misma altura que la línea base */
            background-color: #5e0490; /* Color de la línea seleccionada */
            border-radius: 4px; /* Bordes redondeados */
            z-index: 1;
        }

        /* Controles deslizantes (thumbs) */
        input[type="range"] {
            -webkit-appearance: none;
            appearance: none;
            width: 100%;
            height: 8px; /* Misma altura que la línea base */
            background: transparent;
            position: absolute;
            top: 0;
            left: 0;
            pointer-events: none;
        }

        input[type="range"]::-webkit-slider-thumb {
            -webkit-appearance: none;
            appearance: none;
            width: 20px; /* Tamaño del control deslizante */
            height: 20px;
            background: #5e0490; /* Color del control deslizante */
            border: 2px solid #fff; /* Borde blanco para resaltar */
            border-radius: 50%; /* Forma circular */
            cursor: pointer;
            pointer-events: all;
            position: relative;
            z-index: 2;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2); /* Sombra para dar profundidad */
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        input[type="range"]::-webkit-slider-thumb:active {
            transform: scale(1.2); /* Aumenta el tamaño al hacer clic */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3); /* Sombra más pronunciada */
        }

        input[type="range"]::-moz-range-thumb {
            width: 20px; /* Tamaño del control deslizante */
            height: 20px;
            background: #5e0490; /* Color del control deslizante */
            border: 2px solid #fff; /* Borde blanco para resaltar */
            border-radius: 50%; /* Forma circular */
            cursor: pointer;
            pointer-events: all;
            position: relative;
            z-index: 2;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2); /* Sombra para dar profundidad */
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        input[type="range"]::-moz-range-thumb:active {
            transform: scale(1.2); /* Aumenta el tamaño al hacer clic */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3); /* Sombra más pronunciada */
        }

        /* Texto de los valores mínimo y máximo */
        .flex.justify-between.text-sm.text-gray-600 {
            margin-top: 8px; /* Espacio entre el slider y los valores */
        }
    </style>

    <script src="{{ asset('js/dashboard.js') }}"></script>
@endsection
