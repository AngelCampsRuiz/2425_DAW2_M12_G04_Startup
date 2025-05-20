<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>

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