document.addEventListener('DOMContentLoaded', function() {
    let searchTimeout = null;

    function performSearch() {
        // Show loading state
        document.getElementById('searchLoader').classList.remove('hidden');
        document.getElementById('searchResults').classList.add('opacity-50');

        const query = document.getElementById('filterConvenios').value.trim();
        const estado = document.getElementById('filterEstado').value;

        clearTimeout(searchTimeout);

        searchTimeout = setTimeout(function() {
            fetch('/empresa/convenios/search', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    query: query,
                    estado: estado,
                    page: 1
                })
            })
            .then(response => {
                if (!response.ok) throw response;
                return response.json();
            })
            .then(data => {
                document.getElementById('searchLoader').classList.add('hidden');
                document.getElementById('searchResults').classList.remove('opacity-50');
                if (typeof updateResults === 'function') {
                    updateResults(data);
                }
            })
            .catch(async (error) => {
                document.getElementById('searchLoader').classList.add('hidden');
                document.getElementById('searchResults').classList.remove('opacity-50');
                let errorMsg = 'Ha ocurrido un error en la búsqueda. Inténtalo de nuevo.';
                if (error.json) {
                    const errData = await error.json();
                    if (errData && errData.message) errorMsg = errData.message;
                }
                if (window.Swal) {
                    Swal.fire({
                        title: 'Error',
                        text: errorMsg,
                        icon: 'error',
                        confirmButtonColor: '#6366f1'
                    });
                } else {
                    alert(errorMsg);
                }
            });
        }, 500);
    }

    function loadPage(page, perPage) {
        document.getElementById('searchLoader').classList.remove('hidden');
        document.getElementById('searchResults').classList.add('opacity-50');

        const query = document.getElementById('filterConvenios').value.trim();
        const estado = document.getElementById('filterEstado').value;
        perPage = perPage || (document.getElementById('ajaxPerPageSelector') ? document.getElementById('ajaxPerPageSelector').value : 10);

        fetch('/empresa/convenios/search', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                query: query,
                estado: estado,
                page: page,
                per_page: perPage
            })
        })
        .then(response => {
            if (!response.ok) throw response;
            return response.json();
        })
        .then(data => {
            document.getElementById('searchLoader').classList.add('hidden');
            document.getElementById('searchResults').classList.remove('opacity-50');
            if (typeof updateResults === 'function') {
                updateResults(data);
            }
            // Scroll to table top
            const conveniosTable = document.getElementById('conveniosTable');
            if (conveniosTable) {
                window.scrollTo({ top: conveniosTable.offsetTop - 100, behavior: 'smooth' });
            }
        })
        .catch(async (error) => {
            document.getElementById('searchLoader').classList.add('hidden');
            document.getElementById('searchResults').classList.remove('opacity-50');
            let errorMsg = 'Ha ocurrido un error al cargar la página. Inténtalo de nuevo.';
            if (error.json) {
                const errData = await error.json();
                if (errData && errData.message) errorMsg = errData.message;
            }
            if (window.Swal) {
                Swal.fire({
                    title: 'Error',
                    text: errorMsg,
                    icon: 'error',
                    confirmButtonColor: '#6366f1'
                });
            } else {
                alert(errorMsg);
            }
        });
    }

    // Event Listeners
    const filterConvenios = document.getElementById('filterConvenios');
    const filterEstado = document.getElementById('filterEstado');
    if (filterConvenios) filterConvenios.addEventListener('input', performSearch);
    if (filterEstado) filterEstado.addEventListener('change', performSearch);

    const resetFilters = document.getElementById('resetFilters');
    const resetFiltersButton = document.getElementById('resetFiltersButton');
    [resetFilters, resetFiltersButton].forEach(btn => {
        if (btn) btn.addEventListener('click', function() {
            if (filterConvenios) filterConvenios.value = '';
            if (filterEstado) filterEstado.value = 'todos';
            document.getElementById('noResultsMessage').classList.add('hidden');
            document.getElementById('searchResults').classList.remove('hidden');
            performSearch();
        });
    });

    // Initial search
    setTimeout(performSearch, 500);

    // Expose loadPage globally if needed for pagination
    window.loadPage = loadPage;

    window.updateResults = function(data) {
        // Actualiza la tabla de convenios
        const tbody = document.querySelector('#conveniosTable tbody');
        if (tbody) {
            if (data.convenios && data.convenios.length > 0) {
                tbody.innerHTML = renderConveniosHTML(data.convenios);
            } else {
                tbody.innerHTML = '<tr><td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">No hay convenios que coincidan con la búsqueda.</td></tr>';
            }
        }

        // Actualiza la lista de ofertas con candidatos aceptados
        const ofertasDiv = document.getElementById('ofertasConCandidatos');
        if (ofertasDiv) {
            if (data.ofertas && data.ofertas.length > 0) {
                ofertasDiv.innerHTML = renderOfertasHTML(data.ofertas);
            } else {
                ofertasDiv.innerHTML = `<div class="bg-gray-50 border border-gray-200 rounded-lg p-8 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No hay ofertas con candidatos aceptados</h3>
                    <p class="text-gray-500 max-w-md mx-auto mb-6">
                        Cuando aceptes candidatos para tus ofertas, podrás crear convenios de prácticas con ellos desde aquí.
                    </p>
                </div>`;
            }
        }
    };

    function renderConveniosHTML(convenios) {
        return convenios.map(function(convenio) {
            const imgHTML = convenio.estudiante.imagen
                ? `<img src="/profile_images/${convenio.estudiante.imagen}" alt="${convenio.estudiante.nombre}" class="h-10 w-10 rounded-full object-cover shadow-sm">`
                : `<div class="h-10 w-10 rounded-full bg-gradient-to-br from-indigo-500 to-purple-500 flex items-center justify-center text-white font-bold shadow-sm">
                    ${convenio.estudiante.nombre.substring(0, 1).toUpperCase()}${convenio.estudiante.nombre.split(' ')[1] ? convenio.estudiante.nombre.split(' ')[1].substring(0, 1).toUpperCase() : ''}
                  </div>`;

            const estadoClass = convenio.estado === 'activo'
                ? 'bg-green-100 text-green-800'
                : (convenio.estado === 'pendiente' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800');

            return `<tr>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-10 w-10">${imgHTML}</div>
                        <div class="ml-4">
                            <div class="text-sm font-medium text-gray-900">${convenio.estudiante.nombre}</div>
                            <div class="text-sm text-gray-500">${convenio.estudiante.email}</div>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-900 font-medium">${convenio.oferta.titulo}</div>
                    <div class="text-xs text-gray-500">${convenio.oferta.descripcion ? (convenio.oferta.descripcion.substring(0, 50) + (convenio.oferta.descripcion.length > 50 ? '...' : '')) : ''}</div>
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
                    <div class="flex items-center space-x-2">
                        <a href="/empresa/convenios/${convenio.id}" class="text-indigo-600 hover:text-indigo-900" title="Ver detalles">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </a>
                        <a href="/empresa/convenios/${convenio.id}/edit" class="text-amber-600 hover:text-amber-900" title="Editar convenio">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                            </svg>
                        </a>
                        <a href="/empresa/convenios/${convenio.id}/download" class="text-green-600 hover:text-green-900" title="Descargar PDF">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                        </a>
                    </div>
                </td>
            </tr>`;
        }).join('');
    }

    function renderOfertasHTML(ofertas) {
        return ofertas.map(function(oferta) {
            let candidatosHTML = '';
            if (oferta.candidatos_aceptados && oferta.candidatos_aceptados.length > 0) {
                candidatosHTML = oferta.candidatos_aceptados.map(function(candidato) {
                    const imgHTML = candidato.imagen
                        ? `<img src="/profile_images/${candidato.imagen}" alt="${candidato.nombre}" class="h-10 w-10 rounded-full object-cover border border-gray-200 shadow-sm">`
                        : `<div class="h-10 w-10 rounded-full bg-gradient-to-br from-indigo-500 to-purple-500 flex items-center justify-center text-white font-bold text-lg shadow-sm">
                            ${candidato.nombre.substring(0, 1).toUpperCase()}${candidato.nombre.split(' ')[1] ? candidato.nombre.split(' ')[1].substring(0, 1).toUpperCase() : ''}
                        </div>`;

                    const convenioBtn = candidato.convenio
                        ? `<span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-green-100 text-green-800">
                                Convenio Activo
                            </span>`
                        : `<button onclick="crearConvenio(${oferta.id}, ${candidato.id})" class="inline-flex items-center px-3 py-1 border border-transparent rounded-md shadow-sm text-xs font-medium text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-300">
                                <svg xmlns='http://www.w3.org/2000/svg' class='h-4 w-4 mr-1' fill='none' viewBox='0 0 24 24' stroke='currentColor'>
                                    <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M12 4v16m8-8H4' />
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

            return `<div class="bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-md transition-all duration-300 p-3 sm:p-6">
                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-2">
                    <div>
                        <h3 class="text-base sm:text-lg font-medium text-gray-900">${oferta.titulo}</h3>
                        <p class="text-xs sm:text-sm text-gray-500 mb-1 sm:mb-2">Publicada el ${new Date(oferta.created_at).toLocaleDateString('es-ES')}</p>
                        <div class="flex flex-wrap gap-1 sm:gap-2 mb-2 sm:mb-3">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
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
                    <div class="mt-2 sm:mt-0">
                        <span class="inline-block rounded-full px-2 py-0.5 sm:px-3 sm:py-1 text-xs sm:text-sm font-medium bg-blue-100 text-blue-800">
                            ${oferta.candidatos_aceptados.length} candidatos aceptados
                        </span>
                    </div>
                </div>
                <div class="mt-4 border-t pt-4">
                    <h4 class="text-md font-medium text-gray-800 mb-3 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        Candidatos Aceptados
                    </h4>
                    <div class="divide-y divide-gray-200">
                        ${candidatosHTML}
                    </div>
                </div>
            </div>`;
        }).join('');
    }
});
