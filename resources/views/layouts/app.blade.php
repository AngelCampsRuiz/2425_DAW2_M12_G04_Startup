<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- NOMBRE DE LA EMPRESA --}}
        <title>NextGen</title>
    {{-- AÑADIMOS EL CSS Y EL JS --}}
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
</head>
<body>
    {{-- HEADER --}}
        @include('partials.header')

    {{-- CONTENIDO --}}
        <main>
            @yield('content')
        </main>
    {{-- FOOTER --}}
        @include('partials.footer')
    <!-- Scripts de validación -->
    <script src="{{ asset('js/auth/login-validation.js') }}"></script>
    <script src="{{ asset('js/auth/register-validation.js') }}"></script>
    <script src="{{ asset('js/auth/register-personal-validation.js') }}"></script>
    <script src="{{ asset('js/auth/register-step2-validation.js') }}"></script>
    <script src="{{ asset('js/location-selector.js') }}"></script>
    <script src="{{ asset('js/date-restriction.js') }}"></script>
</body>
</html>