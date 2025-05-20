@extends('layouts.institucion')

@section('title', 'Gestión de Estudiantes')

@section('content')
<div class="bg-gray-50 p-6 rounded-xl shadow-sm">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Estudiantes</h1>
        <div class="flex items-center text-sm text-gray-500 mt-1">
            <a href="{{ route('institucion.dashboard') }}" class="hover:text-primary">Dashboard</a>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mx-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <span>Estudiantes</span>
        </div>
        <div class="text-sm text-gray-600 mt-2">
            Última actualización: {{ now()->format('d/m/Y H:i') }}
        </div>
    </div>

    {{-- Mostrar alertas --}}
    {{-- Comentado para evitar duplicidad con los mensajes del layout
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
    --}}

    {{-- Filtros y búsqueda --}}
    <div class="bg-white rounded-xl shadow-sm mb-6 overflow-hidden">
        <div class="bg-gray-50 px-5 py-4 border-b">
            <div class="flex items-center text-gray-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                </svg>
                <span class="font-medium">Filtros y Búsqueda</span>
            </div>
        </div>
        <div class="p-5">
            <form action="{{ route('institucion.estudiantes.index') }}" method="GET" class="space-y-4">
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
                            <option value="" {{ $filtro == 'todos' ? 'selected' : '' }}>Todos los estados</option>
                            <option value="activo" {{ $filtro == 'activo' ? 'selected' : '' }}>Activo</option>
                            <option value="pendiente" {{ $filtro == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                        </select>
                    </div>
                    
                    <div>
                        <label for="categoria_id" class="block text-sm font-medium text-gray-700 mb-1">Categoría</label>
                        <select class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-primary focus:border-primary" id="categoria_id" name="categoria_id">
                            <option value="">Todas las categorías</option>
                            @foreach($categorias as $categoria)
                                <option value="{{ $categoria->id }}" {{ request('categoria_id') == $categoria->id ? 'selected' : '' }}>
                                    {{ $categoria->nombre_categoria }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="clase_id" class="block text-sm font-medium text-gray-700 mb-1">Clase</label>
                        <select class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-primary focus:border-primary" id="clase_id" name="clase_id">
                            <option value="">Todas las clases</option>
                            @foreach($clases as $clase)
                                <option value="{{ $clase->id }}" {{ request('clase_id') == $clase->id ? 'selected' : '' }}>
                                    {{ $clase->nombre }} ({{ $clase->departamento->nombre ?? 'Sin departamento' }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="flex items-end">
                        <div class="flex space-x-3 w-full justify-end">
                            <a href="{{ route('institucion.estudiantes.index') }}" class="flex items-center justify-center bg-gray-100 hover:bg-gray-200 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg px-5 py-2.5 transition-colors duration-300 text-gray-800">
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
                </div>
            </form>
        </div>
    </div>

    {{-- Tabla de estudiantes --}}
    <div class="bg-white rounded-xl shadow-sm mb-8 overflow-hidden">
        <div class="bg-gray-50 px-5 py-4 border-b">
            <div class="flex items-center justify-between">
                <div class="flex items-center text-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                    </svg>
                    <span class="font-medium">Listado de Estudiantes</span>
                </div>
                <a href="{{ route('institucion.estudiantes.pendientes') }}" class="bg-yellow-100 hover:bg-yellow-200 text-yellow-800 font-medium py-1.5 px-3 rounded-lg text-sm flex items-center transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Ver pendientes ({{ $stats['pendientes'] }})
                </a>
            </div>
        </div>
        
        <div class="p-5">
            @if($estudiantes->count() > 0)
                <div class="overflow-x-auto rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estudiante</th>
                                <th scope="col" class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Categoría</th>
                                <th scope="col" class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                <th scope="col" class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                                <th scope="col" class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Clases</th>
                                <th scope="col" class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($estudiantes as $estudiante)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-5 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10 relative">
                                                <img class="h-10 w-10 rounded-full object-cover border-2 border-gray-200" 
                                                    src="{{ $estudiante->user->imagen ? asset('storage/' . $estudiante->user->imagen) : asset('assets/images/default-avatar.png') }}" 
                                                    alt="{{ $estudiante->user->nombre }}"
                                                    onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($estudiante->user->nombre) }}&color=7F9CF5&background=EBF4FF'">
                                                <span class="absolute bottom-0 right-0 block h-2.5 w-2.5 rounded-full ring-2 ring-white {{ $estudiante->estado == 'activo' ? 'bg-green-400' : 'bg-yellow-400' }}"></span>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $estudiante->user->nombre }}</div>
                                                <div class="text-xs text-gray-500">Fecha alta: {{ $estudiante->created_at->format('d/m/Y') }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-5 py-4 whitespace-nowrap">
                                        @if($estudiante->categoria)
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                {{ $estudiante->categoria->nombre_categoria }}
                                            </span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                Sin categoría
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $estudiante->user->email }}
                                    </td>
                                    <td class="px-5 py-4 whitespace-nowrap">
                                        @if($estudiante->estado == 'activo')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Activo
                                            </span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                Pendiente
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-4 whitespace-nowrap">
                                        @if($estudiante->clases->count() > 0)
                                            <div class="flex flex-wrap -space-x-1">
                                                @foreach($estudiante->clases->take(3) as $clase)
                                                    <div class="h-6 w-6 rounded-full bg-primary text-white flex items-center justify-center text-xs font-bold border border-white" title="{{ $clase->nombre }}">
                                                        {{ strtoupper(substr($clase->nombre, 0, 1)) }}
                                                    </div>
                                                @endforeach
                                                
                                                @if($estudiante->clases->count() > 3)
                                                    <div class="h-6 w-6 rounded-full bg-gray-200 text-gray-700 flex items-center justify-center text-xs font-bold border border-white">
                                                        +{{ $estudiante->clases->count() - 3 }}
                                                    </div>
                                                @endif
                                            </div>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                Sin clase
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('institucion.estudiantes.show', $estudiante->id) }}" class="bg-blue-100 text-blue-700 hover:bg-blue-200 rounded-lg p-2 transition-colors" title="Ver detalles">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </a>
                                            
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
                                                class="bg-yellow-100 text-yellow-700 hover:bg-yellow-200 rounded-lg p-2 transition-colors" 
                                                title="Editar estudiante">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Paginación --}}
                <div class="mt-5">
                    {{ $estudiantes->appends(request()->query())->links() }}
                </div>
            @else
                <div class="text-center py-10 px-4">
                    <img src="{{ asset('assets/images/empty-state.svg') }}" alt="No hay estudiantes" class="w-32 h-32 mx-auto mb-4 opacity-75" onerror="this.src='https://uxwing.com/wp-content/themes/uxwing/download/education-school/student-icon.png'; this.classList.add('w-24', 'h-24');">
                    <h3 class="text-lg font-medium text-gray-900 mb-1">No hay estudiantes</h3>
                    <p class="text-gray-500 max-w-md mx-auto">No se encontraron estudiantes con los criterios de búsqueda actuales. Prueba a cambiar los filtros o espera a que nuevos estudiantes se registren.</p>
                </div>
            @endif
        </div>
    </div>
    
    {{-- Modal de edición de estudiante --}}
    @include('institucion.estudiantes.components.edit-modal')
</div>
@endsection 