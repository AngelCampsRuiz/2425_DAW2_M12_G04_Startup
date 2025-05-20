/**
 * Validaciones onBlur para el formulario de publicaciones
 * Versión simplificada - Solo validación, sin modificar elementos
 */
document.addEventListener('DOMContentLoaded', function() {
    // Configuración de validaciones
    const validaciones = {
        'titulo': {
            validar: (valor) => valor.trim().length >= 5,
            mensaje: 'El título es obligatorio y debe tener al menos 5 caracteres.'
        },
        'empresa_id': {
            validar: (valor) => valor !== '' && valor !== 'Selecciona una empresa',
            mensaje: 'Debes seleccionar una empresa.'
        },
        'categoria_id': {
            validar: (valor) => valor !== '' && valor !== 'Selecciona una categoría',
            mensaje: 'Debes seleccionar una categoría.'
        },
        'subcategoria_id': {
            validar: (valor) => valor !== '' && valor !== 'Selecciona una subcategoría',
            mensaje: 'Debes seleccionar una subcategoría.'
        },
        'horario': {
            validar: (valor) => valor !== '' && valor !== 'Selecciona un horario',
            mensaje: 'Debes seleccionar un horario.'
        },
        'horas_totales': {
            validar: (valor) => !isNaN(valor) && parseInt(valor) > 0,
            mensaje: 'Las horas totales deben ser un número mayor que cero.'
        },
        'fecha_publicacion': {
            validar: (valor) => {
                if (!valor) return false;
                const fecha = new Date(valor);
                const hoy = new Date();
                return fecha >= new Date(hoy.toISOString().split('T')[0]);
            },
            mensaje: 'La fecha debe ser igual o posterior a hoy.'
        },
        'descripcion': {
            validar: (valor) => valor.trim().length >= 10,
            mensaje: 'La descripción debe tener al menos 10 caracteres.'
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
            
            // Solo validar campos del formulario de publicaciones
            if (elemento.form && elemento.form.id === 'form-publicacion' && elemento.id && validaciones[elemento.id]) {
                validarCampo(elemento);
            }
        }, true);
        
        document.body.addEventListener('change', function(e) {
            const elemento = e.target;
            
            // Solo validar selects del formulario de publicaciones
            if (elemento.tagName === 'SELECT' && elemento.form && 
                elemento.form.id === 'form-publicacion' && elemento.id && 
                validaciones[elemento.id]) {
                validarCampo(elemento);
            }
        }, true);
        
        // Validar al enviar el formulario
        const form = document.getElementById('form-publicacion');
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