/**
 * Validaciones onBlur para el formulario de categorías
 * Versión simplificada - Solo validación, sin modificar elementos
 */
document.addEventListener('DOMContentLoaded', function() {
    // Configuración de validaciones
    const validaciones = {
        'nombre_categoria': {
            validar: (valor) => valor.trim().length >= 3,
            mensaje: 'El nombre de la categoría es obligatorio y debe tener al menos 3 caracteres.'
        }
    };

    // Función para validar un campo
    function validarCampo(elemento) {
        const id = elemento.id;
        if (!validaciones[id]) return true;

        const valor = elemento.value;
        const validar = validaciones[id].validar;
        const mensaje = validaciones[id].mensaje;
        
        // Buscar o crear el elemento de error
        let errorId = id + '-error';
        let errorElem = document.getElementById(errorId);
        
        // Validar el valor
        if (!validar(valor)) {
            // Mostrar error
            if (!errorElem) {
                errorElem = document.createElement('p');
                errorElem.id = errorId;
                errorElem.className = 'text-red-600 text-sm mt-1';
                elemento.parentNode.appendChild(errorElem);
            }
            errorElem.textContent = mensaje;
            elemento.classList.add('border-red-500');
            return false;
        } else {
            // Quitar error
            if (errorElem) {
                errorElem.remove();
            }
            elemento.classList.remove('border-red-500');
            return true;
        }
    }

    // Función para inicializar validaciones
    function inicializarValidaciones() {
        // Agregar listeners basados en eventos, sin modificar los elementos originales
        document.body.addEventListener('blur', function(e) {
            const elemento = e.target;
            
            // Solo validar campos del formulario de categorías
            if (elemento.form && elemento.form.id === 'categoriaForm' && elemento.id && validaciones[elemento.id]) {
                validarCampo(elemento);
            }
        }, true);
        
        // Validar al enviar el formulario
        const form = document.getElementById('categoriaForm');
        if (form) {
            form.addEventListener('submit', function(e) {
                let formValido = true;
                
                // Validar todos los campos configurados
                Object.keys(validaciones).forEach(id => {
                    const elemento = document.getElementById(id);
                    if (elemento) {
                        const esValido = validarCampo(elemento);
                        if (!esValido) formValido = false;
                    }
                });
                
                // Detener envío si hay errores
                if (!formValido) {
                    e.preventDefault();
                }
            });
        }
    }

    // Inicializar validaciones cuando se cargue la página
    inicializarValidaciones();
}); 