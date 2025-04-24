<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ config('app.name', 'Laravel') }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
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
    
    @stack('scripts')
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        <!-- Header -->
        @include('partials.header')

        <!-- Page Content -->
        <main>
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