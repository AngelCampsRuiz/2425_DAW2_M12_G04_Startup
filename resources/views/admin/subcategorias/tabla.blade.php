<!-- Tabla para pantallas medianas y grandes -->
<div class="hidden md:block">
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Categoría</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($subcategorias as $subcategoria)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $subcategoria->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $subcategoria->nombre_subcategoria }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                {{ $subcategoria->categoria->nombre_categoria }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <button class="btn-editar text-indigo-600 hover:text-indigo-900 mr-3" data-id="{{ $subcategoria->id }}">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn-eliminar text-red-600 hover:text-red-900" data-id="{{ $subcategoria->id }}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">
                            No hay subcategorías registradas
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Vista de tarjetas para móviles -->
<div class="md:hidden space-y-4">
    @forelse($subcategorias as $subcategoria)
        <div class="bg-white rounded-lg shadow-md p-4">
            <div class="flex justify-between items-start">
                <div>
                    <h3 class="text-lg font-medium text-gray-900">{{ $subcategoria->nombre_subcategoria }}</h3>
                    <p class="text-sm text-gray-500 mt-1">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                            {{ $subcategoria->categoria->nombre_categoria }}
                        </span>
                    </p>
                </div>
                <div class="flex space-x-2">
                    <button class="btn-editar text-indigo-600 hover:text-indigo-900" data-id="{{ $subcategoria->id }}">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="btn-eliminar text-red-600 hover:text-red-900" data-id="{{ $subcategoria->id }}">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        </div>
    @empty
        <div class="bg-white rounded-lg shadow-md p-4 text-center text-gray-500">
            No hay subcategorías registradas
        </div>
    @endforelse
</div>

<!-- Paginación -->
<div class="mt-4">
    {{ $subcategorias->links() }}
</div> 