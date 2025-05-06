<div class="bg-white rounded-lg mb-4 py-3 px-6 flex justify-between items-center">
    <div>
        <span class="text-sm text-gray-700">Mostrando {{ $publicaciones->count() }} {{ $publicaciones->count() == 1 ? 'publicación' : 'publicaciones' }} de {{ $publicaciones->total() }}</span>
    </div>
    <button type="button" class="btn-crear inline-flex items-center px-4 py-2 bg-green-500 hover:bg-green-600 text-white font-bold rounded">
        AÑADIR
    </button>
</div>

<!-- Instrucciones de depuración -->
<div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-4 hidden" id="debug-instruction">
  <p class="font-bold">Instrucciones para depuración</p>
  <p>Si el botón de eliminar normal no funciona, utiliza el botón "Eliminar SQL" (icono de base de datos) para forzar la eliminación directa.</p>
</div>

<!-- Vista de tabla para pantallas medianas y grandes -->
<div class="hidden md:block">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-200">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">ID</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Título</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Empresa</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Categoría</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Subcategoría</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Horas</th>
                <th class="px-6 py-3 text-center text-xs font-medium text-gray-700 uppercase tracking-wider">ACCIONES</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse ($publicaciones as $publicacion)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $publicacion->id }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $publicacion->titulo }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        @if($publicacion->empresa_id && $publicacion->empresa && $publicacion->empresa->user)
                            <span class="font-medium">{{ $publicacion->empresa->user->nombre }}</span>
                        @else
                            <span class="text-red-500">Sin empresa</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $publicacion->categoria->nombre_categoria ?? 'N/A' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $publicacion->subcategoria->nombre_subcategoria ?? 'N/A' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $publicacion->horas_totales }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                        <div class="flex justify-center space-x-2">
                            <button type="button" class="btn-editar text-blue-600 hover:text-blue-900" data-id="{{ $publicacion->id }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </button>
                            <button type="button" class="btn-eliminar text-red-600 hover:text-red-900" data-id="{{ $publicacion->id }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                        No hay publicaciones disponibles
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Vista de tarjetas para móviles -->
<div class="md:hidden space-y-4">
    @forelse ($publicaciones as $publicacion)
        <div class="bg-white rounded-lg shadow border overflow-hidden">
            <div class="p-4 border-b">
                <div class="flex items-start">
                    <div class="flex-shrink-0 bg-blue-500 rounded-lg h-14 w-14 flex items-center justify-center text-white">
                        {{ strtoupper(substr($publicacion->empresa->user->nombre ?? 'NA', 0, 2)) }}
                    </div>
                    <div class="ml-4 flex-1">
                        <h3 class="text-lg font-bold text-gray-900">{{ $publicacion->titulo }}</h3>
                        <p class="text-sm text-gray-700 uppercase">
                            @if($publicacion->empresa_id && $publicacion->empresa && $publicacion->empresa->user)
                                <span class="font-medium">{{ $publicacion->empresa->user->nombre }}</span>
                            @else
                                <span class="text-red-500">Sin empresa</span>
                            @endif
                        </p>
                        <div class="flex items-center mt-1">
                            <p class="text-sm text-gray-700">
                                {{ strtoupper($publicacion->categoria->nombre_categoria ?? 'N/A') }} | {{ $publicacion->horario === 'mañana' ? 'PRESENCIAL' : 'HÍBRIDO' }} | HACE {{ rand(1, 60) }} MIN
                            </p>
                        </div>
                    </div>
                </div>
                <p class="mt-3 text-sm text-gray-600">
                    {{ \Illuminate\Support\Str::limit($publicacion->descripcion, 100) }}
                </p>
            </div>
            <div class="px-4 py-2 bg-gray-50 flex justify-end">
                <button type="button" class="btn-editar text-blue-600 hover:text-blue-900 mr-4" data-id="{{ $publicacion->id }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                </button>
                <button type="button" class="btn-eliminar text-red-600 hover:text-red-900 mr-4" data-id="{{ $publicacion->id }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </button>
            </div>
        </div>
    @empty
        <div class="bg-white p-4 text-center text-gray-500">
            No hay publicaciones disponibles
        </div>
    @endforelse
</div>

<div class="bg-white px-6 py-4">
    <div class="pagination-links">
        @if($publicaciones->hasPages())
            <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between">
                <div class="flex justify-between flex-1 sm:hidden">
                    @if($publicaciones->onFirstPage())
                        <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-md">
                            Anterior
                        </span>
                    @else
                        <a href="{{ $publicaciones->previousPageUrl() }}" class="pagination-link relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:text-gray-500">
                            Anterior
                        </a>
                    @endif

                    @if($publicaciones->hasMorePages())
                        <a href="{{ $publicaciones->nextPageUrl() }}" class="pagination-link relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:text-gray-500">
                            Siguiente
                        </a>
                    @else
                        <span class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-md">
                            Siguiente
                        </span>
                    @endif
                </div>

                <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm text-gray-700">
                            Mostrando
                            <span class="font-medium">{{ $publicaciones->firstItem() ?? 0 }}</span>
                            a
                            <span class="font-medium">{{ $publicaciones->lastItem() ?? 0 }}</span>
                            de
                            <span class="font-medium">{{ $publicaciones->total() }}</span>
                            resultados
                        </p>
                    </div>

                    <div>
                        <span class="relative z-0 inline-flex shadow-sm rounded-md">
                            @if($publicaciones->onFirstPage())
                                <span class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-l-md">
                                    <span class="sr-only">Anterior</span>
                                    <svg class="h-5 w-5" x-description="Heroicon name: solid/chevron-left" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                </span>
                            @else
                                <a href="{{ $publicaciones->previousPageUrl() }}" class="pagination-link relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-l-md hover:bg-gray-50">
                                    <span class="sr-only">Anterior</span>
                                    <svg class="h-5 w-5" x-description="Heroicon name: solid/chevron-left" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                </a>
                            @endif

                            {{-- Números de página --}}
                            @foreach($publicaciones->getUrlRange(1, $publicaciones->lastPage()) as $page => $url)
                                @if($page == $publicaciones->currentPage())
                                    <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-purple-600 border border-gray-300 cursor-default">
                                        {{ $page }}
                                    </span>
                                @else
                                    <a href="{{ $url }}" class="pagination-link relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 hover:bg-gray-50">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach

                            @if($publicaciones->hasMorePages())
                                <a href="{{ $publicaciones->nextPageUrl() }}" class="pagination-link relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-r-md hover:bg-gray-50">
                                    <span class="sr-only">Siguiente</span>
                                    <svg class="h-5 w-5" x-description="Heroicon name: solid/chevron-right" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                </a>
                            @else
                                <span class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-r-md">
                                    <span class="sr-only">Siguiente</span>
                                    <svg class="h-5 w-5" x-description="Heroicon name: solid/chevron-right" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                </span>
                            @endif
                        </span>
                    </div>
                </div>
            </nav>
        @endif
    </div>
</div> 