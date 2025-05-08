@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-purple-50">
    <div class="container mx-auto px-4 py-8">
        <!-- Breadcrumbs -->
        @component('components.breadcrumb')
            @slot('items')
                [{"name": "Calendario"}]
            @endslot
        @endcomponent

        <div class="bg-white rounded-xl shadow-lg p-6">
            <div id='calendar'></div>
        </div>
    </div>
</div>

<!-- Modal para recordatorios -->
<div id="reminderModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-md">
            <div class="bg-gradient-to-r from-purple-600 to-indigo-600 rounded-t-xl px-6 py-4">
                <h3 class="text-xl font-semibold text-white" id="modalTitle">Nuevo Recordatorio</h3>
            </div>
            <form id="reminderForm" class="p-6">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700">Título</label>
                        <input type="text" name="title" id="title" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500" required>
                    </div>
                    
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700">Descripción</label>
                        <textarea name="description" id="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500"></textarea>
                    </div>
                    
                    <input type="hidden" id="eventDate" name="date">
                </div>
                
                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" onclick="closeModal()" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">
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
<!-- Estilos de FullCalendar -->
<link href='https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.10/main.min.css' rel='stylesheet' />
<style>
    .fc-theme-standard td, .fc-theme-standard th {
        @apply border border-gray-200;
    }
    
    .fc-daygrid-day {
        @apply cursor-pointer hover:bg-purple-50 transition-colors;
    }
    
    .fc-daygrid-day.fc-day-today {
        @apply bg-purple-50;
    }
    
    .fc-daygrid-day-number {
        @apply text-gray-700;
    }
    
    .fc-toolbar-title {
        @apply text-xl font-bold text-gray-800 !important;
    }
    
    .fc-button-primary {
        @apply bg-purple-600 border-purple-600 hover:bg-purple-700 hover:border-purple-700 !important;
    }
    
    .fc-event {
        @apply bg-purple-600 border-purple-600 cursor-pointer !important;
    }
</style>
@endpush

@push('scripts')
<!-- Scripts de FullCalendar -->
<script src='https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.10/index.global.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@6.1.10/index.global.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/@fullcalendar/interaction@6.1.10/index.global.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.10/locales/es.global.min.js'></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const calendarEl = document.getElementById('calendar');
    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'es',
        buttonText: {
            today: 'Hoy',
            month: 'Mes',
            week: 'Semana',
            day: 'Día',
            list: 'Lista'
        },
        monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
        dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
        dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'],
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth'
        },
        dateClick: function(info) {
            openModal(info.dateStr);
        },
        eventClick: function(info) {
            editEvent(info.event);
        },
        events: '/empresa/calendar/reminders',
        eventContent: function(arg) {
            return {
                html: `
                    <div class="fc-content">
                        <div class="fc-title">${arg.event.title}</div>
                    </div>
                `
            };
        }
    });
    
    calendar.render();

    // Manejar el formulario de recordatorios
    document.getElementById('reminderForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        
        fetch('/empresa/calendar/reminders', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify(Object.fromEntries(formData))
        })
        .then(response => response.json())
        .then(data => {
            calendar.refetchEvents();
            closeModal();
            // Limpiar el formulario
            this.reset();
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Hubo un error al guardar el recordatorio');
        });
    });
});

function openModal(date) {
    document.getElementById('eventDate').value = date;
    document.getElementById('reminderModal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('reminderModal').classList.add('hidden');
    document.getElementById('reminderForm').reset();
}

function editEvent(event) {
    document.getElementById('title').value = event.title;
    document.getElementById('description').value = event.extendedProps.description || '';
    document.getElementById('eventDate').value = event.startStr;
    document.getElementById('reminderModal').classList.remove('hidden');
}
</script>
@endpush
@endsection
