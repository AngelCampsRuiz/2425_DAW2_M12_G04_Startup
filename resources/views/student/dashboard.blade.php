@extends('layouts.app')

@section('content')
    <head>
        <!-- Incluye FontAwesome desde un CDN -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
        <!-- Incluye noUiSlider desde un CDN -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.7.0/nouislider.min.css" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.7.0/nouislider.min.js"></script>
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>
    <div class="min-h-screen bg-gray-100">
        {{-- BREADCRUMBS --}}
        <div class="bg-white shadow-sm">
            <div class="container mx-auto px-4 py-3">
                <div class="flex items-center text-sm">
                    <a href="{{ route('home') }}" class="text-gray-500 hover:text-[#5e0490]">
                        <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        Inicio
                    </a>
                    <span class="mx-2 text-gray-400">/</span>
                    <span class="text-[#5e0490] font-medium">Ofertas laborales</span>
                </div>
            </div>
        </div>
        
        {{-- CONTENIDO PRINCIPAL --}}
        <div class="container mx-auto px-4 py-8">
            <div class="flex flex-col md:flex-row gap-6">
                {{-- SIDEBAR DE FILTROS --}}
                <div class="w-full md:w-1/4">
                    <div class="bg-white rounded-lg shadow p-6">
                        <h2 class="text-lg font-semibold text-gray-800 mb-4">Filtros</h2>
                        <div class="space-y-4">
                            <!-- Filtro de Categoría y Subcategoría -->
                            <div>
                                <h3 class="text-sm font-medium text-gray-600 mb-2">Categoría</h3>
                                <div class="space-y-2">
                                    @foreach($categorias as $categoria)
                                        <div>
                                            <label class="flex items-center">
                                                <input type="checkbox" name="categoria[]" value="{{ $categoria->id }}" class="categoria-checkbox form-checkbox h-4 w-4 text-[#5e0490] rounded focus:ring-[#5e0490] border-gray-300">
                                                <span class="ml-2 text-sm text-gray-700">{{ $categoria->nombre_categoria }}</span>
                                            </label>
                                            <div id="subcategorias-{{ $categoria->id }}" class="pl-6 mt-2 hidden">
                                                @foreach($categoria->subcategorias as $subcategoria)
                                                    <label class="flex items-center">
                                                        <input type="checkbox" name="subcategoria[]" value="{{ $subcategoria->id }}" class="form-checkbox h-4 w-4 text-[#5e0490] rounded focus:ring-[#5e0490] border-gray-300">
                                                        <span class="ml-2 text-sm text-gray-700">{{ $subcategoria->nombre_subcategoria }}</span>
                                                    </label>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Filtro de Fecha de Publicación -->
                            <div>
                                <h3 class="text-sm font-medium text-gray-600 mb-2">Fecha de Publicación</h3>
                                <div class="flex space-x-4">
                                    <input type="date" name="fecha_inicio" id="fechaInicio" class="w-1/2 border-gray-300 rounded-lg shadow-sm focus:ring-[#5e0490] focus:border-[#5e0490]">
                                    <input type="date" name="fecha_fin" id="fechaFin" class="w-1/2 border-gray-300 rounded-lg shadow-sm focus:ring-[#5e0490] focus:border-[#5e0490]">
                                </div>
                            </div>

                            <!-- Filtro de Horario -->
                            <div>
                                <h3 class="text-sm font-medium text-gray-600 mb-2">Horario</h3>
                                <div class="space-y-2">
                                    @foreach($horarios as $horario)
                                        <label class="flex items-center">
                                            <input type="checkbox" name="horario[]" value="{{ $horario }}" class="form-checkbox h-4 w-4 text-[#5e0490] rounded focus:ring-[#5e0490] border-gray-300">
                                            <span class="ml-2 text-sm text-gray-700">{{ ucfirst($horario) }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Filtro de Horas Totales -->
                            <div>
                                <h3 class="text-sm font-medium text-gray-600 mb-2">Horas Totales</h3>
                                <div class="mb-6">
                                    <div class="flex justify-between text-sm text-gray-600 mb-2">
                                        <span id="horasTotalesMinValue">{{ $horasTotalesMin }}</span>
                                        <span id="horasTotalesMaxValue">{{ $horasTotalesMax }}</span>
                                    </div>
                                    <!-- Contenedor para noUiSlider -->
                                    <div id="horasTotalesSlider" class="mt-4"></div>
                                    <!-- Campos ocultos para enviar los valores en el formulario -->
                                    <input type="hidden" id="horasTotalesMin" name="horas_totales_min" value="{{ $horasTotalesMin }}">
                                    <input type="hidden" id="horasTotalesMax" name="horas_totales_max" value="{{ $horasTotalesMax }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- CONTENIDO PRINCIPAL --}}
                <div class="w-full md:w-3/4">
                    {{-- BARRA DE BÚSQUEDA Y ORDENAMIENTO --}}
                    <div class="flex flex-col md:flex-row gap-4 mb-6">
                        <div class="flex-1">
                            <form id="searchForm" class="flex gap-4 items-center" data-route="{{ route('student.dashboard') }}">
                                <div class="relative flex-1">
                                    <input type="text" name="search" id="searchInput" value="{{ request('search') }}" 
                                    placeholder="Buscar publicaciones..."
                                        class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary focus:outline-none transition duration-200">
                                    <svg class="absolute left-3 top-2.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                    </svg>
                                </div>
                                <input type="hidden" name="order_by" id="orderBy" value="{{ request('order_by', 'fecha_publicacion') }}">
                                <input type="hidden" name="order_direction" id="orderDirection" value="{{ request('order_direction', 'desc') }}">
                                <button type="button" id="clearButton" class="flex items-center justify-center px-4 py-2 bg-[#5e0490] text-white rounded-lg hover:bg-[#4a0370] transition duration-200">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                        <div class="w-full md:w-48">
                            <div class="relative">
                                <select id="orderSelect" class="w-full pl-3 pr-10 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary focus:outline-none appearance-none transition duration-200">
                                <option value="{{ route('student.dashboard', ['order_by' => 'fecha_publicacion', 'order_direction' => 'desc']) }}"
                                    {{ request('order_by') == 'fecha_publicacion' && request('order_direction') == 'desc' ? 'selected' : '' }}>
                                    Más recientes
                                </option>
                                <option value="{{ route('student.dashboard', ['order_by' => 'fecha_publicacion', 'order_direction' => 'asc']) }}"
                                    {{ request('order_by') == 'fecha_publicacion' && request('order_direction') == 'asc' ? 'selected' : '' }}>
                                    Más antiguos
                                </option>
                                <option value="{{ route('student.dashboard', ['order_by' => 'horas_totales', 'order_direction' => 'desc']) }}"
                                    {{ request('order_by') == 'horas_totales' && request('order_direction') == 'desc' ? 'selected' : '' }}>
                                    Mayor duración
                                </option>
                                <option value="{{ route('student.dashboard', ['order_by' => 'horas_totales', 'order_direction' => 'asc']) }}"
                                    {{ request('order_by') == 'horas_totales' && request('order_direction') == 'asc' ? 'selected' : '' }}>
                                    Menor duración
                                </option>
                            </select>
                                <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- GRID DE PUBLICACIONES --}}
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        @foreach($publications as $publication)
                            <div class="bg-white rounded-lg shadow overflow-hidden relative">
                                <div class="flex">
                                    {{-- IMAGEN DE LA EMPRESA --}}
                                    <div class="w-1/3 relative" style="aspect-ratio: 1/1;">
                                        <img src="{{ $publication->empresa->logo_url ?? asset('assets/images/company-default.png') }}" 
                                            alt="{{ $publication->empresa->nombre }}"
                                            class="absolute inset-0 w-full h-full object-cover">
                                    </div>
                                    {{-- INFORMACIÓN DE LA PUBLICACIÓN --}}
                                    <div class="w-2/3 p-4">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <a href="{{ route('publication.show', $publication->id) }}" class="hover:text-[#5e0490] transition-colors">
                                                    <h3 class="text-lg font-semibold text-gray-900">{{ $publication->titulo }}</h3>
                                                </a>
                                                <p class="text-sm text-gray-500">{{ $publication->empresa->nombre }}</p>
                                            </div>
                                        </div>
                                        <div class="flex items-center text-sm text-gray-600 mb-2">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            {{ ucfirst($publication->horario) }}
                                        </div>
                                        <div class="flex items-center text-sm text-gray-600 mb-3">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            {{ $publication->horas_totales }} horas totales
                                        </div>
                                        <p class="text-sm text-gray-600 line-clamp-2">{{ $publication->descripcion }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- PAGINACIÓN --}}
                    <div class="mt-8 flex justify-center">
                        <div class="pagination-container">
                            {{ $publications->onEachSide(1)->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Estilos para noUiSlider */
        .noUi-connect {
            background: #5e0490 !important;
        }
        
        .noUi-handle {
            border-radius: 50% !important;
            background-color: #5e0490 !important;
            border: 2px solid #fff !important;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2) !important;
            width: 20px !important;
            height: 20px !important;
            right: -10px !important;
            top: -7px !important;
            cursor: pointer !important;
            transition: transform 0.2s ease, box-shadow 0.2s ease !important;
        }
        
        .noUi-handle:hover {
            transform: scale(1.1);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3) !important;
        }
        
        .noUi-handle:active {
            transform: scale(1.2);
        }
        
        .noUi-handle:before, .noUi-handle:after {
            display: none !important;
        }
        
        .noUi-target {
            border-radius: 4px !important;
            border: none !important;
            background-color: #e2e8f0 !important;
            box-shadow: none !important;
            height: 8px !important;
        }
        
        .noUi-horizontal {
            height: 8px !important;
        }
        
        .noUi-tooltip {
            display: none !important;
        }

        /* Texto de los valores mínimo y máximo */
        .flex.justify-between.text-sm.text-gray-600 {
            margin-top: 8px; /* Espacio entre el slider y los valores */
        }
        
        /* Estilos para la paginación */
        .pagination-container nav {
            display: flex;
            justify-content: center;
        }
        
        .pagination-container .flex.justify-between.flex-1 {
            display: none; /* Ocultar el texto de paginación */
        }
        
        .pagination-container .relative.inline-flex.items-center {
            padding: 0.5rem 1rem;
            margin: 0 0.25rem;
            border-radius: 0.375rem;
            font-weight: 500;
            font-size: 0.875rem;
            color: #4b5563;
            background-color: #ffffff;
            border: 1px solid #d1d5db;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            transition: all 0.2s;
        }
        
        .pagination-container .relative.inline-flex.items-center:hover {
            background-color: #f3f4f6;
            color: #111827;
        }
        
        .pagination-container .relative.z-0.inline-flex.shadow-sm {
            border-radius: 0.375rem;
            overflow: hidden;
        }
        
        .pagination-container span[aria-current="page"] .relative.inline-flex.items-center {
            background-color: #5e0490;
            color: white;
            border-color: #5e0490;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Inicializar el slider de rango para horas totales
            const horasTotalesSlider = document.getElementById('horasTotalesSlider');
            const horasTotalesMin = document.getElementById('horasTotalesMin');
            const horasTotalesMax = document.getElementById('horasTotalesMax');
            const horasTotalesMinValue = document.getElementById('horasTotalesMinValue');
            const horasTotalesMaxValue = document.getElementById('horasTotalesMaxValue');
            
            if (horasTotalesSlider) {
                const minValue = parseInt(horasTotalesMin.value);
                const maxValue = parseInt(horasTotalesMax.value);
                
                noUiSlider.create(horasTotalesSlider, {
                    start: [minValue, maxValue],
                    connect: true,
                    step: 1,
                    range: {
                        'min': minValue,
                        'max': maxValue
                    }
                });
                
                // Actualizar los valores mostrados y los campos ocultos
                horasTotalesSlider.noUiSlider.on('update', function(values, handle) {
                    const value = Math.round(values[handle]);
                    if (handle === 0) {
                        horasTotalesMinValue.textContent = value;
                        horasTotalesMin.value = value;
                    } else {
                        horasTotalesMaxValue.textContent = value;
                        horasTotalesMax.value = value;
                    }
                });
                
                // Ejecutar la búsqueda cuando el usuario suelta el control deslizante
                horasTotalesSlider.noUiSlider.on('change', function() {
                    fetchPublications();
                });
            }
            
            // Resto del código de dashboard.js
            let debounceTimer;
            const searchForm = document.getElementById('searchForm');
            const searchInput = document.getElementById('searchInput');
            const orderBy = document.getElementById('orderBy');
            const orderDirection = document.getElementById('orderDirection');
            const orderSelect = document.getElementById('orderSelect');
            const clearButton = document.getElementById('clearButton');
            const horarioCheckboxes = document.querySelectorAll('input[name="horario[]"]');
            const categoriaCheckboxes = document.querySelectorAll('.categoria-checkbox');
            const subcategoriaCheckboxes = document.querySelectorAll('input[name="subcategoria[]"]');
            const fechaInicio = document.getElementById('fechaInicio');
            const fechaFin = document.getElementById('fechaFin');
            const route = searchForm ? searchForm.getAttribute('data-route') : '';
            const favoriteButtons = document.querySelectorAll('.favorite-button');
            const favoritosCheckbox = document.getElementById('favoritosCheckbox');

            // Mostrar/ocultar subcategorías al seleccionar una categoría
            categoriaCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const subcategoriasDiv = document.getElementById(`subcategorias-${this.value}`);
                    if (this.checked) {
                        subcategoriasDiv.classList.remove('hidden');
                    } else {
                        subcategoriasDiv.classList.add('hidden');
                    }
                    fetchPublications();
                });
            });

            const fetchPublications = () => {
                if (!searchForm) return;
                
                const searchTerm = searchInput.value;
                const orderByValue = orderBy.value;
                const orderDirectionValue = orderDirection.value;
                const selectedHorarios = Array.from(horarioCheckboxes)
                    .filter(checkbox => checkbox.checked)
                    .map(checkbox => checkbox.value);
                const selectedCategorias = Array.from(categoriaCheckboxes)
                    .filter(checkbox => checkbox.checked)
                    .map(checkbox => checkbox.value);
                const selectedSubcategorias = Array.from(document.querySelectorAll('input[name="subcategoria[]"]'))
                    .filter(checkbox => checkbox.checked)
                    .map(checkbox => checkbox.value);
                const fechaInicioValue = fechaInicio.value;
                const fechaFinValue = fechaFin.value;
                const horasTotalesMinValue = horasTotalesMin.value;
                const horasTotalesMaxValue = horasTotalesMax.value;
                const favoritosValue = favoritosCheckbox && favoritosCheckbox.checked ? 'on' : 'off';

                const params = new URLSearchParams();
                if (searchTerm) params.append('search', searchTerm);
                if (orderByValue) params.append('order_by', orderByValue);
                if (orderDirectionValue) params.append('order_direction', orderDirectionValue);
                selectedHorarios.forEach(horario => params.append('horario[]', horario));
                selectedCategorias.forEach(categoria => params.append('categoria[]', categoria));
                selectedSubcategorias.forEach(subcategoria => params.append('subcategoria[]', subcategoria));
                if (fechaInicioValue) params.append('fecha_inicio', fechaInicioValue);
                if (fechaFinValue) params.append('fecha_fin', fechaFinValue);
                params.append('horas_totales_min', horasTotalesMinValue);
                params.append('horas_totales_max', horasTotalesMaxValue);
                params.append('favoritos', favoritosValue);

                fetch(`${route}?${params.toString()}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const newContent = doc.querySelector('.grid');
                    if (newContent) {
                        document.querySelector('.grid').innerHTML = newContent.innerHTML;
                    }
                    
                    // Reinicializar los botones de favoritos después de actualizar el contenido
                    initFavoriteButtons();
                });
            };

            searchInput && searchInput.addEventListener('input', function() {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(fetchPublications, 300);
            });

            orderSelect && orderSelect.addEventListener('change', function(event) {
                const url = new URL(event.target.value);
                orderBy.value = url.searchParams.get('order_by');
                orderDirection.value = url.searchParams.get('order_direction');
                fetchPublications();
            });

            clearButton && clearButton.addEventListener('click', function() {
                searchInput.value = '';
                orderBy.value = 'fecha_publicacion';
                orderDirection.value = 'desc';
                orderSelect.value = `${route}?order_by=fecha_publicacion&order_direction=desc`;
                horarioCheckboxes.forEach(checkbox => checkbox.checked = false);
                categoriaCheckboxes.forEach(checkbox => {
                    checkbox.checked = false;
                    const categoriaId = checkbox.value;
                    const subcategoriasDiv = document.getElementById(`subcategorias-${categoriaId}`);
                    if (subcategoriasDiv) {
                        subcategoriasDiv.classList.add('hidden');
                        subcategoriasDiv.querySelectorAll('input[type="checkbox"]').forEach(subCheckbox => {
                            subCheckbox.checked = false;
                        });
                    }
                });
                fechaInicio.value = '';
                fechaFin.value = '';
                
                // Resetear el slider de rango
                if (horasTotalesSlider && horasTotalesSlider.noUiSlider) {
                    const minValue = parseInt(horasTotalesSlider.noUiSlider.options.range.min);
                    const maxValue = parseInt(horasTotalesSlider.noUiSlider.options.range.max);
                    horasTotalesSlider.noUiSlider.set([minValue, maxValue]);
                }
                
                fetchPublications();
            });

            horarioCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', fetchPublications);
            });

            subcategoriaCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', fetchPublications);
            });

            fechaInicio && fechaInicio.addEventListener('change', fetchPublications);
            fechaFin && fechaFin.addEventListener('change', fetchPublications);

            favoritosCheckbox && favoritosCheckbox.addEventListener('change', fetchPublications);

            // Función para inicializar los botones de favoritos
            function initFavoriteButtons() {
                const favoriteButtons = document.querySelectorAll('.favorite-button');
                favoriteButtons.forEach(button => {
                    // Eliminar eventos anteriores para evitar duplicados
                    const newButton = button.cloneNode(true);
                    button.parentNode.replaceChild(newButton, button);
                    
                    newButton.addEventListener('click', function() {
                        const publicationId = this.dataset.publicationId;
                        const icon = this.querySelector('i');
                        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                        fetch(`/toggle-favorite/${publicationId}`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken,
                                'Content-Type': 'application/json'
                            }
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.status === 'added') {
                                icon.classList.remove('far');
                                icon.classList.add('fas', 'text-yellow-500');
                            } else {
                                icon.classList.remove('fas', 'text-yellow-500');
                                icon.classList.add('far');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                    });
                });
            }

            // Inicializar los botones de favoritos al cargar la página
            initFavoriteButtons();
        });
    </script>
@endsection
