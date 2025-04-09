@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-100">
        {{-- CONTENIDO PRINCIPAL --}}
        <div class="container mx-auto px-4 py-8">
            <div class="flex flex-col md:flex-row gap-6">
                {{-- SIDEBAR DE FILTROS --}}
                <div class="w-full md:w-1/4">
                    <div class="bg-white rounded-lg shadow p-6">
                        <h2 class="text-lg font-semibold text-gray-800 mb-4">Filtros</h2>
                        <div class="space-y-4">
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
                            <div class="bg-white rounded-lg shadow overflow-hidden">
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

    <script src="{{ asset('js/dashboard.js') }}"></script>
@endsection
