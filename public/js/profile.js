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
            const ciudadMapaInput = document.getElementById('ciudad_mapa');
            const ciudadInput = document.getElementById('ciudad');
            
            if (direccionInput) direccionInput.value = direccionCompleta;
            if (ciudadMapaInput) ciudadMapaInput.value = data.address.city || data.address.town || data.address.village || '';
            if (ciudadInput) ciudadInput.value = data.address.city || data.address.town || data.address.village || '';
        }
    } catch (error) {
        // Error silencioso
    }
}

function initializeViewMap() {
    // Verificar si el usuario es una empresa
    const empresaElement = document.querySelector('[data-role="empresa"]');
    if (!empresaElement) {
        return;
    }

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
    
    setTimeout(() => {
        initializeMap();
    }, 100);
}

function closeEditModal() {
    document.getElementById('editModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Inicialización cuando el DOM está cargado
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

    // Event listener para el botón de editar
    const editButton = document.querySelector('.edit-button');
    if (editButton) {
        editButton.addEventListener('click', openEditModal);
    }

    // Inicializar el mapa de vista si existe
    const viewMapContainer = document.getElementById('viewLocationMap');
    if (viewMapContainer) {
        initializeViewMap();
    }
});

