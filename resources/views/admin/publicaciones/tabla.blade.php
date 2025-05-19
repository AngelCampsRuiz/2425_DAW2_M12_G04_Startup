<!-- Encabezado y botón crear -->
<div class="flex justify-between items-center p-6 border-b">
    <h1 class="text-2xl font-semibold text-gray-800">Ofertas</h1>
    <button class="btn-crear bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
        Crear Oferta
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
        <table class="min-w-full divide-y divide-gray-200 table-fixed">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-12">ID</th>
                    <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/5">Título</th>
                    <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/6">Empresa</th>
                    <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/6">Categoría</th>
                    <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-24">Horario</th>
                    <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-16">Horas</th>
                    <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-16">Estado</th>
                    <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-24">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($publicaciones as $publicacion)
                    <tr>
                        <td class="px-3 py-3 whitespace-nowrap text-sm text-gray-500">{{ $publicacion->id }}</td>
                        <td class="px-3 py-3">
                            <div class="text-sm font-medium text-gray-900 truncate" title="{{ $publicacion->titulo }}">{{ $publicacion->titulo }}</div>
                            <div class="text-xs text-gray-500">{{ date('d/m/Y', strtotime($publicacion->fecha_publicacion)) }}</div>
                        </td>
                        <td class="px-3 py-3 whitespace-nowrap">
                            @if($publicacion->empresa_id && $publicacion->empresa && $publicacion->empresa->user)
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ $publicacion->empresa->user->nombre }}
                                </span>
                            @else
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    Sin empresa
                                </span>
                            @endif
                        </td>
                        <td class="px-3 py-3">
                            <div class="text-xs text-gray-500 truncate" title="{{ $publicacion->categoria->nombre_categoria ?? 'N/A' }}">{{ $publicacion->categoria->nombre_categoria ?? 'N/A' }}</div>
                            <div class="text-xs">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-purple-100 text-purple-800 truncate" title="{{ $publicacion->subcategoria->nombre_subcategoria ?? 'N/A' }}">
                                    {{ $publicacion->subcategoria->nombre_subcategoria ?? 'N/A' }}
                                </span>
                            </div>
                        </td>
                        <td class="px-3 py-3 whitespace-nowrap text-sm text-gray-500">
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                {{ ucfirst($publicacion->horario) }}
                            </span>
                        </td>
                        <td class="px-3 py-3 whitespace-nowrap text-sm text-gray-500">{{ $publicacion->horas_totales }}</td>
                        <td class="px-3 py-3 whitespace-nowrap">
                            @if($publicacion->activa)
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Activa
                                </span>
                            @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                    Inactiva
                                </span>
                            @endif
                        </td>
                        <td class="px-3 py-3 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <button type="button" class="btn-editar text-indigo-600 hover:text-indigo-900" data-id="{{ $publicacion->id }}">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </button>
                                <button type="button" class="btn-activar {{ $publicacion->activa ? 'text-red-600 hover:text-red-900' : 'text-green-600 hover:text-green-900' }}" data-id="{{ $publicacion->id }}" data-active="{{ $publicacion->activa ? '1' : '0' }}">
                                    @if($publicacion->activa)
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    @else
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    @endif
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-3 py-3 whitespace-nowrap text-sm text-gray-500 text-center">
                            No hay ofertas disponibles
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-6 py-4 border-t border-gray-200">
        {{ $publicaciones->links() }}
    </div>
</div>

<!-- Vista móvil -->
<div class="md:hidden space-y-4">
    @forelse ($publicaciones as $publicacion)
        <div class="bg-white shadow rounded-lg p-4">
            <div class="flex items-center space-x-4">
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900">
                        {{ $publicacion->titulo }}
                    </p>
                    <div class="flex flex-wrap gap-1 mt-1">
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                            {{ $publicacion->empresa->user->nombre ?? 'Sin empresa' }}
                        </span>
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-purple-100 text-purple-800">
                            {{ $publicacion->categoria->nombre_categoria ?? 'N/A' }}
                        </span>
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                            {{ ucfirst($publicacion->horario) }} | {{ $publicacion->horas_totales }}h
                        </span>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">
                        {{ date('d/m/Y', strtotime($publicacion->fecha_publicacion)) }}
                    </p>
                    <div class="mt-1">
                        @if($publicacion->activa)
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                Activa
                            </span>
                        @else
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                Inactiva
                            </span>
                        @endif
                    </div>
                </div>
                <div class="flex space-x-2">
                    <button type="button" class="btn-editar text-indigo-600 hover:text-indigo-900" data-id="{{ $publicacion->id }}">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </button>
                    <button type="button" class="btn-activar {{ $publicacion->activa ? 'text-red-600 hover:text-red-900' : 'text-green-600 hover:text-green-900' }}" data-id="{{ $publicacion->id }}" data-active="{{ $publicacion->activa ? '1' : '0' }}">
                        @if($publicacion->activa)
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        @else
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        @endif
                    </button>
                </div>
            </div>
        </div>
    @empty
        <div class="bg-white shadow rounded-lg p-4 text-center text-gray-500">
            No hay ofertas disponibles
        </div>
    @endforelse
    <div class="mt-4">
        {{ $publicaciones->links() }}
    </div>
</div> 