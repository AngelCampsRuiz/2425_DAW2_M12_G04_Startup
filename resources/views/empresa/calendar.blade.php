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

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Panel de recordatorios -->
            <div class="md:col-span-2">
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-2xl font-bold text-gray-800 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 mr-3 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Mis Recordatorios
                        </h1>
                        <button type="button" onclick="window.openReminderModal()" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Nuevo Recordatorio
                        </button>
                    </div>

                    <!-- Filtros -->
                    <div class="flex flex-wrap gap-2 mb-4">
                        <button class="filter-btn active py-1 px-3 rounded-full bg-purple-100 text-purple-700 text-sm font-medium" data-filter="all">
                            Todos
                        </button>
                        <button class="filter-btn py-1 px-3 rounded-full bg-gray-100 text-gray-700 text-sm font-medium" data-filter="pending">
                            Pendientes
                        </button>
                        <button class="filter-btn py-1 px-3 rounded-full bg-gray-100 text-gray-700 text-sm font-medium" data-filter="completed">
                            Completados
                        </button>
                        <button class="filter-btn py-1 px-3 rounded-full bg-gray-100 text-gray-700 text-sm font-medium" data-filter="today">
                            Hoy
                        </button>
                        <button class="filter-btn py-1 px-3 rounded-full bg-gray-100 text-gray-700 text-sm font-medium" data-filter="upcoming">
                            Próximos 7 días
                        </button>
                    </div>

                    <!-- Lista de recordatorios -->
                    <div class="space-y-4 max-h-[600px] overflow-y-auto pr-2">
                        @forelse($reminders as $reminder)
                            <div class="reminder-item border rounded-lg p-4 flex items-start gap-3 {{ $reminder->completed ? 'bg-gray-50 completed' : 'bg-white pending' }}" 
                                data-date="{{ $reminder->date->format('Y-m-d') }}"
                                data-id="{{ $reminder->id }}">
                                <div class="flex-shrink-0 mt-1">
                                    <button onclick="toggleReminder({{ $reminder->id }})" class="w-5 h-5 rounded-full border flex items-center justify-center {{ $reminder->completed ? 'bg-green-500 border-green-500' : 'border-gray-300' }}">
                                        @if($reminder->completed)
                                            <svg class="w-3 h-3 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                                            </svg>
                                        @endif
                                    </button>
                                </div>
                                <div class="flex-grow">
                                    <div class="flex justify-between items-start">
                                        <h3 class="font-medium text-gray-900 {{ $reminder->completed ? 'line-through text-gray-500' : '' }}">
                                            {{ $reminder->title }}
                                        </h3>
                                        <div class="flex items-center space-x-2">
                                            <button onclick="editReminder({{ $reminder->id }})" class="text-gray-500 hover:text-gray-700">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                </svg>
                                            </button>
                                            <form action="{{ route('empresa.reminder.destroy', $reminder) }}" method="POST" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700" onclick="return confirm('¿Estás seguro de eliminar este recordatorio?')">
                                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    @if($reminder->description)
                                        <p class="text-sm text-gray-600 mt-1">{{ $reminder->description }}</p>
                                    @endif
                                    <div class="mt-2 flex items-center text-xs text-gray-500">
                                        <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        {{ $reminder->date->format('d/m/Y') }}
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-12">
                                <p class="text-gray-500">No hay recordatorios. ¡Crea uno nuevo!</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Mini calendario -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <div id="mini-calendar"></div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para nuevo/editar recordatorio -->
<div id="reminderModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-md">
            <div class="bg-gradient-to-r from-purple-600 to-indigo-600 rounded-t-xl px-6 py-4">
                <h3 class="text-xl font-semibold text-white" id="modalTitle">Nuevo Recordatorio</h3>
            </div>
            <form id="reminderForm" action="{{ route('empresa.reminder.store') }}" method="POST" class="p-6">
                @csrf
                <input type="hidden" id="reminder_id" name="reminder_id">
                
                <div class="space-y-4">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700">Título</label>
                        <input type="text" name="title" id="title" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500" required>
                    </div>
                    
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700">Descripción (opcional)</label>
                        <textarea name="description" id="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500"></textarea>
                    </div>
                    
                    <div>
                        <label for="date" class="block text-sm font-medium text-gray-700">Fecha</label>
                        <input type="date" name="date" id="date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500" required>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Color</label>
                        <div class="mt-2 flex space-x-3">
                            @foreach(['#7C3AED', '#EC4899', '#F59E0B', '#10B981', '#3B82F6', '#6B7280'] as $color)
                                <label class="color-option">
                                    <input type="radio" name="color" value="{{ $color }}" class="sr-only" {{ $color === '#7C3AED' ? 'checked' : '' }}>
                                    <div class="w-8 h-8 rounded-full cursor-pointer border-2 hover:opacity-80" style="background-color: {{ $color }}; border-color: {{ $color }}"></div>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>
                
                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" onclick="window.closeReminderModal()" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">
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
@endpush

@push('scripts')
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales/es.js'></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Inicializar el calendario
    const calendarEl = document.getElementById('mini-calendar');
    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'es',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: ''
        },
        height: 'auto',
        selectable: true,
        select: function(info) {
            document.getElementById('date').value = info.startStr;
            window.openReminderModal();
        }
    });
    calendar.render();

    // Marcar fechas con recordatorios
    @foreach($reminders as $reminder)
        calendar.addEvent({
            title: '',
            start: '{{ $reminder->date->format('Y-m-d') }}',
            display: 'background',
            backgroundColor: '{{ $reminder->color }}30'
        });
    @endforeach
});

// Funciones globales
window.openReminderModal = function() {
    document.getElementById('reminderModal').classList.remove('hidden');
};

window.closeReminderModal = function() {
    document.getElementById('reminderModal').classList.add('hidden');
};

window.toggleReminder = function(id) {
    fetch(`/empresa/calendar/reminders/${id}/toggle`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    });
};

window.editReminder = function(id) {
    fetch(`/empresa/calendar/reminders/${id}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('reminder_id').value = data.id;
            document.getElementById('title').value = data.title;
            document.getElementById('description').value = data.description || '';
            document.getElementById('date').value = data.date;
            
            const colorInput = document.querySelector(`input[name="color"][value="${data.color}"]`);
            if (colorInput) {
                colorInput.checked = true;
            }
            
            document.getElementById('modalTitle').textContent = 'Editar Recordatorio';
            window.openReminderModal();
        });
};

// Event listeners
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        window.closeReminderModal();
    }
});

document.getElementById('reminderModal').addEventListener('click', function(e) {
    if (e.target === this) {
        window.closeReminderModal();
    }
});
</script>
@endpush

@endsection
