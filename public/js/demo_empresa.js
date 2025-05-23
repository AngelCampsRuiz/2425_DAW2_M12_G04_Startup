document.addEventListener('DOMContentLoaded', function() {
    // Datos estáticos de la demo
    const data = {
        activePublications: 37,
        inactivePublications: 3,
        activeSolicitudes: 24,
        inactiveSolicitudes: 21
    };

    // Actualizar los contadores en la interfaz
    if (document.getElementById('activePublicationsCount')) {
        document.getElementById('activePublicationsCount').textContent = data.activePublications;
    }
    if (document.getElementById('inactivePublicationsCount')) {
        document.getElementById('inactivePublicationsCount').textContent = data.inactivePublications;
    }
    if (document.getElementById('activeSolicitudesCount')) {
        document.getElementById('activeSolicitudesCount').textContent = data.activeSolicitudes;
    }
    if (document.getElementById('totalSolicitudesCount')) {
        document.getElementById('totalSolicitudesCount').textContent = data.activeSolicitudes + data.inactiveSolicitudes;
    }

    // Detalles
    if (document.getElementById('activePublicationsDetail')) {
        document.getElementById('activePublicationsDetail').textContent = data.activePublications;
    }
    if (document.getElementById('inactivePublicationsDetail')) {
        document.getElementById('inactivePublicationsDetail').textContent = data.inactivePublications;
    }
    if (document.getElementById('activeSolicitudesDetail')) {
        document.getElementById('activeSolicitudesDetail').textContent = data.activeSolicitudes;
    }
    if (document.getElementById('inactiveSolicitudesDetail')) {
        document.getElementById('inactiveSolicitudesDetail').textContent = data.inactiveSolicitudes;
    }

    // Gráfico de Ofertas (Doughnut)
    if (document.getElementById('solicitudesChart')) {
        const ctx1 = document.getElementById('solicitudesChart').getContext('2d');
        new Chart(ctx1, {
            type: 'doughnut',
            data: {
                labels: ['Ofertas Activas', 'Ofertas Inactivas'],
                datasets: [{
                    data: [data.activePublications, data.inactivePublications],
                    backgroundColor: [
                        'rgba(124, 58, 237, 0.7)', // morado
                        'rgba(251, 191, 36, 0.3)'  // amarillo claro
                    ],
                    borderWidth: 0,
                    borderRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            padding: 20
                        }
                    }
                }
            }
        });
    }

    // Gráfico de Solicitudes (Bar)
    if (document.getElementById('estadosChart')) {
        const ctx2 = document.getElementById('estadosChart').getContext('2d');
        new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: ['Solicitudes Aceptadas', 'Solicitudes Rechazadas'],
                datasets: [{
                    data: [data.activeSolicitudes, data.inactiveSolicitudes],
                    backgroundColor: [
                        'rgba(34, 197, 94, 0.7)',   // verde
                        'rgba(239, 68, 68, 0.7)'    // rojo
                    ],
                    borderWidth: 0,
                    borderRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { display: true, color: 'rgba(0, 0, 0, 0.1)' }
                    },
                    x: { grid: { display: false } }
                }
            }
        });
    }
});