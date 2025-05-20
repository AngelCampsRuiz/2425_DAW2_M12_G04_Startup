/**
 * Validaciones onBlur para el formulario de subcategorías
 * Versión mejorada - Con validación específica para añadir
 */
document.addEventListener('DOMContentLoaded', function() {
    console.log('Script de validación de subcategorías cargado correctamente');
    
    // Configuración de validaciones
    const validaciones = {
        'nombre_subcategoria': {
            validar: (valor) => valor.trim().length >= 3,
            mensaje: 'El nombre de la subcategoría es obligatorio y debe tener al menos 3 caracteres.'
        },
        'categoria_id': {
            // Es importante validar que se seleccione una categoría válida
            validar: (valor) => valor !== '' && valor !== 'Seleccione una categoría',
            mensaje: 'Debes seleccionar una categoría.'
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

    // Función para agregar eventos específicos a los campos
    function agregarEventosCampos() {
        const nombreSubcategoria = document.getElementById('nombre_subcategoria');
        const categoriaId = document.getElementById('categoria_id');
        
        // Limpiar eventos previos para evitar duplicados
        if (nombreSubcategoria) {
            const nuevoNombre = nombreSubcategoria.cloneNode(true);
            nombreSubcategoria.parentNode.replaceChild(nuevoNombre, nombreSubcategoria);
            
            // Añadir nuevo evento
            nuevoNombre.addEventListener('blur', function() {
                validarCampo(this);
            });
        }
        
        if (categoriaId) {
            const nuevoCategoria = categoriaId.cloneNode(true);
            categoriaId.parentNode.replaceChild(nuevoCategoria, categoriaId);
            
            // Añadir nuevo evento
            nuevoCategoria.addEventListener('change', function() {
                validarCampo(this);
            });
            
            // Validar inicialmente para mostrar mensaje si está vacío
            // Esto es especialmente útil para el modo "añadir"
            if (document.getElementById('modal-titulo') && 
                document.getElementById('modal-titulo').textContent.includes('Crear')) {
                setTimeout(() => {
                    validarCampo(nuevoCategoria);
                }, 100);
            }
        }
    }
    
    // Validar al enviar el formulario
    function inicializarFormulario() {
        const form = document.getElementById('form-subcategoria');
        if (form) {
            // Limpiar eventos previos
            const nuevoForm = form.cloneNode(true);
            form.parentNode.replaceChild(nuevoForm, form);
            
            // Configurar nuevos campos después de clonar
            setTimeout(() => {
                agregarEventosCampos();
            }, 50);
            
            // Añadir evento submit
            nuevoForm.addEventListener('submit', function(e) {
                e.preventDefault(); // Siempre prevenir el envío por defecto
                
                let formValido = true;
                
                // Validar todos los campos configurados
                Object.keys(validaciones).forEach(id => {
                    const elemento = document.getElementById(id);
                    if (elemento) {
                        const esValido = validarCampo(elemento);
                        if (!esValido) formValido = false;
                    }
                });
                
                // Solo permitir envío si todo es válido
                if (formValido) {
                    // Enviar formulario manualmente
                    console.log('Formulario válido, enviando...');
                    this.submit();
                } else {
                    console.log('Formulario con errores, corregir antes de enviar');
                }
            });
        }
    }
    
    // Función para manejar la apertura del modal (unificada)
    function handleModalOpen() {
        console.log('Modal detectado, configurando validaciones...');
        setTimeout(() => {
            inicializarFormulario();
        }, 100);
    }
    
    // Observar cambios en el DOM para detectar cuando se abre el modal
    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.type === 'attributes' && 
                mutation.attributeName === 'class') {
                
                const modal = mutation.target;
                if (modal.id === 'modal-subcategoria' && !modal.classList.contains('hidden')) {
                    handleModalOpen();
                }
            }
        });
    });
    
    // Iniciar la observación del modal
    const modal = document.getElementById('modal-subcategoria');
    if (modal) {
        observer.observe(modal, {
            attributes: true
        });
    }
    
    // Detectar clicks en los botones que abren el modal
    document.addEventListener('click', function(e) {
        // Botón de crear
        if (e.target.closest('.btn-crear')) {
            console.log('Botón crear clickeado, preparando validación');
            handleModalOpen();
        }
        
        // Botón de editar
        if (e.target.closest('.btn-editar')) {
            console.log('Botón editar clickeado, preparando validación');
            handleModalOpen();
        }
    });
    
    // Inicializar eventos para formularios ya visibles
    inicializarFormulario();
}); 