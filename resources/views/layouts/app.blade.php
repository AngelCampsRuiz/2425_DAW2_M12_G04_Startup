<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- TOKEN CSRF PARA PROTECCIÓN CONTRA ATAQUES DE FALSIFICACIÓN DE PETICIONES -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- TÍTULO DE LA PÁGINA MOSTRADO EN LA PESTAÑA DEL NAVEGADOR -->
        <title>NextGen</title>
    <!-- IMPORTACIÓN DE TAILWIND CSS DESDE CDN PARA LOS ESTILOS DE LA APLICACIÓN -->
        <script src="https://cdn.tailwindcss.com"></script>
    <!-- CONFIGURACIÓN PERSONALIZADA DE TAILWIND CON COLORES CORPORATIVOS -->
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        colors: {
                            <!-- COLOR PRIMARIO DE LA APLICACIÓN -->
                            primary: '#7705B6',
                            <!-- VARIANTE OSCURA DEL COLOR PRIMARIO -->
                            'primary-dark': '#5E0490'
                        }
                    }
                }
            }
        </script>
    {{-- LIBRERÍA SWIPER.JS PARA IMPLEMENTAR CARRUSELES Y SLIDERS EN LA APLICACIÓN --}}
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
    <!-- SCRIPT PRINCIPAL DE SWIPER.JS -->
        <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    {{-- Leaflet CSS --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
          integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
          crossorigin=""/>
    
    {{-- Estilos personalizados para el mapa --}}
    <style>
        #locationMap {
            z-index: 1;
        }
        .leaflet-container {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body>
    {{-- INCLUSIÓN DEL COMPONENTE DE CABECERA DE LA APLICACIÓN --}}
        @include('partials.header')

    {{-- SECCIÓN PRINCIPAL DONDE SE INSERTARÁ EL CONTENIDO ESPECÍFICO DE CADA PÁGINA --}}
        <main>
            <!-- YIELD PERMITE QUE LAS VISTAS QUE EXTIENDEN ESTA PLANTILLA INSERTEN SU CONTENIDO AQUÍ -->
            @yield('content')
        </main>
    <!-- INCLUYE EL ARCHIVO DE PIE DE PÁGINA DESDE LA CARPETA PARTIALS -->
        @include('partials.footer')
        <!-- SCRIPT PARA VALIDACIÓN DEL FORMULARIO DE LOGIN -->
            <script src="{{ asset('js/auth/login-validation.js') }}"></script>
        <!-- SCRIPT PARA VALIDACIÓN DEL FORMULARIO DE REGISTRO GENERAL -->
            <script src="{{ asset('js/auth/register-validation.js') }}"></script>
        <!-- SCRIPT PARA VALIDACIÓN DEL FORMULARIO DE INFORMACIÓN PERSONAL -->
            <script src="{{ asset('js/auth/register-personal-validation.js') }}"></script>
        <!-- SCRIPT PARA VALIDACIÓN DEL PASO 2 DEL REGISTRO -->
            <script src="{{ asset('js/auth/register-step2-validation.js') }}"></script>
        <!-- SCRIPT PARA EL SELECTOR DE UBICACIÓN/LOCALIZACIÓN -->
            <script src="{{ asset('js/location-selector.js') }}"></script>
        <!-- SCRIPT PARA RESTRICCIONES DE FECHAS EN INPUTS -->
            <script src="{{ asset('js/date-restriction.js') }}"></script>
        
        <!-- FUNCIÓN STACK PERMITE QUE LAS VISTAS HIJAS AÑADAN SUS PROPIOS SCRIPTS -->
            @stack('scripts')
        <!-- SCRIPT PARA VALIDACIÓN DEL FORMULARIO DE REGISTRO DE ESTUDIANTES -->
            <script src="{{ asset('js/auth/register-student-validation.js') }}"></script>
        <!-- SCRIPT PARA VALIDACIÓN DEL FORMULARIO DE REGISTRO DE EMPRESAS -->
            <script src="{{ asset('js/auth/register-company-validation.js') }}"></script>
    {{-- Leaflet JS --}}
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
            integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
            crossorigin=""></script>
    
    {{-- Mapa personalizado --}}
    <script src="{{ asset('js/profile-map.js') }}"></script>
</body>
</html>