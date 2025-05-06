document.addEventListener('DOMContentLoaded', function() {
    // Objeto global para almacenar el estado de validación de cada campo
    window.validationErrors = {};
    
    const registerForm = document.getElementById('studentRegisterForm');
    
    if (registerForm) {
        registerForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Obtenemos los elementos del formulario
            const name = document.getElementById('name');
            const surname = document.getElementById('surname');
            const dni = document.getElementById('dni');
            const phone = document.getElementById('phone');
            const birthday = document.getElementById('birthday');
            const city = document.getElementById('city');
            const email = document.getElementById('email');
            const password = document.getElementById('password');
            const passwordConfirmation = document.getElementById('password_confirmation');
            const educationalCenter = document.getElementById('educational_center');
            const title = document.getElementById('title');
            const socialSecurityNumber = document.getElementById('social_security_number');
            const cv = document.getElementById('cv');
            
            // Limpiamos el objeto de errores antes de validar
            window.validationErrors = {};
            
            // Validamos todos los campos
            validateName(name);
            validateSurname(surname);
            validateDNI(dni);
            validatePhone(phone);
            validateBirthday(birthday);
            validateCity(city);
            validateEmail(email);
            validatePassword(password);
            validatePasswordConfirmation(passwordConfirmation, password);
            validateEducationalCenter(educationalCenter);
            validateTitle(title);
            validateSocialSecurityNumber(socialSecurityNumber);
            if (cv && cv.files.length > 0) {
                validateCV(cv);
            }
            
            // Si no hay errores, enviamos el formulario
            if (Object.keys(window.validationErrors).length === 0) {
                this.submit();
            }
        });
        
        // Validación en tiempo real al perder el foco
        const inputs = [
            { element: document.getElementById('name'), validate: validateName },
            { element: document.getElementById('surname'), validate: validateSurname },
            { element: document.getElementById('dni'), validate: validateDNI },
            { element: document.getElementById('phone'), validate: validatePhone },
            { element: document.getElementById('birthday'), validate: validateBirthday },
            { element: document.getElementById('city'), validate: validateCity },
            { element: document.getElementById('email'), validate: validateEmail },
            { element: document.getElementById('password'), validate: validatePassword },
            { element: document.getElementById('password_confirmation'), validate: function(input) {
                const password = document.getElementById('password');
                return validatePasswordConfirmation(input, password);
            }},
            { element: document.getElementById('educational_center'), validate: validateEducationalCenter },
            { element: document.getElementById('title'), validate: validateTitle },
            { element: document.getElementById('social_security_number'), validate: validateSocialSecurityNumber },
            { element: document.getElementById('cv'), validate: validateCV }
        ];
        
        inputs.forEach(input => {
            if (input.element) {
                input.element.addEventListener('blur', function() {
                    input.validate(this);
                });
            }
        });
        
        // Validación del archivo CV cuando se selecciona
        const cvInput = document.getElementById('cv');
        if (cvInput) {
            cvInput.addEventListener('change', function() {
                validateCV(this);
            });
        }
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
            window.updateFieldStatus(input, false, 'El nombre es requerido');
            return false;
        }
        
        window.updateFieldStatus(input, true);
        return true;
    }
    
    function validateSurname(input) {
        if (!input.value.trim()) {
            window.updateFieldStatus(input, false, 'Los apellidos son requeridos');
            return false;
        }
        
        window.updateFieldStatus(input, true);
        return true;
    }
    
    function validateDNI(input) {
        const dniValue = input.value.trim();
        if (!dniValue) {
            window.updateFieldStatus(input, false, 'El DNI/NIE es requerido');
            return false;
        }
        
        // Validación de formato DNI/NIE
        const dniRegex = /^[0-9]{8}[A-Z]$|^[XYZ][0-9]{7}[A-Z]$/;
        if (!dniRegex.test(dniValue)) {
            window.updateFieldStatus(input, false, 'El formato del DNI/NIE no es válido');
            return false;
        }
        
        window.updateFieldStatus(input, true);
        return true;
    }
    
    function validatePhone(input) {
        const phoneValue = input.value.trim();
        if (!phoneValue) {
            window.updateFieldStatus(input, false, 'El teléfono es requerido');
            return false;
        }
        
        // Validación de formato de teléfono
        const phoneRegex = /^[0-9]{9}$/;
        if (!phoneRegex.test(phoneValue)) {
            window.updateFieldStatus(input, false, 'El teléfono debe tener 9 dígitos');
            return false;
        }
        
        window.updateFieldStatus(input, true);
        return true;
    }
    
    function validateBirthday(input) {
        if (!input.value) {
            window.updateFieldStatus(input, false, 'La fecha de nacimiento es requerida');
            return false;
        }
        
        // Validación de fecha de nacimiento
        const birthDate = new Date(input.value);
        const today = new Date();
        const age = today.getFullYear() - birthDate.getFullYear();
        
        if (age < 16) {
            window.updateFieldStatus(input, false, 'Debes tener al menos 16 años');
            return false;
        }
        
        window.updateFieldStatus(input, true);
        return true;
    }
    
    function validateCity(input) {
        if (!input.value.trim()) {
            window.updateFieldStatus(input, false, 'La ciudad es requerida');
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
    
    function validateEducationalCenter(input) {
        if (!input.value.trim()) {
            window.updateFieldStatus(input, false, 'El centro educativo es requerido');
            return false;
        }
        
        window.updateFieldStatus(input, true);
        return true;
    }
    
    function validateTitle(input) {
        if (!input.value.trim()) {
            window.updateFieldStatus(input, false, 'El título es requerido');
            return false;
        }
        
        window.updateFieldStatus(input, true);
        return true;
    }
    
    function validateSocialSecurityNumber(input) {
        const ssnValue = input.value.trim();
        if (!ssnValue) {
            window.updateFieldStatus(input, false, 'El número de seguridad social es requerido');
            return false;
        }
        
        // Validación de formato de número de seguridad social
        const ssnRegex = /^\d{12}$/;
        if (!ssnRegex.test(ssnValue)) {
            window.updateFieldStatus(input, false, 'El número de seguridad social debe tener 12 dígitos');
            return false;
        }
        
        window.updateFieldStatus(input, true);
        return true;
    }
    
    function validateCV(input) {
        if (!input.files || input.files.length === 0) {
            window.updateFieldStatus(input, false, 'Debes subir tu CV');
            return false;
        }
        
        const file = input.files[0];
        const validExtensions = ['pdf', 'doc', 'docx'];
        const fileExtension = file.name.split('.').pop().toLowerCase();
        
        // Validación de tipo de archivo
        if (!validExtensions.includes(fileExtension)) {
            window.updateFieldStatus(input, false, 'El CV debe ser un archivo PDF, DOC o DOCX');
            return false;
        }
        
        // Validación de tamaño de archivo (máximo 2MB)
        if (file.size > 2 * 1024 * 1024) {
            window.updateFieldStatus(input, false, 'El CV no debe exceder los 2MB');
            return false;
        }
        
        window.updateFieldStatus(input, true);
        return true;
    }
});
