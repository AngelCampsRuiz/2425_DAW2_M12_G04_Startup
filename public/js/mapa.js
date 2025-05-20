let map = null;
let marker = null;
let searchTimeout = null;
let selectedLocation = null;

function initMap() {
    // Verificar si el usuario es una empresa
    const empresaElement = document.querySelector('[data-role="empresa"]');
    if (!empresaElement) {
        return;
    }

    if (map) {
        map.invalidateSize();
        return;
    }

    const lat = document.getElementById('lat').value || 41.390205;
    const lng = document.getElementById('lng').value || 2.154007;

    map = L.map('locationMap').setView([lat, lng], 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    marker = L.marker([lat, lng], {
        draggable: true
    }).addTo(map);

    marker.on('dragend', function(e) {
        const position = marker.getLatLng();
        updateLocationFields(position.lat, position.lng);
    });

    map.on('click', function(e) {
        marker.setLatLng(e.latlng);
        updateLocationFields(e.latlng.lat, e.latlng.lng);
    });

    initSearchBox();
}

function initSearchBox() {
    const searchInput = document.getElementById('searchLocation');
    const searchResults = document.getElementById('searchResults');

    if (!searchInput || !searchResults) return;

    // Añadir estilos al contenedor de resultados
    searchResults.style.maxHeight = '300px';
    searchResults.style.overflowY = 'auto';
    searchResults.style.zIndex = '1000';
    searchResults.style.backgroundColor = 'white';
    searchResults.style.borderRadius = '0.5rem';
    searchResults.style.boxShadow = '0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06)';

    searchInput.addEventListener('input', function(e) {
        const query = e.target.value.trim();
        
        if (query.length < 2) {
            searchResults.classList.add('hidden');
            searchResults.innerHTML = '';
            return;
        }

        // Mostrar indicador de carga
        searchResults.innerHTML = `
            <div class="p-3 text-gray-500 flex items-center">
                <svg class="animate-spin h-5 w-5 mr-3 text-purple-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Buscando...
            </div>
        `;
        searchResults.classList.remove('hidden');

        if (searchTimeout) {
            clearTimeout(searchTimeout);
        }

        searchTimeout = setTimeout(() => {
            searchLocation(query);
        }, 300);
    });

    // Cerrar resultados al hacer clic fuera
    document.addEventListener('click', function(e) {
        if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
            searchResults.classList.add('hidden');
        }
    });
}

