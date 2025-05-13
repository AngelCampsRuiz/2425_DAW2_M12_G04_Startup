<!-- Encabezado sin botón crear -->
<div class="flex justify-between items-center p-6 border-b">
    <h1 class="text-2xl font-semibold text-gray-800">Empresas</h1>
</div>

<!-- Instrucciones de depuración -->
<div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-4 hidden" id="debug-instruction">
  <p class="font-bold">Instrucciones para depuración</p>
  <p>Si el botón de eliminar normal no funciona, utiliza el botón "Eliminar SQL" (icono de base de datos) para forzar la eliminación directa.</p>
</div>

<!-- Vista de tabla para escritorio -->
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
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($empresas as $empresa)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <!-- Logo de la empresa -->
                                @if($empresa->user->imagen)
                                    <div class="flex-shrink-0 h-10 w-10 mr-3">
                                        <img class="h-10 w-10 rounded-full object-cover" 
                                             src="{{ asset('public/profile_images/' . $empresa->user->imagen) }}" 
                                             alt="Logo de {{ $empresa->user->nombre }}"
                                             onerror="this.onerror=null; this.src='{{ asset('img/default-logo.png') }}';">
                                    </div>
                                @else
                                    <div class="flex-shrink-0 h-10 w-10 bg-purple-100 rounded-full flex items-center justify-center mr-3">
                                        <span class="text-purple-800 font-medium">{{ substr($empresa->user->nombre, 0, 2) }}</span>
                                    </div>
                                @endif
                                <div>
                                    <div class="text-sm font-medium text-gray-900">{{ $empresa->nombre_comercial ?? $empresa->user->nombre }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-500">{{ $empresa->user->email }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-500">{{ $empresa->cif }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-500">{{ $empresa->user->ciudad ?: 'No especificado' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-500">{{ $empresa->user->telefono }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $empresa->user->activo ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $empresa->user->activo ? 'Activa' : 'Inactiva' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium flex space-x-2">
                            <button class="btn-editar text-indigo-600 hover:text-indigo-900" data-id="{{ $empresa->id }}">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </button>
                            <button class="btn-activar {{ $empresa->user->activo ? 'text-red-600 hover:text-red-900' : 'text-green-600 hover:text-green-900' }}" 
                                    data-id="{{ $empresa->id }}" 
                                    data-active="{{ $empresa->user->activo ? '1' : '0' }}">
                                @if($empresa->user->activo)
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                @else
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                @endif
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                            No hay empresas para mostrar
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
        <div class="bg-white rounded-lg shadow mb-4 p-4">
            <div class="flex justify-between items-center border-b pb-2 mb-2">
                <div class="flex items-center">
                    @if($empresa->user->imagen)
                        <div class="flex-shrink-0 h-10 w-10 mr-3">
                            <img class="h-10 w-10 rounded-full object-cover" 
                                 src="{{ asset('public/profile_images/' . $empresa->user->imagen) }}" 
                                 alt="Logo de {{ $empresa->user->nombre }}"
                                 onerror="this.onerror=null; this.src='{{ asset('img/default-logo.png') }}';">
                        </div>
                    @else
                        <div class="flex-shrink-0 h-10 w-10 bg-purple-100 rounded-full flex items-center justify-center mr-3">
                            <span class="text-purple-800 font-medium">{{ substr($empresa->user->nombre, 0, 2) }}</span>
                        </div>
                    @endif
                    <div class="font-semibold text-lg">{{ $empresa->nombre_comercial ?? $empresa->user->nombre }}</div>
                </div>
                <div class="flex space-x-1">
                    <button class="btn-editar text-indigo-600 hover:text-indigo-900 bg-indigo-100 p-2 rounded-full" data-id="{{ $empresa->id }}">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                    </button>
                    <button class="btn-activar {{ $empresa->user->activo ? 'text-red-600 hover:text-red-900 bg-red-100' : 'text-green-600 hover:text-green-900 bg-green-100' }} p-2 rounded-full" 
                            data-id="{{ $empresa->id }}" 
                            data-active="{{ $empresa->user->activo ? '1' : '0' }}">
                        @if($empresa->user->activo)
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        @else
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        @endif
                    </button>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-2 text-sm">
                <div>
                    <span class="font-medium text-gray-500">Email:</span>
                    <p class="text-gray-800">{{ $empresa->user->email }}</p>
                </div>
                <div>
                    <span class="font-medium text-gray-500">CIF:</span>
                    <p class="text-gray-800">{{ $empresa->cif }}</p>
                </div>
                <div>
                    <span class="font-medium text-gray-500">Ciudad:</span>
                    <p class="text-gray-800">{{ $empresa->user->ciudad ?: 'No especificado' }}</p>
                </div>
                <div>
                    <span class="font-medium text-gray-500">Teléfono:</span>
                    <p class="text-gray-800">{{ $empresa->user->telefono }}</p>
                </div>
                <div>
                    <span class="font-medium text-gray-500">Estado:</span>
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $empresa->user->activo ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $empresa->user->activo ? 'Activa' : 'Inactiva' }}
                    </span>
                </div>
            </div>
        </div>
    @empty
        <div class="text-center py-4 text-gray-500">
            No hay empresas para mostrar
        </div>
    @endforelse
    <div class="mt-4">
        {{ $empresas->links() }}
    </div>
</div> 