{{-- HEADER --}}@extends('layouts.app')@push('meta')<meta name="csrf-token" content="{{ csrf_token() }}">@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://unpkg.com/tippy.js@6"></script>

<!-- Global function definition for creating convenios -->
<script>
function crearConvenio(ofertaId, estudianteId) {
    // Show modal with SweetAlert2
    if (window.Swal) {
        Swal.fire({
            title: 'Nuevo Convenio',
            html: `
            <form id="createConvenioForm" class="text-left">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Fecha de inicio</label>
                    <input type="date" id="fecha_inicio" name="fecha_inicio" class="swal-input w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Fecha de fin</label>
                    <input type="date" id="fecha_fin" name="fecha_fin" class="swal-input w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Horario</label>
                    <select id="horario_practica" name="horario_practica" class="swal-input w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        <option value="">Seleccione un horario</option>
                        <option value="mañana">Mañana (9:00 - 14:00)</option>
                        <option value="tarde">Tarde (15:00 - 20:00)</option>
                        <option value="flexible">Flexible (A convenir)</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tutor de empresa</label>
                    <input type="text" id="tutor_empresa" name="tutor_empresa" class="swal-input w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tareas a realizar</label>
                    <textarea id="tareas" name="tareas" rows="3" class="swal-input w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required></textarea>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Objetivos formativos</label>
                    <textarea id="objetivos" name="objetivos" rows="3" class="swal-input w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required></textarea>
                </div>
            </form>
            `,
            showCancelButton: true,
            confirmButtonText: 'Crear Convenio',
            cancelButtonText: 'Cancelar',
            confirmButtonColor: '#6366f1',
            focusConfirm: false,
            customClass: {
                popup: 'rounded-lg',
            },
            preConfirm: () => {
                // Get the form values directly using querySelector with class (more reliable in SweetAlert2)
                const formData = {
                    oferta_id: ofertaId,
                    estudiante_id: estudianteId,
                    empresa_id: {{ Auth::id() }}, // Add empresa_id from the authenticated user
                    fecha_inicio: document.querySelector('.swal2-container #fecha_inicio').value,
                    fecha_fin: document.querySelector('.swal2-container #fecha_fin').value,
                    horario_practica: document.querySelector('.swal2-container #horario_practica').value,
                    tutor_empresa: document.querySelector('.swal2-container #tutor_empresa').value,
                    tareas: document.querySelector('.swal2-container #tareas').value,
                    objetivos: document.querySelector('.swal2-container #objetivos').value
                };
                
                console.log('Direct form values:', formData);
                
                // Validate the data
                let isValid = true;
                let errorMessages = [];
                
                // Check required fields
                if (!formData.fecha_inicio) {
                    isValid = false;
                    document.querySelector('.swal2-container #fecha_inicio').classList.add('border-red-500');
                    errorMessages.push('Fecha de inicio es obligatorio');
                }
                
                if (!formData.fecha_fin) {
                    isValid = false;
                    document.querySelector('.swal2-container #fecha_fin').classList.add('border-red-500');
                    errorMessages.push('Fecha de fin es obligatorio');
                }
                
                if (!formData.horario_practica) {
                    isValid = false;
                    document.querySelector('.swal2-container #horario_practica').classList.add('border-red-500');
                    errorMessages.push('Horario es obligatorio');
                }
                
                if (!formData.tutor_empresa) {
                    isValid = false;
                    document.querySelector('.swal2-container #tutor_empresa').classList.add('border-red-500');
                    errorMessages.push('Tutor de empresa es obligatorio');
                }
                
                if (!formData.tareas) {
                    isValid = false;
                    document.querySelector('.swal2-container #tareas').classList.add('border-red-500');
                    errorMessages.push('Tareas a realizar es obligatorio');
                }
                
                if (!formData.objetivos) {
                    isValid = false;
                    document.querySelector('.swal2-container #objetivos').classList.add('border-red-500');
                    errorMessages.push('Objetivos formativos es obligatorio');
                }
                
                // Date validation
                if (formData.fecha_inicio && formData.fecha_fin) {
                    const inicio = new Date(formData.fecha_inicio);
                    const fin = new Date(formData.fecha_fin);
                    const today = new Date();
                    today.setHours(0, 0, 0, 0);
                    
                    // Check if fecha_fin is after fecha_inicio
                    if (inicio >= fin) {
                        isValid = false;
                        document.querySelector('.swal2-container #fecha_fin').classList.add('border-red-500');
                        errorMessages.push('La fecha de finalización debe ser posterior a la fecha de inicio');
                    }
                    
                    // Check if fecha_inicio is not in the past
                    if (inicio < today) {
                        isValid = false;
                        document.querySelector('.swal2-container #fecha_inicio').classList.add('border-red-500');
                        errorMessages.push('La fecha de inicio no puede ser en el pasado');
                    }
                }
                
                console.log('Form validation result:', isValid ? 'Valid' : 'Invalid', formData);
                
                if (!isValid) {
                    let validationMessage = 'Por favor, corrige los siguientes errores:';
                    if (errorMessages.length > 0) {
                        validationMessage += '<ul class="mt-2 text-left">';
                        errorMessages.forEach(msg => {
                            validationMessage += `<li class="mt-1">• ${msg}</li>`;
                        });
                        validationMessage += '</ul>';
                    }
                    Swal.showValidationMessage(validationMessage);
                    return false;
                }
                
                return formData;
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading indicator
                Swal.fire({
                    title: 'Creando convenio...',
                    text: 'Por favor espera',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                
                                    // Format dates in YYYY-MM-DD format for Laravel validation                    const formattedFechaInicio = result.value.fecha_inicio;                    const formattedFechaFin = result.value.fecha_fin;                                        // Debug data being sent                    const formData = {                        oferta_id: result.value.oferta_id,                        estudiante_id: result.value.estudiante_id,                        fecha_inicio: formattedFechaInicio,                        fecha_fin: formattedFechaFin,                        horario_practica: result.value.horario_practica,                        tutor_empresa: result.value.tutor_empresa,                        tareas: result.value.tareas,                        objetivos: result.value.objetivos,                        _token: $('meta[name="csrf-token"]').attr('content')                    };
                console.log('Sending data to server:', formData);
                
                // Send data to server using jQuery for better compatibility
                $.ajax({
                    url: '/empresa/convenios',
                    type: 'POST',
                    data: formData,
                    success: function(data) {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: '¡Éxito!',
                                text: data.message || 'Convenio creado correctamente',
                                confirmButtonColor: '#6366f1',
                                showCloseButton: true,
                                confirmButtonText: 'Descargar PDF',
                                footer: '<div class="text-center w-full">El PDF se descargará automáticamente en unos segundos</div>'
                            }).then(() => {
                                // Reload page
                                window.location.reload();
                            });
                            
                            // Automatic PDF download
                            if (data.pdf_url) {
                                // Create a hidden iframe to trigger the download
                                const iframe = document.createElement('iframe');
                                iframe.style.display = 'none';
                                iframe.src = data.pdf_url;
                                document.body.appendChild(iframe);
                                
                                // Also open a new window for viewing
                                setTimeout(() => {
                                    // Remove iframe after a delay
                                    document.body.removeChild(iframe);
                                }, 5000);
                            }
                        } else {
                            throw new Error(data.message || 'Error al crear el convenio');
                        }
                    },
                    error: function(xhr, status, error) {
                        let errorMessage = 'Ha ocurrido un error al crear el convenio';
                        
                        // Check if we have validation errors
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            errorMessage = '<ul class="text-left">';
                            Object.keys(xhr.responseJSON.errors).forEach(function(key) {
                                errorMessage += '<li class="mt-1">' + xhr.responseJSON.errors[key][0] + '</li>';
                            });
                            errorMessage += '</ul>';
                        } else if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }
                        
                        Swal.fire({
                            icon: 'error',
                            title: 'Error de validación',
                            html: errorMessage,
                            confirmButtonColor: '#6366f1'
                        });
                        
                        console.log('Error response:', xhr.responseJSON);
                    }
                });
            }
        });
        
        // Set min date for fecha_inicio to today
        setTimeout(() => {
            const today = new Date().toISOString().split('T')[0];
            const fechaInicio = document.getElementById('fecha_inicio');
            if (fechaInicio) {
                fechaInicio.min = today;
                fechaInicio.addEventListener('change', function() {
                    const fechaFin = document.getElementById('fecha_fin');
                    if (fechaFin) {
                        fechaFin.min = this.value;
                    }
                });
            }
        }, 300);
    } else {
        // Redirect to create page if SweetAlert is not available
        window.location.href = `/empresa/convenios/create?oferta=${ofertaId}&estudiante=${estudianteId}`;
    }
};

