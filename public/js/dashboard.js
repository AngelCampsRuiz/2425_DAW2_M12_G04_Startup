document.addEventListener('DOMContentLoaded', function() {
    let debounceTimer;
    const searchForm = document.getElementById('searchForm');
    const searchInput = document.getElementById('searchInput');
    const orderBy = document.getElementById('orderBy');
    const orderDirection = document.getElementById('orderDirection');
    const orderSelect = document.getElementById('orderSelect');
    const route = searchForm.getAttribute('data-route');

    searchInput.addEventListener('input', function(event) {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => {
            const searchTerm = event.target.value;
            const orderByValue = orderBy.value;
            const orderDirectionValue = orderDirection.value;
            fetch(`${route}?search=${searchTerm}&order_by=${orderByValue}&order_direction=${orderDirectionValue}`, {
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
        }, 300); // Ajusta el tiempo de debounce según sea necesario
    });

    orderSelect.addEventListener('change', function(event) {
        const url = new URL(event.target.value);
        orderBy.value = url.searchParams.get('order_by');
        orderDirection.value = url.searchParams.get('order_direction');
        searchInput.dispatchEvent(new Event('input'));
    });
}); 