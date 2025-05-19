@extends('layouts.institucion')

@section('title', 'Gestión de Solicitudes')

@section('content')
<div class="bg-gray-50 p-6 rounded-xl shadow-sm">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Solicitudes de Estudiantes</h1>
        <div class="flex items-center text-sm text-gray-500 mt-1">
            <a href="{{ route('institucion.dashboard') }}" class="hover:text-primary">Dashboard</a>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mx-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <span>Solicitudes</span>
        </div>
        <div class="text-sm text-gray-600 mt-2">
            Última actualización: {{ now()->format('d/m/Y H:i') }}
        </div>
    </div>

    {{-- Mostrar alertas --}}
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

    {{-- Tarjetas resumen --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-blue-500 hover:shadow-md transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex justify-between items-center">
                <div>
                    <div class="flex items-baseline">
                        <div class="text-3xl font-bold text-gray-800">{{ $stats['total'] }}</div>
                        <div class="ml-1 text-sm text-gray-500 font-medium">solicitudes</div>
                    </div>
                    <div class="text-sm font-medium text-gray-500">Total Solicitudes</div>
                </div>
                <div class="bg-blue-100 p-3 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 border-t pt-3">
                <a href="{{ route('institucion.solicitudes.index') }}" class="text-blue-600 hover:text-blue-800 text-sm flex items-center">
                    <span>Ver todas</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-yellow-500 hover:shadow-md transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex justify-between items-center">
                <div>
                    <div class="flex items-baseline">
                        <div class="text-3xl font-bold text-gray-800">{{ $stats['pendientes'] }}</div>
                        <div class="ml-1 text-sm text-gray-500 font-medium">pendientes</div>
                    </div>
                    <div class="text-sm font-medium text-gray-500">Pendientes de Revisión</div>
                </div>
                <div class="bg-yellow-100 p-3 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 border-t pt-3">
                <a href="{{ route('institucion.solicitudes.index', ['estado' => 'pendiente']) }}" class="text-yellow-600 hover:text-yellow-800 text-sm flex items-center">
                    <span>Ver pendientes</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-green-500 hover:shadow-md transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex justify-between items-center">
                <div>
                    <div class="flex items-baseline">
                        <div class="text-3xl font-bold text-gray-800">{{ $stats['aprobadas'] }}</div>
                        <div class="ml-1 text-sm text-gray-500 font-medium">aprobadas</div>
                    </div>
                    <div class="text-sm font-medium text-gray-500">Aprobadas</div>
                </div>
                <div class="bg-green-100 p-3 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 border-t pt-3">
                <a href="{{ route('institucion.solicitudes.index', ['estado' => 'aprobada']) }}" class="text-green-600 hover:text-green-800 text-sm flex items-center">
                    <span>Ver aprobadas</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-red-500 hover:shadow-md transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex justify-between items-center">
                <div>
                    <div class="flex items-baseline">
                        <div class="text-3xl font-bold text-gray-800">{{ $stats['rechazadas'] }}</div>
                        <div class="ml-1 text-sm text-gray-500 font-medium">rechazadas</div>
                    </div>
                    <div class="text-sm font-medium text-gray-500">Rechazadas</div>
                </div>
                <div class="bg-red-100 p-3 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 border-t pt-3">
                <a href="{{ route('institucion.solicitudes.index', ['estado' => 'rechazada']) }}" class="text-red-600 hover:text-red-800 text-sm flex items-center">
                    <span>Ver rechazadas</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
        </div>
    </div>

    {{-- Filtros y búsqueda --}}
    <div class="bg-white rounded-xl shadow-sm mb-6 overflow-hidden">
        <div class="bg-gray-50 px-5 py-4 border-b">
            <div class="flex items-center text-gray-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                </svg>
                <span class="font-medium">Filtros y Búsqueda Avanzada</span>
            </div>
        </div>
        <div class="p-5">
            <form action="{{ route('institucion.solicitudes.index') }}" method="GET" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div>
                        <label for="buscar" class="block text-sm font-medium text-gray-700 mb-1">Buscar por nombre o email</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <input type="text" class="block w-full border border-gray-300 rounded-lg pl-10 px-4 py-2 focus:ring-primary focus:border-primary" 
                                id="buscar" name="buscar" value="{{ $busqueda }}" placeholder="Nombre o email del estudiante">
                        </div>
                    </div>
                    
                    <div>
                        <label for="estado" class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
                        <select class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-primary focus:border-primary" id="estado" name="estado">
                            <option value="todos" {{ $filtro == 'todos' ? 'selected' : '' }}>Todos los estados</option>
                            <option value="pendiente" {{ $filtro == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                            <option value="aprobada" {{ $filtro == 'aprobada' ? 'selected' : '' }}>Aprobada</option>
                            <option value="rechazada" {{ $filtro == 'rechazada' ? 'selected' : '' }}>Rechazada</option>
                        </select>
                    </div>
                    
                    <div>
                        <label for="fecha" class="block text-sm font-medium text-gray-700 mb-1">Periodo</label>
                        <select class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-primary focus:border-primary" id="fecha" name="fecha">
                            <option value="">Cualquier fecha</option>
                            <option value="hoy" {{ request('fecha') == 'hoy' ? 'selected' : '' }}>Hoy</option>
                            <option value="semana" {{ request('fecha') == 'semana' ? 'selected' : '' }}>Esta semana</option>
                            <option value="mes" {{ request('fecha') == 'mes' ? 'selected' : '' }}>Este mes</option>
                            <option value="trimestre" {{ request('fecha') == 'trimestre' ? 'selected' : '' }}>Último trimestre</option>
                        </select>
                    </div>
                </div>
                
                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center space-y-3 sm:space-y-0">
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center">
                            <input id="con_clase" name="con_clase" type="checkbox" class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded" {{ request('con_clase') ? 'checked' : '' }}>
                            <label for="con_clase" class="ml-2 block text-sm text-gray-700">Solo con clase asignada</label>
                        </div>
                        <div class="flex items-center">
                            <input id="sin_clase" name="sin_clase" type="checkbox" class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded" {{ request('sin_clase') ? 'checked' : '' }}>
                            <label for="sin_clase" class="ml-2 block text-sm text-gray-700">Solo sin clase asignada</label>
                        </div>
                    </div>
                    
                    <div class="flex space-x-3">
                        <a href="{{ route('institucion.solicitudes.index') }}" class="flex items-center justify-center bg-gray-100 hover:bg-gray-200 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg px-5 py-2.5 transition-colors duration-300 text-gray-800">
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
                </div>
            </form>
        </div>
    </div>

    {{-- Tabla de solicitudes --}}
    <div class="bg-white rounded-xl shadow-sm mb-8 overflow-hidden">
        <div class="bg-gray-50 px-5 py-4 border-b">
            <div class="flex items-center text-gray-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                </svg>
                <span class="font-medium">Listado de Solicitudes</span>
            </div>
        </div>
        
        <div class="p-5">
            @if($solicitudes->count() > 0)
                <div class="overflow-x-auto rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                <th scope="col" class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estudiante</th>
                                <th scope="col" class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                <th scope="col" class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                                <th scope="col" class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                                <th scope="col" class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Clase</th>
                                <th scope="col" class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($solicitudes as $solicitud)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-5 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $solicitud->id }}</td>
                                    <td class="px-5 py-4 whitespace-nowrap text-sm text-gray-700">
                                        <div class="font-medium">{{ $solicitud->estudiante->user->nombre ?? 'N/A' }}</div>
                                    </td>
                                    <td class="px-5 py-4 whitespace-nowrap text-sm text-gray-500">{{ $solicitud->estudiante->user->email ?? 'N/A' }}</td>
                                    <td class="px-5 py-4 whitespace-nowrap text-sm text-gray-500">{{ $solicitud->created_at->format('d/m/Y H:i') }}</td>
                                    <td class="px-5 py-4 whitespace-nowrap">
                                        @if($solicitud->estado == 'pendiente')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pendiente</span>
                                        @elseif($solicitud->estado == 'aprobada')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Aprobada</span>
                                        @elseif($solicitud->estado == 'rechazada')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Rechazada</span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-4 whitespace-nowrap text-sm text-gray-500">
                                        @if($solicitud->estado == 'aprobada')
                                            @if($solicitud->clase)
                                                <span class="text-blue-600 font-medium">{{ $solicitud->clase->nombre }}</span>
                                            @else
                                                <span class="text-red-600 font-medium">No asignada</span>
                                            @endif
                                        @else
                                            <span class="text-gray-400">N/A</span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('institucion.solicitudes.show', $solicitud->id) }}" class="bg-blue-100 text-blue-700 hover:bg-blue-200 rounded-lg p-2 transition-colors" title="Ver detalles">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </a>
                                            
                                            @if($solicitud->estado == 'pendiente')
                                                <form action="{{ route('institucion.solicitudes.aprobar', $solicitud->id) }}" method="POST" class="inline-flex">
                                                    @csrf
                                                    <button type="submit" class="bg-green-100 text-green-700 hover:bg-green-200 rounded-lg p-2 transition-colors" title="Aprobar">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            @elseif($solicitud->estado == 'aprobada' && !$solicitud->clase_id)
                                                <a href="{{ route('institucion.solicitudes.asignar-clase', $solicitud->id) }}" class="bg-purple-100 text-purple-700 hover:bg-purple-200 rounded-lg p-2 transition-colors" title="Asignar Clase">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path d="M12 14l9-5-9-5-9 5 9 5z" />
                                                        <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
                                                    </svg>
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Paginación --}}
                <div class="mt-5">
                    {{ $solicitudes->appends(['estado' => $filtro, 'buscar' => $busqueda])->links() }}
                </div>
            @else
                <div class="bg-blue-50 border-l-4 border-blue-400 text-blue-700 p-4 rounded-md">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p>No hay solicitudes que coincidan con los criterios de búsqueda.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- SECCIÓN DE ESTUDIANTES PENDIENTES DE ACTIVACIÓN --}}
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="flex justify-between items-center bg-gray-50 px-5 py-4 border-b">
            <div class="flex items-center text-gray-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                <span class="font-medium">Estudiantes Pendientes de Activación</span>
            </div>
            
            @if(isset($estudiantesPendientes) && !$estudiantesPendientes->isEmpty())
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                    {{ $estudiantesPendientes->count() }} estudiantes
                </span>
            @endif
        </div>
        
        <div class="p-5">
            @if(!isset($estudiantesPendientes) || $estudiantesPendientes->isEmpty())
                <div class="text-center py-10 px-4">
                    <img src="{{ asset('assets/images/empty-state.svg') }}" alt="No hay estudiantes" class="w-32 h-32 mx-auto mb-4 opacity-75" onerror="this.src='https://uxwing.com/wp-content/themes/uxwing/download/education-school/student-icon.png'; this.classList.add('w-24', 'h-24');">
                    <h3 class="text-lg font-medium text-gray-900 mb-1">No hay estudiantes pendientes</h3>
                    <p class="text-gray-500 max-w-md mx-auto">Todos los estudiantes están activados. Cuando nuevos estudiantes se registren, aparecerán aquí para su activación.</p>
                </div>
            @else
                <div class="overflow-x-auto rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estudiante</th>
                                <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Título</th>
                                <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha registro</th>
                                <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($estudiantesPendientes as $estudiante)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-5 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10 relative">
                                                <img class="h-10 w-10 rounded-full object-cover border-2 border-gray-200" 
                                                    src="{{ $estudiante->user->imagen ? asset('storage/' . $estudiante->user->imagen) : asset('assets/images/default-avatar.png') }}" 
                                                    alt="{{ $estudiante->user->nombre }}"
                                                    onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($estudiante->user->nombre) }}&color=7F9CF5&background=EBF4FF'">
                                                <span class="absolute bottom-0 right-0 block h-2.5 w-2.5 rounded-full ring-2 ring-white bg-yellow-400"></span>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $estudiante->user->nombre }}</div>
                                                <div class="text-xs text-gray-500">Pendiente de activación</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-5 py-4 whitespace-nowrap">
                                        @if($estudiante->titulo)
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                {{ $estudiante->titulo->nombre_titulo }}
                                            </span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                Sin título
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $estudiante->user->email }}</div>
                                    </td>
                                    <td class="px-5 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $estudiante->created_at ? $estudiante->created_at->format('d/m/Y H:i') : 'N/A' }}
                                    </td>
                                    <td class="px-5 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            <form action="{{ route('institucion.estudiantes.activar', $estudiante->id) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="bg-green-100 text-green-700 hover:bg-green-200 rounded-lg p-2 transition-colors" title="Activar estudiante">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                </button>
                                            </form>
                                            
                                            <button onclick="mostrarModalEditar({{ $estudiante->id }})" class="bg-blue-100 text-blue-700 hover:bg-blue-200 rounded-lg p-2 transition-colors" title="Editar información académica">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                </svg>
                                            </button>
                                            
                                            <form action="{{ route('institucion.estudiantes.eliminar', $estudiante->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-100 text-red-700 hover:bg-red-200 rounded-lg p-2 transition-colors" 
                                                    onclick="return confirm('¿Estás seguro de que deseas eliminar este estudiante? Esta acción no se puede deshacer.')" title="Eliminar estudiante">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    {{-- Modal para editar estudiante --}}
    <div id="modalEditar" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden overflow-y-auto h-full w-full">
        <div class="relative top-20 mx-auto p-0 border-0 shadow-xl rounded-xl bg-white max-w-md">
            <div class="bg-primary text-white px-6 py-4 rounded-t-xl flex justify-between items-center">
                <h3 class="text-lg font-medium flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                    </svg>
                    Editar Información Académica
                </h3>
                <button type="button" onclick="cerrarModalEditar()" class="text-white hover:text-gray-200 transition-colors">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            
            <div id="modalContent" class="p-6">
                <p class="text-sm text-gray-600 mb-4">Actualiza la información académica de este estudiante pendiente de activación.</p>
                
                <form id="formEditar" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-5">
                        <label class="block text-gray-700 text-sm font-medium mb-2" for="titulo_id">
                            Título académico
                        </label>
                        <div class="relative">
                            <select name="titulo_id" id="titulo_id" class="block w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-primary focus:border-primary appearance-none">
                                @if(isset($titulos))
                                    <option value="">Seleccionar título...</option>
                                    @foreach($titulos as $titulo)
                                        <option value="{{ $titulo->id }}">{{ $titulo->nombre_titulo }}</option>
                                    @endforeach
                                @endif
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </div>
                        <p class="mt-1 text-xs text-gray-500">Este título aparecerá en el perfil del estudiante.</p>
                    </div>
                    
                    <div class="flex justify-end space-x-3 mt-8">
                        <button type="button" onclick="cerrarModalEditar()" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                            Cancelar
                        </button>
                        <button type="submit" class="px-4 py-2 border border-transparent rounded-lg text-white bg-primary hover:bg-primary-dark transition-colors flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Guardar cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script>
        function mostrarModalEditar(id) {
            // Mostrar el modal
            document.getElementById('modalEditar').classList.remove('hidden');
            // Establecer la acción del formulario
            document.getElementById('formEditar').action = `/institucion/estudiantes/${id}/actualizar`;
            
            // Añadir clase al body para evitar el scroll
            document.body.classList.add('overflow-hidden');
            
            // Efecto de entrada suave
            const modal = document.querySelector('#modalContent');
            modal.classList.add('animate-fadeIn');
        }

        function cerrarModalEditar() {
            // Ocultar el modal con transición
            const modal = document.getElementById('modalEditar');
            modal.classList.add('animate-fadeOut');
            
            // Después de la animación, ocultar completamente
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('animate-fadeOut');
                document.body.classList.remove('overflow-hidden');
            }, 200);
        }
        
        // Cerrar al hacer clic fuera del modal
        document.getElementById('modalEditar').addEventListener('click', function(e) {
            if (e.target === this) {
                cerrarModalEditar();
            }
        });
    </script>
    
    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes fadeOut {
            from { opacity: 1; transform: translateY(0); }
            to { opacity: 0; transform: translateY(-10px); }
        }
        
        .animate-fadeIn {
            animation: fadeIn 0.2s ease-out forwards;
        }
        
        .animate-fadeOut {
            animation: fadeOut 0.2s ease-out forwards;
        }
    </style>

    <script>
        function mostrarModalEditar(id) {
            document.getElementById('modalEditar').classList.remove('hidden');
            document.getElementById('formEditar').action = `/institucion/estudiantes/${id}/actualizar`;
        }

        function cerrarModalEditar() {
            document.getElementById('modalEditar').classList.add('hidden');
        }
    </script>
</div>
@endsection 