@extends('admin.dashboard')

@section('admin_content')
    <!-- Mensaje de éxito -->
    <div id="success-message" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert" style="display: none;">
        <span id="success-message-text" class="block sm:inline"></span>
    </div>
    
    <div class="flex justify-end mb-4">
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

    <!-- Modal Confirmación Activar/Desactivar -->
    <div id="modal-eliminar" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg p-8 max-w-md w-full">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-semibold text-gray-800" id="action-title">Confirmar Desactivación</h3>
                <button id="modal-eliminar-close" class="text-gray-500 hover:text-gray-700">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            
            <p class="text-gray-600 mb-6" id="action-message">¿Estás seguro de que deseas desactivar este profesor? Los profesores desactivados no serán visibles para los usuarios.</p>
            
            <form id="form-activar" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="profesor_id" id="profesor_id_activar">
                <input type="hidden" name="is_active" id="is_active" value="1">
                
                <div class="flex justify-end space-x-3">
                    <button type="button" id="btn-cancelar-eliminar" class="px-4 py-2 text-gray-600 bg-gray-100 rounded-md hover:bg-gray-200">
                        Cancelar
                    </button>
                    <button type="submit" id="action-button" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                        Desactivar
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
    // Variable global para control de envíos
    let isSubmitting = false;
    
    document.addEventListener('DOMContentLoaded', function() {
        // Variables de control
        let timeoutId = null;

        // Inicializar event listeners
        setupEventListeners();
        setupFilterListeners();
    
    function setupEventListeners() {
            // Botón crear profesor
            const btnCrearProfesor = document.getElementById('btnCrearProfesor');
            if (btnCrearProfesor) {
                btnCrearProfesor.addEventListener('click', function() {
                mostrarFormularioCrear();
                });
            }
            
            // Delegación de eventos para botones dinámicos
            document.addEventListener('click', function(e) {
                // Botón editar profesor
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
                    document.getElementById('modal-profesor').classList.add('hidden');
                    document.getElementById('modal-profesor').classList.remove('flex');
                });
            }
            
            if (btnCancelar) {
                btnCancelar.addEventListener('click', function() {
                document.getElementById('modal-profesor').classList.add('hidden');
                    document.getElementById('modal-profesor').classList.remove('flex');
                });
            }
            
            // Formulario
            const formProfesor = document.getElementById('form-profesor');
            if (formProfesor) {
                formProfesor.addEventListener('submit', function(e) {
                    e.preventDefault();
                    enviarFormulario(this);
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
    
    // Funciones para crear/editar profesores
    function mostrarFormularioCrear() {
        // Resetear el formulario
        const form = document.getElementById('form-profesor');
        if (form) {
            form.reset();
            form.setAttribute('action', '/admin/profesores');
            
            // Ocultar errores previos
            const formErrors = document.getElementById('form-errors');
            if (formErrors) {
                formErrors.classList.add('hidden');
                document.getElementById('error-list').innerHTML = '';
            }
            
            // Configurar campos
            document.getElementById('profesor_id').value = '';
            document.getElementById('form_method').value = 'POST';
            document.getElementById('modal-title').textContent = 'Crear Nuevo Profesor';
            
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
            
            // Mostrar el modal
            const modalProfesor = document.getElementById('modal-profesor');
            if (modalProfesor) {
                modalProfesor.classList.remove('hidden');
                modalProfesor.classList.add('flex');
            }
        }
    }
    
    function mostrarFormularioEditar(id) {
        if (!id) {
            console.error('ID de profesor no válido');
            return;
        }
        
        // Configurar el formulario
        const form = document.getElementById('form-profesor');
        if (form) {
            form.reset();
            form.setAttribute('action', `/admin/profesores/${id}`);
            
            // Ocultar errores previos
            const formErrors = document.getElementById('form-errors');
            if (formErrors) {
                formErrors.classList.add('hidden');
                document.getElementById('error-list').innerHTML = '';
            }
            
            // Configurar campos
            document.getElementById('profesor_id').value = id;
            document.getElementById('form_method').value = 'PUT';
            document.getElementById('modal-title').textContent = 'Editar Profesor';
            
            // Configurar campos de contraseña como opcionales
            const passwordRequired = document.querySelector('.password-required');
            const passwordHelp = document.querySelector('.password-help');
            
            if (passwordRequired) passwordRequired.classList.add('hidden');
            if (passwordHelp) passwordHelp.classList.remove('hidden');
            
            const password = document.getElementById('password');
            const passwordConfirmation = document.getElementById('password_confirmation');
            
            if (password) password.removeAttribute('required');
            if (passwordConfirmation) passwordConfirmation.removeAttribute('required');
            
            // Mostrar campo de activo para cuentas existentes
            const activoContainer = document.getElementById('activo-container');
            if (activoContainer) activoContainer.classList.remove('hidden');
            
            // Cargar datos del profesor
            fetch(`/admin/profesores/${id}/edit`, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`Error del servidor: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log('Datos recibidos del servidor:', data);
                
                // Comprobar si se recibieron datos y su estructura
                if (data && (data.profesor || data.docente)) {
                    // Usar la estructura correcta según lo que devuelva el servidor
                    const docente = data.profesor || data.docente;
                    
                    // Asegurarnos de que tenemos el objeto user
                    if (!docente.user) {
                        console.error('Error: No se encontró la propiedad user en los datos del profesor');
                        alert('Error: Faltan datos del usuario asociado al profesor');
                        return;
                    }
                    
                    const user = docente.user;
                    
                    // Datos de usuario
                    if (document.getElementById('nombre')) {
                        document.getElementById('nombre').value = user.nombre || '';
                    }
                    if (document.getElementById('email')) {
                        document.getElementById('email').value = user.email || '';
                    }
                    if (document.getElementById('password')) {
                        document.getElementById('password').value = '';
                    }
                    if (document.getElementById('password_confirmation')) {
                        document.getElementById('password_confirmation').value = '';
                    }
                    if (document.getElementById('dni')) {
                        document.getElementById('dni').value = user.dni || '';
                    }
                    if (document.getElementById('telefono')) {
                        document.getElementById('telefono').value = user.telefono || '';
                    }
                    if (document.getElementById('ciudad')) {
                        document.getElementById('ciudad').value = user.ciudad || '';
                    }
                    
                    // Formatear fecha de nacimiento
                    if (user.fecha_nacimiento && document.getElementById('fecha_nacimiento')) {
                        document.getElementById('fecha_nacimiento').value = user.fecha_nacimiento.split('T')[0];
                    }
                    
                    if (document.getElementById('sitio_web')) {
                        document.getElementById('sitio_web').value = user.sitio_web || '';
                    }
                    if (document.getElementById('descripcion')) {
                        document.getElementById('descripcion').value = user.descripcion || '';
                    }
                    
                    const activo = document.getElementById('activo');
                    if (activo) {
                        activo.checked = user.activo ? true : false;
                    }
                    
                    // Cargar imagen
                    const imagenPreview = document.getElementById('imagen-preview');
                    const imagenPreviewImg = document.getElementById('imagen-preview-img');
                    
                    if (user.imagen) {
                        if (imagenPreviewImg) {
                            imagenPreviewImg.src = `/profile_images/${user.imagen}`;
                        }
                        if (imagenPreview) {
                            imagenPreview.classList.remove('hidden');
                        }
                    } else {
                        if (imagenPreview) {
                            imagenPreview.classList.add('hidden');
                        }
                    }
                    
                    // Mostrar el modal
                    const modalProfesor = document.getElementById('modal-profesor');
                    if (modalProfesor) {
                        modalProfesor.classList.remove('hidden');
                        modalProfesor.classList.add('flex');
                    }
                } else {
                    console.error('No se recibieron datos del profesor o formato incorrecto:', data);
                    alert('Error: No se pudieron cargar los datos del profesor correctamente');
                }
            })
            .catch(error => {
                console.error('Error al obtener datos del profesor:', error);
                alert(`Error al obtener los datos del profesor: ${error.message}`);
            });
        }
    }
    
    function enviarFormulario(form) {
        // Evitar envíos duplicados
        if (isSubmitting) return;
        isSubmitting = true;
        
        // Validar contraseñas
        const password = document.getElementById('password').value;
        const passwordConfirmation = document.getElementById('password_confirmation').value;
        
        if (password && password !== passwordConfirmation) {
            mostrarErrores({
                'password_confirmation': ['Las contraseñas no coinciden']
            });
            isSubmitting = false;
            return;
        }
        
        const formData = new FormData(form);
        const method = document.getElementById('form_method').value;
        const url = form.getAttribute('action');
        
        if (method === 'PUT') {
            formData.append('_method', 'PUT');
        }
        
        // Deshabilitar botón de guardar
        const btnGuardar = document.getElementById('btn-guardar');
        if (btnGuardar) btnGuardar.disabled = true;
        
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
            if (data.success) {
                // Cerrar modal y mostrar mensaje de éxito
                document.getElementById('modal-profesor').classList.add('hidden');
                document.getElementById('modal-profesor').classList.remove('flex');
                
                mostrarMensajeExito(data.message || 'Profesor guardado correctamente');
                
                // Actualizar tabla
                refreshProfesoresTable();
            } else if (data.errors) {
                mostrarErrores(data.errors);
            } else {
                alert(data.message || 'Ha ocurrido un error');
            }
        })
        .catch(error => {
            console.error('Error al procesar el formulario:', error);
            alert('Ha ocurrido un error al procesar la solicitud');
        })
        .finally(() => {
            isSubmitting = false;
            if (btnGuardar) btnGuardar.disabled = false;
        });
    }
    
    // Funciones para activar/desactivar
    function openActivateModal(id, isActive) {
        const profesorIdInput = document.getElementById('profesor_id_activar');
        const isActiveInput = document.getElementById('is_active');
        const actionTitle = document.getElementById('action-title');
        const actionMessage = document.getElementById('action-message');
        const actionButton = document.getElementById('action-button');
        const modal = document.getElementById('modal-eliminar');
        
        if (!profesorIdInput || !isActiveInput || !actionTitle || !actionMessage || !actionButton || !modal) {
            console.error('No se encontraron elementos necesarios para el modal');
            return;
        }
        
        profesorIdInput.value = id;
        isActiveInput.value = isActive;
        
        if (isActive === '1') {
            actionTitle.textContent = 'Confirmar Desactivación';
            actionMessage.textContent = '¿Estás seguro de que deseas desactivar este profesor? Los profesores desactivados no serán visibles para los usuarios.';
            actionButton.textContent = 'Desactivar';
            actionButton.classList.remove('bg-green-600', 'hover:bg-green-700');
            actionButton.classList.add('bg-red-600', 'hover:bg-red-700');
        } else {
            actionTitle.textContent = 'Confirmar Activación';
            actionMessage.textContent = '¿Estás seguro de que deseas activar este profesor? Los profesores activos serán visibles para los usuarios.';
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
        const id = document.getElementById('profesor_id_activar').value;
        const isActive = document.getElementById('is_active').value === '1';
        
        if (!id) {
            console.error('ID de profesor no encontrado');
            alert('Error: ID de profesor no válido');
            return;
        }
        
        fetch(`/admin/profesores/${id}`, {
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
            closeDeleteModal();
            
            if (data.success) {
                mostrarMensajeExito(data.message || 'Operación realizada correctamente');
                refreshProfesoresTable();
            } else {
                alert(data.message || 'Ha ocurrido un error');
            }
        })
        .catch(error => {
            console.error('Error al activar/desactivar profesor:', error);
            alert('Ha ocurrido un error al procesar la solicitud');
        });
    }
    
    // Funciones utilitarias
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
    
    function mostrarErrores(errores) {
        const errorsDiv = document.getElementById('form-errors');
        const errorsList = document.getElementById('error-list');
        
        if (!errorsDiv || !errorsList) return;
        
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
    
    function refreshProfesoresTable() {
        fetch('/admin/profesores', {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.text())
        .then(html => {
            document.getElementById('tabla-profesores').innerHTML = html;
        })
        .catch(error => {
            console.error('Error al actualizar la tabla:', error);
        });
    }
    
    function aplicarFiltros() {
        const filtros = {
            nombre: document.getElementById('filtro_nombre')?.value || '',
            email: document.getElementById('filtro_email')?.value || '',
            dni: document.getElementById('filtro_dni')?.value || '',
            estado: document.getElementById('filtro_estado')?.value || '',
            ciudad: document.getElementById('filtro_ciudad')?.value || ''
        };
        
        const params = new URLSearchParams();
        Object.entries(filtros).forEach(([key, value]) => {
            if (value) {
                params.append(key, value);
            }
        });
        
        fetch(`/admin/profesores?${params.toString()}`, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.text())
        .then(html => {
            document.getElementById('tabla-profesores').innerHTML = html;
        })
        .catch(error => {
            console.error('Error al aplicar filtros:', error);
        });
    }
</script>

<!-- Script de validaciones para profesores -->
<script src="{{ asset('js/profesores-validaciones.js') }}"></script>

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