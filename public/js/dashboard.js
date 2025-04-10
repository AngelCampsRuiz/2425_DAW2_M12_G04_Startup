document.addEventListener('DOMContentLoaded', function() {
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
    const horasTotalesMin = document.getElementById('horasTotalesMin');
    const horasTotalesMax = document.getElementById('horasTotalesMax');
    const horasTotalesMinValue = document.getElementById('horasTotalesMinValue');
    const horasTotalesMaxValue = document.getElementById('horasTotalesMaxValue');
    const horasTotalesRange = document.getElementById('horasTotalesRange');
    const route = searchForm.getAttribute('data-route');
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

    const updateRange = () => {
        const minVal = parseInt(horasTotalesMin.value);
        const maxVal = parseInt(horasTotalesMax.value);
        const minMax = parseInt(horasTotalesMin.max);
        const minMin = parseInt(horasTotalesMin.min);
        const range = minMax - minMin;
        
        horasTotalesMinValue.textContent = minVal;
        horasTotalesMaxValue.textContent = maxVal;
        
        // Calcular porcentajes correctamente basados en el rango total
        const leftPercent = ((minVal - minMin) / range) * 100;
        const widthPercent = ((maxVal - minVal) / range) * 100;
        
        horasTotalesRange.style.left = `${leftPercent}%`;
        horasTotalesRange.style.width = `${widthPercent}%`;
    };

    // Mejorar manejo de eventos para el control deslizante mínimo
    horasTotalesMin.addEventListener('input', function() {
        // Limitar el valor mínimo para que no supere el máximo
        if (parseInt(horasTotalesMin.value) > parseInt(horasTotalesMax.value)) {
            horasTotalesMin.value = horasTotalesMax.value;
        }
        updateRange();
    });
    
    // Actualizar y buscar solo cuando se suelta el control deslizante
    horasTotalesMin.addEventListener('change', fetchPublications);

    // Mejorar manejo de eventos para el control deslizante máximo
    horasTotalesMax.addEventListener('input', function() {
        // Limitar el valor máximo para que no sea menor que el mínimo
        if (parseInt(horasTotalesMax.value) < parseInt(horasTotalesMin.value)) {
            horasTotalesMax.value = horasTotalesMin.value;
        }
        updateRange();
    });
    
    // Actualizar y buscar solo cuando se suelta el control deslizante
    horasTotalesMax.addEventListener('change', fetchPublications);

    const fetchPublications = () => {
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
        const favoritosValue = favoritosCheckbox.checked ? 'on' : 'off';

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
            const newContent = doc.querySelector('.grid').innerHTML;
            document.querySelector('.grid').innerHTML = newContent;
        });
    };

    searchInput.addEventListener('input', function() {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(fetchPublications, 300);
    });

    orderSelect.addEventListener('change', function(event) {
        const url = new URL(event.target.value);
        orderBy.value = url.searchParams.get('order_by');
        orderDirection.value = url.searchParams.get('order_direction');
        fetchPublications();
    });

    clearButton.addEventListener('click', function() {
        searchInput.value = '';
        orderBy.value = 'fecha_publicacion';
        orderDirection.value = 'desc';
        orderSelect.value = `${route}?order_by=fecha_publicacion&order_direction=desc`;
        horarioCheckboxes.forEach(checkbox => checkbox.checked = false);
        categoriaCheckboxes.forEach(checkbox => {
            checkbox.checked = false;
            const categoriaId = checkbox.value;
            const subcategoriasDiv = document.getElementById(`subcategorias-${categoriaId}`);
            subcategoriasDiv.classList.add('hidden');
            subcategoriasDiv.querySelectorAll('input[type="checkbox"]').forEach(subCheckbox => {
                subCheckbox.checked = false;
            });
        });
        fechaInicio.value = '';
        fechaFin.value = '';
        horasTotalesMin.value = horasTotalesMin.min;
        horasTotalesMax.value = horasTotalesMax.max;
        updateRange();
        fetchPublications();
    });

    horarioCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', fetchPublications);
    });

    subcategoriaCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', fetchPublications);
    });

    fechaInicio.addEventListener('change', fetchPublications);
    fechaFin.addEventListener('change', fetchPublications);

    favoritosCheckbox.addEventListener('change', fetchPublications);

    // Inicializar el rango
    updateRange();

    favoriteButtons.forEach(button => {
        button.addEventListener('click', function() {
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
}); 