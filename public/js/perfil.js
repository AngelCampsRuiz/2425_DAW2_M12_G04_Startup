// Mostrar/ocultar el dropdown
document.addEventListener('DOMContentLoaded', function() {
    // User menu dropdown
    const userMenuButton = document.getElementById('userMenuButton')
    if (userMenuButton) {
        userMenuButton.addEventListener('click', function() {
            const menu = document.getElementById('userMenu')
            if (menu) {
                menu.classList.toggle('hidden')
            }
        })
    }

    // Función para mostrar/ocultar el dropdown
    const toggleButton = document.getElementById('toggleDropdown')
    const dropdown = document.getElementById('dropdownContent')

    if (toggleButton && dropdown) {
        const icon = toggleButton.querySelector('i')

        if (icon) {
            toggleButton.addEventListener('click', function() {
                if (dropdown.style.maxHeight && dropdown.style.maxHeight !== "0px") {
                    dropdown.style.maxHeight = "0px"
                    dropdown.classList.remove('show')
                    icon.classList.remove('fa-chevron-up')
                    icon.classList.add('fa-chevron-down')
                } else {
                    dropdown.style.maxHeight = dropdown.scrollHeight + "px"
                    dropdown.classList.add('show')
                    icon.classList.remove('fa-chevron-down')
                    icon.classList.add('fa-chevron-up')
                }
            })
        }
    }

    const toggleVisibilityButton = document.getElementById('toggleVisibility')

    if (toggleVisibilityButton) {
        // Establecer el estado inicial del icono basado en el atributo data-visibility
        const initialVisibility = toggleVisibilityButton.getAttribute('data-visibility') === "1"
        const icon = toggleVisibilityButton.querySelector('i')
        if (icon) {
            if (initialVisibility) {
                icon.classList.remove('fa-eye-slash')
                icon.classList.add('fa-eye')
            } else {
                icon.classList.remove('fa-eye')
                icon.classList.add('fa-eye-slash')
            }
        }

        toggleVisibilityButton.addEventListener('click', function() {
            const userId = toggleVisibilityButton.getAttribute('data-user-id')
            console.log('User ID:', userId)

            // Obtener el estado actual de visibilidad desde el ícono
            const icon = toggleVisibilityButton.querySelector('i')
            const isCurrentlyVisible = icon && icon.classList.contains('fa-eye')

            Swal.fire({
                title: isCurrentlyVisible ? '¿Quieres ocultar esta información?' : '¿Quieres mostrar esta información?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: isCurrentlyVisible ? 'Sí, ocultar' : 'Sí, mostrar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch('/update-visibility', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                        },
                        body: JSON.stringify({ user_id: userId })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Cambiar el ícono
                            if (icon) {
                                icon.classList.toggle('fa-eye')
                                icon.classList.toggle('fa-eye-slash')
                            }

                            // Mostrar SweetAlert de confirmación
                            Swal.fire({
                                title: isCurrentlyVisible ? 'Información privada' : 'Información visible',
                                text: isCurrentlyVisible ? 'Ahora estos datos son privados' : 'Ahora estos datos son visibles para todos',
                                icon: 'success',
                                timer: 2000,
                                showConfirmButton: false
                            })

                            // Solo actualizar la visibilidad para otros usuarios
                            // Para el propio usuario, el dropdown siempre permanece visible
                            if (window.location.pathname !== '/profile/' + userId) {
                                if (isCurrentlyVisible) {
                                    if (dropdown) {
                                        dropdown.style.maxHeight = "0px"
                                        dropdown.classList.remove('show')
                                    }
                                    if (toggleButton) {
                                        toggleButton.style.display = "none"
                                    }
                                } else {
                                    if (toggleButton) {
                                        toggleButton.style.display = "block"
                                    }
                                }
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error)
                        Swal.fire({
                            title: 'Error',
                            text: 'Ha ocurrido un error al actualizar la visibilidad',
                            icon: 'error'
                        })
                    })
                }
            })
        })
    }

    const form = document.getElementById('profileForm');
    if (form) {
        form.addEventListener('submit', handleFormSubmit);
    }
})

function handleFormSubmit(event) {
    event.preventDefault();
    // Aquí puedes añadir la lógica del formulario si es necesaria
}
