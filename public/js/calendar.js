document.addEventListener('DOMContentLoaded', function() {
    let calendar = null;

    // Función para inicializar el calendario
    function initializeCalendar() {
        const calendarEl = document.getElementById('calendar');
        if (!calendarEl) return;

        calendar = new FullCalendar.Calendar(calendarEl, {
            locale: 'es',
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            events: "/empresa/calendar/events",
            editable: true,
            selectable: true,
            selectMirror: true,
            dayMaxEvents: true,
            select: function(info) {
                // Prellenar la fecha seleccionada
                document.getElementById('start').value = info.startStr;
                openEventModal();
            },
            eventClick: function(info) {
                editEvent(info.event);
            },
            eventDrop: function(info) {
                updateEventDates(info.event);
            }
        });

        calendar.render();
    }

    // Funciones para manejar los modales
    window.openCalendarModal = function() {
        document.getElementById('calendarModal').classList.remove('hidden');
        if (!calendar) {
            initializeCalendar();
        } else {
            calendar.render();
        }
    }

    window.closeCalendarModal = function() {
        document.getElementById('calendarModal').classList.add('hidden');
    }

    window.openEventModal = function() {
        document.getElementById('eventModal').classList.remove('hidden');
    }

    window.closeEventModal = function() {
        document.getElementById('eventModal').classList.add('hidden');
        document.getElementById('eventForm').reset();
    }

    window.editEvent = function(event) {
        document.getElementById('eventId').value = event.id;
        document.getElementById('title').value = event.title;
        document.getElementById('description').value = event.extendedProps.description || '';
        document.getElementById('start').value = event.start.toISOString().slice(0, 16);
        document.getElementById('color').value = event.backgroundColor || '#7C3AED';
        
        openEventModal();
    }

    // Manejar el envío del formulario
    document.getElementById('eventForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        const eventId = formData.get('id');
        
        const url = eventId 
            ? `/empresa/calendar/events/${eventId}`
            : "/empresa/calendar/events";
        
        fetch(url, {
            method: eventId ? 'PUT' : 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                calendar.refetchEvents();
                closeEventModal();
                Swal.fire({
                    title: '¡Éxito!',
                    text: data.message,
                    icon: 'success',
                    confirmButtonColor: '#7C3AED'
                });
            }
        })
        .catch(error => {
            Swal.fire({
                title: 'Error',
                text: 'Ha ocurrido un error al guardar el evento',
                icon: 'error',
                confirmButtonColor: '#7C3AED'
            });
        });
    });

    // Cerrar modales con Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeEventModal();
            closeCalendarModal();
        }
    });

    // Cerrar modales al hacer clic fuera
    document.getElementById('calendarModal').addEventListener('click', function(e) {
        if (e.target === this) closeCalendarModal();
    });

    document.getElementById('eventModal').addEventListener('click', function(e) {
        if (e.target === this) closeEventModal();
    });

    // Inicializar el calendario
    initializeCalendar();
});
