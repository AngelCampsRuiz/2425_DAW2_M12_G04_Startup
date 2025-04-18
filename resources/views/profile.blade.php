{{-- HEADER --}}
@extends('layouts.app')

{{-- CONTENIDO --}}
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @section('content')
        <div class="profile-container">
            <div class="profile-card">
                <img src="{{ asset('path/to/profile/image.jpg') }}" alt="Profile Picture" class="profile-image">
                <div class="profile-info">
                    <h2>{{ $user->nombre }}</h2>
                    <p>{{ $user->email }}</p>
                    <p>{{ $user->descripcion }}</p>
                    @if($user->role_id == 3)
                        <p>Cursando: {{ $user->estudiante->titulo->name_titulo ?? 'No asignada' }}</p>
                        <a href="{{ asset('cv/' . $user->estudiante->cv_pdf) }}" class="cv-link" target="_blank">{{ $user->estudiante->cv_pdf }}</a>
                    @elseif($user->role_id == 2)
                        <p>Direccion: {{ $user->empresa->direccion }}</p>
                        <a href="{{ $user->sitio_web }}" class="cv-link" target="_blank">{{ $user->sitio_web }}</a>
                    @elseif($user->role_id == 4)
                        <p>Especialidad: {{ $user->tutor->categoria->nombre_categoria ?? 'No asignada' }}</p>
                        <p>Trabajo en: <a href="{{ asset($user->sitio_web) }}" class="cv-link" target="_blank">{{ $user->tutor->centro_asignado }}</a></p>
                    @endif
                    @if(auth()->id() == $user->id)
                        <div class="profile-actions">
                            <button id="toggleVisibility" class="visibility-button" data-user-id="{{ $user->id }}" data-visibility="{{ $user->visibilidad }}">
                                <i class="fas {{ $user->visibilidad ? 'fa-eye' : 'fa-eye-slash' }}"></i>
                            </button>
                            <button class="edit-button">
                                <i class="fas fa-edit mr-1"></i>
                            </button>
                            <button class="delete-button">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    @endif

                    {{-- El dropdown siempre es visible para el propio usuario, y para otros solo si la visibilidad está activada --}}
                    @if(auth()->id() == $user->id || ($user->visibilidad && auth()->id() != $user->id))
                        <button id="toggleDropdown" class="dropdown-button">
                            <i class="fas fa-chevron-down"></i>
                        </button>
                        <!-- Contenedor del dropdown -->
                        <div id="dropdownContent" class="dropdown-content">
                            <p>Telefono: {{ $user->telefono }}</p>
                            <p>Ciudad: {{ $user->ciudad }}</p>
                            @if($user->role_id == 3)
                                <p>Instituto: {{ $user->estudiante->centro_educativo }}</p>
                                <p>Seguridad Social: {{ $user->estudiante->numero_seguridad_social }}</p>
                            @elseif($user->role_id == 2)
                                <p>CIF: {{ $user->empresa->cif }}</p>
                                <p>Fecha de fundacion: {{ $user->fecha_nacimiento }}</p>
                            @else
                                <p>Fecha de Nacimiento: {{ $user->fecha_nacimiento }}</p>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>

        @if($user->role_id == 2 || $user->role_id == 3)
            <h1>asd --</h1>
        @elseif($user->role_id == 4)
            <h1>Alumnos</h1>
        @endif

        <div>
            {{-- @foreach ($comentarios as $comentario)
                <div>
                </div>
            @endforeach --}}
        </div>
    @endsection
