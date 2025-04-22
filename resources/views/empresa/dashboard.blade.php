{{-- HEADER --}}
@extends('layouts.app')

{{-- CONTENIDO --}}
@section('content')
<div class="bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <div class="flex flex-col md:flex-row gap-6">
            <!-- Sidebar -->
            <div class="w-full md:w-1/4">
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <div class="flex items-center space-x-4 mb-6">
                        @if(Auth::user()->empresa->logo_url)
                            <img src="{{ Auth::user()->empresa->logo_url }}" alt="Logo empresa" class="w-16 h-16 rounded-full object-cover">
                        @else
                            <div class="w-16 h-16 rounded-full bg-purple-200 flex items-center justify-center text-purple-700 text-xl font-bold">
                                {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                            </div>
                        @endif
                        <div>
                            <h2 class="text-lg font-bold">{{ Auth::user()->name }}</h2>
                            <p class="text-gray-600">Empresa</p>
                        </div>
                    </div>
                    <div class="border-t pt-4">
                        <p class="text-gray-600 mb-2">CIF: <span class="font-medium">{{ Auth::user()->empresa->cif ?? 'No especificado' }}</span></p>
                        <p class="text-gray-600 mb-2">Sector: <span class="font-medium">{{ Auth::user()->empresa->sector ?? 'No especificado' }}</span></p>
                        <p class="text-gray-600">Estado: <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs font-medium">Activa</span></p>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="font-bold text-lg mb-4 text-gray-800">Menú</h3>
                    <nav>
                        <ul class="space-y-2">
                            <li><a href="{{ route('empresa.dashboard') }}" class="block p-2 {{ Route::currentRouteName() == 'empresa.dashboard' ? 'bg-purple-100 text-purple-700' : 'text-gray-600 hover:bg-gray-100' }} rounded font-medium">Dashboard</a></li>
                            <li><a href="{{ route('profile') }}" class="block p-2 {{ Route::currentRouteName() == 'profile' ? 'bg-purple-100 text-purple-700' : 'text-gray-600 hover:bg-gray-100' }} rounded">Perfil de empresa</a></li>
                            <li><a href="{{ route('empresa.offers.create') }}" class="block p-2 {{ Route::currentRouteName() == 'empresa.offers.create' ? 'bg-purple-100 text-purple-700' : 'text-gray-600 hover:bg-gray-100' }} rounded">Publicar oferta</a></li>
                            <li><a href="#" class="block p-2 text-gray-600 hover:bg-gray-100 rounded">Candidatos</a></li>
                            <li><a href="#" class="block p-2 text-gray-600 hover:bg-gray-100 rounded">Mensajes</a></li>
                        </ul>
                    </nav>
                </div>
            </div>

            <!-- Main Content -->
            <div class="w-full md:w-3/4">
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h1 class="text-2xl font-bold text-gray-800 mb-6">Panel de empresa</h1>
                    
                    <!-- Estadísticas -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                        <div class="bg-purple-50 p-4 rounded-lg">
                            <h3 class="font-medium text-purple-800 mb-1">Ofertas activas</h3>
                            <p class="text-2xl font-bold text-purple-900">{{ $activePublications->count() }}</p>
                        </div>
                        <div class="bg-green-50 p-4 rounded-lg">
                            <h3 class="font-medium text-green-800 mb-1">Total solicitudes</h3>
                            <p class="text-2xl font-bold text-green-900">{{ $activePublications->sum('solicitudes_count') + $inactivePublications->sum('solicitudes_count') }}</p>
                        </div>
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <h3 class="font-medium text-blue-800 mb-1">Solicitudes pendientes</h3>
                            <p class="text-2xl font-bold text-blue-900">{{ $activePublications->sum('solicitudes_count') }}</p>
                        </div>
                        <div class="bg-yellow-50 p-4 rounded-lg">
                            <h3 class="font-medium text-yellow-800 mb-1">Ofertas inactivas</h3>
                            <p class="text-2xl font-bold text-yellow-900">{{ $inactivePublications->count() }}</p>
                        </div>
                    </div>

                    <!-- Ofertas Activas -->
                    <div class="mb-8">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-xl font-bold text-gray-800">Ofertas Activas</h2>
                            <a href="{{ route('empresa.offers.create') }}" class="text-purple-600 hover:text-purple-800 text-sm font-medium">Publicar nueva →</a>
                        </div>
                        
                        @if($activePublications->isEmpty())
                            <div class="text-center py-12 bg-gray-50 rounded-lg">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">No hay ofertas activas</h3>
                                <p class="mt-1 text-sm text-gray-500">Comienza publicando tu primera oferta de prácticas.</p>
                                <div class="mt-6">
                                    <a href="{{ route('empresa.offers.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-purple-600 hover:bg-purple-700">
                                        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                        </svg>
                                        Nueva oferta
                                    </a>
                                </div>
                            </div>
                        @else
                            <div class="border rounded-lg overflow-hidden">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Título</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Horario</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Solicitudes</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($activePublications as $publication)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm font-medium text-gray-900">{{ $publication->titulo }}</div>
                                                    <div class="text-sm text-gray-500">{{ Str::limit($publication->descripcion, 50) }}</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm text-gray-900">{{ ucfirst($publication->horario) }}</div>
                                                    <div class="text-sm text-gray-500">{{ $publication->horas_totales }} horas</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                        Activa
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $publication->solicitudes_count }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                    <a href="{{ route('empresa.applications.view', $publication->id) }}" class="text-purple-600 hover:text-purple-900 mr-3">Ver solicitudes</a>
                                                    <form action="{{ route('empresa.offers.toggle', $publication->id) }}" method="POST" class="inline">
                                                        @csrf
                                                        <button type="submit" class="text-red-600 hover:text-red-900">Desactivar</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>

                    <!-- Ofertas Inactivas -->
                    <div>
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-xl font-bold text-gray-800">Ofertas Inactivas</h2>
                        </div>
                        
                        @if($inactivePublications->isEmpty())
                            <p class="text-center py-4 text-gray-500">No hay ofertas inactivas.</p>
                        @else
                            <div class="border rounded-lg overflow-hidden">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Título</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Horario</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Solicitudes</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($inactivePublications as $publication)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm font-medium text-gray-900">{{ $publication->titulo }}</div>
                                                    <div class="text-sm text-gray-500">{{ Str::limit($publication->descripcion, 50) }}</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm text-gray-900">{{ ucfirst($publication->horario) }}</div>
                                                    <div class="text-sm text-gray-500">{{ $publication->horas_totales }} horas</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                        Inactiva
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $publication->solicitudes_count }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                    <a href="{{ route('empresa.applications.view', $publication->id) }}" class="text-purple-600 hover:text-purple-900 mr-3">Ver solicitudes</a>
                                                    <form action="{{ route('empresa.offers.toggle', $publication->id) }}" method="POST" class="inline">
                                                        @csrf
                                                        <button type="submit" class="text-purple-600 hover:text-purple-900">Activar</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Nueva Oferta -->
