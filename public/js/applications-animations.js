document.addEventListener('DOMContentLoaded', function() {
    // Añadir animaciones suaves a los elementos
    const items = document.querySelectorAll('.divide-y > div');
    items.forEach((item, index) => {
        item.style.opacity = '0';
        item.style.transform = 'translateY(20px)';
        setTimeout(() => {
            item.style.transition = 'all 0.3s ease-out';
            item.style.opacity = '1';
            item.style.transform = 'translateY(0)';
        }, index * 100);
    });

    // Manejar el rechazo de solicitudes
    const rejectButtons = document.querySelectorAll('button[value="rechazada"]');
    rejectButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();

            const form = this.closest('form');
            const formData = new FormData(form);
            formData.append('estado', 'rechazada');

            // Mostrar confirmación
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¿Deseas rechazar esta solicitud?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, rechazar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Enviar la solicitud por AJAX
                    fetch(form.action, {
                        method: 'POST',
                        body: (() => {
                            const fd = new FormData(form);
                            fd.set('estado', 'rechazada');
                            fd.set('_method', 'PUT');
                            return fd;
                        })(),
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => {
                        return response.text().then(text => {
                            try {
                                const data = JSON.parse(text);
                                if (data.success) {
                                    // Actualizar la UI
                                    const solicitudContainer = form.closest('.p-6');
                                    const estadoBadge = solicitudContainer.querySelector('.inline-flex.items-center.px-3.py-1.rounded-full');

                                    // Actualizar el badge de estado
                                    estadoBadge.className = 'inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800';
                                    estadoBadge.innerHTML = `
                                        <span class="w-2 h-2 mr-2 rounded-full bg-red-400"></span>
                                        Rechazada
                                    `;

                                    // Ocultar el formulario
                                    form.style.display = 'none';

                                    // Mostrar mensaje de éxito
                                    Swal.fire(
                                        '¡Rechazada!',
                                        'La solicitud ha sido rechazada correctamente.',
                                        'success'
                                    );
                                } else {
                                    throw new Error(data.message || 'Error al rechazar la solicitud');
                                }
                            } catch (e) {
                                throw new Error('Respuesta inesperada del servidor:\n' + text);
                            }
                        });
                    })
                    .catch(error => {
                        Swal.fire(
                            'Error',
                            error.message || 'Ha ocurrido un error al procesar la solicitud',
                            'error'
                        );
                    });
                }
            });
        });
    });
});