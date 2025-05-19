/**
 * Convenios Search Functionality
 * Handles searching and filtering convenios using fetch API
 */

document.addEventListener('DOMContentLoaded', function() {
    // Elements
    const filterInput = document.getElementById('filterConvenios');
    const filterEstado = document.getElementById('filterEstado');
    const ofertasContainer = document.getElementById('ofertasConCandidatos');
    const conveniosTable = document.getElementById('conveniosTable');
    const filterButton = document.getElementById('applyFilters');
    const resetButton = document.getElementById('resetFilters');
    const searchLoader = document.getElementById('searchLoader');
    const searchResults = document.getElementById('searchResults');
    const noResults = document.getElementById('noResultsMessage');

    // Initialize debounce function
    let searchTimeout = null;

    // Search function
    const performSearch = () => {
        // Show loading state
        if (searchLoader) {
            searchLoader.classList.remove('hidden');
        }
        
        if (searchResults) {
            searchResults.classList.add('opacity-50');
        }

        // Clear previous timeout
        if (searchTimeout) {
            clearTimeout(searchTimeout);
        }

        // Set a new timeout to debounce the search
        searchTimeout = setTimeout(() => {
            // Get search parameters
            const searchQuery = filterInput ? filterInput.value.trim() : '';
            const estadoFilter = filterEstado ? filterEstado.value : 'todos';
            
            // Prepare fetch data
            const searchData = {
                query: searchQuery,
                estado: estadoFilter
            };
            
            // Call the API
            fetch('/empresa/convenios/search', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: JSON.stringify(searchData)
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error en la búsqueda');
                }
                return response.json();
            })
            .then(data => {
                // Hide loader
                if (searchLoader) {
                    searchLoader.classList.add('hidden');
                }
                
                if (searchResults) {
                    searchResults.classList.remove('opacity-50');
                }
                
                // Update the DOM with results
                updateResults(data);
            })
            .catch(error => {
                console.error('Error:', error);
                
                // Hide loader
                if (searchLoader) {
                    searchLoader.classList.add('hidden');
                }
                
                if (searchResults) {
                    searchResults.classList.remove('opacity-50');
                }
                
                // Show error message
                if (window.Swal) {
                    Swal.fire({
                        title: 'Error',
                        text: 'Ha ocurrido un error al buscar. Inténtalo de nuevo.',
                        icon: 'error',
                        confirmButtonColor: '#6366f1'
                    });
                }
            });
        }, 500); // 500ms debounce
    };
    
    // Function to update the DOM with search results
    const updateResults = (data) => {
        // If no results found
        if (data.ofertas.length === 0 && data.convenios.length === 0) {
            if (noResults) {
                noResults.classList.remove('hidden');
            }
            if (searchResults) {
                searchResults.classList.add('hidden');
            }
            return;
        }
        
        // If we have results
        if (noResults) {
            noResults.classList.add('hidden');
        }
        if (searchResults) {
            searchResults.classList.remove('hidden');
        }
        
        // Update ofertas section
        if (ofertasContainer) {
            // If we have an updateOfertasHTML function (defined in-page)
            if (typeof updateOfertasHTML === 'function') {
                updateOfertasHTML(data.ofertas);
            } else {
                // Default rendering if function not available
                ofertasContainer.innerHTML = data.ofertas.length > 0 
                    ? renderOfertasHTML(data.ofertas)
                    : '<div class="bg-gray-50 rounded-lg p-8 text-center">' +
                      '<svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">' +
                      '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />' +
                      '</svg>' +
                      '<h3 class="text-lg font-medium text-gray-900 mb-2">No hay ofertas que coincidan con la búsqueda</h3>' +
                      '</div>';
            }
        }
        
        // Update convenios table
        if (conveniosTable) {
            const tbody = conveniosTable.querySelector('tbody');
            if (tbody) {
                if (data.convenios.length > 0) {
                    tbody.innerHTML = renderConveniosHTML(data.convenios);
                } else {
                    tbody.innerHTML = '<tr><td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">No hay convenios que coincidan con la búsqueda.</td></tr>';
                }
            }
        }
        
        // Update counters if they exist
        const ofertasCount = document.getElementById('ofertasCount');
        const conveniosCount = document.getElementById('conveniosCount');
        
        if (ofertasCount) {
            ofertasCount.textContent = data.ofertas.length;
        }
        
        if (conveniosCount) {
            conveniosCount.textContent = data.convenios.length;
        }
        
        // Initialize any tooltips or popovers after DOM update
        initTooltips();
    };
    
    // Helper function to render ofertas HTML
    const renderOfertasHTML = (ofertas) => {
        return ofertas.map(oferta => {
            let candidatosHTML = '';
            
            if (oferta.candidatos_aceptados && oferta.candidatos_aceptados.length > 0) {
                candidatosHTML = oferta.candidatos_aceptados.map(candidato => {
                    const imgHTML = candidato.imagen 
                        ? `<img src="/profile_images/${candidato.imagen}" alt="${candidato.nombre}" class="h-10 w-10 rounded-full object-cover border border-gray-200">`
                        : `<div class="h-10 w-10 rounded-full bg-purple-100 flex items-center justify-center text-purple-700 font-bold text-lg">${candidato.nombre.substring(0, 2)}</div>`;
                    
                    const convenioBtn = candidato.convenio
                        ? `<span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium ${candidato.convenio.estado === 'activo' ? 'bg-green-100 text-green-800' : 'bg-amber-100 text-amber-800'}">
                            Convenio ${candidato.convenio.estado.charAt(0).toUpperCase() + candidato.convenio.estado.slice(1)}
                           </span>
                           <a href="/empresa/convenios/${candidato.convenio.id}" class="inline-flex items-center px-2.5 py-1 border border-gray-300 rounded-md text-xs font-medium text-gray-700 bg-white hover:bg-gray-50">
                            Ver convenio
                           </a>`
                        : `<button onclick="crearConvenio(${oferta.id}, ${candidato.id})" class="inline-flex items-center px-3 py-1 border border-transparent rounded-md shadow-sm text-xs font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Crear Convenio
                           </button>`;
                    
                    return `<div class="py-3 flex justify-between items-center">
                        <div class="flex items-center space-x-3">
                            ${imgHTML}
                            <div>
                                <h5 class="text-sm font-medium text-gray-900">${candidato.nombre}</h5>
                                <p class="text-xs text-gray-500">${candidato.email}</p>
                            </div>
                        </div>
                        <div class="flex space-x-2">
                            ${convenioBtn}
                        </div>
                    </div>`;
                }).join('');
            } else {
                candidatosHTML = `<div class="py-4 text-center text-sm text-gray-500">
                    No hay candidatos aceptados para esta oferta.
                </div>`;
            }
            
            return `<div class="bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition-shadow p-5 mb-6">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900">${oferta.titulo}</h3>
                        <p class="text-sm text-gray-500 mb-2">Publicada el ${new Date(oferta.created_at).toLocaleDateString('es-ES')}</p>
                        
                        <div class="flex flex-wrap gap-2 mb-3">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                ${oferta.categoria ? oferta.categoria.nombre_categoria : 'Sin categoría'}
                            </span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                ${oferta.horario}
                            </span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                ${oferta.horas_totales} horas
                            </span>
                        </div>
                    </div>
                    
                    <div class="flex items-center">
                        <span class="inline-block rounded-full px-3 py-1 text-sm font-medium bg-blue-100 text-blue-800">
                            ${oferta.candidatos_aceptados ? oferta.candidatos_aceptados.length : 0} candidatos aceptados
                        </span>
                    </div>
                </div>
                
                <div class="mt-4 border-t pt-4">
                    <h4 class="text-md font-medium text-gray-800 mb-3">Candidatos Aceptados</h4>
                    
                    <div class="divide-y divide-gray-200">
                        ${candidatosHTML}
                    </div>
                </div>
            </div>`;
        }).join('');
    };
    
    // Helper function to render convenios HTML
    const renderConveniosHTML = (convenios) => {
        return convenios.map(convenio => {
            const imgHTML = convenio.estudiante.imagen 
                ? `<img src="/profile_images/${convenio.estudiante.imagen}" alt="${convenio.estudiante.nombre}" class="h-10 w-10 rounded-full object-cover">`
                : `<div class="h-10 w-10 rounded-full bg-purple-100 flex items-center justify-center text-purple-700 font-bold">
                    ${convenio.estudiante.nombre.substring(0, 2)}
                   </div>`;
                
            const estadoClass = convenio.estado === 'activo' 
                ? 'bg-green-100 text-green-800' 
                : (convenio.estado === 'pendiente' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800');
                
            return `<tr>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-10 w-10">
                            ${imgHTML}
                        </div>
                        <div class="ml-4">
                            <div class="text-sm font-medium text-gray-900">
                                ${convenio.estudiante.nombre}
                            </div>
                            <div class="text-sm text-gray-500">
                                ${convenio.estudiante.email}
                            </div>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-900">${convenio.oferta.titulo}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    ${convenio.fecha_inicio ? new Date(convenio.fecha_inicio).toLocaleDateString('es-ES') : 'Pendiente'}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    ${convenio.fecha_fin ? new Date(convenio.fecha_fin).toLocaleDateString('es-ES') : 'Pendiente'}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${estadoClass}">
                        ${convenio.estado.charAt(0).toUpperCase() + convenio.estado.slice(1)}
                    </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                    <a href="/empresa/convenios/${convenio.id}" class="text-indigo-600 hover:text-indigo-900 mr-3">Ver</a>
                    <a href="/empresa/convenios/${convenio.id}/edit" class="text-amber-600 hover:text-amber-900 mr-3">Editar</a>
                    <a href="/empresa/convenios/${convenio.id}/download" class="text-green-600 hover:text-green-900">Descargar</a>
                </td>
            </tr>`;
        }).join('');
    };
    
    // Initialize tooltips function
    const initTooltips = () => {
        // Implementation depends on your tooltip library
        // Example with Tippy.js or other libraries
        if (window.tippy) {
            tippy('[data-tippy-content]');
        }
    };

    // Event listeners
    if (filterInput) {
        filterInput.addEventListener('input', performSearch);
    }
    
    if (filterEstado) {
        filterEstado.addEventListener('change', performSearch);
    }
    
    if (filterButton) {
        filterButton.addEventListener('click', performSearch);
    }
    
    if (resetButton) {
        resetButton.addEventListener('click', () => {
            if (filterInput) filterInput.value = '';
            if (filterEstado) filterEstado.value = 'todos';
            performSearch();
        });
    }
    
    // Function to create a new convenio
    window.crearConvenio = function(ofertaId, estudianteId) {
        // Show modal or redirect to form
        if (window.Swal) {
            Swal.fire({
                title: 'Nuevo Convenio',
                html: `
                <form id="createConvenioForm" class="text-left">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Fecha de inicio</label>
                        <input type="date" id="fecha_inicio" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Fecha de fin</label>
                        <input type="date" id="fecha_fin" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Horario</label>
                        <select id="horario_practica" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            <option value="mañana">Mañana (9:00 - 14:00)</option>
                            <option value="tarde">Tarde (15:00 - 20:00)</option>
                            <option value="flexible">Flexible (A convenir)</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tutor de empresa</label>
                        <input type="text" id="tutor_empresa" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tareas a realizar</label>
                        <textarea id="tareas" rows="3" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required></textarea>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Objetivos formativos</label>
                        <textarea id="objetivos" rows="3" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required></textarea>
                    </div>
                </form>
                `,
                showCancelButton: true,
                confirmButtonText: 'Crear Convenio',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: '#6366f1',
                focusConfirm: false,
                preConfirm: () => {
                    // Validate form
                    const form = document.getElementById('createConvenioForm');
                    const inputs = form.querySelectorAll('input, select, textarea');
                    let isValid = true;
                    
                    inputs.forEach(input => {
                        if (input.hasAttribute('required') && !input.value.trim()) {
                            isValid = false;
                            input.classList.add('border-red-500');
                        } else {
                            input.classList.remove('border-red-500');
                        }
                    });
                    
                    if (!isValid) {
                        Swal.showValidationMessage('Por favor, completa todos los campos requeridos');
                        return false;
                    }
                    
                    // Get values
                    return {
                        oferta_id: ofertaId,
                        estudiante_id: estudianteId,
                        fecha_inicio: document.getElementById('fecha_inicio').value,
                        fecha_fin: document.getElementById('fecha_fin').value,
                        horario_practica: document.getElementById('horario_practica').value,
                        tutor_empresa: document.getElementById('tutor_empresa').value,
                        tareas: document.getElementById('tareas').value,
                        objetivos: document.getElementById('objetivos').value
                    };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Send data to server
                    fetch('/empresa/convenios', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify(result.value)
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: '¡Éxito!',
                                text: data.message || 'Convenio creado correctamente',
                                confirmButtonColor: '#6366f1'
                            }).then(() => {
                                // Reload page or update UI
                                window.location.reload();
                            });
                        } else {
                            throw new Error(data.message || 'Error al crear el convenio');
                        }
                    })
                    .catch(error => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: error.message || 'Ha ocurrido un error al crear el convenio',
                            confirmButtonColor: '#6366f1'
                        });
                    });
                }
            });
            
            // Set min date for fecha_inicio to today
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('fecha_inicio').min = today;
            
            // Set min date for fecha_fin to fecha_inicio
            document.getElementById('fecha_inicio').addEventListener('change', function() {
                document.getElementById('fecha_fin').min = this.value;
            });
        } else {
            // Redirect to create page if SweetAlert is not available
            window.location.href = `/empresa/convenios/create?oferta=${ofertaId}&estudiante=${estudianteId}`;
        }
    };
}); 