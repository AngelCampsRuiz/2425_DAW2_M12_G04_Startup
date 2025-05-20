@extends('layouts.institucion')

@section('title', 'Gestión de Clases')

@section('content')
<div class="bg-gray-50 p-6 rounded-xl shadow-sm">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Clases</h1>
            <div class="flex items-center text-sm text-gray-500 mt-1">
                <a href="{{ route('institucion.dashboard') }}" class="hover:text-primary">Dashboard</a>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mx-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
                <span>Clases</span>
            </div>
        </div>
        <a href="{{ route('institucion.clases.create') }}" class="bg-primary hover:bg-primary-dark text-white py-2 px-4 rounded-lg flex items-center transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            Nueva Clase
        </a>
    </div>

    {{-- Mostrar alertas --}}
    {{-- Comentado para evitar duplicidad con los mensajes del layout
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-md" role="alert">
            <div class="flex items-center">
                <svg class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
                <p>{{ session('success') }}</p>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-md" role="alert">
                                <div class="flex items-center">
                <svg class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                <p>{{ session('error') }}</p>
                                </div>
        </div>
    @endif
    --}}

    {{-- Filtros y búsqueda --}}
    <div class="bg-white rounded-xl shadow-sm mb-6 overflow-hidden">
        <div class="bg-gray-50 px-5 py-4 border-b">
            <div class="flex items-center text-gray-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                    </svg>
                <span class="font-medium">Filtros y Búsqueda</span>
            </div>
                        </div>
        <div class="p-5">
            <form action="{{ route('institucion.clases.index') }}" method="GET" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Buscar por nombre</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <input type="text" class="block w-full border border-gray-300 rounded-lg pl-10 px-4 py-2 focus:ring-primary focus:border-primary" 
                                id="search" name="search" value="{{ request('search') }}" placeholder="Nombre de la clase">
                        </div>
                    </div>

                                <div>
                                    <label for="departamento_id" class="block text-sm font-medium text-gray-700 mb-1">Departamento</label>
                        <select class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-primary focus:border-primary" id="departamento_id" name="departamento_id">
                            <option value="">Todos los departamentos</option>
                                        @foreach($departamentos as $departamento)
                                <option value="{{ $departamento->id }}" {{ request('departamento_id') == $departamento->id ? 'selected' : '' }}>
                                                {{ $departamento->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                        <label for="docente_id" class="block text-sm font-medium text-gray-700 mb-1">Docente</label>
                        <select class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-primary focus:border-primary" id="docente_id" name="docente_id">
                            <option value="">Todos los docentes</option>
                                        @foreach($docentes as $docente)
                                <option value="{{ $docente->id }}" {{ request('docente_id') == $docente->id ? 'selected' : '' }}>
                                    {{ $docente->user->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                    </div>
                </div>

                <div class="flex items-center justify-end space-x-3">
                    <a href="{{ route('institucion.clases.index') }}" class="flex items-center justify-center bg-gray-100 hover:bg-gray-200 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg px-5 py-2.5 transition-colors duration-300 text-gray-800">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        <span>Reiniciar</span>
                    </a>
                    
                    <button type="submit" class="bg-primary hover:bg-primary-dark focus:ring-4 focus:ring-primary/30 text-white font-medium rounded-lg px-5 py-2.5 transition-colors duration-300">
                        <div class="flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            <span>Aplicar filtros</span>
                        </div>
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Lista de clases en cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($clases as $clase)
            <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow p-6 border-t-4 {{ $clase->activa ? 'border-green-500' : 'border-gray-300' }}">
                <div class="flex justify-between items-start mb-4">
                    <h2 class="text-lg font-bold text-gray-800">{{ $clase->nombre }}</h2>
                    <span class="px-2 py-1 rounded-full text-xs {{ $clase->activa ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                        {{ $clase->activa ? 'Activa' : 'Inactiva' }}
                    </span>
                </div>
                
                <div class="space-y-3 mb-5">
                    <div class="flex items-start">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    <div>
                            <p class="text-xs text-gray-500">Departamento</p>
                            <p class="text-sm font-medium text-gray-700">{{ $clase->departamento->nombre ?? 'Sin departamento' }}</p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    <div>
                            <p class="text-xs text-gray-500">Docente</p>
                            <p class="text-sm font-medium text-gray-700">
                                @if($clase->docente)
                                    {{ $clase->docente->user->nombre }}
                                @else
                                    <span class="text-red-500">Sin asignar</span>
                                @endif
                            </p>
                        </div>
                                </div>

                    <div class="flex items-start">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                                    <div>
                            <p class="text-xs text-gray-500">Estudiantes</p>
                            <p class="text-sm font-medium {{ $clase->estudiantes_count > 0 ? 'text-gray-700' : 'text-red-500' }}">
                                {{ $clase->estudiantes_count }} estudiantes
                            </p>
                        </div>
                    </div>
                </div>

                <div class="border-t pt-4 flex justify-between">
                    <a href="{{ route('institucion.clases.show', $clase->id) }}" class="text-sm font-medium text-primary hover:text-primary-dark">
                        Ver detalles
                    </a>
                    <div class="flex space-x-3">
                        <button onclick="openEditModal({{ $clase->id }})" class="text-sm font-medium text-yellow-600 hover:text-yellow-800">
                            Editar
                        </button>
                        <a href="{{ route('institucion.clases.asignar-estudiantes', $clase->id) }}" class="text-sm font-medium text-green-600 hover:text-green-800">
                            Asignar estudiantes
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full">
                <div class="text-center py-10 px-4 bg-white rounded-xl shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-300 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-1">No hay clases</h3>
                    <p class="text-gray-500 max-w-md mx-auto mb-6">No se encontraron clases con los criterios de búsqueda actuales o aún no has creado ninguna clase.</p>
                    <a href="{{ route('institucion.clases.create') }}" class="bg-primary hover:bg-primary-dark text-white py-2 px-6 rounded-lg inline-flex items-center transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                        Crear primera clase
                    </a>
                </div>
            </div>
        @endforelse
        </div>

    {{-- Paginación --}}
    <div class="mt-6">
        {{ $clases->appends(request()->query())->links() }}
    </div>
</div>
@endsection

@include('components.edit-clase-modal') 