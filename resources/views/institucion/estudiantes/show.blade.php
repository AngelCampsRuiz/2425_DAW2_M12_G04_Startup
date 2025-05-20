@extends('layouts.institucion')

@section('title', 'Detalle de Estudiante')

@section('content')
<div class="bg-gray-50 p-6 rounded-xl shadow-sm">
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Detalle de Estudiante</h1>
                <div class="flex items-center text-sm text-gray-500 mt-1">
                    <a href="{{ route('institucion.dashboard') }}" class="hover:text-primary">Dashboard</a>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mx-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                    <a href="{{ route('institucion.estudiantes.index') }}" class="hover:text-primary">Estudiantes</a>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mx-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                    <span>{{ $estudiante->user->nombre }}</span>
                </div>
            </div>
            <div class="flex space-x-2">
                <button type="button"
                    onclick="abrirModalEditarEstudiante(
                        '{{ $estudiante->id }}', 
                        '{{ $estudiante->user->nombre }}', 
                        '{{ $estudiante->user->email }}', 
                        '{{ $estudiante->user->telefono }}', 
                        '{{ $estudiante->user->dni }}',
                        '{{ $estudiante->user->fecha_nacimiento ? $estudiante->user->fecha_nacimiento->format('Y-m-d') : '' }}',
                        '{{ $estudiante->user->ciudad }}',
                        '{{ $estudiante->user->direccion }}',
                        '{{ $estudiante->categoria_id }}',
                        '{{ addslashes($estudiante->conocimientos_previos) }}',
                        '{{ addslashes($estudiante->intereses) }}'
                    )" 
                    class="bg-yellow-100 text-yellow-700 hover:bg-yellow-200 py-2 px-4 rounded-lg flex items-center transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Editar estudiante
                </button>
                <a href="{{ route('institucion.estudiantes.index') }}" class="bg-gray-100 text-gray-700 hover:bg-gray-200 py-2 px-4 rounded-lg flex items-center transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12" />
                    </svg>
                    Volver
                </a>
            </div>
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

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        {{-- Información personal --}}
        <div class="bg-white rounded-xl shadow-sm p-6 col-span-1">
            <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                Información Personal
            </h2>
            
            <div class="flex flex-col items-center mb-6">
                <div class="relative mb-4">
                    <img src="{{ $estudiante->user->imagen ? asset('storage/' . $estudiante->user->imagen) : asset('assets/images/default-avatar.png') }}" 
                        alt="{{ $estudiante->user->nombre }}" 
                        class="w-32 h-32 rounded-full object-cover border-4 border-gray-200"
                        onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($estudiante->user->nombre) }}&size=128&color=7F9CF5&background=EBF4FF'">
                    <span class="absolute bottom-1 right-1 h-5 w-5 rounded-full bg-{{ $estudiante->estado == 'activo' ? 'green' : 'yellow' }}-400 border-2 border-white"></span>
                </div>
                <h3 class="text-xl font-bold text-gray-800">{{ $estudiante->user->nombre }}</h3>
                <p class="text-sm text-gray-500">Estudiante {{ ucfirst($estudiante->estado) }}</p>
                <div class="mt-2 flex flex-wrap justify-center">
                    @if($estudiante->categoria)
                        <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded-full dark:bg-blue-200 dark:text-blue-800 mt-1">
                            {{ $estudiante->categoria->nombre_categoria }}
                        </span>
                    @endif
                </div>
            </div>
            
            <div class="space-y-3 border-t pt-4">
                <div class="flex items-start">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 mr-3 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    <div>
                        <p class="text-xs text-gray-500">Email</p>
                        <p class="text-sm text-gray-800">{{ $estudiante->user->email }}</p>
                    </div>
                </div>
                
                <div class="flex items-start">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 mr-3 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <div>
                        <p class="text-xs text-gray-500">Fecha de Alta</p>
                        <p class="text-sm text-gray-800">{{ $estudiante->created_at->format('d/m/Y') }}</p>
                    </div>
                </div>
                
                @if($estudiante->user->telefono)
                <div class="flex items-start">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 mr-3 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                    <div>
                        <p class="text-xs text-gray-500">Teléfono</p>
                        <p class="text-sm text-gray-800">{{ $estudiante->user->telefono }}</p>
                    </div>
                </div>
                @endif
                
                @if($estudiante->user->direccion)
                <div class="flex items-start">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 mr-3 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <div>
                        <p class="text-xs text-gray-500">Dirección</p>
                        <p class="text-sm text-gray-800">{{ $estudiante->user->direccion }}</p>
                    </div>
                </div>
                @endif
            </div>
        </div>
        
        {{-- Información académica y asignación de clases --}}
        <div class="col-span-1 md:col-span-2 space-y-6">
            {{-- Información académica --}}
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path d="M12 14l9-5-9-5-9 5 9 5z" />
                        <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
                    </svg>
                    Información Académica
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-xs text-gray-500">Categoría Académica</p>
                        <p class="text-sm font-medium text-gray-800">
                            @if($estudiante->categoria)
                                {{ $estudiante->categoria->nombre_categoria }}
                            @else
                                <span class="text-red-500">Sin categoría asignada</span>
                            @endif
                        </p>
                    </div>
                    
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-xs text-gray-500">Estado Académico</p>
                        <p class="text-sm font-medium text-gray-800">
                            <span class="px-2 py-1 rounded-full text-xs text-white bg-{{ $estudiante->estado == 'activo' ? 'green' : 'yellow' }}-500">
                                {{ ucfirst($estudiante->estado) }}
                            </span>
                        </p>
                    </div>
                </div>
                
                @if($estudiante->conocimientos_previos || $estudiante->intereses)
                <div class="mt-4 space-y-4">
                    @if($estudiante->conocimientos_previos)
                    <div>
                        <h3 class="text-sm font-medium text-gray-700 mb-1">Conocimientos Previos</h3>
                        <p class="text-sm text-gray-600 bg-gray-50 p-3 rounded-lg">{{ $estudiante->conocimientos_previos }}</p>
                    </div>
                    @endif
                    
                    @if($estudiante->intereses)
                    <div>
                        <h3 class="text-sm font-medium text-gray-700 mb-1">Intereses</h3>
                        <p class="text-sm text-gray-600 bg-gray-50 p-3 rounded-lg">{{ $estudiante->intereses }}</p>
                    </div>
                    @endif
                </div>
                @endif
            </div>
            
            {{-- Clases asignadas --}}
            <div class="bg-white rounded-xl shadow-sm p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        Clases Asignadas
                    </h2>
                    @if($estudiante->clases->count() == 0)
                    <button type="button" onclick="mostrarModalAsignarClase()" class="bg-primary hover:bg-primary-dark text-white py-1.5 px-3 rounded-lg text-sm flex items-center transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Asignar Clase
                    </button>
                    @elseif($clasesDisponibles->count() > 0)
                    <button type="button" onclick="mostrarModalAsignarClase()" class="bg-blue-100 text-blue-700 hover:bg-blue-200 py-1.5 px-3 rounded-lg text-sm flex items-center transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Asignar otra clase
                    </button>
                    @endif
                </div>
                
                @if($estudiante->clases->count() > 0)
                    <div class="overflow-x-auto rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Clase</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Departamento</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Docente</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha Asignación</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($estudiante->clases as $clase)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $clase->nombre }}</div>
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            <div class="text-sm text-gray-500">{{ $clase->departamento->nombre ?? 'Sin departamento' }}</div>
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            <div class="flex items-center">
                                                @if($clase->docente)
                                                    <div class="flex-shrink-0 h-8 w-8">
                                                        <img class="h-8 w-8 rounded-full object-cover" 
                                                            src="{{ $clase->docente->user->imagen ? asset('storage/' . $clase->docente->user->imagen) : asset('assets/images/default-avatar.png') }}" 
                                                            alt="{{ $clase->docente->user->nombre ?? 'Docente' }}"
                                                            onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($clase->docente->user->nombre ?? 'Docente') }}&color=7F9CF5&background=EBF4FF'">
                                                    </div>
                                                    <div class="ml-3">
                                                        <div class="text-sm font-medium text-gray-900">{{ $clase->docente->user->nombre }}</div>
                                                    </div>
                                                @else
                                                    <span class="text-sm text-red-500">Sin docente asignado</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                            {{ $clase->pivot->fecha_asignacion ? \Carbon\Carbon::parse($clase->pivot->fecha_asignacion)->format('d/m/Y') : 'N/A' }}
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm font-medium">
                                            <form action="{{ route('institucion.estudiantes.eliminar-clase', ['id' => $estudiante->id, 'claseId' => $clase->id]) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-100 text-red-700 hover:bg-red-200 rounded-lg p-2 transition-colors" 
                                                    onclick="return confirm('¿Estás seguro de que deseas eliminar esta asignación de clase?')"
                                                    title="Eliminar asignación">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-md">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-yellow-700">
                                    El estudiante no está asignado a ninguna clase. Utiliza el botón "Asignar Clase" para añadirlo a una clase.
                                </p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- Modal para asignar clase --}}
