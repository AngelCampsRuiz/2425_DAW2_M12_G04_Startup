@extends('layouts.docente')

@section('title', 'Gestión de Alumnos - ' . $clase->nombre)

@section('content')
<div class="bg-white rounded-xl shadow-md overflow-hidden">
    <!-- Cabecera -->
    <div class="p-6 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-200">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
            <div>
                <div class="flex items-center">
                    <a href="{{ route('docente.clases.show', $clase->id) }}" class="text-blue-600 hover:text-blue-800 mr-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                        </svg>
                    </a>
                    <h1 class="text-2xl font-bold text-gray-800">Alumnos de {{ $clase->nombre }}</h1>
                </div>
                <div class="flex items-center mt-2 text-sm text-gray-600">
                    <span>
                        <span class="font-medium text-gray-700">Ciclo:</span> 
                        {{ $clase->categoria->nombre_categoria ?? 'No definido' }}
                    </span>
                    <span class="mx-2">•</span>
                    <span>
                        <span class="font-medium text-gray-700">Nivel:</span> 
                        {{ $clase->categoria->nivelEducativo->nombre_nivel ?? 'No definido' }}
                    </span>
                    <span class="mx-2">•</span>
                    <span>
                        <span class="font-medium text-gray-700">Código:</span> 
                        {{ $clase->codigo }}
                    </span>
                </div>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('docente.clases.show', $clase->id) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    Volver a detalles
                </a>
            </div>
        </div>
    </div>

    <!-- Contenido -->
    <div class="p-6">
        <!-- Filtros y búsqueda -->
        <div class="mb-6 bg-gray-50 p-4 rounded-lg border border-gray-200">
            <form action="{{ route('docente.clases.alumnos', $clase->id) }}" method="GET" class="flex flex-col md:flex-row md:items-end space-y-4 md:space-y-0 md:space-x-4">
                <div class="flex-1">
                    <label for="buscar" class="block text-sm font-medium text-gray-700 mb-1">Buscar</label>
                    <input type="text" name="buscar" id="buscar" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Nombre, email o DNI" value="{{ request('buscar') }}">
                </div>
                <div>
                    <label for="estado" class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
                    <select id="estado" name="estado" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                        <option value="">Todos</option>
                        <option value="activo" {{ request('estado') == 'activo' ? 'selected' : '' }}>Activo</option>
                        <option value="inactivo" {{ request('estado') == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                        <option value="completado" {{ request('estado') == 'completado' ? 'selected' : '' }}>Completado</option>
                        <option value="pendiente" {{ request('estado') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                    </select>
                </div>
                <div class="flex space-x-2">
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        Buscar
                    </button>
                    <a href="{{ route('docente.clases.alumnos', $clase->id) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        Limpiar
                    </a>
                </div>
            </form>
        </div>

        <!-- Estadísticas rápidas -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <div class="bg-gradient-to-br from-green-50 to-green-100 p-4 rounded-lg shadow-sm border border-green-200">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-sm font-medium text-green-800">Activos</p>
                        <p class="text-2xl font-bold text-green-900">
                            {{ $alumnos->where('pivot.estado', 'activo')->count() }}
                        </p>
                    </div>
                    <div class="bg-green-200 p-3 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-red-50 to-red-100 p-4 rounded-lg shadow-sm border border-red-200">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-sm font-medium text-red-800">Inactivos</p>
                        <p class="text-2xl font-bold text-red-900">
                            {{ $alumnos->where('pivot.estado', 'inactivo')->count() }}
                        </p>
                    </div>
                    <div class="bg-red-200 p-3 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-4 rounded-lg shadow-sm border border-blue-200">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-sm font-medium text-blue-800">Completados</p>
                        <p class="text-2xl font-bold text-blue-900">
                            {{ $alumnos->where('pivot.estado', 'completado')->count() }}
                        </p>
                    </div>
                    <div class="bg-blue-200 p-3 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 p-4 rounded-lg shadow-sm border border-yellow-200">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-sm font-medium text-yellow-800">Pendientes</p>
                        <p class="text-2xl font-bold text-yellow-900">
                            {{ $alumnos->where('pivot.estado', 'pendiente')->count() }}
                        </p>
                    </div>
                    <div class="bg-yellow-200 p-3 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabla de alumnos -->
        <div class="bg-white shadow-md rounded-lg border border-gray-200 overflow-hidden">
            <div class="px-4 py-3 bg-gray-50 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-800 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    Listado de Estudiantes
                    <span class="ml-2 text-sm text-gray-500">
                        ({{ $alumnos->total() }} en total)
                    </span>
                </h2>
            </div>

            @if($alumnos->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Estudiante
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Contacto
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Fecha Asignación
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Estado
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Calificación
                                </th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($alumnos as $alumno)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10 bg-indigo-100 rounded-full flex items-center justify-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $alumno->user->nombre }}
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    {{ $alumno->user->dni }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $alumno->user->email }}</div>
                                        <div class="text-sm text-gray-500">{{ $alumno->user->telefono }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $alumno->pivot->fecha_asignacion ? \Carbon\Carbon::parse($alumno->pivot->fecha_asignacion)->format('d/m/Y') : 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $estado = $alumno->pivot->estado ?? 'activo';
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
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            @if(isset($alumno->pivot->calificacion))
                                                <span class="font-semibold">{{ $alumno->pivot->calificacion }}</span>/10
                                            @else
                                                <span class="text-gray-500">Sin calificar</span>
                                            @endif
                                        </div>
                                        @if($alumno->pivot->comentarios)
                                            <div class="text-xs text-gray-500 truncate max-w-xs" title="{{ $alumno->pivot->comentarios }}">
                                                {{ \Illuminate\Support\Str::limit($alumno->pivot->comentarios, 30) }}
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end space-x-2">
                                            <a href="{{ route('docente.alumnos.show', $alumno->id) }}" class="text-indigo-600 hover:text-indigo-900">
                                                Ver
                                            </a>
                                            <button type="button" 
                                                class="text-blue-600 hover:text-blue-900" 
                                                onclick="openCalificarModal('{{ $alumno->id }}', '{{ $alumno->user->nombre }}', '{{ $alumno->pivot->calificacion ?? '' }}', '{{ addslashes($alumno->pivot->comentarios ?? '') }}')">
                                                Calificar
                                            </button>
                                            <button type="button" 
                                                class="text-gray-600 hover:text-gray-900"
                                                onclick="openCambiarEstadoModal('{{ $alumno->id }}', '{{ $alumno->user->nombre }}', '{{ $alumno->pivot->estado }}')">
                                                Estado
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="px-4 py-3 bg-white border-t border-gray-200 sm:px-6">
                    {{ $alumnos->appends(request()->query())->links() }}
                </div>
            @else
                <div class="text-center py-16">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <h3 class="mt-2 text-base font-medium text-gray-900">No hay estudiantes</h3>
                    <p class="mt-1 text-sm text-gray-500">Esta clase aún no tiene estudiantes asignados o no se encontraron estudiantes con los filtros aplicados.</p>
                    @if(request('buscar') || request('estado'))
                        <div class="mt-6">
                            <a href="{{ route('docente.clases.alumnos', $clase->id) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                                Limpiar filtros
                            </a>
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal para calificar alumno -->
<div id="modalCalificar" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        
        <div class="relative bg-white rounded-lg shadow-xl mx-auto max-w-lg w-full p-6 overflow-hidden z-50">
            <div class="absolute top-0 right-0 pt-4 pr-4">
                <button type="button" id="closeCalificarModal" class="text-gray-400 hover:text-gray-500 focus:outline-none">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            
            <div class="mt-4">
                <h3 class="text-lg font-medium text-gray-900 mb-1" id="calificarNombreEstudiante"></h3>
                <p class="text-sm text-gray-500 mb-4">Asignar calificación y comentarios</p>
                
                <form id="formCalificar" method="POST" action="">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-4">
                        <label for="calificacion" class="block text-sm font-medium text-gray-700 mb-1">Calificación (0-10)</label>
                        <input type="number" name="calificacion" id="calificacion" min="0" max="10" step="0.1" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                    </div>
                    
                    <div class="mb-4">
                        <label for="comentarios" class="block text-sm font-medium text-gray-700 mb-1">Comentarios</label>
                        <textarea name="comentarios" id="comentarios" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"></textarea>
                    </div>
                    
                    <div class="mt-5 sm:mt-6 flex justify-end space-x-2">
                        <button type="button" id="cancelarCalificar" class="inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:text-sm">
                            Cancelar
                        </button>
                        <button type="submit" class="inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:text-sm">
                            Guardar calificación
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal para cambiar estado -->
<div id="modalEstado" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        
        <div class="relative bg-white rounded-lg shadow-xl mx-auto max-w-lg w-full p-6 overflow-hidden z-50">
            <div class="absolute top-0 right-0 pt-4 pr-4">
                <button type="button" id="closeEstadoModal" class="text-gray-400 hover:text-gray-500 focus:outline-none">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            
            <div class="mt-4">
                <h3 class="text-lg font-medium text-gray-900 mb-1" id="estadoNombreEstudiante"></h3>
                <p class="text-sm text-gray-500 mb-4">Cambiar el estado del estudiante en esta clase</p>
                
                <form id="formEstado" method="POST" action="">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-4">
                        <label for="estado" class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
                        <select name="estado" id="estadoSelect" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            <option value="activo">Activo</option>
                            <option value="inactivo">Inactivo</option>
                            <option value="completado">Completado</option>
                            <option value="pendiente">Pendiente</option>
                        </select>
                    </div>
                    
                    <div class="mt-5 sm:mt-6 flex justify-end space-x-2">
                        <button type="button" id="cancelarEstado" class="inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:text-sm">
                            Cancelar
                        </button>
                        <button type="submit" class="inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:text-sm">
                            Guardar cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function openCalificarModal(id, nombre, calificacion, comentarios) {
        document.getElementById('calificarNombreEstudiante').innerText = 'Calificar a ' + nombre;
        document.getElementById('calificacion').value = calificacion;
        document.getElementById('comentarios').value = comentarios;
        document.getElementById('formCalificar').action = '/docente/estudiante/' + id + '/calificar/{{ $clase->id }}';
        document.getElementById('modalCalificar').classList.remove('hidden');
    }
    
    function closeCalificarModal() {
        document.getElementById('modalCalificar').classList.add('hidden');
    }
    
    function openCambiarEstadoModal(id, nombre, estado) {
        document.getElementById('estadoNombreEstudiante').innerText = 'Cambiar estado de ' + nombre;
        document.getElementById('estadoSelect').value = estado;
        document.getElementById('formEstado').action = '/docente/estudiante/' + id + '/estado/{{ $clase->id }}';
        document.getElementById('modalEstado').classList.remove('hidden');
    }
    
    function closeEstadoModal() {
        document.getElementById('modalEstado').classList.add('hidden');
    }
    
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('closeCalificarModal').addEventListener('click', closeCalificarModal);
        document.getElementById('cancelarCalificar').addEventListener('click', closeCalificarModal);
        
        document.getElementById('closeEstadoModal').addEventListener('click', closeEstadoModal);
        document.getElementById('cancelarEstado').addEventListener('click', closeEstadoModal);
        
        // Cerrar modales al hacer clic fuera
        window.addEventListener('click', function(e) {
            if (e.target.classList.contains('fixed') && e.target.classList.contains('inset-0')) {
                closeCalificarModal();
                closeEstadoModal();
            }
        });
    });
</script>
@endsection 