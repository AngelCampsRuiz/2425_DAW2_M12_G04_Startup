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
                    <input type="hidden" id="eventId" name="id">
                </div>
                
                <div class="mt-6 flex justify-between">
                    <!-- Botón de eliminar (inicialmente oculto) -->
                    <button type="button" id="deleteButton" onclick="deleteEvent()" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 hidden">
                        Eliminar
                    </button>
                    
                    <div class="flex space-x-3">
                        <button type="button" onclick="closeModal()" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">
                            Cancelar
                        </button>
                        <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700">
                            Guardar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal de confirmación para eliminar -->
<div id="confirmDeleteModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-md p-6">
            <h3 class="text-xl font-semibold text-gray-800 mb-4">Confirmar eliminación</h3>
            <p class="text-gray-600 mb-6">¿Estás seguro de que deseas eliminar este recordatorio?</p>
            <div class="flex justify-end space-x-3">
                <button type="button" onclick="closeConfirmModal()" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">
                    Cancelar
                </button>
                <button type="button" onclick="confirmDelete()" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                    Eliminar
                </button>
            </div>
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
// Variable global para el ID del evento a eliminar
let eventIdToDelete = null;

// Declarar calendar como variable global
let calendar;

document.addEventListener('DOMContentLoaded', function() {
    const calendarEl = document.getElementById('calendar');
    calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'es',
        height: 800,
        customButtons: {
            mesButton: {
                text: 'Mes',
                click: function(e) {
                    const button = e.currentTarget;
                    const rect = button.getBoundingClientRect();
                    
                    // Crear y mostrar el desplegable de meses
                    let dropdown = document.getElementById('mes-dropdown');
                    if (!dropdown) {
                        dropdown = document.createElement('div');
                        dropdown.id = 'mes-dropdown';
                        dropdown.style.position = 'absolute';
                        dropdown.style.backgroundColor = 'white';
                        dropdown.style.border = '1px solid #ddd';
                        dropdown.style.borderRadius = '4px';
                        dropdown.style.boxShadow = '0 2px 5px rgba(0,0,0,0.2)';
                        dropdown.style.zIndex = 1000;
                        
                        const meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 
                                     'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
                        
                        meses.forEach((mes, index) => {
                            const item = document.createElement('div');
                            item.className = 'mes-item';
                            item.style.padding = '8px 16px';
                            item.style.cursor = 'pointer';
                            item.style.hover = 'background-color: #f0f0f0';
                            item.innerText = mes;
                            
                            item.addEventListener('mouseover', () => {
                                item.style.backgroundColor = '#f0f0f0';
                            });
                            item.addEventListener('mouseout', () => {
                                item.style.backgroundColor = 'white';
                            });
                            
                            item.addEventListener('click', () => {
                                const date = calendar.getDate();
                                calendar.gotoDate(new Date(date.getFullYear(), index, 1));
                                dropdown.remove();
                            });
                            
                            dropdown.appendChild(item);
                        });
                        
                        document.body.appendChild(dropdown);
                    }
                    
                    dropdown.style.top = `${rect.bottom + window.scrollY}px`;
                    dropdown.style.left = `${rect.left}px`;
                }
            },
            yearButton: {
                text: 'Año',
                click: function(e) {
                    const button = e.currentTarget;
                    const rect = button.getBoundingClientRect();
                    
                    // Crear y mostrar el desplegable de años
                    let dropdown = document.getElementById('year-dropdown');
                    if (!dropdown) {
                        dropdown = document.createElement('div');
                        dropdown.id = 'year-dropdown';
                        dropdown.style.position = 'absolute';
                        dropdown.style.backgroundColor = 'white';
                        dropdown.style.border = '1px solid #ddd';
                        dropdown.style.borderRadius = '4px';
                        dropdown.style.boxShadow = '0 2px 5px rgba(0,0,0,0.2)';
                        dropdown.style.zIndex = 1000;
                        dropdown.style.maxHeight = '200px';
                        dropdown.style.overflowY = 'auto';
                        
                        const currentYear = new Date().getFullYear();
                        for (let year = currentYear - 5; year <= currentYear + 5; year++) {
                            const item = document.createElement('div');
                            item.className = 'year-item';
                            item.style.padding = '8px 16px';
                            item.style.cursor = 'pointer';
                            item.innerText = year;
                            
                            item.addEventListener('mouseover', () => {
                                item.style.backgroundColor = '#f0f0f0';
                            });
                            item.addEventListener('mouseout', () => {
                                item.style.backgroundColor = 'white';
                            });
                            
                            item.addEventListener('click', () => {
                                const date = calendar.getDate();
                                calendar.gotoDate(new Date(year, date.getMonth(), 1));
                                dropdown.remove();
                            });
                            
                            dropdown.appendChild(item);
                        }
                        
                        document.body.appendChild(dropdown);
                    }
                    
                    dropdown.style.top = `${rect.bottom + window.scrollY}px`;
                    dropdown.style.left = `${rect.left}px`;
                }
            }
        },
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'mesButton,yearButton'
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
    
    // Cerrar los desplegables al hacer clic fuera de ellos
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.fc-mesButton-button') && !e.target.closest('#mes-dropdown')) {
            const mesDropdown = document.getElementById('mes-dropdown');
            if (mesDropdown) mesDropdown.remove();
        }
        if (!e.target.closest('.fc-yearButton-button') && !e.target.closest('#year-dropdown')) {
            const yearDropdown = document.getElementById('year-dropdown');
            if (yearDropdown) yearDropdown.remove();
        }
    });
    
    calendar.render();

    // Manejar el formulario de recordatorios
    document.getElementById('reminderForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        const eventId = document.getElementById('eventId').value;
        
        // Determinar si es una edición o una creación nueva
        const method = eventId ? 'PUT' : 'POST';
        const url = eventId ? `/empresa/calendar/reminders/${eventId}` : '/empresa/calendar/reminders';
        
        fetch(url, {
            method: method,
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
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Hubo un error al guardar el recordatorio');
        });
    });
});

function openModal(date) {
    document.getElementById('eventDate').value = date;
    document.getElementById('eventId').value = '';
    document.getElementById('deleteButton').classList.add('hidden');
    document.getElementById('modalTitle').textContent = 'Nuevo Recordatorio';
    document.getElementById('reminderModal').classList.remove('hidden');
}

function editEvent(event) {
    document.getElementById('title').value = event.title;
    document.getElementById('description').value = event.extendedProps.description || '';
    document.getElementById('eventDate').value = event.startStr;
    document.getElementById('eventId').value = event.id;
    document.getElementById('deleteButton').classList.remove('hidden');
    document.getElementById('modalTitle').textContent = 'Editar Recordatorio';
    document.getElementById('reminderModal').classList.remove('hidden');
}

function deleteEvent() {
    eventIdToDelete = document.getElementById('eventId').value;
    if (!eventIdToDelete) return;
    
    // Mostrar el modal de confirmación personalizado
    document.getElementById('confirmDeleteModal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('reminderModal').classList.add('hidden');
    document.getElementById('reminderForm').reset();
    document.getElementById('eventId').value = '';
    document.getElementById('deleteButton').classList.add('hidden');
}

function closeConfirmModal() {
    document.getElementById('confirmDeleteModal').classList.add('hidden');
    eventIdToDelete = null;
}

function confirmDelete() {
    if (!eventIdToDelete) return;

    fetch(`/empresa/calendar/reminders/${eventIdToDelete}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        calendar.refetchEvents();
        closeModal();
        closeConfirmModal();
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Hubo un error al eliminar el recordatorio');
    });
}
</script>
@endpush
@endsection
