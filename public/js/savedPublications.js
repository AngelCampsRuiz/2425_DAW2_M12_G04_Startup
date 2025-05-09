document.addEventListener('DOMContentLoaded', function() {
    const csrf_token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    const saveButtons = document.querySelectorAll('.save-button');

    saveButtons.forEach(button => {
        button.addEventListener('click', async function(e) {
            e.preventDefault();
            const publicationId = button.getAttribute('data-id');
            const icon = button.querySelector('i');
            const isFavorito = icon.classList.contains('fas'); // Si está guardado

            try {
                let response;
                if (isFavorito) {
                    // Eliminar de favoritos
                    response = await fetch(`/favorite/${publicationId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': csrf_token,
                            'X-Requested-With': 'XMLHttpRequest',
                        },
                    });
                } else {
                    // Agregar a favoritos
                    response = await fetch(`/saved-publications/${publicationId}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrf_token,
                            'X-Requested-With': 'XMLHttpRequest',
                        },
                    });
                }

                if (response.ok) {
                    // Alternar el icono
                    if (isFavorito) {
                        icon.classList.remove('fas', 'text-yellow-500');
                        icon.classList.add('far', 'text-gray-400');
                    } else {
                        icon.classList.remove('far', 'text-gray-400');
                        icon.classList.add('fas', 'text-yellow-500');
                    }
                }
            } catch (error) {
                console.error('Error al guardar/eliminar favorito:', error);
            }
        });
    });

    const deleteButtons = document.querySelectorAll('.delete-button');

    deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
            Swal.fire({
                title: '¿Estás seguro?',
                text: '¿Quieres eliminar esta publicación de tus guardados?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, eliminar',
                cancelButtonText: 'Cancelar',
            }).then(async (result) => {
                if (result.isConfirmed) {
                    const publicationId = button.getAttribute('data-id');

                    try {
                        const response = await fetch(`/favorite/${publicationId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': csrf_token,
                                'X-Requested-With': 'XMLHttpRequest',
                            },
                        });

                        if (response.ok) {
                            // Remove the publication card from the UI
                            button.closest('.saved-publication').remove();

                            Swal.fire({
                                title: 'Eliminado',
                                text: 'La publicación ha sido eliminada de tus guardados',
                                icon: 'success',
                                timer: 2000,
                                showConfirmButton: false
                            });
                        } else {
                            throw new Error('Error en la respuesta del servidor');
                        }
                    } catch (error) {
                        console.error('Error al eliminar de guardados:', error);
                        Swal.fire({
                            title: 'Error',
                            text: 'Ocurrió un error al eliminar la publicación de tus guardados',
                            icon: 'error'
                        });
                    }
                }
            });
        });
    });

    // ...ya existente...
    function toggleMobileShareMenu() {
        const mobileShareMenu = document.getElementById('mobileShareMenu');
        if (mobileShareMenu.classList.contains('hidden')) {
            mobileShareMenu.classList.remove('hidden');
            mobileShareMenu.style.transform = 'translateY(0)';
        } else {
            mobileShareMenu.classList.add('hidden');
            mobileShareMenu.style.transform = 'translateY(100%)';
        }
    }

    // Cerrar al hacer clic fuera del menú
    document.addEventListener('click', function(e) {
        const mobileShareMenu = document.getElementById('mobileShareMenu');
        if (
            mobileShareMenu &&
            !mobileShareMenu.classList.contains('hidden') &&
            e.target === mobileShareMenu // solo si el fondo es el objetivo
        ) {
            toggleMobileShareMenu();
        }
    });
});
