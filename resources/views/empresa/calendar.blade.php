@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-purple-50 py-8">
    <div class="container mx-auto px-4">
        <!-- Breadcrumbs -->
        @component('components.breadcrumb')
            @slot('items')
                [{"name": "Dashboard", "url": "{{ route('empresa.dashboard') }}"}, {"name": "Calendario"}]
            @endslot
        @endcomponent

        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 mr-3 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Calendario de Eventos
                </h1>
                <button onclick="openEventModal()" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Nuevo Evento
                </button>
            </div>

            <div id="calendar" class="mt-4"></div>
        </div>
    </div>
</div>

<!-- Modal del Calendario -->
<div id="calendarModal" class="fixed inset-0 bg-black bg-opacity-50 hidden overflow-y-auto h-full w-full z-50 backdrop-blur-sm transition-all duration-300">
    <div class="relative top-20 mx-auto p-6 w-full max-w-4xl transform transition-all duration-300">
        <div class="bg-white rounded-xl shadow-2xl overflow-hidden">
            <div class="bg-gradient-to-r from-purple-600 to-indigo-600 py-4 px-6 flex justify-between items-center">
                <h3 class="text-xl font-bold text-white flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Calendario de Eventos
                </h3>
                <button onclick="closeCalendarModal()" class="text-white hover:text-gray-200 focus:outline-none transition-colors">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            
            <div class="p-6">
                <div id="calendar"></div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Nuevo/Editar Evento -->
<div id="eventModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-md">
            <div class="bg-gradient-to-r from-purple-600 to-indigo-600 rounded-t-xl px-6 py-4">
                <h3 class="text-xl font-semibold text-white" id="modalTitle">Nuevo Recordatorio</h3>
            </div>
            <form id="eventForm" class="p-6">
                @csrf
                <input type="hidden" id="eventId" name="id">
                <div class="space-y-4">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700">Título del recordatorio</label>
                        <input type="text" id="title" name="title" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500" placeholder="Ej: Entrevista con candidato">
                    </div>
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700">Descripción</label>
                        <textarea id="description" name="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500" placeholder="Detalles adicionales..."></textarea>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="start" class="block text-sm font-medium text-gray-700">Fecha y hora</label>
                            <input type="datetime-local" id="start" name="start" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                        </div>
                        <div>
                            <label for="color" class="block text-sm font-medium text-gray-700">Color</label>
                            <input type="color" id="color" name="color" value="#7C3AED" class="mt-1 block w-full h-10 rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                        </div>
                    </div>
                </div>
                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" onclick="closeEventModal()" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">
                        Cancelar
                    </button>
                    <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700">
                        Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('styles')
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css' rel='stylesheet' />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-material-ui@5/material-ui.min.css">
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales/es.js'></script>

<script>
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
            events: "{{ route('empresa.calendar.events') }}",
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
            : "{{ route('empresa.calendar.store') }}";
        
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
});
</script>
@endpush

@endsection
