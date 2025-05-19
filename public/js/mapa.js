let map;
let marker;
let defaultLat = 41.390205;
let defaultLng = 2.154007;

function initMap() {
    // Obtener el contenedor del mapa
    const mapContainer = document.getElementById('locationMap');
    if (!mapContainer) return;

    // Si el mapa ya está inicializado, solo actualizamos su tamaño
    if (map) {
        map.invalidateSize();
        return;
    }

    // Obtener las coordenadas iniciales
    const lat = parseFloat(document.getElementById('lat').value) || defaultLat;
    const lng = parseFloat(document.getElementById('lng').value) || defaultLng;

    // Inicializar el mapa
    map = L.map('locationMap').setView([lat, lng], 13);

    // Añadir el tile layer (OpenStreetMap)
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    // Añadir el marcador inicial
    marker = L.marker([lat, lng], {
        draggable: true
    }).addTo(map);

    // Manejar el evento de arrastrar el marcador
    marker.on('dragend', function(event) {
        const position = marker.getLatLng();
        updateLocationFields(position.lat, position.lng);
    });

    // Manejar clics en el mapa
    map.on('click', function(event) {
        marker.setLatLng(event.latlng);
        updateLocationFields(event.latlng.lat, event.latlng.lng);
    });
}

function updateLocationFields(lat, lng) {
    // Actualizar los campos ocultos
    document.getElementById('lat').value = lat;
    document.getElementById('lng').value = lng;

    // Obtener la dirección usando la API de geocodificación inversa
    fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
        .then(response => response.json())
        .then(data => {
            if (data.display_name) {
                document.getElementById('direccion').value = data.display_name;
                if (data.address && data.address.city) {
                    document.getElementById('ciudad_mapa').value = data.address.city;
                }
            }
        })
        .catch(error => console.error('Error al obtener la dirección:', error));
}

function saveLocation() {
    const lat = document.getElementById('lat').value;
    const lng = document.getElementById('lng').value;
    const direccion = document.getElementById('direccion').value;
    const ciudad = document.getElementById('ciudad_mapa').value;

    // Enviar los datos al servidor
    fetch('/profile/update-location', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            lat: lat,
            lng: lng,
            direccion: direccion,
            ciudad: ciudad
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                title: '¡Éxito!',
                text: 'Ubicación guardada correctamente',
                icon: 'success',
                confirmButtonColor: '#7C3AED'
            }).then(() => {
                location.reload();
            });
        } else {
            throw new Error(data.message);
        }
    })
    .catch(error => {
        Swal.fire({
            title: 'Error',
            text: error.message || 'Error al guardar la ubicación',
            icon: 'error',
            confirmButtonColor: '#7C3AED'
        });
    });
}

// Función para limpiar el mapa cuando se cierra el modal
function cleanupMap() {
    if (map) {
        map.remove();
        map = null;
        marker = null;
    }
}

// Inicializar el mapa cuando el modal se abre
document.addEventListener('DOMContentLoaded', function() {
    const editModal = document.getElementById('editModal');
    if (editModal) {
        // Observar cambios en la visibilidad del modal
        const observer = new MutationObserver((mutations) => {
            mutations.forEach((mutation) => {
                if (mutation.attributeName === 'class') {
                    if (editModal.classList.contains('hidden')) {
                        cleanupMap();
                    } else {
                        setTimeout(initMap, 100);
                    }
                }
            });
        });

        observer.observe(editModal, {
            attributes: true
        });
    }
});
