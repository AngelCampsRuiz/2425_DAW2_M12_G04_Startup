let editMap = null;
let editMarker = null;

// Mapa de solo lectura
let viewMap = null;

// Función para actualizar los campos de ubicación
async function updateLocationFields(lat, lng) {
    try {
        const response = await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`);
        const data = await response.json();
        
        if (data.address) {
            const direccionInput = document.getElementById('direccion');
            const ciudadInput = document.getElementById('ciudad');
            const latInput = document.getElementById('lat');
            const lngInput = document.getElementById('lng');
            
            if (direccionInput) direccionInput.value = data.display_name;
            if (ciudadInput) ciudadInput.value = data.address.city || data.address.town || data.address.village || '';
            if (latInput) latInput.value = lat;
            if (lngInput) lngInput.value = lng;
        }
    } catch (error) {
        console.error('Error al obtener la información de ubicación:', error);
    }
}

// Función para inicializar el mapa de edición
function initializeMap() {
    const mapContainer = document.getElementById('locationMap');
    if (!mapContainer) return;

    // Limpiar el mapa existente si lo hay
    if (editMap) {
        editMap.remove();
        editMap = null;
    }

    // Obtener las coordenadas guardadas o usar coordenadas por defecto
    const lat = document.getElementById('lat')?.value || 41.390205;
    const lng = document.getElementById('lng')?.value || 2.154007;

    // Crear el mapa con opciones optimizadas
    editMap = L.map('locationMap', {
        center: [lat, lng],
        zoom: 13,
        zoomControl: true,
        fadeAnimation: false,
        markerZoomAnimation: false
    });

    // Añadir capa de OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors',
        maxZoom: 19
    }).addTo(editMap);

    // Añadir marcador con icono personalizado
    const customIcon = L.divIcon({
        className: 'custom-div-icon',
        html: `<div style="background-color: #7C3AED; width: 16px; height: 16px; border-radius: 50%; border: 3px solid white; box-shadow: 0 0 10px rgba(0,0,0,0.3);"></div>`,
        iconSize: [16, 16],
        iconAnchor: [8, 8]
    });

    editMarker = L.marker([lat, lng], {
        icon: customIcon,
        draggable: true
    }).addTo(editMap);

    // Eventos del marcador y mapa
    editMarker.on('dragend', function(e) {
        const position = editMarker.getLatLng();
        updateLocationFields(position.lat, position.lng);
    });

    editMap.on('click', function(e) {
        editMarker.setLatLng(e.latlng);
        updateLocationFields(e.latlng.lat, e.latlng.lng);
    });

    // Añadir botón de guardar
    const saveButton = document.createElement('button');
    saveButton.className = 'save-location-btn';
    saveButton.innerHTML = 'Guardar Ubicación';
    saveButton.onclick = saveLocation;
    mapContainer.parentElement.appendChild(saveButton);

    // Forzar actualización del mapa
    setTimeout(() => {
        editMap.invalidateSize();
    }, 100);
}

// Función para guardar la ubicación
async function saveLocation() {
    try {
        const lat = document.getElementById('lat').value;
        const lng = document.getElementById('lng').value;
        const direccion = document.getElementById('direccion').value;
        const ciudad = document.getElementById('ciudad').value;

        const response = await fetch('/profile/update-location', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            },
            body: JSON.stringify({ 
                lat: parseFloat(lat), 
                lng: parseFloat(lng), 
                direccion, 
                ciudad 
            })
        });

        const data = await response.json();

        if (response.ok && data.success) {
            Swal.fire({
                title: '¡Éxito!',
                text: 'Ubicación actualizada correctamente',
                icon: 'success',
                confirmButtonColor: '#7C3AED'
            }).then(() => {
                window.location.reload();
            });
        } else {
            throw new Error(data.message || 'Error al actualizar la ubicación');
        }
    } catch (error) {
        console.error('Error:', error);
        Swal.fire({
            title: 'Error',
            text: error.message || 'Error al guardar la ubicación',
            icon: 'error',
            confirmButtonColor: '#7C3AED'
        });
    }
}

// Función para inicializar el mapa de visualización
function initializeViewMap() {
    const viewMapContainer = document.getElementById('viewLocationMap');
    if (!viewMapContainer) return;

    // Obtener las coordenadas del contenedor del mapa
    const lat = parseFloat(viewMapContainer.dataset.lat);
    const lng = parseFloat(viewMapContainer.dataset.lng);

    if (!lat || !lng) return;

    // Si el mapa ya existe, lo destruimos
    if (viewMap) {
        viewMap.remove();
        viewMap = null;
    }

    // Crear el mapa con un estilo más limpio
    viewMap = L.map('viewLocationMap', {
        center: [lat, lng],
        zoom: 15,
        zoomControl: true,
        dragging: true,
        scrollWheelZoom: false
    });

    // Añadir capa de OpenStreetMap con estilo personalizado
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors',
        maxZoom: 19
    }).addTo(viewMap);

    // Añadir marcador personalizado
    const customIcon = L.divIcon({
        className: 'custom-div-icon',
        html: `<div style="background-color: #DC2626; width: 16px; height: 16px; border-radius: 50%; border: 3px solid white; box-shadow: 0 0 10px rgba(0,0,0,0.3);"></div>`,
        iconSize: [16, 16],
        iconAnchor: [8, 8]
    });

    L.marker([lat, lng], { icon: customIcon }).addTo(viewMap);

    // Mejorar la carga del mapa
    setTimeout(() => {
        viewMap.invalidateSize();
    }, 100);
}

// Mejorar la inicialización de los mapas
document.addEventListener('DOMContentLoaded', function() {
    // Retrasar la inicialización para asegurar que el DOM está listo
    setTimeout(() => {
        const editMapContainer = document.getElementById('locationMap');
        const viewMapContainer = document.getElementById('viewLocationMap');

        if (editMapContainer) {
            initializeMap();
        }

        if (viewMapContainer) {
            initializeViewMap();
        }
    }, 300);
});
