@extends('admin.dashboard')

@section('admin_content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-purple-800">Gestión de Instituciones</h1>
        <button id="btn-crear-institucion" class="btn-crear px-4 py-2 bg-purple-600 text-white rounded hover:bg-purple-700 transition-colors">
            <i class="fas fa-plus mr-2"></i>Nueva Institución
        </button>
    </div>

    <div id="tabla-instituciones-container">
        @include('admin.instituciones.tabla')
    </div>

    <!-- Modal de Creación/Edición -->
    <div id="modal-institucion" class="hidden fixed inset-0 bg-black bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-10 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
            <div class="flex justify-between items-center border-b pb-3">
                <h3 id="modal-titulo" class="text-xl font-semibold text-gray-700">Nueva Institución</h3>
                <button id="modal-close" class="text-gray-400 hover:text-gray-500">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="mt-4 max-h-[70vh] overflow-y-auto p-2">
                <form id="form-institucion" action="{{ route('admin.instituciones.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="form_method" name="_method" value="POST">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <!-- Datos del Usuario -->
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="text-lg font-medium text-gray-700 mb-3">Datos de Usuario</h4>
                            
                            <div class="mb-3">
                                <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre</label>
                                <input type="text" id="nombre" name="nombre" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                <input type="email" id="email" name="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
                                <input type="password" id="password" name="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                <p class="text-xs text-gray-500 mt-1">Dejar en blanco para mantener la actual (solo en edición)</p>
                            </div>
                            
                            <div class="mb-3">
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmar Contraseña</label>
                                <input type="password" id="password_confirmation" name="password_confirmation" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            </div>
                            
                            <div class="mb-3">
                                <label for="dni" class="block text-sm font-medium text-gray-700">DNI/NIF</label>
                                <input type="text" id="dni" name="dni" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="telefono" class="block text-sm font-medium text-gray-700">Teléfono</label>
                                <input type="text" id="telefono" name="telefono" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="descripcion" class="block text-sm font-medium text-gray-700">Descripción</label>
                                <textarea id="descripcion" name="descripcion" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea>
                            </div>
                            
                            <div class="mb-3">
                                <label for="sitio_web" class="block text-sm font-medium text-gray-700">Sitio Web</label>
                                <input type="url" id="sitio_web" name="sitio_web" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            </div>
                            
                            <div class="mb-3">
                                <label for="imagen" class="block text-sm font-medium text-gray-700">Imagen de Perfil</label>
                                <input type="file" id="imagen" name="imagen" class="mt-1 block w-full" accept="image/*">
                                <div id="imagen-actual-container" class="hidden mt-2">
                                    <p class="text-sm">Imagen actual:</p>
                                    <img id="imagen-actual" src="" alt="Imagen actual" class="mt-1 h-20 w-20 object-cover rounded">
                                    <div class="mt-1">
                                        <label class="inline-flex items-center">
                                            <input type="checkbox" name="eliminar_imagen_actual" class="rounded border-gray-300 text-purple-600">
                                            <span class="ml-2 text-sm text-gray-600">Eliminar imagen actual</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="flex items-center">
                                    <input type="checkbox" name="activo" checked class="rounded border-gray-300 text-purple-600">
                                    <span class="ml-2 text-sm text-gray-600">Cuenta Activa</span>
                                </label>
                            </div>
                        </div>
                        
                        <!-- Datos de la Institución -->
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="text-lg font-medium text-gray-700 mb-3">Datos de la Institución</h4>
                            
                            <div class="mb-3">
                                <label for="codigo_centro" class="block text-sm font-medium text-gray-700">Código de Centro</label>
                                <input type="text" id="codigo_centro" name="codigo_centro" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="tipo_institucion" class="block text-sm font-medium text-gray-700">Tipo de Institución</label>
                                <select id="tipo_institucion" name="tipo_institucion" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                    <option value="">Seleccione un tipo</option>
                                    <option value="Educación Primaria">Educación Primaria</option>
                                    <option value="Educación Secundaria">Educación Secundaria</option>
                                    <option value="Formación Profesional">Formación Profesional</option>
                                    <option value="Universidad">Universidad</option>
                                    <option value="Centro de Educación Especial">Centro de Educación Especial</option>
                                    <option value="Centro de Educación de Adultos">Centro de Educación de Adultos</option>
                                    <option value="Escuela de Idiomas">Escuela de Idiomas</option>
                                    <option value="Escuela de Arte">Escuela de Arte</option>
                                    <option value="Conservatorio">Conservatorio</option>
                                    <option value="Otro">Otro</option>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label for="direccion" class="block text-sm font-medium text-gray-700">Dirección</label>
                                <input type="text" id="direccion" name="direccion" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="provincia" class="block text-sm font-medium text-gray-700">Provincia</label>
                                <input type="text" id="provincia" name="provincia" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="codigo_postal" class="block text-sm font-medium text-gray-700">Código Postal</label>
                                <input type="text" id="codigo_postal" name="codigo_postal" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="representante_legal" class="block text-sm font-medium text-gray-700">Representante Legal</label>
                                <input type="text" id="representante_legal" name="representante_legal" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="cargo_representante" class="block text-sm font-medium text-gray-700">Cargo del Representante</label>
                                <input type="text" id="cargo_representante" name="cargo_representante" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="flex items-center">
                                    <input type="checkbox" name="verificada" class="rounded border-gray-300 text-purple-600">
                                    <span class="ml-2 text-sm text-gray-600">Institución Verificada</span>
                                </label>
                            </div>
                            
                            <div class="mb-3">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Niveles Educativos</label>
                                <div class="bg-white p-2 rounded border border-gray-300 max-h-40 overflow-y-auto">
                                    @foreach($nivelesEducativos as $nivel)
                                    <div class="flex items-center mb-2">
                                        <input type="checkbox" id="nivel_{{ $nivel->id }}" name="niveles_educativos[]" value="{{ $nivel->id }}" class="rounded border-gray-300 text-purple-600">
                                        <label for="nivel_{{ $nivel->id }}" class="ml-2 text-sm text-gray-700">{{ $nivel->nombre_nivel }}</label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex justify-end space-x-3 mt-4">
                        <button type="button" id="btn-cancelar" class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 transition-colors">Cancelar</button>
                        <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded hover:bg-purple-700 transition-colors">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal de Confirmación de Eliminación -->
    <div id="modal-eliminar" class="hidden fixed inset-0 bg-black bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="flex justify-between items-center border-b pb-3">
                <h3 class="text-lg font-medium text-gray-700">Confirmar Eliminación</h3>
                <button id="modal-eliminar-close" class="text-gray-400 hover:text-gray-500">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="mt-4 mb-6">
                <p class="text-sm text-gray-700">¿Estás seguro que deseas eliminar esta institución? Esta acción no se puede deshacer.</p>
            </div>
            <form id="form-eliminar" method="POST">
                @csrf
                @method('DELETE')
                <input type="hidden" id="eliminar_id" name="id">
                <div class="flex justify-end space-x-3">
                    <button type="button" id="btn-cancelar-eliminar" class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 transition-colors">Cancelar</button>
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition-colors">Eliminar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal de Gestión de Categorías -->
    <div id="modal-categorias" class="hidden fixed inset-0 bg-black bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-10 mx-auto p-5 border w-11/12 md:w-4/5 lg:w-4/5 xl:w-3/4 shadow-lg rounded-md bg-white">
            <div class="flex justify-between items-center border-b pb-3">
                <h3 id="modal-categorias-titulo" class="text-xl font-semibold text-gray-700">Gestionar Categorías</h3>
                <button id="modal-categorias-close" class="text-gray-400 hover:text-gray-500">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="mt-4 max-h-[75vh] overflow-y-auto p-2">
                <div id="contenedor-categorias-institucion">
                    <div id="lista-niveles-educativos" class="mb-6">
                        <h4 class="text-lg font-medium text-gray-700 mb-3">Niveles Educativos de la Institución</h4>
                        <div id="niveles-container" class="flex flex-wrap gap-2 mb-4">
                            <!-- Aquí se cargarán dinámicamente los niveles educativos -->
                        </div>
                    </div>

                    <div id="categorias-por-nivel" class="mb-6">
                        <h4 class="text-lg font-medium text-gray-700 mb-3">Categorías por Nivel Educativo</h4>
                        <div class="bg-gray-50 p-4 rounded-lg mb-4">
                            <div id="no-categorias" class="hidden text-gray-500 text-sm">
                                Esta institución no tiene categorías asociadas.
                            </div>
                            <div id="categorias-container">
                                <!-- Aquí se cargarán dinámicamente las categorías por nivel -->
                            </div>
                        </div>
                    </div>

                    <div id="agregar-categorias" class="mb-6">
                        <h4 class="text-lg font-medium text-gray-700 mb-3">Agregar Nuevas Categorías</h4>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <form id="form-agregar-categoria">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                    <div>
                                        <label for="nueva-categoria-nivel" class="block text-sm font-medium text-gray-700 mb-1">Nivel Educativo</label>
                                        <select id="nueva-categoria-nivel" class="w-full rounded-md border-gray-300 shadow-sm" required>
                                            <option value="">Seleccione un nivel</option>
                                            <!-- Opciones cargadas dinámicamente -->
                                        </select>
                                    </div>
                                    <div>
                                        <label for="nueva-categoria-id" class="block text-sm font-medium text-gray-700 mb-1">Categoría</label>
                                        <select id="nueva-categoria-id" class="w-full rounded-md border-gray-300 shadow-sm" required disabled>
                                            <option value="">Seleccione primero un nivel</option>
                                            <!-- Opciones cargadas dinámicamente -->
                                        </select>
                                    </div>
                                </div>
                                <div class="flex items-center mb-4">
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" id="nueva-categoria-activo" class="rounded border-gray-300 text-purple-600" checked>
                                        <span class="ml-2 text-sm text-gray-700">Activo</span>
                                    </label>
                                </div>
                                <div class="flex justify-end">
                                    <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded hover:bg-purple-700 transition-colors">Agregar Categoría</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div id="mensaje-cargando-categorias" class="text-center py-8">
                    <div class="inline-block animate-spin rounded-full h-8 w-8 border-t-2 border-b-2 border-purple-600"></div>
                    <p class="mt-2 text-gray-600">Cargando categorías...</p>
                </div>
                <div id="error-categorias" class="hidden bg-red-50 text-red-700 p-4 rounded-lg mb-4">
                    <p class="font-medium">Error al cargar las categorías:</p>
                    <p id="error-categorias-mensaje"></p>
                </div>
            </div>
            <div class="flex justify-end space-x-3 mt-4 border-t pt-4">
                <button id="btn-cancelar-categorias" class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 transition-colors">Cerrar</button>
                <button id="btn-guardar-categorias" class="px-4 py-2 bg-purple-600 text-white rounded hover:bg-purple-700 transition-colors">Guardar Cambios</button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Botón de crear institución
            document.getElementById('btn-crear-institucion').addEventListener('click', function() {
                resetForm();
                document.getElementById('modal-titulo').textContent = 'Nueva Institución';
                document.getElementById('form-institucion').setAttribute('action', '{{ route("admin.instituciones.store") }}');
                document.getElementById('form_method').value = 'POST';
                document.getElementById('modal-institucion').classList.remove('hidden');
            });
            
            // Botones de cerrar y cancelar
            document.getElementById('modal-close').addEventListener('click', function() {
                document.getElementById('modal-institucion').classList.add('hidden');
            });
            
            document.getElementById('btn-cancelar').addEventListener('click', function() {
                document.getElementById('modal-institucion').classList.add('hidden');
            });
            
            document.getElementById('modal-eliminar-close').addEventListener('click', function() {
                document.getElementById('modal-eliminar').classList.add('hidden');
            });
            
            document.getElementById('btn-cancelar-eliminar').addEventListener('click', function() {
                document.getElementById('modal-eliminar').classList.add('hidden');
            });
            
            // Botones del modal de categorías
            document.getElementById('modal-categorias-close').addEventListener('click', function() {
                document.getElementById('modal-categorias').classList.add('hidden');
            });
            
            document.getElementById('btn-cancelar-categorias').addEventListener('click', function() {
                document.getElementById('modal-categorias').classList.add('hidden');
            });
            
            // Delegación de eventos para botones en la tabla
            document.addEventListener('click', function(e) {
                // Botón de editar
                if (e.target.closest('.btn-editar')) {
                    const id = e.target.closest('.btn-editar').getAttribute('data-id');
                    cargarInstitucion(id);
                }
                
                // Botón de eliminar
                if (e.target.closest('.btn-eliminar')) {
                    const id = e.target.closest('.btn-eliminar').getAttribute('data-id');
                    document.getElementById('eliminar_id').value = id;
                    document.getElementById('form-eliminar').setAttribute('action', '{{ route("admin.instituciones.destroy", ["institucione" => "__ID__"]) }}'.replace('__ID__', id));
                    document.getElementById('modal-eliminar').classList.remove('hidden');
                }
                
                // Botón de verificar/desverificar
                if (e.target.closest('.btn-verificar')) {
                    const btn = e.target.closest('.btn-verificar');
                    const id = btn.getAttribute('data-id');
                    cambiarVerificacion(id);
                }
                
                // Botón de gestionar categorías
                if (e.target.closest('.btn-categorias')) {
                    const id = e.target.closest('.btn-categorias').getAttribute('data-id');
                    abrirModalCategorias(id);
                }
                
                // Enlaces de paginación
                if (e.target.closest('.pagination-link')) {
                    e.preventDefault();
                    const url = e.target.closest('.pagination-link').getAttribute('href');
                    actualizarTabla(url);
                }
            });
            
            // Envío del formulario de institución
            document.getElementById('form-institucion').addEventListener('submit', function(e) {
                e.preventDefault();
                const form = this;
                const formData = new FormData(form);
                
                fetch(form.getAttribute('action'), {
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
                        document.getElementById('modal-institucion').classList.add('hidden');
                        actualizarTabla();
                        mostrarNotificacion(data.message, 'success');
                    } else {
                        mostrarNotificacion(data.message, 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    mostrarNotificacion('Error al procesar la solicitud', 'error');
                });
            });
            
            // Envío del formulario de eliminación
            document.getElementById('form-eliminar').addEventListener('submit', function(e) {
                e.preventDefault();
                const form = this;
                
                fetch(form.getAttribute('action'), {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        _method: 'DELETE'
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('modal-eliminar').classList.add('hidden');
                        actualizarTabla();
                        mostrarNotificacion(data.message, 'success');
                    } else {
                        mostrarNotificacion(data.message, 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    mostrarNotificacion('Error al procesar la solicitud', 'error');
                });
            });
            
            // Manejo del formulario para agregar categorías
            document.getElementById('form-agregar-categoria').addEventListener('submit', function(e) {
                e.preventDefault();
                agregarNuevaCategoria();
            });
            
            // Cambio en el selector de nivel para cargar las categorías correspondientes
            document.getElementById('nueva-categoria-nivel').addEventListener('change', function() {
                const nivelId = this.value;
                if (nivelId) {
                    cargarCategoriasPorNivel(nivelId);
                } else {
                    const categoriaSelect = document.getElementById('nueva-categoria-id');
                    categoriaSelect.innerHTML = '<option value="">Seleccione primero un nivel</option>';
                    categoriaSelect.disabled = true;
                }
            });
            
            // Guardar cambios en categorías
            document.getElementById('btn-guardar-categorias').addEventListener('click', function() {
                guardarCategorias();
            });
        });
        
        // Variables globales para gestionar categorías
        let institucionActualId;
        let categoriasPorAgregar = [];
        let categoriasPorEliminar = [];
        let todasCategoriasPorNivel = {}; // Todas las categorías disponibles por nivel
        
        // Función para cargar datos de una institución para editar
        function cargarInstitucion(id) {
            fetch('{{ route("admin.instituciones.edit", ["institucione" => "__ID__"]) }}'.replace('__ID__', id), {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                resetForm();
                
                const institucion = data.institucion;
                const user = institucion.user;
                const nivelesSeleccionados = data.niveles_seleccionados;
                
                // Rellenar campos de usuario
                document.getElementById('nombre').value = user.nombre;
                document.getElementById('email').value = user.email;
                document.getElementById('dni').value = user.dni;
                document.getElementById('telefono').value = user.telefono || '';
                document.getElementById('descripcion').value = user.descripcion || '';
                document.getElementById('sitio_web').value = user.sitio_web || '';
                
                if (user.activo) {
                    document.querySelector('input[name="activo"]').checked = true;
                }
                
                // Rellenar campos de institución
                document.getElementById('codigo_centro').value = institucion.codigo_centro;
                document.getElementById('tipo_institucion').value = institucion.tipo_institucion;
                document.getElementById('direccion').value = institucion.direccion;
                document.getElementById('provincia').value = institucion.provincia;
                document.getElementById('codigo_postal').value = institucion.codigo_postal;
                document.getElementById('representante_legal').value = institucion.representante_legal;
                document.getElementById('cargo_representante').value = institucion.cargo_representante;
                
                if (institucion.verificada) {
                    document.querySelector('input[name="verificada"]').checked = true;
                }
                
                // Marcar niveles educativos
                nivelesSeleccionados.forEach(nivelId => {
                    const checkbox = document.getElementById(`nivel_${nivelId}`);
                    if (checkbox) checkbox.checked = true;
                });
                
                // Mostrar imagen actual si existe
                if (user.imagen) {
                    document.getElementById('imagen-actual').src = `/storage/profile_images/${user.imagen}`;
                    document.getElementById('imagen-actual-container').classList.remove('hidden');
                }
                
                // Actualizar formulario para edición
                document.getElementById('modal-titulo').textContent = 'Editar Institución';
                document.getElementById('form-institucion').setAttribute('action', '{{ route("admin.instituciones.update", ["institucione" => "__ID__"]) }}'.replace('__ID__', id));
                document.getElementById('form_method').value = 'PUT';
                
                // Mostrar modal
                document.getElementById('modal-institucion').classList.remove('hidden');
            })
            .catch(error => {
                console.error('Error:', error);
                mostrarNotificacion('Error al cargar los datos de la institución', 'error');
            });
        }
        
        // Función para abrir el modal de categorías
        function abrirModalCategorias(id) {
            institucionActualId = id;
            categoriasPorAgregar = [];
            categoriasPorEliminar = [];
            
            // Mostrar carga y ocultar contenido
            document.getElementById('mensaje-cargando-categorias').classList.remove('hidden');
            document.getElementById('contenedor-categorias-institucion').classList.add('hidden');
            document.getElementById('error-categorias').classList.add('hidden');
            
            // Mostrar modal
            document.getElementById('modal-categorias').classList.remove('hidden');
            
            // Cargar datos de categorías
            cargarCategorias(id);
        }
        
        // Función para cargar las categorías de una institución
        function cargarCategorias(id) {
            fetch('{{ route("admin.instituciones.categorias", ["id" => "__ID__"]) }}'.replace('__ID__', id), {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Actualizar título del modal
                    document.getElementById('modal-categorias-titulo').textContent = 
                        `Gestionar Categorías: ${data.institucion.nombre}`;
                    
                    // Guardar datos para uso posterior
                    todasCategoriasPorNivel = data.todas_categorias;
                    
                    // Mostrar niveles educativos de la institución
                    mostrarNivelesEducativos(data.niveles_educativos);
                    
                    // Cargar selector de nivel educativo para nuevas categorías
                    cargarSelectorNivelEducativo(data.niveles_educativos);
                    
                    // Mostrar categorías por nivel
                    mostrarCategoriasPorNivel(data.categorias_por_nivel);
                    
                    // Ocultar carga y mostrar contenido
                    document.getElementById('mensaje-cargando-categorias').classList.add('hidden');
                    document.getElementById('contenedor-categorias-institucion').classList.remove('hidden');
                } else {
                    mostrarErrorCategorias(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                mostrarErrorCategorias('Error al cargar los datos: ' + error.message);
            });
        }
        
        // Función para mostrar los niveles educativos de la institución
        function mostrarNivelesEducativos(niveles) {
            const container = document.getElementById('niveles-container');
            container.innerHTML = '';
            
            if (niveles.length === 0) {
                container.innerHTML = '<p class="text-gray-500 text-sm">Esta institución no tiene niveles educativos asignados.</p>';
                return;
            }
            
            niveles.forEach(nivel => {
                const badge = document.createElement('span');
                badge.className = 'inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800';
                badge.textContent = nivel.nombre_nivel;
                container.appendChild(badge);
            });
        }
        
        // Función para cargar el selector de nivel educativo
        function cargarSelectorNivelEducativo(niveles) {
            const selector = document.getElementById('nueva-categoria-nivel');
            selector.innerHTML = '<option value="">Seleccione un nivel</option>';
            
            if (niveles.length === 0) {
                selector.disabled = true;
                selector.innerHTML = '<option value="">La institución no tiene niveles asignados</option>';
                return;
            }
            
            niveles.forEach(nivel => {
                const option = document.createElement('option');
                option.value = nivel.id;
                option.textContent = nivel.nombre_nivel;
                selector.appendChild(option);
            });
            
            selector.disabled = false;
        }
        
        // Función para mostrar las categorías por nivel educativo
        function mostrarCategoriasPorNivel(categoriasPorNivel) {
            const container = document.getElementById('categorias-container');
            container.innerHTML = '';
            
            const noCategoriasMsg = document.getElementById('no-categorias');
            
            if (Object.keys(categoriasPorNivel).length === 0) {
                noCategoriasMsg.classList.remove('hidden');
                return;
            }
            
            noCategoriasMsg.classList.add('hidden');
            
            // Para cada nivel, crear una sección con sus categorías
            Object.keys(categoriasPorNivel).forEach(nivelId => {
                const categorias = categoriasPorNivel[nivelId];
                
                // Buscar el nombre del nivel
                let nombreNivel = 'Nivel ' + nivelId;
                // Buscar en los niveles educativos
                const nivelesEdu = document.getElementById('nueva-categoria-nivel').options;
                for (let i = 0; i < nivelesEdu.length; i++) {
                    if (nivelesEdu[i].value == nivelId) {
                        nombreNivel = nivelesEdu[i].textContent;
                        break;
                    }
                }
                
                // Crear contenedor del nivel
                const nivelSection = document.createElement('div');
                nivelSection.className = 'mb-6 last:mb-0';
                nivelSection.innerHTML = `
                    <h5 class="font-medium text-gray-700 mb-2">${nombreNivel}</h5>
                    <div class="border rounded-lg overflow-hidden">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Categoría</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200" id="categoria-nivel-${nivelId}">
                            </tbody>
                        </table>
                    </div>
                `;
                
                container.appendChild(nivelSection);
                
                // Agregar categorías a la tabla
                const tbody = nivelSection.querySelector(`#categoria-nivel-${nivelId}`);
                
                categorias.forEach(categoria => {
                    const row = document.createElement('tr');
                    row.className = 'hover:bg-gray-50';
                    row.setAttribute('data-categoria-id', categoria.id);
                    row.setAttribute('data-nivel-id', nivelId);
                    
                    row.innerHTML = `
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            ${categoria.nombre}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            ${categoria.activo ? 
                                '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Activo</span>' : 
                                '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Inactivo</span>'}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex justify-end items-center space-x-2">
                                <button class="text-blue-600 hover:text-blue-900 focus:outline-none btn-toggle-categoria" data-pivot-id="${categoria.pivot_id || ''}" data-activo="${categoria.activo ? 1 : 0}">
                                    ${categoria.activo ? 
                                        '<svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>' : 
                                        '<svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>'}
                                </button>
                                <button class="text-red-600 hover:text-red-900 focus:outline-none btn-eliminar-categoria" data-pivot-id="${categoria.pivot_id || ''}">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    `;
                    
                    tbody.appendChild(row);
                });
            });
            
            // Agregar listeners para eliminar categorías
            document.querySelectorAll('.btn-eliminar-categoria').forEach(btn => {
                btn.addEventListener('click', function() {
                    const pivotId = this.getAttribute('data-pivot-id');
                    if (pivotId) {
                        categoriasPorEliminar.push(pivotId);
                        this.closest('tr').remove();
                    }
                });
            });
            
            // Agregar listeners para activar/desactivar categorías
            document.querySelectorAll('.btn-toggle-categoria').forEach(btn => {
                btn.addEventListener('click', function() {
                    const pivotId = this.getAttribute('data-pivot-id');
                    const estaActivo = this.getAttribute('data-activo') === '1';
                    if (pivotId) {
                        cambiarEstadoCategoria(institucionActualId, pivotId, !estaActivo);
                    }
                });
            });
        }
        
        // Función para cargar las categorías según el nivel seleccionado
        function cargarCategoriasPorNivel(nivelId) {
            const select = document.getElementById('nueva-categoria-id');
            select.innerHTML = '<option value="">Cargando categorías...</option>';
            select.disabled = true;
            
            // Hacer petición a la API de categorías por nivel
            fetch('/api/categorias-por-niveles', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    niveles: [nivelId]
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data[nivelId] && data[nivelId].length > 0) {
                    // Guardar en nuestro objeto global para futuros usos
                    todasCategoriasPorNivel[nivelId] = data[nivelId];
                    
                    // Rellenar el selector
                    rellenarSelectCategorias(select, data[nivelId]);
                } else {
                    select.innerHTML = '<option value="">No hay categorías disponibles para este nivel</option>';
                    select.disabled = true;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                select.innerHTML = '<option value="">Error al cargar categorías</option>';
                select.disabled = true;
            });
        }
        
        // Función para rellenar el select de categorías
        function rellenarSelectCategorias(select, categorias) {
            select.innerHTML = '<option value="">Seleccione una categoría</option>';
            
            categorias.forEach(categoria => {
                const option = document.createElement('option');
                option.value = categoria.id;
                option.textContent = categoria.nombre_categoria || categoria.nombre;
                select.appendChild(option);
            });
            
            select.disabled = false;
        }
        
        // Función para agregar una nueva categoría a la institución
        function agregarNuevaCategoria() {
            const nivelId = document.getElementById('nueva-categoria-nivel').value;
            const categoriaId = document.getElementById('nueva-categoria-id').value;
            const activo = document.getElementById('nueva-categoria-activo').checked;
            
            if (!nivelId || !categoriaId) {
                mostrarNotificacion('Seleccione un nivel educativo y una categoría', 'error');
                return;
            }
            
            // Verificar que la categoría no esté ya añadida
            const yaExiste = document.querySelector(`tr[data-categoria-id="${categoriaId}"][data-nivel-id="${nivelId}"]`);
            if (yaExiste) {
                mostrarNotificacion('Esta categoría ya está asociada a la institución', 'error');
                return;
            }
            
            // Añadir a la lista de categorías por agregar
            categoriasPorAgregar.push({
                nivel_id: nivelId,
                categoria_id: categoriaId,
                activo: activo
            });
            
            // Actualizar la vista
            actualizarVistaCategorias();
            
            // Limpiar formulario
            document.getElementById('form-agregar-categoria').reset();
            document.getElementById('nueva-categoria-id').innerHTML = '<option value="">Seleccione primero un nivel</option>';
            document.getElementById('nueva-categoria-id').disabled = true;
            
            mostrarNotificacion('Categoría añadida. No olvide guardar los cambios.', 'success');
        }
        
        // Función para actualizar la vista de categorías con las nuevas agregadas
        function actualizarVistaCategorias() {
            // Recorremos las categorías por agregar
            categoriasPorAgregar.forEach(categoria => {
                const nivelId = categoria.nivel_id;
                
                // Verificar si ya existe una sección para este nivel
                let seccionNivel = document.querySelector(`#categoria-nivel-${nivelId}`);
                
                if (!seccionNivel) {
                    // Si no existe la sección, crear una nueva
                    const container = document.getElementById('categorias-container');
                    const noCategoriasMsg = document.getElementById('no-categorias');
                    noCategoriasMsg.classList.add('hidden');
                    
                    // Buscar el nombre del nivel
                    let nombreNivel = 'Nivel ' + nivelId;
                    // Buscar en los niveles educativos
                    const nivelesEdu = document.getElementById('nueva-categoria-nivel').options;
                    for (let i = 0; i < nivelesEdu.length; i++) {
                        if (nivelesEdu[i].value == nivelId) {
                            nombreNivel = nivelesEdu[i].textContent;
                            break;
                        }
                    }
                    
                    const nivelSection = document.createElement('div');
                    nivelSection.className = 'mb-6 last:mb-0';
                    nivelSection.innerHTML = `
                        <h5 class="font-medium text-gray-700 mb-2">${nombreNivel}</h5>
                        <div class="border rounded-lg overflow-hidden">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Categoría</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200" id="categoria-nivel-${nivelId}">
                                </tbody>
                            </table>
                        </div>
                    `;
                    
                    container.appendChild(nivelSection);
                    seccionNivel = nivelSection.querySelector(`#categoria-nivel-${nivelId}`);
                }
                
                // Encontrar nombre de la categoría
                let nombreCategoria = 'Categoría ' + categoria.categoria_id;
                
                // Buscar en las categorías disponibles para este nivel
                const categoriasPorNivel = todasCategoriasPorNivel[nivelId];
                if (categoriasPorNivel) {
                    const categoriaObj = categoriasPorNivel.find(c => c.id == categoria.categoria_id);
                    if (categoriaObj) {
                        nombreCategoria = categoriaObj.nombre_categoria;
                    }
                }
                
                // Si no se encontró, buscar en el select de categorías
                if (nombreCategoria === 'Categoría ' + categoria.categoria_id) {
                    const categoriaOptions = document.getElementById('nueva-categoria-id').options;
                    for (let i = 0; i < categoriaOptions.length; i++) {
                        if (categoriaOptions[i].value == categoria.categoria_id) {
                            nombreCategoria = categoriaOptions[i].textContent;
                            break;
                        }
                    }
                }
                
                // Verificar que no exista ya una fila para esta categoría
                const existeRow = seccionNivel.querySelector(`tr[data-categoria-id="${categoria.categoria_id}"]`);
                if (existeRow) {
                    return;
                }
                
                // Crear la fila para la categoría
                const row = document.createElement('tr');
                row.className = 'hover:bg-gray-50 nueva-categoria';
                row.setAttribute('data-categoria-id', categoria.categoria_id);
                row.setAttribute('data-nivel-id', nivelId);
                
                row.innerHTML = `
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        ${nombreCategoria}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        ${categoria.activo ? 
                            '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Activo</span>' : 
                            '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Inactivo</span>'}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <div class="flex justify-end items-center space-x-2">
                            <button class="text-blue-600 hover:text-blue-900 focus:outline-none btn-toggle-nueva-categoria" data-index="${categoriasPorAgregar.length - 1}">
                                ${categoria.activo ? 
                                    '<svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>' : 
                                    '<svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>'}
                            </button>
                            <button class="text-red-600 hover:text-red-900 focus:outline-none btn-cancelar-nueva-categoria">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </div>
                    </td>
                `;
                
                seccionNivel.appendChild(row);
                
                // Añadir listener para eliminar la nueva categoría
                row.querySelector('.btn-cancelar-nueva-categoria').addEventListener('click', function() {
                    // Encontrar el índice de la categoría en el array
                    const index = categoriasPorAgregar.findIndex(c => 
                        c.categoria_id == categoria.categoria_id && c.nivel_id == nivelId);
                    
                    if (index !== -1) {
                        // Eliminar del array
                        categoriasPorAgregar.splice(index, 1);
                        // Eliminar fila
                        row.remove();
                    }
                });
                
                // Añadir listener para activar/desactivar la nueva categoría
                row.querySelector('.btn-toggle-nueva-categoria').addEventListener('click', function() {
                    const index = parseInt(this.getAttribute('data-index'));
                    if (index >= 0 && index < categoriasPorAgregar.length) {
                        // Invertir el estado activo
                        categoriasPorAgregar[index].activo = !categoriasPorAgregar[index].activo;
                        
                        // Actualizar la vista
                        const activo = categoriasPorAgregar[index].activo;
                        const estadoSpan = this.closest('tr').querySelector('td:nth-child(2) span');
                        if (estadoSpan) {
                            if (activo) {
                                estadoSpan.className = 'px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800';
                                estadoSpan.textContent = 'Activo';
                                this.innerHTML = '<svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>';
                            } else {
                                estadoSpan.className = 'px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800';
                                estadoSpan.textContent = 'Inactivo';
                                this.innerHTML = '<svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>';
                            }
                        }
                    }
                });
            });
        }
        
        // Función para guardar los cambios en las categorías
        function guardarCategorias() {
            // Mostrar indicador de carga
            document.getElementById('btn-guardar-categorias').disabled = true;
            document.getElementById('btn-guardar-categorias').innerHTML = `
                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Guardando...
            `;
            
            fetch('{{ route("admin.instituciones.updateCategorias", ["id" => "__ID__"]) }}'.replace('__ID__', institucionActualId), {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    categorias: categoriasPorAgregar,
                    eliminar_categorias: categoriasPorEliminar
                })
            })
            .then(response => response.json())
            .then(data => {
                // Restaurar botón
                document.getElementById('btn-guardar-categorias').disabled = false;
                document.getElementById('btn-guardar-categorias').textContent = 'Guardar Cambios';
                
                if (data.success) {
                    // Mostrar notificación
                    mostrarNotificacion(data.message, 'success');
                    
                    // Limpiar datos temporales
                    categoriasPorAgregar = [];
                    categoriasPorEliminar = [];
                    
                    // Recargar los datos para obtener los IDs de pivot actualizados
                    cargarCategorias(institucionActualId);
                } else {
                    mostrarNotificacion(data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                
                // Restaurar botón
                document.getElementById('btn-guardar-categorias').disabled = false;
                document.getElementById('btn-guardar-categorias').textContent = 'Guardar Cambios';
                
                mostrarNotificacion('Error al guardar los cambios: ' + error.message, 'error');
            });
        }
        
        // Función para mostrar error en el modal de categorías
        function mostrarErrorCategorias(mensaje) {
            document.getElementById('mensaje-cargando-categorias').classList.add('hidden');
            document.getElementById('contenedor-categorias-institucion').classList.add('hidden');
            
            const errorContainer = document.getElementById('error-categorias');
            document.getElementById('error-categorias-mensaje').textContent = mensaje;
            errorContainer.classList.remove('hidden');
        }
        
        // Función para cambiar estado de verificación
        function cambiarVerificacion(id) {
            fetch('{{ route("admin.instituciones.cambiar-verificacion", ["id" => "__ID__"]) }}'.replace('__ID__', id), {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    actualizarTabla();
                    mostrarNotificacion(data.message, 'success');
                } else {
                    mostrarNotificacion(data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                mostrarNotificacion('Error al cambiar estado de verificación', 'error');
            });
        }
        
        // Función para actualizar la tabla
        function actualizarTabla(url = '{{ route("admin.instituciones.index") }}') {
            fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('tabla-instituciones-container').innerHTML = data.tabla;
            })
            .catch(error => {
                console.error('Error:', error);
                mostrarNotificacion('Error al actualizar la tabla', 'error');
            });
        }
        
        // Función para resetear el formulario
        function resetForm() {
            document.getElementById('form-institucion').reset();
            document.getElementById('imagen-actual-container').classList.add('hidden');
            
            // Desmarcar todos los checkboxes de niveles educativos
            document.querySelectorAll('input[name="niveles_educativos[]"]').forEach(checkbox => {
                checkbox.checked = false;
            });
        }
        
        // Función para mostrar notificaciones
        function mostrarNotificacion(mensaje, tipo) {
            // Implementar según el sistema de notificaciones del proyecto
            alert(mensaje);
        }
        
        // Función para cambiar el estado de activación de una categoría
        function cambiarEstadoCategoria(institucionId, categoriaId, nuevoEstado) {
            fetch('{{ route("admin.instituciones.toggleCategoria", ["id" => "__INST_ID__", "categoria" => "__CAT_ID__"]) }}'
                .replace('__INST_ID__', institucionId)
                .replace('__CAT_ID__', categoriaId), {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Actualizar la vista del botón y estado
                    const btn = document.querySelector(`.btn-toggle-categoria[data-pivot-id="${categoriaId}"]`);
                    if (btn) {
                        // Actualizar atributo de estado
                        btn.setAttribute('data-activo', data.activo ? '1' : '0');
                        
                        // Actualizar icono del botón
                        if (data.activo) {
                            btn.innerHTML = '<svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>';
                        } else {
                            btn.innerHTML = '<svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>';
                        }
                        
                        // Actualizar estado en la tabla
                        const estadoSpan = btn.closest('tr').querySelector('td:nth-child(2) span');
                        if (estadoSpan) {
                            if (data.activo) {
                                estadoSpan.className = 'px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800';
                                estadoSpan.textContent = 'Activo';
                            } else {
                                estadoSpan.className = 'px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800';
                                estadoSpan.textContent = 'Inactivo';
                            }
                        }
                    }
                    
                    mostrarNotificacion(data.message, 'success');
                } else {
                    mostrarNotificacion(data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                mostrarNotificacion('Error al cambiar el estado de la categoría', 'error');
            });
        }
    </script>
@endsection 