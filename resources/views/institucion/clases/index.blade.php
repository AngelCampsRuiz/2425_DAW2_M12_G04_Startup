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
                                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                    <p class="mt-1 text-xs text-gray-500">Ej: Matemáticas Avanzadas</p>
                                </div>

                                <div>
                                    <label for="codigo" class="block text-sm font-medium text-gray-700 mb-1">Código de la Clase *</label>
                                    <input type="text" name="codigo" id="codigo" required 
                                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                    <p class="mt-1 text-xs text-gray-500">Ej: MAT-101 o MATE2023</p>
                                </div>

                                <div>
                                    <label for="descripcion" class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                                    <textarea name="descripcion" id="descripcion" rows="3" 
                                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"></textarea>
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
        
        // Limpiar select
        categoriaSelect.innerHTML = '<option value="">-- Seleccionar Curso --</option>';
        
        // Si no hay nivel seleccionado, salir
        if (!nivelId) return;
        
        // Añadir las categorías del nivel seleccionado
        const categorias = categoriasPorNivel[nivelId] || [];
        categorias.forEach(categoria => {
            const option = document.createElement('option');
            option.value = categoria.id;
            option.textContent = categoria.nombre;
            categoriaSelect.appendChild(option);
        });
    }
    
    // Función para actualizar las categorías en el modal de edición
    function actualizarCategoriasEdit() {
        const nivelId = document.getElementById('edit_nivel_educativo_id').value;
        const categoriaSelect = document.getElementById('edit_categoria_id');
        
        // Limpiar select
        categoriaSelect.innerHTML = '<option value="">-- Seleccionar Curso --</option>';
        
        // Si no hay nivel seleccionado, salir
        if (!nivelId) return;
        
        // Añadir las categorías del nivel seleccionado
        const categorias = categoriasPorNivel[nivelId] || [];
        categorias.forEach(categoria => {
            const option = document.createElement('option');
            option.value = categoria.id;
            option.textContent = categoria.nombre;
            categoriaSelect.appendChild(option);
        });
    }

    // Función para abrir el modal de edición y cargar los datos
    function openEditarModal(claseId) {
        // Obtener los datos de la clase mediante AJAX
        fetch(`/institucion/clases/${claseId}/getData`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const clase = data.clase;
                    
                    // Establecer la acción del formulario
                    document.getElementById('formEditarClase').action = `/institucion/clases/${claseId}`;
                    
                    // Cargar los datos en el formulario
                    document.getElementById('clase_id').value = clase.id;
                    document.getElementById('edit_nombre').value = clase.nombre;
                    document.getElementById('edit_codigo').value = clase.codigo;
                    document.getElementById('edit_descripcion').value = clase.descripcion || '';
                    document.getElementById('edit_departamento_id').value = clase.departamento_id || '';
                    document.getElementById('edit_docente_id').value = clase.docente_id || '';
                    document.getElementById('edit_nivel_educativo_id').value = clase.nivel_educativo_id || '';
                    document.getElementById('edit_grupo').value = clase.grupo || '';
                    
                    // Actualizar las categorías según el nivel seleccionado
                    actualizarCategoriasEdit();
                    
                    // Establecer la categoría seleccionada después de cargar las opciones
                    setTimeout(() => {
                        document.getElementById('edit_categoria_id').value = clase.categoria_id || '';
                    }, 100);
                    
                    // Mostrar el modal
                    const modal = document.getElementById('modalEditarClase');
                    modal.classList.remove('hidden');
                    document.body.classList.add('overflow-hidden');
                    
                    // Animación de entrada
                    setTimeout(() => {
                        const modalContent = modal.querySelector('.relative');
                        if (modalContent) {
                            modalContent.classList.add('animate-fadeIn');
                        }
                    }, 10);
                }
            })
            .catch(error => {
                console.error('Error al cargar los datos de la clase:', error);
            });
    }
    
    // Función para cerrar el modal de edición
    function closeEditarModal() {
        const modal = document.getElementById('modalEditarClase');
        if (modal) {
            // Animación de salida
            const modalContent = modal.querySelector('.relative');
            if (modalContent) {
                modalContent.classList.remove('animate-fadeIn');
                modalContent.classList.add('animate-fadeOut');
            }
            
            setTimeout(() => {
                modal.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
                
                if (modalContent) {
                    modalContent.classList.remove('animate-fadeOut');
                }
                
                // Restablecer el formulario
                document.getElementById('formEditarClase').reset();
            }, 200);
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

        // Funciones para el modal de clase
        window.openModalClase = function() {
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
                
                // Scroll al inicio del modal y focus primer input
                setTimeout(() => {
                    const firstInput = modal.querySelector('input, select, textarea');
                    if (firstInput) firstInput.focus();
                }, 300);
            }
        };
        
        window.closeModalClase = function() {
            const modal = document.getElementById('modalNuevaClase');
            if (modal) {
                // Animación de salida
                const modalContent = modal.querySelector('.relative');
                if (modalContent) {
                    modalContent.classList.remove('animate-fadeIn');
                    modalContent.classList.add('animate-fadeOut');
                }
                
                setTimeout(() => {
                    modal.classList.add('hidden');
                    document.body.classList.remove('overflow-hidden');
                    
                    if (modalContent) {
                        modalContent.classList.remove('animate-fadeOut');
                    }
                    
                    const form = document.getElementById('formNuevaClase');
                    if (form) {
                        form.reset();
                    }
                }, 200);
            }
        };

        // Configuración modal de clase
        const modalNuevaClase = document.getElementById('modalNuevaClase');
        if (modalNuevaClase) {
            modalNuevaClase.addEventListener('click', function(e) {
                if (e.target === this) {
                    closeModalClase();
                }
            });

            // Cerrar con tecla Escape
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && !modalNuevaClase.classList.contains('hidden')) {
                    closeModalClase();
                }
            });
        }
    });
</script>
@endpush 