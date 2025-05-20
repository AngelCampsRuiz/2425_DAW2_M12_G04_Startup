@extends('layouts.docente')

@section('title', 'Detalles de Clase')

@section('content')
<div class="bg-white rounded-xl shadow-md overflow-hidden">
    <!-- Cabecera con información básica de la clase -->
    <div class="p-6 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-200">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
            <div>
                <div class="flex items-center">
                    <a href="{{ route('docente.clases.index') }}" class="text-blue-600 hover:text-blue-800 mr-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                        </svg>
                    </a>
                    <h1 class="text-2xl font-bold text-gray-800">{{ $clase->nombre }}</h1>
                </div>
                <div class="flex items-center mt-2 text-sm text-gray-600">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $clase->activa ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $clase->activa ? 'Activa' : 'Inactiva' }}
                    </span>
                    <span class="mx-2">•</span>
                    <span>Código: {{ $clase->codigo }}</span>
                    @if($clase->horario)
                        <span class="mx-2">•</span>
                        <span>{{ $clase->horario }}</span>
                    @endif
                </div>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('docente.clases.alumnos', $clase->id) }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    Gestionar alumnos
                </a>
            </div>
        </div>
    </div>

    <!-- Información detallada y estadísticas -->
    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Estadísticas de la clase -->
            <div class="col-span-1 bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    Estadísticas
                </h2>
                <div class="space-y-4">
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <div class="flex justify-between items-center">
                            <span class="text-sm font-medium text-blue-600">Total estudiantes</span>
                            <span class="text-lg font-bold text-blue-800">{{ $clase->estudiantes->count() }}</span>
                        </div>
                        <div class="w-full bg-blue-100 rounded-full h-2.5 mt-2">
                            @php $porcentaje = $clase->capacidad > 0 ? min(100, ($clase->estudiantes->count() / $clase->capacidad) * 100) : 0; @endphp
                            <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $porcentaje }}%"></div>
                        </div>
                        <p class="text-xs text-blue-600 mt-1">{{ $clase->estudiantes->count() }}/{{ $clase->capacidad ?: '∞' }} plazas ocupadas</p>
                    </div>

                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                        <span class="text-sm font-medium text-gray-600">Solicitudes pendientes</span>
                        <span class="text-lg font-bold text-indigo-600">{{ $clase->solicitudes()->where('estado', 'pendiente')->count() }}</span>
                    </div>
                </div>
            </div>

            <!-- Información académica -->
            <div class="col-span-1 bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path d="M12 14l9-5-9-5-9 5 9 5z" />
                        <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
                    </svg>
                    Información académica
                </h2>
                <div class="space-y-3">
                    <div class="flex">
                        <div class="w-1/2">
                            <p class="text-xs text-gray-500">Nivel educativo</p>
                            <p class="text-sm font-medium text-gray-800">{{ $clase->categoria->nivelEducativo->nombre_nivel ?? 'No definido' }}</p>
                        </div>
                        <div class="w-1/2">
                            <p class="text-xs text-gray-500">Categoría</p>
                            <p class="text-sm font-medium text-gray-800">{{ $clase->categoria->nombre_categoria ?? 'No definida' }}</p>
                        </div>
                    </div>
                    <div class="pt-2 border-t border-gray-100">
                        <p class="text-xs text-gray-500">Departamento</p>
                        <p class="text-sm font-medium text-gray-800">{{ $clase->departamento->nombre ?? 'Sin departamento asignado' }}</p>
                    </div>
                    @if($clase->curso || $clase->grupo)
                    <div class="pt-2 border-t border-gray-100">
                        <div class="flex">
                            @if($clase->curso)
                            <div class="w-1/2">
                                <p class="text-xs text-gray-500">Curso</p>
                                <p class="text-sm font-medium text-gray-800">{{ $clase->curso }}</p>
                            </div>
                            @endif
                            @if($clase->grupo)
                            <div class="w-1/2">
                                <p class="text-xs text-gray-500">Grupo</p>
                                <p class="text-sm font-medium text-gray-800">{{ $clase->grupo }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Información adicional -->
            <div class="col-span-1 bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Información adicional
                </h2>
                <div class="space-y-3">
                    <div>
                        <p class="text-xs text-gray-500">Institución</p>
                        <p class="text-sm font-medium text-gray-800">{{ $clase->institucion->user->nombre ?? 'No disponible' }}</p>
                    </div>
                    @if($clase->anyo_academico)
                    <div class="pt-2 border-t border-gray-100">
                        <p class="text-xs text-gray-500">Año académico</p>
                        <p class="text-sm font-medium text-gray-800">{{ $clase->anyo_academico }}</p>
                    </div>
                    @endif
                    @if($clase->descripcion)
                    <div class="pt-2 border-t border-gray-100">
                        <p class="text-xs text-gray-500">Descripción</p>
                        <p class="text-sm text-gray-800">{{ $clase->descripcion }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Lista de estudiantes -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    Estudiantes
                    <span class="ml-2 text-sm text-gray-500">({{ $clase->estudiantes->count() }})</span>
                </h2>
                <a href="{{ route('docente.clases.alumnos', $clase->id) }}" class="text-sm text-blue-600 hover:text-blue-800 flex items-center">
                    Ver todos
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>

            @if($clase->estudiantes->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Nombre
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Email
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Teléfono
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Estado
                                </th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($clase->estudiantes->take(5) as $estudiante)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10 bg-gray-100 rounded-full flex items-center justify-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $estudiante->user->nombre }}
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    {{ $estudiante->user->dni }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $estudiante->user->email }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $estudiante->user->telefono }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $pivot = $estudiante->pivot;
                                            $estado = $pivot ? $pivot->estado : 'activo';
                                            $estadoClase = [
                                                'activo' => 'bg-green-100 text-green-800',
                                                'inactivo' => 'bg-red-100 text-red-800',
                                                'completado' => 'bg-blue-100 text-blue-800',
                                                'pendiente' => 'bg-yellow-100 text-yellow-800',
                                            ][$estado] ?? 'bg-gray-100 text-gray-800';
                                        @endphp
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $estadoClase }}">
                                            {{ ucfirst($estado) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('docente.alumnos.show', $estudiante->id) }}" class="text-indigo-600 hover:text-indigo-900">
                                            Ver
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if($clase->estudiantes->count() > 5)
                    <div class="mt-4 text-center">
                        <a href="{{ route('docente.clases.alumnos', $clase->id) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Ver todos los estudiantes
                        </a>
                    </div>
                @endif
            @else
                <div class="text-center py-8">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No hay estudiantes</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        Esta clase aún no tiene estudiantes asignados.
                    </p>
                    <div class="mt-6">
                        <a href="{{ route('docente.clases.alumnos', $clase->id) }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Gestionar alumnos
                        </a>
                    </div>
                </div>
            @endif
        </div>

        <!-- Solicitudes pendientes -->
        @php
            $solicitudesPendientes = $clase->solicitudes()->where('estado', 'pendiente')->with('estudiante.user')->latest()->take(3)->get();
        @endphp
        @if($solicitudesPendientes->count() > 0)
            <div class="mt-8 bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                        </svg>
                        Solicitudes pendientes
                    </h2>
                    <a href="{{ route('docente.solicitudes.index') }}" class="text-sm text-blue-600 hover:text-blue-800 flex items-center">
                        Ver todas
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>

                <div class="space-y-4">
                    @foreach($solicitudesPendientes as $solicitud)
                        <div class="flex items-center justify-between p-4 border border-amber-100 rounded-lg bg-amber-50">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10 bg-amber-100 rounded-full flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">{{ $solicitud->estudiante->user->nombre }}</p>
                                    <p class="text-xs text-gray-500">
                                        {{ $solicitud->created_at->format('d/m/Y H:i') }}
                                    </p>
                                </div>
                            </div>
                            
                            <div class="flex space-x-2">
                                <a href="{{ route('docente.solicitudes.show', $solicitud->id) }}" class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded text-blue-700 bg-blue-100 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    Ver
                                </a>
                                <form action="{{ route('docente.solicitudes.aprobar', $solicitud->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded text-green-700 bg-green-100 hover:bg-green-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                        Aprobar
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
@endsection 