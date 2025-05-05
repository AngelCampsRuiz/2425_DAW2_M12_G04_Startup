class DistanceFilter {
    constructor() {
        this.radioSlider = document.getElementById('radioSlider');
        this.radioDistancia = document.getElementById('radioDistancia');
        this.radioValue = document.getElementById('radioValue');
        this.obtenerUbicacion = document.getElementById('obtenerUbicacion');
        this.ubicacionStatus = document.getElementById('ubicacionStatus');
        this.userLat = document.getElementById('userLat');
        this.userLng = document.getElementById('userLng');
        this.map = null;
        this.circle = null;
        this.marker = null;

        this.initializeMap();
        this.initializeSlider();
        this.initializeLocationButton();
        this.initializePublicationFiltering();
    }

    initializeMap() {
        // Crear el mapa centrado en España
        this.map = L.map('radiusMap').setView([40.4167, -3.7037], 6);

        // Añadir capa de OpenStreetMap
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(this.map);

        // Deshabilitar zoom con rueda del ratón para evitar conflictos con el scroll
        this.map.scrollWheelZoom.disable();
    }

    updateMapRadius(lat, lng, radius) {
        // Si ya existe un círculo, eliminarlo
        if (this.circle) {
            this.map.removeLayer(this.circle);
        }
        if (this.marker) {
            this.map.removeLayer(this.marker);
        }

        // Crear nuevo marcador
        this.marker = L.marker([lat, lng]).addTo(this.map);

        // Crear nuevo círculo
        this.circle = L.circle([lat, lng], {
            radius: radius * 1000, // Convertir km a metros
            color: '#5e0490',
            fillColor: '#5e0490',
            fillOpacity: 0.2
        }).addTo(this.map);

        // Ajustar la vista para mostrar todo el círculo
        this.map.fitBounds(this.circle.getBounds());
    }

    initializeSlider() {
        if (this.radioSlider) {
            noUiSlider.create(this.radioSlider, {
                start: [50],
                connect: [true, false],
                step: 1,
                range: {
                    'min': 0,
                    'max': 100
                }
            });

            // Actualizar el valor mostrado y el campo oculto
            this.radioSlider.noUiSlider.on('update', (values, handle) => {
                const value = Math.round(values[handle]);
                this.radioValue.textContent = value + ' km';
                this.radioDistancia.value = value;

                // Actualizar el radio en el mapa si hay una ubicación seleccionada
                if (this.userLat.value && this.userLng.value) {
                    this.updateMapRadius(
                        parseFloat(this.userLat.value),
                        parseFloat(this.userLng.value),
                        value
                    );
                }
            });

            // Ejecutar la búsqueda cuando el usuario suelta el control deslizante
            this.radioSlider.noUiSlider.on('change', () => {
                if (this.userLat.value && this.userLng.value) {
                    this.dispatchFilterEvent();
                }
            });
        }
    }

    dispatchFilterEvent() {
        const event = new CustomEvent('distanceFilterChanged', {
            detail: {
                lat: this.userLat.value,
                lng: this.userLng.value,
                radio: this.radioDistancia.value
            }
        });
        document.dispatchEvent(event);
    }

    initializeLocationButton() {
        if (this.obtenerUbicacion) {
            this.obtenerUbicacion.addEventListener('click', () => {
                this.getUserLocation();
            });
        }
    }

    getUserLocation() {
        this.showStatus('Obteniendo ubicación...', 'text-gray-600');
        
        if ("geolocation" in navigator) {
            navigator.geolocation.getCurrentPosition(
                (position) => this.handleLocationSuccess(position),
                (error) => this.handleLocationError(error)
            );
        } else {
            this.showStatus('Tu navegador no soporta geolocalización', 'text-red-600');
        }
    }

    handleLocationSuccess(position) {
        this.userLat.value = position.coords.latitude;
        this.userLng.value = position.coords.longitude;
        this.showStatus('Ubicación obtenida correctamente', 'text-green-600');

        // Actualizar el mapa con la nueva ubicación y radio
        this.updateMapRadius(
            position.coords.latitude,
            position.coords.longitude,
            parseFloat(this.radioDistancia.value)
        );

        this.dispatchFilterEvent();

        setTimeout(() => {
            this.hideStatus();
        }, 3000);
    }

    handleLocationError(error) {
        let message = 'Error al obtener la ubicación';
        switch(error.code) {
            case error.PERMISSION_DENIED:
                message = 'Permiso denegado para obtener la ubicación';
                break;
            case error.POSITION_UNAVAILABLE:
                message = 'Ubicación no disponible';
                break;
            case error.TIMEOUT:
                message = 'Tiempo de espera agotado';
                break;
        }
        this.showStatus(message, 'text-red-600');
    }

    showStatus(message, className) {
        this.ubicacionStatus.textContent = message;
        this.ubicacionStatus.className = 'mt-2 text-sm text-center ' + className;
        this.ubicacionStatus.classList.remove('hidden');
    }

    hideStatus() {
        this.ubicacionStatus.classList.add('hidden');
    }

    getCurrentLocation() {
        return {
            lat: this.userLat.value,
            lng: this.userLng.value,
            radio: this.radioDistancia.value
        };
    }

    initializePublicationFiltering() {
        document.addEventListener('distanceFilterChanged', () => {
            this.filterPublicationsByDistance();
        });
    }

    filterPublicationsByDistance() {
        const userLat = parseFloat(this.userLat.value);
        const userLng = parseFloat(this.userLng.value);
        const radius = parseFloat(this.radioDistancia.value);

        if (!userLat || !userLng) return;

        const publications = document.querySelectorAll('.grid > div');
        
        publications.forEach(pub => {
            const empresaLat = parseFloat(pub.dataset.lat);
            const empresaLng = parseFloat(pub.dataset.lng);

            if (empresaLat && empresaLng) {
                const distance = this.calculateDistance(userLat, userLng, empresaLat, empresaLng);
                
                if (distance <= radius) {
                    pub.style.display = '';
                    const distanceElement = pub.querySelector('.distance-info');
                    if (distanceElement) {
                        distanceElement.textContent = `A ${Math.round(distance)} km`;
                    }
                } else {
                    pub.style.display = 'none';
                }
            }
        });
    }

    calculateDistance(lat1, lon1, lat2, lon2) {
        const R = 6371;
        const dLat = this.toRad(lat2 - lat1);
        const dLon = this.toRad(lon2 - lon1);
        const a = 
            Math.sin(dLat/2) * Math.sin(dLat/2) +
            Math.cos(this.toRad(lat1)) * Math.cos(this.toRad(lat2)) * 
            Math.sin(dLon/2) * Math.sin(dLon/2);
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
        return R * c;
    }

    toRad(value) {
        return value * Math.PI / 180;
    }
}

// Inicializar cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', () => {
    window.distanceFilter = new DistanceFilter();
});

document.addEventListener('DOMContentLoaded', function() {
    // ... código existente ...

    const fetchPublications = () => {
        if (!searchForm) return;
        
        const params = new URLSearchParams();
        // ... otros parámetros existentes ...

        // Obtener ubicación del filtro de distancia si está disponible
        if (window.distanceFilter) {
            const location = window.distanceFilter.getCurrentLocation();
            if (location.lat && location.lng) {
                params.append('user_lat', location.lat);
                params.append('user_lng', location.lng);
                params.append('radio_distancia', location.radio);
            }
        }

        // ... resto del código de fetch ...
    };

    // Escuchar el evento de cambio en el filtro de distancia
    document.addEventListener('distanceFilterChanged', () => {
        fetchPublications();
    });

    // ... resto del código existente ...
});
