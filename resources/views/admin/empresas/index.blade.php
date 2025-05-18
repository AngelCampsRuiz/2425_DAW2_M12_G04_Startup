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
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
            <div class="relative">
                <label for="filtro_nombre" class="block text-sm font-medium text-purple-700 mb-2">Nombre de la empresa</label>
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
                <label for="filtro_cif" class="block text-sm font-medium text-purple-700 mb-2">CIF</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <input type="text" id="filtro_cif" class="pl-10 w-full rounded-lg border-purple-200 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50" placeholder="Buscar por CIF...">
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
    
    <!-- Contenedor de la tabla -->
    <div id="tabla-container" class="bg-white rounded-lg shadow overflow-hidden">
        @include('admin.empresas.tabla')
    </div>

    <!-- Modal Crear/Editar Empresa -->
    <div id="modal-empresa" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-lg shadow-xl max-w-4xl w-full max-h-screen overflow-y-auto p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 id="modal-titulo" class="text-xl font-semibold">Crear Nueva Empresa</h2>
                <button id="modal-close" class="text-gray-500 hover:text-gray-700 focus:outline-none">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <!-- Mensajes de error del formulario -->
            <div id="form-errors" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6 hidden" role="alert">
                <strong class="font-bold">¡Hay errores en el formulario!</strong>
                <ul id="error-list" class="mt-2 list-disc list-inside"></ul>
            </div>
            
            <form id="form-empresa" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="empresa_id" name="empresa_id" value="">
                <input type="hidden" id="form_method" name="_method" value="POST">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Datos de Usuario -->
                    <div class="col-span-2">
                        <h3 class="text-lg font-medium text-gray-900 border-b pb-2 mb-4">Información de Usuario</h3>
                    </div>
                
                    <div>
                        <label for="nombre" class="block text-sm font-medium text-gray-700 mb-1">Nombre <span class="text-red-500">*</span></label>
                        <input type="text" name="nombre" id="nombre" 
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50"
                               required>
                    </div>
                    
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email <span class="text-red-500">*</span></label>
                        <input type="email" name="email" id="email" 
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50"
                               required>
                    </div>
                    
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Contraseña <span class="password-required text-red-500">*</span></label>
                        <input type="password" name="password" id="password" 
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50"
                               required>
                        <p class="password-help text-xs text-gray-500 mt-1 hidden">Dejar en blanco para mantener la contraseña actual</p>
                    </div>
                    
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirmar Contraseña <span class="password-required text-red-500">*</span></label>
                        <input type="password" name="password_confirmation" id="password_confirmation" 
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50"
                               required>
                        <p class="password-confirmation-help text-xs text-gray-500 mt-1 hidden">Dejar en blanco para mantener la contraseña actual</p>
                    </div>
                    
                    <div>
                        <label for="dni" class="block text-sm font-medium text-gray-700 mb-1">DNI/NIE <span class="text-red-500">*</span></label>
                        <input type="text" name="dni" id="dni" 
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50"
                               required>
                    </div>
                    
                    <div>
                        <label for="telefono" class="block text-sm font-medium text-gray-700 mb-1">Teléfono</label>
                        <input type="text" name="telefono" id="telefono" 
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50">
                    </div>
                    
                    <div>
                        <label for="ciudad" class="block text-sm font-medium text-gray-700 mb-1">Ciudad</label>
                        <input type="text" name="ciudad" id="ciudad" 
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50">
                    </div>
                    
                    <div>
                        <label for="fecha_nacimiento" class="block text-sm font-medium text-gray-700 mb-1">Fecha de Constitución</label>
                        <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" 
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50">
                    </div>
                    
                    <div>
                        <label for="sitio_web" class="block text-sm font-medium text-gray-700 mb-1">Sitio Web</label>
                        <input type="url" name="sitio_web" id="sitio_web" 
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50"
                               placeholder="https://...">
                    </div>
                    
                    <div>
                        <label for="foto" class="block text-sm font-medium text-gray-700 mb-1">Fotografía</label>
                        <input type="file" name="imagen" id="imagen" accept="image/*"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50">
                        <div id="imagen-preview" class="mt-2 hidden">
                            <img id="imagen-preview-img" src="" alt="Vista previa" class="h-24 w-auto object-cover rounded">
                            <button type="button" id="eliminar-imagen" class="text-xs text-red-600 mt-1">Eliminar imagen</button>
                        </div>
                    </div>
                
                    <!-- Datos de Empresa -->
                    <div class="col-span-2 mt-4">
                        <h3 class="text-lg font-medium text-gray-900 border-b pb-2 mb-4">Información de Empresa</h3>
                    </div>
                    
                    <div>
                        <label for="cif" class="block text-sm font-medium text-gray-700 mb-1">CIF <span class="text-red-500">*</span></label>
                        <input type="text" name="cif" id="cif" 
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50"
                               required>
                    </div>
                    
                    <div>
                        <label for="provincia" class="block text-sm font-medium text-gray-700 mb-1">Provincia</label>
                        <input type="text" name="provincia" id="provincia" 
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50">
                    </div>
                    
                    <div class="col-span-2">
                        <label for="direccion" class="block text-sm font-medium text-gray-700 mb-1">Dirección <span class="text-red-500">*</span></label>
                        <input type="text" name="direccion" id="direccion" 
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50"
                               required>
                    </div>
                    
                    <div>
                        <label for="latitud" class="block text-sm font-medium text-gray-700 mb-1">Latitud</label>
                        <input type="number" name="latitud" id="latitud" step="0.000001"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50">
                    </div>
                    
                    <div>
                        <label for="longitud" class="block text-sm font-medium text-gray-700 mb-1">Longitud</label>
                        <input type="number" name="longitud" id="longitud" step="0.000001"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50">
                    </div>
                    
                    <div id="activo-container" class="col-span-2 flex items-center hidden">
                        <input type="checkbox" name="activo" id="activo" value="1"
                               class="rounded border-gray-300 text-purple-600 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-50">
                        <label for="activo" class="ml-2 text-sm font-medium text-gray-700">Cuenta Activa</label>
                    </div>
                </div>
                
                <div class="mt-6">
                    <label for="descripcion" class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                    <textarea name="descripcion" id="descripcion" rows="4" 
                              class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50"></textarea>
                </div>
                
                <div class="mt-6 flex justify-end">
                    <button type="button" id="btn-cancelar" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 active:bg-gray-500 focus:outline-none focus:border-gray-500 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 mr-3">
                        Cancelar
                    </button>
                    <button type="submit" id="btn-guardar" class="inline-flex items-center px-4 py-2 bg-purple-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-700 active:bg-purple-900 focus:outline-none focus:border-purple-900 focus:ring ring-purple-300 disabled:opacity-25 transition ease-in-out duration-150">
                        Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Confirmación Eliminar -->
    <div id="modal-eliminar" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-semibold">Confirmar Eliminación</h2>
                <button id="modal-eliminar-close" class="text-gray-500 hover:text-gray-700 focus:outline-none">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <p class="mb-6">¿Estás seguro de que deseas eliminar esta empresa? Esta acción no se puede deshacer y eliminará también el usuario asociado.</p>
            
            <form id="form-eliminar" method="POST">
                @csrf
                @method('DELETE')
                <input type="hidden" id="eliminar_id" name="eliminar_id" value="">
                
                <div class="flex justify-end">
                    <button type="button" id="btn-cancelar-eliminar" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 active:bg-gray-500 focus:outline-none focus:border-gray-500 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 mr-3">
                        Cancelar
                    </button>
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 active:bg-red-800 focus:outline-none focus:border-red-800 focus:ring ring-red-300 disabled:opacity-25 transition ease-in-out duration-150">
                        Eliminar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Eliminar SQL -->
    <div id="eliminarSqlModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white p-6 rounded-lg shadow-xl max-w-md w-full">
            <h2 class="text-xl font-bold text-purple-600 mb-4">Confirmar eliminación SQL</h2>
            <p class="text-gray-600 mb-4">Esta opción eliminará directamente los registros de la base de datos. Use solo en caso de que la eliminación normal no funcione.</p>
            <div class="flex justify-end space-x-2">
                <button type="button" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded text-gray-800 font-medium cerrar-modal">Cancelar</button>
                <button type="button" class="px-4 py-2 bg-purple-500 hover:bg-purple-600 rounded text-white font-medium confirmar-eliminar-sql">Eliminar SQL</button>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Variable de control para evitar duplicación
    let isSubmitting = false;
    let initialized = false;
    
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOMContentLoaded evento disparado');
        
        // Esperar un poco para que todo se cargue completamente
        setTimeout(() => {
            console.log('Iniciando configuración de elementos');
            
            // Inicialización de botones solo una vez
            if (!initialized) {
                try {
                    setupEventListeners();
                    initialized = true;
                } catch (error) {
                    console.error('Error durante la inicialización:', error);
                }
            }
        }, 100);
    });
    
    // Configura todos los listeners una sola vez
    function setupEventListeners() {
        // Cerrar modales
        document.getElementById('modal-close').addEventListener('click', function() {
            document.getElementById('modal-empresa').classList.add('hidden');
        });
        
        document.getElementById('btn-cancelar').addEventListener('click', function() {
            document.getElementById('modal-empresa').classList.add('hidden');
        });
        
        document.getElementById('modal-eliminar-close').addEventListener('click', function() {
            document.getElementById('modal-eliminar').classList.add('hidden');
        });
        
        document.getElementById('btn-cancelar-eliminar').addEventListener('click', function() {
            document.getElementById('modal-eliminar').classList.add('hidden');
        });
        
        // Manejo de la previsualización de la foto
        document.getElementById('imagen').addEventListener('change', function(e) {
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
        
        // Eliminar foto
        document.getElementById('eliminar-imagen').addEventListener('click', function() {
            document.getElementById('imagen').value = '';
            document.getElementById('imagen-preview').classList.add('hidden');
            document.getElementById('imagen-preview-img').src = '';
            // Agregar campo oculto para indicar que se debe eliminar la foto existente
            const inputEliminarImagen = document.getElementById('eliminar_imagen_actual') || document.createElement('input');
            inputEliminarImagen.type = 'hidden';
            inputEliminarImagen.id = 'eliminar_imagen_actual';
            inputEliminarImagen.name = 'eliminar_imagen_actual';
            inputEliminarImagen.value = '1';
            document.getElementById('form-empresa').appendChild(inputEliminarImagen);
        });
        
        // Delegación de eventos para los botones dinámicos
        document.addEventListener('click', function(e) {
            // Botón Crear
            if (e.target.closest('.btn-crear')) {
                mostrarFormularioCrear();
            }
            
            // Botones Editar
            if (e.target.closest('.btn-editar')) {
                const btn = e.target.closest('.btn-editar');
                const id = btn.getAttribute('data-id');
                mostrarFormularioEditar(id);
            }
            
            // Botones Eliminar
            if (e.target.closest('.btn-eliminar')) {
                const btn = e.target.closest('.btn-eliminar');
                const id = btn.getAttribute('data-id');
                mostrarModalEliminar(id);
            }
            
            // Enlaces de paginación
            if (e.target.closest('.pagination-link')) {
                e.preventDefault();
                const link = e.target.closest('.pagination-link');
                actualizarTablaEmpresas(link.getAttribute('href'));
            }
        });
        
        // Validation function for password match
        function validatePasswords() {
            const passwordInput = document.getElementById('password');
            const confirmInput = document.getElementById('password_confirmation');
            
            if (passwordInput && confirmInput && passwordInput.value && confirmInput.value) {
                if (passwordInput.value !== confirmInput.value) {
                    // Create an error object in the format expected by mostrarErrores
                    const errors = {
                        'password_confirmation': ['Las contraseñas no coinciden']
                    };
                    mostrarErrores(errors);
                    confirmInput.classList.add('border-red-500');
                    return false;
                } else {
                    confirmInput.classList.remove('border-red-500');
                }
            }
            return true;
        }

        // Add validation to form submission
        document.getElementById('form-empresa').addEventListener('submit', function(e) {
            e.preventDefault();
            
            if (!validatePasswords()) {
                return false;
            }
            
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
                    // No incluir Content-Type para permitir que el navegador establezca el boundary correcto para FormData
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('modal-empresa').classList.add('hidden');
                    mostrarMensajeExito(data.message);
                    actualizarTablaEmpresas();
                } else if (data.errors) {
                    mostrarErrores(data.errors);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            })
            .finally(() => {
                isSubmitting = false;
                document.getElementById('btn-guardar').disabled = false;
            });
        });
        
        // Envío del formulario de eliminar - Una sola vez
        document.getElementById('form-eliminar').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Evitar envíos duplicados
            if (isSubmitting) return;
            isSubmitting = true;
            
            const url = this.getAttribute('action');
            
            fetch(url, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('modal-eliminar').classList.add('hidden');
                    mostrarMensajeExito(data.message);
                    actualizarTablaEmpresas();
                } else {
                    alert(data.message || 'Error al eliminar la empresa');
                }
            })
            .catch(error => {
                console.error('Error:', error);
            })
            .finally(() => {
                isSubmitting = false;
            });
        });
    }
    
    // Funciones principales
    function mostrarFormularioCrear() {
        // Resetear el formulario
        document.getElementById('form-empresa').reset();
        document.getElementById('form-errors').classList.add('hidden');
        document.getElementById('empresa_id').value = '';
        document.getElementById('form_method').value = 'POST';
        
        // Configurar la acción del formulario
        document.getElementById('form-empresa').setAttribute('action', '{{ route("admin.empresas.store") }}');
        
        // Configurar campo de contraseña como obligatorio
        document.querySelector('.password-required').classList.remove('hidden');
        document.querySelector('.password-help').classList.add('hidden');
        document.getElementById('password').setAttribute('required', 'required');
        document.getElementById('password_confirmation').setAttribute('required', 'required');
        
        // Resetear campo de foto
        document.getElementById('imagen-preview').classList.add('hidden');
        document.getElementById('imagen-preview-img').src = '';
        
        // Eliminar campo oculto de eliminar foto si existe
        const eliminarImagenInput = document.getElementById('eliminar_imagen_actual');
        if (eliminarImagenInput) {
            eliminarImagenInput.remove();
        }
        
        // Ocultar el checkbox de activo para nuevas empresas
        document.getElementById('activo-container').classList.add('hidden');
        
        // Cambiar el título del modal
        document.getElementById('modal-titulo').textContent = 'Crear Nueva Empresa';
        
        // Mostrar el modal
        document.getElementById('modal-empresa').classList.remove('hidden');
    }
    
    /**
     * Obtiene los datos de una empresa para editar
     */
    function mostrarFormularioEditar(id) {
        document.getElementById('modal-titulo').textContent = 'Editar Empresa';
        document.getElementById('empresa_id').value = id;
        document.getElementById('form_method').value = 'PUT';
        document.getElementById('form-empresa').action = `/admin/empresas/${id}`;
        
        // Configurar campo de contraseña como opcional
        document.querySelector('.password-required').classList.add('hidden');
        document.querySelector('.password-help').classList.remove('hidden');
        document.querySelector('.password-confirmation-help').classList.remove('hidden');
        document.getElementById('password').removeAttribute('required');
        document.getElementById('password_confirmation').removeAttribute('required');
        
        // Mostrar el checkbox de activo para empresas existentes
        document.getElementById('activo-container').classList.remove('hidden');
        
        // Eliminar campo oculto de eliminar foto si existe
        const eliminarImagenInput = document.getElementById('eliminar_imagen_actual');
        if (eliminarImagenInput) {
            eliminarImagenInput.remove();
        }
        
        fetch(`/admin/empresas/${id}/edit`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            const empresa = data.empresa;
            
            // Datos de usuario
            document.getElementById('nombre').value = empresa.user.nombre || '';
            document.getElementById('email').value = empresa.user.email || '';
            document.getElementById('password').value = ''; // No mostrar contraseña
            document.getElementById('dni').value = empresa.user.dni || '';
            document.getElementById('telefono').value = empresa.user.telefono || '';
            document.getElementById('ciudad').value = empresa.user.ciudad || '';
            document.getElementById('fecha_nacimiento').value = empresa.user.fecha_nacimiento ? empresa.user.fecha_nacimiento.split('T')[0] : '';
            document.getElementById('sitio_web').value = empresa.user.sitio_web || '';
            document.getElementById('descripcion').value = empresa.user.descripcion || '';
            document.getElementById('activo').checked = empresa.user.activo ? true : false;
            
            // Cargar y mostrar foto si existe
            if (empresa.user.imagen) {
                document.getElementById('imagen-preview-img').src = `/profile_images/${empresa.user.imagen}`;
                document.getElementById('imagen-preview').classList.remove('hidden');
            } else {
                document.getElementById('imagen-preview').classList.add('hidden');
                document.getElementById('imagen-preview-img').src = '';
            }
            
            // Datos de empresa
            document.getElementById('cif').value = empresa.cif || '';
            document.getElementById('direccion').value = empresa.direccion || '';
            document.getElementById('provincia').value = empresa.provincia || '';
            document.getElementById('latitud').value = empresa.latitud || '';
            document.getElementById('longitud').value = empresa.longitud || '';
            
            document.getElementById('modal-empresa').classList.remove('hidden');
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al obtener los datos de la empresa');
        });
    }
    
    function mostrarModalEliminar(id) {
        // Configurar el formulario
        document.getElementById('eliminar_id').value = id;
        document.getElementById('form-eliminar').setAttribute('action', `/admin/empresas/${id}`);
        
        // Mostrar el modal
        document.getElementById('modal-eliminar').classList.remove('hidden');
    }
    
    function mostrarModalEliminarSQL(id) {
        const modal = document.getElementById('eliminarSqlModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        
        const btnConfirmar = modal.querySelector('.confirmar-eliminar-sql');
        btnConfirmar.onclick = function() {
            eliminarEmpresaSQL(id);
        };
        
        const btnCerrar = modal.querySelector('.cerrar-modal');
        btnCerrar.onclick = function() {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        };
    }
    
    function eliminarEmpresaSQL(id) {
        if (isSubmitting) return;
        isSubmitting = true;
        
        fetch(`/admin/empresas/eliminar-sql/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('eliminarSqlModal').classList.add('hidden');
            document.getElementById('eliminarSqlModal').classList.remove('flex');
            
            if (data.success) {
                mostrarMensajeExito(data.message);
                actualizarTablaEmpresas();
            } else {
                alert(data.message || 'Error al eliminar la empresa mediante SQL');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al procesar la solicitud');
        })
        .finally(() => {
            isSubmitting = false;
        });
    }
    
    // Funciones auxiliares para mostrar mensajes y errores
    function mostrarMensajeExito(mensaje) {
        const messageElement = document.getElementById('success-message');
        const messageText = document.getElementById('success-message-text');
        
        messageText.textContent = mensaje;
        messageElement.style.display = 'block';
        
        setTimeout(function() {
            messageElement.style.display = 'none';
        }, 5000);
    }
    
    function mostrarErrores(errores) {
        const errorsDiv = document.getElementById('form-errors');
        const errorsList = document.getElementById('error-list');
        
        errorsList.innerHTML = '';
        
        for (const key in errores) {
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
        
        errorsDiv.classList.remove('hidden');
    }
    
    // Función de actualización de tabla
    function actualizarTablaEmpresas(url = '{{ route("admin.empresas.index") }}') {
        fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.tabla) {
                document.getElementById('tabla-container').innerHTML = data.tabla;
            } else {
                console.error('No se recibió contenido HTML para la tabla');
            }
        })
        .catch(error => {
            console.error('Error al actualizar la tabla:', error);
        });
    }

    // Cerrar modales al hacer clic fuera de ellos
    document.querySelectorAll('#eliminarSqlModal').forEach(modal => {
        modal.addEventListener('click', function(e) {
            if (e.target === this) {
                this.classList.add('hidden');
                this.classList.remove('flex');
            }
        });
    });
</script>

<style>
/* Asegurar que los botones de acción siempre estén visibles */
.btn-editar, .btn-eliminar {
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
    .md\:hidden .btn-eliminar {
        width: 40px !important;
        height: 40px !important;
    }
}
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let timeoutId = null;

        // Eventos para filtrado automático
        document.getElementById('filtro_nombre').addEventListener('input', debounceFilter);
        document.getElementById('filtro_cif').addEventListener('input', debounceFilter);
        document.getElementById('filtro_estado').addEventListener('change', aplicarFiltros);
        document.getElementById('filtro_ciudad').addEventListener('change', aplicarFiltros);
        
        // Resetear filtros
        document.getElementById('reset-filtros').addEventListener('click', function() {
            document.getElementById('filtro_nombre').value = '';
            document.getElementById('filtro_cif').value = '';
            document.getElementById('filtro_estado').value = '';
            document.getElementById('filtro_ciudad').value = '';
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
                cif: document.getElementById('filtro_cif').value,
                estado: document.getElementById('filtro_estado').value,
                ciudad: document.getElementById('filtro_ciudad').value
            };
            
            const params = new URLSearchParams();
            Object.entries(filtros).forEach(([key, value]) => {
                if (value) {
                    params.append(key, value);
                }
            });
            
            fetch(`/admin/empresas?${params.toString()}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
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
    });
</script>
@endpush 