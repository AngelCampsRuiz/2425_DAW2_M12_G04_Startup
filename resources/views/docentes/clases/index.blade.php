@extends('layouts.docente')

@section('title', 'Mis Clases')

@section('content')
<div class="space-y-6">
    <!-- Encabezado con buscador -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
        <div>
            <h2 class="text-xl font-bold text-gray-800 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
                Mis Clases
            </h2>
            <p class="mt-1 text-sm text-gray-600">Gestiona las clases que tienes asignadas</p>
        </div>
        
        <!-- Buscador -->
        <form action="{{ route('docente.clases.index') }}" method="GET" class="flex">
            <div class="relative">
                <input type="text" name="search" placeholder="Buscar clase..." value="{{ request('search') }}"
                       class="pl-10 pr-4 py-2 rounded-lg border border-gray-300 focus:ring-purple-500 focus:border-purple-500 block w-full">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
            </div>
            <button type="submit" class="ml-2 bg-purple-600 text-white py-2 px-4 rounded-lg hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-opacity-50 transition-colors">
                Buscar
            </button>
        </form>
    </div>
    
    <!-- Grid de clases -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($clases as $clase)
            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                <div class="h-3 bg-gradient-to-r from-purple-500 to-indigo-600"></div>
                <div class="p-6">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h3 class="text-lg font-bold text-gray-800">{{ $clase->nombre }}</h3>
                            <p class="text-sm text-gray-500">{{ $clase->codigo }}</p>
                        </div>
                        <span class="bg-purple-100 text-purple-800 text-xs font-medium px-2.5 py-1 rounded-full">
                            {{ $clase->estudiantes_count ?? count($clase->estudiantes) ?? 0 }} alumnos
                        </span>
                    </div>
                    
                    <div class="space-y-3">
                        <div class="flex items-center text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            <span>{{ $clase->departamento->nombre ?? 'Sin departamento' }}</span>
                        </div>
                        
                        <div class="flex items-center text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span>{{ $clase->created_at->format('d/m/Y') }}</span>
                        </div>
                    </div>
                    
                    <div class="mt-5 flex justify-end space-x-2">
                        <a href="{{ route('docente.clases.alumnos', $clase->id) }}" class="inline-flex items-center px-3 py-1.5 text-xs font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                            Alumnos
                        </a>
                        <a href="{{ route('docente.clases.show', $clase->id) }}" class="inline-flex items-center px-3 py-1.5 text-xs font-medium rounded-md text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            Detalles
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-3 bg-white rounded-xl shadow-md p-8 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
                <h3 class="text-lg font-medium text-gray-900">No tienes clases asignadas</h3>
                <p class="mt-1 text-sm text-gray-500">
                    Actualmente no tienes ninguna clase asignada. Por favor, contacta con la institución si crees que esto es un error.
                </p>
            </div>
        @endforelse
    </div>
    
    <!-- Paginación -->
    <div class="mt-6">
        {{ $clases->links() }}
    </div>
</div>
@endsection 