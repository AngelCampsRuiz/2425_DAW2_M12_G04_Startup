let editMap = null;
let editMarker = null;

// Mapa de solo lectura
let viewMap = null;

// Función para inicializar el mapa de edición
function initializeMap() {
    const mapContainer = document.getElementById('locationMap');
    if (!mapContainer) return; // Si no existe el contenedor, no inicializar

    // Obtener las coordenadas guardadas o usar coordenadas por defecto (Barcelona)
    const lat = document.getElementById('lat')?.value || 41.390205;
    const lng = document.getElementById('lng')?.value || 2.154007;

    // Si el mapa ya existe, lo destruimos
    if (editMap) {
        editMap.remove();
        editMap = null;
    }

    // Crear el mapa
    editMap = L.map('locationMap', {
        center: [lat, lng],
        zoom: 13,
        zoomControl: true
    });

    // Añadir capa de OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors',
        maxZoom: 19
    }).addTo(editMap);

    // Añadir marcador
    editMarker = L.marker([lat, lng], {
        draggable: true
    }).addTo(editMap);

    // Evento cuando se arrastra el marcador
    editMarker.on('dragend', function(e) {
        const position = editMarker.getLatLng();
        updateLocationFields(position.lat, position.lng);
    });

    // Evento de clic en el mapa
    editMap.on('click', function(e) {
        editMarker.setLatLng(e.latlng);
        updateLocationFields(e.latlng.lat, e.latlng.lng);
    });

    // Invalidar el tamaño del mapa después de que sea visible
    setTimeout(() => {
        editMap.invalidateSize();
        setTimeout(() => {
            editMap.invalidateSize();
            setTimeout(() => {
                editMap.invalidateSize();
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

// Función para inicializar el mapa de solo lectura
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

// Inicializar los mapas cuando se carga la página
document.addEventListener('DOMContentLoaded', function() {
    // Intentar inicializar el mapa de edición
    const editMapContainer = document.getElementById('locationMap');
    if (editMapContainer) {
        initializeMap();
    }

    // Intentar inicializar el mapa de visualización
    const viewMapContainer = document.getElementById('viewLocationMap');
    if (viewMapContainer) {
        initializeViewMap();
    }
});
