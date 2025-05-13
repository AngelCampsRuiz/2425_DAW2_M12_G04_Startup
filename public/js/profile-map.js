let editMap = null;
let editMarker = null;

// Mapa de solo lectura
let viewMap = null;

// Función para actualizar los campos de ubicación
async function updateLocationFields(lat, lng) {
    document.getElementById('lat').value = lat;
    document.getElementById('lng').value = lng;

    try {
        const response = await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`);
        const data = await response.json();
        
        if (data.address) {
            const direccion = document.getElementById('direccion');
            const ciudad = document.getElementById('ciudad');
            
            if (direccion) direccion.value = data.display_name;
            if (ciudad) ciudad.value = data.address.city || data.address.town || data.address.village || '';
        }
    } catch (error) {
        console.error('Error al obtener la información de ubicación:', error);
    }
}

// Función para inicializar el mapa de edición
function initializeMap() {
    const mapContainer = document.getElementById('locationMap');
    if (!mapContainer) return;

    // Establecer dimensiones explícitas
    mapContainer.style.height = '300px'; // Reducir altura
    mapContainer.style.width = '100%';
    mapContainer.style.maxHeight = '400px';

    // Obtener las coordenadas guardadas o usar coordenadas por defecto
    const lat = document.getElementById('lat')?.value || 41.390205;
    const lng = document.getElementById('lng')?.value || 2.154007;

    // Limpiar el mapa existente si lo hay
    if (editMap) {
        editMap.remove();
        editMap = null;
    }

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

    // Serie de actualizaciones programadas para asegurar la carga correcta
    const refreshMap = () => {
        if (editMap) {
            editMap.invalidateSize({
                animate: false,
                pan: false
            });
        }
    };

    // Múltiples intentos de actualización
    refreshMap();
    [100, 300, 500, 1000].forEach(delay => {
        setTimeout(refreshMap, delay);
    });
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
            await Swal.fire({
                title: '¡Éxito!',
                text: 'Ubicación actualizada correctamente',
                icon: 'success',
                confirmButtonColor: '#7C3AED'
            });
            window.location.reload();
        } else {
            throw new Error(data.message || 'Error al actualizar la ubicación');
        }
    } catch (error) {
        console.error('Error:', error);
        await Swal.fire({
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
    }, 100);
});
