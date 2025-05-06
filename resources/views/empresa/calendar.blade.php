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
<script src="{{ asset('js/calendar.js') }}"></script>

<script>
    // Función para editar recordatorio
    function editReminder(id) {
        // Cargar datos del recordatorio en el formulario
        fetch(`/empresa/calendar/reminders/${id}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('edit_reminder_id').value = data.id;
                document.getElementById('title').value = data.title;
                document.getElementById('description').value = data.description || '';
                document.getElementById('date').value = data.date;
                
                // Seleccionar el color correcto
                const colorInput = document.querySelector(`input[name="color"][value="${data.color}"]`);
                if (colorInput) {
                    colorInput.checked = true;
                    // Actualizar la visualización del color seleccionado
                    document.querySelectorAll('.check-mark').forEach(mark => mark.classList.add('hidden'));
                    colorInput.parentElement.querySelector('.check-mark').classList.remove('hidden');
                }
                
                // Cambiar el título del modal
                document.getElementById('modal-title').textContent = 'Editar Recordatorio';
                
                // Mostrar el modal
                document.getElementById('newReminderModal').classList.remove('hidden');
            });
    }

    // Función para filtrar recordatorios por fecha
    function filterByDate(date) {
        const items = document.querySelectorAll('.reminder-item');
        items.forEach(item => {
            if (item.dataset.date === date) {
                item.scrollIntoView({ behavior: 'smooth', block: 'center' });
                item.classList.add('highlight');
                setTimeout(() => item.classList.remove('highlight'), 2000);
            }
        });
    }

    // Cerrar modal con Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            document.getElementById('newReminderModal').classList.add('hidden');
        }
    });

    // Cerrar modal haciendo clic fuera
    document.getElementById('newReminderModal').addEventListener('click', function(e) {
        if (e.target === this) {
            this.classList.add('hidden');
        }
    });

    // Inicializar con el filtro "todos" activo
    document.querySelector('.filter-btn[data-filter="all"]').click();
});
</script>

<style>
    /* Estilos para el calendario y recordatorios */
    .fc-daygrid-day.fc-day-today {
        background-color: rgba(124, 58, 237, 0.1) !important;
    }

    .fc-daygrid-day-frame {
        cursor: pointer;
    }

    .fc-daygrid-day-frame:hover {
        background-color: rgba(124, 58, 237, 0.05);
    }

    .reminder-item {
        transition: all 0.3s ease;
    }

    .reminder-item.highlight {
        background-color: rgba(124, 58, 237, 0.1);
        transform: scale(1.02);
    }

    .filter-btn.active {
        background-color: rgba(124, 58, 237, 0.1);
        color: rgb(124, 58, 237);
    }

    /* Personalización del scrollbar */
    .max-h-\[600px\]::-webkit-scrollbar {
        width: 8px;
    }

    .max-h-\[600px\]::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }

    .max-h-\[600px\]::-webkit-scrollbar-thumb {
        background: #ddd;
        border-radius: 4px;
    }

    .max-h-\[600px\]::-webkit-scrollbar-thumb:hover {
        background: #ccc;
    }

    /* Animaciones */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .reminder-item {
        animation: fadeIn 0.3s ease-out;
    }
</style>
@endpush

@endsection
