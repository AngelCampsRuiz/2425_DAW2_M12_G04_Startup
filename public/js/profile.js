// Variables globales en el objeto window
window.mapEdit = null;
window.markerEdit = null;
window.viewMap = null;
window.isFormSubmitting = false;

// Manejo de errores global
window.onerror = function(msg, url, lineNo, columnNo, error) {
    console.log('Error:', msg, '\nURL:', url, '\nLine:', lineNo);
    Swal.fire({
        title: 'Error detectado',
        text: `Error: ${msg}`,
        icon: 'error',
        confirmButtonColor: '#7C3AED'
    });
    return false;
};

// Catch para promesas no manejadas
window.addEventListener('unhandledrejection', function(event) {
    console.log('Unhandled promise rejection:', event.reason);
    Swal.fire({
        title: 'Error en promesa no manejada',
        text: event.reason.toString(),
        icon: 'error',
        confirmButtonColor: '#7C3AED'
    });
});

// Funciones del mapa
function initializeMap() {
    const mapContainer = document.getElementById('locationMap');
    if (!mapContainer) return;

    const lat = document.getElementById('lat')?.value || 41.390205;
    const lng = document.getElementById('lng')?.value || 2.154007;

    if (window.mapEdit) {
        window.mapEdit.remove();
        window.mapEdit = null;
    }

    window.mapEdit = L.map('locationMap', {
        center: [lat, lng],
        zoom: 13,
        zoomControl: true
    });

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors',
        maxZoom: 19
    }).addTo(window.mapEdit);

    window.markerEdit = L.marker([lat, lng], {
        draggable: true
    }).addTo(window.mapEdit);

    window.markerEdit.on('dragend', function(e) {
        const position = window.markerEdit.getLatLng();
        updateLocationFields(position.lat, position.lng);
    });

    window.mapEdit.on('click', function(e) {
        window.markerEdit.setLatLng(e.latlng);
        updateLocationFields(e.latlng.lat, e.latlng.lng);
    });

    setTimeout(() => {
        window.mapEdit.invalidateSize();
    }, 500);
}

