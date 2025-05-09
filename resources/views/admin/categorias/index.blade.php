@extends('admin.dashboard')

@section('admin_content')
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
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
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div class="relative">
                <label for="filtro_nombre" class="block text-sm font-medium text-purple-700 mb-2">Nombre de la categoría</label>
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
                <label for="filtro_subcategorias" class="block text-sm font-medium text-purple-700 mb-2">Número de subcategorías</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                        </svg>
                    </div>
                    <select id="filtro_subcategorias" class="pl-10 w-full rounded-lg border-purple-200 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50 appearance-none bg-white">
                        <option value="">Todas</option>
                        <option value="0">Sin subcategorías</option>
                        <option value="1">Con subcategorías</option>
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

    <div class="flex justify-between items-center mb-4">
        <div class="text-sm text-gray-600">
            Mostrando {{ $categorias->count() }} categorías de {{ $categorias->total() }}
        </div>
        <button onclick="openCreateModal()" class="bg-purple-600 text-white px-4 py-2 rounded-md hover:bg-purple-700 transition-colors duration-200">
            Nueva Categoría
        </button>
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
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
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
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
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
        let timeoutId = null;

        // Eventos para filtrado automático
        document.getElementById('filtro_nombre').addEventListener('input', debounceFilter);
        document.getElementById('filtro_subcategorias').addEventListener('change', aplicarFiltros);
        
        // Resetear filtros
        document.getElementById('reset-filtros').addEventListener('click', function() {
            document.getElementById('filtro_nombre').value = '';
            document.getElementById('filtro_subcategorias').value = '';
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
                subcategorias: document.getElementById('filtro_subcategorias').value
            };
            
            const params = new URLSearchParams();
            Object.entries(filtros).forEach(([key, value]) => {
                if (value) {
                    params.append(key, value);
                }
            });
            
            refreshTable(params.toString());
        }

        function refreshTable(queryString = '') {
            const url = queryString 
                ? `/admin/categorias?${queryString}`
                : '/admin/categorias';

            fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
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

        function showSuccessMessage(message) {
            const messageDiv = document.createElement('div');
            messageDiv.className = 'bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4';
            messageDiv.textContent = message;

            const container = document.querySelector('#tabla-container').parentNode;
            container.insertBefore(messageDiv, container.firstChild);

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
    </script>
@endsection 