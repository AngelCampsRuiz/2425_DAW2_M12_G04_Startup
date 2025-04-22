@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-100">
        {{-- BREADCRUMBS --}}
        <div class="bg-white shadow-sm">
            <div class="container mx-auto px-4 py-3">
                <div class="flex items-center text-sm">
                    <a href="{{ route('home') }}" class="text-gray-500 hover:text-[#5e0490]">
                        <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        Inicio
                    </a>
                    <span class="mx-2 text-gray-400">/</span>
                    <a href="{{ route('student.dashboard') }}" class="text-gray-500 hover:text-[#5e0490]">
                        Ofertas laborales
                    </a>
                    <span class="mx-2 text-gray-400">/</span>
                    <span class="text-[#5e0490] font-medium truncate max-w-xs">{{ $publication->titulo }}</span>
                </div>
            </div>
        </div>
        
        <div class="container mx-auto px-4 py-8">
            <!-- Botón de regreso -->
            <div class="mb-6">
                <a href="{{ route('student.dashboard') }}" class="inline-flex items-center text-sm font-medium text-[#5e0490] hover:text-[#4a0370] transition-colors duration-300">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Volver a las ofertas
                </a>
            </div>
            
            <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100">
                <!-- Cabecera con categoría -->
                <div class="bg-gradient-to-r from-[#5e0490] to-[#8a2be2] px-6 py-4 text-white">
                    <div class="flex justify-between items-center">
                        <h2 class="text-2xl font-bold">{{ $publication->titulo }}</h2>
                        <span class="bg-white/20 text-white text-sm font-medium px-3 py-1 rounded-full">
                            {{ ucfirst($publication->categoria->nombre_categoria ?? 'General') }}
                        </span>
                    </div>
                </div>
                
                <div class="flex flex-col md:flex-row">
                    {{-- IMAGEN DE LA EMPRESA --}}
                    <div class="w-full md:w-1/3 p-6 flex flex-col items-center justify-center bg-gray-50">
                        <div class="w-48 h-48 rounded-lg overflow-hidden border-4 border-white shadow-lg mb-4 flex items-center justify-center" style="aspect-ratio: 1/1;">
                            <img src="{{ asset('public/profile_images/' . ($publication->empresa->user->imagen ?? 'company-default.png')) }}" 
                                alt="{{ $publication->empresa->nombre }}"
                                class="max-w-[85%] max-h-[85%] object-contain">
                        </div>
                        <a href="{{ route('profile.show', $publication->empresa->user->id) }}" class="group">
                            <h3 class="text-xl font-bold text-[#5e0490] text-center group-hover:text-[#4a0370] transition-colors duration-300">
                                {{ $publication->empresa->user->nombre }}
                                <span class="inline-block ml-1 transition-transform duration-300 group-hover:translate-x-1">
                                    <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                    </svg>
                                </span>
                            </h3>
                        </a>
                        
                        <!-- Información de contacto de la empresa si está disponible -->
                        @if(isset($publication->empresa->email) || isset($publication->empresa->telefono))
                        <div class="mt-4 text-center">
                            @if(isset($publication->empresa->email))
                            <p class="text-sm text-gray-600 mb-1">
                                <span class="inline-block w-5 h-5 mr-1">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                </span>
                                {{ $publication->empresa->email }}
                            </p>
                            @endif
                            @if(isset($publication->empresa->telefono))
                            <p class="text-sm text-gray-600">
                                <span class="inline-block w-5 h-5 mr-1">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                </span>
                                {{ $publication->empresa->telefono }}
                            </p>
                            @endif
                        </div>
                        @endif
                        
                        
                    </div>
                    
                    {{-- INFORMACIÓN DE LA PUBLICACIÓN --}}
                    <div class="w-full md:w-2/3 p-6">
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-700 mb-4">Detalles de la oferta</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                                <div class="flex items-center p-4 bg-purple-50 rounded-lg">
                                    <span class="flex items-center justify-center w-10 h-10 mr-3 bg-[#5e0490] rounded-full">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </span>
                                    <div>
                                        <p class="text-xs text-gray-500">Horario</p>
                                        <p class="font-semibold text-gray-800">{{ ucfirst($publication->horario) }}</p>
                                    </div>
                                </div>
                                
                                <div class="flex items-center p-4 bg-purple-50 rounded-lg">
                                    <span class="flex items-center justify-center w-10 h-10 mr-3 bg-[#5e0490] rounded-full">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                        </svg>
                                    </span>
                                    <div>
                                        <p class="text-xs text-gray-500">Duración</p>
                                        <p class="font-semibold text-gray-800">{{ $publication->horas_totales }} horas</p>
                                    </div>
                                </div>

                                <!-- Añadimos el contador de solicitudes -->
                                <div class="flex items-center p-4 bg-purple-50 rounded-lg">
                                    <span class="flex items-center justify-center w-10 h-10 mr-3 bg-[#5e0490] rounded-full">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                        </svg>
                                    </span>
                                    <div>
                                        <p class="text-xs text-gray-500">Solicitudes recibidas</p>
                                        <p class="font-semibold text-gray-800">{{ $publication->solicitudes_count }} {{ Str::plural('candidato', $publication->solicitudes_count) }}</p>
                                    </div>
                                </div>
                                
                                @if(isset($publication->fecha_publicacion))
                                <div class="flex items-center p-4 bg-purple-50 rounded-lg">
                                    <span class="flex items-center justify-center w-10 h-10 mr-3 bg-[#5e0490] rounded-full">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </span>
                                    <div>
                                        <p class="text-xs text-gray-500">Fecha de publicación</p>
                                        <p class="font-semibold text-gray-800">{{ \Carbon\Carbon::parse($publication->fecha_publicacion)->format('d/m/Y') }}</p>
                                    </div>
                                </div>
                                @endif
                                
                                @if(isset($publication->subcategoria))
                                <div class="flex items-center p-4 bg-purple-50 rounded-lg">
                                    <span class="flex items-center justify-center w-10 h-10 mr-3 bg-[#5e0490] rounded-full">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                        </svg>
                                    </span>
                                    <div>
                                        <p class="text-xs text-gray-500">Subcategoría</p>
                                        <p class="font-semibold text-gray-800">{{ $publication->subcategoria->nombre_subcategoria }}</p>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                        
                        <div>
                            <h3 class="text-lg font-semibold text-gray-700 mb-4">Descripción</h3>
                            <div class="bg-gray-50 p-5 rounded-lg border border-gray-100">
                                <p class="text-gray-700 whitespace-pre-line">{{ $publication->descripcion }}</p>
                            </div>
                        </div>
                        
                        <!-- Botón de solicitud o contacto -->
                        <div class="mt-8 flex justify-end">
                            @if(Auth::check())
                                @if($solicitudExistente)
                                    <button disabled class="inline-flex items-center px-6 py-3 bg-gray-400 text-white font-medium rounded-lg shadow cursor-not-allowed">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        Solicitud enviada ({{ ucfirst($solicitudExistente->estado) }})
                                    </button>
                                @else
                                    <button onclick="openSolicitudModal()" class="inline-flex items-center px-6 py-3 bg-[#5e0490] text-white font-medium rounded-lg shadow hover:bg-[#4a0370] transition-colors duration-300">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"/>
                                        </svg>
                                        Solicitar esta oferta
                                    </button>
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="inline-flex items-center px-6 py-3 bg-[#5e0490] text-white font-medium rounded-lg shadow hover:bg-[#4a0370] transition-colors duration-300">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                                    </svg>
                                    Inicia sesión para solicitar
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Solicitud -->
    <div id="solicitudModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full" style="z-index: 100;">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Solicitar Oferta</h3>
                <form id="solicitudForm" action="{{ route('solicitudes.store', $publication->id) }}" method="POST" class="mt-4">
                    @csrf
                    <div class="mt-2">Carta de motivación (opcional)</label>
                        <textarea
                            id="mensaje"
                            name="mensaje"
                            rows="4"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#5e0490] focus:ring-[#5e0490]"
                            placeholder="Escribe un mensaje para la empresa..."></textarea>
                    </div>
                    <div class="mt-4 flex justify-end space-x-3">
                        <button
                            type="button"
                            onclick="closeSolicitudModal()"
                            class="inline-flex justify-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#5e0490]">
                            Cancelar
                        </button>
                        <button
                            type="submit"
                            class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-[#5e0490] border border-transparent rounded-md hover:bg-[#4a0370] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#5e0490]">
                            Enviar solicitud
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Sweet Alert CSS y JS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-material-ui@5/material-ui.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        /* Animación para el botón de favoritos */
        .favorite-button i.fas {
            animation: pulse 1s ease-in-out;
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.2); }
            100% { transform: scale(1); }
        }
        
        /* Estilos para la imagen de la empresa */
        .w-48.h-48.rounded-lg {
            background-color: white;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        
        .w-48.h-48.rounded-lg img {
            transition: transform 0.3s ease;
        }
        
        .w-48.h-48.rounded-lg:hover img {
            transform: scale(1.05);
        }
        
        /* Ajustes para breadcrumbs en móvil */
        @media (max-width: 640px) {
            .max-w-xs {
                max-width: 150px;
            }
        }
    </style>
    
    <script>
        // Script para manejar el botón de favoritos
        document.addEventListener('DOMContentLoaded', function() {
            const favoriteButton = document.querySelector('.favorite-button');
            if (favoriteButton) {
                favoriteButton.addEventListener('click', function() {
                    const publicationId = this.getAttribute('data-publication-id');
                    const icon = this.querySelector('i');
                    const text = this.querySelector('span');
                    
                    fetch(`/toggle-favorite/${publicationId}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'added') {
                            icon.classList.remove('far', 'text-gray-400');
                            icon.classList.add('fas', 'text-yellow-500');
                            text.textContent = 'Quitar de favoritos';
                        } else {
                            icon.classList.remove('fas', 'text-yellow-500');
                            icon.classList.add('far', 'text-gray-400');
                            text.textContent = 'Añadir a favoritos';
                        }
                    })
                    .catch(error => console.error('Error:', error));
                });
            }
        });

        // Funciones para el modal de solicitud
        function openSolicitudModal() {
            document.getElementById('solicitudModal').classList.remove('hidden');
        }

        function closeSolicitudModal() {
            document.getElementById('solicitudModal').classList.add('hidden');
        }

        // Cerrar modal al hacer clic fuera
        document.getElementById('solicitudModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeSolicitudModal();
            }
        });

        // Manejar envío del formulario con AJAX
        document.getElementById('solicitudForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            fetch(this.action, {
                method: 'POST',
                body: new FormData(this),
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    closeSolicitudModal();
                    
                    // Actualizar el botón de solicitud
                    const solicitudButton = document.querySelector('[onclick="openSolicitudModal()"]').parentElement;
                    solicitudButton.innerHTML = `
                        <button disabled class="inline-flex items-center px-6 py-3 bg-gray-400 text-white font-medium rounded-lg shadow cursor-not-allowed">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Solicitud enviada (Pendiente)
                        </button>
                    `;
                    
                    // Actualizar el contador de solicitudes
                    const contadorSolicitudes = document.querySelector('[data-solicitudes-count]');
                    const numeroActual = parseInt(contadorSolicitudes.textContent);
                    const nuevoNumero = numeroActual + 1;
                    contadorSolicitudes.textContent = `${nuevoNumero} ${nuevoNumero === 1 ? 'candidato' : 'candidatos'}`;
                    
                    // Mostrar mensaje de éxito
                    Swal.fire({
                        title: '¡Solicitud enviada!',
                        text: 'Tu solicitud ha sido enviada correctamente',
                        icon: 'success',
                        confirmButtonText: 'Aceptar',
                        confirmButtonColor: '#5e0490',
                        background: '#fff',
                        customClass: {
                            confirmButton: 'px-4 py-2 bg-[#5e0490] text-white rounded-lg hover:bg-[#4a0370] transition-colors duration-300'
                        }
                    });
                } else if (data.status === 'error') {
                    Swal.fire({
                        title: '¡Error!',
                        text: data.message || 'Ha ocurrido un error al enviar la solicitud',
                        icon: 'error',
                        confirmButtonText: 'Entendido',
                        confirmButtonColor: '#5e0490',
                        background: '#fff',
                        customClass: {
                            confirmButton: 'px-4 py-2 bg-[#5e0490] text-white rounded-lg hover:bg-[#4a0370] transition-colors duration-300'
                        }
                    });
                }
            })
            // .catch(error => {
            //     console.error('Error:', error);
            //     Swal.fire({
            //         title: '¡Error!',
            //         text: 'Ha ocurrido un error al procesar tu solicitud',
            //         icon: 'error',
            //         confirmButtonText: 'Entendido',
            //         confirmButtonColor: '#5e0490',
            //         background: '#fff',
            //         customClass: {
            //             confirmButton: 'px-4 py-2 bg-[#5e0490] text-white rounded-lg hover:bg-[#4a0370] transition-colors duration-300'
            //         }
            //     });
            // });
        });
    </script>
@endsection