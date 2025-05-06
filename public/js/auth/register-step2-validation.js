document.addEventListener('DOMContentLoaded', function() {
    // Check if we're on the student registration form
    const registerStudentForm = document.getElementById('registerStudentForm');
    
    // Check if we're on the company registration form
    const registerCompanyForm = document.getElementById('registerCompanyForm');
    
    // Handle student registration form validation
    if (registerStudentForm) {
        // Elementos de error
        const dniError = document.getElementById('dni-error');
        const telefonoError = document.getElementById('phone-error');
        const ciudadError = document.getElementById('city-error');
        const passwordError = document.getElementById('password-error');
        const passwordConfirmError = document.getElementById('password_confirmation-error');
        const centroError = document.getElementById('educational_center-error');
        const tituloError = document.getElementById('degree-error');
        const ssError = document.getElementById('social_security-error');
        const cvError = document.getElementById('cv-error');

        // Campos a validar
        const dni = document.getElementById('dni');
        const telefono = document.getElementById('phone');
        const ciudad = document.getElementById('city');
        const password = document.getElementById('password');
        const passwordConfirm = document.getElementById('password_confirmation');
        const centroEstudios = document.getElementById('educational_center');
        const titulo = document.getElementById('degree');
        const numeroSS = document.getElementById('social_security');
        const cvPdf = document.getElementById('cv');

        // Validación DNI
        window.validateDNI = function() {
            if (!dni || !dniError) return true;
            
            const dniRegex = /^[0-9]{8}[A-Za-z]$|^[XYZ][0-9]{7}[A-Za-z]$/;
            
            if (!dni.value.trim()) {
                dniError.textContent = 'El DNI/NIE es obligatorio';
                dni.classList.add('border-red-500');
                return false;
            } else if (!dniRegex.test(dni.value.trim())) {
                dniError.textContent = 'Introduce un DNI/NIE válido';
                dni.classList.add('border-red-500');
                return false;
            } else {
                dniError.textContent = '';
                dni.classList.remove('border-red-500');
                return true;
            }
        }
        
        // Validación teléfono
        window.validateTelefono = function() {
            if (!telefono || !telefonoError) return true;
            
            const telefonoRegex = /^[0-9]{9}$/;
            
            if (!telefono.value.trim()) {
                telefonoError.textContent = 'El teléfono es obligatorio';
                telefono.classList.add('border-red-500');
                return false;
            } else if (!telefonoRegex.test(telefono.value.trim())) {
                telefonoError.textContent = 'Introduce un teléfono válido (9 dígitos)';
                telefono.classList.add('border-red-500');
                return false;
            } else {
                telefonoError.textContent = '';
                telefono.classList.remove('border-red-500');
                return true;
            }
        }
        
        // Validación ciudad
        window.validateCiudad = function() {
            if (!ciudad || !ciudadError) return true;
            
            if (!ciudad.value.trim()) {
                ciudadError.textContent = 'La ciudad es obligatoria';
                ciudad.classList.add('border-red-500');
                return false;
            } else {
                ciudadError.textContent = '';
                ciudad.classList.remove('border-red-500');
                return true;
            }
        }
        
        // Validación contraseña
        window.validatePassword = function() {
            if (!password || !passwordError) return true;
            
            if (!password.value) {
                passwordError.textContent = 'La contraseña es obligatoria';
                password.classList.add('border-red-500');
                return false;
            } else if (password.value.length < 8) {
                passwordError.textContent = 'La contraseña debe tener al menos 8 caracteres';
                password.classList.add('border-red-500');
                return false;
            } else if (!hasNumber(password.value)) {
                passwordError.textContent = 'La contraseña debe contener al menos un número';
                password.classList.add('border-red-500');
                return false;
            } else {
                passwordError.textContent = '';
                password.classList.remove('border-red-500');
                return true;
            }
        }
        
        // Validación confirmación contraseña
        window.validatePasswordConfirm = function() {
            if (!passwordConfirm || !passwordConfirmError || !password) return true;
            
            if (!passwordConfirm.value) {
                passwordConfirmError.textContent = 'Confirma tu contraseña';
                passwordConfirm.classList.add('border-red-500');
                return false;
            } else if (passwordConfirm.value !== password.value) {
                passwordConfirmError.textContent = 'Las contraseñas no coinciden';
                passwordConfirm.classList.add('border-red-500');
                return false;
            } else {
                passwordConfirmError.textContent = '';
                passwordConfirm.classList.remove('border-red-500');
                return true;
            }
        }
        
        // Validación centro estudios
        window.validateCentroEstudios = function() {
            if (!centroEstudios || !centroError) return true;
            
            if (!centroEstudios.value.trim()) {
                centroError.textContent = 'El centro educativo es obligatorio';
                centroEstudios.classList.add('border-red-500');
                return false;
            } else {
                centroError.textContent = '';
                centroEstudios.classList.remove('border-red-500');
                return true;
            }
        }
        
        // Validación título
        window.validateTitulo = function() {
            if (!titulo || !tituloError) return true;
            
            if (!titulo.value) {
                tituloError.textContent = 'Selecciona un título';
                titulo.classList.add('border-red-500');
                return false;
            } else {
                tituloError.textContent = '';
                titulo.classList.remove('border-red-500');
                return true;
            }
        }
        
        // Validación número seguridad social
        window.validateSS = function() {
            if (!numeroSS || !ssError) return true;
            
            const ssRegex = /^SS[0-9]{8}$/;
            
            if (!numeroSS.value.trim()) {
                ssError.textContent = 'El número de seguridad social es obligatorio';
                numeroSS.classList.add('border-red-500');
                return false;
            } else if (!ssRegex.test(numeroSS.value.trim())) {
                ssError.textContent = 'Formato válido: SS seguido de 8 dígitos';
                numeroSS.classList.add('border-red-500');
                return false;
            } else {
                ssError.textContent = '';
                numeroSS.classList.remove('border-red-500');
                return true;
            }
        }
        
        // Validación CV
        window.validateCV = function() {
            if (!cvPdf || !cvError) return true;
            
            if (!cvPdf.files || cvPdf.files.length === 0) {
                if (cvError) cvError.textContent = 'Debes adjuntar tu CV en formato PDF';
                return false;
            } else if (!cvPdf.files[0].type.includes('pdf')) {
                if (cvError) cvError.textContent = 'El archivo debe ser un PDF';
                return false;
            } else if (cvPdf.files[0].size > 5 * 1024 * 1024) { // 5MB en bytes
                if (cvError) cvError.textContent = 'El tamaño máximo permitido es 5MB';
                return false;
            } else {
                if (cvError) cvError.textContent = '';
                return true;
            }
        }

        // Actualizar label CV
        window.updateCVLabel = function(input) {
            if (!input || !input.files || input.files.length === 0) return;
            
            const fileName = input.files[0].name;
            const fileNameElement = document.getElementById('file-name');
            if (fileNameElement) {
                fileNameElement.textContent = fileName;
            }
        }

        // Añadir event listeners sin usar clearErrors para evento input
        // Estos eventos solo validarán el campo actual sin afectar a otros
        if (dni) {
            dni.addEventListener('input', function() {
                if (typeof window.validateDNI === 'function') window.validateDNI();
            });
        }
        
        if (telefono) {
            telefono.addEventListener('input', function() {
                if (typeof window.validateTelefono === 'function') window.validateTelefono();
            });
        }
        
        if (ciudad) {
            ciudad.addEventListener('input', function() {
                if (typeof window.validateCiudad === 'function') window.validateCiudad();
            });
        }
        
        if (password) {
            password.addEventListener('input', function() {
                if (typeof window.validatePassword === 'function') window.validatePassword();
                if (passwordConfirm && passwordConfirm.value && typeof window.validatePasswordConfirm === 'function') {
                    window.validatePasswordConfirm();
                }
            });
        }
        
        if (passwordConfirm) {
            passwordConfirm.addEventListener('input', function() {
                if (typeof window.validatePasswordConfirm === 'function') window.validatePasswordConfirm();
            });
        }
        
        if (centroEstudios) {
            centroEstudios.addEventListener('input', function() {
                if (typeof window.validateCentroEstudios === 'function') window.validateCentroEstudios();
            });
        }
        
        if (titulo) {
            titulo.addEventListener('change', function() {
                if (typeof window.validateTitulo === 'function') window.validateTitulo();
            });
        }
        
        if (numeroSS) {
            numeroSS.addEventListener('input', function() {
                if (typeof window.validateSS === 'function') window.validateSS();
            });
        }
        
        if (cvPdf) {
            cvPdf.addEventListener('change', function() {
                if (typeof window.updateCVLabel === 'function') window.updateCVLabel(this);
                if (typeof window.validateCV === 'function') window.validateCV();
            });
        }

        registerStudentForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Validar todos los campos sin limpiar errores previos
            const isDNIValid = typeof window.validateDNI === 'function' ? window.validateDNI() : true;
            const isTelefonoValid = typeof window.validateTelefono === 'function' ? window.validateTelefono() : true;
            const isCiudadValid = typeof window.validateCiudad === 'function' ? window.validateCiudad() : true;
            const isPasswordValid = typeof window.validatePassword === 'function' ? window.validatePassword() : true;
            const isPasswordConfirmValid = typeof window.validatePasswordConfirm === 'function' ? window.validatePasswordConfirm() : true;
            const isCentroValid = typeof window.validateCentroEstudios === 'function' ? window.validateCentroEstudios() : true;
            const isTituloValid = typeof window.validateTitulo === 'function' ? window.validateTitulo() : true;
            const isSSValid = typeof window.validateSS === 'function' ? window.validateSS() : true;
            const isCVValid = typeof window.validateCV === 'function' ? window.validateCV() : true;
            
            // Si todos son válidos, enviar formulario
            if (isDNIValid && isTelefonoValid && isCiudadValid && isPasswordValid && 
                isPasswordConfirmValid && isCentroValid && isTituloValid && isSSValid && isCVValid) {
                this.submit();
            }
        });
    }
    
    // Handle company registration form validation
    if (registerCompanyForm) {
        // Elementos de error
        const cifError = document.getElementById('cif-error');
        const direccionError = document.getElementById('address-error');
        const provinciaError = document.getElementById('province-error');
        const passwordError = document.getElementById('password-error');
        const passwordConfirmError = document.getElementById('password_confirmation-error');

        // Campos a validar
        const cif = document.getElementById('cif');
        const direccion = document.getElementById('address');
        const provincia = document.getElementById('province');
        const password = document.getElementById('password');
        const passwordConfirm = document.getElementById('password_confirmation');

        // Validación CIF
        window.validateCIF = function() {
            if (!cif || !cifError) return true;
            
            const cifRegex = /^[A-Z][0-9]{8}$/;
            
            if (!cif.value.trim()) {
                cifError.textContent = 'El CIF es obligatorio';
                cif.classList.add('border-red-500');
                return false;
            } else if (!cifRegex.test(cif.value.trim())) {
                cifError.textContent = 'Introduce un CIF válido (letra mayúscula seguida de 8 números)';
                cif.classList.add('border-red-500');
                return false;
            } else {
                cifError.textContent = '';
                cif.classList.remove('border-red-500');
                return true;
            }
        }

        // Validación dirección
        window.validateDireccion = function() {
            if (!direccion || !direccionError) return true;
            
            if (!direccion.value.trim()) {
                direccionError.textContent = 'La dirección es obligatoria';
                direccion.classList.add('border-red-500');
                return false;
            } else {
                direccionError.textContent = '';
                direccion.classList.remove('border-red-500');
                return true;
            }
        }

        // Validación provincia
        window.validateProvincia = function() {
            if (!provincia || !provinciaError) return true;
            
            if (!provincia.value) {
                provinciaError.textContent = 'Selecciona una provincia';
                provincia.classList.add('border-red-500');
                return false;
            } else {
                provinciaError.textContent = '';
                provincia.classList.remove('border-red-500');
                return true;
            }
        }

        // Validación contraseña (para empresas)
        window.validateCompanyPassword = function() {
            if (!password || !passwordError) return true;
            
            if (!password.value) {
                passwordError.textContent = 'La contraseña es obligatoria';
                password.classList.add('border-red-500');
                return false;
            } else if (password.value.length < 8) {
                passwordError.textContent = 'La contraseña debe tener al menos 8 caracteres';
                password.classList.add('border-red-500');
                return false;
            } else if (!hasNumber(password.value)) {
                passwordError.textContent = 'La contraseña debe contener al menos un número';
                password.classList.add('border-red-500');
                return false;
            } else {
                passwordError.textContent = '';
                password.classList.remove('border-red-500');
                return true;
            }
        }

        // Validación confirmación contraseña (para empresas)
        window.validateCompanyPasswordConfirm = function() {
            if (!passwordConfirm || !passwordConfirmError || !password) return true;
            
            if (!passwordConfirm.value) {
                passwordConfirmError.textContent = 'Confirma tu contraseña';
                passwordConfirm.classList.add('border-red-500');
                return false;
            } else if (passwordConfirm.value !== password.value) {
                passwordConfirmError.textContent = 'Las contraseñas no coinciden';
                passwordConfirm.classList.add('border-red-500');
                return false;
            } else {
                passwordConfirmError.textContent = '';
                passwordConfirm.classList.remove('border-red-500');
                return true;
            }
        }
        
        // Añadir event listeners para evento input
        if (cif) {
            cif.addEventListener('input', function() {
                if (typeof window.validateCIF === 'function') window.validateCIF();
            });
        }
        
        if (direccion) {
            direccion.addEventListener('input', function() {
                if (typeof window.validateDireccion === 'function') window.validateDireccion();
            });
        }
        
        if (provincia) {
            provincia.addEventListener('change', function() {
                if (typeof window.validateProvincia === 'function') window.validateProvincia();
            });
        }
        
        if (password) {
            password.addEventListener('input', function() {
                if (typeof window.validateCompanyPassword === 'function') window.validateCompanyPassword();
                if (passwordConfirm && passwordConfirm.value && typeof window.validateCompanyPasswordConfirm === 'function') {
                    window.validateCompanyPasswordConfirm();
                }
            });
        }
        
        if (passwordConfirm) {
            passwordConfirm.addEventListener('input', function() {
                if (typeof window.validateCompanyPasswordConfirm === 'function') window.validateCompanyPasswordConfirm();
            });
        }
        
        if (registerCompanyForm) {
            registerCompanyForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Validar todos los campos sin limpiar errores previos
                const isCIFValid = typeof window.validateCIF === 'function' ? window.validateCIF() : true;
                const isDireccionValid = typeof window.validateDireccion === 'function' ? window.validateDireccion() : true;
                const isProvinciaValid = typeof window.validateProvincia === 'function' ? window.validateProvincia() : true;
                const isPasswordValid = typeof window.validateCompanyPassword === 'function' ? window.validateCompanyPassword() : true;
                const isPasswordConfirmValid = typeof window.validateCompanyPasswordConfirm === 'function' ? window.validateCompanyPasswordConfirm() : true;
                
                // Si todos son válidos, enviar formulario
                if (isCIFValid && isDireccionValid && isProvinciaValid && isPasswordValid && isPasswordConfirmValid) {
                    this.submit();
                }
            });
        }
    }
    
    // Función para mostrar errores en elementos personalizados
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
    
    // Función auxiliar para validar si la contraseña tiene números
    function hasNumber(password) {
        return /\d/.test(password);
    }
});
