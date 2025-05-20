@extends('layouts.institucion')

@section('title', 'Gestión de Clases')

@section('content')
<div class="bg-white">
    <!-- Cabecera y botones de acción -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
        <div>
            <h2 class="text-xl font-semibold text-gray-800">Listado de Clases</h2>
            <p class="text-gray-600 text-sm">Gestiona las clases de tu institución educativa</p>
        </div>
        <div class="mt-4 md:mt-0">
            <a href="javascript:void(0)" onclick="openModalClase()" class="bg-primary hover:bg-primary-dark text-white font-medium py-2 px-4 rounded inline-flex items-center transition-colors">
                <i class="fas fa-plus mr-2"></i> Nueva Clase
            </a>
        </div>
    </div>

    <!-- Tarjetas de estadísticas -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-purple-50 p-4 rounded-lg">
            <h3 class="font-medium text-purple-800 mb-1">Total Clases</h3>
            <p class="text-2xl font-bold text-purple-900">{{ $clases->count() }}</p>
        </div>
        <div class="bg-green-50 p-4 rounded-lg">
            <h3 class="font-medium text-green-800 mb-1">Clases Activas</h3>
            <p class="text-2xl font-bold text-green-900">{{ $clases->where('activa', true)->count() }}</p>
        </div>
        <div class="bg-blue-50 p-4 rounded-lg">
            <h3 class="font-medium text-blue-800 mb-1">Departamentos</h3>
            <p class="text-2xl font-bold text-blue-900">{{ $departamentos->count() ?? 0 }}</p>
        </div>
        <div class="bg-yellow-50 p-4 rounded-lg">
            <h3 class="font-medium text-yellow-800 mb-1">Estudiantes</h3>
            <p class="text-2xl font-bold text-yellow-900">{{ $estudiantes ?? 0 }}</p>
        </div>
    </div>

    <!-- Filtros de búsqueda -->
    <div class="bg-gray-50 p-4 rounded-lg mb-6">
        <div class="flex flex-col md:flex-row gap-4">
            <div class="w-full md:w-1/3">
                <label for="filtro-departamento" class="block text-sm font-medium text-gray-700 mb-1">Departamento</label>
                <select id="filtro-departamento" class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50" onchange="filtrarClases()">
                    <option value="">Todos los departamentos</option>
                    @foreach($departamentos ?? [] as $departamento)
                        <option value="{{ $departamento->id }}">{{ $departamento->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="w-full md:w-1/3">
                <label for="filtro-docente" class="block text-sm font-medium text-gray-700 mb-1">Docente</label>
                <select id="filtro-docente" class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50" onchange="filtrarClases()">
                    <option value="">Todos los docentes</option>
                    @foreach($docentes ?? [] as $docente)
                        <option value="{{ $docente->id }}">{{ $docente->user->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="w-full md:w-1/3">
                <label for="filtro-busqueda" class="block text-sm font-medium text-gray-700 mb-1">Buscar</label>
                <input type="text" id="filtro-busqueda" placeholder="Nombre de la clase..." class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50" oninput="filtrarClases()">
            </div>
        </div>
    </div>

    <!-- Tabla de clases -->
    @if($clases->isEmpty())
        <div class="text-center py-12 bg-gray-50 rounded-lg">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">No hay clases registradas</h3>
            <p class="mt-1 text-sm text-gray-500">Comienza creando tu primera clase.</p>
            <div class="mt-6">
                <a href="javascript:void(0)" onclick="openModalClase()" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary hover:bg-primary-dark">
                    <i class="fas fa-plus mr-2"></i> Nueva clase
                </a>
            </div>
        </div>
    @else
        <div class="overflow-x-auto border rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Clase</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Departamento</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Docente</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estudiantes</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody id="tabla-clases" class="bg-white divide-y divide-gray-200">
                    @foreach($clases as $clase)
                        <tr 
                            data-departamento="{{ $clase->departamento_id ?? '' }}" 
                            data-docente="{{ $clase->docente_id ?? '' }}" 
                            data-nombre="{{ strtolower($clase->nombre) }}" 
                            class="hover:bg-gray-50"
                        >
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $clase->nombre }}</div>
                                <div class="text-sm text-gray-500">{{ $clase->codigo }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    @if($clase->departamento)
                                        <a href="{{ route('institucion.departamentos.show', $clase->departamento_id) }}" class="text-primary hover:text-primary-dark">
                                            {{ $clase->departamento->nombre }}
                                        </a>
                                    @else
                                        <span class="text-gray-500">Sin departamento</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    @if($clase->docente)
                                        <div class="flex-shrink-0 h-8 w-8">
                                            <img class="h-8 w-8 rounded-full" src="https://ui-avatars.com/api/?name={{ urlencode($clase->docente->user->nombre) }}&background=7705B6&color=fff" alt="{{ $clase->docente->user->nombre }}">
                                        </div>
                                        <div class="ml-3">
                                            <div class="text-sm font-medium text-gray-900">
                                                <a href="{{ route('institucion.docentes.show', $clase->docente_id) }}" class="text-primary hover:text-primary-dark">
                                                    {{ $clase->docente->user->nombre }}
                                                </a>
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-gray-500">Sin asignar</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    {{ $clase->estudiantes_count ?? $clase->estudiantes()->count() }} estudiantes
                                </div>
                                @if($clase->capacidad)
                                    <div class="w-32 bg-gray-200 rounded-full h-2.5 mt-1">
                                        @php
                                            $estudiantes = $clase->estudiantes_count ?? $clase->estudiantes()->count();
                                            $porcentaje = min(100, ($estudiantes / $clase->capacidad) * 100);
                                            $colorClase = $porcentaje > 80 ? 'bg-red-600' : ($porcentaje > 50 ? 'bg-yellow-500' : 'bg-green-500');
                                        @endphp
                                        <div class="{{ $colorClase }} h-2.5 rounded-full" style="width: {{ $porcentaje }}%"></div>
                                    </div>
                                    <span class="text-xs text-gray-500">{{ $estudiantes }}/{{ $clase->capacidad }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-2 text-xs leading-5 font-semibold rounded-full {{ $clase->activa ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ $clase->activa ? 'Activa' : 'Inactiva' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center space-x-3">
                                    <a href="{{ route('institucion.clases.show', $clase->id) }}" class="text-blue-600 hover:text-blue-900" title="Ver detalles">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="javascript:void(0)" onclick="openEditarModal({{ $clase->id }})" class="text-indigo-600 hover:text-indigo-900" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('institucion.clases.toggle-active', $clase->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="{{ $clase->activa ? 'text-red-600 hover:text-red-900' : 'text-green-600 hover:text-green-900' }}" title="{{ $clase->activa ? 'Desactivar' : 'Activar' }}">
                                            <i class="fas {{ $clase->activa ? 'fa-ban' : 'fa-check-circle' }}"></i>
                                        </button>
                                    </form>
                                    @if($clase->estudiantes()->count() == 0)
                                        <form action="{{ route('institucion.clases.destroy', $clase->id) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta clase?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900" title="Eliminar">
                                                <i class="fas fa-trash"></i>
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
    @endif
</div>
@endsection

<!-- Modal de Nueva Clase -->
<div id="modalNuevaClase" class="fixed inset-0 bg-black bg-opacity-50 hidden overflow-y-auto h-full w-full z-50 backdrop-blur-sm transition-all duration-300">
    <div class="relative top-20 mx-auto p-0 w-full max-w-4xl transform transition-all duration-300">
        <div class="bg-white rounded-xl shadow-2xl overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 py-4 px-6 flex justify-between items-center">
                <h3 class="text-xl font-bold text-white flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                    Crear Nueva Clase
                </h3>
                <button onclick="closeModalClase()" class="text-white hover:text-gray-200 focus:outline-none transition-colors">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <form id="formNuevaClase" action="{{ route('institucion.clases.store') }}" method="POST" class="p-6">
                @csrf
                
                <!-- Mensajes de error -->
                @if ($errors->any())
                <div class="mb-4 bg-red-50 border-l-4 border-red-500 p-4 rounded">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">Se encontraron los siguientes errores:</h3>
                            <ul class="mt-1 text-xs text-red-700 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                @endif
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <!-- Información básica de la clase -->
                        <div class="mb-5">
                            <h4 class="text-md font-medium text-gray-800 mb-3 flex items-center">
                                <div class="w-8 h-8 flex items-center justify-center bg-blue-100 rounded-full mr-2 text-blue-600">1</div>
                                Información General
                            </h4>
                            <div class="bg-gray-50 p-4 rounded-lg space-y-4">
                                <div>
                                    <label for="nombre" class="block text-sm font-medium text-gray-700 mb-1">Nombre de la Clase *</label>
                                    <input type="text" name="nombre" id="nombre" required 
                                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                        value="{{ old('nombre') }}">
                                    <p class="mt-1 text-xs text-gray-500">Ej: Matemáticas Avanzadas</p>
                                </div>

                                <div>
                                    <label for="codigo" class="block text-sm font-medium text-gray-700 mb-1">Código de la Clase *</label>
                                    <input type="text" name="codigo" id="codigo" required 
                                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                        value="{{ old('codigo') }}">
                                    <p class="mt-1 text-xs text-gray-500">Ej: MAT-101 o MATE2023</p>
                                </div>

                                <div>
                                    <label for="descripcion" class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                                    <textarea name="descripcion" id="descripcion" rows="3" 
                                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">{{ old('descripcion') }}</textarea>
                                    <p class="mt-1 text-xs text-gray-500">Descripción breve de la clase y sus objetivos</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <!-- Información académica de la clase -->
                        <div class="mb-5">
                            <h4 class="text-md font-medium text-gray-800 mb-3 flex items-center">
                                <div class="w-8 h-8 flex items-center justify-center bg-blue-100 rounded-full mr-2 text-blue-600">2</div>
                                Información Académica
                            </h4>
                            <div class="bg-gray-50 p-4 rounded-lg space-y-4">
                                <div>
                                    <label for="departamento_id" class="block text-sm font-medium text-gray-700 mb-1">Departamento</label>
                                    <select name="departamento_id" id="departamento_id"
                                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                        <option value="">-- Seleccionar Departamento --</option>
                                        @foreach($departamentos as $departamento)
                                            <option value="{{ $departamento->id }}">
                                                {{ $departamento->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <p class="mt-1 text-xs text-gray-500">Opcional - Puede asignarlo más tarde</p>
                                </div>

                                <div>
                                    <label for="docente_id" class="block text-sm font-medium text-gray-700 mb-1">Docente Responsable</label>
                                    <select name="docente_id" id="docente_id"
                                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                        <option value="">-- Seleccionar Docente --</option>
                                        @foreach($docentes as $docente)
                                            <option value="{{ $docente->id }}">
                                                {{ $docente->user->nombre }} ({{ $docente->especialidad }})
                                            </option>
                                        @endforeach
                                    </select>
                                    <p class="mt-1 text-xs text-gray-500">Opcional - Puede asignarlo más tarde</p>
                                </div>
                            </div>
                        </div>

                        <!-- Información del curso -->
                        <div class="mb-5">
                            <h4 class="text-md font-medium text-gray-800 mb-3 flex items-center">
                                <div class="w-8 h-8 flex items-center justify-center bg-blue-100 rounded-full mr-2 text-blue-600">3</div>
                                Información del Curso
                            </h4>
                            <div class="bg-gray-50 p-4 rounded-lg space-y-4">
                                <div>
                                    <label for="nivel_educativo_id" class="block text-sm font-medium text-gray-700 mb-1">Nivel *</label>
                                    <select name="nivel_educativo_id" id="nivel_educativo_id" required onchange="actualizarCategorias()"
                                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                        <option value="">-- Seleccionar Nivel --</option>
                                        @foreach($nivelesEducativos as $nivel)
                                            <option value="{{ $nivel->id }}">{{ $nivel->nombre_nivel }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="categoria_id" class="block text-sm font-medium text-gray-700 mb-1">Curso/Ciclo *</label>
                                        <select name="categoria_id" id="categoria_id" required
                                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                            <option value="">-- Seleccionar Curso --</option>
                                            <!-- Las opciones se cargarán dinámicamente con JavaScript -->
                                        </select>
                                        <p class="mt-1 text-xs text-gray-500">Ej: 1º ESO, CFGM, etc.</p>
                                    </div>
                                    
                                    <div>
                                        <label for="grupo" class="block text-sm font-medium text-gray-700 mb-1">Grupo</label>
                                        <input type="text" name="grupo" id="grupo" 
                                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                        <p class="mt-1 text-xs text-gray-500">Ej: A, B, C, etc.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end space-x-3 pt-4 border-t mt-4">
                    <button type="button" onclick="closeModalClase()"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all">
                        Cancelar
                    </button>
                    <button type="submit" id="submitButtonClase"
                            class="px-4 py-2 text-sm font-medium text-white bg-gradient-to-r from-blue-600 to-indigo-600 border border-transparent rounded-lg hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all shadow-lg">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Crear Clase
                        </div>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal de Editar Clase -->
<div id="modalEditarClase" class="fixed inset-0 bg-black bg-opacity-50 hidden overflow-y-auto h-full w-full z-50 backdrop-blur-sm transition-all duration-300">
    <div class="relative top-20 mx-auto p-0 w-full max-w-4xl transform transition-all duration-300">
        <div class="bg-white rounded-xl shadow-2xl overflow-hidden">
            <div class="bg-gradient-to-r from-yellow-500 to-orange-500 py-4 px-6 flex justify-between items-center">
                <h3 class="text-xl font-bold text-white flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Editar Clase
                </h3>
                <button onclick="closeEditarModal()" class="text-white hover:text-gray-200 focus:outline-none transition-colors">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <form id="formEditarClase" action="" method="POST" class="p-6">
                @csrf
                @method('PUT')
                <input type="hidden" id="clase_id" name="clase_id">
                
                <!-- Mensajes de error -->
                <div id="errores-edicion-clase" class="mb-4 bg-red-50 border-l-4 border-red-500 p-4 rounded hidden">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">Se encontraron los siguientes errores:</h3>
                            <ul class="mt-1 text-xs text-red-700 list-disc list-inside" id="lista-errores-edicion-clase">
                            </ul>
                        </div>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <!-- Información básica de la clase -->
                        <div class="mb-5">
                            <h4 class="text-md font-medium text-gray-800 mb-3 flex items-center">
                                <div class="w-8 h-8 flex items-center justify-center bg-yellow-100 rounded-full mr-2 text-yellow-600">1</div>
                                Información General
                            </h4>
                            <div class="bg-gray-50 p-4 rounded-lg space-y-4">
                                <div>
                                    <label for="edit_nombre" class="block text-sm font-medium text-gray-700 mb-1">Nombre de la Clase *</label>
                                    <input type="text" name="nombre" id="edit_nombre" required 
                                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-yellow-500 focus:ring-yellow-500 sm:text-sm">
                                    <p class="mt-1 text-xs text-gray-500">Ej: Matemáticas Avanzadas</p>
                                </div>

                                <div>
                                    <label for="edit_codigo" class="block text-sm font-medium text-gray-700 mb-1">Código de la Clase *</label>
                                    <input type="text" name="codigo" id="edit_codigo" required 
                                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-yellow-500 focus:ring-yellow-500 sm:text-sm">
                                    <p class="mt-1 text-xs text-gray-500">Ej: MAT-101 o MATE2023</p>
                                </div>

                                <div>
                                    <label for="edit_descripcion" class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                                    <textarea name="descripcion" id="edit_descripcion" rows="3" 
                                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-yellow-500 focus:ring-yellow-500 sm:text-sm"></textarea>
                                    <p class="mt-1 text-xs text-gray-500">Descripción breve de la clase y sus objetivos</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <!-- Información académica de la clase -->
                        <div class="mb-5">
                            <h4 class="text-md font-medium text-gray-800 mb-3 flex items-center">
                                <div class="w-8 h-8 flex items-center justify-center bg-yellow-100 rounded-full mr-2 text-yellow-600">2</div>
                                Información Académica
                            </h4>
                            <div class="bg-gray-50 p-4 rounded-lg space-y-4">
                                <div>
                                    <label for="edit_departamento_id" class="block text-sm font-medium text-gray-700 mb-1">Departamento</label>
                                    <select name="departamento_id" id="edit_departamento_id"
                                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-yellow-500 focus:ring-yellow-500 sm:text-sm">
                                        <option value="">-- Seleccionar Departamento --</option>
                                        @foreach($departamentos as $departamento)
                                            <option value="{{ $departamento->id }}">
                                                {{ $departamento->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <p class="mt-1 text-xs text-gray-500">Opcional - Puede asignarlo más tarde</p>
                                </div>

                                <div>
                                    <label for="edit_docente_id" class="block text-sm font-medium text-gray-700 mb-1">Docente Responsable</label>
                                    <select name="docente_id" id="edit_docente_id"
                                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-yellow-500 focus:ring-yellow-500 sm:text-sm">
                                        <option value="">-- Seleccionar Docente --</option>
                                        @foreach($docentes as $docente)
                                            <option value="{{ $docente->id }}">
                                                {{ $docente->user->nombre }} ({{ $docente->especialidad }})
                                            </option>
                                        @endforeach
                                    </select>
                                    <p class="mt-1 text-xs text-gray-500">Opcional - Puede asignarlo más tarde</p>
                                </div>
                            </div>
                        </div>

                        <!-- Información del curso -->
                        <div class="mb-5">
                            <h4 class="text-md font-medium text-gray-800 mb-3 flex items-center">
                                <div class="w-8 h-8 flex items-center justify-center bg-yellow-100 rounded-full mr-2 text-yellow-600">3</div>
                                Información del Curso
                            </h4>
                            <div class="bg-gray-50 p-4 rounded-lg space-y-4">
                                <div>
                                    <label for="edit_nivel_educativo_id" class="block text-sm font-medium text-gray-700 mb-1">Nivel *</label>
                                    <select name="nivel_educativo_id" id="edit_nivel_educativo_id" required onchange="actualizarCategoriasEdit()"
                                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-yellow-500 focus:ring-yellow-500 sm:text-sm">
                                        <option value="">-- Seleccionar Nivel --</option>
                                        @foreach($nivelesEducativos as $nivel)
                                            <option value="{{ $nivel->id }}">{{ $nivel->nombre_nivel }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="edit_categoria_id" class="block text-sm font-medium text-gray-700 mb-1">Curso/Ciclo *</label>
                                        <select name="categoria_id" id="edit_categoria_id" required
                                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-yellow-500 focus:ring-yellow-500 sm:text-sm">
                                            <option value="">-- Seleccionar Curso --</option>
                                            <!-- Las opciones se cargarán dinámicamente con JavaScript -->
                                        </select>
                                        <p class="mt-1 text-xs text-gray-500">Ej: 1º ESO, CFGM, etc.</p>
                                    </div>
                                    
                                    <div>
                                        <label for="edit_grupo" class="block text-sm font-medium text-gray-700 mb-1">Grupo</label>
                                        <input type="text" name="grupo" id="edit_grupo" 
                                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-yellow-500 focus:ring-yellow-500 sm:text-sm">
                                        <p class="mt-1 text-xs text-gray-500">Ej: A, B, C, etc.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end space-x-3 pt-4 border-t mt-4">
                    <button type="button" onclick="closeEditarModal()"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition-all">
                        Cancelar
                    </button>
                    <button type="submit" id="submitButtonEditar"
                            class="px-4 py-2 text-sm font-medium text-white bg-gradient-to-r from-yellow-500 to-orange-500 border border-transparent rounded-lg hover:from-yellow-600 hover:to-orange-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition-all shadow-lg">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Actualizar Clase
                        </div>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Mostrar modal automáticamente si hay errores
    @if ($errors->any())
        document.addEventListener('DOMContentLoaded', function() {
            openModalClase();
        });
    @endif
    
    // Objeto global para almacenar el estado de validación de cada campo
    window.validationErrors = {};

    // Función centralizada para actualizar el estado visual de los campos
    window.updateFieldStatus = function(input, isValid, errorMessage = '') {
        if (!input) return;
        
        const fieldId = input.id;
        let errorElement = document.getElementById(fieldId + '-error');
        
        // Si no existe el elemento de error, lo creamos
        if (!errorElement) {
            errorElement = document.createElement('span');
            errorElement.id = fieldId + '-error';
            errorElement.className = 'text-red-500 text-xs mt-1';
            input.parentNode.appendChild(errorElement);
        }
        
        if (!isValid) {
            window.validationErrors[fieldId] = errorMessage;
            input.classList.add('border-red-500');
            errorElement.textContent = errorMessage;
        } else {
            delete window.validationErrors[fieldId];
            input.classList.remove('border-red-500');
            errorElement.textContent = '';
        }
    };

    // Validaciones para los formularios de clases
    const validateNombre = function(prefix = '') {
        const field = document.getElementById((prefix ? prefix + '_' : '') + 'nombre');
        if (!field) return true;
        
        const value = field.value.trim();
        if (!value) {
            window.updateFieldStatus(field, false, 'El nombre de la clase es obligatorio');
            return false;
        } else if (value.length < 3) {
            window.updateFieldStatus(field, false, 'El nombre debe tener al menos 3 caracteres');
            return false;
        }
        
        window.updateFieldStatus(field, true);
        return true;
    };

    const validateCodigo = function(prefix = '') {
        const field = document.getElementById((prefix ? prefix + '_' : '') + 'codigo');
        if (!field) return true;
        
        const value = field.value.trim();
        if (!value) {
            window.updateFieldStatus(field, false, 'El código de la clase es obligatorio');
            return false;
        } else if (value.length < 2) {
            window.updateFieldStatus(field, false, 'El código debe tener al menos 2 caracteres');
            return false;
        }
        
        window.updateFieldStatus(field, true);
        return true;
    };

    const validateNivelEducativo = function(prefix = '') {
        const field = document.getElementById((prefix ? prefix + '_' : '') + 'nivel_educativo_id');
        if (!field) return true;
        
        const value = field.value.trim();
        if (!value) {
            window.updateFieldStatus(field, false, 'El nivel educativo es obligatorio');
            return false;
        }
        
        window.updateFieldStatus(field, true);
        return true;
    };

    const validateCategoria = function(prefix = '') {
        const field = document.getElementById((prefix ? prefix + '_' : '') + 'categoria_id');
        if (!field) return true;
        
        const value = field.value.trim();
        if (!value) {
            window.updateFieldStatus(field, false, 'El curso/ciclo es obligatorio');
            return false;
        }
        
        window.updateFieldStatus(field, true);
        return true;
    };

    const validateDescripcion = function(prefix = '') {
        const field = document.getElementById((prefix ? prefix + '_' : '') + 'descripcion');
        if (!field) return true;
        
        // La descripción es opcional, pero si tiene texto, debería tener más de 10 caracteres
        const value = field.value.trim();
        if (value && value.length < 10) {
            window.updateFieldStatus(field, false, 'La descripción debe tener al menos 10 caracteres');
            return false;
        }
        
        window.updateFieldStatus(field, true);
        return true;
    };

    // Configurar validaciones para los formularios
    document.addEventListener('DOMContentLoaded', function() {
        // Validaciones para el formulario de creación
        const createForm = document.getElementById('formNuevaClase');
        if (createForm) {
            const fieldsToValidate = [
                { id: 'nombre', validate: validateNombre },
                { id: 'codigo', validate: validateCodigo },
                { id: 'descripcion', validate: validateDescripcion },
                { id: 'nivel_educativo_id', validate: validateNivelEducativo },
                { id: 'categoria_id', validate: validateCategoria }
            ];
            
            // Añadir validaciones onblur
            fieldsToValidate.forEach(field => {
                const element = document.getElementById(field.id);
                if (element) {
                    element.addEventListener('blur', () => field.validate());
                }
            });
            
            // Validar formulario al enviar
            createForm.addEventListener('submit', function(event) {
                const isValid = fieldsToValidate.map(field => field.validate()).every(Boolean);
                
                if (!isValid) {
                    event.preventDefault();
                    alert('Por favor, corrija los errores en el formulario antes de continuar.');
                }
            });
        }
        
        // Validaciones para el formulario de edición
        const editForm = document.getElementById('formEditarClase');
        if (editForm) {
            const fieldsToValidate = [
                { id: 'edit_nombre', validate: () => validateNombre('edit') },
                { id: 'edit_codigo', validate: () => validateCodigo('edit') },
                { id: 'edit_descripcion', validate: () => validateDescripcion('edit') },
                { id: 'edit_nivel_educativo_id', validate: () => validateNivelEducativo('edit') },
                { id: 'edit_categoria_id', validate: () => validateCategoria('edit') }
            ];
            
            // Añadir validaciones onblur
            fieldsToValidate.forEach(field => {
                const element = document.getElementById(field.id);
                if (element) {
                    element.addEventListener('blur', () => field.validate());
                }
            });
            
            // Validar formulario al enviar
            editForm.addEventListener('submit', function(event) {
                const isValid = fieldsToValidate.map(field => field.validate()).every(Boolean);
                
                if (!isValid) {
                    event.preventDefault();
                    alert('Por favor, corrija los errores en el formulario antes de continuar.');
                }
            });
        }
    });

    // Categorías organizadas por nivel educativo
    const categoriasPorNivel = {
        @foreach($nivelesEducativos as $nivel)
            {{ $nivel->id }}: [
                @foreach($categoriasPorNivel[$nivel->id] ?? [] as $categoria)
                    {
                        id: {{ $categoria->id }},
                        nombre: '{{ $categoria->pivot->nombre_personalizado ?: $categoria->nombre_categoria }}'
                    },
                @endforeach
            ],
        @endforeach
    };

    // Función para actualizar las categorías según el nivel seleccionado
    function actualizarCategorias() {
        const nivelId = document.getElementById('nivel_educativo_id').value;
        const categoriaSelect = document.getElementById('categoria_id');
        
        if (nivelId) {
            // Mostrar un indicador de carga
            categoriaSelect.innerHTML = '<option value="">Cargando...</option>';
            
            // Hacer la petición al servidor
            fetch(`/institucion/api/categorias/${nivelId}`)
                .then(response => response.json())
                .then(data => {
                    // Limpiar y volver a llenar el selector
                    categoriaSelect.innerHTML = '<option value="">-- Seleccionar Curso --</option>';
                    
                    // Añadir las opciones
                    data.forEach(categoria => {
                        const option = document.createElement('option');
                        option.value = categoria.id;
                        option.textContent = categoria.nombre_categoria;
                        categoriaSelect.appendChild(option);
                    });
                    
                    // Si no hay categorías
                    if (data.length === 0) {
                        categoriaSelect.innerHTML = '<option value="">No hay cursos disponibles para este nivel</option>';
                    }
                })
                .catch(error => {
                    console.error('Error cargando categorías:', error);
                    categoriaSelect.innerHTML = '<option value="">Error al cargar los cursos</option>';
                });
        } else {
            // Si no hay nivel seleccionado, limpiar las categorías
            categoriaSelect.innerHTML = '<option value="">-- Seleccionar Curso --</option>';
        }
    }
    
    // Función similar para el formulario de edición
    function actualizarCategoriasEdit() {
        const nivelId = document.getElementById('edit_nivel_educativo_id').value;
        const categoriaSelect = document.getElementById('edit_categoria_id');
        const categoriaActual = categoriaSelect.dataset.valor || '';
        
        if (nivelId) {
            // Mostrar un indicador de carga
            categoriaSelect.innerHTML = '<option value="">Cargando...</option>';
            
            // Hacer la petición al servidor
            fetch(`/institucion/api/categorias/${nivelId}`)
                .then(response => response.json())
                .then(data => {
                    // Limpiar y volver a llenar el selector
                    categoriaSelect.innerHTML = '<option value="">-- Seleccionar Curso --</option>';
                    
                    // Añadir las opciones
                    data.forEach(categoria => {
                        const option = document.createElement('option');
                        option.value = categoria.id;
                        option.textContent = categoria.nombre_categoria;
                        
                        // Seleccionar la categoría actual si coincide
                        if (categoria.id == categoriaActual) {
                            option.selected = true;
                        }
                        
                        categoriaSelect.appendChild(option);
                    });
                    
                    // Si no hay categorías
                    if (data.length === 0) {
                        categoriaSelect.innerHTML = '<option value="">No hay cursos disponibles para este nivel</option>';
                    }
                })
                .catch(error => {
                    console.error('Error cargando categorías:', error);
                    categoriaSelect.innerHTML = '<option value="">Error al cargar los cursos</option>';
                });
        } else {
            // Si no hay nivel seleccionado, limpiar las categorías
            categoriaSelect.innerHTML = '<option value="">-- Seleccionar Curso --</option>';
        }
    }

    // Función para abrir el modal de edición
    function openEditarModal(claseId) {
        const modal = document.getElementById('modalEditarClase');
        if (modal) {
            // Cargar datos de la clase
            fetch(`/institucion/clases/${claseId}/getData`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Configurar formulario
                        const form = document.getElementById('formEditarClase');
                        form.action = `/institucion/clases/${claseId}`;
                        
                        // Llenar campos
                        document.getElementById('clase_id').value = claseId;
                        document.getElementById('edit_nombre').value = data.clase.nombre;
                        document.getElementById('edit_codigo').value = data.clase.codigo || '';
                        document.getElementById('edit_descripcion').value = data.clase.descripcion || '';
                        document.getElementById('edit_departamento_id').value = data.clase.departamento_id || '';
                        document.getElementById('edit_docente_id').value = data.clase.docente_id || '';
                        document.getElementById('edit_nivel_educativo_id').value = data.clase.nivel_educativo_id || '';
                        
                        // Almacenar el valor actual de categoría para restaurarlo después de cargar las opciones
                        const categoriaSelect = document.getElementById('edit_categoria_id');
                        categoriaSelect.dataset.valor = data.clase.categoria_id;
                        
                        // Cargar las categorías según el nivel
                        actualizarCategoriasEdit();
                        
                        document.getElementById('edit_grupo').value = data.clase.grupo || '';
                        
                        // Mostrar modal
                        modal.classList.remove('hidden');
                        document.body.classList.add('overflow-hidden');
                        
                        // Animación de entrada
                        setTimeout(() => {
                            const modalContent = modal.querySelector('.relative');
                            if (modalContent) {
                                modalContent.classList.add('animate-fadeIn');
                            }
                        }, 10);
                    } else {
                        // Mostrar error
                        alert('Error al cargar los datos de la clase');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error al cargar los datos de la clase');
                });
        }
    }
    
    function closeEditarModal() {
        const modal = document.getElementById('modalEditarClase');
        if (modal) {
            // Animación de salida
            const modalContent = modal.querySelector('.relative');
            if (modalContent) {
                modalContent.classList.remove('animate-fadeIn');
                modalContent.classList.add('animate-fadeOut');
            }
            
            // Ocultar modal tras animación
            setTimeout(() => {
                modal.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
                if (modalContent) {
                    modalContent.classList.remove('animate-fadeOut');
                }
            }, 300);
        }
    }
    
    function openModalClase() {
        const modal = document.getElementById('modalNuevaClase');
        if (modal) {
            modal.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
            
            // Animación de entrada
            setTimeout(() => {
                const modalContent = modal.querySelector('.relative');
                if (modalContent) {
                    modalContent.classList.add('animate-fadeIn');
                }
            }, 10);
            
            // Limpiar formulario
            document.getElementById('formNuevaClase').reset();
            // Resetear el selector de categoría
            document.getElementById('categoria_id').innerHTML = '<option value="">-- Seleccionar Curso --</option>';
        }
    }
    
    function closeModalClase() {
        const modal = document.getElementById('modalNuevaClase');
        if (modal) {
            // Animación de salida
            const modalContent = modal.querySelector('.relative');
            if (modalContent) {
                modalContent.classList.remove('animate-fadeIn');
                modalContent.classList.add('animate-fadeOut');
            }
            
            // Ocultar modal tras animación
            setTimeout(() => {
                modal.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
                if (modalContent) {
                    modalContent.classList.remove('animate-fadeOut');
                }
            }, 300);
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Verificar si hay que abrir el modal automáticamente
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('openModal')) {
            openModalClase();
        } else if (urlParams.has('editModal') && urlParams.has('id')) {
            const claseId = urlParams.get('id');
            openEditarModal(claseId);
        }
        
        function filtrarClases() {
            const departamento = document.getElementById('filtro-departamento').value;
            const docente = document.getElementById('filtro-docente').value;
            const busqueda = document.getElementById('filtro-busqueda').value.toLowerCase();
            
            const filas = document.querySelectorAll('#tabla-clases tr');
            
            filas.forEach(fila => {
                const filaDepartamento = fila.getAttribute('data-departamento');
                const filaDocente = fila.getAttribute('data-docente');
                const filaNombre = fila.getAttribute('data-nombre');
                
                const coincideDepartamento = !departamento || filaDepartamento === departamento;
                const coincideDocente = !docente || filaDocente === docente;
                const coincideBusqueda = !busqueda || filaNombre.includes(busqueda);
                
                if (coincideDepartamento && coincideDocente && coincideBusqueda) {
                    fila.style.display = '';
                } else {
                    fila.style.display = 'none';
                }
            });
        }
    });
</script>
@endpush 