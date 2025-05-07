@extends('layouts.docente')

@section('title', 'Dashboard de Docente')

@section('content')
<div class="bg-gradient-to-br from-gray-50 to-purple-50">
    <!-- Estadísticas -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Tarjeta: Total de Alumnos -->
        <div class="bg-gradient-to-br from-purple-50 to-purple-100 p-5 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 border border-purple-100 transform hover:-translate-y-1">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="font-medium text-purple-800 mb-1">Alumnos</h3>
                    <p class="text-3xl font-bold text-purple-900">{{ $totalAlumnos }}</p>
                </div>
                <div class="bg-white p-3 rounded-lg shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 text-sm text-purple-700">
                <div class="flex items-center">
                    <span class="font-medium">Estudiantes Activos</span>
                    <a href="{{ route('docente.alumnos.index') }}" class="ml-auto bg-white text-purple-600 hover:text-purple-800 text-xs font-medium px-2 py-1 rounded-full shadow-sm transition-colors duration-200">
                        Ver todos
                    </a>
                </div>
            </div>
        </div>

        <!-- Tarjeta: Clases Asignadas -->
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-5 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 border border-blue-100 transform hover:-translate-y-1">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="font-medium text-blue-800 mb-1">Clases</h3>
                    <p class="text-3xl font-bold text-blue-900">{{ $totalClases }}</p>
                </div>
                <div class="bg-white p-3 rounded-lg shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 text-sm text-blue-700">
                <div class="flex items-center">
                    <span class="font-medium">Clases Asignadas</span>
                    <a href="{{ route('docente.clases.index') }}" class="ml-auto bg-white text-blue-600 hover:text-blue-800 text-xs font-medium px-2 py-1 rounded-full shadow-sm transition-colors duration-200">
                        Ver todas
                    </a>
                </div>
            </div>
        </div>

        <!-- Tarjeta: Solicitudes Pendientes -->
        <div class="bg-gradient-to-br from-amber-50 to-amber-100 p-5 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 border border-amber-100 transform hover:-translate-y-1">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="font-medium text-amber-800 mb-1">Solicitudes</h3>
                    <p class="text-3xl font-bold text-amber-900">{{ $solicitudesPendientes }}</p>
                </div>
                <div class="bg-white p-3 rounded-lg shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 text-sm text-amber-700">
                <div class="flex items-center">
                    <span class="font-medium">Pendientes</span>
                    <a href="{{ route('docente.solicitudes.index') }}" class="ml-auto bg-white text-amber-600 hover:text-amber-800 text-xs font-medium px-2 py-1 rounded-full shadow-sm transition-colors duration-200">
                        Ver todas
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Accesos Rápidos -->
    <div class="bg-white rounded-xl shadow-md p-6 border border-gray-100 transform transition-all duration-300 hover:shadow-lg mb-8">
        <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
            </svg>
            Acciones Rápidas
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
            <!-- Ver Lista de Alumnos -->
            <a href="{{ route('docente.alumnos.index') }}" class="flex items-center p-5 rounded-xl shadow-sm hover:shadow-md border border-indigo-100 hover:border-indigo-300 transition-all duration-300 bg-gradient-to-br from-white to-indigo-50 group">
                <div class="bg-indigo-100 group-hover:bg-indigo-200 rounded-full p-3 mr-4 transition-colors duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-base text-gray-800">Lista de Alumnos</h3>
                    <p class="text-sm text-gray-600 mt-1">Gestionar estudiantes</p>
                </div>
            </a>

            <!-- Mensajes -->
            <a href="{{ route('chat.index') }}" class="flex items-center p-5 rounded-xl shadow-sm hover:shadow-md border border-blue-100 hover:border-blue-300 transition-all duration-300 bg-gradient-to-br from-white to-blue-50 group">
                <div class="bg-blue-100 group-hover:bg-blue-200 rounded-full p-3 mr-4 transition-colors duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-base text-gray-800">Mensajes</h3>
                    <p class="text-sm text-gray-600 mt-1">Chat con alumnos y empresas</p>
                </div>
            </a>

            <!-- Revisar Solicitudes -->
            <a href="{{ route('docente.solicitudes.index') }}" class="flex items-center p-5 rounded-xl shadow-sm hover:shadow-md border border-amber-100 hover:border-amber-300 transition-all duration-300 bg-gradient-to-br from-white to-amber-50 group">
                <div class="bg-amber-100 group-hover:bg-amber-200 rounded-full p-3 mr-4 transition-colors duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-base text-gray-800">Revisar Solicitudes</h3>
                    <p class="text-sm text-gray-600 mt-1">Gestionar solicitudes pendientes</p>
                </div>
            </a>
        </div>
    </div>

    <!-- Lista de Clases Asignadas -->
    <div class="bg-white rounded-xl shadow-md p-6 border border-gray-100 transform transition-all duration-300 hover:shadow-lg">
        <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
            </svg>
            Mis Clases
        </h2>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Clase</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Departamento</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Alumnos</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($clases as $clase)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $clase->nombre }}</div>
                            <div class="text-sm text-gray-500">{{ $clase->codigo }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $clase->departamento->nombre }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $clase->estudiantes_count }} estudiantes</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <a href="{{ route('docente.clases.show', $clase) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Ver detalles</a>
                            <a href="{{ route('docente.clases.alumnos', $clase) }}" class="text-green-600 hover:text-green-900">Gestionar alumnos</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">No hay clases asignadas</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection 