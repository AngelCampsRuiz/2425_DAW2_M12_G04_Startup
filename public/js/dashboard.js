document.addEventListener('DOMContentLoaded', function() {
    let debounceTimer;
    const searchForm = document.getElementById('searchForm');
    const searchInput = document.getElementById('searchInput');
    const orderBy = document.getElementById('orderBy');
    const orderDirection = document.getElementById('orderDirection');
    const orderSelect = document.getElementById('orderSelect');
    const clearButton = document.getElementById('clearButton');
    const horarioCheckboxes = document.querySelectorAll('input[name="horario[]"]');
    const route = searchForm.getAttribute('data-route');

    const fetchPublications = () => {
        const searchTerm = searchInput.value;
        const orderByValue = orderBy.value;
        const orderDirectionValue = orderDirection.value;
        const selectedHorarios = Array.from(horarioCheckboxes)
            .filter(checkbox => checkbox.checked)
            .map(checkbox => checkbox.value);

        const params = new URLSearchParams();
        if (searchTerm) params.append('search', searchTerm);
        if (orderByValue) params.append('order_by', orderByValue);
        if (orderDirectionValue) params.append('order_direction', orderDirectionValue);
        selectedHorarios.forEach(horario => params.append('horario[]', horario));

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
        fetchPublications();
    });

    horarioCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', fetchPublications);
    });
}); 