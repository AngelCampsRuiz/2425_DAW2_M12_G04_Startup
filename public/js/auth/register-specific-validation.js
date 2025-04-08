document.addEventListener('DOMContentLoaded', function() {
    const registerStudentForm = document.getElementById('registerStudentForm');
    const registerCompanyForm = document.getElementById('registerCompanyForm');
    
    // VALIDACIÓN FORMULARIO ESTUDIANTE
    if (registerStudentForm) {
        registerStudentForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // LIMPIAMOS LOS ERRORES ANTERIORES SI HAY
            clearErrors();
            
            // VALIDAMOS LOS CAMPOS DEL FORMULARIO
            const name = document.getElementById('name');
            const email = document.getElementById('email');
            const centroEstudios = document.getElementById('centro_estudios');
            const password = document.getElementById('password');
            const passwordConfirm = document.getElementById('password_confirmation');
            let isValid = true;
            
            // VALIDAMOS EL NOMBRE
            if (!name.value.trim()) {
                showError(name, 'El nombre completo es requerido');
                isValid = false;
            } else if (name.value.trim().length < 3) {
                showError(name, 'El nombre debe tener al menos 3 caracteres');
                isValid = false;
            }
            
            // VALIDAMOS EL EMAIL
            if (!email.value.trim()) {
                showError(email, 'El correo electrónico es requerido');
                isValid = false;
            } else if (!isValidEmail(email.value.trim())) {
                showError(email, 'Ingrese un correo electrónico válido');
                isValid = false;
            }
            
            // VALIDAMOS EL CENTRO DE ESTUDIOS
            if (!centroEstudios.value.trim()) {
                showError(centroEstudios, 'El centro de estudios es requerido');
                isValid = false;
            }
            
            // VALIDAMOS LA CONTRASEÑA
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
            
            // VALIDAMOS LA CONFIRMACIÓN DE CONTRASEÑA
            if (!passwordConfirm.value.trim()) {
                showError(passwordConfirm, 'Por favor confirme su contraseña');
                isValid = false;
            } else if (password.value !== passwordConfirm.value) {
                showError(passwordConfirm, 'Las contraseñas no coinciden');
                isValid = false;
            }
            
            // SI TODO LO ANTERIOR ES VALIDO, ENVIAMOS EL FORMULARIO
            if (isValid) {
                this.submit();
            }
        });
    }
    
    // VALIDACIÓN FORMULARIO EMPRESA
    if (registerCompanyForm) {
        registerCompanyForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // LIMPIAMOS LOS ERRORES ANTERIORES SI HAY
            clearErrors();
            
            // VALIDAMOS LOS CAMPOS DEL FORMULARIO
            const name = document.getElementById('name');
            const email = document.getElementById('email');
            const cif = document.getElementById('cif');
            const direccion = document.getElementById('direccion');
            const provincia = document.getElementById('provincia');
            const password = document.getElementById('password');
            const passwordConfirm = document.getElementById('password_confirmation');
            let isValid = true;
            
            // VALIDAMOS EL NOMBRE
            if (!name.value.trim()) {
                showError(name, 'El nombre de la empresa es requerido');
                isValid = false;
            } else if (name.value.trim().length < 3) {
                showError(name, 'El nombre debe tener al menos 3 caracteres');
                isValid = false;
            }
            
            // VALIDAMOS EL EMAIL
            if (!email.value.trim()) {
                showError(email, 'El correo electrónico es requerido');
                isValid = false;
            } else if (!isValidEmail(email.value.trim())) {
                showError(email, 'Ingrese un correo electrónico válido');
                isValid = false;
            }
            
            // VALIDAMOS EL CIF
            if (!cif.value.trim()) {
                showError(cif, 'El CIF es requerido');
                isValid = false;
            } else if (!isValidCIF(cif.value.trim())) {
                showError(cif, 'Ingrese un CIF válido');
                isValid = false;
            }
            
            // VALIDAMOS LA DIRECCIÓN
            if (!direccion.value.trim()) {
                showError(direccion, 'La dirección es requerida');
                isValid = false;
            }
            
            // VALIDAMOS LA PROVINCIA
            if (!provincia.value) {
                showError(provincia, 'Por favor seleccione una provincia');
                isValid = false;
            }
            
            // VALIDAMOS LA CONTRASEÑA
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
            
            // VALIDAMOS LA CONFIRMACIÓN DE CONTRASEÑA
            if (!passwordConfirm.value.trim()) {
                showError(passwordConfirm, 'Por favor confirme su contraseña');
                isValid = false;
            } else if (password.value !== passwordConfirm.value) {
                showError(passwordConfirm, 'Las contraseñas no coinciden');
                isValid = false;
            }
            
            // SI TODO LO ANTERIOR ES VALIDO, ENVIAMOS EL FORMULARIO
            if (isValid) {
                this.submit();
            }
        });
    }
    
    function showError(input, message) {
        let formGroup;
        
        // PARA LOS SELECTS, USAMOS EL CONTENEDOR
        if (input.tagName === 'SELECT') {
            formGroup = input.closest('.mb-4');
        } else {
            formGroup = input.closest('.mb-4');
        }
        
        if (!formGroup) return;
        
        // AÑADIMOS LA CLASE DE ERROR AL INPUT
        input.classList.add('border-red-500');
        
        // CREAR EL ELEMENTO DE ERROR SI NO EXISTE
        let errorElement = formGroup.querySelector('.text-red-500');
        if (!errorElement) {
            errorElement = document.createElement('span');
            errorElement.className = 'text-red-500 text-xs mt-1 block';
            formGroup.appendChild(errorElement);
        }
        
        errorElement.textContent = message;
    }
    
    function clearErrors() {
        // LIMPIAMOS LOS ESTILOS DEL ERROR
        document.querySelectorAll('.border-red-500').forEach(el => {
            el.classList.remove('border-red-500');
        });
        
        // ELIMINAMOS EL MENSAJE DE ERROR
        document.querySelectorAll('.text-red-500').forEach(el => {
            if (el.tagName === 'SPAN') {
                el.remove();
            }
        });
    }
    
    function isValidEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    }
    
    function hasNumber(password) {
        return /\d/.test(password);
    }
    
    function isValidCIF(cif) {
        return /^[A-Z]\d{8}$/.test(cif);
    }
});
