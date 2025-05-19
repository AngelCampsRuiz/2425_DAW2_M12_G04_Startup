document.addEventListener('DOMContentLoaded', function() {
    // Si la validación personalizada está activa, no ejecutar este script
    if (window.customValidationActive) {
        return;
    }
    
    const registerForm = document.getElementById('registerForm');
    
    if (registerForm) {
        // Campos a validar
        const name = document.getElementById('name');
        const email = document.getElementById('email');
        
        // Elementos de error
        const nameError = document.getElementById('name-error');
        const emailError = document.getElementById('email-error');
        
        // Función para validar nombre
        window.validateName = function() {
            if (!name.value.trim()) {
                nameError.textContent = 'El nombre es obligatorio';
                name.classList.add('border-red-500');
                return false;
            } else if (name.value.trim().length < 3) {
                nameError.textContent = 'El nombre debe tener al menos 3 caracteres';
                name.classList.add('border-red-500');
                return false;
            } else {
                nameError.textContent = '';
                name.classList.remove('border-red-500');
                return true;
            }
        };
        
        // Función para validar email
        window.validateEmail = function() {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            
            if (!email.value.trim()) {
                emailError.textContent = 'El correo electrónico es obligatorio';
                email.classList.add('border-red-500');
                return false;
            } else if (!emailRegex.test(email.value)) {
                emailError.textContent = 'Introduce un correo electrónico válido';
                email.classList.add('border-red-500');
                return false;
            } else {
                emailError.textContent = '';
                email.classList.remove('border-red-500');
                return true;
            }
        };
        
        // Eventos onblur
        if (name) name.addEventListener('blur', window.validateName);
        if (email) email.addEventListener('blur', window.validateEmail);
        
        // Validación al enviar el formulario
        registerForm.addEventListener('submit', function(event) {
            const isNameValid = window.validateName();
            const isEmailValid = window.validateEmail();
            
            if (!isNameValid || !isEmailValid) {
                event.preventDefault();
            }
        });
    }
});