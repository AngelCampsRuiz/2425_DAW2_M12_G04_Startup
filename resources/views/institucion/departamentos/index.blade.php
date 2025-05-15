@extends('layouts.institucion')

@section('title', 'Gestión de Departamentos')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Departamentos</h1>
    <a href="javascript:void(0)" onclick="openModalDepartamento()" class="px-4 py-2 bg-primary text-white rounded-md hover:bg-primary-dark transition">
        <i class="fas fa-plus mr-2"></i> Nuevo Departamento
    </a>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="p-4 border-b">
        <div class="flex justify-between items-center">
            <h2 class="text-lg font-medium">Listado de Departamentos</h2>
            <div class="flex items-center">
                <input type="text" id="searchInput" placeholder="Buscar departamento..." class="px-3 py-2 border rounded-md text-sm">
            </div>
        </div>
    </div>
    
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jefe de Departamento</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Docentes</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Clases</th>
                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200" id="departamentosTable">
                @forelse ($departamentos as $departamento)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10 flex items-center justify-center rounded-md bg-purple-100 text-purple-500">
                                    <i class="fas fa-building"></i>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $departamento->nombre }}</div>
                                    <div class="text-xs text-gray-500">
                                        <span class="truncate">
                                            {{ Str::limit($departamento->descripcion, 50) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">
                                @if($departamento->jefeDepartamento)
                                    <a href="{{ route('institucion.docentes.show', $departamento->jefeDepartamento->id) }}" class="text-primary hover:underline flex items-center">
                                        <span class="w-8 h-8 rounded-full overflow-hidden inline-block mr-2">
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($departamento->jefeDepartamento->user->nombre) }}&background=7705B6&color=fff" alt="{{ $departamento->jefeDepartamento->user->nombre }}" class="w-full h-full object-cover">
                                        </span>
                                        {{ $departamento->jefeDepartamento->user->nombre }}
                                    </a>
                                @else
                                    <span class="text-gray-400">No asignado</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">
                                <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">
                                    {{ $departamento->docentes->count() }} docentes
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">
                                <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">
                                    {{ $departamento->clases->count() }} clases
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex justify-end space-x-2">
                                <a href="{{ route('institucion.departamentos.show', $departamento->id) }}" class="text-blue-600 hover:text-blue-900" title="Ver">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="javascript:void(0)" onclick="openEditModal({{ $departamento->id }})" class="text-yellow-600 hover:text-yellow-900" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="{{ route('institucion.departamentos.asignar-docentes', $departamento->id) }}" class="text-green-600 hover:text-green-900" title="Asignar Docentes">
                                    <i class="fas fa-user-plus"></i>
                                </a>
                                <form action="{{ route('institucion.departamentos.destroy', $departamento->id) }}" method="POST" class="inline-block delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900" title="Eliminar">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                            No hay departamentos registrados en esta institución.
                            <a href="{{ route('institucion.departamentos.create') }}" class="text-primary font-medium">Crear uno ahora</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Resumen -->
