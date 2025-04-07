document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.getElementById('loginForm');
    
    if (loginForm) {
        loginForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // LIMPIAR ERRORES ANTERIORES SI HAY
                clearErrors();
            
            // VALIDAMOS LOS CAMPOS
                const email = document.getElementById('email');
                const password = document.getElementById('password');
                let isValid = true;
            
            // VALIDAMOS EL EMAIL
                if (!email.value.trim()) {
                    showError(email, 'El correo electrónico es requerido');
                    isValid = false;
                } else if (!isValidEmail(email.value.trim())) {
                    showError(email, 'Ingrese un correo electrónico válido');
                    isValid = false;
                }
            
            // VALIDAR LA CONTRASEÑA
                if (!password.value.trim()) {
                    showError(password, 'La contraseña es requerida');
                    isValid = false;
                } else if (password.value.trim().length < 8) {
                    showError(password, 'La contraseña debe tener al menos 8 caracteres');
                    isValid = false;
                }
            
            // SI TODO LO ANTERIOR ES VALIDO, ENVIAMOS EL FORMULARIO
                if (isValid) {
                    this.submit();
                }
        });
    }
    
    function showError(input, message) {
        const formGroup = input.closest('.mb-4') || input.closest('.mb-6');
        if (!formGroup) return;
        
        // AÑADIR CLASE AL ERROR (BORDE ROJO)
            input.classList.add('border-red-500');
        
        // CREAMOS ELEMENTO DE ERROR SI NO EXISTE
            let errorElement = formGroup.querySelector('.text-red-500');
            if (!errorElement) {
                errorElement = document.createElement('span');
                errorElement.className = 'text-red-500 text-xs mt-1 block';
                formGroup.appendChild(errorElement);
            }
        
        errorElement.textContent = message;
    }
    
    function clearErrors() {
        // LIMPIAMOS LOS ESTILOS
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
});