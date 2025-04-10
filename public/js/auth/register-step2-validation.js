document.addEventListener('DOMContentLoaded', function() {
    // Check if we're on the student registration form
    const registerStudentForm = document.getElementById('registerStudentForm');
    
    // Check if we're on the company registration form
    const registerCompanyForm = document.getElementById('registerCompanyForm');
    
    // Handle student registration form validation
    if (registerStudentForm) {
        registerStudentForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Clear previous errors
            clearErrors();
            
            // Get form fields
            const password = document.getElementById('password');
            const passwordConfirm = document.getElementById('password-confirm');
            const centroEstudios = document.getElementById('centro_estudios');
            let isValid = true;
            
            // Validate password
            if (!password.value.trim()) {
                showError(password, 'La contraseña es requerida');
                isValid = false;
            } else if (password.value.trim().length < 8) {
                showError(password, 'La contraseña debe tener al menos 8 caracteres');
                isValid = false;
            } else if (!hasNumber(password.value.trim())) {
                showError(password, 'La contraseña debe contener al menos un número');
                isValid = false;
            }
            
            // Validate password confirmation
            if (!passwordConfirm.value.trim()) {
                showError(passwordConfirm, 'Por favor confirme su contraseña');
                isValid = false;
            } else if (password.value !== passwordConfirm.value) {
                showError(passwordConfirm, 'Las contraseñas no coinciden');
                isValid = false;
            }
            
            // Validate centro de estudios
            if (!centroEstudios.value.trim()) {
                showError(centroEstudios, 'El centro de estudios es requerido');
                isValid = false;
            }
            
            // Submit the form if valid
            if (isValid) {
                this.submit();
            }
        });
    }
    
    // Handle company registration form validation
    if (registerCompanyForm) {
        registerCompanyForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Clear previous errors
            clearErrors();
            
            // Get form fields
            const password = document.getElementById('password');
            const passwordConfirm = document.getElementById('password-confirm');
            const cif = document.getElementById('cif');
            const direccion = document.getElementById('direccion');
            const provincia = document.getElementById('provincia');
            let isValid = true;
            
            // Validate password
            if (!password.value.trim()) {
                showError(password, 'La contraseña es requerida');
                isValid = false;
            } else if (password.value.trim().length < 8) {
                showError(password, 'La contraseña debe tener al menos 8 caracteres');
                isValid = false;
            } else if (!hasNumber(password.value.trim())) {
                showError(password, 'La contraseña debe contener al menos un número');
                isValid = false;
            }
            
            // Validate password confirmation
            if (!passwordConfirm.value.trim()) {
                showError(passwordConfirm, 'Por favor confirme su contraseña');
                isValid = false;
            } else if (password.value !== passwordConfirm.value) {
                showError(passwordConfirm, 'Las contraseñas no coinciden');
                isValid = false;
            }
            
            // Validate CIF
            if (!cif.value.trim()) {
                showError(cif, 'El CIF es requerido');
                isValid = false;
            }
            
            // Validate direccion
            if (!direccion.value.trim()) {
                showError(direccion, 'La dirección es requerida');
                isValid = false;
            }
            
            // Validate provincia
            if (!provincia.value || provincia.value === '') {
                showError(provincia, 'La provincia es requerida');
                isValid = false;
            }
            
            // Submit the form if valid
            if (isValid) {
                this.submit();
            }
        });
    }
    
    function showError(input, message) {
        let formGroup;
        
        // For radios, use the container
        if (input.classList && input.classList.contains('mb-6')) {
            formGroup = input;
        } else {
            formGroup = input.closest('.mb-4') || input.closest('.mb-6');
        }
        
        if (!formGroup) return;
        
        // Add error class to input
        if (input.tagName === 'INPUT' || input.tagName === 'SELECT') {
            input.classList.add('border-red-500');
        }
        
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
    
    function hasNumber(password) {
        return /\d/.test(password);
    }
});
