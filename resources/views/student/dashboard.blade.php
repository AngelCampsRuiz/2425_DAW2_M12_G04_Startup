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
                        <form action="{{ route('student.dashboard') }}" method="GET">
                            {{-- CATEGORÍAS --}}
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Categoría</label>
                                <select name="categoria_id" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary">
                                    <option value="">Todas</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ request('categoria_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- HORARIO --}}
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Horario</label>
                                @foreach($filters['horarios'] as $horario)
                                    <div class="flex items-center mb-2">
                                        <input type="radio" name="horario" value="{{ $horario }}"
                                            {{ request('horario') == $horario ? 'checked' : '' }}
                                            class="h-4 w-4 text-primary focus:ring-primary border-gray-300">
                                        <label class="ml-2 text-sm text-gray-700">{{ ucfirst($horario) }}</label>
                                    </div>
                                @endforeach
                            </div>

                            {{-- HORAS TOTALES --}}
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Horas mínimas</label>
                                <select name="horas_totales" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary">
                                    <option value="">Todas</option>
                                    @foreach($filters['horas_totales'] as $hours)
                                        <option value="{{ $hours }}" {{ request('horas_totales') == $hours ? 'selected' : '' }}>
                                            {{ $hours }}+ horas
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <button type="submit" class="w-full bg-primary text-white py-2 px-4 rounded-lg hover:bg-primary-dark transition">
                                Aplicar filtros
                            </button>
                        </form>
                    </div>
                </div>

                {{-- CONTENIDO PRINCIPAL --}}
                <div class="w-full md:w-3/4">
                    {{-- BARRA DE BÚSQUEDA Y ORDENAMIENTO --}}
                    <div class="flex flex-col md:flex-row gap-4 mb-6">
                        <div class="flex-1">
                            <form action="{{ route('student.dashboard') }}" method="GET" class="flex gap-4">
                                <input type="text" name="search" value="{{ request('search') }}" 
                                    placeholder="Buscar publicaciones..."
                                    class="flex-1 border-gray-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary">
                                <button type="submit" class="bg-primary text-white px-6 py-2 rounded-lg hover:bg-primary-dark transition">
                                    Buscar
                                </button>
                            </form>
                        </div>
                        <div class="w-full md:w-48">
                            <select onchange="window.location.href=this.value" 
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary">
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
@endsection