async function updateLocationFields(lat, lng) {
    document.getElementById('lat').value = lat;
    document.getElementById('lng').value = lng;

    try {
        const response = await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&addressdetails=1`);
        const data = await response.json();
        
        if (data.address) {
            const direccionParts = [];
            if (data.address.road) direccionParts.push(data.address.road);
            if (data.address.house_number) direccionParts.push(data.address.house_number);
            if (data.address.suburb) direccionParts.push(data.address.suburb);
            if (data.address.city || data.address.town || data.address.village) {
                direccionParts.push(data.address.city || data.address.town || data.address.village);
            }
            
            const direccionCompleta = direccionParts.join(', ');
            
            const direccionInput = document.getElementById('direccion');
            const ciudadInput = document.getElementById('ciudad');
            
            if (direccionInput) direccionInput.value = direccionCompleta;
            if (ciudadInput) ciudadInput.value = data.address.city || data.address.town || data.address.village || '';
        }
    } catch (error) {
        console.error('Error al obtener la información de ubicación:', error);
    }
}

function initializeViewMap() {
    const viewMapContainer = document.getElementById('viewLocationMap');
    if (!viewMapContainer) return;

    const lat = parseFloat(viewMapContainer.dataset.lat);
    const lng = parseFloat(viewMapContainer.dataset.lng);

    if (!lat || !lng) return;

    if (window.viewMap) {
        window.viewMap.remove();
        window.viewMap = null;
    }

    window.viewMap = L.map('viewLocationMap', {
        center: [lat, lng],
        zoom: 15,
        zoomControl: true,
        dragging: true,
        scrollWheelZoom: false
    });

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors',
        maxZoom: 19
    }).addTo(window.viewMap);

    L.marker([lat, lng]).addTo(window.viewMap);

    setTimeout(() => {
        window.viewMap.invalidateSize();
    }, 100);
}

// Funciones del modal
function openEditModal() {
    document.getElementById('editModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
    resetAllErrors();
    
    setTimeout(() => {
        initializeMap();
    }, 100);
}

function closeEditModal() {
    document.getElementById('editModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Funciones de utilidad para errores
function showError(field, message) {
    const errorElement = document.getElementById('error-' + field.id);
    if (errorElement) {
        errorElement.textContent = message;
        errorElement.classList.remove('hidden');
        field.classList.add('border-red-500');
    }
}

function hideError(field) {
    const errorElement = document.getElementById('error-' + field.id);
    if (errorElement) {
        errorElement.classList.add('hidden');
        field.classList.remove('border-red-500');
    }
}

function resetAllErrors() {
    document.querySelectorAll('.error-message').forEach(el => el.classList.add('hidden'));
    document.querySelectorAll('input, textarea').forEach(el => el.classList.remove('border-red-500'));
}

// Funciones de validación
function validarCampo(field, nombre, minLength, maxLength) {
    if (!field || !field.value) return true;
    const valor = field.value.trim();
    
    if (!valor) {
        showError(field, `El ${nombre} es obligatorio`);
        return false;
    }
    
    if (minLength && valor.length < minLength) {
        showError(field, `El ${nombre} debe tener al menos ${minLength} caracteres`);
        return false;
    }
    
    if (maxLength && valor.length > maxLength) {
        showError(field, `El ${nombre} no puede exceder los ${maxLength} caracteres`);
        return false;
    }
    
    hideError(field);
    return true;
}

function validarEmail(field) {
    if (!field) return true;
    const valor = field.value.trim();
    
    if (!valor) {
        showError(field, "El email es obligatorio");
        return false;
    }
    
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(valor)) {
        showError(field, "Formato de email no válido");
        return false;
    }
    
    hideError(field);
    return true;
}

function validarDNI(field) {
    if (!field || document.querySelector('[data-role="empresa"]')) return true;
    
    const valor = field.value.trim();
    if (!valor) {
        showError(field, "El DNI es obligatorio");
        return false;
    }
    
    const dniRegex = /^[0-9]{8}[A-Za-z]$/;
    const nieRegex = /^[XYZxyz][0-9]{7}[A-Za-z]$/;
    
    if (!dniRegex.test(valor) && !nieRegex.test(valor)) {
        showError(field, "Formato de DNI/NIE no válido");
        return false;
    }
    
    hideError(field);
    return true;
}

function validarCIF(field) {
    if (!field) return true;
    
    const valor = field.value.trim();
    if (!valor) {
        showError(field, "El CIF es obligatorio");
        return false;
    }
    
    const cifRegex = /^[A-HJNP-SUVW][0-9]{7}[0-9A-J]$/;
    if (!cifRegex.test(valor.toUpperCase())) {
        showError(field, "Formato de CIF no válido");
        return false;
    }
    
    hideError(field);
    return true;
}

// Función para manejar el envío del formulario
function handleFormSubmit(e) {
    e.preventDefault();
    
    if (window.isFormSubmitting) return;
    
    // Validar campos
    let isValid = true;
    const isEmpresa = document.querySelector('[data-role="empresa"]') !== null;
    
    // Validaciones básicas
    const emailInput = document.getElementById('email');
    const nombreInput = document.getElementById('nombre');
    
    // Validar email primero
    if (!validarEmail(emailInput)) {
        isValid = false;
    }

    // Validar nombre
    if (!validarCampo(nombreInput, 'nombre', 2, 100)) {
        isValid = false;
    }
    
    // Validar DNI/CIF según rol
    if (isEmpresa) {
        const cifInput = document.getElementById('cif');
        if (!validarCIF(cifInput)) {
            isValid = false;
        }
    } else {
        const dniInput = document.getElementById('dni');
        if (!validarDNI(dniInput)) {
            isValid = false;
        }
    }
    
    if (!isValid) {
        Swal.fire({
            title: 'Error de validación',
            text: 'Por favor, revisa los campos marcados en rojo',
            icon: 'error',
            confirmButtonColor: '#7C3AED'
        });
        return;
    }
    
    window.isFormSubmitting = true;
    const form = e.target;
    const submitButton = form.querySelector('button[type="submit"]');
    const originalButtonText = submitButton.innerHTML;
    
    submitButton.disabled = true;
    submitButton.innerHTML = 'Guardando...';
    
    const formData = new FormData(form);
    
    fetch(form.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => {
        if (!response.ok) {
            return response.json().then(data => {
                throw new Error(Object.values(data.errors || {}).flat().join('\n'));
            });
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            Swal.fire({
                title: '¡Éxito!',
                text: 'Los cambios se han guardado correctamente',
                icon: 'success',
                confirmButtonColor: '#7C3AED'
            }).then(() => {
                window.location.reload();
            });
        } else {
            throw new Error(data.message || 'Error al guardar los cambios');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        
        // Mostrar errores específicos de validación
        const errorMessage = error.message;
        if (errorMessage.includes('email')) {
            showError(emailInput, "El email es obligatorio");
        }
        
        Swal.fire({
            title: 'Error',
            text: errorMessage || 'Ha ocurrido un error al guardar los cambios',
            icon: 'error',
            confirmButtonColor: '#7C3AED'
        });
    })
    .finally(() => {
        submitButton.disabled = false;
        submitButton.innerHTML = originalButtonText;
        window.isFormSubmitting = false;
    });
}

// Inicialización cuando el DOM está cargado
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded');
    
    // Solo inicializar una vez
    let mapInitialized = false;
    
    // Event listener para cerrar el modal al hacer clic fuera
    const modal = document.getElementById('editModal');
    if (modal) {
        modal.addEventListener('click', function(event) {
            if (event.target === this) {
                closeEditModal();
            }
        });
    }

    // Event listeners para validación de campos
    const inputs = {
        nombre: { min: 2, max: 100 },
        descripcion: { min: 10, max: 255 },
        telefono: { min: 9, max: 15 },
        ciudad: { min: 2, max: 100 },
        email: { validate: validarEmail }
    };

    Object.entries(inputs).forEach(([id, rules]) => {
        const input = document.getElementById(id);
        if (input) {
            input.addEventListener('blur', () => {
                if (rules.validate) {
                    rules.validate(input);
                } else {
                    validarCampo(input, id, rules.min, rules.max);
                }
            });
        }
    });

    // Event listener para el botón de editar
    const editButton = document.querySelector('.edit-button');
    if (editButton) {
        editButton.addEventListener('click', function() {
            if (!mapInitialized) {
                setTimeout(() => {
                    initializeMap();
                    mapInitialized = true;
                }, 500);
            }
        });
    }

    // Event listener para el formulario
    const profileForm = document.getElementById('profileForm');
    if (profileForm) {
        // Remover event listeners anteriores si existen
        const newProfileForm = profileForm.cloneNode(true);
        profileForm.parentNode.replaceChild(newProfileForm, profileForm);
        newProfileForm.addEventListener('submit', handleFormSubmit);
    }

    // Inicializar el mapa de vista si existe
    const viewMapContainer = document.getElementById('viewLocationMap');
    if (viewMapContainer) {
        initializeViewMap();
    }
});

