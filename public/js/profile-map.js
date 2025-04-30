let map = null;
let marker = null;

// Mapa de solo lectura
let viewMap = null;

// Función para inicializar el mapa
function initializeMap() {
    // Obtener las coordenadas guardadas o usar coordenadas por defecto (Barcelona)
    const lat = document.getElementById('lat')?.value || 41.390205;
    const lng = document.getElementById('lng')?.value || 2.154007;

    // Si el mapa ya existe, lo destruimos
    if (map) {
        map.remove();
        map = null;
    }

    // Crear el mapa
    map = L.map('locationMap', {
        center: [lat, lng],
        zoom: 13,
        zoomControl: true
    });

    // Añadir capa de OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors',
        maxZoom: 19
    }).addTo(map);

    // Añadir marcador
    marker = L.marker([lat, lng], {
        draggable: true
    }).addTo(map);

    // Evento cuando se arrastra el marcador
    marker.on('dragend', function(e) {
        const position = marker.getLatLng();
        updateLocationFields(position.lat, position.lng);
    });

    // Evento de clic en el mapa
    map.on('click', function(e) {
        marker.setLatLng(e.latlng);
        updateLocationFields(e.latlng.lat, e.latlng.lng);
    });

    // Invalidar el tamaño del mapa después de que sea visible
    setTimeout(() => {
        map.invalidateSize();
        setTimeout(() => {
            map.invalidateSize();
            setTimeout(() => {
                map.invalidateSize();
            }, 500);
        }, 300);
    }, 100);
}

// Función para actualizar los campos de ubicación
async function updateLocationFields(lat, lng) {
    // Actualizar campos ocultos
    document.getElementById('lat').value = lat;
    document.getElementById('lng').value = lng;

    try {
        // Obtener dirección usando Nominatim
        const response = await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`);
        const data = await response.json();
        
        if (data.address) {
            // Actualizar campos de dirección y ciudad
            const direccion = document.getElementById('direccion');
            const ciudad = document.getElementById('ciudad');
            
            if (direccion) direccion.value = data.display_name;
            if (ciudad) ciudad.value = data.address.city || data.address.town || data.address.village || '';
        }
    } catch (error) {
        console.error('Error al obtener la información de ubicación:', error);
    }
}

// Función para guardar la ubicación
async function saveLocation() {
    const lat = document.getElementById('lat').value;
    const lng = document.getElementById('lng').value;
    const direccion = document.getElementById('direccion').value;
    const ciudad = document.getElementById('ciudad').value;

    try {
        const response = await fetch('/profile/update-location', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            },
            body: JSON.stringify({ lat, lng, direccion, ciudad })
        });

        if (!response.ok) {
            const errorData = await response.json();
            throw new Error(errorData.message || 'Error al actualizar la ubicación');
        }

        const data = await response.json();

        if (data.success) {
            Swal.fire({
                title: '¡Éxito!',
                text: 'Ubicación actualizada correctamente',
                icon: 'success',
                confirmButtonColor: '#7C3AED'
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

// Función para inicializar el mapa de solo lectura
function initializeViewMap() {
    const viewMapContainer = document.getElementById('viewLocationMap');
    if (!viewMapContainer) return;

    // Obtener las coordenadas guardadas
    const lat = document.getElementById('lat')?.value;
    const lng = document.getElementById('lng')?.value;

    if (!lat || !lng) return;

    // Si el mapa ya existe, lo destruimos
    if (viewMap) {
        viewMap.remove();
        viewMap = null;
    }

    // Crear el mapa
    viewMap = L.map('viewLocationMap', {
        center: [lat, lng],
        zoom: 15,
        zoomControl: true,
        dragging: true,
        scrollWheelZoom: false
    });

    // Añadir capa de OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors',
        maxZoom: 19
    }).addTo(viewMap);

    // Añadir marcador
    L.marker([lat, lng]).addTo(viewMap);

    // Invalidar el tamaño del mapa después de que sea visible
    setTimeout(() => {
        viewMap.invalidateSize();
    }, 100);
}

// Modificar el evento DOMContentLoaded existente
document.addEventListener('DOMContentLoaded', function() {
    initializeMap();
    initializeViewMap();
});
