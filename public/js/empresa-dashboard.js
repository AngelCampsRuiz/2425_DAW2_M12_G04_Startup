// Verificar que estamos en la página correcta antes de ejecutar el script
document.addEventListener('DOMContentLoaded', function() {
    // Renderizar gráficos si existen los elementos
    if (document.getElementById('solicitudesChart')) {
        initializeCharts();
    }

    // Configuración para el modal
    const modalNuevaOferta = document.getElementById('modalNuevaOferta');
    const formNuevaOferta = document.getElementById('formNuevaOferta');

    // Configurar botones para abrir el modal
    document.querySelectorAll('#btnNuevaOferta, #btnPrimeraOferta').forEach(button => {
        if (button) {
            button.addEventListener('click', function() {
                openModal();
            });
        }
    });
    
    // Función para abrir el modal
    window.openModal = function() {
        if (modalNuevaOferta) {
            modalNuevaOferta.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
            
            // Animación de entrada
            setTimeout(() => {
                const modalContent = modalNuevaOferta.querySelector('.relative');
                if (modalContent) {
                    modalContent.classList.add('animate-fadeIn');
                }
            }, 10);
            
            // Scroll al inicio del modal y focus primer input
            setTimeout(() => {
                const firstInput = modalNuevaOferta.querySelector('input, select, textarea');
                if (firstInput) firstInput.focus();
            }, 300);
        }
    };
    
    // Función para cerrar el modal
    window.closeModal = function() {
        if (modalNuevaOferta) {
            // Animación de salida
            const modalContent = modalNuevaOferta.querySelector('.relative');
            if (modalContent) {
                modalContent.classList.remove('animate-fadeIn');
                modalContent.classList.add('animate-fadeOut');
            }
            
            setTimeout(() => {
                modalNuevaOferta.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
                
                if (modalContent) {
                    modalContent.classList.remove('animate-fadeOut');
                }
                
                if (formNuevaOferta) {
                    formNuevaOferta.reset();
                    delete formNuevaOferta.dataset.processing;
                }
            }, 200);
        }
    };
    
    // Cerrar modal al hacer clic fuera
    if (modalNuevaOferta) {
        modalNuevaOferta.addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });
    
        // Cerrar con tecla Escape
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !modalNuevaOferta.classList.contains('hidden')) {
                closeModal();
            }
        });
    }
    
    // Función para cargar subcategorías
    window.cargarSubcategorias = function() {
        const categoriaId = document.getElementById('categoria_id');
        if (!categoriaId) return;
        
        const subcategoriasSelect = document.getElementById('subcategoria_id');
        if (!subcategoriasSelect) return;
        
        if (!categoriaId.value) {
            subcategoriasSelect.innerHTML = '<option value="">Primero seleccione una categoría</option>';
            return;
        }
        
        subcategoriasSelect.innerHTML = '<option value="">Cargando subcategorías...</option>';
        subcategoriasSelect.disabled = true;
        
        const baseUrl = window.baseUrl || '';
        const url = `${baseUrl}/empresa/get-subcategorias/${categoriaId.value}`;
        
        fetch(url, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            credentials: 'same-origin'
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(response => {
            if (response.error) {
                throw new Error(response.message);
            }

            subcategoriasSelect.innerHTML = '<option value="">Seleccionar subcategoría</option>';
            
            const subcategorias = response.data || [];
            if (subcategorias.length === 0) {
                subcategoriasSelect.innerHTML = '<option value="">No hay subcategorías disponibles</option>';
                return;
            }

            // Usar un Set para evitar duplicados
            const addedIds = new Set();
            
            subcategorias.forEach(subcategoria => {
                if (!addedIds.has(subcategoria.id)) {
                    addedIds.add(subcategoria.id);
                    subcategoriasSelect.innerHTML += `
                        <option value="${subcategoria.id}">${subcategoria.nombre_subcategoria}</option>
                    `;
                }
            });
        })
        .catch(error => {
            console.error('Error al cargar subcategorías:', error);
            if (window.Swal) {
                Swal.fire({
                    title: '¡Error!',
                    text: 'No se pudieron cargar las subcategorías: ' + error.message,
                    icon: 'error',
                    confirmButtonText: 'Entendido',
                    confirmButtonColor: '#7E22CE'
                });
            }
            subcategoriasSelect.innerHTML = '<option value="">Error al cargar subcategorías</option>';
        })
        .finally(() => {
            subcategoriasSelect.disabled = false;
        });
    };
    
    // Manejar envío del formulario
    if (formNuevaOferta) {
        const requestsInProgress = new Set();
        
        formNuevaOferta.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Verificar si el formulario ya está siendo procesado
            if (this.dataset.processing === 'true') {
                console.log('Formulario ya está siendo procesado, ignorando envío duplicado');
                return false;
            }
        
            // Validaciones adicionales en el cliente
            const titulo = this.querySelector('#titulo').value.trim();
            const descripcion = this.querySelector('#descripcion').value.trim();
            
            if (titulo.length < 5) {
                Swal.fire({
                    title: 'Validación',
                    text: 'El título debe tener al menos 5 caracteres',
                    icon: 'warning',
                    confirmButtonColor: '#7E22CE'
                });
                return false;
            }
            
            if (descripcion.length < 50) {
                Swal.fire({
                    title: 'Validación',
                    text: 'La descripción debe ser más detallada (mínimo 50 caracteres)',
                    icon: 'warning',
                    confirmButtonColor: '#7E22CE'
                });
                return false;
            }
            
            // Verificar si hay una solicitud idéntica en progreso usando datos del formulario como identificador
            const formData = new FormData(this);
            const requestId = Array.from(formData.entries())
                .map(([key, value]) => `${key}=${value}`)
                .join('&');
                
            if (requestsInProgress.has(requestId)) {
                console.log('Solicitud idéntica ya en progreso, ignorando');
                return false;
            }
            
            // Marcar el formulario como en procesamiento
            this.dataset.processing = 'true';
            requestsInProgress.add(requestId);
            
            // Deshabilitar el botón de submit y mostrar estado de carga
            const submitButton = document.getElementById('submitButton');
            if (submitButton) {
                submitButton.disabled = true;
                submitButton.innerHTML = '<div class="flex items-center"><svg class="animate-spin -ml-1 mr-2 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Publicando...</div>';
            }
            
            // Datos para el seguimiento de la petición
            const uniqueId = Date.now().toString();
            console.log(`[${uniqueId}] Iniciando envío del formulario`);
            
            fetch(window.storeUrl, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'X-Request-ID': uniqueId,
                    'X-Request-Unique': requestId
                }
            })
            .then(response => {
                console.log(`[${uniqueId}] Respuesta recibida, status: ${response.status}`);
                
                if (!response.ok) {
                    throw new Error(`Error en la respuesta del servidor: ${response.status}`);
                }
                
                const contentType = response.headers.get('content-type');
                if (contentType && contentType.includes('application/json')) {
                    return response.json().then(data => {
                        console.log(`[${uniqueId}] Datos JSON recibidos:`, data);
                        
                        if (data.success) {
                            closeModal();
                            if (window.Swal) {
                                Swal.fire({
                                    title: '¡Éxito!',
                                    text: data.message || 'Oferta creada exitosamente',
                                    icon: 'success',
                                    confirmButtonText: 'Continuar',
                                    confirmButtonColor: '#7E22CE'
                                }).then(() => {
                                    window.location.reload();
                                });
                            } else {
                                alert(data.message || 'Oferta creada exitosamente');
                                window.location.reload();
                            }
                        } else {
                            throw new Error(data.message || 'Error al crear la oferta');
                        }
                    });
                } else {
                    console.log(`[${uniqueId}] Respuesta no es JSON, recargando página`);
                    window.location.reload();
                }
            })
            .catch(error => {
                console.error(`[${uniqueId}] Error:`, error);
                
                if (window.Swal) {
                    Swal.fire({
                        title: '¡Error!',
                        text: error.message || 'Ha ocurrido un error al publicar la oferta',
                        icon: 'error',
                        confirmButtonText: 'Entendido',
                        confirmButtonColor: '#7E22CE'
                    });
                } else {
                    alert(error.message || 'Ha ocurrido un error al publicar la oferta');
                }
            })
            .finally(() => {
                console.log(`[${uniqueId}] Finalizada la petición`);
                
                // Eliminar la solicitud del conjunto de solicitudes en progreso
                requestsInProgress.delete(requestId);
                
                // Restablecer el estado del botón y formulario después de 2 segundos
                setTimeout(() => {
                    delete formNuevaOferta.dataset.processing;
                    
                    if (submitButton) {
                        submitButton.disabled = false;
                        submitButton.innerHTML = '<div class="flex items-center"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg> Publicar oferta</div>';
                    }
                }, 2000);
            });
        });
    }
});

