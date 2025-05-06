@extends('layouts.app')

@section('title', 'Detalles de la Clase ' . $clase->nombre)

@section('content')
<div class="bg-white rounded-lg shadow-lg overflow-hidden">
    <!-- Encabezado -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 p-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-white mr-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
                <div>
                    <h1 class="text-2xl font-bold text-white">{{ $clase->nombre }}</h1>
                    <p class="text-blue-100 flex items-center">
                        <span class="mr-2">{{ $clase->nivel }} · {{ $clase->curso }}{{ $clase->grupo ? ' · Grupo ' . $clase->grupo : '' }}</span>
                        <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $clase->activa ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $clase->activa ? 'Activa' : 'Inactiva' }}
                        </span>
                    </p>
                </div>
            </div>
            <div class="space-x-2">
                <a href="{{ route('institucion.clases.edit', $clase->id) }}" class="px-4 py-2 text-sm font-medium text-white bg-blue-800 hover:bg-blue-700 border border-transparent rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200 inline-flex items-center shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Editar
                </a>
                <a href="{{ route('institucion.clases.asignar-estudiantes', $clase->id) }}" class="px-4 py-2 text-sm font-medium text-white bg-indigo-800 hover:bg-indigo-700 border border-transparent rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200 inline-flex items-center shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    Asignar Estudiantes
                </a>
            </div>
        </div>
    </div>

    <!-- Información General -->
    <div class="p-6">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Columna 1 - Información de la Clase -->
            <div class="col-span-2">
                <div class="mb-8">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Información General
                    </h2>

                    <div class="bg-white rounded-lg border p-6">
                        <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-6 text-sm">
                            <div class="col-span-1">
                                <dt class="text-gray-500 mb-1">Código de Clase</dt>
                                <dd class="font-medium text-gray-900">{{ $clase->codigo }}</dd>
                            </div>
                            
                            <div class="col-span-1">
                                <dt class="text-gray-500 mb-1">Departamento</dt>
                                <dd class="font-medium text-gray-900">
                                    @if($clase->departamento)
                                        <a href="{{ route('institucion.departamentos.show', $clase->departamento->id) }}" class="text-blue-600 hover:text-blue-800 hover:underline">
                                            {{ $clase->departamento->nombre }}
                                        </a>
                                    @else
                                        <span class="text-gray-400">No asignado</span>
                                    @endif
                                </dd>
                            </div>
                            
                            <div class="col-span-1">
                                <dt class="text-gray-500 mb-1">Nivel</dt>
                                <dd class="font-medium text-gray-900">{{ $clase->nivel }}</dd>
                            </div>
                            
                            <div class="col-span-1">
                                <dt class="text-gray-500 mb-1">Curso / Grupo</dt>
                                <dd class="font-medium text-gray-900">{{ $clase->curso }}{{ $clase->grupo ? ' - ' . $clase->grupo : '' }}</dd>
                            </div>
                            
                            <div class="col-span-1">
                                <dt class="text-gray-500 mb-1">Estado</dt>
                                <dd class="font-medium">
                                    <form action="{{ route('institucion.clases.toggle-active', $clase->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        <button type="submit" class="inline-flex items-center px-2.5 py-1.5 text-xs font-medium rounded-full {{ $clase->activa ? 'bg-green-100 text-green-800 hover:bg-green-200' : 'bg-red-100 text-red-800 hover:bg-red-200' }}">
                                            <span class="mr-1 h-2 w-2 rounded-full {{ $clase->activa ? 'bg-green-500' : 'bg-red-500' }}"></span>
                                            {{ $clase->activa ? 'Activa' : 'Inactiva' }}
                                        </button>
                                    </form>
                                </dd>
                            </div>
                            
                            <div class="col-span-1">
                                <dt class="text-gray-500 mb-1">Fecha Creación</dt>
                                <dd class="font-medium text-gray-900">{{ $clase->created_at->format('d/m/Y') }}</dd>
                            </div>
                            
                            <div class="col-span-2">
                                <dt class="text-gray-500 mb-1">Docente Responsable</dt>
                                <dd class="font-medium">
                                    @if($clase->docente)
                                        <div class="flex items-center">
                                            <div class="h-10 w-10 flex items-center justify-center rounded-full bg-blue-100 text-blue-800 mr-3">
                                                <span class="font-semibold">{{ substr($clase->docente->user->nombre, 0, 1) }}</span>
                                            </div>
                                            <div>
                                                <a href="{{ route('institucion.docentes.show', $clase->docente->id) }}" class="text-blue-600 hover:text-blue-800 hover:underline">
                                                    {{ $clase->docente->user->nombre }}
                                                </a>
                                                <p class="text-gray-500 text-xs">{{ $clase->docente->especialidad }}</p>
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-gray-400">No asignado</span>
                                    @endif
                                </dd>
                            </div>
                            
                            <div class="col-span-2">
                                <dt class="text-gray-500 mb-1">Descripción</dt>
                                <dd class="font-medium text-gray-900">{{ $clase->descripcion ?: 'No hay descripción disponible' }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>

            <!-- Columna 2 - Estadísticas -->
            <div>
                <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    Estadísticas
                </h2>

                <div class="space-y-4">
                    <!-- Tarjeta de Estudiantes -->
                    <div class="bg-white rounded-lg border p-4">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-blue-100 text-blue-700 mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <div>
                                <div class="text-sm text-gray-500">Estudiantes en la Clase</div>
                                <div class="text-xl font-semibold">{{ $clase->estudiantes->count() }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Acciones rápidas -->
                    <div class="bg-gray-50 rounded-lg border p-4">
                        <h3 class="text-sm font-medium text-gray-500 mb-3">Acciones Rápidas</h3>
                        <div class="flex flex-col space-y-2">
                            <a href="{{ route('institucion.clases.asignar-estudiantes', $clase->id) }}" class="flex items-center text-sm text-blue-600 hover:text-blue-800 hover:bg-blue-50 p-2 rounded-md transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                                Asignar estudiantes
                            </a>
                            <a href="{{ route('institucion.clases.edit', $clase->id) }}" class="flex items-center text-sm text-blue-600 hover:text-blue-800 hover:bg-blue-50 p-2 rounded-md transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                Editar clase
                            </a>
                            <form action="{{ route('institucion.clases.toggle-active', $clase->id) }}" method="POST" class="inline-block">
                                @csrf
                                <button type="submit" class="flex items-center w-full text-left text-sm text-blue-600 hover:text-blue-800 hover:bg-blue-50 p-2 rounded-md transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    {{ $clase->activa ? 'Desactivar clase' : 'Activar clase' }}
                                </button>
                            </form>
                            <form action="{{ route('institucion.clases.destroy', $clase->id) }}" method="POST" class="inline-block delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="flex items-center w-full text-left text-sm text-red-600 hover:text-red-800 hover:bg-red-50 p-2 rounded-md transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    Eliminar clase
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Lista de Estudiantes -->
        <div class="mt-8">
            <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                Estudiantes en la Clase
                <a href="{{ route('institucion.clases.asignar-estudiantes', $clase->id) }}" class="ml-4 text-sm font-medium text-blue-600 hover:text-blue-800 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Asignar estudiantes
                </a>
            </h2>

            <div class="bg-white rounded-lg border overflow-hidden">
                @if($clase->estudiantes->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estudiante</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha de Alta</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($clase->estudiantes as $estudiante)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="h-10 w-10 flex items-center justify-center rounded-full bg-blue-100 text-blue-800 mr-3">
                                                    <span class="font-semibold">{{ substr($estudiante->user->nombre, 0, 1) }}</span>
                                                </div>
                                                <div>
                                                    <div class="font-medium text-gray-900">{{ $estudiante->user->nombre }}</div>
                                                    <div class="text-sm text-gray-500">{{ $estudiante->user->dni }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $estudiante->user->email }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $estudiante->created_at->format('d/m/Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-right">
                                            <a href="#" class="text-blue-600 hover:text-blue-900 mr-3">Ver perfil</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="p-6 text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900 mb-1">No hay estudiantes asignados a esta clase</h3>
                        <p class="text-gray-500 mb-4">Asigne estudiantes para que aparezcan en esta lista.</p>
                        <a href="{{ route('institucion.clases.asignar-estudiantes', $clase->id) }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 border border-transparent rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all shadow-md">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Asignar estudiantes
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Confirmación de eliminación
        const deleteForm = document.querySelector('.delete-form');
        
        if (deleteForm) {
            deleteForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                if (confirm('¿Estás seguro de que deseas eliminar esta clase? Esta acción no se puede deshacer.')) {
                    this.submit();
                }
            });
        }
    });
</script>
@endpush 