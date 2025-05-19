@extends('layouts.app')

@push('scripts')
<script>
    // Deshabilitar el script de validación externo
    document.addEventListener('DOMContentLoaded', function() {
        // Esta variable evita que el script externo register-validation.js ejecute sus validaciones
        window.customValidationActive = true;
    });
</script>
@endpush

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-r from-primary/20 to-primary">
    <div class="bg-white rounded-lg shadow-xl p-8 w-full max-w-2xl">
        <div class="flex items-center mb-8">
            {{-- LOGO DE LA EMPRESA --}}
                <div class="mr-6">
                    <a href="{{ url('/') }}">
                        <img src="{{ asset('assets/images/logo.svg') }}" alt="Logo" class="h-48">
                    </a>
                </div>
            
            {{-- FORMULARIO --}}
                <div class="flex-1">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Registro</h2>
                    
                    <form id="registerForm" method="POST" action="{{ route('register') }}">
                        @csrf
                        
                        {{-- NOMBRE --}}
                            <div class="mb-4">
                                <label for="name" class="block text-gray-700 text-sm font-medium mb-2">Nombre completo</label>
                                <input id="name" type="text" name="name" value="{{ old('name') }}" autocomplete="name" autofocus
                                    class="w-full px-4 py-2 border rounded-lg focus:ring-primary focus:border-primary @error('name') border-red-500 @enderror">
                                
                                <div id="name-error" class="text-red-500 text-xs mt-1 error-container">
                                    @error('name'){{ $message }}@enderror
                                </div>
                            </div>
                        
                        {{-- CORREO --}}
                            <div class="mb-4">
                                <label for="email" class="block text-gray-700 text-sm font-medium mb-2">Correo electrónico</label>
                                <input id="email" type="email" name="email" value="{{ old('email') }}" autocomplete="email"
                                    class="w-full px-4 py-2 border rounded-lg focus:ring-primary focus:border-primary @error('email') border-red-500 @enderror">
                                
                                <div id="email-error" class="text-red-500 text-xs mt-1 error-container">
                                    @error('email'){{ $message }}@enderror
                                </div>
                            </div>
                        
                        {{-- Password fields removed as they will be added in the second step --}}
                        
                        {{-- AÑADIR ROL --}}
                            <div class="mb-6">
                                <label class="block text-gray-700 text-sm font-medium mb-2">Registrarme como:</label>
                                <div class="grid grid-cols-3 gap-4">
                                    <div class="flex items-center">
                                        <input type="radio" id="alumno" name="role" value="alumno" checked
                                            class="h-4 w-4 text-primary focus:ring-primary">
                                        <label for="alumno" class="ml-2 block text-sm text-gray-700">Alumno</label>
                                    </div>
                                    <div class="flex items-center">
                                        <input type="radio" id="empresa" name="role" value="empresa"
                                            class="h-4 w-4 text-primary focus:ring-primary">
                                        <label for="empresa" class="ml-2 block text-sm text-gray-700">Empresa</label>
                                    </div>
                                    <div class="flex items-center">
                                        <input type="radio" id="institucion" name="role" value="institucion"
                                            class="h-4 w-4 text-primary focus:ring-primary">
                                        <label for="institucion" class="ml-2 block text-sm text-gray-700">Institución</label>
                                    </div>
                                </div>
                                <div id="role-error" class="text-red-500 text-xs mt-1 error-container">
                                    @error('role'){{ $message }}@enderror
                                </div>
                            </div>
                        
                        <!-- BOTON REGISTER -->
                            <button type="submit" class="w-full bg-primary text-white py-2 px-4 rounded-lg hover:bg-primary-dark transition font-medium">
                                Registrarme
                            </button>
                        
                        <!-- ENLACE LOGIN -->
                            <div class="mt-4 text-center">
                                <a href="{{ route('login') }}" class="text-sm text-primary hover:underline">¿Ya tienes cuenta? Inicia sesión</a>
                            </div>
                    </form>
                </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Deshabilitar cualquier otra validación que pudiera existir
    window.customValidationActive = true;
    
    // Eliminar todos los duplicados de mensajes de error
    document.querySelectorAll('.error-container').forEach(container => {
        // Solo mantener el primer elemento hijo si hay múltiples
        const children = Array.from(container.childNodes);
        if (children.length > 1) {
            // Guardar solo el primer elemento con contenido
            let firstContentNode = null;
            for (const child of children) {
                if (child.textContent && child.textContent.trim()) {
                    firstContentNode = child;
                    break;
                }
            }
            
            // Limpiar el contenedor
            container.innerHTML = '';
            
            // Restaurar solo el primer elemento con contenido
            if (firstContentNode) {
                container.appendChild(firstContentNode);
            }
        }
    });
    
    // Validación del nombre
    function validateName() {
        const nameField = document.getElementById('name');
        if (!nameField) return true;
        
        const errorContainer = document.getElementById('name-error');
        const nameValue = nameField.value.trim();
        
        // Limpiar errores anteriores
        if (errorContainer) errorContainer.innerHTML = '';
        nameField.classList.remove('border-red-500');
        
        if (!nameValue) {
            nameField.classList.add('border-red-500');
            if (errorContainer) errorContainer.innerHTML = 'El nombre es obligatorio';
            return false;
        } else if (nameValue.length < 2) {
            nameField.classList.add('border-red-500');
            if (errorContainer) errorContainer.innerHTML = 'El nombre debe tener al menos 2 caracteres';
            return false;
        }
        
        return true;
    }
    
    // Validación del email
    function validateEmail() {
        const emailField = document.getElementById('email');
        if (!emailField) return true;
        
        const errorContainer = document.getElementById('email-error');
        const emailValue = emailField.value.trim();
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        
        // Limpiar errores anteriores
        if (errorContainer) errorContainer.innerHTML = '';
        emailField.classList.remove('border-red-500');
        
        if (!emailValue) {
            emailField.classList.add('border-red-500');
            if (errorContainer) errorContainer.innerHTML = 'El correo electrónico es obligatorio';
            return false;
        } else if (!emailRegex.test(emailValue)) {
            emailField.classList.add('border-red-500');
            if (errorContainer) errorContainer.innerHTML = 'El formato del correo electrónico no es válido';
            return false;
        }
        
        return true;
    }
    
    // Validación del rol
    function validateRole() {
        const roleRadios = document.querySelectorAll('input[name="role"]');
        const errorContainer = document.getElementById('role-error');
        let roleSelected = false;
        
        roleRadios.forEach(radio => {
            if (radio.checked) {
                roleSelected = true;
            }
        });
        
        // Limpiar errores anteriores
        if (errorContainer) errorContainer.innerHTML = '';
        
        if (!roleSelected) {
            if (errorContainer) errorContainer.innerHTML = 'Debes seleccionar un tipo de usuario';
            return false;
        }
        
        return true;
    }
    
    // Validación de todo el formulario antes de envío
    document.getElementById('registerForm').addEventListener('submit', function(event) {
        const isNameValid = validateName();
        const isEmailValid = validateEmail();
        const isRoleValid = validateRole();
        
        if (!isNameValid || !isEmailValid || !isRoleValid) {
            event.preventDefault();
        }
    });
    
    // Agregar validación onblur para cada campo
    const nameField = document.getElementById('name');
    if (nameField) {
        nameField.addEventListener('blur', validateName);
    }
    
    const emailField = document.getElementById('email');
    if (emailField) {
        emailField.addEventListener('blur', validateEmail);
    }
    
    // Para los radio buttons de rol, validar al cambiar
    const roleRadios = document.querySelectorAll('input[name="role"]');
    roleRadios.forEach(radio => {
        radio.addEventListener('change', validateRole);
    });
    
    // Limpiar errores del servidor al interactuar con los campos
    document.querySelectorAll('input, select').forEach(element => {
        element.addEventListener('focus', function() {
            const fieldName = this.name || this.id;
            const errorContainer = document.getElementById(fieldName + '-error');
            if (errorContainer) {
                errorContainer.innerHTML = '';
            }
            this.classList.remove('border-red-500');
        });
    });
});
</script>

@endsection