@extends('layouts.institucion')

@section('title', 'Asignar Estudiantes a Clase')

@section('content')
<div class="bg-gray-50 p-6 rounded-xl shadow-sm">
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Asignar Estudiantes: {{ $clase->nombre }}</h1>
                <div class="flex items-center text-sm text-gray-500 mt-1">
                    <a href="{{ route('institucion.dashboard') }}" class="hover:text-primary">Dashboard</a>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mx-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                    <a href="{{ route('institucion.clases.index') }}" class="hover:text-primary">Clases</a>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mx-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                    <span>Asignar Estudiantes</span>
                </div>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('institucion.clases.show', $clase->id) }}" class="bg-gray-100 text-gray-700 hover:bg-gray-200 py-2 px-4 rounded-lg flex items-center transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12" />
            </svg>
                    Volver a detalles
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

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Información de la clase --}}
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
                Información de la Clase
            </h2>
            
            <div class="space-y-3 mb-5">
                <div class="flex items-start">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div>
                        <p class="text-xs text-gray-500">Código</p>
                        <p class="text-sm font-medium text-gray-800">{{ $clase->codigo }}</p>
                    </div>
                </div>
                
                <div class="flex items-start">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    <div>
                        <p class="text-xs text-gray-500">Departamento</p>
                        <p class="text-sm font-medium text-gray-800">{{ $clase->departamento->nombre ?? 'Sin departamento' }}</p>
        </div>
    </div>

                <div class="flex items-start">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <div>
                        <p class="text-xs text-gray-500">Docente</p>
                        <p class="text-sm font-medium {{ $clase->docente ? 'text-gray-800' : 'text-red-500' }}">
                            {{ $clase->docente ? $clase->docente->user->nombre : 'Sin asignar' }}
                        </p>
                    </div>
                </div>
                
                <div class="flex items-start">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                    <div>
                        <p class="text-xs text-gray-500">Categoría</p>
                        <p class="text-sm font-medium text-gray-800">{{ $clase->categoria->nombre_categoria ?? 'Sin categoría' }}</p>
                    </div>
                </div>
            </div>
            
            <div class="border-t pt-4 border-b pb-4 mb-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <p class="text-sm font-medium text-gray-700">Estudiantes en la clase</p>
                    </div>
                    <span class="bg-primary text-white text-sm font-medium py-1 px-2 rounded-full">{{ $clase->estudiantes->count() }}</span>
                </div>
                
                @if($clase->capacidad)
                <div class="mt-3">
                    <div class="flex items-center justify-between text-xs text-gray-600 mb-1">
                        <span>{{ $clase->estudiantes->count() }} / {{ $clase->capacidad }}</span>
                        <span>{{ number_format(($clase->estudiantes->count() / $clase->capacidad) * 100, 0) }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-primary h-2 rounded-full" style="width: {{ min(100, ($clase->estudiantes->count() / $clase->capacidad) * 100) }}%"></div>
                    </div>
                </div>
                @endif
            </div>
            
            {{-- Estudiantes asignados a la clase --}}
            <h3 class="text-md font-medium text-gray-700 mb-3">Estudiantes Actuales</h3>
            
            @if($clase->estudiantes->isEmpty())
                <div class="bg-yellow-50 rounded-lg p-3">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-yellow-700">
                                No hay estudiantes asignados a esta clase. Utiliza el formulario para añadir estudiantes.
                            </p>
                        </div>
                    </div>
                </div>
            @else
                <div class="space-y-2 max-h-96 overflow-y-auto pr-2">
                    @foreach($clase->estudiantes->sortBy('user.nombre') as $estudiante)
                        <div class="flex items-center justify-between bg-gray-50 p-2 rounded-lg hover:bg-gray-100 transition-colors">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-8 w-8 relative">
                                    <img class="h-8 w-8 rounded-full object-cover border border-gray-200" 
                                        src="{{ $estudiante->user->imagen ? asset('storage/' . $estudiante->user->imagen) : asset('assets/images/default-avatar.png') }}" 
                                        alt="{{ $estudiante->user->nombre }}"
                                        onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($estudiante->user->nombre) }}&color=7F9CF5&background=EBF4FF'">
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">{{ $estudiante->user->nombre }}</p>
                                    <p class="text-xs text-gray-500">
                                        @if($estudiante->categoria)
                                            {{ $estudiante->categoria->nombre_categoria }}
                                        @else
                                            Sin categoría
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <form action="{{ route('institucion.clases.eliminar-estudiante', ['id' => $clase->id, 'estudianteId' => $estudiante->id]) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 p-1" title="Eliminar de la clase"
                                    onclick="return confirm('¿Estás seguro de que deseas eliminar a este estudiante de la clase?')">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Lista de estudiantes para asignar --}}
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    Estudiantes Disponibles
                </h2>
                
                {{-- Filtros de búsqueda --}}
                <div class="mb-4">
                    <form action="{{ route('institucion.clases.asignar-estudiantes', $clase->id) }}" method="GET" class="space-y-3">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Buscar</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                    </div>
                                    <input type="text" class="block w-full border border-gray-300 rounded-lg pl-10 px-4 py-2 focus:ring-primary focus:border-primary" 
                                        id="search" name="search" value="{{ request('search') }}" placeholder="Nombre o email">
                                </div>
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
                        
                        <div class="flex items-center justify-end space-x-3">
                            <a href="{{ route('institucion.clases.asignar-estudiantes', $clase->id) }}" class="flex items-center justify-center bg-gray-100 hover:bg-gray-200 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg px-4 py-2 transition-colors duration-300 text-gray-800 text-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                                <span>Reiniciar</span>
                            </a>
                            
                            <button type="submit" class="bg-primary hover:bg-primary-dark focus:ring-4 focus:ring-primary/30 text-white font-medium rounded-lg px-4 py-2 transition-colors duration-300 text-sm">
                                <div class="flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                    <span>Filtrar</span>
                                </div>
                            </button>
                        </div>
                    </form>
                </div>
                
                {{-- Formulario de asignación de estudiantes --}}
                <form action="{{ route('institucion.clases.guardar-estudiantes', $clase->id) }}" method="POST">
                    @csrf
                    
                    @if($estudiantesDisponibles->isEmpty())
                        <div class="bg-gray-50 rounded-lg p-8 text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                            <h3 class="text-lg font-medium text-gray-900 mb-1">No hay estudiantes disponibles</h3>
                            <p class="text-gray-500 max-w-md mx-auto mb-6">
                                No se encontraron estudiantes que cumplan con los criterios de búsqueda o todos los estudiantes ya están asignados a esta clase.
                            </p>
                            <a href="{{ route('institucion.estudiantes.index') }}" class="bg-primary hover:bg-primary-dark text-white py-2 px-4 rounded-lg inline-flex items-center transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                                Ver todos los estudiantes
                            </a>
                        </div>
                    @else
                        <div class="border rounded-lg overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            <div class="flex items-center">
                                                <input id="seleccionar-todos" type="checkbox" class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded"
                                                    onchange="seleccionarTodos(this)">
                                                <label for="seleccionar-todos" class="ml-2">Seleccionar</label>
                                            </div>
                                        </th>
                                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estudiante</th>
                                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Categoría</th>
                                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                            </tr>
                        </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($estudiantesDisponibles as $estudiante)
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            <td class="px-4 py-3 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <input id="estudiante-{{ $estudiante->id }}" name="estudiantes[]" value="{{ $estudiante->id }}" type="checkbox" 
                                                        class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded estudiante-checkbox">
                                                </div>
                                    </td>
                                            <td class="px-4 py-3 whitespace-nowrap">
                                        <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-8 w-8 relative">
                                                        <img class="h-8 w-8 rounded-full object-cover border border-gray-200" 
                                                            src="{{ $estudiante->user->imagen ? asset('storage/' . $estudiante->user->imagen) : asset('assets/images/default-avatar.png') }}" 
                                                            alt="{{ $estudiante->user->nombre }}"
                                                            onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($estudiante->user->nombre) }}&color=7F9CF5&background=EBF4FF'">
                                            </div>
                                                    <div class="ml-3">
                                                        <label for="estudiante-{{ $estudiante->id }}" class="text-sm font-medium text-gray-900 cursor-pointer">{{ $estudiante->user->nombre }}</label>
                                            </div>
                                        </div>
                                    </td>
                                            <td class="px-4 py-3 whitespace-nowrap">
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
                                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                        {{ $estudiante->user->email }}
                                    </td>
                                            <td class="px-4 py-3 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $estudiante->estado == 'activo' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                    {{ ucfirst($estudiante->estado) }}
                                                </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                        
                        <div class="mt-6 flex justify-end">
                            <button type="submit" class="bg-primary hover:bg-primary-dark focus:ring-4 focus:ring-primary/30 text-white font-medium rounded-lg px-5 py-2.5 transition-colors duration-300 flex items-center" id="btn-asignar">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                                Asignar Estudiantes Seleccionados
                            </button>
            </div>
        @endif
                </form>
                
                {{-- Paginación --}}
                <div class="mt-6">
                    {{ $estudiantesDisponibles->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function seleccionarTodos(source) {
        const checkboxes = document.getElementsByClassName('estudiante-checkbox');
        for (let i = 0; i < checkboxes.length; i++) {
            checkboxes[i].checked = source.checked;
        }
        actualizarBotonAsignar();
    }
    
    function actualizarBotonAsignar() {
        const checkboxes = document.getElementsByClassName('estudiante-checkbox');
        const btnAsignar = document.getElementById('btn-asignar');
        
        if (!btnAsignar) return;
        
        let seleccionados = 0;
        for (let i = 0; i < checkboxes.length; i++) {
            if (checkboxes[i].checked) {
                seleccionados++;
            }
        }
        
        if (seleccionados > 0) {
            btnAsignar.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Asignar ${seleccionados} Estudiante${seleccionados !== 1 ? 's' : ''} Seleccionado${seleccionados !== 1 ? 's' : ''}
            `;
        } else {
            btnAsignar.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Asignar Estudiantes Seleccionados
            `;
        }
    }
    
    // Actualizar botón cuando se cambia algún checkbox
    document.addEventListener('DOMContentLoaded', function() {
        const checkboxes = document.getElementsByClassName('estudiante-checkbox');
        for (let i = 0; i < checkboxes.length; i++) {
            checkboxes[i].addEventListener('change', actualizarBotonAsignar);
        }
    });
</script>
@endsection 