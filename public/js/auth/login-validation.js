document.addEventListener('DOMContentLoaded', function() {
    // Objeto global para almacenar el estado de validación de cada campo
    window.validationErrors = {};
    
    const loginForm = document.getElementById('loginForm');
    
    if (loginForm) {
        loginForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Obtenemos los elementos del formulario
            const email = document.getElementById('email');
            const password = document.getElementById('password');
            
            // Limpiamos el objeto de errores antes de validar
            window.validationErrors = {};
            
            // Validamos el email
            validateEmail(email);
            
            // Validamos la contraseña
            validatePassword(password);
            
            // Si no hay errores, enviamos el formulario
            if (Object.keys(window.validationErrors).length === 0) {
                this.submit();
            }
        });
        
        // Validación en tiempo real al perder el foco
        const inputs = [
            { element: document.getElementById('email'), validate: validateEmail },
            { element: document.getElementById('password'), validate: validatePassword }
        ];
        
        inputs.forEach(input => {
            if (input.element) {
                input.element.addEventListener('blur', function() {
                    input.validate(this);
                });
            }
        });
    }
    
    // Función centralizada para actualizar el estado visual de los campos
    window.updateFieldStatus = function(input, isValid, errorMessage = '') {
        const formGroup = input.closest('.mb-4') || input.closest('.mb-6');
        if (!formGroup) return;
        
        const fieldId = input.id;
        
        if (!isValid) {
            // Guardamos el error en el objeto global
            window.validationErrors[fieldId] = errorMessage;
            
            // Añadimos la clase de error al input
            input.classList.add('border-red-500');
            
            // Creamos el elemento de error si no existe
            let errorElement = formGroup.querySelector('.text-red-500');
            if (!errorElement) {
                errorElement = document.createElement('span');
                errorElement.className = 'text-red-500 text-xs mt-1 block';
                errorElement.setAttribute('data-field', fieldId);
                formGroup.appendChild(errorElement);
            }
            
            errorElement.textContent = errorMessage;
        } else {
            // Eliminamos el error del objeto global
            delete window.validationErrors[fieldId];
            
            // Quitamos la clase de error
            input.classList.remove('border-red-500');
            
            // Eliminamos el mensaje de error si existe
            const errorElement = formGroup.querySelector('.text-red-500[data-field="' + fieldId + '"]');
            if (errorElement) {
                errorElement.remove();
            }
        }
    }
    
    // Funciones de validación individuales
    function validateEmail(input) {
        if (!input.value.trim()) {
            window.updateFieldStatus(input, false, 'El correo electrónico es requerido');
            return false;
        } else if (!isValidEmail(input.value.trim())) {
            window.updateFieldStatus(input, false, 'Ingrese un correo electrónico válido');
            return false;
        }
        
        window.updateFieldStatus(input, true);
        return true;
    }
    
    function validatePassword(input) {
        if (!input.value) {
            window.updateFieldStatus(input, false, 'La contraseña es requerida');
            return false;
        }
        
        window.updateFieldStatus(input, true);
        return true;
    }
    
    function isValidEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    }
});