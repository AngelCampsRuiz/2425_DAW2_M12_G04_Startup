@extends('layouts.institucion')

@section('title', 'Detalles del Docente')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Detalles del Docente</h1>
    <div class="flex space-x-2">
        <button onclick="openEditModal({{ $docente->id }})" class="px-4 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600 transition">
            <i class="fas fa-edit mr-2"></i> Editar
        </button>
        <a href="{{ route('institucion.docentes.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition">
            <i class="fas fa-arrow-left mr-2"></i> Volver al listado
        </a>
    </div>
</div>

<!-- Alerta de contraseña reseteada -->
@if(session('success') && strpos(session('success'), 'Contraseña reseteada') !== false)
    <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-800 p-4 mb-6 rounded-md" role="alert">
        <div class="flex items-start">
            <svg class="h-5 w-5 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
            </svg>
            <div class="w-full">
                <p class="font-bold mb-1">¡Contraseña reseteada!</p>
                <p class="mb-1"><span class="font-semibold">Email:</span> {{ $docente->user->email }}</p>
                <div class="flex items-center mb-1">
                    <span class="font-semibold mr-2">Nueva contraseña:</span>
                    <code id="passwordText" class="bg-blue-50 px-2 py-1 rounded">{{ str_replace("Contraseña reseteada correctamente. Nueva contraseña temporal: ", "", session("success")) }}</code>
                    <button type="button" onclick="copyPassword()" class="ml-2 text-xs bg-blue-200 hover:bg-blue-300 text-blue-800 px-2 py-1 rounded">
                        <i class="fas fa-copy mr-1"></i> Copiar
                    </button>
                    <span id="copyMessage" class="ml-2 text-xs text-green-600 hidden">
                        <i class="fas fa-check"></i> Copiado
                    </span>
                </div>
                <p class="text-xs mt-2 text-blue-700">Guarde esta contraseña. Por seguridad, no se mostrará nuevamente.</p>
            </div>
        </div>
    </div>
