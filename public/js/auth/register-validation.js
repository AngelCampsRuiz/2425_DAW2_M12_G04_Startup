document.addEventListener('DOMContentLoaded', function() {
    const registerForm = document.getElementById('registerForm');
    
    if (registerForm) {
        registerForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // LIMPIAMOS LOS ERRORES ANTERIORES SI HAY
                clearErrors();
            
            // VALIDAMOS LOS CAMPOS DEL FORMULARIO
                const name = document.getElementById('name');
                const email = document.getElementById('email');
                // Password fields are not in the first step anymore
                const role = document.querySelector('input[name="role"]:checked');
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
            
            // Password validation removed for first step
            
            // VALIDAMOS EL ROL DEL USUARIO
                if (!role) {
                    const roleContainer = document.querySelector('.mb-6');
                    showError(roleContainer, 'Por favor seleccione un tipo de usuario');
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
        
        // PARA LOS RADIOS, USAMOS EL CONTENEDOR
            if (input.classList && input.classList.contains('mb-6')) {
                formGroup = input;
            } else {
                formGroup = input.closest('.mb-4') || input.closest('.mb-6');
            }
        
        if (!formGroup) return;
        
        // AÑADIMOS LA CLASE DE ERROR AL INPUT
            if (input.tagName === 'INPUT') {
                input.classList.add('border-red-500');
            }
        
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
});