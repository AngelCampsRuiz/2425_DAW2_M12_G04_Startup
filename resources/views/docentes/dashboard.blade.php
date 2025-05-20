@extends('layouts.docente')

@section('title', 'Dashboard de Docente')

@section('content')
<div class="bg-gradient-to-br from-gray-50 to-purple-50">
    <!-- Estadísticas -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
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

        <!-- Tarjeta: Convenios -->
        <div class="bg-gradient-to-br from-green-50 to-green-100 p-5 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 border border-green-100 transform hover:-translate-y-1">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="font-medium text-green-800 mb-1">Convenios</h3>
                    <p class="text-3xl font-bold text-green-900">{{ count($conveniosPendientes ?? []) }}</p>
                </div>
                <div class="bg-white p-3 rounded-lg shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 text-sm text-green-700">
                <div class="flex items-center">
                    <span class="font-medium">Pendientes de aprobación</span>
                    <a href="{{ route('docente.convenios.index') }}" class="ml-auto bg-white text-green-600 hover:text-green-800 text-xs font-medium px-2 py-1 rounded-full shadow-sm transition-colors duration-200">
                        Ver todos
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
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mt-6">
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

            <!-- Convenios -->
            <a href="{{ route('docente.convenios.index') }}" class="flex items-center p-5 rounded-xl shadow-sm hover:shadow-md border border-green-100 hover:border-green-300 transition-all duration-300 bg-gradient-to-br from-white to-green-50 group">
                <div class="bg-green-100 group-hover:bg-green-200 rounded-full p-3 mr-4 transition-colors duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-base text-gray-800">Convenios</h3>
                    <p class="text-sm text-gray-600 mt-1">Gestionar convenios con empresas</p>
                </div>
            </a>
        </div>
    </div>

    <!-- Lista de Clases Asignadas -->
    <div class="bg-white rounded-xl shadow-md p-6 border border-gray-100 transform transition-all duration-300 hover:shadow-lg mb-8">
        <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
            </svg>
            Mis Clases
        </h2>
        
        <!-- Clases en formato de tarjetas -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($clases as $clase)
                <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow p-6 border-t-4 border-blue-500">
                    <div class="flex justify-between items-start mb-4">
                        <h3 class="text-lg font-bold text-gray-800">{{ $clase->nombre }}</h3>
                        <span class="px-2 py-1 rounded-full text-xs bg-blue-100 text-blue-800">
                            {{ $clase->estudiantes_count }} estudiantes
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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <div>
                                <p class="text-xs text-gray-500">Año académico</p>
                                <p class="text-sm font-medium text-gray-700">{{ $clase->anyo_academico ?? 'No definido' }}</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                            </svg>
                            <div>
                                <p class="text-xs text-gray-500">Código</p>
                                <p class="text-sm font-medium text-gray-700">{{ $clase->codigo }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="border-t pt-4 flex justify-between">
                        <a href="{{ route('docente.clases.show', $clase) }}" class="text-sm font-medium text-blue-600 hover:text-blue-800">
                            Ver detalles
                        </a>
                        <a href="{{ route('docente.clases.alumnos', $clase) }}" class="text-sm font-medium text-green-600 hover:text-green-800">
                            Gestionar alumnos
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full">
                    <div class="text-center py-10 px-4 bg-white rounded-xl shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-300 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900 mb-1">No hay clases asignadas</h3>
                        <p class="text-gray-500 max-w-md mx-auto mb-6">Actualmente no tienes clases asignadas. Contacta con la institución para que te asignen clases.</p>
                    </div>
                </div>
            @endforelse
        </div>
        
        @if(count($clases) > 0)
            <div class="mt-4 flex justify-end">
                <a href="{{ route('docente.clases.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                    Ver todas mis clases
                </a>
            </div>
        @endif
    </div>

    <!-- Convenios Pendientes de Aprobación -->
    <div class="bg-white rounded-xl shadow-md p-6 border border-gray-100 transform transition-all duration-300 hover:shadow-lg mb-8">
        <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            Convenios Pendientes
            <span class="ml-2 px-2.5 py-0.5 bg-amber-100 text-amber-800 text-xs font-medium rounded-full">
                {{ count($conveniosPendientes ?? []) }}
            </span>
        </h2>
        
        <!-- Convenios en formato de tarjetas -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($conveniosPendientes ?? [] as $convenio)
                <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow p-6 border-l-4 border-amber-400">
                    <div class="flex justify-between items-start mb-4">
                        <h3 class="text-base font-bold text-gray-800">{{ $convenio->estudiante->nombre }}</h3>
                        <span class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                            Pendiente
                        </span>
                    </div>
                    
                    <div class="space-y-3 mb-5">
                        <div class="flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            <div>
                                <p class="text-xs text-gray-500">Empresa</p>
                                <p class="text-sm font-medium text-gray-700">{{ $convenio->empresa->nombre }}</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <div>
                                <p class="text-xs text-gray-500">Fechas</p>
                                <p class="text-sm font-medium text-gray-700">
                                    {{ $convenio->fecha_inicio ? \Carbon\Carbon::parse($convenio->fecha_inicio)->format('d/m/Y') : 'No definida' }} -
                                    {{ $convenio->fecha_fin ? \Carbon\Carbon::parse($convenio->fecha_fin)->format('d/m/Y') : 'No definida' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="border-t pt-4 flex flex-wrap gap-2">
                        <a href="{{ route('docente.convenios.show', $convenio->id) }}" class="inline-flex items-center px-3 py-1.5 border border-transparent rounded-md text-xs font-medium text-white bg-blue-600 hover:bg-blue-700 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            Ver
                        </a>
                        <form action="{{ route('docente.convenios.aprobar', $convenio->id) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="inline-flex items-center px-3 py-1.5 border border-transparent rounded-md text-xs font-medium text-white bg-green-600 hover:bg-green-700 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Aprobar
                            </button>
                        </form>
                        <form action="{{ route('docente.convenios.rechazar', $convenio->id) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="inline-flex items-center px-3 py-1.5 border border-transparent rounded-md text-xs font-medium text-white bg-red-600 hover:bg-red-700 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Rechazar
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="col-span-full">
                    <div class="text-center py-10 px-4 bg-white rounded-xl shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-300 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900 mb-1">No hay convenios pendientes</h3>
                        <p class="text-gray-500 max-w-md mx-auto mb-6">Actualmente no hay convenios pendientes de aprobación.</p>
                    </div>
                </div>
            @endforelse
        </div>
        
        @if(count($conveniosPendientes ?? []) > 0)
            <div class="mt-4 flex justify-end">
                <a href="{{ route('docente.convenios.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-purple-600 hover:bg-purple-700 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    Ver todos los convenios
                </a>
            </div>
        @endif
    </div>
</div>
@endsection 