async function searchLocation(query) {
    try {
        // Añadir parámetros específicos para mejorar la búsqueda en España
        const params = new URLSearchParams({
            format: 'json',
            q: query,
            limit: 5,
            addressdetails: 1,
            countrycodes: 'es',
            bounded: 1,
            viewbox: '-9.5,44.0,3.5,35.9', // Bounding box de España
            featuretype: 'street,house', // Priorizar calles y números
            'accept-language': 'es' // Forzar resultados en español
        });

        const response = await fetch(`https://nominatim.openstreetmap.org/search?${params}`);
        const data = await response.json();
        
        const searchResults = document.getElementById('searchResults');
        searchResults.innerHTML = '';
        
        if (data.length === 0) {
            searchResults.innerHTML = `
                <div class="p-3 text-gray-500 flex items-center">
                    <svg class="h-5 w-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    No se encontraron resultados
                </div>
            `;
            searchResults.classList.remove('hidden');
            return;
        }

        data.forEach(result => {
            const div = document.createElement('div');
            div.className = 'p-3 hover:bg-purple-50 cursor-pointer border-b last:border-b-0 transition-colors duration-150';
            
            const address = result.address;
            const direccionParts = [];
            
            // Mejorar la construcción de la dirección
            if (address.road) {
                let calle = address.road;
                if (address.house_number) {
                    calle += `, ${address.house_number}`;
                }
                direccionParts.push(calle);
            }
            
            if (address.postcode) {
                direccionParts.push(address.postcode);
            }
            
            if (address.city || address.town || address.village) {
                direccionParts.push(address.city || address.town || address.village);
            }
            
            if (address.state) {
                direccionParts.push(address.state);
            }
            
            const direccionCompleta = direccionParts.join(', ');
            
            div.innerHTML = `
                <div class="flex items-start">
                    <div class="flex-shrink-0 mt-1">
                        <svg class="h-5 w-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <div class="font-medium text-gray-900">${direccionCompleta}</div>
                        <div class="text-sm text-gray-500">${result.display_name}</div>
                    </div>
                </div>
            `;
            
            div.addEventListener('click', () => {
                const lat = parseFloat(result.lat);
                const lon = parseFloat(result.lon);
                
                selectedLocation = {
                    lat: lat,
                    lng: lon,
                    direccion: direccionCompleta,
                    ciudad: address.city || address.town || address.village || '',
                    codigoPostal: address.postcode || ''
                };
                
                map.setView([lat, lon], 16);
                marker.setLatLng([lat, lon]);
                
                document.getElementById('lat').value = lat;
                document.getElementById('lng').value = lon;
                document.getElementById('direccion').value = direccionCompleta;
                document.getElementById('ciudad_mapa').value = selectedLocation.ciudad;
                document.getElementById('ciudad').value = selectedLocation.ciudad;
                
                document.getElementById('searchLocation').value = direccionCompleta;
                searchResults.classList.add('hidden');
            });
            
            searchResults.appendChild(div);
        });
        
        searchResults.classList.remove('hidden');
    } catch (error) {
        console.error('Error al buscar ubicación:', error);
        const searchResults = document.getElementById('searchResults');
        searchResults.innerHTML = `
            <div class="p-3 text-red-500 flex items-center">
                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Error al buscar la ubicación
            </div>
        `;
        searchResults.classList.remove('hidden');
    }
}

async function updateLocationFields(lat, lng) {
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
            
            document.getElementById('lat').value = lat;
            document.getElementById('lng').value = lng;
            document.getElementById('direccion').value = direccionCompleta;
            document.getElementById('ciudad_mapa').value = data.address.city || data.address.town || data.address.village || '';
            document.getElementById('ciudad').value = data.address.city || data.address.town || data.address.village || '';
            document.getElementById('searchLocation').value = direccionCompleta;
        }
    } catch (error) {
        console.error('Error al obtener detalles de la ubicación:', error);
    }
}

async function saveLocation() {
    const lat = document.getElementById('lat').value;
    const lng = document.getElementById('lng').value;
    const direccion = document.getElementById('direccion').value;
    const ciudad = document.getElementById('ciudad').value;

    if (!lat || !lng || !direccion || !ciudad) {
        Swal.fire({
            title: 'Error',
            text: 'Por favor, selecciona una ubicación válida',
            icon: 'error',
            confirmButtonColor: '#7C3AED'
        });
        return;
    }

    try {
        const response = await fetch('/profile/update-location', {
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
        });

        const data = await response.json();

        if (data.success) {
            Swal.fire({
                title: '¡Éxito!',
                text: 'Ubicación guardada correctamente',
                icon: 'success',
                confirmButtonColor: '#7C3AED'
            }).then(() => {
                window.location.reload();
            });
        } else {
            throw new Error(data.message || 'Error al guardar la ubicación');
        }
    } catch (error) {
        Swal.fire({
            title: 'Error',
            text: error.message || 'Error al guardar la ubicación',
            icon: 'error',
            confirmButtonColor: '#7C3AED'
        });
    }
}

function cleanupMap() {
    if (map) {
        map.remove();
        map = null;
    }
    if (marker) {
        marker = null;
    }
    if (searchTimeout) {
        clearTimeout(searchTimeout);
        searchTimeout = null;
    }
    selectedLocation = null;
}

// Inicializar cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', function() {
    const editModal = document.getElementById('editModal');
    if (editModal) {
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
