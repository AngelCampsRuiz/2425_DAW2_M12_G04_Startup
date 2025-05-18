<!-- Encabezado y botón crear -->
<div class="flex justify-between items-center p-6 border-b">
    <h1 class="text-2xl font-semibold text-gray-800">Empresas</h1>
    <button class="btn-crear bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
        Crear Empresa
    </button>
</div>

<!-- Instrucciones de depuración -->
<div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-4 hidden" id="debug-instruction">
  <p class="font-bold">Instrucciones para depuración</p>
  <p>Si el botón de eliminar normal no funciona, utiliza el botón "Eliminar SQL" (icono de base de datos) para forzar la eliminación directa.</p>
</div>

<!-- Vista de tabla para pantallas medianas y grandes -->
<div class="hidden md:block">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">CIF</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ciudad</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Teléfono</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($empresas as $empresa)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <div class="flex items-center">
                                @if($empresa->user->imagen)
                                    <img class="h-10 w-10 rounded-full object-cover mr-3" src="{{ asset('profile_images/' . $empresa->user->imagen) }}" alt="{{ $empresa->user->nombre }}">
                                @else
                                    <div class="h-10 w-10 rounded-full bg-purple-100 flex items-center justify-center mr-3">
                                        <span class="text-purple-800 font-medium text-sm">{{ strtoupper(substr($empresa->user->nombre ?? 'NA', 0, 2)) }}</span>
                                    </div>
                                @endif
                                <div class="text-sm font-medium text-gray-900">{{ $empresa->user->nombre ?? 'Sin nombre' }}</div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $empresa->user->email ?? 'Sin email' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $empresa->cif }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $empresa->user->ciudad ?? 'No especificado' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $empresa->user->telefono ?? 'No especificado' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-3">
                                <button class="btn-editar text-indigo-600 hover:text-indigo-900" data-id="{{ $empresa->id }}">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </button>
                                <button class="btn-eliminar text-red-600 hover:text-red-900" data-id="{{ $empresa->id }}">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                            No hay empresas disponibles
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-6 py-4 border-t border-gray-200">
        {{ $empresas->links() }}
    </div>
</div>

<!-- Vista de tarjetas para móviles -->
<div class="md:hidden space-y-4">
    @forelse ($empresas as $empresa)
        <div class="bg-white shadow rounded-lg p-4">
            <div class="flex items-center space-x-4">
                <div class="flex-shrink-0">
                    @if($empresa->user->imagen)
                        <img class="h-12 w-12 rounded-full object-cover" src="{{ asset('profile_images/' . $empresa->user->imagen) }}" alt="{{ $empresa->user->nombre }}">
                    @else
                        <div class="h-12 w-12 rounded-full bg-purple-100 flex items-center justify-center">
                            <span class="text-purple-800 font-medium text-sm">{{ strtoupper(substr($empresa->user->nombre ?? 'NA', 0, 2)) }}</span>
                        </div>
                    @endif
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900 truncate">
                        {{ $empresa->user->nombre ?? 'Sin nombre' }}
                    </p>
                    <p class="text-sm text-gray-500 truncate">
                        {{ $empresa->user->email ?? 'Sin email' }}
                    </p>
                    <p class="text-sm text-gray-500 truncate">
                        CIF: {{ $empresa->cif }}
                    </p>
                    <p class="text-sm text-gray-500 truncate">
                        {{ $empresa->user->ciudad ?? 'No especificado' }}
                    </p>
                </div>
                <div class="flex space-x-2">
                    <button class="btn-editar text-indigo-600 hover:text-indigo-900" data-id="{{ $empresa->id }}">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </button>
                    <button class="btn-eliminar text-red-600 hover:text-red-900" data-id="{{ $empresa->id }}">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    @empty
        <div class="bg-white shadow rounded-lg p-4 text-center text-gray-500">
            No hay empresas disponibles
        </div>
    @endforelse
    <div class="mt-4">
        {{ $empresas->links() }}
    </div>
</div> 