@endif

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <!-- Información Básica -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="p-5 bg-primary text-white">
            <div class="flex justify-between items-center">
                <h2 class="font-bold text-lg">Información Personal</h2>
                <i class="fas fa-user text-3xl"></i>
            </div>
        </div>
        <div class="p-6">
            <div class="flex items-center mb-6">
                <div class="flex-shrink-0 mr-4">
                    <img class="h-24 w-24 rounded-full" src="https://ui-avatars.com/api/?name={{ urlencode($docente->user->nombre) }}&background=7705B6&color=fff&size=256" alt="{{ $docente->user->nombre }}">
                </div>
                <div>
                    <h3 class="text-xl font-semibold text-gray-800">{{ $docente->user->nombre }}</h3>
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $docente->activo ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $docente->activo ? 'Activo' : 'Inactivo' }}
                    </span>
                </div>
            </div>
            
            <div class="border-t pt-4">
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <span class="text-gray-600 text-sm block">Email:</span>
                        <span class="font-medium">{{ $docente->user->email }}</span>
                    </div>
                    <div>
                        <span class="text-gray-600 text-sm block">DNI/NIF/NIE:</span>
                        <span class="font-medium">{{ $docente->user->dni }}</span>
                    </div>
                    <div>
                        <span class="text-gray-600 text-sm block">Teléfono:</span>
                        <span class="font-medium">{{ $docente->user->telefono }}</span>
                    </div>
                    @if($docente->user->fecha_nacimiento)
                    <div>
                        <span class="text-gray-600 text-sm block">Fecha de nacimiento:</span>
                        <span class="font-medium">{{ \Carbon\Carbon::parse($docente->user->fecha_nacimiento)->format('d/m/Y') }}</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <!-- Información Profesional -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="p-5 bg-blue-600 text-white">
            <div class="flex justify-between items-center">
                <h2 class="font-bold text-lg">Información Profesional</h2>
                <i class="fas fa-briefcase text-3xl"></i>
            </div>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 gap-4">
                <div>
                    <span class="text-gray-600 text-sm block">Especialidad:</span>
                    <span class="font-medium">{{ $docente->especialidad }}</span>
                </div>
                <div>
                    <span class="text-gray-600 text-sm block">Cargo:</span>
                    <span class="font-medium">{{ $docente->cargo }}</span>
                </div>
                <div>
                    <span class="text-gray-600 text-sm block">Departamento:</span>
                    <span class="font-medium">
                        @if($docente->departamentoObj)
                            <a href="{{ route('institucion.departamentos.show', $docente->departamentoObj->id) }}" class="text-primary hover:underline">
                                {{ $docente->departamentoObj->nombre }}
                            </a>
                        @elseif($docente->departamento)
                            {{ $docente->departamento }}
                        @else
                            <span class="text-gray-400">No asignado</span>
                        @endif
                    </span>
                </div>
                <div>
                    <span class="text-gray-600 text-sm block">Fecha de alta:</span>
                    <span class="font-medium">{{ $docente->created_at->format('d/m/Y') }}</span>
                </div>
                @if($docente->esJefeDepartamento())
                <div>
                    <span class="text-gray-600 text-sm block">Jefe de departamento:</span>
                    <span class="font-medium text-green-600">Sí</span>
                </div>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Clases Asignadas -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="p-5 bg-green-600 text-white">
            <div class="flex justify-between items-center">
                <h2 class="font-bold text-lg">Clases Asignadas</h2>
                <i class="fas fa-graduation-cap text-3xl"></i>
            </div>
        </div>
        <div class="p-6">
            @if($docente->clases->count() > 0)
                <ul class="divide-y divide-gray-200">
                    @foreach($docente->clases as $clase)
                        <li class="py-2">
                            <a href="{{ route('institucion.clases.show', $clase->id) }}" class="flex justify-between items-center hover:bg-gray-50 p-2 rounded transition">
                                <div>
                                    <span class="font-medium text-gray-800">{{ $clase->nombre }}</span>
                                    <div class="text-xs text-gray-500">
                                        {{ $clase->nivel }} • {{ $clase->curso }} 
                                        @if($clase->grupo) • Grupo {{ $clase->grupo }} @endif
                                    </div>
                                </div>
                                <span class="text-primary">
                                    <i class="fas fa-chevron-right"></i>
                                </span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            @else
                <div class="text-center py-4 text-gray-500">
                    <i class="fas fa-info-circle mb-2 text-2xl"></i>
                    <p>No hay clases asignadas a este docente.</p>
                </div>
            @endif
            
            <div class="mt-4 pt-4 border-t">
                <a href="javascript:void(0)" onclick="openModalClase()" class="text-primary hover:text-primary-dark font-medium flex items-center justify-center">
                    <i class="fas fa-plus-circle mr-2"></i> Asignar una nueva clase
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Estudiantes asociados -->
<div class="mt-6 bg-white rounded-lg shadow p-6">
    <h2 class="text-xl font-semibold mb-4">Estudiantes</h2>
    
    @if($docente->estudiantes->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Clase</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($docente->estudiantes as $estudiante)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <img class="h-10 w-10 rounded-full" src="https://ui-avatars.com/api/?name={{ urlencode($estudiante->user->nombre) }}&background=7705B6&color=fff" alt="{{ $estudiante->user->nombre }}">
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $estudiante->user->nombre }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $estudiante->user->email }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    @if($estudiante->clase)
                                        <a href="{{ route('institucion.clases.show', $estudiante->clase->id) }}" class="text-primary hover:underline">
                                            {{ $estudiante->clase->nombre }}
                                        </a>
                                    @else
                                        <span class="text-gray-400">No asignado</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="#" class="text-indigo-600 hover:text-indigo-900">Ver perfil</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="text-center py-8 border rounded-lg bg-gray-50">
            <i class="fas fa-user-graduate text-gray-400 text-4xl mb-3"></i>
            <p class="text-gray-500">No hay estudiantes asignados a este docente.</p>
        </div>
    @endif
</div>

