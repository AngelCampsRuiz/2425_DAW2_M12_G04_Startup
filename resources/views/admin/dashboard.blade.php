{{-- HEADER --}}
@extends('layouts.app')

{{-- CONTENIDO --}}
@section('content')
    <div class="container mx-auto px-4 py-6">
        <!-- Menú hamburguesa para móviles y título del CRUD actual -->
        <div class="flex justify-between items-center mb-6 bg-white rounded-lg shadow p-4">
            <div class="flex items-center">
                <button id="menu-toggle" class="md:hidden mr-4 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-800" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <h1 class="text-xl font-bold text-purple-800 md:hidden">
                    @if(request()->routeIs('admin.publicaciones.*'))
                        OFERTAS
                    @elseif(request()->routeIs('admin.categorias.*'))
                        CATEGORÍAS
                    @elseif(request()->routeIs('admin.empresas.*'))
                        EMPRESAS
                    @elseif(request()->routeIs('admin.alumnos.*'))
                        ALUMNOS
                    @elseif(request()->routeIs('admin.profesores.*'))
                        PROFESORES
                    @else
                        PANEL DE ADMINISTRACIÓN
                    @endif
                </h1>
            </div>
            <!-- Título centrado para escritorio -->
            <div class="hidden md:block text-center flex-1">
                <h1 class="text-2xl font-bold text-purple-800">
                    @if(request()->routeIs('admin.publicaciones.*'))
                        OFERTAS
                    @elseif(request()->routeIs('admin.categorias.*'))
                        CATEGORÍAS
                    @elseif(request()->routeIs('admin.empresas.*'))
                        EMPRESAS
                    @elseif(request()->routeIs('admin.alumnos.*'))
                        ALUMNOS
                    @elseif(request()->routeIs('admin.profesores.*'))
                        PROFESORES
                    @else
                        PANEL DE ADMINISTRACIÓN
                    @endif
                </h1>
            </div>
            <!-- Espacio vacío para mantener centrado el título en escritorio -->
            <div class="hidden md:block">
                <div class="w-6"></div>
            </div>
        </div>

        <!-- Menú de navegación, oculto en móviles inicialmente -->
        <div id="menu-nav" class="mb-6 bg-white rounded-lg shadow p-4 hidden md:block">
            <div class="flex flex-wrap">
                <a href="{{ route('admin.publicaciones.index') }}" class="flex-1 {{ request()->routeIs('admin.publicaciones.*') ? 'bg-purple-200 text-purple-800' : 'bg-gray-100 text-gray-800' }} font-semibold py-3 px-4 rounded-md text-center mx-1 mb-2 md:mb-0">
                    OFERTAS
                </a>
                <a href="#" class="flex-1 bg-gray-100 text-gray-800 font-semibold py-3 px-4 rounded-md text-center mx-1 mb-2 md:mb-0">
                    CATEGORÍAS
                </a>
                <a href="#" class="flex-1 bg-gray-100 text-gray-800 font-semibold py-3 px-4 rounded-md text-center mx-1 mb-2 md:mb-0">
                    EMPRESAS
                </a>
                <a href="#" class="flex-1 bg-gray-100 text-gray-800 font-semibold py-3 px-4 rounded-md text-center mx-1 mb-2 md:mb-0">
                    ALUMNOS
                </a>
                <a href="#" class="flex-1 bg-gray-100 text-gray-800 font-semibold py-3 px-4 rounded-md text-center mx-1 mb-2 md:mb-0">
                    PROFESORES
                </a>
            </div>
        </div>

        @if(request()->routeIs('admin.dashboard'))
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-2xl font-semibold mb-6 text-purple-800">Panel de Administración</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-blue-50 rounded-lg p-6 shadow-sm">
                        <div class="flex items-center mb-3">
                            <div class="bg-blue-100 p-3 rounded-full mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-800">Publicaciones</h3>
                        </div>
                        <p class="text-gray-600">Gestiona las ofertas de prácticas para los estudiantes.</p>
                        <div class="mt-4">
                            <a href="{{ route('admin.publicaciones.index') }}" class="text-blue-600 hover:text-blue-800 font-medium">
                                Gestionar publicaciones →
                            </a>
                        </div>
                    </div>
                    
                    <div class="bg-green-50 rounded-lg p-6 shadow-sm">
                        <div class="flex items-center mb-3">
                            <div class="bg-green-100 p-3 rounded-full mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-800">Empresas</h3>
                        </div>
                        <p class="text-gray-600">Administra las empresas colaboradoras con la plataforma.</p>
                        <div class="mt-4">
                            <a href="#" class="text-green-600 hover:text-green-800 font-medium">
                                Gestionar empresas →
                            </a>
                        </div>
                    </div>
                    
                    <div class="bg-purple-50 rounded-lg p-6 shadow-sm">
                        <div class="flex items-center mb-3">
                            <div class="bg-purple-100 p-3 rounded-full mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-800">Alumnos</h3>
                        </div>
                        <p class="text-gray-600">Gestiona los perfiles de estudiantes registrados.</p>
                        <div class="mt-4">
                            <a href="#" class="text-purple-600 hover:text-purple-800 font-medium">
                                Gestionar alumnos →
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gray-50 p-6 rounded-lg shadow-sm">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Actividad reciente</h3>
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <div class="bg-blue-100 p-2 rounded-full mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-gray-800 font-medium">Nueva oferta de prácticas añadida</p>
                                <p class="text-gray-500 text-sm">Hace 2 horas</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="bg-green-100 p-2 rounded-full mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-gray-800 font-medium">Nueva empresa registrada</p>
                                <p class="text-gray-500 text-sm">Hace 1 día</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="bg-purple-100 p-2 rounded-full mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-gray-800 font-medium">Nuevo alumno registrado</p>
                                <p class="text-gray-500 text-sm">Hace 3 días</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @yield('admin_content')
    </div>

    <!-- JavaScript para el menú hamburguesa -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const menuToggle = document.getElementById('menu-toggle');
            const menuNav = document.getElementById('menu-nav');
            
            menuToggle.addEventListener('click', function() {
                menuNav.classList.toggle('hidden');
            });
            
            // Ocultar menú en pantallas pequeñas cuando se hace clic en un enlace
            const menuLinks = menuNav.querySelectorAll('a');
            menuLinks.forEach(link => {
                link.addEventListener('click', function() {
                    if (window.innerWidth < 768) { // 768px es el breakpoint md de Tailwind
                        menuNav.classList.add('hidden');
                    }
                });
            });
            
            // Ajustar visibilidad del menú en cambio de tamaño de ventana
            window.addEventListener('resize', function() {
                if (window.innerWidth >= 768) {
                    menuNav.classList.remove('hidden');
                } else {
                    menuNav.classList.add('hidden');
                }
            });
        });
    </script>
    
    <!-- CSRF token para AJAX -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Scripts adicionales para la sección admin -->
    <script>
        // Asegurarse de que los listeners de eventos se apliquen a elementos cargados dinámicamente
        document.addEventListener('DOMContentLoaded', function() {
            // Delegación de eventos para todos los botones y formularios
            document.addEventListener('click', function(e) {
                // Botón de crear
                if (e.target.closest('.btn-crear')) {
                    resetForm();
                    document.getElementById('modal-titulo').textContent = 'Crear Nueva Publicación';
                    document.getElementById('form-publicacion').setAttribute('action', '{{ route('admin.publicaciones.store') }}');
                    document.getElementById('form_method').value = 'POST';
                    document.getElementById('modal-publicacion').classList.remove('hidden');
                }
                
                // Botón de editar
                if (e.target.closest('.btn-editar')) {
                    const id = e.target.closest('.btn-editar').getAttribute('data-id');
                    cargarPublicacion(id);
                }
                
                // Botón de eliminar
                if (e.target.closest('.btn-eliminar')) {
                    const id = e.target.closest('.btn-eliminar').getAttribute('data-id');
                    document.getElementById('eliminar_id').value = id;
                    document.getElementById('form-eliminar').setAttribute('action', '{{ route('admin.publicaciones.index') }}/' + id);
                    document.getElementById('modal-eliminar').classList.remove('hidden');
                }
                
                // Botones de cerrar y cancelar
                if (e.target.closest('#modal-close') || e.target.closest('#btn-cancelar')) {
                    document.getElementById('modal-publicacion').classList.add('hidden');
                }
                
                if (e.target.closest('#modal-eliminar-close') || e.target.closest('#btn-cancelar-eliminar')) {
                    document.getElementById('modal-eliminar').classList.add('hidden');
                }
                
                // Enlaces de paginación
                const paginationLink = e.target.closest('.pagination-link');
                if (paginationLink) {
                    e.preventDefault();
                    const url = paginationLink.getAttribute('href');
                    actualizarTabla(url);
                }
            });
            
            // Manejo de envío de formularios
            document.addEventListener('submit', function(e) {
                // Formulario de crear/editar
                if (e.target.id === 'form-publicacion') {
                    e.preventDefault();
                    const formData = new FormData(e.target);
                    const url = e.target.getAttribute('action');
                    const method = document.getElementById('form_method').value;
                    
                    fetch(url, {
                        method: method === 'PUT' ? 'POST' : 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            document.getElementById('modal-publicacion').classList.add('hidden');
                            mostrarMensajeExito(data.message);
                            actualizarTabla();
                        } else if (data.errors) {
                            mostrarErrores(data.errors);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
                }
                
                // Formulario de eliminar
                if (e.target.id === 'form-eliminar') {
                    e.preventDefault();
                    const url = e.target.getAttribute('action');
                    
                    fetch(url, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'X-Requested-With': 'XMLHttpRequest',
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            document.getElementById('modal-eliminar').classList.add('hidden');
                            mostrarMensajeExito(data.message);
                            actualizarTabla();
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
                }
            });
            
            // Definir funciones auxiliares que podrían ser llamadas por los eventos
            window.resetForm = function() {
                if (document.getElementById('form-publicacion')) {
                    document.getElementById('form-publicacion').reset();
                    document.getElementById('publicacion_id').value = '';
                    document.getElementById('fecha_publicacion').value = new Date().toISOString().split('T')[0];
                    document.getElementById('form-errors').classList.add('hidden');
                    document.getElementById('error-list').innerHTML = '';
                }
            };
            
            window.cargarPublicacion = function(id) {
                fetch('{{ route('admin.publicaciones.index') }}/' + id + '/edit', {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    resetForm();
                    
                    const publicacion = data.publicacion;
                    
                    document.getElementById('publicacion_id').value = publicacion.id;
                    document.getElementById('titulo').value = publicacion.titulo;
                    document.getElementById('descripcion').value = publicacion.descripcion;
                    document.getElementById('horario').value = publicacion.horario;
                    document.getElementById('horas_totales').value = publicacion.horas_totales;
                    document.getElementById('fecha_publicacion').value = publicacion.fecha_publicacion.split(' ')[0];
                    document.getElementById('activa').checked = publicacion.activa == 1;
                    document.getElementById('empresa_id').value = publicacion.empresa_id;
                    document.getElementById('categoria_id').value = publicacion.categoria_id;
                    document.getElementById('subcategoria_id').value = publicacion.subcategoria_id;
                    
                    document.getElementById('modal-titulo').textContent = 'Editar Publicación';
                    document.getElementById('form-publicacion').setAttribute('action', '{{ route('admin.publicaciones.index') }}/' + id);
                    document.getElementById('form_method').value = 'PUT';
                    
                    document.getElementById('modal-publicacion').classList.remove('hidden');
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            };
            
            window.mostrarMensajeExito = function(mensaje) {
                const messageElement = document.getElementById('success-message');
                const messageText = document.getElementById('success-message-text');
                
                messageText.textContent = mensaje;
                messageElement.style.display = 'block';
                
                setTimeout(function() {
                    messageElement.style.display = 'none';
                }, 5000);
            };
            
            window.mostrarErrores = function(errores) {
                const errorsDiv = document.getElementById('form-errors');
                const errorsList = document.getElementById('error-list');
                
                errorsList.innerHTML = '';
                
                for (const key in errores) {
                    errores[key].forEach(error => {
                        const li = document.createElement('li');
                        li.textContent = error;
                        errorsList.appendChild(li);
                    });
                }
                
                errorsDiv.classList.remove('hidden');
            };
            
            window.actualizarTabla = function(url = '{{ route('admin.publicaciones.index') }}') {
                fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    document.getElementById('tabla-container').innerHTML = data.tabla;
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            };
        });
    </script>
@endsection
