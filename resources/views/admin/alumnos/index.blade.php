@extends('admin.dashboard')

@section('admin_content')
    <!-- Mensaje de éxito -->
    <div id="success-message" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert" style="display: none;">
        <span id="success-message-text" class="block sm:inline"></span>
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
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-5">
            <div class="relative">
                <label for="filtro_nombre" class="block text-sm font-medium text-purple-700 mb-2">Nombre</label>
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
                <label for="filtro_email" class="block text-sm font-medium text-purple-700 mb-2">Email</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <input type="text" id="filtro_email" class="pl-10 w-full rounded-lg border-purple-200 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50" placeholder="Buscar por email...">
                </div>
            </div>

            <div class="relative">
                <label for="filtro_dni" class="block text-sm font-medium text-purple-700 mb-2">DNI</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                        </svg>
                    </div>
                    <input type="text" id="filtro_dni" class="pl-10 w-full rounded-lg border-purple-200 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50" placeholder="Buscar por DNI...">
                </div>
            </div>

            <div class="relative">
                <label for="filtro_ciudad" class="block text-sm font-medium text-purple-700 mb-2">Ciudad</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    <select id="filtro_ciudad" class="pl-10 w-full rounded-lg border-purple-200 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50 appearance-none bg-white">
                        <option value="">Todas las ciudades</option>
                        @foreach($ciudades as $ciudad)
                            <option value="{{ $ciudad }}">{{ $ciudad }}</option>
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
                <label for="filtro_estado" class="block text-sm font-medium text-purple-700 mb-2">Estado</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <select id="filtro_estado" class="pl-10 w-full rounded-lg border-purple-200 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50 appearance-none bg-white">
                        <option value="">Todos</option>
                        <option value="1">Activos</option>
                        <option value="0">Inactivos</option>
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
    
    <!-- Contenedor de la tabla -->
    <div id="tabla-container" class="bg-white rounded-lg shadow overflow-hidden">
        @include('admin.alumnos.tabla')
    </div>

    <!-- Modal Crear/Editar Alumno -->
    <div id="modal-alumno" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-start justify-center p-4 z-50 hidden overflow-y-auto">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-4xl my-8">
            <div class="sticky top-0 bg-white px-6 py-4 border-b">
                <div class="flex justify-between items-center">
                    <h2 id="modal-titulo" class="text-xl font-semibold text-gray-800">Crear Nuevo Alumno</h2>
                    <button id="modal-close" class="text-gray-500 hover:text-gray-700 focus:outline-none">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
            
            <div class="p-6">
                <!-- Mensajes de error del formulario -->
                <div id="form-errors" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6 hidden" role="alert">
                    <strong class="font-bold">¡Hay errores en el formulario!</strong>
                    <ul id="error-list" class="mt-2 list-disc list-inside"></ul>
                </div>
                
                <form id="form-alumno" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    <input type="hidden" id="alumno_id" name="alumno_id" value="">
                    <input type="hidden" id="form_method" name="_method" value="POST">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre <span class="text-red-500">*</span></label>
                            <input type="text" name="nombre" id="nombre" 
                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50"
                                   required>
                        </div>
                        
                        <div class="space-y-2">
                            <label for="email" class="block text-sm font-medium text-gray-700">Email <span class="text-red-500">*</span></label>
                            <input type="email" name="email" id="email" 
                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50"
                                   required>
                        </div>
                        
                        <div class="space-y-2">
                            <label for="password" class="block text-sm font-medium text-gray-700">Contraseña <span class="password-required text-red-500">*</span></label>
                            <input type="password" name="password" id="password" 
                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50"
                                   required>
                            <p class="password-help text-xs text-gray-500 hidden">Dejar en blanco para mantener la contraseña actual</p>
                        </div>
                        
                        <div class="space-y-2">
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmar Contraseña <span class="password-required text-red-500">*</span></label>
                            <input type="password" name="password_confirmation" id="password_confirmation" 
                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50"
                                   required>
                        </div>
                        
                        <div class="space-y-2">
                            <label for="dni" class="block text-sm font-medium text-gray-700">DNI/NIE <span class="text-red-500">*</span></label>
                            <input type="text" name="dni" id="dni" 
                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50"
                                   required>
                        </div>
                        
                        <div class="space-y-2">
                            <label for="telefono" class="block text-sm font-medium text-gray-700">Teléfono</label>
                            <input type="text" name="telefono" id="telefono" 
                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50">
                        </div>
                        
                        <div class="space-y-2">
                            <label for="ciudad" class="block text-sm font-medium text-gray-700">Ciudad</label>
                            <input type="text" name="ciudad" id="ciudad" 
                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50">
                        </div>
                        
                        <div class="space-y-2">
                            <label for="fecha_nacimiento" class="block text-sm font-medium text-gray-700">Fecha de Nacimiento</label>
                            <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" 
                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50">
                        </div>
                        
                        <div class="space-y-2">
                            <label for="sitio_web" class="block text-sm font-medium text-gray-700">Sitio Web</label>
                            <input type="url" name="sitio_web" id="sitio_web" 
                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50"
                                   placeholder="https://...">
                        </div>
                        
                        <div class="space-y-2">
                            <label for="imagen" class="block text-sm font-medium text-gray-700">Fotografía</label>
                            <input type="file" name="imagen" id="imagen" accept="image/*"
                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50">
                            <div id="imagen-preview" class="mt-2 hidden">
                                <img id="imagen-preview-img" src="" alt="Vista previa" class="h-24 w-auto object-cover rounded">
                                <button type="button" id="eliminar-imagen" class="text-xs text-red-600 mt-1">Eliminar imagen</button>
                            </div>
                        </div>
                    </div>
                    
                    <div id="activo-container" class="hidden">
                        <div class="flex items-center">
                            <input type="checkbox" name="activo" id="activo" value="1"
                                   class="rounded border-gray-300 text-purple-600 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-50">
                            <label for="activo" class="ml-2 text-sm font-medium text-gray-700">Cuenta Activa</label>
                        </div>
                    </div>
                    
                    <div class="space-y-2">
                        <label for="descripcion" class="block text-sm font-medium text-gray-700">Descripción</label>
                        <textarea name="descripcion" id="descripcion" rows="4" 
                                  class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50"></textarea>
                    </div>
                </form>
            </div>
            
            <div class="sticky bottom-0 bg-gray-50 px-6 py-4 border-t">
                <div class="flex justify-end space-x-3">
                    <button type="button" id="btn-cancelar" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors duration-150">
                        Cancelar
                    </button>
                    <button type="submit" form="form-alumno" id="btn-guardar" class="px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition-colors duration-150">
                        Guardar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Confirmación de Activación/Desactivación -->
    <div id="modal-eliminar" class="hidden fixed inset-0 z-50 flex items-center justify-center overflow-y-auto overflow-x-hidden bg-black bg-opacity-50">
        <div class="relative p-4 w-full max-w-md">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 id="action-title" class="text-xl font-semibold text-gray-900 dark:text-white">
                        Confirmar Acción
                    </h3>
                    <button type="button" id="modal-eliminar-close" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Cerrar</span>
                    </button>
                </div>
                <div class="p-4 md:p-5 text-center">
                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                    </svg>
                    <p id="action-message" class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">
                        ¿Estás seguro de que deseas realizar esta acción?
                    </p>
                    <form id="form-activar" method="POST" action="">
                        @csrf
                        @method('POST')
                        <input type="hidden" id="alumno_id_activar" name="alumno_id" value="">
                        <input type="hidden" id="is_active" name="is_active" value="">
                        <button id="action-button" type="submit" class="text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center me-2">
                            Confirmar
                        </button>
                        <button id="btn-cancelar-eliminar" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                            Cancelar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Eliminar SQL -->
    <div id="eliminarSqlModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white p-6 rounded-lg shadow-xl max-w-md w-full">
            <h2 class="text-xl font-bold text-purple-600 mb-4">Confirmar eliminación SQL</h2>
            <p class="text-gray-600 mb-4">Esta opción eliminará directamente el registro de la base de datos. Use solo en caso de que la eliminación normal no funcione.</p>
            <div class="flex justify-end space-x-2">
                <button type="button" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded text-gray-800 font-medium cerrar-modal">Cancelar</button>
                <button type="button" class="px-4 py-2 bg-purple-500 hover:bg-purple-600 rounded text-white font-medium confirmar-eliminar-sql">Eliminar SQL</button>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Variable global para control de envíos
    let isSubmitting = false;
    
    document.addEventListener('DOMContentLoaded', function() {
        // Variables de control
        let timeoutId = null;

        // Inicializar event listeners
        setupEventListeners();
        setupFilterListeners();
        
        function setupEventListeners() {
            // Botón crear alumno
            document.addEventListener('click', function(e) {
                // Botón crear alumno
                if (e.target.closest('.btn-crear')) {
                    mostrarFormularioCrear();
                }
                
                // Botón editar alumno
                if (e.target.closest('.btn-editar')) {
                    const button = e.target.closest('.btn-editar');
                    const id = button.getAttribute('data-id');
                    mostrarFormularioEditar(id);
                }
                
                // Botón activar/desactivar
                if (e.target.closest('.btn-activar')) {
                    const button = e.target.closest('.btn-activar');
                    const id = button.getAttribute('data-id');
                    const isActive = button.getAttribute('data-active');
                    
                    openActivateModal(id, isActive);
                }
            });
            
            // Cerrar modales
            const modalClose = document.getElementById('modal-close');
            const btnCancelar = document.getElementById('btn-cancelar');
            
            if (modalClose) {
                modalClose.addEventListener('click', function() {
                    document.getElementById('modal-alumno').classList.add('hidden');
                });
            }
            
            if (btnCancelar) {
                btnCancelar.addEventListener('click', function() {
                    document.getElementById('modal-alumno').classList.add('hidden');
                });
            }
            
            // Manejo de la previsualización de la foto
            const inputImagen = document.getElementById('imagen');
            if (inputImagen) {
                inputImagen.addEventListener('change', function(e) {
                    const file = this.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            document.getElementById('imagen-preview-img').src = e.target.result;
                            document.getElementById('imagen-preview').classList.remove('hidden');
                        };
                        reader.readAsDataURL(file);
                    }
                });
            }
            
            // Eliminar foto
            const btnEliminarImagen = document.getElementById('eliminar-imagen');
            if (btnEliminarImagen) {
                btnEliminarImagen.addEventListener('click', function() {
                    document.getElementById('imagen').value = '';
                    document.getElementById('imagen-preview').classList.add('hidden');
                    document.getElementById('imagen-preview-img').src = '';
                    // Agregar campo oculto para indicar que se debe eliminar la foto existente
                    const inputEliminarImagen = document.getElementById('eliminar_imagen_actual') || document.createElement('input');
                    inputEliminarImagen.type = 'hidden';
                    inputEliminarImagen.id = 'eliminar_imagen_actual';
                    inputEliminarImagen.name = 'eliminar_imagen_actual';
                    inputEliminarImagen.value = '1';
                    document.getElementById('form-alumno').appendChild(inputEliminarImagen);
                });
            }
            
            // Envío del formulario
            const formAlumno = document.getElementById('form-alumno');
            if (formAlumno) {
                formAlumno.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    // Evitar envíos duplicados
                    if (isSubmitting) return;
                    isSubmitting = true;
                    
                    const formData = new FormData(this);
                    const url = this.getAttribute('action');
                    const method = document.getElementById('form_method').value;
                    
                    // Incluir método PUT para ediciones
                    if (method === 'PUT') {
                        formData.append('_method', 'PUT');
                    }
                    
                    // Deshabilitar botones durante la petición
                    document.getElementById('btn-guardar').disabled = true;
                    
                    fetch(url, {
                        method: 'POST', // Siempre POST para enviar archivos
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => {
                        console.log("Respuesta del servidor:", response);
                        if (!response.ok) {
                            throw new Error(`Error del servidor: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log("Datos recibidos:", data);
                        if (data.success) {
                            document.getElementById('modal-alumno').classList.add('hidden');
                            mostrarMensajeExito(data.message || 'Operación realizada correctamente');
                            window.location.reload(); // Forzar recarga de la página
                        } else if (data.errors) {
                            mostrarErrores(data.errors);
                        } else {
                            alert(data.message || 'Ha ocurrido un error desconocido');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Ha ocurrido un error al procesar la solicitud: ' + error.message);
                    })
                    .finally(() => {
                        isSubmitting = false;
                        document.getElementById('btn-guardar').disabled = false;
                    });
                });
            }
            
            // Modal confirmación
            const modalEliminarClose = document.getElementById('modal-eliminar-close');
            const btnCancelarEliminar = document.getElementById('btn-cancelar-eliminar');
            const formActivar = document.getElementById('form-activar');
            
            if (modalEliminarClose) {
                modalEliminarClose.addEventListener('click', closeDeleteModal);
            }
            
            if (btnCancelarEliminar) {
                btnCancelarEliminar.addEventListener('click', closeDeleteModal);
            }
            
            if (formActivar) {
                formActivar.addEventListener('submit', function(e) {
                    e.preventDefault();
                    handleActivateSubmit();
                });
            }
        }
        
        function setupFilterListeners() {
            // Eventos para filtrado automático
            const filtroNombre = document.getElementById('filtro_nombre');
            const filtroEmail = document.getElementById('filtro_email');
            const filtroDni = document.getElementById('filtro_dni');
            const filtroEstado = document.getElementById('filtro_estado');
            const filtroCiudad = document.getElementById('filtro_ciudad');
            const resetFiltros = document.getElementById('reset-filtros');
            
            if (filtroNombre) filtroNombre.addEventListener('input', debounceFilter);
            if (filtroEmail) filtroEmail.addEventListener('input', debounceFilter);
            if (filtroDni) filtroDni.addEventListener('input', debounceFilter);
            if (filtroEstado) filtroEstado.addEventListener('change', aplicarFiltros);
            if (filtroCiudad) filtroCiudad.addEventListener('change', aplicarFiltros);
            
            if (resetFiltros) {
                resetFiltros.addEventListener('click', function() {
                    if (filtroNombre) filtroNombre.value = '';
                    if (filtroEmail) filtroEmail.value = '';
                    if (filtroDni) filtroDni.value = '';
                    if (filtroEstado) filtroEstado.value = '';
                    if (filtroCiudad) filtroCiudad.value = '';
                    aplicarFiltros();
                });
            }
        }
        
        // Función para debounce en campos de texto
        function debounceFilter() {
            if (timeoutId) {
                clearTimeout(timeoutId);
            }
            timeoutId = setTimeout(() => {
                aplicarFiltros();
            }, 300);
        }
    });
    
    function mostrarFormularioCrear() {
        // Resetear el formulario
        const form = document.getElementById('form-alumno');
        if (form) {
            form.reset();
            form.setAttribute('action', '/admin/alumnos');
            
            // Ocultar errores previos
            const formErrors = document.getElementById('form-errors');
            if (formErrors) {
                formErrors.classList.add('hidden');
                document.getElementById('error-list').innerHTML = '';
            }
            
            // Configurar campos
            document.getElementById('alumno_id').value = '';
            document.getElementById('form_method').value = 'POST';
            document.getElementById('modal-titulo').textContent = 'Crear Nuevo Alumno';
            
            // Configurar campos de contraseña como obligatorios
            const passwordRequired = document.querySelector('.password-required');
            const passwordHelp = document.querySelector('.password-help');
            
            if (passwordRequired) passwordRequired.classList.remove('hidden');
            if (passwordHelp) passwordHelp.classList.add('hidden');
            
            const password = document.getElementById('password');
            const passwordConfirmation = document.getElementById('password_confirmation');
            
            if (password) password.setAttribute('required', 'required');
            if (passwordConfirmation) passwordConfirmation.setAttribute('required', 'required');
            
            // Ocultar campo de activo para nuevas cuentas
            const activoContainer = document.getElementById('activo-container');
            if (activoContainer) activoContainer.classList.add('hidden');
            
            // Resetear campo de foto
            const imagenPreview = document.getElementById('imagen-preview');
            const imagenPreviewImg = document.getElementById('imagen-preview-img');
            
            if (imagenPreview) imagenPreview.classList.add('hidden');
            if (imagenPreviewImg) imagenPreviewImg.src = '';
            
            // Eliminar campo oculto de eliminar foto si existe
            const eliminarImagenInput = document.getElementById('eliminar_imagen_actual');
            if (eliminarImagenInput) {
                eliminarImagenInput.remove();
            }
            
            // Mostrar el modal
            const modalAlumno = document.getElementById('modal-alumno');
            if (modalAlumno) {
                modalAlumno.classList.remove('hidden');
            }
        }
    }
    
    function mostrarFormularioEditar(id) {
        if (!id) {
            console.error('ID de alumno no válido');
            return;
        }
        
        // Configurar el formulario
        const form = document.getElementById('form-alumno');
        if (form) {
            form.reset();
            form.setAttribute('action', `/admin/alumnos/${id}`);
            
            // Ocultar errores previos
            const formErrors = document.getElementById('form-errors');
            if (formErrors) {
                formErrors.classList.add('hidden');
                document.getElementById('error-list').innerHTML = '';
            }
            
            // Configurar campos
            document.getElementById('alumno_id').value = id;
            document.getElementById('form_method').value = 'PUT';
            document.getElementById('modal-titulo').textContent = 'Editar Alumno';
            
            // Configurar campos de contraseña como opcionales
            const passwordRequired = document.querySelectorAll('.password-required');
            const passwordHelp = document.querySelectorAll('.password-help');
            
            passwordRequired.forEach(el => el.classList.add('hidden'));
            passwordHelp.forEach(el => el.classList.remove('hidden'));
            
            const password = document.getElementById('password');
            const passwordConfirmation = document.getElementById('password_confirmation');
            
            if (password) password.removeAttribute('required');
            if (passwordConfirmation) passwordConfirmation.removeAttribute('required');
            
            // Mostrar campo de activo para cuentas existentes
            const activoContainer = document.getElementById('activo-container');
            if (activoContainer) activoContainer.classList.remove('hidden');
            
            // Cargar datos del alumno
            fetch(`/admin/alumnos/${id}/edit`, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`Error en la respuesta: ${response.status} ${response.statusText}`);
                }
                return response.json();
            })
            .then(data => {
                console.log("Datos recibidos:", data);
                
                if (data.estudiante) {
                    const estudiante = data.estudiante;
                    
                    // Datos de usuario
                    document.getElementById('nombre').value = estudiante.user?.nombre || '';
                    document.getElementById('email').value = estudiante.user?.email || '';
                    document.getElementById('password').value = '';
                    document.getElementById('password_confirmation').value = '';
                    document.getElementById('dni').value = estudiante.user?.dni || '';
                    document.getElementById('telefono').value = estudiante.user?.telefono || '';
                    document.getElementById('ciudad').value = estudiante.user?.ciudad || '';
                    
                    // Formatear fecha de nacimiento
                    if (estudiante.user?.fecha_nacimiento) {
                        const fechaNacimiento = document.getElementById('fecha_nacimiento');
                        if (fechaNacimiento) {
                            fechaNacimiento.value = estudiante.user.fecha_nacimiento.split('T')[0];
                        }
                    }
                    
                    document.getElementById('sitio_web').value = estudiante.user?.sitio_web || '';
                    document.getElementById('descripcion').value = estudiante.user?.descripcion || '';
                    
                    const activo = document.getElementById('activo');
                    if (activo) activo.checked = estudiante.user?.activo ? true : false;
                    
                    // Cargar imagen
                    const imagenPreview = document.getElementById('imagen-preview');
                    const imagenPreviewImg = document.getElementById('imagen-preview-img');
                    
                    if (estudiante.user?.imagen) {
                        if (imagenPreviewImg) imagenPreviewImg.src = `/public/profile_images/${estudiante.user.imagen}`;
                        if (imagenPreview) imagenPreview.classList.remove('hidden');
                    } else {
                        if (imagenPreview) imagenPreview.classList.add('hidden');
                        if (imagenPreviewImg) imagenPreviewImg.src = '';
                    }
                    
                    // Eliminar campo oculto de eliminar foto si existe
                    const eliminarImagenInput = document.getElementById('eliminar_imagen_actual');
                    if (eliminarImagenInput) {
                        eliminarImagenInput.remove();
                    }
                    
                    // Mostrar el modal
                    const modalAlumno = document.getElementById('modal-alumno');
                    if (modalAlumno) {
                        modalAlumno.classList.remove('hidden');
                    }
                } else {
                    console.error('No se recibieron datos del alumno');
                    alert('Error al cargar los datos del alumno');
                }
            })
            .catch(error => {
                console.error('Error al obtener datos del alumno:', error);
                alert('Error al obtener los datos del alumno: ' + error.message);
            });
        }
    }
    
    // Funciones para activar/desactivar
    function openActivateModal(id, isActive) {
        const alumnoIdInput = document.getElementById('alumno_id_activar');
        const isActiveInput = document.getElementById('is_active');
        const actionTitle = document.getElementById('action-title');
        const actionMessage = document.getElementById('action-message');
        const actionButton = document.getElementById('action-button');
        const modal = document.getElementById('modal-eliminar');
        
        if (!alumnoIdInput || !isActiveInput || !actionTitle || !actionMessage || !actionButton || !modal) {
            console.error('No se encontraron elementos necesarios para el modal');
            return;
        }
        
        alumnoIdInput.value = id;
        isActiveInput.value = isActive;
        
        if (isActive === '1') {
            actionTitle.textContent = 'Confirmar Desactivación';
            actionMessage.textContent = '¿Estás seguro de que deseas desactivar este estudiante? Los estudiantes desactivados no serán visibles para los usuarios.';
            actionButton.textContent = 'Desactivar';
            actionButton.classList.remove('bg-green-600', 'hover:bg-green-700');
            actionButton.classList.add('bg-red-600', 'hover:bg-red-700');
        } else {
            actionTitle.textContent = 'Confirmar Activación';
            actionMessage.textContent = '¿Estás seguro de que deseas activar este estudiante? Los estudiantes activos serán visibles para los usuarios.';
            actionButton.textContent = 'Activar';
            actionButton.classList.remove('bg-red-600', 'hover:bg-red-700');
            actionButton.classList.add('bg-green-600', 'hover:bg-green-700');
        }
        
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }
    
    function closeDeleteModal() {
        const modal = document.getElementById('modal-eliminar');
        if (modal) {
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }
    }
    
    function handleActivateSubmit() {
        const id = document.getElementById('alumno_id_activar').value;
        const isActive = document.getElementById('is_active').value === '1';
        
        if (!id) {
            console.error('ID de alumno no encontrado');
            alert('Error: ID de alumno no válido');
            return;
        }
        
        // Mostrar indicador de carga
        const actionButton = document.getElementById('action-button');
        if (actionButton) {
            actionButton.disabled = true;
            actionButton.textContent = 'Procesando...';
        }
        
        // Primero, vamos a obtener los datos actuales del alumno
        fetch(`/admin/alumnos/${id}/edit`, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`Error al obtener datos: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            if (!data.estudiante || !data.estudiante.user) {
                throw new Error('No se encontraron datos del estudiante');
            }
            
            // Ahora enviar actualización con todos los campos necesarios
            const userData = data.estudiante.user;
            
            return fetch(`/admin/alumnos/${id}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    _method: 'PUT',
                    nombre: userData.nombre,
                    email: userData.email,
                    dni: userData.dni,
                    telefono: userData.telefono || '',
                    ciudad: userData.ciudad || '',
                    fecha_nacimiento: userData.fecha_nacimiento || '',
                    sitio_web: userData.sitio_web || '',
                    descripcion: userData.descripcion || '',
                    activo: isActive ? 0 : 1 // Invertir el estado actual
                })
            });
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(data => {
                    console.error("Error en la respuesta:", data);
                    throw new Error('Error en la petición: ' + response.status);
                });
            }
            return response.json();
        })
        .then(data => {
            console.log("Respuesta de activación:", data);
            closeDeleteModal();
            
            if (data.success) {
                mostrarMensajeExito(data.message || 'Estado actualizado correctamente');
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            } else {
                alert(data.message || 'Ha ocurrido un error al procesar la solicitud');
            }
        })
        .catch(error => {
            console.error('Error al activar/desactivar alumno:', error);
            alert('Error: ' + error.message);
            closeDeleteModal();
        })
        .finally(() => {
            if (actionButton) {
                actionButton.disabled = false;
                actionButton.textContent = isActive ? 'Desactivar' : 'Activar';
            }
        });
    }
    
    // Función utilitaria para mostrar mensaje de éxito
    function mostrarMensajeExito(mensaje) {
        const messageElement = document.getElementById('success-message');
        const messageText = document.getElementById('success-message-text');
        
        if (messageElement && messageText) {
            messageText.textContent = mensaje;
            messageElement.style.display = 'block';
            
            window.scrollTo(0, 0);
            
            setTimeout(function() {
                messageElement.style.display = 'none';
            }, 5000);
        }
    }
    
    // Función para mostrar errores
    function mostrarErrores(errores) {
        const errorsDiv = document.getElementById('form-errors');
        const errorsList = document.getElementById('error-list');
        
        if (!errorsDiv || !errorsList) return;
        
        errorsList.innerHTML = '';
        
        for (const key in errores) {
            if (Object.hasOwnProperty.call(errores, key)) {
                errores[key].forEach(error => {
                    const li = document.createElement('li');
                    li.textContent = error;
                    errorsList.appendChild(li);
                });
                
                // Resaltar campo con error
                const campo = document.getElementById(key);
                if (campo) {
                    campo.classList.add('border-red-500');
                }
            }
        }
        
        errorsDiv.classList.remove('hidden');
    }
    
    // Función para actualizar la tabla
    function refreshAlumnosTable() {
        // Mostrar indicador de carga
        const tablaContainer = document.getElementById('tabla-container');
        if (tablaContainer) {
            tablaContainer.innerHTML = '<div class="flex justify-center items-center p-8"><svg class="animate-spin h-10 w-10 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg></div>';
        }

        fetch('/admin/alumnos/tabla?_=' + new Date().getTime(), {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'text/html'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`Error en la respuesta del servidor: ${response.status}`);
            }
            return response.text();
        })
        .then(html => {
            if (tablaContainer) {
                tablaContainer.innerHTML = html;
            } else {
                console.error('No se encontró el contenedor de la tabla');
            }
        })
        .catch(error => {
            console.error('Error al actualizar la tabla:', error);
            if (tablaContainer) {
                tablaContainer.innerHTML = `
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                        <strong class="font-bold">Error:</strong>
                        <span class="block sm:inline">No se pudieron cargar los datos. Intente nuevamente.</span>
                    </div>
                `;
            }
        });
    }
    
    // Función para aplicar filtros
    function aplicarFiltros() {
        // Mostrar indicador de carga
        const tablaContainer = document.getElementById('tabla-container');
        if (tablaContainer) {
            tablaContainer.innerHTML = '<div class="flex justify-center items-center p-8"><svg class="animate-spin h-10 w-10 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg></div>';
        }

        const filtros = {
            nombre: document.getElementById('filtro_nombre')?.value || '',
            email: document.getElementById('filtro_email')?.value || '',
            dni: document.getElementById('filtro_dni')?.value || '',
            ciudad: document.getElementById('filtro_ciudad')?.value || '',
            estado: document.getElementById('filtro_estado')?.value || ''
        };
        
        const params = new URLSearchParams();
        Object.entries(filtros).forEach(([key, value]) => {
            if (value) {
                params.append(key, value);
            }
        });
        
        fetch(`/admin/alumnos?${params.toString()}&_=${new Date().getTime()}`, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`Error en la respuesta: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log("Datos recibidos:", data);
            if (tablaContainer && data.tabla) {
                tablaContainer.innerHTML = data.tabla;
                
                // Volver a conectar eventos a los nuevos botones
                document.querySelectorAll('.btn-editar').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const id = this.getAttribute('data-id');
                        mostrarFormularioEditar(id);
                    });
                });
                
                document.querySelectorAll('.btn-activar').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const id = this.getAttribute('data-id');
                        const isActive = this.getAttribute('data-active');
                        openActivateModal(id, isActive);
                    });
                });
                
                document.querySelectorAll('.btn-crear').forEach(btn => {
                    btn.addEventListener('click', mostrarFormularioCrear);
                });
            } else {
                console.error('Error al cargar la tabla o datos no válidos');
                tablaContainer.innerHTML = `
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                        <strong class="font-bold">Error:</strong>
                        <span class="block sm:inline">No se pudieron cargar los datos correctamente.</span>
                    </div>
                `;
            }
        })
        .catch(error => {
            console.error('Error al aplicar filtros:', error);
            if (tablaContainer) {
                tablaContainer.innerHTML = `
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                        <strong class="font-bold">Error:</strong>
                        <span class="block sm:inline">No se pudieron cargar los datos. Intente nuevamente.</span>
                    </div>
                `;
            }
        });
    }
</script>

<style>
/* Asegurar que los botones de acción siempre estén visibles */
.btn-editar, .btn-activar {
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    min-height: 32px !important;
    min-width: 32px !important;
}

/* Aplicar estilos a los campos de formulario con error */
.border-red-500 {
    border-color: #f56565 !important;
}

/* Estilos para las tarjetas en móvil */
@media (max-width: 768px) {
    .md\:hidden .btn-editar,
    .md\:hidden .btn-activar {
        width: 40px !important;
        height: 40px !important;
    }
}
</style>
@endpush 