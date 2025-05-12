@extends('admin.dashboard')

@section('admin_content')
    <!-- Mensaje de éxito -->
    <div id="success-message" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert" style="display: none;">
        <span id="success-message-text" class="block sm:inline"></span>
    </div>

    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-semibold text-gray-800">Profesores</h1>
        <button id="btnCrearProfesor" class="btn-crear bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
            Crear Profesor
        </button>
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
    <div id="tabla-profesores">
        @include('admin.profesores.tabla')
    </div>

    <!-- Modal para crear/editar profesor -->
    <div id="modal-profesor" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-lg shadow-xl max-w-4xl w-full max-h-screen overflow-y-auto p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 id="modal-title" class="text-xl font-semibold">Crear Nuevo Profesor</h2>
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
            
            <form id="form-profesor" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="_method" id="form_method" value="POST">
                <input type="hidden" name="profesor_id" id="profesor_id">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="nombre" class="block text-sm font-medium text-gray-700 mb-1">Nombre <span class="text-red-500">*</span></label>
                        <input type="text" name="nombre" id="nombre" required
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50">
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email <span class="text-red-500">*</span></label>
                        <input type="email" name="email" id="email" required
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50">
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Contraseña <span class="password-required text-red-500">*</span></label>
                        <input type="password" name="password" id="password" required
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50">
                        <p class="password-help text-xs text-gray-500 mt-1 hidden">Dejar en blanco para mantener la contraseña actual</p>
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirmar Contraseña <span class="password-required text-red-500">*</span></label>
                        <input type="password" name="password_confirmation" id="password_confirmation" required
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50">
                    </div>

                    <div>
                        <label for="dni" class="block text-sm font-medium text-gray-700 mb-1">DNI <span class="text-red-500">*</span></label>
                        <input type="text" name="dni" id="dni" required
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50">
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
                        <label for="fecha_nacimiento" class="block text-sm font-medium text-gray-700 mb-1">Fecha de Nacimiento</label>
                        <input type="date" name="fecha_nacimiento" id="fecha_nacimiento"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50">
                    </div>

                    <div>
                        <label for="sitio_web" class="block text-sm font-medium text-gray-700 mb-1">Sitio Web</label>
                        <input type="url" name="sitio_web" id="sitio_web"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50">
                    </div>

                    <div>
                        <label for="imagen" class="block text-sm font-medium text-gray-700 mb-1">Imagen de Perfil</label>
                        <input type="file" name="imagen" id="imagen" accept="image/*"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50">
                        <div id="imagen-preview" class="mt-2 hidden">
                            <img id="imagen-preview-img" src="" alt="Vista previa" class="h-24 w-auto object-cover rounded">
                            <button type="button" id="eliminar-imagen" class="text-xs text-red-600 mt-1">Eliminar imagen</button>
                        </div>
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
            
            <p class="mb-6">¿Estás seguro de que deseas eliminar este profesor? Esta acción no se puede deshacer.</p>
            
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
    // Variable de control para evitar duplicación
    let isSubmitting = false;
    
    document.addEventListener('DOMContentLoaded', function() {
        setupEventListeners();
        setupFiltros();
    });
    
    function setupEventListeners() {
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
            
            // Cerrar modales
            if (e.target.closest('#modal-close') || e.target.closest('#btn-cancelar')) {
                document.getElementById('modal-profesor').classList.add('hidden');
            }
            
            if (e.target.closest('#modal-eliminar-close') || e.target.closest('#btn-cancelar-eliminar')) {
                document.getElementById('modal-eliminar').classList.add('hidden');
            }
            
            // Eliminar foto
            if (e.target.closest('#eliminar-imagen')) {
                document.getElementById('imagen').value = '';
                document.getElementById('imagen-preview').classList.add('hidden');
                document.getElementById('imagen-preview-img').src = '';
                // Agregar campo oculto para indicar que se debe eliminar la foto existente
                const inputEliminarImagen = document.getElementById('eliminar_imagen_actual') || document.createElement('input');
                inputEliminarImagen.type = 'hidden';
                inputEliminarImagen.id = 'eliminar_imagen_actual';
                inputEliminarImagen.name = 'eliminar_imagen_actual';
                inputEliminarImagen.value = '1';
                document.getElementById('form-profesor').appendChild(inputEliminarImagen);
            }
            
            // Cerrar modal de eliminar SQL
            if (e.target.closest('.cerrar-modal')) {
                document.getElementById('eliminarSqlModal').classList.add('hidden');
            }
            
            // Confirmar eliminación SQL
            if (e.target.closest('.confirmar-eliminar-sql')) {
                eliminarProfesorSQL();
            }
        });
        
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
        
        // Manejar envío del formulario
        const formProfesor = document.getElementById('form-profesor');
        if (formProfesor) {
            formProfesor.addEventListener('submit', async function(e) {
                e.preventDefault();
                
                if (isSubmitting) return;
                
                // Validar contraseñas
                if (!validarContrasenas()) return;
                
                isSubmitting = true;
                const btnGuardar = document.getElementById('btn-guardar');
                btnGuardar.disabled = true;
                btnGuardar.textContent = 'Guardando...';
                
                try {
                    const formData = new FormData(this);
                    const profesorId = document.getElementById('profesor_id').value;
                    const method = document.getElementById('form_method').value;
                    const url = profesorId ? `/admin/profesores/${profesorId}` : '/admin/profesores';
                    
                    console.log(`Enviando formulario a ${url} con método ${method}, ID: ${profesorId || 'nuevo'}`);
                    
                    const response = await fetch(url, {
                        method: 'POST', // Siempre POST, el método real va en _method
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    });
                    
                    const data = await response.json();
                    
                    if (response.ok) {
                        mostrarMensajeExito(data.message || 'Profesor guardado correctamente');
                        document.getElementById('modal-profesor').classList.add('hidden');
                        limpiarFormulario();
                        
                        // Recargamos la tabla de profesores después de guardar
                        actualizarTabla();
                    } else {
                        if (data.errors) {
                            mostrarErroresFormulario(data.errors);
                        } else {
                            mostrarMensajeError(data.message || 'Error al procesar la solicitud');
                        }
                    }
                } catch (error) {
                    console.error('Error:', error);
                    mostrarMensajeError('Error al procesar la solicitud');
                } finally {
                    isSubmitting = false;
                    btnGuardar.disabled = false;
                    btnGuardar.textContent = 'Guardar';
                }
            });
        }
        
        // Manejar envío del formulario de eliminación
        const formEliminar = document.getElementById('form-eliminar');
        if (formEliminar) {
            formEliminar.addEventListener('submit', async function(e) {
                e.preventDefault();
                
                if (isSubmitting) return;
                isSubmitting = true;
                
                try {
                    const profesorId = document.getElementById('eliminar_id').value;
                    const url = `/admin/profesores/${profesorId}`;
                    
                    const response = await fetch(url, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        }
                    });
                    
                    const data = await response.json();
                    
                    if (response.ok) {
                        mostrarMensajeExito(data.message || 'Profesor eliminado correctamente');
                        document.getElementById('modal-eliminar').classList.add('hidden');
                        
                        // Recargamos la tabla de profesores después de eliminar
                        actualizarTabla();
                    } else {
                        mostrarMensajeError(data.message || 'Error al eliminar el profesor');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    mostrarMensajeError('Error al eliminar el profesor');
                } finally {
                    isSubmitting = false;
                }
            });
        }
    }
    
    function setupFiltros() {
        let timeoutId = null;

        // Eventos para filtrado automático
        document.getElementById('filtro_nombre').addEventListener('input', debounceFilter);
        document.getElementById('filtro_email').addEventListener('input', debounceFilter);
        document.getElementById('filtro_dni').addEventListener('input', debounceFilter);
        document.getElementById('filtro_ciudad').addEventListener('change', aplicarFiltros);
        document.getElementById('filtro_estado').addEventListener('change', aplicarFiltros);
        
        // Resetear filtros
        document.getElementById('reset-filtros').addEventListener('click', function() {
            document.getElementById('filtro_nombre').value = '';
            document.getElementById('filtro_email').value = '';
            document.getElementById('filtro_dni').value = '';
            document.getElementById('filtro_ciudad').value = '';
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
                email: document.getElementById('filtro_email').value,
                dni: document.getElementById('filtro_dni').value,
                ciudad: document.getElementById('filtro_ciudad').value,
                estado: document.getElementById('filtro_estado').value
            };
            
            const params = new URLSearchParams();
            Object.entries(filtros).forEach(([key, value]) => {
                if (value) {
                    params.append(key, value);
                }
            });
            
            refreshTable(params.toString());
        }
    }
    
    // Funciones auxiliares
    function mostrarFormularioCrear() {
        limpiarFormulario();
        document.getElementById('modal-title').textContent = 'Crear Nuevo Profesor';
        document.getElementById('form_method').value = 'POST';
        document.getElementById('profesor_id').value = '';
        document.querySelector('.password-required').classList.remove('hidden');
        document.querySelector('.password-help').classList.add('hidden');
        document.getElementById('password').required = true;
        document.getElementById('password_confirmation').required = true;
        // Ocultar el checkbox de activo para crear
        document.getElementById('activo-container').classList.add('hidden');
        document.getElementById('modal-profesor').classList.remove('hidden');
    }
    
    async function mostrarFormularioEditar(id) {
        try {
            const response = await fetch(`/admin/profesores/${id}/edit`);
            const data = await response.json();
            
            if (response.ok) {
                const profesor = data.profesor;
                document.getElementById('profesor_id').value = profesor.id;
                document.getElementById('nombre').value = profesor.nombre;
                document.getElementById('email').value = profesor.email;
                document.getElementById('dni').value = profesor.dni;
                document.getElementById('telefono').value = profesor.telefono || '';
                document.getElementById('ciudad').value = profesor.ciudad || '';
                document.getElementById('fecha_nacimiento').value = profesor.fecha_nacimiento || '';
                document.getElementById('sitio_web').value = profesor.sitio_web || '';
                document.getElementById('descripcion').value = profesor.descripcion || '';
                
                // Manejar la imagen
                if (profesor.imagen) {
                    document.getElementById('imagen-preview-img').src = `/public/profile_images/${profesor.imagen}`;
                    document.getElementById('imagen-preview').classList.remove('hidden');
                } else {
                    document.getElementById('imagen-preview').classList.add('hidden');
                }
                
                // Configurar el formulario para edición
                document.getElementById('modal-title').textContent = 'Editar Profesor';
                document.getElementById('form_method').value = 'PUT';
                document.querySelector('.password-required').classList.add('hidden');
                document.querySelector('.password-help').classList.remove('hidden');
                document.getElementById('password').required = false;
                document.getElementById('password_confirmation').required = false;
                
                // Mostrar el checkbox de activo y configurar estado
                document.getElementById('activo-container').classList.remove('hidden');
                document.getElementById('activo').checked = profesor.activo;
                
                document.getElementById('modal-profesor').classList.remove('hidden');
            } else {
                mostrarMensajeError('Error al cargar los datos del profesor');
            }
        } catch (error) {
            console.error('Error:', error);
            mostrarMensajeError('Error al cargar los datos del profesor');
        }
    }
    
    function mostrarModalEliminar(id) {
        document.getElementById('eliminar_id').value = id;
        document.getElementById('modal-eliminar').classList.remove('hidden');
    }
    
    function limpiarFormulario() {
        document.getElementById('form-profesor').reset();
        document.getElementById('profesor_id').value = '';
        document.getElementById('imagen-preview').classList.add('hidden');
        document.getElementById('imagen-preview-img').src = '';
        document.getElementById('form-errors').classList.add('hidden');
        document.getElementById('error-list').innerHTML = '';
        
        // Eliminar campo oculto de eliminar imagen si existe
        const inputEliminarImagen = document.getElementById('eliminar_imagen_actual');
        if (inputEliminarImagen) {
            inputEliminarImagen.remove();
        }
    }
    
    function validarContrasenas() {
        const password = document.getElementById('password').value;
        const passwordConfirmation = document.getElementById('password_confirmation').value;
        
        if (password || passwordConfirmation) {
            if (password !== passwordConfirmation) {
                mostrarMensajeError('Las contraseñas no coinciden');
                return false;
            }
            if (password && password.length < 8) {
                mostrarMensajeError('La contraseña debe tener al menos 8 caracteres');
                return false;
            }
        }
        return true;
    }
    
    function refreshTable(params = '') {
        fetch(`/admin/profesores?${params}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.text())
        .then(html => {
            document.getElementById('tabla-profesores').innerHTML = html;
            setupEventListeners();
        })
        .catch(error => console.error('Error:', error));
    }

    async function actualizarTabla() {
        try {
            const response = await fetch('/admin/profesores', {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            if (response.ok) {
                const html = await response.text();
                document.getElementById('tabla-profesores').innerHTML = html;
                setupEventListeners();
            }
        } catch (error) {
            console.error('Error:', error);
            window.location.reload();
        }
    }
    
    async function eliminarProfesorSQL() {
        const profesorId = document.getElementById('eliminar_id').value;
        try {
            const response = await fetch(`/admin/profesores/eliminar-sql/${profesorId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            });
            
            const data = await response.json();
            
            if (response.ok) {
                mostrarMensajeExito(data.message || 'Profesor eliminado correctamente (SQL)');
                document.getElementById('eliminarSqlModal').classList.add('hidden');
                document.getElementById('modal-eliminar').classList.add('hidden');
                
                // Recargamos la tabla de profesores después de eliminar
                actualizarTabla();
            } else {
                mostrarMensajeError(data.message || 'Error al eliminar el profesor');
            }
        } catch (error) {
            console.error('Error:', error);
            mostrarMensajeError('Error al eliminar el profesor mediante SQL');
        }
    }
    
    function mostrarMensajeExito(mensaje) {
        const successMessage = document.getElementById('success-message');
        const successMessageText = document.getElementById('success-message-text');
        successMessageText.textContent = mensaje;
        successMessage.style.display = 'block';
        
        // Nos aseguramos de que el mensaje sea visible
        window.scrollTo({ top: 0, behavior: 'smooth' });
        
        // Ocultar el mensaje después de 5 segundos
        setTimeout(() => {
            successMessage.style.display = 'none';
        }, 5000);
    }
    
    function mostrarMensajeError(mensaje) {
        // Crear un elemento fijo en la parte superior de la pantalla
        const errorAlert = document.createElement('div');
        errorAlert.className = 'fixed top-4 left-1/2 transform -translate-x-1/2 bg-red-100 border border-red-400 text-red-700 px-6 py-4 rounded-lg shadow-lg z-50';
        errorAlert.innerHTML = `
            <div class="flex items-center">
                <svg class="w-6 h-6 text-red-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <strong class="font-bold mr-1">¡Error!</strong>
                <span class="block">${mensaje}</span>
            </div>
        `;
        document.body.appendChild(errorAlert);
        
        // Nos aseguramos de que el mensaje sea visible
        window.scrollTo({ top: 0, behavior: 'smooth' });
        
        setTimeout(() => {
            errorAlert.remove();
        }, 5000);
    }
    
    function mostrarErroresFormulario(errores) {
        const errorList = document.getElementById('error-list');
        errorList.innerHTML = '';
        
        Object.values(errores).forEach(mensajes => {
            mensajes.forEach(mensaje => {
                const li = document.createElement('li');
                li.textContent = mensaje;
                errorList.appendChild(li);
            });
        });
        
        document.getElementById('form-errors').classList.remove('hidden');
    }
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
@endpush 