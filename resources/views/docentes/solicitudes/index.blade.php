@extends('layouts.docente')

@section('title', 'Gestión de Solicitudes')

@section('content')
<div class="bg-gray-50 p-6 rounded-xl shadow-sm">
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-6 border-b pb-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Solicitudes de Estudiantes</h1>
            <div class="flex items-center text-sm text-gray-500 mt-1">
                <a href="{{ route('docente.dashboard') }}" class="hover:text-primary">Dashboard</a>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mx-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
                <span>Solicitudes</span>
            </div>
        </div>
        
        <div class="mt-4 md:mt-0">
            <span class="text-sm text-gray-600">Última actualización: {{ now()->format('d/m/Y H:i') }}</span>
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
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <div class="bg-white rounded-xl shadow-sm p-6 border border-l-4 border-l-blue-500 hover:shadow-md transition-all">
            <div class="flex justify-between items-center">
                <div>
                    <div class="text-4xl font-bold text-gray-800">{{ $stats['total'] }}</div>
                    <div class="text-sm font-medium text-gray-500 mt-1">Total Solicitudes</div>
                </div>
                <div class="bg-blue-100 p-3 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm p-6 border border-l-4 border-l-yellow-500 hover:shadow-md transition-all">
            <div class="flex justify-between items-center">
                <div>
                    <div class="text-4xl font-bold text-gray-800">{{ $stats['pendientes'] }}</div>
                    <div class="text-sm font-medium text-gray-500 mt-1">Pendientes</div>
                </div>
                <div class="bg-yellow-100 p-3 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            @if($stats['pendientes'] > 0)
            <div class="mt-4">
                <a href="{{ route('docente.solicitudes.index', ['estado' => 'pendiente']) }}" class="inline-flex items-center text-sm font-medium text-yellow-600 hover:text-yellow-800">
                    Ver detalle <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
            @endif
        </div>
        
        <div class="bg-white rounded-xl shadow-sm p-6 border border-l-4 border-l-green-500 hover:shadow-md transition-all">
            <div class="flex justify-between items-center">
                <div>
                    <div class="text-4xl font-bold text-gray-800">{{ $stats['aprobadas'] }}</div>
                    <div class="text-sm font-medium text-gray-500 mt-1">Aprobadas</div>
                </div>
                <div class="bg-green-100 p-3 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            @if($stats['aprobadas'] > 0)
            <div class="mt-4">
                <a href="{{ route('docente.solicitudes.index', ['estado' => 'aprobada']) }}" class="inline-flex items-center text-sm font-medium text-green-600 hover:text-green-800">
                    Ver detalle <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
            @endif
        </div>
        
        <div class="bg-white rounded-xl shadow-sm p-6 border border-l-4 border-l-red-500 hover:shadow-md transition-all">
            <div class="flex justify-between items-center">
                <div>
                    <div class="text-4xl font-bold text-gray-800">{{ $stats['rechazadas'] }}</div>
                    <div class="text-sm font-medium text-gray-500 mt-1">Rechazadas</div>
                </div>
                <div class="bg-red-100 p-3 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            @if($stats['rechazadas'] > 0)
            <div class="mt-4">
                <a href="{{ route('docente.solicitudes.index', ['estado' => 'rechazada']) }}" class="inline-flex items-center text-sm font-medium text-red-600 hover:text-red-800">
                    Ver detalle <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
            @endif
        </div>
    </div>

    {{-- Filtros y búsqueda --}}
    <div class="bg-white rounded-xl shadow-sm mb-6 overflow-hidden border border-gray-100">
        <div class="bg-gray-50 px-6 py-4 border-b">
            <div class="flex items-center text-gray-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                </svg>
                <span class="font-medium">Filtros</span>
            </div>
        </div>
        <div class="p-6">
            <form action="{{ route('docente.solicitudes.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label for="buscar" class="block text-sm font-medium text-gray-700 mb-1">Buscar por nombre o email</label>
                    <input type="text" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                        id="buscar" name="buscar" value="{{ $busqueda }}" placeholder="Nombre o email del estudiante">
                </div>
                
                <div>
                    <label for="estado" class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
                    <select class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" id="estado" name="estado">
                        <option value="todos" {{ $filtro == 'todos' ? 'selected' : '' }}>Todos</option>
                        <option value="pendiente" {{ $filtro == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                        <option value="aprobada" {{ $filtro == 'aprobada' ? 'selected' : '' }}>Aprobada</option>
                        <option value="rechazada" {{ $filtro == 'rechazada' ? 'selected' : '' }}>Rechazada</option>
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 text-white font-medium rounded-lg px-5 py-2.5 transition-colors duration-300">
                        <div class="flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            <span>Buscar</span>
                        </div>
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Tabla de solicitudes --}}
    <div class="bg-white rounded-xl shadow-sm mb-6 overflow-hidden border border-gray-100">
        <div class="bg-gray-50 px-6 py-4 border-b">
            <div class="flex items-center text-gray-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                </svg>
                <span class="font-medium">Listado de Solicitudes</span>
            </div>
        </div>
        
        <div class="p-6">
            @if($solicitudes->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estudiante</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ciclo/Categoría</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Clase</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($solicitudes as $solicitud)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $solicitud->id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                        <div class="font-medium">{{ $solicitud->estudiante->user->nombre }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $solicitud->estudiante->user->email }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $solicitud->created_at->format('d/m/Y H:i') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($solicitud->estado == 'pendiente')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pendiente</span>
                                        @elseif($solicitud->estado == 'aprobada')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Aprobada</span>
                                        @elseif($solicitud->estado == 'rechazada')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Rechazada</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        @if($solicitud->estudiante->categoria)
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">
                                                {{ $solicitud->estudiante->categoria->nombre_categoria }}
                                            </span>
                                        @else
                                            <span class="text-gray-400">No asignado</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $solicitud->clase ? $solicitud->clase->nombre : 'No asignada' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('docente.solicitudes.show', $solicitud->id) }}" class="bg-blue-100 text-blue-700 hover:bg-blue-200 rounded-lg p-2 transition-colors">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </a>
                                            
                                            @if($solicitud->estado == 'pendiente')
                                                <form action="{{ route('docente.solicitudes.aprobar', $solicitud->id) }}" method="POST" class="inline-flex">
                                                    @csrf
                                                    <button type="submit" class="bg-green-100 text-green-700 hover:bg-green-200 rounded-lg p-2 transition-colors" title="Aprobar">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                        </svg>
                                                    </button>
                                                </form>

                                                <form action="{{ route('docente.solicitudes.rechazar', $solicitud->id) }}" method="POST" class="inline-flex">
                                                    @csrf
                                                    <button type="submit" class="bg-red-100 text-red-700 hover:bg-red-200 rounded-lg p-2 transition-colors" title="Rechazar">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Paginación --}}
                <div class="mt-6">
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
</div>
@endsection 