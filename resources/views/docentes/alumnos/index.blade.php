@extends('layouts.docente')

@section('title', 'Alumnos')

@section('content')
<div class="space-y-6">
    <!-- Encabezado con buscador -->
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
        
        <div class="flex items-center space-x-4">
            <!-- Buscador -->
            <form action="{{ route('docente.alumnos.index') }}" method="GET" class="flex">
                <div class="relative">
                    <input type="text" name="search" placeholder="Buscar alumno..." value="{{ request('search') }}"
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
            
            <!-- Filtro por clase -->
            <select onchange="window.location.href=this.value" 
                    class="rounded-lg border border-gray-300 focus:ring-purple-500 focus:border-purple-500 py-2 pl-3 pr-10 text-sm">
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
    
    <!-- Tabla de alumnos -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Alumno</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
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
                                @if($alumno->imagen)
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <img class="h-10 w-10 rounded-full object-cover" src="{{ asset('public/profile_images/' . $alumno->imagen) }}" alt="">
                                    </div>
                                @else
                                    <div class="flex-shrink-0 h-10 w-10 bg-purple-200 rounded-full flex items-center justify-center">
                                        <span class="text-purple-600 font-medium text-sm">{{ substr($alumno->nombre, 0, 2) }}</span>
                                    </div>
                                @endif
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $alumno->nombre }}</div>
                                    <div class="text-sm text-gray-500">{{ $alumno->dni }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $alumno->email }}</div>
                            <div class="text-sm text-gray-500">{{ $alumno->telefono }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">
                                {{ $alumno->clases_count ?? count($alumno->clases) }} clase(s)
                            </div>
                            @if($alumno->clases && count($alumno->clases) > 0)
                                <div class="text-xs text-gray-500">{{ $alumno->clases->pluck('nombre')->join(', ') }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                Activo
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                            <a href="{{ route('chat.show', $alumno->id) }}" class="text-blue-600 hover:text-blue-900">
                                <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded-md">
                                    <i class="fas fa-comment mr-1"></i> Mensaje
                                </span>
                            </a>
                            <a href="{{ route('docente.alumnos.show', $alumno->id) }}" class="text-indigo-600 hover:text-indigo-900">
                                <span class="bg-indigo-100 text-indigo-700 px-2 py-1 rounded-md">
                                    <i class="fas fa-eye mr-1"></i> Ver
                                </span>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                            No se encontraron alumnos.
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