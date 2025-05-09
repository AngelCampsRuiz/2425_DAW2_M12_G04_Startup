document.addEventListener('DOMContentLoaded', function() {
    const contrastToggle = document.getElementById('contrast-toggle');
    const moonIcon = contrastToggle.querySelector('.moon');
    const sunIcon = contrastToggle.querySelector('.sun');
    
    // Verificar si el modo oscuro estaba activado
    const highContrastEnabled = localStorage.getItem('highContrast') === 'true';
    if (highContrastEnabled) {
        document.body.classList.add('high-contrast');
        moonIcon.classList.add('hidden');
        sunIcon.classList.remove('hidden');
    }

    // Función para alternar el modo oscuro
    contrastToggle?.addEventListener('click', function() {
        document.body.classList.toggle('high-contrast');
        const isEnabled = document.body.classList.contains('high-contrast');
        localStorage.setItem('highContrast', isEnabled);

        // Cambiar el icono
        if (isEnabled) {
            moonIcon.classList.add('hidden');
            sunIcon.classList.remove('hidden');
        } else {
            moonIcon.classList.remove('hidden');
            sunIcon.classList.add('hidden');
        }
    });
});