<script>
$(document).ready(function() {
    // Check if tippy is available before trying to use it
    if (typeof tippy === 'function') {
        // Initialize tooltips
        tippy('[data-tippy-content]');
    } else {
        console.warn('Tippy.js not loaded - tooltips will not work');
    }
    
    // Check for CSRF token
    if (!$('meta[name="csrf-token"]').length) {
        console.error('CSRF token meta tag not found! Adding it manually...');
        $('head').append('<meta name="csrf-token" content="{{ csrf_token() }}">');
    }
    
    // Handle debounce for search
    let searchTimeout = null;
    
    function performSearch() {
        // Show loading state
        $('#searchLoader').removeClass('hidden');
        $('#searchResults').addClass('opacity-50');
        
        // Get search values
        const query = $('#filterConvenios').val().trim();
        const estado = $('#filterEstado').val();
        
        console.log('Searching with:', {query, estado});
        
        // Clear previous timeout
        clearTimeout(searchTimeout);
        
        // Set debounce timeout
        searchTimeout = setTimeout(function() {
            // Send AJAX request
            $.ajax({
                url: '/empresa/convenios/search',
                type: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({
                    query: query,
                    estado: estado,
                    page: 1 // Reset to first page on new search
                }),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    console.log('Search success:', data);
                    
                    // Hide loader
                    $('#searchLoader').addClass('hidden');
                    $('#searchResults').removeClass('opacity-50');
                    
                    // Update results
                    updateResults(data);
                },
                error: function(xhr, status, error) {
                    console.error('Search error:', xhr.responseText, status, error);
                    
                    // Hide loader
                    $('#searchLoader').addClass('hidden');
                    $('#searchResults').removeClass('opacity-50');
                    
                    // Show error message
                    Swal.fire({
                        title: 'Error',
                        text: 'Ha ocurrido un error en la búsqueda. Inténtalo de nuevo.',
                        icon: 'error',
                        confirmButtonColor: '#6366f1'
                    });
                }
            });
        }, 500);
    }
    
    // Update results function
    function updateResults(data) {
        // If no results found
        if (data.ofertas.length === 0 && data.convenios.length === 0 && (!data.pagination || data.pagination.total === 0)) {
            $('#noResultsMessage').removeClass('hidden');
            $('#searchResults').addClass('hidden');
            return;
        }
        
        // If we have results
        $('#noResultsMessage').addClass('hidden');
        $('#searchResults').removeClass('hidden');
        
        // Update ofertas section
        if ($('#ofertasConCandidatos').length) {
            if (data.ofertas.length > 0) {
                $('#ofertasConCandidatos').html(renderOfertasHTML(data.ofertas));
            } else {
                $('#ofertasConCandidatos').html('<div class="bg-gray-50 rounded-lg p-8 text-center">' +
                  '<svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">' +
                  '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />' +
                  '</svg>' +
                  '<h3 class="text-lg font-medium text-gray-900 mb-2">No hay ofertas que coincidan con la búsqueda</h3>' +
                  '</div>');
            }
        }
        
        // Update convenios table
        if ($('#conveniosTable').length) {
            const $tbody = $('#conveniosTable tbody');
            if (data.convenios.length > 0) {
                $tbody.html(renderConveniosHTML(data.convenios));
                
                // Update pagination if exists
                if (data.pagination) {
                    renderPagination(data.pagination);
                } else {
                    $('#conveniosPagination').html('');
                }
            } else {
                $tbody.html('<tr><td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">No hay convenios que coincidan con la búsqueda.</td></tr>');
                $('#conveniosPagination').html('');
            }
        }
        
        // Update counters
        $('#ofertasCount').text(data.ofertas.length);
        $('#conveniosCount').text(data.pagination ? data.pagination.total : data.convenios.length);
        
        let totalCandidatos = 0;
        data.ofertas.forEach(function(oferta) {
            totalCandidatos += oferta.candidatos_aceptados ? oferta.candidatos_aceptados.length : 0;
        });
        $('#candidatosCount').text(totalCandidatos);
        
        // Re-initialize tooltips
        if (typeof tippy === 'function') {
            tippy('[data-tippy-content]');
        }
    }
    
    // Render pagination controls
    function renderPagination(pagination) {
        if (!pagination || pagination.last_page <= 1) {
            $('#conveniosPagination').html('');
            return;
        }
        
        let paginationHTML = '<div class="px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6 bg-gradient-to-r from-gray-50 to-indigo-50 rounded-lg shadow-sm mt-4">' +
            '<div class="flex-1 flex justify-between sm:hidden">' +
                '<button ' + (pagination.current_page <= 1 ? 'disabled' : '') + ' data-page="' + (pagination.current_page - 1) + '" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 ' + (pagination.current_page <= 1 ? 'opacity-50 cursor-not-allowed' : '') + '">' +
                    'Anterior' +
                '</button>' +
                '<button ' + (pagination.current_page >= pagination.last_page ? 'disabled' : '') + ' data-page="' + (pagination.current_page + 1) + '" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 ' + (pagination.current_page >= pagination.last_page ? 'opacity-50 cursor-not-allowed' : '') + '">' +
                    'Siguiente' +
                '</button>' +
            '</div>' +
            '<div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">' +
                '<div>' +
                    '<p class="text-sm text-gray-700">' +
                        'Mostrando ' +
                        '<span class="font-medium">' + ((pagination.current_page - 1) * pagination.per_page + 1) + '</span>' +
                        ' a ' +
                        '<span class="font-medium">' + Math.min(pagination.current_page * pagination.per_page, pagination.total) + '</span>' +
                        ' de ' +
                        '<span class="font-medium">' + pagination.total + '</span>' +
                        ' resultados' +
                    '</p>' +
                '</div>' +
                '<div class="flex items-center">' +
                    '<select id="ajaxPerPageSelector" class="mr-4 bg-white border border-gray-300 rounded-md shadow-sm py-1 px-3 text-sm text-gray-700 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">' +
                        '<option value="10" ' + (pagination.per_page == 10 ? 'selected' : '') + '>10 por página</option>' +
                        '<option value="20" ' + (pagination.per_page == 20 ? 'selected' : '') + '>20 por página</option>' +
                        '<option value="50" ' + (pagination.per_page == 50 ? 'selected' : '') + '>50 por página</option>' +
                        '<option value="100" ' + (pagination.per_page == 100 ? 'selected' : '') + '>100 por página</option>' +
                    '</select>' +
                    '<nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">';
        
        // Previous button
        paginationHTML += '<button ' + (pagination.current_page <= 1 ? 'disabled' : '') + ' data-page="' + (pagination.current_page - 1) + '" class="relative inline-flex items-center px-3 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium ' + (pagination.current_page <= 1 ? 'text-gray-400 opacity-50 cursor-not-allowed' : 'text-indigo-600 hover:bg-indigo-50 transition-colors duration-150') + '">' +
            '<svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">' +
                '<path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />' +
            '</svg>' +
            '<span class="ml-1">Anterior</span>' +
        '</button>';
        
        // Page numbers
        const startPage = Math.max(1, pagination.current_page - 1);
        const endPage = Math.min(pagination.last_page, pagination.current_page + 1);
        
        if (startPage > 1) {
            paginationHTML += '<button data-page="1" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors duration-150">' +
                '1' +
            '</button>';
            
            if (startPage > 2) {
                paginationHTML += '<span class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700">' +
                    '...' +
                '</span>';
            }
        }
        
        for (let page = startPage; page <= endPage; page++) {
            paginationHTML += (page === pagination.current_page) ?
                '<span class="relative inline-flex items-center px-4 py-2 border border-indigo-500 bg-indigo-50 text-sm font-bold text-indigo-600">' +
                    page +
                '</span>' :
                '<button data-page="' + page + '" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors duration-150">' +
                    page +
                '</button>';
        }
        
        if (endPage < pagination.last_page) {
            if (endPage < pagination.last_page - 1) {
                paginationHTML += '<span class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700">' +
                    '...' +
                '</span>';
            }
            
            paginationHTML += '<button data-page="' + pagination.last_page + '" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors duration-150">' +
                pagination.last_page +
            '</button>';
        }
        
        // Next button
        paginationHTML += '<button ' + (pagination.current_page >= pagination.last_page ? 'disabled' : '') + ' data-page="' + (pagination.current_page + 1) + '" class="relative inline-flex items-center px-3 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium ' + (pagination.current_page >= pagination.last_page ? 'text-gray-400 opacity-50 cursor-not-allowed' : 'text-indigo-600 hover:bg-indigo-50 transition-colors duration-150') + '">' +
            '<span class="mr-1">Siguiente</span>' +
            '<svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">' +
                '<path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />' +
            '</svg>' +
        '</button>';
        
        paginationHTML += '</nav></div></div></div>';
        
        $('#conveniosPagination').html(paginationHTML);
        
        // Add event listeners to pagination buttons
        $('#conveniosPagination button[data-page]').on('click', function() {
            if ($(this).attr('disabled')) return;
            
            const page = $(this).data('page');
            loadPage(page);
        });
        
        // Add event listener for per page selector
        $('#ajaxPerPageSelector').on('change', function() {
            const perPage = $(this).val();
            loadPage(1, perPage);
        });
    }
    
    // Update loadPage function to include perPage parameter
    function loadPage(page, perPage) {
        // Show loading state
        $('#searchLoader').removeClass('hidden');
        $('#searchResults').addClass('opacity-50');
        
        // Get search values
        const query = $('#filterConvenios').val().trim();
        const estado = $('#filterEstado').val();
        perPage = perPage || $('#ajaxPerPageSelector').val() || 10;
        
        console.log('Loading page', page, 'with filters:', {query, estado, perPage});
        
        // Send AJAX request
        $.ajax({
            url: '/empresa/convenios/search',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({
                query: query,
                estado: estado,
                page: page,
                per_page: perPage
            }),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                console.log('Page load success:', data);
                
                // Hide loader
                $('#searchLoader').addClass('hidden');
                $('#searchResults').removeClass('opacity-50');
                
                // Update results
                updateResults(data);
                
                // Scroll to table top
                $('html, body').animate({
                    scrollTop: $("#conveniosTable").offset().top - 100
                }, 300);
            },
            error: function(xhr, status, error) {
                console.error('Page load error:', xhr.responseText, status, error);
                
                // Hide loader
                $('#searchLoader').addClass('hidden');
                $('#searchResults').removeClass('opacity-50');
                
                // Show error message
                Swal.fire({
                    title: 'Error',
                    text: 'Ha ocurrido un error al cargar la página. Inténtalo de nuevo.',
                    icon: 'error',
                    confirmButtonColor: '#6366f1'
                });
            }
        });
    }
    
    // Add event listener for per page selector on initial page load
    $(document).ready(function() {
        // Initial event listeners we set up earlier...
        
        // Add event listener for per page selector
        $('#perPageSelector').on('change', function() {
            const perPage = $(this).val();
            window.location.href = updateQueryStringParameter(window.location.href, 'per_page', perPage);
        });
    });
    
    // Helper function to update query string parameters
    function updateQueryStringParameter(uri, key, value) {
        var re = new RegExp("([?&])" + key + "=.*?(&|$)", "i");
        var separator = uri.indexOf('?') !== -1 ? "&" : "?";
        if (uri.match(re)) {
            return uri.replace(re, '$1' + key + "=" + value + '$2');
        }
        else {
            return uri + separator + key + "=" + value;
        }
    }
    
    // Render functions for ofertas
    function renderOfertasHTML(ofertas) {
        return ofertas.map(function(oferta) {
            let candidatosHTML = '';
            
            if (oferta.candidatos_aceptados && oferta.candidatos_aceptados.length > 0) {
                candidatosHTML = oferta.candidatos_aceptados.map(function(candidato) {
                    // Display profile image if available, otherwise show initials
                    const imgHTML = candidato.imagen
                        ? `<img src="{{ asset('profile_images/') }}/${candidato.imagen}" alt="${candidato.nombre}" class="h-10 w-10 rounded-full object-cover border border-gray-200 shadow-sm" onerror="this.onerror=null; this.src='data:image/svg+xml;utf8,<svg xmlns=\\'http://www.w3.org/2000/svg\\' viewBox=\\'0 0 100 100\\' width=\\'40\\' height=\\'40\\'><rect width=\\'100\\' height=\\'100\\' fill=\'%236366F1\\'/><text x=\\'50\\' y=\\'50\\' font-size=\\'35\\' fill=\\'white\\' text-anchor=\\'middle\\' dominant-baseline=\\'middle\\'>${candidato.nombre.substring(0, 1).toUpperCase()}${candidato.nombre.split(' ')[1] ? candidato.nombre.split(' ')[1].substring(0, 1).toUpperCase() : ''}</text></svg>';">`
                        : `<div class="h-10 w-10 rounded-full bg-gradient-to-br from-indigo-500 to-purple-500 flex items-center justify-center text-white font-bold text-lg shadow-sm">${candidato.nombre.substring(0, 1).toUpperCase()}${candidato.nombre.split(' ')[1] ? candidato.nombre.split(' ')[1].substring(0, 1).toUpperCase() : ''}</div>`;
                    
                    const convenioBtn = candidato.convenio
                        ? `<span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium ${candidato.convenio.estado === 'activo' ? 'bg-green-100 text-green-800' : 'bg-amber-100 text-amber-800'}">
                            Convenio ${candidato.convenio.estado.charAt(0).toUpperCase() + candidato.convenio.estado.slice(1)}
                           </span>
                           <a href="/empresa/convenios/${candidato.convenio.id}" class="inline-flex items-center px-2.5 py-1 border border-gray-300 rounded-md text-xs font-medium text-gray-700 bg-white hover:bg-gray-50 transition-all duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            Ver convenio
                           </a>`
                        : `<button onclick="crearConvenio(${oferta.id}, ${candidato.id})" class="inline-flex items-center px-3 py-1 border border-transparent rounded-md shadow-sm text-xs font-medium text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-300">
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
            
            return `<div class="bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-md transition-all duration-300 p-6 mb-6 animate-fadeIn">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900">${oferta.titulo}</h3>
                        <p class="text-sm text-gray-500 mb-2">Publicada el ${new Date(oferta.created_at).toLocaleDateString('es-ES')}</p>
                        
                        <div class="flex flex-wrap gap-2 mb-3">
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
                    
                    <div class="flex items-center">
                        <span class="inline-block rounded-full px-3 py-1 text-sm font-medium bg-blue-100 text-blue-800">
                            ${oferta.candidatos_aceptados_count ?? $oferta->candidatosAceptados->count()} candidatos aceptados
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
    
    // Render functions for convenios
    function renderConveniosHTML(convenios) {
        return convenios.map(function(convenio) {
            // Display profile image if available, otherwise show initials
            const imgHTML = convenio.estudiante.imagen
                ? `<img src="{{ asset('profile_images/') }}/${convenio.estudiante.imagen}" alt="${convenio.estudiante.nombre}" class="h-10 w-10 rounded-full object-cover shadow-sm" onerror="this.onerror=null; this.src='data:image/svg+xml;utf8,<svg xmlns=\\'http://www.w3.org/2000/svg\\' viewBox=\\'0 0 100 100\\' width=\\'40\\' height=\\'40\\'><rect width=\\'100\\' height=\\'100\\' fill=\\'%236366F1\\'/><text x=\\'50\\' y=\\'50\\' font-size=\\'35\\' fill=\\'white\\' text-anchor=\\'middle\\' dominant-baseline=\\'middle\\'>${convenio.estudiante.nombre.substring(0, 1).toUpperCase()}${convenio.estudiante.nombre.split(' ')[1] ? convenio.estudiante.nombre.split(' ')[1].substring(0, 1).toUpperCase() : ''}</text></svg>';">`
                : `<div class="h-10 w-10 rounded-full bg-gradient-to-br from-indigo-500 to-purple-500 flex items-center justify-center text-white font-bold shadow-sm">
                    ${convenio.estudiante.nombre.substring(0, 1).toUpperCase()}${convenio.estudiante.nombre.split(' ')[1] ? convenio.estudiante.nombre.split(' ')[1].substring(0, 1).toUpperCase() : ''}
                   </div>`;
                
            const estadoClass = convenio.estado === 'activo' 
                ? 'bg-green-100 text-green-800' 
                : (convenio.estado === 'pendiente' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800');
                
            return `<tr class="hover:bg-gray-50 transition-colors duration-200 animate-fadeIn">
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
                        <a href="/empresa/convenios/${convenio.id}" class="text-indigo-600 hover:text-indigo-900">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" data-tippy-content="Ver detalles">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </a>
                        <a href="/empresa/convenios/${convenio.id}/edit" class="text-amber-600 hover:text-amber-900">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" data-tippy-content="Editar convenio">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                            </svg>
                        </a>
                        <a href="/empresa/convenios/${convenio.id}/download" class="text-green-600 hover:text-green-900">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" data-tippy-content="Descargar PDF">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                        </a>
                    </div>
                </td>
            </tr>`;
        }).join('');
    }
    
    // Event Listeners
    $('#filterConvenios').on('input', performSearch);
    $('#filterEstado').on('change', performSearch);
    $('#applyFilters').on('click', performSearch);
    
    $('#resetFilters, #resetFiltersButton').on('click', function() {
        $('#filterConvenios').val('');
        $('#filterEstado').val('todos');
        $('#noResultsMessage').addClass('hidden');
        $('#searchResults').removeClass('hidden');
        performSearch();
    });
    
    // Trigger initial search
    setTimeout(performSearch, 500);
});
</script>
@endpush

{{-- CONTENIDO --}}
@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-purple-50">
    {{-- MIGAS DE PAN STICKY --}}
    <div class="bg-white shadow-sm sticky top-0 z-10">
        <div class="container mx-auto px-4 py-3">
            <div class="flex items-center text-sm">
                <a href="{{ route('home') }}" class="text-gray-500 hover:text-purple-700 transition-colors duration-200">
                    <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    Inicio
                </a>
                <span class="mx-2 text-gray-400">/</span>
                <a href="{{ route('empresa.dashboard') }}" class="text-gray-500 hover:text-purple-700 transition-colors duration-200">Dashboard</a>
                <span class="mx-2 text-gray-400">/</span>
                <span class="text-purple-700 font-medium">Convenios</span>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        <div class="flex flex-col md:flex-row gap-6">
            <!-- Sidebar - Esto debería ser un componente compartido, pero por ahora se duplica -->
            @include('layouts.empresa-sidebar')

            <!-- Main Content -->
            <div class="w-full md:w-3/4">
                <div class="bg-white rounded-xl shadow-lg p-6 mb-6 hover:shadow-xl transition-shadow duration-300">
                    <h1 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 mr-3 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Gestión de Convenios
                    </h1>

                    <!-- Filtro rápido -->
                    <div class="mb-6">
                        <div class="bg-gradient-to-r from-indigo-50 to-purple-50 rounded-lg p-5 shadow-sm border border-indigo-100">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                                </svg>
                                Filtros de búsqueda
                            </h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="col-span-2">
                                    <div class="relative rounded-md shadow-sm">
                                        <input type="text" id="filterConvenios" class="block w-full rounded-md border-gray-300 pl-10 pr-12 py-2 focus:border-indigo-500 focus:ring-indigo-500 transition-all duration-300" 
                                            placeholder="Buscar por título de oferta, nombre de candidato, correo electrónico... (filtrado en tiempo real)" 
                                            autofocus>
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                            </svg>
                                        </div>
                                        <div id="searchLoader" class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none hidden">
                                            <svg class="animate-spin h-5 w-5 text-indigo-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div id="filterStatus" class="text-xs text-indigo-600 mt-1">
                                        Los resultados se filtran automáticamente mientras escribes
                                    </div>
                                </div>
                                <div>
                                    <select id="filterEstado" class="block w-full rounded-md border-gray-300 pr-10 py-2 focus:border-indigo-500 focus:ring-indigo-500 transition-all duration-300">
                                        <option value="todos">Todos los estados</option>
                                        <option value="pendiente">Pendiente</option>
                                        <option value="activo">Activo</option>
                                        <option value="finalizado">Finalizado</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="flex items-center justify-between mt-4">
                                <div class="flex items-center space-x-4 text-sm">
                                    <div class="flex items-center">
                                        <div class="w-3 h-3 rounded-full bg-indigo-500 mr-1"></div>
                                        <span><span id="ofertasCount">{{ $ofertas->count() }}</span> ofertas</span>
                                    </div>
                                    <div class="flex items-center">
                                        <div class="w-3 h-3 rounded-full bg-purple-500 mr-1"></div>
                                        <span><span id="conveniosCount">{{ $convenios->count() }}</span> convenios</span>
                                    </div>
                                </div>
                                
                                <div class="flex space-x-2">
                                    <button id="resetFilters" class="inline-flex items-center px-3 py-1.5 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                        </svg>
                                        Limpiar
                                    </button>
                                    <button id="applyFilters" class="inline-flex items-center px-3 py-1.5 border border-transparent rounded-md text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                        Buscar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sección de Publicaciones con Candidatos Aceptados -->
                    <div id="searchResults">
                        <div class="mb-8">
                            <div class="flex justify-between items-center mb-4">
                                <h2 class="text-xl font-semibold text-gray-800 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    Ofertas con Candidatos Aceptados
                                </h2>
                                <div class="text-sm text-gray-500">
                                    <span class="font-medium text-indigo-700"><span id="candidatosCount">{{ $ofertas->sum(function($oferta) { return $oferta->candidatosAceptados->count(); }) }}</span></span> candidatos disponibles
                                </div>
                            </div>
                            
                            <!-- Lista de Ofertas -->
                            <div class="space-y-6" id="ofertasConCandidatos">
                                <!-- Esta sección se llenará con PHP desde el controlador -->
                                @forelse($ofertas ?? [] as $oferta)
                                    <div class="bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-md transition-all duration-300 p-6">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <h3 class="text-lg font-medium text-gray-900">{{ $oferta->titulo }}</h3>
                                                <p class="text-sm text-gray-500 mb-2">Publicada el {{ $oferta->created_at->format('d/m/Y') }}</p>
                                                
                                                <div class="flex flex-wrap gap-2 mb-3">
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                                        {{ $oferta->categoria->nombre_categoria ?? 'Sin categoría' }}
                                                    </span>
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                        {{ $oferta->horario }}
                                                    </span>
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                        {{ $oferta->horas_totales }} horas
                                                    </span>
                                                </div>
                                            </div>
                                            
                                            <div class="flex items-center">
                                                <span class="inline-block rounded-full px-3 py-1 text-sm font-medium bg-blue-100 text-blue-800">
                                                    {{ $oferta->candidatos_aceptados_count ?? $oferta->candidatosAceptados->count() }} candidatos aceptados
                                                </span>
                                            </div>
                                        </div>
                                        
                                        <!-- Lista de Candidatos Aceptados -->
                                        <div class="mt-4 border-t pt-4">
                                            <h4 class="text-md font-medium text-gray-800 mb-3 flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                                </svg>
                                                Candidatos Aceptados
                                            </h4>
                                            
                                            <div class="divide-y divide-gray-200">
                                                @forelse($oferta->candidatosAceptados ?? [] as $candidato)
                                                    <div class="py-3 flex justify-between items-center">
                                                        <div class="flex items-center space-x-3">
                                                            @if($candidato->imagen)
                                                                <img src="{{ asset('profile_images/' . $candidato->imagen) }}" alt="{{ $candidato->nombre }}" class="h-10 w-10 rounded-full object-cover border border-gray-200 shadow-sm" onerror="this.onerror=null; this.src='data:image/svg+xml;utf8,<?xml version=\'1.0\' encoding=\'UTF-8\'?><svg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 100 100\' width=\'40\' height=\'40\'><rect width=\'100\' height=\'100\' fill=\'%236366F1\'/><text x=\'50\' y=\'50\' font-size=\'35\' fill=\'white\' text-anchor=\'middle\' dominant-baseline=\'middle\'>{{ substr($candidato->nombre, 0, 1) }}{{ isset(explode(" ", $candidato->nombre)[1]) ? substr(explode(" ", $candidato->nombre)[1], 0, 1) : "" }}</text></svg>';">
                                                            @else
                                                                <div class="h-10 w-10 rounded-full bg-gradient-to-br from-indigo-500 to-purple-500 flex items-center justify-center text-white font-bold text-lg shadow-sm">
                                                                    {{ substr($candidato->nombre, 0, 1) }}{{ isset(explode(" ", $candidato->nombre)[1]) ? substr(explode(" ", $candidato->nombre)[1], 0, 1) : "" }}
                                                                </div>
                                                            @endif
                                                            
                                                            <div>
                                                                <h5 class="text-sm font-medium text-gray-900">{{ $candidato->nombre }}</h5>
                                                                <p class="text-xs text-gray-500">{{ $candidato->email }}</p>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="flex space-x-2">
                                                            @php
                                                                $convenio = \App\Models\Convenio::where('oferta_id', $oferta->id)
                                                                    ->where('estudiante_id', $candidato->id)
                                                                    ->first();
                                                            @endphp
                                                            
                                                            @if($convenio)
                                                                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium {{ $convenio->estado == 'activo' ? 'bg-green-100 text-green-800' : 'bg-amber-100 text-amber-800' }}">
                                                                    Convenio {{ ucfirst($convenio->estado) }}
                                                                </span>
                                                                <a href="{{ route('empresa.convenios.show', $convenio->id) }}" class="inline-flex items-center px-2.5 py-1 border border-gray-300 rounded-md text-xs font-medium text-gray-700 bg-white hover:bg-gray-50 transition-all duration-300">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                                    </svg>
                                                                    Ver convenio
                                                                </a>
                                                            @else
                                                                <button onclick="crearConvenio({{ $oferta->id }}, {{ $candidato->id }})" class="inline-flex items-center px-3 py-1 border border-transparent rounded-md shadow-sm text-xs font-medium text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-300">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                                                    </svg>
                                                                    Crear Convenio
                                                                </button>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @empty
                                                    <div class="py-4 text-center text-sm text-gray-500">
                                                        No hay candidatos aceptados para esta oferta.
                                                    </div>
                                                @endforelse
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-8 text-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        <h3 class="text-lg font-medium text-gray-900 mb-2">No hay ofertas con candidatos aceptados</h3>
                                        <p class="text-gray-500 max-w-md mx-auto mb-6">
                                            Cuando aceptes candidatos para tus ofertas, podrás crear convenios de prácticas con ellos desde aquí.
                                        </p>
                                        <a href="{{ route('empresa.offers.active') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 transition-all duration-300">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                            </svg>
                                            Ver mis ofertas activas
                                        </a>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <!-- Sección de Convenios Existentes -->
                    <div>
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-xl font-semibold text-gray-800 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Convenios Existentes
                            </h2>
                        </div>
                        
                        <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-200">
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200" id="conveniosTable">
                                    <thead class="bg-gradient-to-r from-gray-50 to-indigo-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Estudiante
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Oferta
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Fecha Inicio
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Fecha Fin
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Estado
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Acciones
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @forelse($convenios ?? [] as $convenio)
                                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="flex items-center">
                                                        <div class="flex-shrink-0 h-10 w-10">
                                                            @if($convenio->estudiante->imagen)
                                                                <img src="{{ asset('profile_images/' . $convenio->estudiante->imagen) }}" alt="{{ $convenio->estudiante->nombre }}" class="h-10 w-10 rounded-full object-cover shadow-sm" onerror="this.onerror=null; this.src='data:image/svg+xml;utf8,<?xml version=\'1.0\' encoding=\'UTF-8\'?><svg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 100 100\' width=\'40\' height=\'40\'><rect width=\'100\' height=\'100\' fill=\'%236366F1\'/><text x=\'50\' y=\'50\' font-size=\'35\' fill=\'white\' text-anchor=\'middle\' dominant-baseline=\'middle\'>{{ substr($convenio->estudiante->nombre, 0, 1) }}{{ isset(explode(" ", $convenio->estudiante->nombre)[1]) ? substr(explode(" ", $convenio->estudiante->nombre)[1], 0, 1) : "" }}</text></svg>';">
                                                            @else
                                                                <div class="h-10 w-10 rounded-full bg-gradient-to-br from-indigo-500 to-purple-500 flex items-center justify-center text-white font-bold shadow-sm">
                                                                    {{ substr($convenio->estudiante->nombre, 0, 1) }}{{ isset(explode(" ", $convenio->estudiante->nombre)[1]) ? substr(explode(" ", $convenio->estudiante->nombre)[1], 0, 1) : "" }}
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div class="ml-4">
                                                            <div class="text-sm font-medium text-gray-900">
                                                                {{ $convenio->estudiante->nombre }}
                                                            </div>
                                                            <div class="text-sm text-gray-500">
                                                                {{ $convenio->estudiante->email }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm text-gray-900 font-medium">{{ $convenio->oferta->titulo }}</div>
                                                    <div class="text-xs text-gray-500">{{ \Illuminate\Support\Str::limit($convenio->oferta->descripcion, 50) }}</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $convenio->fecha_inicio ? \Carbon\Carbon::parse($convenio->fecha_inicio)->format('d/m/Y') : 'Pendiente' }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $convenio->fecha_fin ? \Carbon\Carbon::parse($convenio->fecha_fin)->format('d/m/Y') : 'Pendiente' }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                        {{ $convenio->estado == 'activo' ? 'bg-green-100 text-green-800' : 
                                                          ($convenio->estado == 'pendiente' ? 'bg-yellow-100 text-yellow-800' : 
                                                          'bg-gray-100 text-gray-800') }}">
                                                        {{ ucfirst($convenio->estado) }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                    <div class="flex items-center space-x-2">
                                                        <a href="{{ route('empresa.convenios.show', $convenio->id) }}" class="text-indigo-600 hover:text-indigo-900">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" data-tippy-content="Ver detalles">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                            </svg>
                                                        </a>
                                                        <a href="{{ route('empresa.convenios.edit', $convenio->id) }}" class="text-amber-600 hover:text-amber-900">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" data-tippy-content="Editar convenio">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                            </svg>
                                                        </a>
                                                        <a href="{{ route('empresa.convenios.download', $convenio->id) }}" class="text-green-600 hover:text-green-900">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" data-tippy-content="Descargar PDF">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                                            </svg>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                                    No hay convenios registrados.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            
                            <!-- Pagination Container -->
                            <div id="conveniosPagination" class="mt-4 mb-6 py-2">
                                @if(isset($convenios) && method_exists($convenios, 'links'))
                                    <div class="px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6 bg-gradient-to-r from-gray-50 to-indigo-50 rounded-lg shadow-sm">
                                        <div class="flex-1 flex justify-between sm:hidden">
                                            @if($convenios->onFirstPage())
                                                <button disabled class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white opacity-50 cursor-not-allowed">
                                                    Anterior
                                                </button>
                                            @else
                                                <a href="{{ $convenios->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                                    Anterior
                                                </a>
                                            @endif
                                            
                                            @if(!$convenios->hasMorePages())
                                                <button disabled class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white opacity-50 cursor-not-allowed">
                                                    Siguiente
                                                </button>
                                            @else
                                                <a href="{{ $convenios->nextPageUrl() }}" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                                    Siguiente
                                                </a>
                                            @endif
                                        </div>
                                        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                                            <div>
                                                <p class="text-sm text-gray-700">
                                                    Mostrando
                                                    <span class="font-medium">{{ $convenios->firstItem() ?? 0 }}</span>
                                                    a
                                                    <span class="font-medium">{{ $convenios->lastItem() ?? 0 }}</span>
                                                    de
                                                    <span class="font-medium">{{ $convenios->total() }}</span>
                                                    resultados
                                                </p>
                                            </div>
                                            <div class="flex items-center">
                                                <select id="perPageSelector" class="mr-4 bg-white border border-gray-300 rounded-md shadow-sm py-1 px-3 text-sm text-gray-700 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                                    <option value="10" {{ $convenios->perPage() == 10 ? 'selected' : '' }}>10 por página</option>
                                                    <option value="20" {{ $convenios->perPage() == 20 ? 'selected' : '' }}>20 por página</option>
                                                    <option value="50" {{ $convenios->perPage() == 50 ? 'selected' : '' }}>50 por página</option>
                                                    <option value="100" {{ $convenios->perPage() == 100 ? 'selected' : '' }}>100 por página</option>
                                                </select>
                                                <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                                                    <!-- Previous Page -->
                                                    @if($convenios->onFirstPage())
                                                        <button disabled class="relative inline-flex items-center px-3 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-400 opacity-50 cursor-not-allowed">
                                                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                                            </svg>
                                                            <span class="ml-1">Anterior</span>
                                                        </button>
                                                    @else
                                                        <a href="{{ $convenios->previousPageUrl() }}" class="relative inline-flex items-center px-3 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-indigo-600 hover:bg-indigo-50 transition-colors duration-150">
                                                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                                            </svg>
                                                            <span class="ml-1">Anterior</span>
                                                        </a>
                                                    @endif
                                
                                                    <!-- Numbered Pages -->
                                                    @php
                                                        $start = max(1, $convenios->currentPage() - 1);
                                                        $end = min($convenios->lastPage(), $convenios->currentPage() + 1);
                                                    @endphp
                                
                                                    @if($start > 1)
                                                        <a href="{{ $convenios->url(1) }}" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors duration-150">
                                                            1
                                                        </a>
                                                        @if($start > 2)
                                                            <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700">
                                                                ...
                                                            </span>
                                                        @endif
                                                    @endif
                                
                                                    @for($i = $start; $i <= $end; $i++)
                                                        @if($i == $convenios->currentPage())
                                                            <span class="relative inline-flex items-center px-4 py-2 border border-indigo-500 bg-indigo-50 text-sm font-bold text-indigo-600">
                                                                {{ $i }}
                                                            </span>
                                                        @else
                                                            <a href="{{ $convenios->url($i) }}" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors duration-150">
                                                                {{ $i }}
                                                            </a>
                                                        @endif
                                                    @endfor
                                
                                                    @if($end < $convenios->lastPage())
                                                        @if($end < $convenios->lastPage() - 1)
                                                            <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700">
                                                                ...
                                                            </span>
                                                        @endif
                                                        <a href="{{ $convenios->url($convenios->lastPage()) }}" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors duration-150">
                                                            {{ $convenios->lastPage() }}
                                                        </a>
                                                    @endif
                                
                                                    <!-- Next Page -->
                                                    @if($convenios->hasMorePages())
                                                        <a href="{{ $convenios->nextPageUrl() }}" class="relative inline-flex items-center px-3 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-indigo-600 hover:bg-indigo-50 transition-colors duration-150">
                                                            <span class="mr-1">Siguiente</span>
                                                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                                            </svg>
                                                        </a>
                                                    @else
                                                        <button disabled class="relative inline-flex items-center px-3 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-400 opacity-50 cursor-not-allowed">
                                                            <span class="mr-1">Siguiente</span>
                                                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                                            </svg>
                                                        </button>
                                                    @endif
                                                </nav>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Creación de Convenio -->
<div id="modalConvenio" class="fixed inset-0 bg-black bg-opacity-50 hidden overflow-y-auto h-full w-full z-50 backdrop-blur-sm transition-all duration-300">
    <div class="relative top-20 mx-auto p-0 w-full max-w-2xl transform transition-all duration-300">
        <div class="bg-white rounded-xl shadow-2xl overflow-hidden">
            <div class="bg-gradient-to-r from-purple-600 to-indigo-600 py-4 px-6 flex justify-between items-center">
                <h3 class="text-xl font-bold text-white flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Crear Nuevo Convenio
                </h3>
                <button onclick="cerrarModalConvenio()" class="text-white hover:text-gray-200 focus:outline-none transition-colors">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <form id="formConvenio" class="p-6">
                @csrf
                <input type="hidden" id="oferta_id" name="oferta_id">
                <input type="hidden" id="estudiante_id" name="estudiante_id">

                <!-- Información del Convenio -->
                <div class="mb-6">
                    <h4 class="text-md font-medium text-gray-800 mb-3 flex items-center">
                        <div class="w-8 h-8 flex items-center justify-center bg-purple-100 rounded-full mr-2 text-purple-600">1</div>
                        Detalles del Convenio
                    </h4>
                    <div class="bg-gray-50 p-4 rounded-lg space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="fecha_inicio" class="block text-sm font-medium text-gray-700 mb-1">Fecha de inicio *</label>
                                <input type="date" name="fecha_inicio" id="fecha_inicio" required
                                       class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 text-sm transition-all">
                            </div>
                            <div>
                                <label for="fecha_fin" class="block text-sm font-medium text-gray-700 mb-1">Fecha de finalización *</label>
                                <input type="date" name="fecha_fin" id="fecha_fin" required
                                       class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 text-sm transition-all">
                            </div>
                        </div>

                        <div>
                            <label for="horario_practica" class="block text-sm font-medium text-gray-700 mb-1">Horario de prácticas *</label>
                            <select name="horario_practica" id="horario_practica" required
                                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 text-sm transition-all">
                                <option value="">Seleccionar horario</option>
                                <option value="mañana">Mañana (9:00 - 14:00)</option>
                                <option value="tarde">Tarde (15:00 - 20:00)</option>
                                <option value="flexible">Flexible (A convenir)</option>
                            </select>
                        </div>

                        <div>
                            <label for="tutor_empresa" class="block text-sm font-medium text-gray-700 mb-1">Tutor de empresa *</label>
                            <input type="text" name="tutor_empresa" id="tutor_empresa" required
                                   class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 text-sm transition-all">
                        </div>
                    </div>
                </div>

                <!-- Tareas y Objetivos -->
                <div class="mb-6">
                    <h4 class="text-md font-medium text-gray-800 mb-3 flex items-center">
                        <div class="w-8 h-8 flex items-center justify-center bg-purple-100 rounded-full mr-2 text-purple-600">2</div>
                        Tareas y Objetivos
                    </h4>
                    <div class="bg-gray-50 p-4 rounded-lg space-y-4">
                        <div>
                            <label for="tareas" class="block text-sm font-medium text-gray-700 mb-1">Descripción de las tareas *</label>
                            <textarea name="tareas" id="tareas" rows="3" required
                                      class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 text-sm transition-all"></textarea>
                            <p class="mt-1 text-xs text-gray-500">Detalla las tareas que realizará el estudiante durante sus prácticas</p>
                        </div>

                        <div>
                            <label for="objetivos" class="block text-sm font-medium text-gray-700 mb-1">Objetivos formativos *</label>
                            <textarea name="objetivos" id="objetivos" rows="3" required
                                      class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 text-sm transition-all"></textarea>
                            <p class="mt-1 text-xs text-gray-500">Describe los conocimientos y habilidades que adquirirá el estudiante</p>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end space-x-3 pt-4 border-t">
                    <button type="button" onclick="cerrarModalConvenio()"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-all">
                        Cancelar
                    </button>
                    <button type="submit" id="submitConvenioButton"
                            class="px-4 py-2 text-sm font-medium text-white bg-gradient-to-r from-purple-600 to-indigo-600 border border-transparent rounded-lg hover:from-purple-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-all shadow-lg">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Crear Convenio
                        </div>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Sweet Alert -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-material-ui@5/material-ui.min.css">
<link rel="stylesheet" href="https://unpkg.com/tippy.js@6/dist/tippy.css" />

<!-- Mensaje de no resultados -->
<div id="noResultsMessage" class="hidden">
    <div class="bg-white border border-gray-200 rounded-lg p-8 text-center mb-8">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
        </svg>
        <h3 class="text-lg font-medium text-gray-900 mb-2">No se encontraron resultados</h3>
        <p class="text-gray-500 max-w-md mx-auto mb-6">
            No hay convenios ni ofertas que coincidan con tu búsqueda. Intenta con otros términos o limpia los filtros.
        </p>
        <button id="resetFiltersButton" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 transition-all duration-300">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
            </svg>
            Limpiar filtros
        </button>
    </div>
</div>

<style>
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .animate-fadeIn {
        animation: fadeIn 0.3s ease-out forwards;
    }
    
    /* Add hover effects to buttons */
    button, a.inline-flex {
        transition: all 0.3s !important;
    }
    
    button:hover, a.inline-flex:hover {
        transform: translateY(-1px) !important;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06) !important;
    }
    
    /* Improve focus states */
    button:focus, a:focus, input:focus, select:focus, textarea:focus {
        outline: none !important;
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.3) !important;
    }
    
    /* Add a subtle hover effect to table rows */
    tr:hover {
        background-color: rgba(99, 102, 241, 0.04) !important;
    }
    
    /* Badge animations */
    .rounded-full {
        transition: all 0.3s !important;
    }
    
    .rounded-full:hover {
        transform: scale(1.05) !important;
    }
</style>

<!-- Inline script to ensure global function availability -->
<script>
    // Make sure the function is available in the global scope
    if (typeof crearConvenio !== 'function') {
        console.log('Ensuring global crearConvenio function');
        window.crearConvenio = function(ofertaId, estudianteId) {
            if (typeof Swal === 'undefined') {
                console.error('SweetAlert2 not loaded yet');
                alert('Please wait for the page to fully load and try again.');
                return;
            }
            // Show the Swal dialog
            Swal.fire({
                title: 'Nuevo Convenio',
                html: `
                <form id="createConvenioForm" class="text-left">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Fecha de inicio</label>
                        <input type="date" id="fecha_inicio" name="fecha_inicio" class="swal-input w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Fecha de fin</label>
                        <input type="date" id="fecha_fin" name="fecha_fin" class="swal-input w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Horario</label>
                        <select id="horario_practica" name="horario_practica" class="swal-input w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            <option value="">Seleccione un horario</option>
                            <option value="mañana">Mañana (9:00 - 14:00)</option>
                            <option value="tarde">Tarde (15:00 - 20:00)</option>
                            <option value="flexible">Flexible (A convenir)</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tutor de empresa</label>
                        <input type="text" id="tutor_empresa" name="tutor_empresa" class="swal-input w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tareas a realizar</label>
                        <textarea id="tareas" name="tareas" rows="3" class="swal-input w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required></textarea>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Objetivos formativos</label>
                        <textarea id="objetivos" name="objetivos" rows="3" class="swal-input w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required></textarea>
                    </div>
                </form>
                `,
                showCancelButton: true,
                confirmButtonText: 'Crear Convenio',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: '#6366f1',
                focusConfirm: false,
                customClass: {
                    popup: 'rounded-lg',
                },
                didOpen: () => {
                    // Set min date for fecha_inicio to today when the dialog opens
                    const today = new Date().toISOString().split('T')[0];
                    const fechaInicio = document.getElementById('fecha_inicio');
                    if (fechaInicio) {
                        fechaInicio.min = today;
                        fechaInicio.addEventListener('change', function() {
                            const fechaFin = document.getElementById('fecha_fin');
                            if (fechaFin) {
                                fechaFin.min = this.value;
                            }
                        });
                    }
                },
                preConfirm: () => {
                    // Get the form values directly using querySelector with class (more reliable in SweetAlert2)
                    const formData = {
                        oferta_id: ofertaId,
                        estudiante_id: estudianteId,
                        empresa_id: {{ Auth::id() }}, // Add empresa_id from the authenticated user
                        fecha_inicio: document.querySelector('.swal2-container #fecha_inicio').value,
                        fecha_fin: document.querySelector('.swal2-container #fecha_fin').value,
                        horario_practica: document.querySelector('.swal2-container #horario_practica').value,
                        tutor_empresa: document.querySelector('.swal2-container #tutor_empresa').value,
                        tareas: document.querySelector('.swal2-container #tareas').value,
                        objetivos: document.querySelector('.swal2-container #objetivos').value
                    };
                    
                    console.log('Direct form values:', formData);
                    
                    // Validate the data
                    let isValid = true;
                    let errorMessages = [];
                    
                    // Check required fields
                    if (!formData.fecha_inicio) {
                        isValid = false;
                        document.querySelector('.swal2-container #fecha_inicio').classList.add('border-red-500');
                        errorMessages.push('Fecha de inicio es obligatorio');
                    }
                    
                    if (!formData.fecha_fin) {
                        isValid = false;
                        document.querySelector('.swal2-container #fecha_fin').classList.add('border-red-500');
                        errorMessages.push('Fecha de fin es obligatorio');
                    }
                    
                    if (!formData.horario_practica) {
                        isValid = false;
                        document.querySelector('.swal2-container #horario_practica').classList.add('border-red-500');
                        errorMessages.push('Horario es obligatorio');
                    }
                    
                    if (!formData.tutor_empresa) {
                        isValid = false;
                        document.querySelector('.swal2-container #tutor_empresa').classList.add('border-red-500');
                        errorMessages.push('Tutor de empresa es obligatorio');
                    }
                    
                    if (!formData.tareas) {
                        isValid = false;
                        document.querySelector('.swal2-container #tareas').classList.add('border-red-500');
                        errorMessages.push('Tareas a realizar es obligatorio');
                    }
                    
                    if (!formData.objetivos) {
                        isValid = false;
                        document.querySelector('.swal2-container #objetivos').classList.add('border-red-500');
                        errorMessages.push('Objetivos formativos es obligatorio');
                    }
                    
                    // Date validation
                    if (formData.fecha_inicio && formData.fecha_fin) {
                        const inicio = new Date(formData.fecha_inicio);
                        const fin = new Date(formData.fecha_fin);
                        const today = new Date();
                        today.setHours(0, 0, 0, 0);
                        
                        // Check if fecha_fin is after fecha_inicio
                        if (inicio >= fin) {
                            isValid = false;
                            document.querySelector('.swal2-container #fecha_fin').classList.add('border-red-500');
                            errorMessages.push('La fecha de finalización debe ser posterior a la fecha de inicio');
                        }
                        
                        // Check if fecha_inicio is not in the past
                        if (inicio < today) {
                            isValid = false;
                            document.querySelector('.swal2-container #fecha_inicio').classList.add('border-red-500');
                            errorMessages.push('La fecha de inicio no puede ser en el pasado');
                        }
                    }
                    
                    console.log('Form validation result:', isValid ? 'Valid' : 'Invalid', formData);
                    
                    if (!isValid) {
                        let validationMessage = 'Por favor, corrige los siguientes errores:';
                        if (errorMessages.length > 0) {
                            validationMessage += '<ul class="mt-2 text-left">';
                            errorMessages.forEach(msg => {
                                validationMessage += `<li class="mt-1">• ${msg}</li>`;
                            });
                            validationMessage += '</ul>';
                        }
                        Swal.showValidationMessage(validationMessage);
                        return false;
                    }
                    
                    return formData;
                }
            }).then((result) => {
                if (result.isConfirmed && result.value) {
                    // Show loading indicator
                    Swal.fire({
                        title: 'Creando convenio...',
                        text: 'Por favor espera',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    
                    // Add CSRF token
                    const formData = {
                        ...result.value,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    };
                    
                    console.log('Sending data to server:', formData);
                    
                    // Send data to server
                    $.ajax({
                        url: '/empresa/convenios',
                        type: 'POST',
                        data: formData,
                        success: function(data) {
                            if (data.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: '¡Éxito!',
                                    text: data.message || 'Convenio creado correctamente',
                                    confirmButtonColor: '#6366f1',
                                    showCloseButton: true,
                                    confirmButtonText: 'Descargar PDF',
                                    footer: '<div class="text-center w-full">El PDF se descargará automáticamente en unos segundos</div>'
                                }).then(() => {
                                    // Reload page
                                    window.location.reload();
                                });
                                
                                // Automatic PDF download
                                if (data.pdf_url) {
                                    // Create a hidden iframe to trigger the download
                                    const iframe = document.createElement('iframe');
                                    iframe.style.display = 'none';
                                    iframe.src = data.pdf_url;
                                    document.body.appendChild(iframe);
                                    
                                    // Also open a new window for viewing
                                    setTimeout(() => {
                                        // Remove iframe after a delay
                                        document.body.removeChild(iframe);
                                    }, 5000);
                                }
                            } else {
                                throw new Error(data.message || 'Error al crear el convenio');
                            }
                        },
                        error: function(xhr, status, error) {
                            let errorMessage = 'Ha ocurrido un error al crear el convenio';
                            
                            // Check if we have validation errors
                            if (xhr.responseJSON && xhr.responseJSON.errors) {
                                errorMessage = '<ul class="text-left">';
                                Object.keys(xhr.responseJSON.errors).forEach(function(key) {
                                    errorMessage += '<li class="mt-1">' + xhr.responseJSON.errors[key][0] + '</li>';
                                });
                                errorMessage += '</ul>';
                            } else if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMessage = xhr.responseJSON.message;
                            }
                            
                            Swal.fire({
                                icon: 'error',
                                title: 'Error de validación',
                                html: errorMessage,
                                confirmButtonColor: '#6366f1'
                            });
                            
                            console.log('Error response:', xhr.responseJSON);
                        }
                    });
                }
            });
        };
    }
</script>
@endsection 