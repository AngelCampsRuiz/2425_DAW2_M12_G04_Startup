<!-- Encabezado y botón crear -->
<div class="flex justify-between items-center p-6 border-b">
    <h1 class="text-2xl font-semibold text-gray-800">Categorías</h1>
    <button onclick="openCreateModal()" class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
        Crear Categoría
    </button>
</div>

<!-- Tabla para pantallas medianas y grandes -->
<div class="hidden md:block">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subcategorías</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($categorias as $categoria)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $categoria->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $categoria->nombre_categoria }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex flex-wrap gap-1">
                                @foreach ($categoria->subcategorias as $subcategoria)
                                    <span class="inline-block bg-purple-100 text-purple-800 text-xs px-2 py-1 rounded">
                                        {{ $subcategoria->nombre_subcategoria }}
                                    </span>
                                @endforeach
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-3">
                                <button onclick="openEditModal({{ $categoria->id }})" class="text-indigo-600 hover:text-indigo-900">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </button>
                                <button onclick="openDeleteModal({{ $categoria->id }})" class="text-red-600 hover:text-red-900">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                            No hay categorías registradas
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-6 py-4 border-t border-gray-200">
        {{ $categorias->links() }}
    </div>
</div>

<!-- Vista móvil -->
<div class="md:hidden space-y-4">
    @forelse($categorias as $categoria)
        <div class="bg-white shadow rounded-lg p-4">
            <div class="flex items-center space-x-4">
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900">
                        {{ $categoria->nombre_categoria }}
                    </p>
                    <div class="mt-2 flex flex-wrap gap-1">
                        @foreach ($categoria->subcategorias as $subcategoria)
                            <span class="inline-block bg-purple-100 text-purple-800 text-xs px-2 py-1 rounded">
                                {{ $subcategoria->nombre_subcategoria }}
                            </span>
                        @endforeach
                    </div>
                </div>
                <div class="flex space-x-2">
                    <button onclick="openEditModal({{ $categoria->id }})" class="text-indigo-600 hover:text-indigo-900">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </button>
                    <button onclick="openDeleteModal({{ $categoria->id }})" class="text-red-600 hover:text-red-900">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    @empty
        <div class="bg-white shadow rounded-lg p-4 text-center text-gray-500">
            No hay categorías registradas
        </div>
    @endforelse
    <div class="mt-4">
        {{ $categorias->links() }}
    </div>
</div> 