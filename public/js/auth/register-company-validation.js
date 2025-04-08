document.addEventListener('DOMContentLoaded', function() {
    const registerCompanyForm = document.getElementById('registerCompanyForm');
    
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
                let isValid = true;
            
            // VALIDAMOS EL NOMBRE DE LA EMPRESA
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
                    showError(cif, 'Ingrese un CIF válido (Letra mayúscula seguida de 8 números)');
                    isValid = false;
                }
            
            // VALIDAMOS LA DIRECCIÓN
                if (!direccion.value.trim()) {
                    showError(direccion, 'La dirección es requerida');
                    isValid = false;
                }
            
            // VALIDAMOS LA PROVINCIA
                if (!provincia.value) {
                    showError(provincia, 'Seleccione una provincia');
                    isValid = false;
                }
            
            // SI TODO LO ANTERIOR ES VALIDO, ENVIAMOS EL FORMULARIO
                if (isValid) {
                    this.submit();
                }
        });

        // Validación en tiempo real al perder el foco
        const inputs = [
            { element: document.getElementById('name'), validate: function() {
                if (!this.element.value.trim()) {
                    showError(this.element, 'El nombre de la empresa es requerido');
                } else if (this.element.value.trim().length < 3) {
                    showError(this.element, 'El nombre debe tener al menos 3 caracteres');
                }
            }},
            { element: document.getElementById('email'), validate: function() {
                if (!this.element.value.trim()) {
                    showError(this.element, 'El correo electrónico es requerido');
                } else if (!isValidEmail(this.element.value.trim())) {
                    showError(this.element, 'Ingrese un correo electrónico válido');
                }
            }},
            { element: document.getElementById('cif'), validate: function() {
                if (!this.element.value.trim()) {
                    showError(this.element, 'El CIF es requerido');
                } else if (!isValidCIF(this.element.value.trim())) {
                    showError(this.element, 'Ingrese un CIF válido (Letra mayúscula seguida de 8 números)');
                }
            }},
            { element: document.getElementById('direccion'), validate: function() {
                if (!this.element.value.trim()) {
                    showError(this.element, 'La dirección es requerida');
                }
            }},
            { element: document.getElementById('provincia'), validate: function() {
                if (!this.element.value) {
                    showError(this.element, 'Seleccione una provincia');
                }
            }}
        ];

        inputs.forEach(input => {
            if (input.element) {
                input.element.addEventListener('blur', function() {
                    clearErrors();
                    input.validate();
                });
            }
        });
    }
    
    function showError(input, message) {
        const formGroup = input.closest('.mb-4') || input.closest('.mb-6');
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

    function isValidCIF(cif) {
        const re = /^[A-Z]\d{8}$/;
        return re.test(cif);
    }
});
