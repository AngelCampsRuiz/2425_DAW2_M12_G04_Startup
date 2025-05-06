document.addEventListener('DOMContentLoaded', function() {
    // Objeto global para almacenar el estado de validación de cada campo
    window.validationErrors = {};
    
    const registerForm = document.getElementById('companyRegisterForm');
    
    if (registerForm) {
        registerForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Obtenemos los elementos del formulario
            const name = document.getElementById('name');
            const email = document.getElementById('email');
            const cif = document.getElementById('cif');
            const password = document.getElementById('password');
            const passwordConfirmation = document.getElementById('password_confirmation');
            const province = document.getElementById('province');
            
            // Limpiamos el objeto de errores antes de validar
            window.validationErrors = {};
            
            // Validamos todos los campos
            validateName(name);
            validateEmail(email);
            validateCIF(cif);
            validatePassword(password);
            validatePasswordConfirmation(passwordConfirmation, password);
            validateProvince(province);
            
            // Si no hay errores, enviamos el formulario
            if (Object.keys(window.validationErrors).length === 0) {
                this.submit();
            }
        });
        
        // Validación en tiempo real al perder el foco
        const inputs = [
            { element: document.getElementById('name'), validate: validateName },
            { element: document.getElementById('email'), validate: validateEmail },
            { element: document.getElementById('cif'), validate: validateCIF },
            { element: document.getElementById('password'), validate: validatePassword },
            { element: document.getElementById('password_confirmation'), validate: function(input) {
                const password = document.getElementById('password');
                return validatePasswordConfirmation(input, password);
            }},
            { element: document.getElementById('province'), validate: validateProvince }
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
            let errorElement = formGroup.querySelector('.text-red-500[data-field="' + fieldId + '"]');
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
    function validateName(input) {
        if (!input.value.trim()) {
            window.updateFieldStatus(input, false, 'El nombre de la empresa es requerido');
            return false;
        }
        
        window.updateFieldStatus(input, true);
        return true;
    }
    
    function validateEmail(input) {
        const emailValue = input.value.trim();
        if (!emailValue) {
            window.updateFieldStatus(input, false, 'El correo electrónico es requerido');
            return false;
        }
        
        // Validación de formato de email
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(emailValue)) {
            window.updateFieldStatus(input, false, 'El formato del correo electrónico no es válido');
            return false;
        }
        
        window.updateFieldStatus(input, true);
        return true;
    }
    
    function validateCIF(input) {
        const cifValue = input.value.trim();
        if (!cifValue) {
            window.updateFieldStatus(input, false, 'El CIF es requerido');
            return false;
        }
        
        // Validación de formato CIF
        const cifRegex = /^[A-HJNPQRSUVW]{1}[0-9]{7}[0-9A-J]{1}$/;
        if (!cifRegex.test(cifValue)) {
            window.updateFieldStatus(input, false, 'El formato del CIF no es válido');
            return false;
        }
        
        window.updateFieldStatus(input, true);
        return true;
    }
    
    function validatePassword(input) {
        const passwordValue = input.value;
        if (!passwordValue) {
            window.updateFieldStatus(input, false, 'La contraseña es requerida');
            return false;
        }
        
        // Validación de longitud mínima
        if (passwordValue.length < 8) {
            window.updateFieldStatus(input, false, 'La contraseña debe tener al menos 8 caracteres');
            return false;
        }
        
        window.updateFieldStatus(input, true);
        return true;
    }
    
    function validatePasswordConfirmation(input, passwordInput) {
        if (!input.value) {
            window.updateFieldStatus(input, false, 'La confirmación de contraseña es requerida');
            return false;
        }
        
        // Validación de coincidencia con la contraseña
        if (input.value !== passwordInput.value) {
            window.updateFieldStatus(input, false, 'Las contraseñas no coinciden');
            return false;
        }
        
        window.updateFieldStatus(input, true);
        return true;
    }
    
    function validateProvince(input) {
        if (!input.value) {
            window.updateFieldStatus(input, false, 'La provincia es requerida');
            return false;
        }
        
        window.updateFieldStatus(input, true);
        return true;
    }
});
