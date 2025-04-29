document.addEventListener('DOMContentLoaded', function() {
    // Selector de idioma en el footer
    const localeSelect = document.querySelector('select[name="locale"]');
    
    if (localeSelect) {
        localeSelect.addEventListener('change', function() {
            const form = document.getElementById('localeForm');
            const formData = new FormData(form);
            const select = this;

            // Deshabilitar el select mientras se procesa
            select.disabled = true;

            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                credentials: 'same-origin'
            }).then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log('Idioma cambiado a:', data.locale);
                    window.location.reload(true);
                }
            })
            .catch(error => {
                console.error('Error al cambiar el idioma:', error);
                select.disabled = false;
            });
        });
    }
}); 