<!-- Acciones -->
<div class="mt-6 flex justify-end space-x-3">
    <button onclick="openEditModal({{ $docente->id }})" class="px-4 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600 transition">
        <i class="fas fa-edit mr-2"></i> Editar Docente
    </button>
    <form action="{{ route('institucion.docentes.toggle-active', $docente->id) }}" method="POST" class="inline-block">
        @csrf
        @method('POST')
        <button type="submit" class="px-4 py-2 {{ $docente->activo ? 'bg-red-500 hover:bg-red-600' : 'bg-green-500 hover:bg-green-600' }} text-white rounded-md transition">
            <i class="fas {{ $docente->activo ? 'fa-user-slash' : 'fa-user-check' }} mr-2"></i>
            {{ $docente->activo ? 'Desactivar Docente' : 'Activar Docente' }}
        </button>
    </form>
    <form action="{{ route('institucion.docentes.destroy', $docente->id) }}" method="POST" class="inline-block delete-form">
        @csrf
        @method('DELETE')
        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition">
            <i class="fas fa-trash-alt mr-2"></i> Eliminar Docente
        </button>
    </form>
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
                <input type="hidden" name="docente_id" value="{{ $docente->id }}">
                
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
                                        @foreach($departamentos ?? [] as $departamento)
                                            <option value="{{ $departamento->id }}">
                                                {{ $departamento->nombre }}
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
                                    <label for="nivel" class="block text-sm font-medium text-gray-700 mb-1">Nivel *</label>
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

@push('scripts')
<script>
    // Función para abrir el modal de edición
    function openEditModal(id) {
        console.log("Abriendo modal de edición para docente ID:", id);
        // Redirigir a la página principal con parámetros para abrir el modal
        window.location.href = "{{ route('institucion.docentes.index') }}?editModal=true&id=" + id;
    }

    // Si hay información de contraseña reseteada, mostrarla en la consola
    @if(session('success') && strpos(session('success'), 'Contraseña reseteada') !== false)
        console.log('%c CONTRASEÑA RESETEADA ', 'background: #2196F3; color: white; font-size: 12px; font-weight: bold; padding: 5px;');
        console.log('%c Email: ' + '{{ $docente->user->email }}', 'color: #333; font-size: 14px; font-weight: bold;');
        console.log('%c Nueva contraseña: ' + '{{ str_replace("Contraseña reseteada correctamente. Nueva contraseña temporal: ", "", session("success")) }}', 'color: #E91E63; font-size: 14px; font-weight: bold;');
        console.log('%c Guarde esta contraseña ya que no se mostrará nuevamente. ', 'background: #FFC107; color: #333; font-size: 12px; padding: 3px;');
    @endif

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

    // Script para confirmar eliminación
    document.addEventListener('DOMContentLoaded', function() {
        const deleteForms = document.querySelectorAll('.delete-form');
        
        deleteForms.forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                if (confirm('¿Estás seguro de que deseas eliminar este docente? Esta acción no se puede deshacer y eliminará toda la información asociada.')) {
                    this.submit();
                }
            });
        });

        // Verificar si hay un parámetro para abrir el modal de edición
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('editModal') && urlParams.get('editModal') === 'true') {
            const id = urlParams.get('id') || {{ $docente->id }};
            openEditModal(id);
        }
        
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

    // Funciones para el modal de clase
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
            
            // Scroll al inicio del modal y focus primer input
            setTimeout(() => {
                const firstInput = modal.querySelector('input, select, textarea');
                if (firstInput) firstInput.focus();
            }, 300);
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
    }

    // Función para copiar la contraseña al portapapeles
    function copyPassword() {
        const passwordText = document.getElementById('passwordText');
        const copyMessage = document.getElementById('copyMessage');
        
        if (passwordText) {
            const range = document.createRange();
            range.selectNode(passwordText);
            window.getSelection().removeAllRanges();
            window.getSelection().addRange(range);
            document.execCommand('copy');
            window.getSelection().removeAllRanges();
            
            copyMessage.classList.remove('hidden');
            setTimeout(() => {
                copyMessage.classList.add('hidden');
            }, 2000);
        }
    }
</script>
@endpush 