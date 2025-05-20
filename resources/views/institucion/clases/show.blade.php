@extends('layouts.institucion')

@section('title', 'Detalles de la Clase')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Detalles de la Clase</h1>
    <div class="flex space-x-2">
        <button onclick="openModalEdit({{ $clase->id }})" class="px-4 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600 transition">
            <i class="fas fa-edit mr-2"></i> Editar
        </button>
        <a href="{{ route('institucion.clases.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition">
            <i class="fas fa-arrow-left mr-2"></i> Volver al listado
        </a>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <!-- Información Básica -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="p-5 bg-primary text-white">
            <div class="flex justify-between items-center">
                <h2 class="font-bold text-lg">Información General</h2>
                <i class="fas fa-graduation-cap text-3xl"></i>
            </div>
        </div>
        <div class="p-6">
            <div class="flex items-center mb-6">
                <div class="flex-shrink-0 mr-4">
                    <div class="h-24 w-24 rounded-full bg-blue-100 text-blue-800 flex items-center justify-center text-3xl font-bold">
                        {{ substr($clase->nombre, 0, 1) }}
                    </div>
                </div>
                <div>
                    <h3 class="text-xl font-semibold text-gray-800">{{ $clase->nombre }}</h3>
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $clase->activa ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $clase->activa ? 'Activa' : 'Inactiva' }}
                    </span>
                </div>
            </div>
            
            <div class="border-t pt-4">
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <span class="text-gray-600 text-sm block">Código:</span>
                        <span class="font-medium">{{ $clase->codigo }}</span>
                    </div>
                    <div>
                        <span class="text-gray-600 text-sm block">Nivel Educativo:</span>
                        <span class="font-medium">{{ $clase->nivel }}</span>
                    </div>
                    <div>
                        <span class="text-gray-600 text-sm block">Curso:</span>
                        <span class="font-medium">{{ $clase->curso }}</span>
                    </div>
                    @if($clase->grupo)
                    <div>
                        <span class="text-gray-600 text-sm block">Grupo:</span>
                        <span class="font-medium">{{ $clase->grupo }}</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <!-- Información del Departamento y Docente -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="p-5 bg-blue-600 text-white">
            <div class="flex justify-between items-center">
                <h2 class="font-bold text-lg">Departamento y Docente</h2>
                <i class="fas fa-briefcase text-3xl"></i>
            </div>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 gap-4">
                <div>
                    <span class="text-gray-600 text-sm block">Departamento:</span>
                    <span class="font-medium">
                        @if($clase->departamento)
                            <a href="{{ route('institucion.departamentos.show', $clase->departamento->id) }}" class="text-primary hover:underline">
                                {{ $clase->departamento->nombre }}
                            </a>
                        @else
                            <span class="text-gray-400">No asignado</span>
                        @endif
                    </span>
                </div>
                <div>
                    <span class="text-gray-600 text-sm block">Docente Responsable:</span>
                    <span class="font-medium" id="docente-info">
                        @if($clase->docente)
                            <a href="{{ route('institucion.docentes.show', $clase->docente->id) }}" class="text-primary hover:underline">
                                {{ $clase->docente->user->nombre }}
                            </a>
                            @if(config('app.debug'))
                            <small class="text-xs text-gray-500 mt-1 block">ID: {{ $clase->docente_id }} | Última actualización: {{ now()->format('H:i:s') }}</small>
                            @endif
                        @else
                            <span class="text-gray-400">No asignado</span>
                            @if(config('app.debug'))
                            <small class="text-xs text-gray-500 mt-1 block">docente_id es NULL | Última actualización: {{ now()->format('H:i:s') }}</small>
                            @endif
                        @endif
                    </span>
                </div>
                @if($clase->docente && $clase->docente->especialidad)
                <div>
                    <span class="text-gray-600 text-sm block">Especialidad del Docente:</span>
                    <span class="font-medium">{{ $clase->docente->especialidad }}</span>
                </div>
                @endif
                <div>
                    <span class="text-gray-600 text-sm block">Fecha de creación:</span>
                    <span class="font-medium">{{ $clase->created_at->format('d/m/Y') }}</span>
                </div>
                @if($clase->descripcion)
                <div class="mt-2 pt-2 border-t">
                    <span class="text-gray-600 text-sm block">Descripción:</span>
                    <p class="font-medium mt-1">{{ $clase->descripcion }}</p>
                </div>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Estadísticas y Acciones -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="p-5 bg-green-600 text-white">
            <div class="flex justify-between items-center">
                <h2 class="font-bold text-lg">Estadísticas</h2>
                <i class="fas fa-chart-bar text-3xl"></i>
            </div>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 gap-4">
                <div class="p-4 bg-blue-50 rounded-lg">
                    <div class="flex items-center">
                        <div class="p-2 bg-blue-100 rounded-full mr-3">
                            <i class="fas fa-user-graduate text-blue-600"></i>
                        </div>
                        <div>
                            <span class="text-gray-600 text-sm">Estudiantes:</span>
                            <span class="font-bold text-lg block">{{ $clase->estudiantes->count() }}</span>
                        </div>
                    </div>
                </div>
                
                <div class="mt-4 pt-4 border-t">
                    <h3 class="font-medium text-gray-700 mb-2">Acciones Rápidas</h3>
                    <a href="{{ route('institucion.clases.asignar-estudiantes', $clase->id) }}" class="text-primary hover:text-primary-dark font-medium flex items-center mb-2">
                        <i class="fas fa-user-plus mr-2"></i> Asignar estudiantes
                    </a>
                    
                    <form action="{{ route('institucion.clases.toggle-active', $clase->id) }}" method="POST" class="mb-2">
                        @csrf
                        <button type="submit" class="text-primary hover:text-primary-dark font-medium flex items-center">
                            <i class="fas {{ $clase->activa ? 'fa-toggle-off' : 'fa-toggle-on' }} mr-2"></i>
                            {{ $clase->activa ? 'Desactivar clase' : 'Activar clase' }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Estudiantes asociados -->
<div class="mt-6 bg-white rounded-lg shadow p-6">
    <h2 class="text-xl font-semibold mb-4">Estudiantes de la Clase</h2>
    
    @if($clase->estudiantes->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">DNI</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($clase->estudiantes as $estudiante)
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
                                <div class="text-sm text-gray-900">{{ $estudiante->user->dni }}</div>
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
            <p class="text-gray-500">No hay estudiantes asignados a esta clase.</p>
            <a href="{{ route('institucion.clases.asignar-estudiantes', $clase->id) }}" class="mt-4 inline-flex items-center px-4 py-2 bg-primary text-white rounded-md hover:bg-primary-dark transition">
                <i class="fas fa-user-plus mr-2"></i> Asignar estudiantes
            </a>
        </div>
    @endif
</div>

<!-- Acciones del Pie de Página -->
<div class="mt-6 flex justify-end space-x-3">
    <button onclick="openModalEdit({{ $clase->id }})" class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600 flex items-center focus:outline-none focus:ring-2 focus:ring-yellow-400">
        <i class="fas fa-edit mr-2"></i> Editar
    </button>
    
    <form action="{{ route('institucion.clases.toggle-active', $clase->id) }}" method="POST" class="inline">
        @csrf
        <button type="submit" class="px-4 py-2 {{ $clase->activa ? 'bg-red-500 hover:bg-red-600' : 'bg-green-500 hover:bg-green-600' }} text-white rounded flex items-center focus:outline-none focus:ring-2 focus:ring-{{ $clase->activa ? 'red' : 'green' }}-400">
            <i class="fas {{ $clase->activa ? 'fa-ban' : 'fa-check' }} mr-2"></i> {{ $clase->activa ? 'Desactivar' : 'Activar' }}
        </button>
    </form>
    
    <form action="{{ route('institucion.clases.destroy', $clase->id) }}" method="POST" class="inline delete-form">
        @csrf
        @method('DELETE')
        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 flex items-center focus:outline-none focus:ring-2 focus:ring-red-400">
            <i class="fas fa-trash-alt mr-2"></i> Eliminar
        </button>
    </form>
</div>

<script>
// Script para confirmar eliminación
document.addEventListener('DOMContentLoaded', function() {
    console.log('---- INICIO DE DEPURACIÓN DE CLASE ----');
    console.log('Clase ID actual:', {{ $clase->id }});
    console.log('Docente ID actual:', '{{ $clase->docente_id }}');
    console.log('Docente nombre actual:', '{{ $clase->docente ? $clase->docente->user->nombre : "No asignado" }}');
    console.log('QueryString:', window.location.search);
    
    const deleteForms = document.querySelectorAll('.delete-form');
    
    deleteForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            if (confirm('¿Estás seguro de que deseas eliminar esta clase? Esta acción no se puede deshacer.')) {
                this.submit();
            }
        });
    });
    
    // Verificar si hay un parámetro para abrir el modal de edición
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('editModal') && urlParams.get('editModal') === 'true') {
        const id = urlParams.get('id') || {{ $clase->id }};
        openModalEdit(id);
    }
    
    // Configurar cerrar modal con Escape
    document.addEventListener('keydown', function(e) {
        const modal = document.getElementById('editClaseModal');
        if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
            cerrarModalEdit();
        }
    });
    
    // Cerrar modal al hacer clic en el fondo
    const modal = document.getElementById('editClaseModal');
    modal.addEventListener('click', function(e) {
        if (e.target === this) {
            cerrarModalEdit();
        }
    });
    
    // Configurar botones de cierre
    const closeButtons = document.querySelectorAll('.close-modal');
    closeButtons.forEach(button => {
        button.addEventListener('click', cerrarModalEdit);
    });
    
    // Añadir listener al select de nivel educativo para actualizar categorías
    const nivelSelect = document.getElementById('edit_nivel_educativo_id');
    if (nivelSelect) {
        nivelSelect.addEventListener('change', actualizarCategoriasPorNivel);
    }

    // Obtener la información actualizada del docente
    console.log('Iniciando petición AJAX para obtener datos actualizados...');
    fetch('/institucion/clases/{{ $clase->id }}/get-data')
        .then(response => {
            console.log('Respuesta recibida:', response.status);
            if (!response.ok) {
                throw new Error('Error en la respuesta: ' + response.status);
            }
            return response.json();
        })
        .then(data => {
            console.log('Datos recibidos:', data);
            if (data.clase && data.clase.docente_id) {
                console.log('Nuevo docente_id en la respuesta:', data.clase.docente_id);
                
                // Buscar el docente en la lista de docentes
                const docente = data.docentes.find(d => d.id == data.clase.docente_id);
                console.log('Docente encontrado:', docente);
                
                if (docente && docente.user) {
                    // Actualizar la información en la página
                    document.getElementById('docente-info').innerHTML = `
                        <a href="/institucion/docentes/${docente.id}" class="text-primary hover:underline">
                            ${docente.user.nombre}
                        </a>
                        @if(config('app.debug'))
                        <small class="text-xs text-gray-500 mt-1 block">ID: ${data.clase.docente_id} | Última actualización: ${new Date().toLocaleTimeString()}</small>
                        @endif
                    `;
                    console.log('Docente actualizado a:', docente.user.nombre);
                    
                    // Verificar si el docente mostrado es diferente del docente actual
                    if (data.clase.docente_id != {{ $clase->docente_id }}) {
                        console.log('ALERTA: El ID del docente ha cambiado en la base de datos pero no se refleja en la vista.');
                        console.log('ID en BD:', data.clase.docente_id);
                        console.log('ID en Vista:', {{ $clase->docente_id }});
                    }
                } else {
                    console.error('Error: Docente encontrado pero sin datos de usuario:', docente);
                }
            } else {
                console.log('No se encontró docente_id en los datos o es nulo.');
            }
        })
        .catch(error => {
            console.error('Error al obtener datos de la clase:', error);
        });
});

