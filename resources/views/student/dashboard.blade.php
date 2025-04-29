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
    <div class="min-h-screen bg-gray-50">
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
            <div class="flex flex-col md:flex-row gap-6">
                {{-- SIDEBAR DE FILTROS --}}
                <div class="w-full md:w-1/4">
                    <div class="bg-white rounded-xl shadow-md p-6 sticky top-4">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-lg font-semibold text-gray-800">Filtros</h2>
                            <button id="toggleFilters" class="md:hidden text-purple-600 hover:text-purple-800">
                                <i class="fas fa-chevron-down"></i>
                            </button>
                        </div>
                        
                        <div id="filterContent" class="space-y-6">
                            <!-- Filtro de Categoría y Subcategoría -->
                            <div class="border-b border-gray-100 pb-4">
                                <h3 class="text-sm font-medium text-gray-600 mb-3 flex items-center">
                                    <i class="fas fa-tag mr-2 text-purple-500"></i>
                                    Categoría
                                </h3>
                                <div class="space-y-2 max-h-48 overflow-y-auto pr-2 custom-scrollbar">
                                    @foreach($categorias as $categoria)
                                        <div class="transition-all duration-200 hover:bg-purple-50 rounded-lg p-1 -mx-1">
                                            <label class="flex items-center cursor-pointer">
                                                <input type="checkbox" name="categoria[]" value="{{ $categoria->id }}" class="categoria-checkbox form-checkbox h-4 w-4 text-[#5e0490] rounded focus:ring-[#5e0490] border-gray-300">
                                                <span class="ml-2 text-sm text-gray-700">{{ $categoria->nombre_categoria }}</span>
                                            </label>
                                            @if($categoria->subcategorias->count() > 0)
                                            <div id="subcategorias-{{ $categoria->id }}" class="pl-6 mt-2 hidden">
                                                @foreach($categoria->subcategorias as $subcategoria)
                                                    <label class="flex items-center my-1 cursor-pointer">
                                                        <input type="checkbox" name="subcategoria[]" value="{{ $subcategoria->id }}" class="form-checkbox h-4 w-4 text-[#5e0490] rounded focus:ring-[#5e0490] border-gray-300">
                                                        <span class="ml-2 text-sm text-gray-600">{{ $subcategoria->nombre_subcategoria }}</span>
                                                    </label>
                                                @endforeach
                                            </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Filtro de Fecha de Publicación -->
                            <div class="border-b border-gray-100 pb-4">
                                <h3 class="text-sm font-medium text-gray-600 mb-3 flex items-center">
                                    <i class="far fa-calendar-alt mr-2 text-purple-500"></i>
                                    Fecha de Publicación
                                </h3>
                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <label class="text-xs text-gray-500 mb-1 block">Desde</label>
                                        <input type="date" name="fecha_inicio" id="fechaInicio" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-[#5e0490] focus:border-[#5e0490] text-sm">
                                    </div>
                                    <div>
                                        <label class="text-xs text-gray-500 mb-1 block">Hasta</label>
                                        <input type="date" name="fecha_fin" id="fechaFin" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-[#5e0490] focus:border-[#5e0490] text-sm">
                                    </div>
                                </div>
                            </div>

                            <!-- Filtro de Horario -->
                            <div class="border-b border-gray-100 pb-4">
                                <h3 class="text-sm font-medium text-gray-600 mb-3 flex items-center">
                                    <i class="far fa-clock mr-2 text-purple-500"></i>
                                    Horario
                                </h3>
                                <div class="grid grid-cols-2 gap-2">
                                    @foreach($horarios as $horario)
                                        <label class="flex items-center p-2 bg-gray-50 hover:bg-purple-50 rounded-lg transition-colors duration-200 cursor-pointer">
                                            <input type="checkbox" name="horario[]" value="{{ $horario }}" class="form-checkbox h-4 w-4 text-[#5e0490] rounded focus:ring-[#5e0490] border-gray-300">
                                            <span class="ml-2 text-sm text-gray-700">{{ ucfirst($horario) }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Filtro de Horas Totales -->
                            <div>
                                <h3 class="text-sm font-medium text-gray-600 mb-3 flex items-center">
                                    <i class="fas fa-hourglass-half mr-2 text-purple-500"></i>
                                    Horas Totales
                                </h3>
                                <div class="mb-4">
                                    <div class="flex justify-between text-sm text-gray-600 mb-2">
                                        <span id="horasTotalesMinValue" class="font-medium">{{ $horasTotalesMin }}</span>
                                        <span id="horasTotalesMaxValue" class="font-medium">{{ $horasTotalesMax }}</span>
                                    </div>
                                    <!-- Contenedor para noUiSlider -->
                                    <div id="horasTotalesSlider" class="mt-4"></div>
                                    <!-- Campos ocultos para enviar los valores en el formulario -->
                                    <input type="hidden" id="horasTotalesMin" name="horas_totales_min" value="{{ $horasTotalesMin }}">
                                    <input type="hidden" id="horasTotalesMax" name="horas_totales_max" value="{{ $horasTotalesMax }}">
                                </div>
                            </div>
                            
                            <!-- Botón para limpiar todos los filtros -->
                            <div class="pt-2">
                                <button type="button" id="clearFiltersButton" 
                                    class="w-full flex items-center justify-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition duration-200">
                                    <i class="fas fa-undo-alt mr-2"></i>
                                    Restablecer filtros
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- CONTENIDO PRINCIPAL --}}
                <div class="w-full md:w-3/4">
                    {{-- BARRA DE BÚSQUEDA Y ORDENAMIENTO --}}
                    <div class="bg-white rounded-xl shadow-md p-4 mb-6">
                        <form id="searchForm" class="flex flex-col md:flex-row gap-4 items-center" 
                            data-route="{{ isset($is_demo) && $is_demo ? route('demo.student') : route('student.dashboard') }}">
                            
                            <div class="relative flex-1">
                                <input type="text" name="search" id="searchInput" value="{{ request('search') }}" 
                                placeholder="Buscar por título, descripción, empresa..."
                                    class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-[#5e0490] focus:border-[#5e0490] focus:outline-none transition duration-200">
                                <svg class="absolute left-3 top-3.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                                <div id="searchSpinner" class="absolute right-4 top-3.5 hidden">
                                    <svg class="animate-spin h-5 w-5 text-purple-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                </div>
                            </div>
                            
                            <div class="flex gap-3">
                                <div class="relative w-48">
                                    <select id="orderSelect" class="w-full pl-10 pr-10 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-[#5e0490] focus:border-[#5e0490] focus:outline-none appearance-none transition duration-200">
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
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <i class="fas fa-sort text-gray-400"></i>
                                    </div>
                                    <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </div>
                                </div>
                                
                                <button type="button" id="clearButton" class="flex items-center justify-center px-4 py-3 bg-[#5e0490] text-white rounded-xl hover:bg-[#4a0370] transition duration-200">
                                    <i class="fas fa-eraser mr-2"></i>
                                    Limpiar
                                </button>
                            </div>
                            
                            <input type="hidden" name="order_by" id="orderBy" value="{{ request('order_by', 'fecha_publicacion') }}">
                            <input type="hidden" name="order_direction" id="orderDirection" value="{{ request('order_direction', 'desc') }}">
                        </form>
                    </div>

                    {{-- CONTADOR DE RESULTADOS --}}
                    <div class="flex justify-between items-center mb-4">
                        <p class="text-gray-600"><span class="font-semibold text-purple-800">{{ $publications->total() }}</span> resultados encontrados</p>
                        <div class="flex gap-2">
                            <button id="gridViewButton" class="p-2 bg-purple-600 text-white rounded-l-lg">
                                <i class="fas fa-th-large"></i>
                            </button>
                            <button id="listViewButton" class="p-2 bg-gray-200 text-gray-600 rounded-r-lg">
                                <i class="fas fa-list"></i>
                            </button>
                        </div>
                    </div>

                    {{-- GRID DE PUBLICACIONES --}}
                    <div id="publicationsGrid" class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        @foreach($publications as $publication)
                            <div class="bg-white rounded-xl shadow-md overflow-hidden relative hover:shadow-lg">
                                <div class="flex">
                                    {{-- IMAGEN DE LA EMPRESA --}}
                                    <div class="w-1/3 bg-gray-50 flex items-center justify-center border-r border-gray-100" style="min-height: 160px;">
                                        <a href="{{ route('profile.show', $publication->empresa->user->id) }}" class="p-3 flex justify-center items-center h-full w-full">
                                            <img src="{{ asset('public/profile_images/' . ($publication->empresa->user->imagen ?? 'company-default.png')) }}" 
                                                alt="{{ $publication->empresa->user->nombre }}"
                                                class="max-w-[90%] max-h-[90px] object-contain hover:scale-105 m-auto">
                                        </a>
                                        <div class="absolute bottom-0 left-0 w-1/3 bg-gray-50 text-center py-1.5 px-2 border-t border-gray-100">
                                            <a href="{{ route('profile.show', $publication->empresa->user->id) }}" class="group">
                                                <p class="text-xs font-medium text-gray-700 hover:text-[#5e0490] truncate">
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
                                                
                                                <div class="flex flex-wrap gap-2 mt-1">
                                                    @if($publication->categoria)
                                                        <span class="inline-block bg-purple-100 text-purple-800 text-xs px-2 py-1 rounded-full">
                                                            {{ $publication->categoria->nombre_categoria }}
                                                        </span>
                                                    @endif
                                                    @if($publication->subcategoria)
                                                        <span class="inline-block bg-indigo-100 text-indigo-800 text-xs px-2 py-1 rounded-full">
                                                            {{ $publication->subcategoria->nombre_subcategoria }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            
                                            @if(!isset($is_demo) || !$is_demo)
                                            <!-- Botón de favoritos eliminado -->
                                            @endif
                                        </div>
                                        
                                        <div class="flex items-center mt-3 text-sm text-gray-600">
                                            <div class="flex items-center mr-4">
                                                <i class="far fa-clock mr-1 text-purple-500"></i>
                                                {{ ucfirst($publication->horario) }}
                                            </div>
                                            <div class="flex items-center">
                                                <i class="fas fa-hourglass-half mr-1 text-purple-500"></i>
                                                {{ $publication->horas_totales }} horas
                                            </div>
                                        </div>
                                        
                                        <div class="flex items-center mt-2 text-sm text-gray-600">
                                            <i class="far fa-calendar-alt mr-1 text-purple-500"></i>
                                            Publicado: {{ \Carbon\Carbon::parse($publication->fecha_publicacion)->format('d/m/Y') }}
                                        </div>
                                        
                                        <p class="text-sm text-gray-600 mt-3 line-clamp-2">{{ $publication->descripcion }}</p>
                                        
                                        @if(!isset($is_demo) || !$is_demo)
                                        <div class="mt-3">
                                            <a href="{{ route('publication.show', $publication->id) }}" 
                                               class="inline-flex items-center text-sm text-purple-600 hover:text-purple-800 transition-colors duration-200">
                                                Ver detalles
                                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                                </svg>
                                            </a>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- VISTA LISTA (OCULTA POR DEFECTO) --}}
                    <div id="publicationsList" class="hidden space-y-4">
                        @foreach($publications as $publication)
                            <div class="bg-white rounded-xl shadow-md overflow-hidden relative hover:shadow-lg">
                                <div class="flex flex-col md:flex-row">
                                    {{-- IMAGEN DE LA EMPRESA --}}
                                    <div class="w-full md:w-1/6 bg-gray-50 flex items-center justify-center p-4 md:border-r border-gray-100" style="min-height: 120px;">
                                        <a href="{{ route('profile.show', $publication->empresa->user->id) }}" class="block w-full h-full flex items-center justify-center">
                                            <img src="{{ asset('public/profile_images/' . ($publication->empresa->user->imagen ?? 'company-default.png')) }}" 
                                                alt="{{ $publication->empresa->user->nombre }}"
                                                class="max-h-[80px] object-contain hover:scale-105 m-auto">
                                        </a>
                                    </div>
                                    
                                    {{-- INFORMACIÓN DE LA PUBLICACIÓN --}}
                                    <div class="w-full md:w-5/6 p-4">
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
                                                
                                                <p class="text-sm text-purple-600">{{ $publication->empresa->user->nombre }}</p>
                                            </div>
                                            
                                            @if(!isset($is_demo) || !$is_demo)
                                            <!-- Botón de favoritos eliminado -->
                                            @endif
                                        </div>
                                        
                                        <div class="flex flex-wrap gap-2 my-2">
                                            @if($publication->categoria)
                                                <span class="inline-block bg-purple-100 text-purple-800 text-xs px-2 py-1 rounded-full">
                                                    {{ $publication->categoria->nombre_categoria }}
                                                </span>
                                            @endif
                                            @if($publication->subcategoria)
                                                <span class="inline-block bg-indigo-100 text-indigo-800 text-xs px-2 py-1 rounded-full">
                                                    {{ $publication->subcategoria->nombre_subcategoria }}
                                                </span>
                                            @endif
                                        </div>
                                        
                                        <p class="text-sm text-gray-600 my-2">{{ $publication->descripcion }}</p>
                                        
                                        <div class="flex flex-wrap items-center gap-4 mt-3 text-sm text-gray-600">
                                            <div class="flex items-center">
                                                <i class="far fa-clock mr-1 text-purple-500"></i>
                                                {{ ucfirst($publication->horario) }}
                                            </div>
                                            <div class="flex items-center">
                                                <i class="fas fa-hourglass-half mr-1 text-purple-500"></i>
                                                {{ $publication->horas_totales }} horas
                                            </div>
                                            <div class="flex items-center">
                                                <i class="far fa-calendar-alt mr-1 text-purple-500"></i>
                                                Publicado: {{ \Carbon\Carbon::parse($publication->fecha_publicacion)->format('d/m/Y') }}
                                            </div>
                                            
                                            @if(!isset($is_demo) || !$is_demo)
                                            <div class="ml-auto">
                                                <a href="{{ route('publication.show', $publication->id) }}" 
                                                   class="inline-flex items-center text-sm text-white bg-purple-600 hover:bg-purple-700 px-3 py-1 rounded-lg transition-colors duration-200">
                                                    Ver detalles
                                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                                    </svg>
                                                </a>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
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
        </div>
    </div>

    <style>
        /* Estilos mejorados para la UI */
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }
        
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #d1d5db;
            border-radius: 10px;
        }
        
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #5e0490;
        }
        
        /* Estilos para noUiSlider */
        .noUi-connect {
            background: #5e0490 !important;
        }
        
        /* Estilos para las imágenes de empresas (eliminamos los anteriores) */
        
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
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle para los filtros en móvil
            const toggleFilters = document.getElementById('toggleFilters');
            const filterContent = document.getElementById('filterContent');
            
            if (toggleFilters && filterContent) {
                toggleFilters.addEventListener('click', function() {
                    filterContent.classList.toggle('hidden');
                    const icon = toggleFilters.querySelector('i');
                    if (icon.classList.contains('fa-chevron-down')) {
                        icon.classList.replace('fa-chevron-down', 'fa-chevron-up');
                    } else {
                        icon.classList.replace('fa-chevron-up', 'fa-chevron-down');
                    }
                });
            }
            
            // Cambio entre vista grid y lista
            const gridViewButton = document.getElementById('gridViewButton');
            const listViewButton = document.getElementById('listViewButton');
            const publicationsGrid = document.getElementById('publicationsGrid');
            const publicationsList = document.getElementById('publicationsList');
            
            if (gridViewButton && listViewButton) {
                gridViewButton.addEventListener('click', function() {
                    publicationsGrid.classList.remove('hidden');
                    publicationsList.classList.add('hidden');
                    gridViewButton.classList.replace('bg-gray-200', 'bg-purple-600');
                    gridViewButton.classList.replace('text-gray-600', 'text-white');
                    listViewButton.classList.replace('bg-purple-600', 'bg-gray-200');
                    listViewButton.classList.replace('text-white', 'text-gray-600');
                    localStorage.setItem('preferredView', 'grid');
                });
                
                listViewButton.addEventListener('click', function() {
                    publicationsGrid.classList.add('hidden');
                    publicationsList.classList.remove('hidden');
                    listViewButton.classList.replace('bg-gray-200', 'bg-purple-600');
                    listViewButton.classList.replace('text-gray-600', 'text-white');
                    gridViewButton.classList.replace('bg-purple-600', 'bg-gray-200');
                    gridViewButton.classList.replace('text-white', 'text-gray-600');
                    localStorage.setItem('preferredView', 'list');
                });
                
                // Restaurar vista preferida del usuario
                const preferredView = localStorage.getItem('preferredView');
                if (preferredView === 'list') {
                    listViewButton.click();
                }
            }
            
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
            const clearFiltersButton = document.getElementById('clearFiltersButton');
            const horarioCheckboxes = document.querySelectorAll('input[name="horario[]"]');
            const categoriaCheckboxes = document.querySelectorAll('.categoria-checkbox');
            const subcategoriaCheckboxes = document.querySelectorAll('input[name="subcategoria[]"]');
            const fechaInicio = document.getElementById('fechaInicio');
            const fechaFin = document.getElementById('fechaFin');
            const route = searchForm ? searchForm.getAttribute('data-route') : '';
            const searchSpinner = document.getElementById('searchSpinner');
            const favoritosCheckbox = document.getElementById('favoritosCheckbox');
            const paginationContainer = document.querySelector('.pagination-container');

            // Mostrar/ocultar subcategorías al seleccionar una categoría
            categoriaCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const subcategoriasDiv = document.getElementById(`subcategorias-${this.value}`);
                    if (subcategoriasDiv) {
                        if (this.checked) {
                            subcategoriasDiv.classList.remove('hidden');
                        } else {
                            subcategoriasDiv.classList.add('hidden');
                            // Desmarcar todas las subcategorías
                            const subcheckboxes = subcategoriasDiv.querySelectorAll('input[type="checkbox"]');
                            subcheckboxes.forEach(subcheck => {
                                subcheck.checked = false;
                            });
                        }
                    }
                    fetchPublications();
                });
            });

            // Manejar la paginación con AJAX
            if (paginationContainer) {
                paginationContainer.addEventListener('click', function(e) {
                    // Prevenir solo si es un enlace de paginación
                    const target = e.target.closest('a[href]');
                    if (target) {
                        e.preventDefault();
                        const pageUrl = target.getAttribute('href');
                        
                        // Mostrar spinner
                        if (searchSpinner) searchSpinner.classList.remove('hidden');
                        
                        // Hacer la petición AJAX
                        fetch(pageUrl, {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        })
                        .then(response => response.text())
                        .then(html => {
                            updatePageContent(html);
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        })
                        .finally(() => {
                            // Ocultar spinner
                            if (searchSpinner) searchSpinner.classList.add('hidden');
                            
                            // Hacer scroll hacia arriba suavemente
                            window.scrollTo({
                                top: 0,
                                behavior: 'smooth'
                            });
                        });
                    }
                });
            }

            const fetchPublications = () => {
                if (!searchForm) return;
                
                // Mostrar spinner
                if (searchSpinner) searchSpinner.classList.remove('hidden');
                
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
                    updatePageContent(html);
                })
                .catch(error => {
                    console.error('Error:', error);
                })
                .finally(() => {
                    // Ocultar spinner
                    if (searchSpinner) searchSpinner.classList.add('hidden');
                });
            };
            
            // Función para actualizar el contenido de la página
            const updatePageContent = (html) => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                
                // Actualizar ambas vistas
                const newGridContent = doc.querySelector('#publicationsGrid');
                const newListContent = doc.querySelector('#publicationsList');
                
                if (newGridContent) {
                    document.querySelector('#publicationsGrid').innerHTML = newGridContent.innerHTML;
                }
                
                if (newListContent) {
                    document.querySelector('#publicationsList').innerHTML = newListContent.innerHTML;
                } else {
                    // Si no existe el elemento en la respuesta, actualizar con la estructura grid
                    document.querySelector('#publicationsList').innerHTML = document.querySelector('#publicationsGrid').innerHTML;
                }
                
                // Actualizar contador de resultados
                const resultCountElement = document.querySelector('.text-gray-600 span.font-semibold');
                if (resultCountElement) {
                    const newResultCount = doc.querySelector('.text-gray-600 span.font-semibold');
                    if (newResultCount) {
                        resultCountElement.textContent = newResultCount.textContent;
                    }
                }
                
                // Actualizar paginación
                const paginationContainer = document.querySelector('.pagination-container');
                if (paginationContainer) {
                    const newPagination = doc.querySelector('.pagination-container');
                    if (newPagination) {
                        paginationContainer.innerHTML = newPagination.innerHTML;
                    }
                }
                
                // Reinicializar los botones de favoritos después de actualizar el contenido
                initFavoriteButtons();
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
                resetAllFilters();
                fetchPublications();
            });
            
            clearFiltersButton && clearFiltersButton.addEventListener('click', function() {
                resetAllFilters();
                fetchPublications();
            });
            
            function resetAllFilters() {
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
                
                // Resetear favoritos
                if (favoritosCheckbox) favoritosCheckbox.checked = false;
            }

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
                });
            }
            
            // Función para mostrar toast de notificaciones
            function showToast(message, type = 'info') {
                // Verificar si ya existe un toast para no duplicar
                const existingToast = document.querySelector('.toast-notification');
                if (existingToast) {
                    existingToast.remove();
                }
                
                // Crear el toast
                const toast = document.createElement('div');
                toast.className = 'toast-notification fixed bottom-4 right-4 px-6 py-3 rounded-lg shadow-lg z-50 flex items-center';
                
                // Aplicar estilos según el tipo
                switch(type) {
                    case 'success':
                        toast.classList.add('bg-green-500', 'text-white');
                        toast.innerHTML = `<i class="fas fa-check-circle mr-2"></i> ${message}`;
                        break;
                    case 'error':
                        toast.classList.add('bg-red-500', 'text-white');
                        toast.innerHTML = `<i class="fas fa-exclamation-circle mr-2"></i> ${message}`;
                        break;
                    case 'info':
                    default:
                        toast.classList.add('bg-blue-500', 'text-white');
                        toast.innerHTML = `<i class="fas fa-info-circle mr-2"></i> ${message}`;
                        break;
                }
                
                document.body.appendChild(toast);
                
                // Autocierre
                setTimeout(() => {
                    toast.remove();
                }, 3000);
            }
        });
    </script>
@endsection
