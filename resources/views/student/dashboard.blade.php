@extends('layouts.app')

@section('content')
    <head>
        <!-- Incluye FontAwesome desde un CDN -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
        <!-- Incluye noUiSlider desde un CDN -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.7.0/nouislider.min.css" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.7.0/nouislider.min.js"></script>
        <!-- Incluye los estilos personalizados -->
        <link rel="stylesheet" href="{{ asset('css/student-dashboard.css') }}" />
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

    <!-- Script del dashboard -->
    <script src="{{ asset('js/student-dashboard.js') }}"></script>
@endsection
