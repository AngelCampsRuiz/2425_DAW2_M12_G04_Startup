// Variables globales para el mapa
let map = null;
let marker = null;

// Funciones para el modal principal
function openEditModal() {
    document.getElementById('editModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
    resetAllErrors();
    
    // Inicializar mapa después de que el modal sea visible
    setTimeout(() => {
        initializeMap();
    }, 300);
}

function closeEditModal() {
    document.getElementById('editModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Funciones para el mapa
function initializeMap() {
    // Si ya existe un mapa, eliminarlo
    if (map !== null) {
        map.remove();
    }

    try {
        // Obtener coordenadas iniciales
        const latInput = document.getElementById('latitud');
        const lngInput = document.getElementById('longitud');
        const initialLat = latInput ? parseFloat(latInput.value) || 40.4167 : 40.4167;
        const initialLng = lngInput ? parseFloat(lngInput.value) || -3.7037 : -3.7037;

        // Crear el mapa
        map = L.map('map').setView([initialLat, initialLng], 13);

        // Añadir capa de OpenStreetMap
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Añadir marcador inicial
        marker = L.marker([initialLat, initialLng], {
            draggable: true
        }).addTo(map);

        // Evento de clic en el mapa
        map.on('click', function(e) {
            const newLat = e.latlng.lat;
            const newLng = e.latlng.lng;
            
            if (marker) {
                marker.setLatLng([newLat, newLng]);
            }
            
            updateCoordinates(newLat, newLng);
        });

        // Evento de arrastre del marcador
        marker.on('dragend', function() {
            const pos = marker.getLatLng();
            updateCoordinates(pos.lat, pos.lng);
        });

        // Forzar redimensionamiento del mapa después de que sea visible
        setTimeout(() => {
            map.invalidateSize();
        }, 250);

    } catch (error) {
        console.error('Error al inicializar el mapa:', error);
    }
}

function updateCoordinates(lat, lng) {
    const latInput = document.getElementById('latitud');
    const lngInput = document.getElementById('longitud');
    
    if (latInput && lngInput) {
        latInput.value = lat.toFixed(6);
        lngInput.value = lng.toFixed(6);
    }
}

// Funciones de validación
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
    document.querySelectorAll('.error-message').forEach(el => {
        el.classList.add('hidden');
    });
    document.querySelectorAll('input, textarea').forEach(el => {
        el.classList.remove('border-red-500');
    });
}

// Funciones de validación de campos
function validarNombre(field) {
    if (!field.value.trim()) {
        showError(field, "El nombre es obligatorio");
        return false;
    } else if (field.value.trim().length < 2) {
        showError(field, "El nombre debe tener al menos 2 caracteres");
        return false;
    } else if (field.value.trim().length > 100) {
        showError(field, "El nombre no puede exceder los 100 caracteres");
        return false;
            } else {
        hideError(field);
        return true;
    }
}

// ... (resto de funciones de validación)

// Event Listeners cuando el DOM está cargado
document.addEventListener('DOMContentLoaded', function() {
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
    const nombreInput = document.getElementById('nombre');
    const descripcionInput = document.getElementById('descripcion');
    const telefonoInput = document.getElementById('telefono');
    const dniInput = document.getElementById('dni');
    const ciudadInput = document.getElementById('ciudad');
    
    if (nombreInput) nombreInput.addEventListener('blur', function() { validarNombre(this); });
    if (descripcionInput) descripcionInput.addEventListener('blur', function() { validarDescripcion(this); });
    if (telefonoInput) telefonoInput.addEventListener('blur', function() { validarTelefono(this); });
    if (dniInput) dniInput.addEventListener('blur', function() { validarDNI(this); });
    if (ciudadInput) ciudadInput.addEventListener('blur', function() { validarCiudad(this); });

    // Event listener para el formulario
    const profileForm = document.getElementById('profileForm');
    if (profileForm) {
        profileForm.addEventListener('submit', handleFormSubmit);
    }
});
