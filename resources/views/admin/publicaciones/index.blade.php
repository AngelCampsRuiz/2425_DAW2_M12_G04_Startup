@extends('admin.dashboard')

@section('admin_content')
    <!-- Mensaje de éxito -->
    <div id="success-message" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert" style="display: none;">
        <span id="success-message-text" class="block sm:inline"></span>
    </div>
    
    <!-- Contenedor de la tabla -->
    <div id="tabla-container" class="bg-white rounded-lg shadow overflow-hidden">
        @include('admin.publicaciones.tabla')
    </div>

    <!-- Modal Crear/Editar Publicación -->
    <div id="modal-publicacion" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-lg shadow-xl max-w-4xl w-full max-h-screen overflow-y-auto p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 id="modal-titulo" class="text-xl font-semibold">Crear Nueva Publicación</h2>
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
                                <option value="{{ $empresa->id }}">{{ $empresa->nombre }}</option>
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
                                <option value="{{ $categoria->id }}">{{ $categoria->nombre_categoria }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div>
                        <label for="subcategoria_id" class="block text-sm font-medium text-gray-700 mb-1">Subcategoría</label>
                        <select name="subcategoria_id" id="subcategoria_id" 
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50"
                                required>
                            <option value="">Selecciona una subcategoría</option>
                            @foreach($subcategorias as $subcategoria)
                                <option value="{{ $subcategoria->id }}">{{ $subcategoria->nombre_subcategoria }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div>
                        <label for="horario" class="block text-sm font-medium text-gray-700 mb-1">Horario</label>
                        <select name="horario" id="horario" 
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50"
                                required>
                            <option value="mañana">Mañana</option>
                            <option value="tarde">Tarde</option>
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
            
            <p class="mb-6">¿Estás seguro de que deseas eliminar esta publicación? Esta acción no se puede deshacer.</p>
            
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
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Usamos delegación de eventos para manejar los clicks en el contenedor
        const tablaContainer = document.getElementById('tabla-container');
        
        // Listener delegado para el botón de crear
        tablaContainer.addEventListener('click', function(e) {
            const btnCrear = e.target.closest('.btn-crear');
            if (btnCrear) {
                resetForm();
                document.getElementById('modal-titulo').textContent = 'Crear Nueva Publicación';
                document.getElementById('form-publicacion').setAttribute('action', '{{ route('admin.publicaciones.store') }}');
                document.getElementById('form_method').value = 'POST';
                document.getElementById('modal-publicacion').classList.remove('hidden');
            }
            
            // Listener delegado para el botón de editar
            const btnEditar = e.target.closest('.btn-editar');
            if (btnEditar) {
                const id = btnEditar.getAttribute('data-id');
                cargarPublicacion(id);
            }
            
            // Listener delegado para el botón de eliminar
            const btnEliminar = e.target.closest('.btn-eliminar');
            if (btnEliminar) {
                const id = btnEliminar.getAttribute('data-id');
                document.getElementById('eliminar_id').value = id;
                document.getElementById('form-eliminar').setAttribute('action', '{{ route('admin.publicaciones.index') }}/' + id);
                document.getElementById('modal-eliminar').classList.remove('hidden');
            }
            
            // Manejo de enlaces de paginación
            const paginationLink = e.target.closest('.pagination-link');
            if (paginationLink) {
                e.preventDefault();
                const url = paginationLink.getAttribute('href');
                cargarPagina(url);
            }
        });
        
        // Cerrar modales
        document.getElementById('modal-close').addEventListener('click', function() {
            document.getElementById('modal-publicacion').classList.add('hidden');
        });
        
        document.getElementById('btn-cancelar').addEventListener('click', function() {
            document.getElementById('modal-publicacion').classList.add('hidden');
        });
        
        document.getElementById('modal-eliminar-close').addEventListener('click', function() {
            document.getElementById('modal-eliminar').classList.add('hidden');
        });
        
        document.getElementById('btn-cancelar-eliminar').addEventListener('click', function() {
            document.getElementById('modal-eliminar').classList.add('hidden');
        });
        
        // Envío del formulario de crear/editar
        document.getElementById('form-publicacion').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const url = this.getAttribute('action');
            const method = document.getElementById('form_method').value;
            
            fetch(url, {
                method: method === 'PUT' ? 'POST' : 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('modal-publicacion').classList.add('hidden');
                    mostrarMensajeExito(data.message);
                    actualizarTabla();
                } else if (data.errors) {
                    mostrarErrores(data.errors);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
        
        // Envío del formulario de eliminar
        document.getElementById('form-eliminar').addEventListener('submit', function(e) {
            e.preventDefault();
            
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
                    actualizarTabla();
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
        
        // Funciones auxiliares
        function resetForm() {
            document.getElementById('form-publicacion').reset();
            document.getElementById('publicacion_id').value = '';
            document.getElementById('fecha_publicacion').value = new Date().toISOString().split('T')[0];
            document.getElementById('form-errors').classList.add('hidden');
            document.getElementById('error-list').innerHTML = '';
        }
        
        function cargarPublicacion(id) {
            fetch('{{ route('admin.publicaciones.index') }}/' + id + '/edit', {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                resetForm();
                
                const publicacion = data.publicacion;
                
                document.getElementById('publicacion_id').value = publicacion.id;
                document.getElementById('titulo').value = publicacion.titulo;
                document.getElementById('descripcion').value = publicacion.descripcion;
                document.getElementById('horario').value = publicacion.horario;
                document.getElementById('horas_totales').value = publicacion.horas_totales;
                document.getElementById('fecha_publicacion').value = publicacion.fecha_publicacion.split(' ')[0];
                document.getElementById('activa').checked = publicacion.activa == 1;
                document.getElementById('empresa_id').value = publicacion.empresa_id;
                document.getElementById('categoria_id').value = publicacion.categoria_id;
                document.getElementById('subcategoria_id').value = publicacion.subcategoria_id;
                
                document.getElementById('modal-titulo').textContent = 'Editar Publicación';
                document.getElementById('form-publicacion').setAttribute('action', '{{ route('admin.publicaciones.index') }}/' + id);
                document.getElementById('form_method').value = 'PUT';
                
                document.getElementById('modal-publicacion').classList.remove('hidden');
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
        
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
            }
            
            errorsDiv.classList.remove('hidden');
        }
        
        function actualizarTabla(url = '{{ route('admin.publicaciones.index') }}') {
            fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('tabla-container').innerHTML = data.tabla;
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
        
        function cargarPagina(url) {
            actualizarTabla(url);
        }
    });
</script>
@endpush 