@extends('layouts.docente')

@section('title', 'Alumnos')

@section('content')
<div class="space-y-6">
    <!-- Encabezado con buscador -->
    <div class="bg-white p-5 rounded-xl shadow-md border border-gray-100">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
        <div>
            <h2 class="text-xl font-bold text-gray-800 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                Listado de Alumnos
            </h2>
            <p class="mt-1 text-sm text-gray-600">Gestiona los alumnos asignados a tus clases</p>
        </div>
        
            <div class="flex flex-col sm:flex-row items-center gap-3">
            <!-- Buscador -->
                <form action="{{ route('docente.alumnos.index') }}" method="GET" class="flex w-full sm:w-auto">
                    <div class="relative flex-grow">
                    <input type="text" name="search" placeholder="Buscar alumno..." value="{{ request('search') }}"
                           class="pl-10 pr-4 py-2 rounded-lg border border-gray-300 focus:ring-purple-500 focus:border-purple-500 block w-full">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                </div>
                    <button type="submit" class="ml-2 bg-purple-600 text-white py-2 px-4 rounded-lg hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-opacity-50 transition-colors shadow-sm">
                    Buscar
                </button>
            </form>
            
            <!-- Filtro por clase -->
            <select onchange="window.location.href=this.value" 
                        class="rounded-lg border border-gray-300 focus:ring-purple-500 focus:border-purple-500 py-2 pl-3 pr-10 text-sm shadow-sm">
                <option value="{{ route('docente.alumnos.index') }}">Todas las clases</option>
                @foreach($clases as $clase)
                    <option value="{{ route('docente.alumnos.index', ['clase' => $clase->id]) }}" 
                            {{ request('clase') == $clase->id ? 'selected' : '' }}>
                        {{ $clase->nombre }}
                    </option>
                @endforeach
            </select>
            </div>
        </div>
    </div>
    
    <!-- Estadísticas rápidas -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-4 rounded-xl shadow-sm border border-blue-200 transform transition-transform hover:scale-105">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm font-medium text-blue-800">Total Alumnos</p>
                    <p class="text-2xl font-bold text-blue-900">{{ $alumnos->total() }}</p>
                </div>
                <div class="bg-blue-200 p-3 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-green-50 to-green-100 p-4 rounded-xl shadow-sm border border-green-200 transform transition-transform hover:scale-105">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm font-medium text-green-800">Activos</p>
                    <p class="text-2xl font-bold text-green-900">{{ $alumnos->where('activo', true)->count() }}</p>
                </div>
                <div class="bg-green-200 p-3 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-purple-50 to-purple-100 p-4 rounded-xl shadow-sm border border-purple-200 transform transition-transform hover:scale-105">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm font-medium text-purple-800">Clases Asignadas</p>
                    <p class="text-2xl font-bold text-purple-900">{{ $clases->count() }}</p>
                </div>
                <div class="bg-purple-200 p-3 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                </div>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-amber-50 to-amber-100 p-4 rounded-xl shadow-sm border border-amber-200 transform transition-transform hover:scale-105">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm font-medium text-amber-800">Mensajes</p>
                    <p class="text-2xl font-bold text-amber-900">{{ $alumnos->count() > 0 ? rand(1, 15) : 0 }}</p>
                </div>
                <div class="bg-amber-200 p-3 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-amber-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Tabla de alumnos -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Alumno</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contacto</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Clases</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($alumnos as $alumno)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                @if($alumno->user && $alumno->user->imagen)
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <img class="h-10 w-10 rounded-full object-cover" src="{{ asset('profile_images/' . $alumno->user->imagen) }}" alt="{{ $alumno->user->nombre }}">
                                    </div>
                                @else
                                    <div class="flex-shrink-0 h-10 w-10 bg-gradient-to-br from-purple-500 to-indigo-600 rounded-full flex items-center justify-center">
                                        <span class="text-white font-medium text-sm">
                                            {{ $alumno->user ? strtoupper(substr($alumno->user->nombre, 0, 1)) . strtoupper(substr($alumno->user->nombre, strpos($alumno->user->nombre, ' ') + 1, 1)) : 'NA' }}
                                        </span>
                                    </div>
                                @endif
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $alumno->user ? $alumno->user->nombre : 'Sin nombre' }}</div>
                                    <div class="text-sm text-gray-500">{{ $alumno->user ? $alumno->user->dni : 'Sin DNI' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                {{ $alumno->user ? $alumno->user->email : 'Sin email' }}
                            </div>
                            <div class="text-sm text-gray-500 flex items-center mt-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                                {{ $alumno->user && $alumno->user->telefono ? $alumno->user->telefono : 'Sin teléfono' }}
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900 font-semibold">
                                {{ $alumno->clases_count ?? count($alumno->clases) }} clase(s)
                            </div>
                            @if($alumno->clases && count($alumno->clases) > 0)
                                <div class="mt-1 flex flex-wrap gap-1">
                                    @foreach($alumno->clases->take(2) as $clase)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-indigo-100 text-indigo-800">
                                            {{ $clase->nombre }}
                                        </span>
                                    @endforeach
                                    @if(count($alumno->clases) > 2)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800">
                                            +{{ count($alumno->clases) - 2 }} más
                                        </span>
                                    @endif
                                </div>
                            @else
                                <div class="text-xs text-gray-500 italic">Sin clases asignadas</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Activo
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex flex-col sm:flex-row gap-2">
                                <a href="{{ route('chat.show', $alumno->id) }}" class="text-blue-600 hover:text-blue-900 bg-blue-50 border border-blue-200 hover:bg-blue-100 rounded-md px-3 py-1 transition-colors flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                    </svg>
                                    Mensaje
                                </a>
                                <a href="{{ route('docente.alumnos.show', $alumno->id) }}" class="text-purple-600 hover:text-purple-900 bg-purple-50 border border-purple-200 hover:bg-purple-100 rounded-md px-3 py-1 transition-colors flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Ver perfil
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                                <span class="text-gray-500 text-lg font-medium">No se encontraron alumnos</span>
                                <p class="text-gray-400 text-sm mt-1">Prueba a cambiar los filtros de búsqueda o seleccionar otra clase</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Paginación -->
        <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
            {{ $alumnos->links() }}
        </div>
    </div>
</div>
@endsection 