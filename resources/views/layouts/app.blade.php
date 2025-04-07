<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- NOMBRE DE LA EMPRESA --}}
        <title>NextGen</title>
    {{-- AÑADIMOS EL CSS Y EL JS --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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
</body>
</html>