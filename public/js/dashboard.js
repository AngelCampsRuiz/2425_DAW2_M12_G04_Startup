document.addEventListener('DOMContentLoaded', function() {
    let debounceTimer;
    const searchForm = document.getElementById('searchForm');
    const searchInput = document.getElementById('searchInput');
    const route = searchForm.getAttribute('data-route');

    searchInput.addEventListener('input', function(event) {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => {
            const searchTerm = event.target.value;
            fetch(`${route}?search=${searchTerm}`, {
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
}); 