// Variable global para almacenar las categorías por nivel
let categoriasPorNivel = {};

// Función para actualizar las categorías según el nivel educativo seleccionado
function actualizarCategoriasPorNivel() {
    console.log('Actualizando categorías por nivel...');
    const nivelId = document.getElementById('edit_nivel_educativo_id').value;
    const categoriaSelect = document.getElementById('edit_categoria_id');
    
    console.log('Nivel seleccionado:', nivelId);
    console.log('Categorías disponibles:', categoriasPorNivel);
    
    // Limpiar opciones actuales
    categoriaSelect.innerHTML = '<option value="">Seleccionar categoría</option>';
    
    // Si no hay nivel seleccionado, salir
    if (!nivelId || !categoriasPorNivel[nivelId]) {
        console.log('No hay categorías para el nivel seleccionado');
        return;
    }
    
    // Añadir las categorías del nivel seleccionado
    categoriasPorNivel[nivelId].forEach(categoria => {
        const option = document.createElement('option');
        option.value = categoria.id;
        option.textContent = categoria.nombre_personalizado || categoria.nombre_categoria;
        categoriaSelect.appendChild(option);
    });
    
    console.log('Categorías actualizadas para el nivel:', nivelId);
}

// Función para abrir el modal de edición
function openModalEdit(claseId) {
    console.log('Abriendo modal de edición para clase ID:', claseId);
    
    // Obtener los datos de la clase mediante AJAX
    fetch(`/institucion/clases/${claseId}/get-data`)
        .then(response => {
            console.log('Respuesta de get-data:', response.status);
            if (!response.ok) {
                throw new Error('Error al obtener datos: ' + response.status);
            }
            return response.json();
        })
        .then(data => {
            console.log('Datos recibidos para el modal:', data);
            
            // Guardar las categorías por nivel en la variable global
            categoriasPorNivel = data.categoriasPorNivel;
            
            // Configurar la acción del formulario
            const formulario = document.getElementById('editClaseForm');
            formulario.action = `/institucion/clases/${claseId}`;
            console.log('Formulario configurado:', formulario.action);
            
            // Limpiar todos los event listeners anteriores del formulario
            const nuevoFormulario = formulario.cloneNode(true);
            formulario.parentNode.replaceChild(nuevoFormulario, formulario);
            
            // Rellenar los campos del formulario
            document.getElementById('edit_nombre').value = data.clase.nombre;
            document.getElementById('edit_codigo').value = data.clase.codigo;
            document.getElementById('edit_grupo').value = data.clase.grupo || '';
            document.getElementById('edit_capacidad').value = data.clase.capacidad || '';
            document.getElementById('edit_descripcion').value = data.clase.descripcion || '';
            document.getElementById('edit_activa').checked = data.clase.activa;
            
            // Poblar los selects con opciones
            const nivelSelect = document.getElementById('edit_nivel_educativo_id');
            nivelSelect.innerHTML = '<option value="">Seleccionar nivel</option>';
            data.nivelesEducativos.forEach(nivel => {
                const option = document.createElement('option');
                option.value = nivel.id;
                option.textContent = nivel.nombre_nivel;
                option.selected = nivel.id === data.clase.nivel_educativo_id;
                nivelSelect.appendChild(option);
            });
            
            // Poblar el select de categorías basado en el nivel seleccionado inicialmente
            const categoriaSelect = document.getElementById('edit_categoria_id');
            categoriaSelect.innerHTML = '<option value="">Seleccionar categoría</option>';
            
            if (data.clase.nivel_educativo_id && data.categoriasPorNivel[data.clase.nivel_educativo_id]) {
                data.categoriasPorNivel[data.clase.nivel_educativo_id].forEach(categoria => {
                    const option = document.createElement('option');
                    option.value = categoria.id;
                    option.textContent = categoria.nombre_personalizado || categoria.nombre_categoria;
                    option.selected = categoria.id === data.clase.categoria_id;
                    categoriaSelect.appendChild(option);
                });
            }
            
            const departamentoSelect = document.getElementById('edit_departamento_id');
            departamentoSelect.innerHTML = '<option value="">Seleccionar departamento</option>';
            data.departamentos.forEach(departamento => {
                const option = document.createElement('option');
                option.value = departamento.id;
                option.textContent = departamento.nombre;
                option.selected = departamento.id === data.clase.departamento_id;
                departamentoSelect.appendChild(option);
            });
            
            const docenteSelect = document.getElementById('edit_docente_id');
            docenteSelect.innerHTML = '<option value="">Seleccionar docente</option>';
            
            console.log('Docentes disponibles:', data.docentes);
            console.log('Docente actual ID:', data.clase.docente_id);
            
            // Forzar la limpieza del select de docentes
            while (docenteSelect.firstChild) {
                docenteSelect.removeChild(docenteSelect.firstChild);
            }
            
            // Añadir la opción por defecto
            const defaultOption = document.createElement('option');
            defaultOption.value = '';
            defaultOption.textContent = 'Seleccionar docente';
            docenteSelect.appendChild(defaultOption);
            
            // Añadir cada docente como opción
            data.docentes.forEach(docente => {
                const option = document.createElement('option');
                option.value = docente.id;
                option.textContent = docente.user.nombre;
                
                // Verificar si este docente es el seleccionado actualmente
                const esSeleccionado = docente.id == data.clase.docente_id;
                option.selected = esSeleccionado;
                
                console.log(`Docente ${docente.id} (${docente.user.nombre}) - Seleccionado: ${esSeleccionado}`);
                
                docenteSelect.appendChild(option);
            });
            
            // Disparar evento change para forzar actualización
            const changeEvent = new Event('change');
            docenteSelect.dispatchEvent(changeEvent);
            
            // Mostrar el modal con animación
            const modal = document.getElementById('editClaseModal');
            modal.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
            
            // Animar la entrada del modal
            setTimeout(() => {
                const modalContent = modal.querySelector('.relative');
                if (modalContent) {
                    modalContent.classList.add('animate-fadeIn');
                }
                
                // Focus al primer campo
                const firstInput = modal.querySelector('input, select');
                if (firstInput) firstInput.focus();
            }, 10);
        })
        .catch(error => {
            console.error('Error al obtener datos de la clase:', error);
            alert('Ocurrió un error al cargar los datos de la clase.');
        });
}

// Función para cerrar el modal
function cerrarModalEdit() {
    console.log('Cerrando modal de edición');
    const modal = document.getElementById('editClaseModal');
    
    // Animar la salida
    const modalContent = modal.querySelector('.relative');
    if (modalContent) {
        modalContent.classList.remove('animate-fadeIn');
        modalContent.classList.add('animate-fadeOut');
    }
    
    // Ocultar el modal después de la animación
    setTimeout(() => {
        modal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
        
        if (modalContent) {
            modalContent.classList.remove('animate-fadeOut');
        }
    }, 200);
}
</script>

<style>
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-20px); }
    to { opacity: 1; transform: translateY(0); }
}

@keyframes fadeOut {
    from { opacity: 1; transform: translateY(0); }
    to { opacity: 0; transform: translateY(-20px); }
}

.animate-fadeIn {
    animation: fadeIn 0.3s ease-out forwards;
}

.animate-fadeOut {
    animation: fadeOut 0.2s ease-in forwards;
}
</style>

@include('components.edit-clase-modal')
@endsection 