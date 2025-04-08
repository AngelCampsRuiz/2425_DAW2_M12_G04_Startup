@extends('layouts.app')

@section('content')
<div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0 bg-gray-100">
    <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
        <h2 class="text-2xl font-bold text-center text-primary mb-6">Registro de Estudiante</h2>

        <form method="POST" action="{{ route('register.alumno') }}">
            @csrf

            <!-- Name -->
            <div>
                <label for="name" class="block font-medium text-sm text-gray-700">Nombre</label>
                <input id="name" class="block mt-1 w-full rounded-md border-gray-300" type="text" name="name" value="{{ old('name') }}" required autofocus />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <label for="email" class="block font-medium text-sm text-gray-700">Email</label>
                <input id="email" class="block mt-1 w-full rounded-md border-gray-300" type="email" name="email" value="{{ old('email') }}" required />
            </div>

            <!-- Centro de Estudios -->
            <div class="mt-4">
                <label for="centro_estudios" class="block font-medium text-sm text-gray-700">Centro de Estudios</label>
                <input id="centro_estudios" class="block mt-1 w-full rounded-md border-gray-300" type="text" name="centro_estudios" value="{{ old('centro_estudios') }}" required />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <label for="password" class="block font-medium text-sm text-gray-700">Contraseña</label>
                <input id="password" class="block mt-1 w-full rounded-md border-gray-300" type="password" name="password" required />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <label for="password_confirmation" class="block font-medium text-sm text-gray-700">Confirmar Contraseña</label>
                <input id="password_confirmation" class="block mt-1 w-full rounded-md border-gray-300" type="password" name="password_confirmation" required />
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    ¿Ya estás registrado?
                </a>

                <button type="submit" class="ml-4 inline-flex items-center px-4 py-2 bg-primary border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-dark focus:bg-primary-dark active:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 transition ease-in-out duration-150">
                    Registrarse
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