<div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-6">
    <!-- Total de Departamentos -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-purple-100 text-purple-500 mr-4">
                <i class="fas fa-building text-2xl"></i>
            </div>
            <div>
                <div class="text-sm text-gray-500">Total de Departamentos</div>
                <div class="text-xl font-semibold">{{ $departamentos->count() }}</div>
            </div>
        </div>
    </div>
    
    <!-- Total de Docentes en Departamentos -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-blue-100 text-blue-500 mr-4">
                <i class="fas fa-chalkboard-teacher text-2xl"></i>
            </div>
            <div>
                <div class="text-sm text-gray-500">Docentes en Departamentos</div>
                <div class="text-xl font-semibold">
                    {{ $departamentos->sum(function($dept) { return $dept->docentes->count(); }) }}
                </div>
            </div>
        </div>
    </div>
    
    <!-- Departamentos sin Jefe -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-yellow-100 text-yellow-500 mr-4">
                <i class="fas fa-exclamation-triangle text-2xl"></i>
            </div>
            <div>
                <div class="text-sm text-gray-500">Departamentos sin Jefe</div>
                <div class="text-xl font-semibold">
                    {{ $departamentos->filter(function($dept) { return !$dept->jefeDepartamento; })->count() }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Nuevo Departamento -->
<div id="modalNuevoDepartamento" class="fixed inset-0 bg-black bg-opacity-50 hidden overflow-y-auto h-full w-full z-50 backdrop-blur-sm transition-all duration-300">
    <div class="relative top-20 mx-auto p-0 w-full max-w-2xl transform transition-all duration-300">
        <div class="bg-white rounded-xl shadow-2xl overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 py-4 px-6 flex justify-between items-center">
                <h3 class="text-xl font-bold text-white flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    Crear Nuevo Departamento
                </h3>
                <button onclick="closeModalDepartamento()" class="text-white hover:text-gray-200 focus:outline-none transition-colors">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

            <form id="formNuevoDepartamento" action="{{ route('institucion.departamentos.store') }}" method="POST" class="p-6">
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
                        <div class="mb-4">
                            <label for="nombre" class="block text-sm font-medium text-gray-700 mb-1">Nombre del Departamento *</label>
                            <input type="text" name="nombre" id="nombre" required 
                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm transition-all"
                                value="{{ old('nombre') }}">
                            <p class="mt-1 text-xs text-gray-500">Nombre descriptivo para el departamento</p>
                        </div>
                        
                        <div class="mb-4">
                            <label for="codigo" class="block text-sm font-medium text-gray-700 mb-1">Código del Departamento *</label>
                            <input type="text" name="codigo" id="codigo" required 
                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm transition-all"
                                value="{{ old('codigo') }}">
                            <p class="mt-1 text-xs text-gray-500">Código único del departamento (ej: DEPT-INFO)</p>
                        </div>
                        
                        <div class="mb-4">
                            <label for="descripcion" class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                            <textarea name="descripcion" id="descripcion" rows="4" 
                                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm transition-all">{{ old('descripcion') }}</textarea>
                            <p class="mt-1 text-xs text-gray-500">Una breve descripción de las funciones del departamento</p>
                        </div>
                    </div>
                    
                    <div>
                        <div class="mb-4">
                            <label for="jefe_departamento_id" class="block text-sm font-medium text-gray-700 mb-1">Jefe de Departamento</label>
                            <select name="jefe_departamento_id" id="jefe_departamento_id" 
                                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm transition-all">
                                <option value="">-- Seleccionar Jefe de Departamento --</option>
                                @foreach($docentes as $docente)
                                    <option value="{{ $docente->id }}">
                                        {{ $docente->user->nombre }} ({{ $docente->especialidad }})
                                    </option>
                                @endforeach
                            </select>
                            <p class="mt-1 text-xs text-gray-500">Opcional - Puede asignarlo más tarde</p>
                        </div>
                        
                        <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mt-6">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-blue-700">
                                        Después de crear el departamento, podrás asignar docentes a este departamento desde la vista de detalles.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="flex justify-end space-x-3 pt-4 border-t mt-6">
                    <button type="button" onclick="closeModalDepartamento()"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all">
                        Cancelar
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 text-sm font-medium text-white bg-gradient-to-r from-blue-600 to-indigo-600 border border-transparent rounded-lg hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all shadow-lg">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Guardar Departamento
                        </div>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal de Edición de Departamento -->
<div id="modalEditarDepartamento" class="fixed inset-0 bg-black bg-opacity-50 hidden overflow-y-auto h-full w-full z-50 backdrop-blur-sm transition-all duration-300">
    <div class="relative top-20 mx-auto p-0 w-full max-w-2xl transform transition-all duration-300">
        <div class="bg-white rounded-xl shadow-2xl overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 py-4 px-6 flex justify-between items-center">
                <h3 class="text-xl font-bold text-white flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Editar Departamento
                </h3>
                <button onclick="closeEditModal()" class="text-white hover:text-gray-200 focus:outline-none transition-colors">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

            <form id="formEditarDepartamento" method="POST" class="p-6">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit_departamento_id" name="departamento_id">
                
                <!-- Mensajes de error -->
                <div id="errores-edicion-dpto" class="mb-4 bg-red-50 border-l-4 border-red-500 p-4 rounded hidden">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">Se encontraron los siguientes errores:</h3>
                            <ul class="mt-1 text-xs text-red-700 list-disc list-inside" id="lista-errores-edicion-dpto">
                            </ul>
                        </div>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <div class="mb-4">
                            <label for="edit_nombre" class="block text-sm font-medium text-gray-700 mb-1">Nombre del Departamento *</label>
                            <input type="text" name="nombre" id="edit_nombre" required 
                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm transition-all">
                        </div>
                        
                        <div class="mb-4">
                            <label for="edit_codigo" class="block text-sm font-medium text-gray-700 mb-1">Código del Departamento *</label>
                            <input type="text" name="codigo" id="edit_codigo" required 
                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm transition-all">
                        </div>
                        
                        <div class="mb-4">
                            <label for="edit_descripcion" class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                            <textarea name="descripcion" id="edit_descripcion" rows="4" 
                                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm transition-all"></textarea>
                        </div>
                    </div>
                    
                    <div>
                        <div class="mb-4">
                            <label for="edit_jefe_departamento_id" class="block text-sm font-medium text-gray-700 mb-1">Jefe de Departamento</label>
                            <select name="jefe_departamento_id" id="edit_jefe_departamento_id" 
                                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm transition-all">
                                <option value="">-- Seleccionar Jefe de Departamento --</option>
                                @foreach($docentes as $docente)
                                    <option value="{{ $docente->id }}">
                                        {{ $docente->user->nombre }} ({{ $docente->especialidad }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mt-6">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-blue-700">
                                        Recuerde que puede asignar docentes a este departamento desde la vista de detalles.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="flex justify-end space-x-3 pt-4 border-t mt-6">
                    <button type="button" onclick="closeEditModal()"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all">
                        Cancelar
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 text-sm font-medium text-white bg-gradient-to-r from-blue-600 to-indigo-600 border border-transparent rounded-lg hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all shadow-lg">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Actualizar Departamento
                        </div>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Mostrar modal automáticamente si hay errores
    @if ($errors->any())
        document.addEventListener('DOMContentLoaded', function() {
            openModalDepartamento();
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
            errorElement.className = 'text-red-500 text-xs';
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

    // Validaciones para los formularios de departamentos
    const validateNombre = function(prefix = '') {
        const field = document.getElementById((prefix ? prefix + '_' : '') + 'nombre');
        if (!field) return true;
        
        const value = field.value.trim();
        if (!value) {
            window.updateFieldStatus(field, false, 'El nombre del departamento es obligatorio');
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
            window.updateFieldStatus(field, false, 'El código del departamento es obligatorio');
            return false;
        } else if (value.length < 2) {
            window.updateFieldStatus(field, false, 'El código debe tener al menos 2 caracteres');
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
        const createForm = document.getElementById('formNuevoDepartamento');
        if (createForm) {
            const fieldsToValidate = [
                { id: 'nombre', validate: validateNombre },
                { id: 'codigo', validate: validateCodigo },
                { id: 'descripcion', validate: validateDescripcion }
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
        const editForm = document.getElementById('formEditarDepartamento');
        if (editForm) {
            const fieldsToValidate = [
                { id: 'edit_nombre', validate: () => validateNombre('edit') },
                { id: 'edit_codigo', validate: () => validateCodigo('edit') },
                { id: 'edit_descripcion', validate: () => validateDescripcion('edit') }
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

    // Definición global de openEditModal
    function openEditModal(departamentoId) {
        const modal = document.getElementById('modalEditarDepartamento');
        if (modal) {
            // Cargar datos del departamento
            fetch(`/institucion/departamentos/${departamentoId}/get-data`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Configurar formulario
                        const form = document.getElementById('formEditarDepartamento');
                        form.action = `/institucion/departamentos/${departamentoId}`;
                        
                        // Llenar campos
                        document.getElementById('edit_departamento_id').value = departamentoId;
                        document.getElementById('edit_nombre').value = data.departamento.nombre;
                        document.getElementById('edit_codigo').value = data.departamento.codigo || '';
                        document.getElementById('edit_descripcion').value = data.departamento.descripcion || '';
                        document.getElementById('edit_jefe_departamento_id').value = data.departamento.jefe_departamento_id || '';
                        
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
                        alert('Error al cargar los datos del departamento');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error al cargar los datos del departamento');
                });
        }
    }
    
    document.addEventListener('DOMContentLoaded', function() {
        // Comprobar parámetros URL para abrir modal automáticamente
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('editModal') && urlParams.get('editModal') === 'true') {
            const id = urlParams.get('id');
            if (id) {
                console.log("Detectado parámetro editModal=true con id=", id);
                openEditModal(id);
            }
        }
        
        // Búsqueda de departamentos
        const searchInput = document.getElementById('searchInput');
        const departamentosTable = document.getElementById('departamentosTable');
        const departamentosRows = departamentosTable.querySelectorAll('tr');
        
        searchInput.addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase();
            
            departamentosRows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });
        
        // Confirmación de eliminación
        const deleteForms = document.querySelectorAll('.delete-form');
        
        deleteForms.forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                if (confirm('¿Estás seguro de que deseas eliminar este departamento? Esta acción no se puede deshacer.')) {
                    this.submit();
                }
            });
        });

        // Funciones para el modal de nuevo departamento
        window.openModalDepartamento = function() {
            const modal = document.getElementById('modalNuevoDepartamento');
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
                document.getElementById('formNuevoDepartamento').reset();
            }
        };
        
        window.closeModalDepartamento = function() {
            const modal = document.getElementById('modalNuevoDepartamento');
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
        };
        
        window.closeEditModal = function() {
            const modal = document.getElementById('modalEditarDepartamento');
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
        };
    });
</script>
@endpush 