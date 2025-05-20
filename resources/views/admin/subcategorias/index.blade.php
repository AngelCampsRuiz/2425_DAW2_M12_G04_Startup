@extends('admin.dashboard')

@section('admin_content')
<div class="container mx-auto px-4 py-6">
    <!-- Mensaje de éxito/error -->
    @if(session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
        <p>{{ session('success') }}</p>
    </div>
    @endif

    @if(session('error'))
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
        <p>{{ session('error') }}</p>
    </div>
    @endif

    <!-- Notificación AJAX -->
    <div id="ajax-notification" class="hidden bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
        <p id="notification-text"></p>
    </div>

    <!-- Filtros -->
    <div class="bg-gradient-to-r from-purple-50 to-indigo-50 rounded-xl shadow-md p-6 mb-8 border border-purple-100">
        <div class="flex flex-col md:flex-row justify-between items-center mb-6">
            <div class="flex items-center mb-4 md:mb-0">
                <svg class="w-5 h-5 text-purple-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                </svg>
                <h3 class="text-lg font-semibold text-purple-800">Filtros de búsqueda</h3>
            </div>
            <button id="reset-filtros" class="inline-flex items-center px-4 py-2 bg-white border border-purple-200 rounded-lg font-medium text-sm text-purple-700 hover:bg-purple-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-colors duration-150 shadow-sm">
                <svg class="w-4 h-4 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                Reiniciar filtros
            </button>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            <div class="relative">
                <label for="filtro_nombre" class="block text-sm font-medium text-purple-700 mb-2">Nombre de la subcategoría</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" id="filtro_nombre" class="pl-10 w-full rounded-lg border-purple-200 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50" placeholder="Buscar por nombre...">
                </div>
            </div>
            
            <div class="relative">
                <label for="filtro_categoria" class="block text-sm font-medium text-purple-700 mb-2">Categoría</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                        </svg>
                    </div>
                    <select id="filtro_categoria" class="pl-10 w-full rounded-lg border-purple-200 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50 appearance-none bg-white">
                        <option value="">Todas las categorías</option>
                        @foreach($categorias as $categoria)
                            <option value="{{ $categoria->id }}">{{ $categoria->nombre_categoria }}</option>
                        @endforeach
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                        <svg class="w-5 h-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="relative">
                <label for="filtro_publicaciones" class="block text-sm font-medium text-purple-700 mb-2">Publicaciones</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <select id="filtro_publicaciones" class="pl-10 w-full rounded-lg border-purple-200 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50 appearance-none bg-white">
                        <option value="">Todas</option>
                        <option value="0">Sin publicaciones</option>
                        <option value="1">Con publicaciones</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                        <svg class="w-5 h-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>
            </div>
            
            <div class="relative">
                <label for="filtro_estado" class="block text-sm font-medium text-purple-700 mb-2">Estado</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <select id="filtro_estado" class="pl-10 w-full rounded-lg border-purple-200 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50 appearance-none bg-white">
                        <option value="">Todas</option>
                        <option value="1">Activas</option>
                        <option value="0">Inactivas</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                        <svg class="w-5 h-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Botón para crear nueva subcategoría -->
    <div class="flex justify-between items-center mb-4">
        <div class="text-sm text-gray-600">
            Mostrando {{ $subcategorias->count() }} subcategorías de {{ $subcategorias->total() }}
        </div>
        <button class="btn-crear bg-purple-600 text-white px-4 py-2 rounded-md hover:bg-purple-700 transition-colors duration-200">
            Nueva Subcategoría
        </button>
    </div>

    <!-- Contenedor de la tabla -->
    <div id="tabla-container">
        @include('admin.subcategorias.tabla')
    </div>

    <!-- Modal de subcategoría -->
    <div id="modal-subcategoria" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 id="modal-titulo" class="text-lg leading-6 font-medium text-gray-900 mb-4"></h3>
                
                <!-- Formulario -->
                <form id="form-subcategoria" method="POST" class="space-y-4">
                    @csrf
                    <input type="hidden" id="form_method" name="_method" value="POST">
                    <input type="hidden" id="subcategoria_id" name="id">
                    
                    <div>
                        <label for="nombre_subcategoria" class="block text-sm font-medium text-gray-700">Nombre de la Subcategoría</label>
                        <input type="text" name="nombre_subcategoria" id="nombre_subcategoria" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                    </div>
                    
                    <div>
                        <label for="categoria_id" class="block text-sm font-medium text-gray-700">Categoría</label>
                        <select name="categoria_id" id="categoria_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                            <option value="">Seleccione una categoría</option>
                            @foreach($categorias as $categoria)
                                <option value="{{ $categoria->id }}">{{ $categoria->nombre_categoria }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- Mensajes de error -->
                    <div id="form-errors" class="hidden bg-red-100 border-l-4 border-red-500 text-red-700 p-4">
                        <ul id="error-list"></ul>
                    </div>
                    
                    <!-- Botones -->
                    <div class="flex justify-end space-x-3">
                        <button type="button" id="btn-cancelar" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded transition duration-300">
                            Cancelar
                        </button>
                        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded transition duration-300">
                            Guardar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal de confirmación de eliminación -->
    <div id="modal-eliminar" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 id="action-title" class="text-lg leading-6 font-medium text-gray-900 mb-4">Confirmar Desactivación</h3>
                <p id="action-message" class="text-sm text-gray-500">¿Estás seguro de que deseas desactivar esta subcategoría? Las subcategorías desactivadas no serán visibles para los usuarios.</p>
                
                <form id="form-eliminar" method="POST" class="mt-4">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="eliminar_id" name="subcategoria_id">
                    <input type="hidden" id="is_active" name="activo" value="0">
                    
                    <div class="flex justify-end space-x-3">
                        <button type="button" id="btn-cancelar-eliminar" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded transition duration-300">
                            Cancelar
                        </button>
                        <button type="submit" id="action-button" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded transition duration-300">
                            Desactivar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .pagination-link {
        @apply px-3 py-1 rounded-lg transition-colors duration-200;
    }
    .pagination-link:not(.active) {
        @apply text-gray-500 hover:text-purple-600 hover:bg-purple-100;
    }
    .pagination-link.active {
        @apply bg-purple-600 text-white;
    }
    .pagination span.text-gray-500 {
        @apply px-3 py-1;
    }
</style>

<!-- Script para manejar los eventos -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Registrar delegación de eventos una sola vez
    initEventListeners();
    
    function initEventListeners() {
        // Delegación de eventos para todos los botones y formularios
        document.addEventListener('click', function(e) {
            // Botón de crear
            if (e.target.closest('.btn-crear')) {
                e.preventDefault(); // Evitar comportamiento por defecto
                resetForm();
                document.getElementById('modal-titulo').textContent = 'Crear Nueva Subcategoría';
                document.getElementById('form-subcategoria').setAttribute('action', '{{ route('admin.subcategorias.store') }}');
                document.getElementById('form_method').value = 'POST';
                document.getElementById('modal-subcategoria').classList.remove('hidden');
            }
            
            // Botón de editar (delegación mejorada)
            const btnEditar = e.target.closest('.btn-editar');
            if (btnEditar) {
                e.preventDefault(); // Evitar comportamiento por defecto
                const id = btnEditar.getAttribute('data-id');
                cargarSubcategoria(id);
            }
            
            // Botón de eliminar/desactivar (delegación mejorada)
            const btnEliminar = e.target.closest('.btn-eliminar');
            if (btnEliminar) {
                e.preventDefault(); // Evitar comportamiento por defecto
                const id = btnEliminar.getAttribute('data-id');
                verificarEstadoSubcategoria(id);
            }
            
            // Botones de cerrar y cancelar
            if (e.target.closest('#btn-cancelar')) {
                e.preventDefault(); // Evitar comportamiento por defecto
                document.getElementById('modal-subcategoria').classList.add('hidden');
                resetForm();
            }
            
            if (e.target.closest('#btn-cancelar-eliminar')) {
                e.preventDefault(); // Evitar comportamiento por defecto
                document.getElementById('modal-eliminar').classList.add('hidden');
            }
            
            // Enlaces de paginación (selector mejorado)
            const paginationLink = e.target.closest('.pagination a') || e.target.closest('a[href*="page="]');
            if (paginationLink) {
                e.preventDefault();
                const url = paginationLink.getAttribute('href');
                actualizarTabla(url);
            }
        });
        
        // Manejo del formulario de desactivación/activación
        const formEliminar = document.getElementById('form-eliminar');
        if (formEliminar) {
            formEliminar.addEventListener('submit', function(e) {
                e.preventDefault();
                const id = document.getElementById('eliminar_id').value;
                const isActive = document.getElementById('is_active').value === '1';
                
                fetch(`/admin/subcategorias/${id}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({
                        _method: 'PUT',
                        activo: isActive ? 0 : 1
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('modal-eliminar').classList.add('hidden');
                        mostrarNotificacion(data.message);
                        actualizarTabla();
                    } else {
                        alert(data.message || 'Ha ocurrido un error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Ha ocurrido un error al procesar la solicitud');
                });
            });
        }

        // Función para verificar el estado de la subcategoría antes de mostrar el modal
        function verificarEstadoSubcategoria(id) {
            fetch(`/admin/subcategorias/${id}/edit`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                const isActive = data.subcategoria.activo;
                document.getElementById('eliminar_id').value = id;
                document.getElementById('is_active').value = isActive ? '1' : '0';
                document.getElementById('form-eliminar').setAttribute('action', `/admin/subcategorias/${id}`);
                
                // Actualizar título y mensaje según el estado
                if (isActive) {
                    document.getElementById('action-title').textContent = 'Confirmar Desactivación';
                    document.getElementById('action-message').textContent = '¿Estás seguro de que deseas desactivar esta subcategoría? Las subcategorías desactivadas no serán visibles para los usuarios.';
                    document.getElementById('action-button').textContent = 'Desactivar';
                    document.getElementById('action-button').classList.remove('bg-green-600', 'hover:bg-green-700');
                    document.getElementById('action-button').classList.add('bg-red-600', 'hover:bg-red-700');
                } else {
                    document.getElementById('action-title').textContent = 'Confirmar Activación';
                    document.getElementById('action-message').textContent = '¿Estás seguro de que deseas activar esta subcategoría? Las subcategorías activas serán visibles para los usuarios.';
                    document.getElementById('action-button').textContent = 'Activar';
                    document.getElementById('action-button').classList.remove('bg-red-600', 'hover:bg-red-700');
                    document.getElementById('action-button').classList.add('bg-green-600', 'hover:bg-green-700');
                }
                
                document.getElementById('modal-eliminar').classList.remove('hidden');
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al obtener información de la subcategoría');
            });
        }
        
        // Función para cargar subcategoría
        function cargarSubcategoria(id) {
            console.log('Cargando subcategoría ID:', id);
            fetch('{{ route('admin.subcategorias.edit', ['subcategoria' => '__ID__']) }}'.replace('__ID__', id), {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                console.log('Datos de subcategoría recibidos:', data);
                if (data.success) {
                    resetForm();
                    
                    const subcategoria = data.subcategoria;
                    
                    const subcategoriaIdField = document.getElementById('subcategoria_id');
                    const nombreField = document.getElementById('nombre_subcategoria');
                    const categoriaField = document.getElementById('categoria_id');
                    const tituloModal = document.getElementById('modal-titulo');
                    const formSubcategoria = document.getElementById('form-subcategoria');
                    const modalSubcategoria = document.getElementById('modal-subcategoria');
                    
                    if (subcategoriaIdField) subcategoriaIdField.value = subcategoria.id;
                    if (nombreField) nombreField.value = subcategoria.nombre_subcategoria;
                    if (categoriaField) categoriaField.value = subcategoria.categoria_id;
                    
                    if (tituloModal) tituloModal.textContent = 'Editar Subcategoría';
                    if (formSubcategoria) formSubcategoria.setAttribute('action', '{{ route('admin.subcategorias.update', ['subcategoria' => '__ID__']) }}'.replace('__ID__', id));
                    
                    const formMethodField = document.getElementById('form_method');
                    if (formMethodField) formMethodField.value = 'PUT';
                    
                    if (modalSubcategoria) modalSubcategoria.classList.remove('hidden');
                } else {
                    mostrarNotificacion('Error al cargar la subcategoría', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                mostrarNotificacion('Error al cargar la subcategoría', 'error');
            });
        }
        
        // Manejo de envío de formularios
        const formSubcategoria = document.getElementById('form-subcategoria');
        if (formSubcategoria) {
            formSubcategoria.addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                const url = this.getAttribute('action');
                const method = document.getElementById('form_method').value;
                
                if (method === 'PUT') {
                    formData.append('_method', 'PUT');
                }
                
                console.log('Enviando datos:', {
                    url: url,
                    method: method,
                    nombre: formData.get('nombre_subcategoria'),
                    categoria: formData.get('categoria_id')
                });
                
                fetch(url, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => {
                    console.log('Respuesta recibida:', response.status);
                    return response.json();
                })
                .then(data => {
                    console.log('Datos recibidos:', data);
                    if (data.success) {
                        document.getElementById('modal-subcategoria').classList.add('hidden');
                        mostrarNotificacion(data.message, 'success');
                        actualizarTabla();
                        resetForm();
                    } else if (data.errors) {
                        mostrarErrores(data.errors);
                    } else if (data.message) {
                        mostrarNotificacion(data.message, 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    mostrarNotificacion('Ha ocurrido un error en la comunicación con el servidor', 'error');
                });
            });
        }
        
        // Detectar cuando se cierra el modal al hacer clic fuera de él
        const modales = document.querySelectorAll('#modal-subcategoria, #modal-eliminar');
        modales.forEach(modal => {
            modal.addEventListener('click', function(e) {
                if (e.target === this) {
                    this.classList.add('hidden');
                }
            });
        });
    }
    
    // Funciones auxiliares
    function resetForm() {
        const form = document.getElementById('form-subcategoria');
        if (form) {
            form.reset();
            const errorsDiv = document.getElementById('form-errors');
            const errorsList = document.getElementById('error-list');
            if (errorsDiv) {
                errorsDiv.classList.add('hidden');
            }
            if (errorsList) {
                errorsList.innerHTML = '';
            }
        }
    }
    
    function mostrarNotificacion(mensaje, tipo) {
        const notification = document.getElementById('ajax-notification');
        const notificationText = document.getElementById('notification-text');
        
        if (!notification || !notificationText) return;
        
        // Cambiar el estilo según el tipo de notificación
        if (tipo === 'success') {
            notification.className = 'bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4';
        } else {
            notification.className = 'bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4';
        }
        
        notificationText.textContent = mensaje;
        notification.classList.remove('hidden');
        
        // Desplazarse al principio para ver la notificación
        window.scrollTo(0, 0);
        
        // Ocultar después de 3 segundos
        setTimeout(function() {
            notification.classList.add('hidden');
        }, 5000);
    }
    
    function mostrarErrores(errores) {
        const errorsDiv = document.getElementById('form-errors');
        const errorsList = document.getElementById('error-list');
        
        if (!errorsDiv || !errorsList) return;
        
        errorsList.innerHTML = '';
        
        if (typeof errores === 'object') {
            Object.values(errores).forEach(errorArray => {
                if (Array.isArray(errorArray)) {
                    errorArray.forEach(error => {
                        const li = document.createElement('li');
                        li.textContent = error;
                        errorsList.appendChild(li);
                    });
                } else {
                    const li = document.createElement('li');
                    li.textContent = errorArray;
                    errorsList.appendChild(li);
                }
            });
        } else {
            const li = document.createElement('li');
            li.textContent = 'Error al procesar la solicitud';
            errorsList.appendChild(li);
        }
        
        errorsDiv.classList.remove('hidden');
    }
    
    function actualizarTabla(url = '{{ route('admin.subcategorias.index') }}') {
        console.log('Actualizando tabla desde URL:', url);
        fetch(url, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            const tablaContainer = document.getElementById('tabla-container');
            if (tablaContainer) {
                tablaContainer.innerHTML = data.tabla;
                console.log('Tabla actualizada');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            mostrarNotificacion('Error al actualizar la tabla', 'error');
        });
    }
});

let timeoutId = null;

// Eventos para filtrado automático
document.getElementById('filtro_nombre').addEventListener('input', debounceFilter);
document.getElementById('filtro_categoria').addEventListener('change', aplicarFiltros);
document.getElementById('filtro_publicaciones').addEventListener('change', aplicarFiltros);
document.getElementById('filtro_estado').addEventListener('change', aplicarFiltros);

// Resetear filtros
document.getElementById('reset-filtros').addEventListener('click', function() {
    document.getElementById('filtro_nombre').value = '';
    document.getElementById('filtro_categoria').value = '';
    document.getElementById('filtro_publicaciones').value = '';
    document.getElementById('filtro_estado').value = '';
    aplicarFiltros();
});

// Función para debounce en campos de texto
function debounceFilter() {
    if (timeoutId) {
        clearTimeout(timeoutId);
    }
    timeoutId = setTimeout(() => {
        aplicarFiltros();
    }, 300);
}

function aplicarFiltros() {
    const filtros = {
        nombre: document.getElementById('filtro_nombre').value,
        categoria: document.getElementById('filtro_categoria').value,
        publicaciones: document.getElementById('filtro_publicaciones').value,
        activo: document.getElementById('filtro_estado').value
    };
    
    const params = new URLSearchParams();
    Object.entries(filtros).forEach(([key, value]) => {
        if (value) {
            params.append(key, value);
        }
    });
    
    refreshTable(params.toString());
}

function refreshTable(queryString = '') {
    const url = queryString 
        ? `/admin/subcategorias?${queryString}`
        : '/admin/subcategorias';

    fetch(url, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.tabla) {
            document.getElementById('tabla-container').innerHTML = data.tabla;
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

// Añadir la función openEditModal que falta
window.openEditModal = function(id) {
    cargarSubcategoria(id);
};

// Añadir la función openDeleteModal que falta
window.openDeleteModal = function(id) {
    verificarEstadoSubcategoria(id);
};
</script>

<!-- Script de validaciones para subcategorías -->
<script src="{{ asset('js/subcategorias-validaciones.js') }}"></script>
@endsection 