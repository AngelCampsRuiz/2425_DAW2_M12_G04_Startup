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
                        <select name="categoria_id" id="categoria_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
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
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Confirmar Eliminación</h3>
                <p class="text-sm text-gray-500">¿Estás seguro de que deseas eliminar esta subcategoría?</p>
                
                <form id="form-eliminar" method="POST" class="mt-4">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" id="eliminar_id" name="subcategoria_id">
                    
                    <div class="flex justify-end space-x-3">
                        <button type="button" id="btn-cancelar-eliminar" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded transition duration-300">
                            Cancelar
                        </button>
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded transition duration-300">
                            Eliminar
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
            
            // Botón de eliminar (delegación mejorada)
            const btnEliminar = e.target.closest('.btn-eliminar');
            if (btnEliminar) {
                e.preventDefault(); // Evitar comportamiento por defecto
                const id = btnEliminar.getAttribute('data-id');
                document.getElementById('eliminar_id').value = id;
                document.getElementById('form-eliminar').setAttribute('action', '{{ route('admin.subcategorias.destroy', ['subcategoria' => '__ID__']) }}'.replace('__ID__', id));
                document.getElementById('modal-eliminar').classList.remove('hidden');
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
        
        // Formulario de eliminar
        const formEliminar = document.getElementById('form-eliminar');
        if (formEliminar) {
            formEliminar.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Obtener el ID directamente
                const subcategoriaId = document.getElementById('eliminar_id').value;
                if (!subcategoriaId) {
                    console.error("Error: ID de subcategoría no encontrado para eliminación");
                    mostrarNotificacion('Error: ID de subcategoría no encontrado', 'error');
                    return;
                }
                
                const url = '{{ route('admin.subcategorias.destroy', ['subcategoria' => '__ID__']) }}'.replace('__ID__', subcategoriaId);
                const formData = new FormData(this);
                console.log("Enviando eliminación para ID:", subcategoriaId, "a URL:", url);
                
                fetch(url, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    document.getElementById('modal-eliminar').classList.add('hidden');
                    
                    console.log('Respuesta eliminación:', data);
                    if (data.success) {
                        mostrarNotificacion(data.message || 'Subcategoría eliminada correctamente', 'success');
                        actualizarTabla();
                    } else if (data.message) {
                        mostrarNotificacion(data.message, 'error');
                    } else {
                        mostrarNotificacion('Error al eliminar la subcategoría', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error al eliminar:', error);
                    mostrarNotificacion('Error al intentar eliminar la subcategoría', 'error');
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
</script>
@endsection 