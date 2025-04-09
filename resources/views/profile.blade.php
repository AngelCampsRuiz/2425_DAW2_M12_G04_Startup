{{-- HEADER --}}
@extends('layouts.app')

{{-- CONTENIDO --}}
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
    @section('content')
        <div class="profile-container">
            @php
                $user = auth()->user();
            @endphp

            @if($user->role->nombre_rol == 'Estudiante')
                <div class="profile-card">
                    <img src="{{ asset('path/to/profile/image.jpg') }}" alt="Profile Picture" class="profile-image">
                    <div class="profile-info">
                        <h2>{{ $user->name }}</h2>
                        <p>{{ $user->email }}</p>
                        <p>Grado superior en Desarrollo de Aplicaciones Web</p>
                        <p>Soy un chico muy comprometido con el trabajo, me gusta el ping pong y beber palincă con los chavales en el parque.</p>
                        <a href="{{ asset('path/to/CV_MarioPalamari.pdf') }}" class="cv-link">CV_MarioPalamari.pdf</a>
                    </div>
                </div>
            @elseif($user->role->nombre_rol == 'Empresa')
                <!-- Estructura para Empresa -->
            @elseif($user->role->nombre_rol == 'Tutor')
                <!-- Estructura para Tutor -->
            @elseif($user->role->nombre_rol == 'Administrador')
                <!-- Estructura para Admin -->
            @endif
        </div>
    @endsection