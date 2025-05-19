@extends('admin.dashboard')

@section('admin_content')
    <!-- Mensaje de éxito -->
    <div id="success-message" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert" style="display: none;">
        <span id="success-message-text" class="block sm:inline"></span>
    </div>
    
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
                <label for="filtro_titulo" class="block text-sm font-medium text-purple-700 mb-2">Título de la oferta</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" id="filtro_titulo" class="pl-10 w-full rounded-lg border-purple-200 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50" placeholder="Buscar por título...">
                </div>
            </div>
            
            <div class="relative">
                <label for="filtro_empresa" class="block text-sm font-medium text-purple-700 mb-2">Nombre de la empresa</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    <input type="text" id="filtro_empresa" class="pl-10 w-full rounded-lg border-purple-200 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50" placeholder="Buscar por empresa...">
                </div>
            </div>
            
            <div class="relative">
                <label for="filtro_categoria" class="block text-sm font-medium text-purple-700 mb-2">Categoría</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
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
                <label for="filtro_subcategoria" class="block text-sm font-medium text-purple-700 mb-2">Subcategoría</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4" />
                        </svg>
                    </div>
                    <select id="filtro_subcategoria" class="pl-10 w-full rounded-lg border-purple-200 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50 appearance-none bg-white">
                    <option value="">Todas las subcategorías</option>
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
    <div id="tabla-container">
        @include('admin.publicaciones.tabla')
    </div>

    <!-- Modal para Crear/Editar Publicación -->
    <div id="modal-publicacion" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg p-8 max-w-4xl w-full max-h-screen overflow-y-auto">
            <div class="flex justify-between items-center mb-6">
                <h3 id="modal-titulo" class="text-xl font-semibold">Nueva Oferta</h3>
                <button id="modal-close" class="text-gray-500 hover:text-gray-700">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            
            <!-- Mensajes de error del formulario -->
            <div id="form-errors" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6 hidden" role="alert">
                <strong class="font-bold">¡Hay errores en el formulario!</strong>
                <ul id="error-list" class="mt-2 list-disc list-inside"></ul>
            </div>
            
            <form id="form-publicacion" method="POST">
                @csrf
                <input type="hidden" id="publicacion_id" name="publicacion_id" value="">
                <input type="hidden" id="form_method" name="_method" value="POST">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="titulo" class="block text-sm font-medium text-gray-700 mb-1">Título</label>
                        <input type="text" name="titulo" id="titulo" 
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50"
                               required maxlength="100">
                    </div>
                    
                    <div>
                        <label for="empresa_id" class="block text-sm font-medium text-gray-700 mb-1">Empresa</label>
                        <select name="empresa_id" id="empresa_id" 
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50"
                                required>
                            <option value="">Selecciona una empresa</option>
                            @foreach($empresas as $empresa)
                                <option value="{{ $empresa->id }}">
                                    {{ $empresa->user->nombre ?? 'Empresa #'.$empresa->id }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div>
                        <label for="categoria_id" class="block text-sm font-medium text-gray-700 mb-1">Categoría</label>
                        <select name="categoria_id" id="categoria_id" 
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50"
                                required>
                            <option value="">Selecciona una categoría</option>
                            @foreach($categorias as $categoria)
                                <option value="{{ $categoria->id }}">
                                    {{ $categoria->nombre_categoria }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div>
                        <label for="subcategoria_id" class="block text-sm font-medium text-gray-700 mb-1">Subcategoría</label>
                        <select name="subcategoria_id" id="subcategoria_id" 
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50"
                                required>
                            <option value="">Selecciona una subcategoría</option>
                        </select>
                    </div>
                    
                    <div>
                        <label for="horario" class="block text-sm font-medium text-gray-700 mb-1">Horario</label>
                        <select name="horario" id="horario" 
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50"
                                required>
                            <option value="mañana">Mañana</option>
                            <option value="tarde">Tarde</option>
                            <option value="flexible">Flexible</option>
                        </select>
                    </div>
                    
                    <div>
                        <label for="horas_totales" class="block text-sm font-medium text-gray-700 mb-1">Horas Totales</label>
                        <input type="number" name="horas_totales" id="horas_totales" 
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50"
                               required min="1">
                    </div>
                    
                    <div>
                        <label for="fecha_publicacion" class="block text-sm font-medium text-gray-700 mb-1">Fecha de Publicación</label>
                        <input type="date" name="fecha_publicacion" id="fecha_publicacion" 
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50"
                               required value="{{ date('Y-m-d') }}">
                    </div>
                    
                    <div class="flex items-center">
                        <input type="checkbox" name="activa" id="activa" value="1" checked
                               class="rounded border-gray-300 text-purple-600 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-50">
                        <label for="activa" class="ml-2 text-sm font-medium text-gray-700">Publicación Activa</label>
                    </div>
                </div>
                
                <div class="mt-6">
                    <label for="descripcion" class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                    <textarea name="descripcion" id="descripcion" rows="6" 
                              class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50"
                              required></textarea>
                </div>
                
                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" id="btn-cancelar" class="px-4 py-2 text-gray-600 bg-gray-100 rounded-md hover:bg-gray-200">
                        Cancelar
                    </button>
                    <button type="submit" id="btn-guardar" class="px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700">
                        Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal de Confirmación de Eliminación -->
    <div id="modal-eliminar" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg p-8 max-w-md w-full">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-semibold text-gray-800" id="action-title">Confirmar Desactivación</h3>
                <button id="modal-eliminar-close" class="text-gray-500 hover:text-gray-700">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            
            <p class="text-gray-600 mb-6" id="action-message">¿Estás seguro de que deseas desactivar esta oferta? Las ofertas desactivadas no serán visibles para los usuarios.</p>
            
            <form id="form-activar" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="publicacion_id" id="publicacion_id_activar">
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inicializar variables
        let timeoutId = null;
        let listenersLoaded = false;
        
        // Configurar event listeners
        setupEventListeners();
        setupFilterListeners();
        
        // Event listeners para el formulario
        document.getElementById('categoria_id').addEventListener('change', function() {
            cargarSubcategorias(this.value);
        });
        
        // Manejar envío del formulario
        document.getElementById('form-publicacion').addEventListener('submit', function(e) {
            e.preventDefault();
            guardarPublicacion();
        });
        
        // Manejar eliminación
        document.getElementById('form-activar').addEventListener('submit', function(e) {
            e.preventDefault();
            activarPublicacion();
        });
        
        // Resetear filtros
        document.getElementById('reset-filtros').addEventListener('click', function() {
            document.getElementById('filtro_titulo').value = '';
            document.getElementById('filtro_empresa').value = '';
            document.getElementById('filtro_categoria').value = '';
            document.getElementById('filtro_subcategoria').value = '';
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
            }, 300); // Espera 300ms después de que el usuario deje de escribir
        }
        
        function setupEventListeners() {
            if (listenersLoaded) return;
            
            // Configurar event listeners para filtros
            setupFilterListeners();
            
            // Delegar eventos para los botones
            document.addEventListener('click', function(e) {
                // Botón crear
                if (e.target.closest('.btn-crear')) {
                    e.preventDefault();
                    resetForm();
                    document.getElementById('modal-titulo').textContent = 'Nueva Oferta';
                    document.getElementById('form-publicacion').setAttribute('action', '{{ route("admin.publicaciones.store") }}');
                    document.getElementById('form_method').value = 'POST';
                    document.getElementById('modal-publicacion').classList.remove('hidden');
                    document.getElementById('modal-publicacion').classList.add('flex');
                }
                
                // Botón editar
                if (e.target.closest('.btn-editar')) {
                    e.preventDefault();
                    const id = e.target.closest('.btn-editar').getAttribute('data-id');
                    cargarPublicacion(id);
                }
                
                // Botón activar/desactivar
                if (e.target.closest('.btn-activar')) {
                    e.preventDefault();
                    const button = e.target.closest('.btn-activar');
                    const id = button.getAttribute('data-id');
                    const isActive = button.getAttribute('data-active');
                    showActivateModal(id, isActive);
                }
                
                // Botones cerrar y cancelar
                if (e.target.closest('#modal-close') || e.target.closest('#btn-cancelar')) {
                    document.getElementById('modal-publicacion').classList.remove('flex');
                    document.getElementById('modal-publicacion').classList.add('hidden');
                    resetForm();
                }
                
                if (e.target.closest('#modal-eliminar-close') || e.target.closest('#btn-cancelar-eliminar')) {
                    document.getElementById('modal-eliminar').classList.remove('flex');
                    document.getElementById('modal-eliminar').classList.add('hidden');
                }
                
                // Enlaces de paginación
                const paginationLink = e.target.closest('.pagination a');
                if (paginationLink) {
                    e.preventDefault();
                    const url = paginationLink.getAttribute('href');
                    actualizarTabla(url);
                }
            });
            
            listenersLoaded = true;
        }
        
        function resetForm() {
            const form = document.getElementById('form-publicacion');
            form.reset();
            document.getElementById('publicacion_id').value = '';
            document.getElementById('form_method').value = 'POST';
            
            const errorsDiv = document.getElementById('form-errors');
            const errorsList = document.getElementById('error-list');
            errorsDiv.classList.add('hidden');
            errorsList.innerHTML = '';
            
            // Reiniciar el select de subcategorías
            const subcatSelect = document.getElementById('subcategoria_id');
            subcatSelect.innerHTML = '<option value="">Selecciona una subcategoría</option>';
        }
        
        function cargarPublicacion(id) {
            fetch(`/admin/publicaciones/${id}/edit`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                resetForm();
                
                // Cargar datos de la publicación
                document.getElementById('modal-titulo').textContent = 'Editar Oferta';
                document.getElementById('publicacion_id').value = data.publicacion.id;
                document.getElementById('titulo').value = data.publicacion.titulo;
                document.getElementById('empresa_id').value = data.publicacion.empresa_id;
                document.getElementById('categoria_id').value = data.publicacion.categoria_id;
                document.getElementById('horario').value = data.publicacion.horario;
                document.getElementById('horas_totales').value = data.publicacion.horas_totales;
                document.getElementById('fecha_publicacion').value = data.publicacion.fecha_publicacion.substring(0, 10);
                document.getElementById('activa').checked = data.publicacion.activa == 1;
                document.getElementById('descripcion').value = data.publicacion.descripcion;
                
                // Cargar subcategorías y seleccionar la correcta
                cargarSubcategorias(data.publicacion.categoria_id, data.publicacion.subcategoria_id);
                
                document.getElementById('form_method').value = 'PUT';
                document.getElementById('form-publicacion').setAttribute('action', `/admin/publicaciones/${id}`);
                
                document.getElementById('modal-publicacion').classList.remove('hidden');
                document.getElementById('modal-publicacion').classList.add('flex');
            })
            .catch(error => {
                console.error('Error:', error);
                mostrarMensajeError('Error al cargar la oferta');
            });
        }
        
        function cargarSubcategorias(categoriaId, subcategoriaSeleccionada = null) {
            if (!categoriaId) return;
            
            fetch(`/admin/categorias/${categoriaId}/subcategorias`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                const subcatSelect = document.getElementById('subcategoria_id');
                subcatSelect.innerHTML = '<option value="">Selecciona una subcategoría</option>';
                
                data.subcategorias.forEach(subcategoria => {
                    const option = document.createElement('option');
                    option.value = subcategoria.id;
                    option.textContent = subcategoria.nombre_subcategoria;
                    
                    if (subcategoriaSeleccionada && subcategoriaSeleccionada == subcategoria.id) {
                        option.selected = true;
                    }
                    
                    subcatSelect.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
        
        function cargarSubcategoriasFiltro(categoriaId) {
            const subcatSelect = document.getElementById('filtro_subcategoria');
            subcatSelect.innerHTML = '<option value="">Todas las subcategorías</option>';
            
            if (!categoriaId) {
                aplicarFiltros();
                    return;
                }

            fetch(`/admin/categorias/${categoriaId}/subcategorias`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                data.subcategorias.forEach(subcategoria => {
                    const option = document.createElement('option');
                    option.value = subcategoria.id;
                    option.textContent = subcategoria.nombre_subcategoria;
                    subcatSelect.appendChild(option);
                });
                
                aplicarFiltros();
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
        
        function guardarPublicacion() {
            const form = document.getElementById('form-publicacion');
            const formData = new FormData(form);
            const method = document.getElementById('form_method').value;
            const url = form.getAttribute('action');
            
            if (method === 'PUT') {
                formData.append('_method', 'PUT');
            }
            
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
                    document.getElementById('modal-publicacion').classList.remove('flex');
                    document.getElementById('modal-publicacion').classList.add('hidden');
                    
                    mostrarMensajeExito(data.message || 'Oferta guardada exitosamente');
                    actualizarTabla();
                    resetForm();
                } else if (data.errors) {
                    mostrarErrores(data.errors);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                mostrarMensajeError('Error al guardar la oferta');
            });
        }
        
        function activarPublicacion() {
            // Obtener el ID y estado de la publicación del formulario
            const id = document.getElementById('publicacion_id_activar').value;
            const isActive = document.getElementById('is_active').value === '1';
            
            // Validar ID
            if (!id || id === 'null') {
                console.error('ID de publicación no válido');
                alert('Error: La publicación no tiene un ID válido');
                return;
            }
            
            // Preparar los datos, solo enviando lo mínimo necesario
            const formData = new FormData();
            formData.append('_method', 'PUT');
            formData.append('activa', isActive ? 0 : 1);
            
            // Enviar solicitud para activar/desactivar
            fetch(`/admin/publicaciones/${id}`, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                // Cerrar modal
                document.getElementById('modal-eliminar').classList.remove('flex');
                document.getElementById('modal-eliminar').classList.add('hidden');
                
                if (data.success) {
                    // Mostrar mensaje de éxito
                    const mensaje = isActive ? 'Publicación desactivada correctamente' : 'Publicación activada correctamente';
                    mostrarMensajeExito(data.message || mensaje);
                    
                    // Actualizar tabla
                    aplicarFiltros();
                } else {
                    // Mostrar mensaje de error
                    alert(data.message || 'Ha ocurrido un error al procesar la solicitud');
                }
            })
            .catch(error => {
                console.error('Error al activar/desactivar publicación:', error);
                alert('Ha ocurrido un error al procesar la solicitud');
            });
        }
        
        function mostrarMensajeExito(mensaje) {
            const messageElement = document.getElementById('success-message');
            const messageText = document.getElementById('success-message-text');
            
            messageText.textContent = mensaje;
            messageElement.style.display = 'block';
            
            window.scrollTo(0, 0);
            
            setTimeout(function() {
                messageElement.style.display = 'none';
            }, 5000);
        }
        
        function mostrarMensajeError(mensaje) {
            // Si tenemos un div de error global, mostrarlo
            // Si no, usar alert
            alert(mensaje);
        }
        
        function mostrarErrores(errores) {
            const errorsDiv = document.getElementById('form-errors');
            const errorsList = document.getElementById('error-list');
            
            errorsList.innerHTML = '';
            
            for (const key in errores) {
                if (errores.hasOwnProperty(key)) {
                    errores[key].forEach(error => {
                        const li = document.createElement('li');
                        li.textContent = error;
                        errorsList.appendChild(li);
                    });
                }
            }
            
            errorsDiv.classList.remove('hidden');
        }
        
        function actualizarTabla(url = '{{ route("admin.publicaciones.index") }}') {
            if (url.indexOf('?') !== -1) {
                // La URL ya tiene parámetros
                const filtros = {
                    titulo: document.getElementById('filtro_titulo').value,
                    empresa: document.getElementById('filtro_empresa').value,
                    categoria: document.getElementById('filtro_categoria').value,
                    subcategoria: document.getElementById('filtro_subcategoria').value
                };
                
                // Construir un objeto URLSearchParams con los parámetros existentes
                const urlObj = new URL(url, window.location.origin);
                const params = urlObj.searchParams;
                
                // Agregar los filtros
                Object.entries(filtros).forEach(([key, value]) => {
                    if (value) {
                        params.set(key, value);
                    } else {
                        params.delete(key);
                    }
                });
                
                // Reconstruir la URL
                url = urlObj.pathname + '?' + params.toString();
            } else {
                // La URL no tiene parámetros, aplicar filtros
                aplicarFiltros();
                return;
            }
            
            fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.tabla) {
                    document.getElementById('tabla-container').innerHTML = data.tabla;
                    setupEventListeners();
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }

    function aplicarFiltros() {
        const filtros = {
            titulo: document.getElementById('filtro_titulo')?.value || '',
            empresa: document.getElementById('filtro_empresa')?.value || '',
            categoria_id: document.getElementById('filtro_categoria')?.value || '',
            subcategoria_id: document.getElementById('filtro_subcategoria')?.value || '',
            activa: document.getElementById('filtro_estado')?.value || ''
        };

        const params = new URLSearchParams();
        Object.entries(filtros).forEach(([key, value]) => {
            if (value) {
                params.append(key, value);
            }
        });

        fetch(`/admin/publicaciones?${params.toString()}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
            .then(response => response.json())
        .then(data => {
            if (data.tabla) {
                document.getElementById('tabla-container').innerHTML = data.tabla;
                    setupEventListeners();
            }
        })
        .catch(error => {
                console.error('Error:', error);
        });
    }

    // Actualizar la función que abre el modal de activar/desactivar
    function showActivateModal(id, isActive) {
        const modal = document.getElementById('modal-eliminar');
        const actionTitle = document.getElementById('action-title');
        const actionMessage = document.getElementById('action-message');
        const actionButton = document.getElementById('action-button');
        const isActiveInput = document.getElementById('is_active');
        const publicacionIdInput = document.getElementById('publicacion_id_activar');
        
        // Actualizar los valores según el estado
        publicacionIdInput.value = id;
        isActiveInput.value = isActive;
        
        // Actualizar el aspecto según si se va a activar o desactivar
        if (isActive === '1') {
            actionTitle.textContent = 'Confirmar Desactivación';
            actionMessage.textContent = '¿Estás seguro de que deseas desactivar esta oferta? Las ofertas desactivadas no serán visibles para los usuarios.';
            actionButton.textContent = 'Desactivar';
            actionButton.classList.remove('bg-green-600', 'hover:bg-green-700');
            actionButton.classList.add('bg-red-600', 'hover:bg-red-700');
        } else {
            actionTitle.textContent = 'Confirmar Activación';
            actionMessage.textContent = '¿Estás seguro de que deseas activar esta oferta? Las ofertas activas serán visibles para los usuarios.';
            actionButton.textContent = 'Activar';
            actionButton.classList.remove('bg-red-600', 'hover:bg-red-700');
            actionButton.classList.add('bg-green-600', 'hover:bg-green-700');
        }
        
        // Mostrar el modal
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    // Configurar event listeners para filtros
    function setupFilterListeners() {
        // Filtro de título
        const filtroTitulo = document.getElementById('filtro_titulo');
        if (filtroTitulo) {
            filtroTitulo.addEventListener('input', debounceFilter);
        }
        
        // Filtro de empresa
        const filtroEmpresa = document.getElementById('filtro_empresa');
        if (filtroEmpresa) {
            filtroEmpresa.addEventListener('input', debounceFilter);
        }
        
        // Filtro de categoría
        const filtroCategoria = document.getElementById('filtro_categoria');
        if (filtroCategoria) {
            filtroCategoria.addEventListener('change', function() {
                cargarSubcategoriasFiltro(this.value);
            });
        }
        
        // Filtro de subcategoría
        const filtroSubcategoria = document.getElementById('filtro_subcategoria');
        if (filtroSubcategoria) {
            filtroSubcategoria.addEventListener('change', aplicarFiltros);
        }
        
        // Filtro de estado
        const filtroEstado = document.getElementById('filtro_estado');
        if (filtroEstado) {
            filtroEstado.addEventListener('change', aplicarFiltros);
        }
    }
    });
</script>

<!-- Script de validaciones para publicaciones -->
<script src="{{ asset('js/publicaciones-validaciones.js') }}"></script>
@endsection 