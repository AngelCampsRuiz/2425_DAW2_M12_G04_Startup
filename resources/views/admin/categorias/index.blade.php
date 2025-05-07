@extends('admin.dashboard')

@section('admin_content')
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex justify-between items-center mb-4">
        <div class="text-sm text-gray-600">
            Mostrando {{ $categorias->count() }} categorías de {{ $categorias->total() }}
        </div>
    </div>

    <div id="tabla-container">
        @include('admin.categorias.tabla')
    </div>

    <!-- Modal para Crear/Editar Categoría -->
    <div id="categoriaModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg p-8 max-w-md w-full">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-semibold" id="modalTitle">Nueva Categoría</h3>
                <button onclick="closeModal()" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <form id="categoriaForm" onsubmit="handleSubmit(event)">
                @csrf
                <input type="hidden" name="_method" value="POST" id="method">
                <input type="hidden" name="categoria_id" id="categoria_id">

                <div class="mb-4">
                    <label for="nombre_categoria" class="block text-gray-700 font-medium mb-2">Nombre de la Categoría</label>
                    <input type="text" name="nombre_categoria" id="nombre_categoria" class="w-full border-gray-300 rounded-md shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200" required>
                </div>

                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeModal()" class="px-4 py-2 text-gray-600 bg-gray-100 rounded-md hover:bg-gray-200">
                        Cancelar
                    </button>
                    <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700">
                        Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal de Confirmación de Eliminación -->
    <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg p-8 max-w-md w-full">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-semibold text-gray-800">Confirmar Eliminación</h3>
                <button onclick="closeDeleteModal()" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <p class="text-gray-600 mb-6">¿Estás seguro de que deseas eliminar esta categoría? Esta acción no se puede deshacer.</p>

            <form id="deleteForm" onsubmit="handleDelete(event)">
                @csrf
                @method('DELETE')
                <input type="hidden" name="delete_id" id="delete_id">

                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeDeleteModal()" class="px-4 py-2 text-gray-600 bg-gray-100 rounded-md hover:bg-gray-200">
                        Cancelar
                    </button>
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                        Eliminar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let currentPage = 1;

        function showSuccessMessage(message) {
            // Crear el elemento del mensaje
            const messageDiv = document.createElement('div');
            messageDiv.className = 'bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4';
            messageDiv.textContent = message;

            // Insertar el mensaje al principio del contenedor principal
            const container = document.querySelector('#tabla-container').parentNode;
            container.insertBefore(messageDiv, container.firstChild);

            // Eliminar el mensaje después de 3 segundos
            setTimeout(() => {
                messageDiv.remove();
            }, 3000);
        }

        function openCreateModal() {
            document.getElementById('modalTitle').textContent = 'Nueva Categoría';
            document.getElementById('categoriaForm').reset();
            document.getElementById('method').value = 'POST';
            document.getElementById('categoria_id').value = '';
            document.getElementById('categoriaModal').classList.remove('hidden');
            document.getElementById('categoriaModal').classList.add('flex');
        }

        function openEditModal(id) {
            fetch(`/admin/categorias/${id}/edit`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('modalTitle').textContent = 'Editar Categoría';
                document.getElementById('nombre_categoria').value = data.categoria.nombre_categoria;
                document.getElementById('method').value = 'PUT';
                document.getElementById('categoria_id').value = data.categoria.id;
                document.getElementById('categoriaModal').classList.remove('hidden');
                document.getElementById('categoriaModal').classList.add('flex');
            });
        }

        function closeModal() {
            document.getElementById('categoriaModal').classList.remove('flex');
            document.getElementById('categoriaModal').classList.add('hidden');
            document.getElementById('categoriaForm').reset();
        }

        function openDeleteModal(id) {
            document.getElementById('delete_id').value = id;
            document.getElementById('deleteModal').classList.remove('hidden');
            document.getElementById('deleteModal').classList.add('flex');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.remove('flex');
            document.getElementById('deleteModal').classList.add('hidden');
        }

        function handleSubmit(event) {
            event.preventDefault();
            const form = event.target;
            const formData = new FormData(form);
            const method = document.getElementById('method').value;
            const id = document.getElementById('categoria_id').value;

            const url = method === 'PUT' 
                ? `/admin/categorias/${id}`
                : '/admin/categorias';

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
                    closeModal();
                    refreshTable();
                    showSuccessMessage(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Ha ocurrido un error al procesar la solicitud');
            });
        }

        function handleDelete(event) {
            event.preventDefault();
            const id = document.getElementById('delete_id').value;

            fetch(`/admin/categorias/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    closeDeleteModal();
                    refreshTable();
                    showSuccessMessage(data.message);
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Ha ocurrido un error al eliminar la categoría');
            });
        }

        function refreshTable() {
            fetch(`/admin/categorias?page=${currentPage}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('tabla-container').innerHTML = data.tabla;
                setupPagination();
            });
        }

        function setupPagination() {
            document.querySelectorAll('.pagination a').forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const page = this.href.split('page=')[1];
                    currentPage = page;
                    refreshTable();
                });
            });
        }

        // Configurar la paginación inicial
        document.addEventListener('DOMContentLoaded', function() {
            setupPagination();
        });
    </script>
@endsection 