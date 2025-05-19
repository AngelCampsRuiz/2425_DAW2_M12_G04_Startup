<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <!-- Script para prevenir el parpadeo en modo oscuro -->
    <script>
        // Verificar inmediatamente si el modo oscuro está activado
        if (localStorage.getItem('darkMode') === 'dark' ||
            (!localStorage.getItem('darkMode') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        }
    </script>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'NextGen') }}</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('assets/images/logo.svg') }}" type="image/svg+xml">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Tailwind CSS -->
    <!-- Use production CDN version of Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#7705B6',
                        'primary-dark': '#5E0490'
                    }
                }
            }
        }
    </script>

    <style>
        /* Estilos globales para el modo oscuro */
        .dark body {
            background-color: #000000 !important;
            color: #ffffff !important;
        }

        /* Asegurar que todo el texto sea blanco en modo oscuro */
        .dark * {
            color: #ffffff !important;
        }

        .dark .text-gray-700,
        .dark .text-gray-600,
        .dark .text-gray-800,
        .dark .text-gray-900,
        .dark [class*="text-gray-"],
        .dark [class*="text-primary"],
        .dark [class*="text-purple"] {
            color: #ffffff !important;
        }

        /* Mantener el color de los SVG y paths */
        .dark svg:not([class*="text-white"]) {
            color: #ffffff !important;
        }

        .dark .bg-gradient-to-r {
            background-image: none !important;
            background-color: #000000 !important;
        }

        .dark .bg-gradient-to-tr {
            background-image: none !important;
            background-color: #000000 !important;
        }

        .dark section {
            background-color: #000000 !important;
        }

        .dark .bg-white {
            background-color: #000000 !important;
        }

        .dark .bg-gray-100 {
            background-color: #000000 !important;
        }

        .dark .border-gray-200 {
            border-color: #333333;
        }

        /* Asegurarse de que todos los fondos con opacidad sean oscuros */
        .dark .bg-white\/30,
        .dark .bg-white\/50,
        .dark .bg-white\/80 {
            background-color: rgba(0, 0, 0, 0.8) !important;
        }

        /* Asegurarse de que todos los elementos con fondo primario sean oscuros */
        .dark .from-primary\/5,
        .dark .to-primary\/15,
        .dark .bg-primary\/5,
        .dark [class*="from-primary"],
        .dark [class*="to-primary"],
        .dark [class*="bg-primary"] {
            background-color: #000000 !important;
            background-image: none !important;
        }

        /* Asegurarse de que las cards y elementos elevados sean más oscuros */
        .dark .shadow-lg {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.5), 0 4px 6px -2px rgba(0, 0, 0, 0.25);
        }

        /* Ajustar el color de fondo de los contenedores con backdrop-blur */
        .dark .backdrop-blur-sm {
            backdrop-filter: none !important;
            background-color: #000000 !important;
        }

        /* Asegurarse de que todos los gradientes sean negros */
        .dark [class*="bg-gradient"] {
            background-image: none !important;
            background-color: #000000 !important;
        }

        /* Asegurarse de que todos los elementos con fondo blanco sean negros */
        .dark [class*="bg-white"] {
            background-color: #000000 !important;
        }

        /* Asegurarse de que todos los elementos con fondo gris sean negros */
        .dark [class*="bg-gray"] {
            background-color: #000000 !important;
        }
    </style>

    <!-- Swiper.js para sliders -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>

    <link href="{{ asset('css/high-contrast.css') }}" rel="stylesheet">
    <script src="{{ asset('js/high-contrast.js') }}"></script>

    @stack('scripts')

    <!-- Dark Mode Script -->
    <script src="{{ asset('js/darkMode.js') }}"></script>


    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="font-sans antialiased min-h-full bg-gray-100">
    <div class="min-h-screen flex flex-col">
        @include('partials.header')

        <!-- Page Content -->
        <main class="flex-grow">
            @yield('content')
        </main>

        <!-- Footer -->
        @include('partials.footer')
    </div>

    <!-- Scripts de validación -->
    <script src="{{ asset('js/auth/login-validation.js') }}"></script>
    <script src="{{ asset('js/auth/register-validation.js') }}"></script>
    <script src="{{ asset('js/auth/register-personal-validation.js') }}"></script>
    <script src="{{ asset('js/auth/register-step2-validation.js') }}"></script>
    <script src="{{ asset('js/location-selector.js') }}"></script>
    <script src="{{ asset('js/date-restriction.js') }}"></script>

    <!-- Scripts específicos de cada página -->
    <script src="{{ asset('js/auth/register-student-validation.js') }}"></script>
    <script src="{{ asset('js/auth/register-company-validation.js') }}"></script>
</body>
</html>