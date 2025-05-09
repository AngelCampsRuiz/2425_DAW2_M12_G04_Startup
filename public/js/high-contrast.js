document.addEventListener('DOMContentLoaded', function() {
    const contrastToggle = document.getElementById('contrast-toggle');
    
    // Verificar si el modo alto contraste estaba activado
    const highContrastEnabled = localStorage.getItem('highContrast') === 'true';
    if (highContrastEnabled) {
        document.body.classList.add('high-contrast');
    }

    // Función para alternar el modo alto contraste
    contrastToggle?.addEventListener('click', function() {
        document.body.classList.toggle('high-contrast');
        const isEnabled = document.body.classList.contains('high-contrast');
        localStorage.setItem('highContrast', isEnabled);
    });
});
