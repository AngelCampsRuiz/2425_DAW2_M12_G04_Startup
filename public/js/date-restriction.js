document.addEventListener('DOMContentLoaded', function() {
    // Obtener el campo de fecha de nacimiento
    const fechaNacimientoInput = document.getElementById('fecha_nacimiento');
    
    if (fechaNacimientoInput) {
        // Calcular la fecha de hace 16 años desde hoy
        const today = new Date();
        const minAge = 16;
        const maxDate = new Date(
            today.getFullYear() - minAge,
            today.getMonth(),
            today.getDate()
        );
        
        // Formatear la fecha en formato YYYY-MM-DD para el atributo max
        const formattedMaxDate = maxDate.toISOString().split('T')[0];
        
        // Establecer el atributo max
        fechaNacimientoInput.setAttribute('max', formattedMaxDate);
        
        // Establecer un valor predeterminado si no hay uno
        if (!fechaNacimientoInput.value) {
            // Sugerir una fecha razonable (por ejemplo, 18 años)
            const suggestedDate = new Date(
                today.getFullYear() - 18,
                today.getMonth(),
                today.getDate()
            );
            const formattedSuggestedDate = suggestedDate.toISOString().split('T')[0];
            fechaNacimientoInput.value = formattedSuggestedDate;
        }
    }
});