// Inicializar gráficos con estilos mejorados y animaciones
function initializeCharts() {
    // Obtener datos para los gráficos
    const activas = window.activasCount || 0;
    const inactivas = window.inactivasCount || 0;
    const solicitudesActivas = window.solicitudesActivasCount || 0;
    const solicitudesInactivas = window.solicitudesInactivasCount || 0;
    
    // Paleta de colores personalizada con degradados
    const chartPalette = {
        purple: {
            primary: 'rgba(124, 58, 237, 0.9)',
            secondary: 'rgba(139, 92, 246, 0.6)',
            gradient: createGradient('solicitudesChart', [
                'rgba(124, 58, 237, 0.7)', 
                'rgba(139, 92, 246, 0.3)'
            ])
        },
        amber: {
            primary: 'rgba(217, 119, 6, 0.9)',
            secondary: 'rgba(245, 158, 11, 0.6)',
            gradient: createGradient('solicitudesChart', [
                'rgba(217, 119, 6, 0.7)', 
                'rgba(251, 191, 36, 0.3)'
            ])
        },
        blue: {
            primary: 'rgba(59, 130, 246, 0.9)',
            secondary: 'rgba(96, 165, 250, 0.6)',
            gradient: createGradient('estadosChart', [
                'rgba(59, 130, 246, 0.7)', 
                'rgba(96, 165, 250, 0.3)'
            ])
        },
        gray: {
            primary: 'rgba(107, 114, 128, 0.9)',
            secondary: 'rgba(156, 163, 175, 0.6)',
            gradient: createGradient('estadosChart', [
                'rgba(107, 114, 128, 0.7)', 
                'rgba(156, 163, 175, 0.3)'
            ])
        }
    };
    
    // Crear degradados para los gráficos
    function createGradient(chartId, colorStops) {
        const ctx = document.getElementById(chartId).getContext('2d');
        const gradient = ctx.createLinearGradient(0, 0, 0, 400);
        
        colorStops.forEach((color, index) => {
            gradient.addColorStop(index / (colorStops.length - 1), color);
        });
        
        return gradient;
    }
    
    // Configurar Chart.js con defaults globales
    Chart.defaults.font.family = "'Inter', 'Helvetica', 'Arial', sans-serif";
    Chart.defaults.color = '#6B7280';
    Chart.defaults.elements.arc.borderWidth = 0;
    Chart.defaults.elements.arc.hoverBorderWidth = 3;
    Chart.defaults.elements.arc.hoverBorderColor = '#FFF';
    Chart.defaults.elements.arc.borderRadius = 4;
    
    // Gráfico de distribución de ofertas
    const solicitudesChart = new Chart(
        document.getElementById('solicitudesChart').getContext('2d'), 
        {
            type: 'doughnut',
            data: {
                labels: ['Ofertas Activas', 'Ofertas Inactivas'],
                datasets: [{
                    data: [activas, inactivas],
                    backgroundColor: [
                        chartPalette.purple.gradient,
                        chartPalette.amber.gradient
                    ],
                    borderColor: [
                        chartPalette.purple.primary,
                        chartPalette.amber.primary
                    ],
                    hoverBackgroundColor: [
                        chartPalette.purple.primary,
                        chartPalette.amber.primary
                    ],
                    hoverOffset: 10,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                layout: {
                    padding: 20
                },
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            boxWidth: 12,
                            padding: 15,
                            font: {
                                size: 12,
                                weight: '500'
                            }
                        }
                    },
                    title: {
                        display: false
                    },
                    tooltip: {
                        enabled: true,
                        backgroundColor: 'rgba(255, 255, 255, 0.95)',
                        titleColor: '#1F2937',
                        bodyColor: '#4B5563',
                        padding: 12,
                        cornerRadius: 8,
                        boxWidth: 10,
                        boxHeight: 10,
                        boxPadding: 3,
                        usePointStyle: true,
                        borderColor: 'rgba(229, 231, 235, 1)',
                        borderWidth: 1,
                        titleFont: {
                            size: 14,
                            weight: 'bold'
                        },
                        bodyFont: {
                            size: 13
                        },
                        callbacks: {
                            label: function(context) {
                                const total = context.dataset.data.reduce((acc, val) => acc + val, 0);
                                const value = context.raw;
                                const percentage = total > 0 ? Math.round((value / total) * 100) : 0;
                                return `${context.label}: ${value} (${percentage}%)`;
                            }
                        },
                        displayColors: false
                    }
                },
                cutout: '70%',
                animation: {
                    animateScale: true,
                    animateRotate: true,
                    duration: 1500,
                    easing: 'easeOutCirc',
                    delay: function(context) {
                        return context.dataIndex * 100;
                    }
                }
            },
            plugins: [{
                id: 'centreTitlePlugin',
                beforeDraw: function(chart) {
                    // Si no hay datos, no dibujar nada
                    if (chart.data.datasets[0].data.length === 0) return;
                    
                    const width = chart.width;
                    const height = chart.height;
                    const ctx = chart.ctx;
                    const centerX = width / 2;
                    const centerY = height / 2;
                    const total = chart.data.datasets[0].data.reduce((a, b) => a + b, 0);
                    
                    // Configuración del texto
                    ctx.textAlign = 'center';
                    ctx.textBaseline = 'middle';
                    
                    // Dibujar el valor total
                    ctx.font = 'bold 30px Inter';
                    ctx.fillStyle = '#1F2937';
                    ctx.fillText(total, centerX, centerY - 10);
                    
                    // Texto "Total" debajo
                    ctx.font = '14px Inter';
                    ctx.fillStyle = '#6B7280';
                    ctx.fillText('Total', centerX, centerY + 15);
                }
            }]
        }
    );
    
    // Gráfico de distribución de solicitudes
    const estadosChart = new Chart(
        document.getElementById('estadosChart').getContext('2d'), 
        {
            type: 'bar',
            data: {
                labels: ['Solicitudes Activas', 'Solicitudes Inactivas'],
                datasets: [{
                    label: 'Solicitudes',
                    data: [solicitudesActivas, solicitudesInactivas],
                    backgroundColor: [
                        chartPalette.blue.gradient,
                        chartPalette.gray.gradient
                    ],
                    borderColor: [
                        chartPalette.blue.primary,
                        chartPalette.gray.primary
                    ],
                    borderWidth: 1,
                    borderRadius: 8,
                    borderSkipped: false,
                    hoverBackgroundColor: [
                        chartPalette.blue.primary,
                        chartPalette.gray.primary
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                indexAxis: 'y',
                layout: {
                    padding: {
                        top: 20,
                        bottom: 20,
                        left: 20,
                        right: 20
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    title: {
                        display: false
                    },
                    tooltip: {
                        enabled: true,
                        backgroundColor: 'rgba(255, 255, 255, 0.95)',
                        titleColor: '#1F2937',
                        bodyColor: '#4B5563',
                        padding: 12,
                        cornerRadius: 8,
                        boxWidth: 10,
                        boxHeight: 10,
                        boxPadding: 3,
                        usePointStyle: true,
                        borderColor: 'rgba(229, 231, 235, 1)',
                        borderWidth: 1,
                        callbacks: {
                            label: function(context) {
                                const total = context.dataset.data.reduce((acc, val) => acc + val, 0);
                                const value = context.raw;
                                const percentage = total > 0 ? Math.round((value / total) * 100) : 0;
                                return `${value} solicitudes (${percentage}%)`;
                            }
                        },
                        displayColors: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            font: {
                                size: 12,
                                weight: '500'
                            },
                            color: '#4B5563',
                            padding: 8
                        }
                    },
                    x: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(243, 244, 246, 0.8)',
                            drawBorder: false
                        },
                        ticks: {
                            font: {
                                size: 11
                            },
                            color: '#9CA3AF',
                            padding: 8,
                            callback: function(value) {
                                return value % 1 === 0 ? value : '';
                            }
                        }
                    }
                },
                animation: {
                    delay: function(context) {
                        return context.dataIndex * 200;
                    },
                    easing: 'easeOutQuart',
                    duration: 1500
                }
            },
            plugins: [{
                id: 'valueLabels',
                afterDatasetsDraw: function(chart) {
                    const ctx = chart.ctx;
                    
                    chart.data.datasets.forEach((dataset, datasetIndex) => {
                        const meta = chart.getDatasetMeta(datasetIndex);
                        
                        if (!meta.hidden) {
                            meta.data.forEach((element, index) => {
                                const value = dataset.data[index];
                                if (value === 0) return;
                                
                                // Obtener posición para el texto
                                const position = element.getCenterPoint();
                                const xPos = position.x + 20;
                                const yPos = position.y;
                                
                                // Configuración del texto
                                ctx.fillStyle = '#1F2937';
                                ctx.textAlign = 'left';
                                ctx.textBaseline = 'middle';
                                ctx.font = 'bold 14px Inter';
                                
                                // Dibujar valor
                                ctx.fillText(value, xPos, yPos);
                            });
                        }
                    });
                }
            }]
        }
    );
    
    // Añadir animación a los gráficos cuando están visibles en la pantalla
    const chartsSection = document.querySelector('.bg-white.rounded-xl.shadow-md.p-6.mb-8');
    if (chartsSection) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    // Reiniciar gráficos cuando son visibles
                    solicitudesChart.reset();
                    estadosChart.reset();
                    setTimeout(() => {
                        solicitudesChart.update();
                        estadosChart.update();
                    }, 100);
                    
                    // Dejar de observar una vez que se han animado
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.2 });
        
        observer.observe(chartsSection);
    }
} 