<div id="modalAsignarClase" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden overflow-y-auto h-full w-full">
    <div class="relative top-20 mx-auto p-0 border-0 shadow-xl rounded-xl bg-white max-w-md">
        <div class="bg-primary text-white px-6 py-4 rounded-t-xl flex justify-between items-center">
            <h3 class="text-lg font-medium flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path d="M12 14l9-5-9-5-9 5 9 5z" />
                    <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                </svg>
                Asignar a Clase
            </h3>
            <button type="button" onclick="cerrarModalAsignarClase()" class="text-white hover:text-gray-200 transition-colors">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        
        <div class="p-6">
            <form action="{{ route('institucion.estudiantes.asignar-clase', $estudiante->id) }}" method="POST">
                @csrf
                
                <div class="mb-5">
                    <label class="block text-gray-700 text-sm font-medium mb-2" for="clase_id">
                        Selecciona una clase
                    </label>
                    <div class="relative">
                        <select name="clase_id" id="clase_id" class="block w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-primary focus:border-primary appearance-none" required>
                            <option value="">Seleccionar clase...</option>
                            @foreach($clasesDisponibles as $clase)
                                <option value="{{ $clase->id }}">
                                    {{ $clase->nombre }} 
                                    @if($clase->departamento) 
                                        - {{ $clase->departamento->nombre }}
                                    @endif
                                    @if($clase->docente)
                                        ({{ $clase->docente->user->nombre }})
                                    @else
                                        (Sin docente)
                                    @endif
                                </option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                    @if($clasesDisponibles->isEmpty())
                        <p class="mt-2 text-sm text-red-600">
                            No hay clases disponibles para asignar. El estudiante ya está asignado a todas las clases existentes.
                        </p>
                    @endif
                </div>
                
                <div class="flex justify-end space-x-3 mt-8">
                    <button type="button" onclick="cerrarModalAsignarClase()" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                        Cancelar
                    </button>
                    <button type="submit" class="px-4 py-2 border border-transparent rounded-lg text-white bg-primary hover:bg-primary-dark transition-colors flex items-center"
                        {{ $clasesDisponibles->isEmpty() ? 'disabled' : '' }}>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Asignar Clase
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function mostrarModalAsignarClase() {
        document.getElementById('modalAsignarClase').classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function cerrarModalAsignarClase() {
        document.getElementById('modalAsignarClase').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }
    
    // Cerrar modal al hacer clic fuera
    document.getElementById('modalAsignarClase').addEventListener('click', function(e) {
        if (e.target === this) {
            cerrarModalAsignarClase();
        }
    });
</script>

{{-- Modal de edición de estudiante --}}
@include('institucion.estudiantes.components.edit-modal')
@endsection 