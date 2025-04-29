document.addEventListener('DOMContentLoaded', function() {
    // Toggle para los filtros en móvil
    const toggleFilters = document.getElementById('toggleFilters');
    const filterContent = document.getElementById('filterContent');
    
    if (toggleFilters && filterContent) {
        toggleFilters.addEventListener('click', function() {
            filterContent.classList.toggle('hidden');
            const icon = toggleFilters.querySelector('i');
            if (icon.classList.contains('fa-chevron-down')) {
                icon.classList.replace('fa-chevron-down', 'fa-chevron-up');
            } else {
                icon.classList.replace('fa-chevron-up', 'fa-chevron-down');
            }
        });
    }
    
    // Traducir el texto de paginación
    function translatePagination() {
        const paginationText = document.querySelector('.pagination div:first-child p');
        if (paginationText) {
            const text = paginationText.textContent;
            // Extraer números del texto "Showing X to Y of Z results"
            const regex = /Showing\s+(\d+)\s+to\s+(\d+)\s+of\s+(\d+)\s+results/i;
            const match = regex.exec(text);
            
            if (match) {
                const from = match[1];
                const to = match[2];
                const total = match[3];
                
                // Añadir atributos de datos para el pseudo-elemento CSS
                paginationText.setAttribute('data-from', from);
                paginationText.setAttribute('data-to', to);
                paginationText.setAttribute('data-total', total);
            }
        }
    }
    
    // Llamar a la función al cargar la página
    translatePagination();
    
    // Cambio entre vista grid y lista
    const gridViewButton = document.getElementById('gridViewButton');
    const listViewButton = document.getElementById('listViewButton');
    const publicationsGrid = document.getElementById('publicationsGrid');
    const publicationsList = document.getElementById('publicationsList');
    
    if (gridViewButton && listViewButton) {
        gridViewButton.addEventListener('click', function() {
            publicationsGrid.classList.remove('hidden');
            publicationsList.classList.add('hidden');
            gridViewButton.classList.replace('bg-gray-200', 'bg-purple-600');
            gridViewButton.classList.replace('text-gray-600', 'text-white');
            listViewButton.classList.replace('bg-purple-600', 'bg-gray-200');
            listViewButton.classList.replace('text-white', 'text-gray-600');
            localStorage.setItem('preferredView', 'grid');
        });
        
        listViewButton.addEventListener('click', function() {
            publicationsGrid.classList.add('hidden');
            publicationsList.classList.remove('hidden');
            listViewButton.classList.replace('bg-gray-200', 'bg-purple-600');
            listViewButton.classList.replace('text-gray-600', 'text-white');
            gridViewButton.classList.replace('bg-purple-600', 'bg-gray-200');
            gridViewButton.classList.replace('text-white', 'text-gray-600');
            localStorage.setItem('preferredView', 'list');
        });
        
        // Restaurar vista preferida del usuario
        const preferredView = localStorage.getItem('preferredView');
        if (preferredView === 'list') {
            listViewButton.click();
        }
    }
    
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
    const clearFiltersButton = document.getElementById('clearFiltersButton');
    const horarioCheckboxes = document.querySelectorAll('input[name="horario[]"]');
    const categoriaCheckboxes = document.querySelectorAll('.categoria-checkbox');
    const subcategoriaCheckboxes = document.querySelectorAll('input[name="subcategoria[]"]');
    const fechaInicio = document.getElementById('fechaInicio');
    const fechaFin = document.getElementById('fechaFin');
    const route = searchForm ? searchForm.getAttribute('data-route') : '';
    const searchSpinner = document.getElementById('searchSpinner');
    const paginationContainer = document.querySelector('.pagination-container');

    // Mostrar/ocultar subcategorías al seleccionar una categoría
    categoriaCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const subcategoriasDiv = document.getElementById(`subcategorias-${this.value}`);
            if (subcategoriasDiv) {
                if (this.checked) {
                    subcategoriasDiv.classList.remove('hidden');
                } else {
                    subcategoriasDiv.classList.add('hidden');
                    // Desmarcar todas las subcategorías
                    const subcheckboxes = subcategoriasDiv.querySelectorAll('input[type="checkbox"]');
                    subcheckboxes.forEach(subcheck => {
                        subcheck.checked = false;
                    });
                }
            }
            fetchPublications();
        });
    });

    // Manejar la paginación con AJAX
    if (paginationContainer) {
        paginationContainer.addEventListener('click', function(e) {
            // Prevenir solo si es un enlace de paginación
            const target = e.target.closest('a[href]');
            if (target) {
                e.preventDefault();
                const pageUrl = target.getAttribute('href');
                
                // Mostrar spinner
                if (searchSpinner) searchSpinner.classList.remove('hidden');
                
                // Hacer la petición AJAX
                fetch(pageUrl, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.text())
                .then(html => {
                    updatePageContent(html);
                    // Traducir la paginación después de actualizar el contenido
                    translatePagination();
                })
                .catch(error => {
                    console.error('Error:', error);
                })
                .finally(() => {
                    // Ocultar spinner
                    if (searchSpinner) searchSpinner.classList.add('hidden');
                    
                    // Hacer scroll hacia arriba suavemente
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                });
            }
        });
    }

    const fetchPublications = () => {
        if (!searchForm) return;
        
        // Mostrar spinner
        if (searchSpinner) searchSpinner.classList.remove('hidden');
        
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

        fetch(`${route}?${params.toString()}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.text())
        .then(html => {
            updatePageContent(html);
            // Traducir la paginación después de actualizar el contenido
            translatePagination();
        })
        .catch(error => {
            console.error('Error:', error);
        })
        .finally(() => {
            // Ocultar spinner
            if (searchSpinner) searchSpinner.classList.add('hidden');
        });
    };
    
    // Función para actualizar el contenido de la página
    const updatePageContent = (html) => {
        const parser = new DOMParser();
        const doc = parser.parseFromString(html, 'text/html');
        
        // Actualizar ambas vistas
        const newGridContent = doc.querySelector('#publicationsGrid');
        const newListContent = doc.querySelector('#publicationsList');
        
        if (newGridContent) {
            document.querySelector('#publicationsGrid').innerHTML = newGridContent.innerHTML;
        }
        
        if (newListContent) {
            document.querySelector('#publicationsList').innerHTML = newListContent.innerHTML;
        } else {
            // Si no existe el elemento en la respuesta, actualizar con la estructura grid
            document.querySelector('#publicationsList').innerHTML = document.querySelector('#publicationsGrid').innerHTML;
        }
        
        // Actualizar contador de resultados
        const resultCountElement = document.querySelector('.text-gray-600 span.font-semibold');
        if (resultCountElement) {
            const newResultCount = doc.querySelector('.text-gray-600 span.font-semibold');
            if (newResultCount) {
                resultCountElement.textContent = newResultCount.textContent;
            }
        }
        
        // Actualizar paginación
        const paginationContainer = document.querySelector('.pagination-container');
        if (paginationContainer) {
            const newPagination = doc.querySelector('.pagination-container');
            if (newPagination) {
                paginationContainer.innerHTML = newPagination.innerHTML;
            }
        }
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
        resetAllFilters();
        fetchPublications();
    });
    
    clearFiltersButton && clearFiltersButton.addEventListener('click', function() {
        resetAllFilters();
        fetchPublications();
    });
    
    function resetAllFilters() {
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
    }

    horarioCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', fetchPublications);
    });

    subcategoriaCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', fetchPublications);
    });

    fechaInicio && fechaInicio.addEventListener('change', fetchPublications);
    fechaFin && fechaFin.addEventListener('change', fetchPublications);

    // Función para mostrar toast de notificaciones
    function showToast(message, type = 'info') {
        // Verificar si ya existe un toast para no duplicar
        const existingToast = document.querySelector('.toast-notification');
        if (existingToast) {
            existingToast.remove();
        }
        
        // Crear el toast
        const toast = document.createElement('div');
        toast.className = 'toast-notification fixed bottom-4 right-4 px-6 py-3 rounded-lg shadow-lg z-50 flex items-center';
        
        // Aplicar estilos según el tipo
        switch(type) {
            case 'success':
                toast.classList.add('bg-green-500', 'text-white');
                toast.innerHTML = `<i class="fas fa-check-circle mr-2"></i> ${message}`;
                break;
            case 'error':
                toast.classList.add('bg-red-500', 'text-white');
                toast.innerHTML = `<i class="fas fa-exclamation-circle mr-2"></i> ${message}`;
                break;
            case 'info':
            default:
                toast.classList.add('bg-blue-500', 'text-white');
                toast.innerHTML = `<i class="fas fa-info-circle mr-2"></i> ${message}`;
                break;
        }
        
        document.body.appendChild(toast);
        
        // Autocierre
        setTimeout(() => {
            toast.remove();
        }, 3000);
    }
}); 