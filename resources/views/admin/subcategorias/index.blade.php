@extends('admin.dashboard')

@section('admin_content')
<div class="container mx-auto px-4 py-6">
    <!-- Mensaje de éxito -->
    <div id="success-message" class="hidden fixed top-4 right-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
        <span id="success-message-text"></span>
    </div>

    <!-- Botón de crear -->
    <div class="flex justify-end mb-4">
        <button class="btn-crear bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">
            <i class="fas fa-plus mr-2"></i>Nueva Subcategoría
        </button>
    </div>

    <!-- Contenedor de la tabla -->
    <div id="tabla-container">
        @include('admin.subcategorias.tabla')
    </div>

    <!-- Modal de subcategoría -->
    <div id="modal-subcategoria" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 id="modal-titulo" class="text-lg leading-6 font-medium text-gray-900 mb-4"></h3>
                
                <!-- Formulario -->
                <form id="form-subcategoria" class="space-y-4">
                    @csrf
                    <input type="hidden" id="form_method" name="_method" value="POST">
                    <input type="hidden" id="subcategoria_id" name="id">
                    
                    <div>
                        <label for="nombre_subcategoria" class="block text-sm font-medium text-gray-700">Nombre de la Subcategoría</label>
                        <input type="text" name="nombre_subcategoria" id="nombre_subcategoria" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
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
                    <div id="form-errors" class="hidden bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                        <ul id="error-list"></ul>
                    </div>
                    
                    <!-- Botones -->
                    <div class="flex justify-end space-x-3">
                        <button type="button" id="btn-cancelar" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
                            Cancelar
                        </button>
                        <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">
                            Guardar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal de confirmación de eliminación -->
    <div id="modal-eliminar" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Confirmar Eliminación</h3>
                <p class="text-sm text-gray-500">¿Estás seguro de que deseas eliminar esta subcategoría?</p>
                
                <form id="form-eliminar" method="POST">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" id="eliminar_id" name="id">
                    
                    <div class="flex justify-end space-x-3 mt-4">
                        <button type="button" id="btn-cancelar-eliminar" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
                            Cancelar
                        </button>
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                            Eliminar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Script para manejar los eventos -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Delegación de eventos para todos los botones y formularios
    document.addEventListener('click', function(e) {
        // Botón de crear
        if (e.target.closest('.btn-crear')) {
            resetForm();
            document.getElementById('modal-titulo').textContent = 'Crear Nueva Subcategoría';
            document.getElementById('form-subcategoria').setAttribute('action', '{{ route('admin.subcategorias.store') }}');
            document.getElementById('form_method').value = 'POST';
            document.getElementById('modal-subcategoria').classList.remove('hidden');
        }
        
        // Botón de editar
        if (e.target.closest('.btn-editar')) {
            const id = e.target.closest('.btn-editar').getAttribute('data-id');
            cargarSubcategoria(id);
        }
        
        // Botón de eliminar
        if (e.target.closest('.btn-eliminar')) {
            const id = e.target.closest('.btn-eliminar').getAttribute('data-id');
            document.getElementById('eliminar_id').value = id;
            document.getElementById('form-eliminar').setAttribute('action', '{{ route('admin.subcategorias.index') }}/' + id);
            document.getElementById('modal-eliminar').classList.remove('hidden');
        }
        
        // Botones de cerrar y cancelar
        if (e.target.closest('#modal-close') || e.target.closest('#btn-cancelar')) {
            document.getElementById('modal-subcategoria').classList.add('hidden');
        }
        
        if (e.target.closest('#modal-eliminar-close') || e.target.closest('#btn-cancelar-eliminar')) {
            document.getElementById('modal-eliminar').classList.add('hidden');
        }
        
        // Enlaces de paginación
        const paginationLink = e.target.closest('.pagination-link');
        if (paginationLink) {
            e.preventDefault();
            const url = paginationLink.getAttribute('href');
            actualizarTabla(url);
        }
    });
    
    // Manejo de envío de formularios
    document.addEventListener('submit', function(e) {
        // Formulario de crear/editar
        if (e.target.id === 'form-subcategoria') {
            e.preventDefault();
            const formData = new FormData(e.target);
            const url = e.target.getAttribute('action');
            const method = document.getElementById('form_method').value;
            
            fetch(url, {
                method: method === 'PUT' ? 'POST' : 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('modal-subcategoria').classList.add('hidden');
                    mostrarMensajeExito(data.message);
                    actualizarTabla();
                } else if (data.errors) {
                    mostrarErrores(data.errors);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
        
        // Formulario de eliminar
        if (e.target.id === 'form-eliminar') {
            e.preventDefault();
            const url = e.target.getAttribute('action');
            
            fetch(url, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
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
        }
    });
    
    // Funciones auxiliares
    function resetForm() {
        document.getElementById('form-subcategoria').reset();
        document.getElementById('subcategoria_id').value = '';
        document.getElementById('form-errors').classList.add('hidden');
        document.getElementById('error-list').innerHTML = '';
    }
    
    function cargarSubcategoria(id) {
        fetch('{{ route('admin.subcategorias.index') }}/' + id + '/edit', {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            resetForm();
            
            const subcategoria = data.subcategoria;
            
            document.getElementById('subcategoria_id').value = subcategoria.id;
            document.getElementById('nombre_subcategoria').value = subcategoria.nombre_subcategoria;
            document.getElementById('categoria_id').value = subcategoria.categoria_id;
            
            document.getElementById('modal-titulo').textContent = 'Editar Subcategoría';
            document.getElementById('form-subcategoria').setAttribute('action', '{{ route('admin.subcategorias.index') }}/' + id);
            document.getElementById('form_method').value = 'PUT';
            
            document.getElementById('modal-subcategoria').classList.remove('hidden');
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
    
    function actualizarTabla(url = '{{ route('admin.subcategorias.index') }}') {
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
});
</script>
@endsection 