<div id="modalNuevaOferta" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full" style="z-index: 100;">
    <div class="relative top-20 mx-auto p-5 border w-full max-w-2xl shadow-lg rounded-md bg-white">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-bold text-gray-900">Publicar Nueva Oferta</h3>
            <button onclick="closeModal()" class="text-gray-400 hover:text-gray-500">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <form id="formNuevaOferta" class="space-y-6">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="col-span-2">
                    <label for="titulo" class="block text-sm font-medium text-gray-700">Título de la oferta *</label>
                    <input type="text" name="titulo" id="titulo" required
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                </div>

                <div class="col-span-2">
                    <label for="descripcion" class="block text-sm font-medium text-gray-700">Descripción *</label>
                    <textarea name="descripcion" id="descripcion" rows="4" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500"></textarea>
                </div>

                <div>
                    <label for="horario" class="block text-sm font-medium text-gray-700">Horario *</label>
                    <select name="horario" id="horario" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                        <option value="">Seleccionar horario</option>
                        <option value="mañana">Mañana</option>
                        <option value="tarde">Tarde</option>
                    </select>
                </div>

                <div>
                    <label for="horas_totales" class="block text-sm font-medium text-gray-700">Horas totales *</label>
                    <input type="number" name="horas_totales" id="horas_totales" min="100" max="400" required
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                </div>

                <div>
                    <label for="categoria_id" class="block text-sm font-medium text-gray-700">Categoría *</label>
                    <select name="categoria_id" id="categoria_id" required onchange="cargarSubcategorias()"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                        <option value="">Seleccionar categoría</option>
                        @foreach($categorias as $categoria)
                            <option value="{{ $categoria->id }}">{{ $categoria->nombre_categoria }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="subcategoria_id" class="block text-sm font-medium text-gray-700">Subcategoría *</label>
                    <select name="subcategoria_id" id="subcategoria_id" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                        <option value="">Primero seleccione una categoría</option>
                    </select>
                </div>
            </div>

            <div class="flex justify-end space-x-3 pt-4 border-t">
                <button type="button" onclick="closeModal()"
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                    Cancelar
                </button>
                <button type="submit"
                        class="px-4 py-2 text-sm font-medium text-white bg-purple-600 border border-transparent rounded-md hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                    Publicar oferta
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Sweet Alert y Scripts -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-material-ui@5/material-ui.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Verificar que estamos en la página correcta antes de ejecutar el script
    if (document.querySelector('#modalNuevaOferta')) {
        document.addEventListener('DOMContentLoaded', function() {
            // Modificar los enlaces/botones que abren el modal (una sola vez)
            document.querySelectorAll('[href="{{ route('empresa.offers.create') }}"]').forEach(element => {
                element.setAttribute('onclick', 'openModal(); return false;');
                element.removeAttribute('href');
            });

            // Configuración para el modal
            const modalNuevaOferta = document.getElementById('modalNuevaOferta');
            const formNuevaOferta = document.getElementById('formNuevaOferta');
            
            // Función para abrir el modal
            window.openModal = function() {
                if (modalNuevaOferta) {
                    modalNuevaOferta.classList.remove('hidden');
                }
            };
            
            // Función para cerrar el modal
            window.closeModal = function() {
                if (modalNuevaOferta) {
                    modalNuevaOferta.classList.add('hidden');
                }
                if (formNuevaOferta) {
                    formNuevaOferta.reset();
                    delete formNuevaOferta.dataset.processing;
                }
            };
            
            // Cerrar modal al hacer clic fuera (una sola vez)
            if (modalNuevaOferta) {
                modalNuevaOferta.addEventListener('click', function(e) {
                    if (e.target === this) {
                        closeModal();
                    }
                });
            }
            
            // Función para cargar subcategorías
            window.cargarSubcategorias = function() {
                const categoriaId = document.getElementById('categoria_id');
                if (!categoriaId) return;
                
                const subcategoriasSelect = document.getElementById('subcategoria_id');
                if (!subcategoriasSelect) return;
                
                if (!categoriaId.value) {
                    subcategoriasSelect.innerHTML = '<option value="">Primero seleccione una categoría</option>';
                    return;
                }
                
                subcategoriasSelect.innerHTML = '<option value="">Cargando subcategorías...</option>';
                subcategoriasSelect.disabled = true;
                
                const baseUrl = '{{ url('/') }}';
                const url = `${baseUrl}/empresa/get-subcategorias/${categoriaId.value}`;
                
                fetch(url, {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    credentials: 'same-origin'
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(response => {
                    if (response.error) {
                        throw new Error(response.message);
                    }

                    subcategoriasSelect.innerHTML = '<option value="">Seleccionar subcategoría</option>';
                    
                    const subcategorias = response.data || [];
                    if (subcategorias.length === 0) {
                        subcategoriasSelect.innerHTML = '<option value="">No hay subcategorías disponibles</option>';
                        return;
                    }

                    // Usar un Set para evitar duplicados
                    const addedIds = new Set();
                    
                    subcategorias.forEach(subcategoria => {
                        if (!addedIds.has(subcategoria.id)) {
                            addedIds.add(subcategoria.id);
                            subcategoriasSelect.innerHTML += `
                                <option value="${subcategoria.id}">${subcategoria.nombre_subcategoria}</option>
                            `;
                        }
                    });
                })
                .catch(error => {
                    console.error('Error al cargar subcategorías:', error);
                    if (window.Swal) {
                        Swal.fire({
                            title: '¡Error!',
                            text: 'No se pudieron cargar las subcategorías: ' + error.message,
                            icon: 'error',
                            confirmButtonText: 'Entendido',
                            confirmButtonColor: '#5e0490'
                        });
                    }
                    subcategoriasSelect.innerHTML = '<option value="">Error al cargar subcategorías</option>';
                })
                .finally(() => {
                    subcategoriasSelect.disabled = false;
                });
            };
            
            // Manejar envío del formulario (una sola vez)
            if (formNuevaOferta) {
                const requestsInProgress = new Set();
                
                formNuevaOferta.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    // Verificar si el formulario ya está siendo procesado
                    if (this.dataset.processing === 'true') {
                        console.log('Formulario ya está siendo procesado, ignorando envío duplicado');
                        return false;
                    }
                    
                    // Verificar si hay una solicitud idéntica en progreso usando datos del formulario como identificador
                    const formData = new FormData(this);
                    const requestId = Array.from(formData.entries())
                        .map(([key, value]) => `${key}=${value}`)
                        .join('&');
                        
                    if (requestsInProgress.has(requestId)) {
                        console.log('Solicitud idéntica ya en progreso, ignorando');
                        return false;
                    }
                    
                    // Marcar el formulario como en procesamiento
                    this.dataset.processing = 'true';
                    requestsInProgress.add(requestId);
                    
                    // Deshabilitar el botón de submit
                    const submitButton = this.querySelector('button[type="submit"]');
                    if (submitButton) {
                        submitButton.disabled = true;
                        submitButton.innerHTML = 'Publicando...';
                    }
                    
                    // Datos para el seguimiento de la petición
                    const uniqueId = Date.now().toString();
                    console.log(`[${uniqueId}] Iniciando envío del formulario`);
                    
                    fetch('{{ route('empresa.offers.store') }}', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'X-Request-ID': uniqueId,
                            'X-Request-Unique': requestId
                        }
                    })
                    .then(response => {
                        console.log(`[${uniqueId}] Respuesta recibida, status: ${response.status}`);
                        
                        if (!response.ok) {
                            throw new Error(`Error en la respuesta del servidor: ${response.status}`);
                        }
                        
                        const contentType = response.headers.get('content-type');
                        if (contentType && contentType.includes('application/json')) {
                            return response.json().then(data => {
                                console.log(`[${uniqueId}] Datos JSON recibidos:`, data);
                                
                                if (data.success) {
                                    if (window.Swal) {
                                        Swal.fire({
                                            title: '¡Éxito!',
                                            text: data.message || 'Oferta creada exitosamente',
                                            icon: 'success',
                                            confirmButtonText: 'Continuar',
                                            confirmButtonColor: '#5e0490'
                                        }).then(() => {
                                            window.location.reload();
                                        });
                                    } else {
                                        alert(data.message || 'Oferta creada exitosamente');
                                        window.location.reload();
                                    }
                                } else {
                                    throw new Error(data.message || 'Error al crear la oferta');
                                }
                            });
                        } else {
                            console.log(`[${uniqueId}] Respuesta no es JSON, recargando página`);
                            window.location.reload();
                        }
                    })
                    .catch(error => {
                        console.error(`[${uniqueId}] Error:`, error);
                        
                        if (window.Swal) {
                            Swal.fire({
                                title: '¡Error!',
                                text: error.message || 'Ha ocurrido un error al publicar la oferta',
                                icon: 'error',
                                confirmButtonText: 'Entendido',
                                confirmButtonColor: '#5e0490'
                            });
                        } else {
                            alert(error.message || 'Ha ocurrido un error al publicar la oferta');
                        }
                    })
                    .finally(() => {
                        console.log(`[${uniqueId}] Finalizada la petición`);
                        
                        // Eliminar la solicitud del conjunto de solicitudes en progreso
                        requestsInProgress.delete(requestId);
                        
                        // Restablecer el estado del botón y formulario después de 2 segundos
                        setTimeout(() => {
                            delete this.dataset.processing;
                            
                            if (submitButton) {
                                submitButton.disabled = false;
                                submitButton.innerHTML = 'Publicar oferta';
                            }
                        }, 2000);
                    });
                });
            }
        });
    }
</script>
@endsection

