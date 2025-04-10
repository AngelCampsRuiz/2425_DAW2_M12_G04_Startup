document.addEventListener('DOMContentLoaded', function() {
    const registerPersonalForm = document.getElementById('registerPersonalForm');
    
    if (registerPersonalForm) {
        registerPersonalForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Clear previous errors
            clearErrors();
            
            // Get form fields
            const fechaNacimiento = document.getElementById('fecha_nacimiento');
            const provincia = document.getElementById('provincia');
            const ciudad = document.getElementById('ciudad');
            const dni = document.getElementById('dni');
            const telefono = document.getElementById('telefono');
            let isValid = true;
            
            // Validate fecha_nacimiento
            if (!fechaNacimiento.value.trim()) {
                showError(fechaNacimiento, 'La fecha de nacimiento es requerida');
                isValid = false;
            } else {
                // Check if user is at least 16 years old
                const birthDate = new Date(fechaNacimiento.value);
                const today = new Date();
                const minAge = 16;
                
                // Calcular la fecha exacta de hace 16 años
                const minAgeDate = new Date(
                    today.getFullYear() - minAge,
                    today.getMonth(),
                    today.getDate()
                );
                
                if (birthDate > minAgeDate) {
                    showError(fechaNacimiento, 'Debes tener al menos 16 años para registrarte');
                    isValid = false;
                } else if (birthDate.getFullYear() < 1900) {
                    showError(fechaNacimiento, 'La fecha de nacimiento no es válida');
                    isValid = false;
                }
            }
            
            // Validate provincia
            if (!provincia.value.trim()) {
                showError(provincia, 'La provincia es requerida');
                isValid = false;
            }
            
            // Validate ciudad
            if (!ciudad.value.trim()) {
                showError(ciudad, 'La ciudad es requerida');
                isValid = false;
            }
            
            // Validate DNI/NIE
            if (!dni.value.trim()) {
                showError(dni, 'El DNI/NIE es requerido');
                isValid = false;
            } else if (!isValidDNI(dni.value.trim())) {
                showError(dni, 'El formato del DNI/NIE no es válido');
                isValid = false;
            }
            
            // Validate telefono
            if (!telefono.value.trim()) {
                showError(telefono, 'El teléfono es requerido');
                isValid = false;
            } else if (!isValidPhone(telefono.value.trim())) {
                showError(telefono, 'El formato del teléfono no es válido');
                isValid = false;
            }
            
            // Submit the form if valid
            if (isValid) {
                this.submit();
            }
        });
    }
    
    function showError(input, message) {
        let formGroup = input.closest('.mb-4') || input.closest('.mb-6');
        
        if (!formGroup) return;
        
        // Add error class to input
        input.classList.add('border-red-500');
        
        // Create error element if it doesn't exist
        let errorElement = formGroup.querySelector('.text-red-500');
        if (!errorElement) {
            errorElement = document.createElement('span');
            errorElement.className = 'text-red-500 text-xs mt-1 block';
            formGroup.appendChild(errorElement);
        }
        
        errorElement.textContent = message;
    }
    
    function clearErrors() {
        // Clear error styles
        document.querySelectorAll('.border-red-500').forEach(el => {
            el.classList.remove('border-red-500');
        });
        
        // Remove error messages
        document.querySelectorAll('.text-red-500').forEach(el => {
            if (el.tagName === 'SPAN') {
                el.remove();
            }
        });
    }
    
    function isValidDNI(dni) {
        // Simple validation for Spanish DNI (8 digits + letter) or NIE (letter + 7 digits + letter)
        return /^[0-9]{8}[A-Z]$/.test(dni) || /^[XYZ][0-9]{7}[A-Z]$/.test(dni);
    }
    
    function isValidPhone(phone) {
        // Simple validation for Spanish phone numbers
        return /^[6-9][0-9]{8}$/.test(phone);
    }
});
