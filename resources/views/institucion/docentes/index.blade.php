@extends('layouts.institucion')

@section('title', 'Gestión de Docentes')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Docentes</h1>
    <a href="javascript:void(0)" onclick="openModalDocente()" class="px-4 py-2 bg-primary text-white rounded-md hover:bg-primary-dark transition">
        <i class="fas fa-plus mr-2"></i> Nuevo Docente
    </a>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="p-4 border-b">
        <div class="flex justify-between items-center">
            <h2 class="text-lg font-medium">Listado de Docentes</h2>
            <div class="flex items-center">
                <input type="text" id="searchInput" placeholder="Buscar docente..." class="px-3 py-2 border rounded-md text-sm">
            </div>
        </div>
    </div>
    
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Departamento</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Especialidad</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cargo</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200" id="docentesTable">
                @forelse ($docentes as $docente)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <img class="h-10 w-10 rounded-full" src="https://ui-avatars.com/api/?name={{ urlencode($docente->user->nombre) }}&background=7705B6&color=fff" alt="{{ $docente->user->nombre }}">
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $docente->user->nombre }}</div>
                                    <div class="text-sm text-gray-500">{{ $docente->user->dni }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $docente->user->email }}</div>
                            <div class="text-sm text-gray-500">{{ $docente->user->telefono }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">
                                @if($docente->departamentoObj)
                                    {{ $docente->departamentoObj->nombre }}
                                @elseif($docente->departamento)
                                    {{ $docente->departamento }}
                                @else
                                    <span class="text-gray-400">No asignado</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $docente->especialidad }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $docente->cargo }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $docente->activo ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $docente->activo ? 'Activo' : 'Inactivo' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex justify-end space-x-2">
                                <a href="{{ route('institucion.docentes.show', $docente->id) }}" class="text-blue-600 hover:text-blue-900" title="Ver">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="javascript:void(0)" onclick="openEditModal({{ $docente->id }})" class="text-yellow-600 hover:text-yellow-900" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('institucion.docentes.toggle-active', $docente->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('POST')
                                    <button type="submit" class="{{ $docente->activo ? 'text-red-600 hover:text-red-900' : 'text-green-600 hover:text-green-900' }}" title="{{ $docente->activo ? 'Desactivar' : 'Activar' }}">
                                        <i class="fas {{ $docente->activo ? 'fa-toggle-on' : 'fa-toggle-off' }}"></i>
                                    </button>
                                </form>
                                <form action="{{ route('institucion.docentes.destroy', $docente->id) }}" method="POST" class="inline-block delete-form">
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
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                            No hay docentes registrados en esta institución.
                            <a href="{{ route('institucion.docentes.create') }}" class="text-primary font-medium">Crear uno ahora</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Filtros por Departamento -->
<div class="mt-6 bg-white rounded-lg shadow p-6">
    <h3 class="font-medium text-lg mb-4">Filtrar por Departamento</h3>
    <div class="flex flex-wrap gap-2">
        <button class="department-filter px-3 py-1 rounded-full bg-primary text-white text-sm" data-department="all">
            Todos
        </button>
        
        @foreach ($departamentos as $departamento)
            <button class="department-filter px-3 py-1 rounded-full bg-gray-200 text-gray-700 hover:bg-gray-300 text-sm" data-department="{{ $departamento->id }}">
                {{ $departamento->nombre }}
            </button>
        @endforeach
        
        <button class="department-filter px-3 py-1 rounded-full bg-gray-200 text-gray-700 hover:bg-gray-300 text-sm" data-department="null">
            Sin departamento
        </button>
    </div>
</div>

<!-- Modal de Nuevo Docente -->
<div id="modalNuevoDocente" class="fixed inset-0 bg-black bg-opacity-50 hidden overflow-y-auto h-full w-full z-50 backdrop-blur-sm transition-all duration-300">
    <div class="relative top-20 mx-auto p-0 w-full max-w-2xl transform transition-all duration-300">
        <div class="bg-white rounded-xl shadow-2xl overflow-hidden">
            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 py-4 px-6 flex justify-between items-center">
                <h3 class="text-xl font-bold text-white flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                    Crear Nuevo Docente
                </h3>
                <button onclick="closeModalDocente()" class="text-white hover:text-gray-200 focus:outline-none transition-colors">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

            <form id="formNuevoDocente" action="{{ route('institucion.docentes.store') }}" method="POST" class="p-6">
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
                
                <!-- Información Personal -->
                <div class="mb-6">
                    <h4 class="text-md font-medium text-gray-800 mb-3 flex items-center">
                        <div class="w-8 h-8 flex items-center justify-center bg-indigo-100 rounded-full mr-2 text-indigo-600">1</div>
                        Información Personal
                    </h4>
                    <div class="bg-gray-50 p-4 rounded-lg space-y-4">
                        <div>
                            <label for="nombre" class="block text-sm font-medium text-gray-700 mb-1">Nombre Completo *</label>
                            <input type="text" name="nombre" id="nombre" required 
                                   class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 text-sm transition-all"
                                   value="{{ old('nombre') }}">
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                            <input type="email" name="email" id="email" required 
                                   class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 text-sm transition-all"
                                   value="{{ old('email') }}">
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="dni" class="block text-sm font-medium text-gray-700 mb-1">DNI/NIF/NIE *</label>
                                <input type="text" name="dni" id="dni" required 
                                       class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 text-sm transition-all"
                                       value="{{ old('dni') }}">
                            </div>
                            
                            <div>
                                <label for="telefono" class="block text-sm font-medium text-gray-700 mb-1">Teléfono *</label>
                                <input type="text" name="telefono" id="telefono" required 
                                       class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 text-sm transition-all"
                                       value="{{ old('telefono') }}">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Información Profesional -->
                <div class="mb-6">
                    <h4 class="text-md font-medium text-gray-800 mb-3 flex items-center">
                        <div class="w-8 h-8 flex items-center justify-center bg-indigo-100 rounded-full mr-2 text-indigo-600">2</div>
                        Información Profesional
                    </h4>
                    <div class="bg-gray-50 p-4 rounded-lg space-y-4">
                        <div>
                            <label for="departamento_id" class="block text-sm font-medium text-gray-700 mb-1">Departamento</label>
                            <select name="departamento_id" id="departamento_id"
                                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 text-sm transition-all">
                                <option value="">-- Seleccionar Departamento --</option>
                                @foreach($departamentos as $departamento)
                                    <option value="{{ $departamento->id }}">{{ $departamento->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="especialidad" class="block text-sm font-medium text-gray-700 mb-1">Especialidad *</label>
                                <input type="text" name="especialidad" id="especialidad" required 
                                       class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 text-sm transition-all">
                            </div>
                            
                            <div>
                                <label for="cargo" class="block text-sm font-medium text-gray-700 mb-1">Cargo *</label>
                                <select name="cargo" id="cargo" required
                                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 text-sm transition-all">
                                    <option value="">-- Seleccionar Cargo --</option>
                                    <option value="Profesor">Profesor</option>
                                    <option value="Jefe de Estudios">Jefe de Estudios</option>
                                    <option value="Director">Director</option>
                                    <option value="Coordinador">Coordinador</option>
                                    <option value="Tutor">Tutor</option>
                                    <option value="Otro">Otro</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4 text-sm text-gray-600 mb-4">
                    <div class="flex items-center bg-blue-50 p-3 rounded-lg border border-blue-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p>Al crear un docente, se generará automáticamente una contraseña temporal que será enviada al correo electrónico proporcionado.</p>
                    </div>
                </div>

                <div class="flex justify-end space-x-3 pt-4 border-t">
                    <button type="button" onclick="closeModalDocente()"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-all">
                        Cancelar
                    </button>
                    <button type="submit" id="submitButton"
                            class="px-4 py-2 text-sm font-medium text-white bg-gradient-to-r from-indigo-600 to-purple-600 border border-transparent rounded-lg hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all shadow-lg">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Guardar Docente
                        </div>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal de Edición de Docente -->
<div id="modalEditarDocente" class="fixed inset-0 bg-black bg-opacity-50 hidden overflow-y-auto h-full w-full z-50 backdrop-blur-sm transition-all duration-300">
    <div class="relative top-20 mx-auto p-0 w-full max-w-2xl transform transition-all duration-300">
        <div class="bg-white rounded-xl shadow-2xl overflow-hidden">
            <div class="bg-gradient-to-r from-yellow-600 to-amber-600 py-4 px-6 flex justify-between items-center">
                <h3 class="text-xl font-bold text-white flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Editar Docente
                </h3>
                <button onclick="closeEditModal()" class="text-white hover:text-gray-200 focus:outline-none transition-colors">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

            <form id="formEditarDocente" method="POST" class="p-6">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit_docente_id" name="docente_id">
                
                <!-- Mensajes de error -->
                <div id="errores-edicion" class="mb-4 bg-red-50 border-l-4 border-red-500 p-4 rounded hidden">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">Se encontraron los siguientes errores:</h3>
                            <ul class="mt-1 text-xs text-red-700 list-disc list-inside" id="lista-errores-edicion">
                            </ul>
                        </div>
                    </div>
                </div>
                
                <!-- Información Personal -->
                <div class="mb-6">
                    <h4 class="text-md font-medium text-gray-800 mb-3 flex items-center">
                        <div class="w-8 h-8 flex items-center justify-center bg-yellow-100 rounded-full mr-2 text-yellow-600">1</div>
                        Información Personal
                    </h4>
                    <div class="bg-gray-50 p-4 rounded-lg space-y-4">
                        <div>
                            <label for="edit_nombre" class="block text-sm font-medium text-gray-700 mb-1">Nombre Completo *</label>
                            <input type="text" name="nombre" id="edit_nombre" required 
                                   class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-yellow-500 focus:ring-yellow-500 text-sm transition-all">
                        </div>

                        <div>
                            <label for="edit_email" class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                            <input type="email" name="email" id="edit_email" required 
                                   class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-yellow-500 focus:ring-yellow-500 text-sm transition-all">
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="edit_dni" class="block text-sm font-medium text-gray-700 mb-1">DNI/NIF/NIE *</label>
                                <input type="text" name="dni" id="edit_dni" required 
                                       class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-yellow-500 focus:ring-yellow-500 text-sm transition-all">
                            </div>
                            
                            <div>
                                <label for="edit_telefono" class="block text-sm font-medium text-gray-700 mb-1">Teléfono *</label>
                                <input type="text" name="telefono" id="edit_telefono" required 
                                       class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-yellow-500 focus:ring-yellow-500 text-sm transition-all">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Información Profesional -->
                <div class="mb-6">
                    <h4 class="text-md font-medium text-gray-800 mb-3 flex items-center">
                        <div class="w-8 h-8 flex items-center justify-center bg-yellow-100 rounded-full mr-2 text-yellow-600">2</div>
                        Información Profesional
                    </h4>
                    <div class="bg-gray-50 p-4 rounded-lg space-y-4">
                        <div>
                            <label for="edit_departamento_id" class="block text-sm font-medium text-gray-700 mb-1">Departamento</label>
                            <select name="departamento_id" id="edit_departamento_id" onchange="toggleEditDepartamentoManual()"
                                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-yellow-500 focus:ring-yellow-500 text-sm transition-all">
                                <option value="">-- Seleccionar Departamento --</option>
                                @foreach($departamentos as $departamento)
                                    <option value="{{ $departamento->id }}">{{ $departamento->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div id="edit_departamento_manual_container">
                            <label for="edit_departamento" class="block text-sm font-medium text-gray-700 mb-1">Nombre del Departamento (si no está en la lista)</label>
                            <input type="text" name="departamento" id="edit_departamento" 
                                   class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-yellow-500 focus:ring-yellow-500 text-sm transition-all">
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="edit_especialidad" class="block text-sm font-medium text-gray-700 mb-1">Especialidad *</label>
                                <input type="text" name="especialidad" id="edit_especialidad" required 
                                       class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-yellow-500 focus:ring-yellow-500 text-sm transition-all">
                            </div>
                            
                            <div>
                                <label for="edit_cargo" class="block text-sm font-medium text-gray-700 mb-1">Cargo *</label>
                                <select name="cargo" id="edit_cargo" required
                                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-yellow-500 focus:ring-yellow-500 text-sm transition-all">
                                    <option value="">-- Seleccionar Cargo --</option>
                                    <option value="Profesor">Profesor</option>
                                    <option value="Jefe de Estudios">Jefe de Estudios</option>
                                    <option value="Director">Director</option>
                                    <option value="Coordinador">Coordinador</option>
                                    <option value="Tutor">Tutor</option>
                                    <option value="Otro">Otro</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="flex items-center mt-3">
                            <input type="checkbox" name="activo" id="edit_activo" value="1" 
                                   class="rounded border-gray-300 text-yellow-600 shadow-sm focus:border-yellow-300 focus:ring focus:ring-yellow-200 focus:ring-opacity-50">
                            <label for="edit_activo" class="ml-2 block text-sm text-gray-700">
                                Docente activo
                            </label>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end space-x-3 pt-4 border-t">
                    <button type="button" onclick="closeEditModal()"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition-all">
                        Cancelar
                    </button>
                    <button type="submit"
                            class="px-4 py-2 text-sm font-medium text-white bg-gradient-to-r from-yellow-600 to-amber-600 border border-transparent rounded-lg hover:from-yellow-700 hover:to-amber-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition-all shadow-lg">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Actualizar Docente
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
    // Si hay información de contraseña, mostrarla en la consola
    @if(session('password') && session('email'))
        console.log('%c CREDENCIALES DEL NUEVO DOCENTE ', 'background: #4CAF50; color: white; font-size: 12px; font-weight: bold; padding: 5px;');
        console.log('%c Email: ' + '{{ session('email') }}', 'color: #333; font-size: 14px; font-weight: bold;');
        console.log('%c Contraseña: ' + '{{ session('password') }}', 'color: #E91E63; font-size: 14px; font-weight: bold;');
        console.log('%c Guarde estas credenciales ya que no se mostrarán nuevamente. ', 'background: #FFC107; color: #333; font-size: 12px; padding: 3px;');
    @endif
    
    // Mostrar modal automáticamente si hay errores
    @if ($errors->any())
        document.addEventListener('DOMContentLoaded', function() {
            openModalDocente();
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

    // Validaciones para el formulario de creación de docentes
    const validateNombre = function(prefix = '') {
        const field = document.getElementById((prefix ? prefix + '_' : '') + 'nombre');
        if (!field) return true;
        
        const value = field.value.trim();
        if (!value) {
            window.updateFieldStatus(field, false, 'El nombre es obligatorio');
            return false;
        } else if (value.length < 3) {
            window.updateFieldStatus(field, false, 'El nombre debe tener al menos 3 caracteres');
            return false;
        }
        
        window.updateFieldStatus(field, true);
        return true;
    };

    const validateEmail = function(prefix = '') {
        const field = document.getElementById((prefix ? prefix + '_' : '') + 'email');
        if (!field) return true;
        
        const value = field.value.trim();
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        
        if (!value) {
            window.updateFieldStatus(field, false, 'El email es obligatorio');
            return false;
        } else if (!emailRegex.test(value)) {
            window.updateFieldStatus(field, false, 'El formato del email no es válido');
            return false;
        }
        
        window.updateFieldStatus(field, true);
        return true;
    };

    const validateDNI = function(prefix = '') {
        const field = document.getElementById((prefix ? prefix + '_' : '') + 'dni');
        if (!field) return true;
        
        const value = field.value.trim();
        const dniRegex = /^[0-9]{8}[TRWAGMYFPDXBNJZSQVHLCKE]$|^[XYZ][0-9]{7}[TRWAGMYFPDXBNJZSQVHLCKE]$/i;
        
        if (!value) {
            window.updateFieldStatus(field, false, 'El DNI/NIE es obligatorio');
            return false;
        } else if (!dniRegex.test(value)) {
            window.updateFieldStatus(field, false, 'El formato del DNI/NIE no es válido');
            return false;
        }
        
        window.updateFieldStatus(field, true);
        return true;
    };

    const validateTelefono = function(prefix = '') {
        const field = document.getElementById((prefix ? prefix + '_' : '') + 'telefono');
        if (!field) return true;
        
        const value = field.value.trim();
        const telefonoRegex = /^[0-9]{9}$/;
        
        if (!value) {
            window.updateFieldStatus(field, false, 'El teléfono es obligatorio');
            return false;
        } else if (!telefonoRegex.test(value)) {
            window.updateFieldStatus(field, false, 'El teléfono debe tener 9 dígitos');
            return false;
        }
        
        window.updateFieldStatus(field, true);
        return true;
    };

    const validateEspecialidad = function(prefix = '') {
        const field = document.getElementById((prefix ? prefix + '_' : '') + 'especialidad');
        if (!field) return true;
        
        const value = field.value.trim();
        if (!value) {
            window.updateFieldStatus(field, false, 'La especialidad es obligatoria');
            return false;
        }
        
        window.updateFieldStatus(field, true);
        return true;
    };

    const validateCargo = function(prefix = '') {
        const field = document.getElementById((prefix ? prefix + '_' : '') + 'cargo');
        if (!field) return true;
        
        const value = field.value.trim();
        if (!value) {
            window.updateFieldStatus(field, false, 'El cargo es obligatorio');
            return false;
        }
        
        window.updateFieldStatus(field, true);
        return true;
    };

    // Configurar validaciones para el formulario de creación
    document.addEventListener('DOMContentLoaded', function() {
        // Validaciones para el formulario de creación
        const createForm = document.getElementById('formNuevoDocente');
        if (createForm) {
            const fieldsToValidate = [
                { id: 'nombre', validate: validateNombre },
                { id: 'email', validate: validateEmail },
                { id: 'dni', validate: validateDNI },
                { id: 'telefono', validate: validateTelefono },
                { id: 'especialidad', validate: validateEspecialidad },
                { id: 'cargo', validate: validateCargo }
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
        const editForm = document.getElementById('formEditarDocente');
        if (editForm) {
            const fieldsToValidate = [
                { id: 'edit_nombre', validate: () => validateNombre('edit') },
                { id: 'edit_email', validate: () => validateEmail('edit') },
                { id: 'edit_dni', validate: () => validateDNI('edit') },
                { id: 'edit_telefono', validate: () => validateTelefono('edit') },
                { id: 'edit_especialidad', validate: () => validateEspecialidad('edit') },
                { id: 'edit_cargo', validate: () => validateCargo('edit') }
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
    function openEditModal(docenteId) {
        const modal = document.getElementById('modalEditarDocente');
        if (modal) {
            // Cargar datos del docente
            fetch(`/institucion/docentes/${docenteId}/get-data`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Configurar formulario
                        const form = document.getElementById('formEditarDocente');
                        form.action = `/institucion/docentes/${docenteId}`;
                        
                        // Llenar campos
                        document.getElementById('edit_docente_id').value = docenteId;
                        document.getElementById('edit_nombre').value = data.docente.user.nombre;
                        document.getElementById('edit_email').value = data.docente.user.email;
                        document.getElementById('edit_dni').value = data.docente.user.dni;
                        document.getElementById('edit_telefono').value = data.docente.user.telefono;
                        document.getElementById('edit_departamento_id').value = data.docente.departamento_id || '';
                        document.getElementById('edit_departamento').value = data.docente.departamento || '';
                        document.getElementById('edit_especialidad').value = data.docente.especialidad;
                        document.getElementById('edit_cargo').value = data.docente.cargo;
                        document.getElementById('edit_activo').checked = data.docente.activo ? true : false;
                        
                        // Mostrar/ocultar campo departamento manual
                        toggleEditDepartamentoManual();
                        
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
                        alert('Error al cargar los datos del docente');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error al cargar los datos del docente');
                });
        }
    }
    
    // Funciones para el modal de docente
    window.openModalDocente = function() {
        const modal = document.getElementById('modalNuevoDocente');
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
    
    window.closeModalDocente = function() {
        const modal = document.getElementById('modalNuevoDocente');
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
                
                const form = document.getElementById('formNuevoDocente');
                if (form) {
                    form.reset();
                }
            }, 200);
        }
    };
    
    window.toggleDepartamentoManual = function() {
        const departamentoSelect = document.getElementById('departamento_id');
        const departamentoManualContainer = document.getElementById('departamento_manual_container');
        
        if (departamentoSelect && departamentoManualContainer) {
            if (departamentoSelect.value) {
                departamentoManualContainer.style.display = 'none';
            } else {
                departamentoManualContainer.style.display = '';
            }
        }
    };
    
    window.toggleEditDepartamentoManual = function() {
        const departamentoSelect = document.getElementById('edit_departamento_id');
        const departamentoManualContainer = document.getElementById('edit_departamento_manual_container');
        
        if (departamentoSelect && departamentoManualContainer) {
            if (departamentoSelect.value) {
                departamentoManualContainer.style.display = 'none';
            } else {
                departamentoManualContainer.style.display = '';
            }
        }
    };
    
    window.closeEditModal = function() {
        const modal = document.getElementById('modalEditarDocente');
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
                
                // Limpiar formulario
                const form = document.getElementById('formEditarDocente');
                if (form) {
                    form.reset();
                }
            }, 200);
        }
    };

    document.addEventListener('DOMContentLoaded', function() {
        // Configuración al cargar la página
        toggleDepartamentoManual();
        
        // Comprobar parámetros URL para abrir modal automáticamente
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('editModal') && urlParams.get('editModal') === 'true') {
            const id = urlParams.get('id');
            if (id) {
                console.log("Detectado parámetro editModal=true con id=", id);
                openEditModal(id);
            }
        }
        
        // Cerrar modal al hacer clic fuera
        const modalNuevoDocente = document.getElementById('modalNuevoDocente');
        if (modalNuevoDocente) {
            modalNuevoDocente.addEventListener('click', function(e) {
                if (e.target === this) {
                    closeModalDocente();
                }
            });
        
            // Cerrar con tecla Escape
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && !modalNuevoDocente.classList.contains('hidden')) {
                    closeModalDocente();
                }
            });
        }

        // Búsqueda de docentes
        const searchInput = document.getElementById('searchInput');
        const docentesTable = document.getElementById('docentesTable');
        const docentesRows = docentesTable.querySelectorAll('tr');
        
        searchInput.addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase();
            
            docentesRows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });
        
        // Filtrar por departamento
        const departmentButtons = document.querySelectorAll('.department-filter');
        
        departmentButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Actualizar clases de botones
                departmentButtons.forEach(btn => {
                    btn.classList.remove('bg-primary', 'text-white');
                    btn.classList.add('bg-gray-200', 'text-gray-700');
                });
                
                this.classList.remove('bg-gray-200', 'text-gray-700');
                this.classList.add('bg-primary', 'text-white');
                
                const departmentId = this.getAttribute('data-department');
                
                docentesRows.forEach(row => {
                    if (departmentId === 'all') {
                        row.style.display = '';
                    } else if (departmentId === 'null') {
                        const departmentText = row.querySelector('td:nth-child(3)').textContent.trim();
                        row.style.display = departmentText.includes('No asignado') ? '' : 'none';
                    } else {
                        const departmentCell = row.querySelector('td:nth-child(3)');
                        const departmentText = departmentCell ? departmentCell.textContent.trim() : '';
                        
                        // Aquí necesitaríamos una forma de saber si el departamento coincide con el ID
                        // Como esto es más complejo, podríamos usar un atributo data en la fila
                        // Por ahora, haremos una coincidencia simple por texto
                        row.style.display = departmentText.toLowerCase().includes(departmentId) ? '' : 'none';
                    }
                });
            });
        });
        
        // Confirmación de eliminación
        const deleteForms = document.querySelectorAll('.delete-form');
        
        deleteForms.forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                if (confirm('¿Estás seguro de que deseas eliminar este docente? Esta acción no se puede deshacer.')) {
                    this.submit();
                }
            });
        });

        // Cerrar modal al hacer clic fuera
        const modalEditarDocente = document.getElementById('modalEditarDocente');
        if (modalEditarDocente) {
            modalEditarDocente.addEventListener('click', function(e) {
                if (e.target === this) {
                    closeEditModal();
                }
            });
            
            // Cerrar con tecla Escape
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && !modalEditarDocente.classList.contains('hidden')) {
                    closeEditModal();
                }
            });
        }
    });
</script>
@endpush 