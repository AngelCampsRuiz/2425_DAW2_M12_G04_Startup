@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-r from-primary/20 to-primary p-4">
    <div class="w-full max-w-4xl bg-white rounded-xl shadow-xl p-8">
        <div class="flex justify-center mb-6">
            <a href="{{ url('/') }}">
                <img src="{{ asset('assets/images/logo.svg') }}" alt="Logo" class="h-24">
            </a>
        </div>

        <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Registro de Empresa</h2>
        <p class="text-gray-600 text-center mb-6">Paso 2 de 2: Completa la información de tu empresa</p>

        <form method="POST" action="{{ route('company.register') }}" id="companyRegisterForm" class="space-y-6">
            @csrf
            <div class="grid md:grid-cols-2 gap-6">
                <!-- Nombre de la empresa (readonly) -->
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 text-sm font-medium mb-2">Nombre de la empresa</label>
                    <input id="name" type="text" name="name" value="{{ session('registration_data.name') ?? old('name') }}" readonly
                        class="w-full px-4 py-2 border rounded-lg bg-gray-100 focus:ring-primary focus:border-primary @error('name') border-red-500 @enderror">
                    @error('name')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                    <span id="name-error" class="text-red-500 text-xs"></span>
                </div>

                <!-- Email (readonly) -->
                <div class="mb-4">
                    <label for="email" class="block text-gray-700 text-sm font-medium mb-2">Correo electrónico</label>
                    <input id="email" type="email" name="email" value="{{ session('registration_data.email') ?? old('email') }}" readonly
                        class="w-full px-4 py-2 border rounded-lg bg-gray-100 focus:ring-primary focus:border-primary @error('email') border-red-500 @enderror">
                    @error('email')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                    <span id="email-error" class="text-red-500 text-xs"></span>
                </div>

                <!-- CIF -->
                <div class="mb-4">
                    <label for="cif" class="block text-gray-700 text-sm font-medium mb-2">CIF</label>
                    <input id="cif" type="text" name="cif" value="{{ old('cif') }}" 
                        class="w-full px-4 py-2 border rounded-lg focus:ring-primary focus:border-primary @error('cif') border-red-500 @enderror"
                        placeholder="Ej: B12345678">
                    @error('cif')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                    <span id="cif-error" class="text-red-500 text-xs"></span>
                </div>

                <!-- Dirección -->
                <div class="mb-4">
                    <label for="direccion" class="block text-gray-700 text-sm font-medium mb-2">Dirección</label>
                    <input id="direccion" type="text" name="direccion" value="{{ old('direccion') }}" 
                        class="w-full px-4 py-2 border rounded-lg focus:ring-primary focus:border-primary @error('direccion') border-red-500 @enderror"
                        placeholder="Ej: Calle Gran Vía 123, 28001">
                    @error('direccion')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                    <span id="direccion-error" class="text-red-500 text-xs"></span>
                </div>

                <!-- Provincia -->
                <div class="mb-4">
                    <label for="provincia" class="block text-gray-700 text-sm font-medium mb-2">Provincia</label>
                    <input id="provincia" type="text" name="provincia" class="w-full px-4 py-2 border rounded-lg focus:ring-primary focus:border-primary @error('provincia') border-red-500 @enderror" placeholder="Ej: Barcelona">
                    @error('provincia')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                    <span id="provincia-error" class="text-red-500 text-xs"></span>
                </div>

                <!-- Contraseña -->
                <div class="mb-4">
                    <label for="password" class="block text-gray-700 text-sm font-medium mb-2">Contraseña</label>
                    <input id="password" type="password" name="password" 
                        class="w-full px-4 py-2 border rounded-lg focus:ring-primary focus:border-primary @error('password') border-red-500 @enderror"
                        placeholder="Mínimo 8 caracteres">
                    @error('password')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                    <span id="password-error" class="text-red-500 text-xs"></span>
                </div>

                <!-- Confirmar Contraseña -->
                <div class="mb-4">
                    <label for="password_confirmation" class="block text-gray-700 text-sm font-medium mb-2">Confirmar contraseña</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" 
                        class="w-full px-4 py-2 border rounded-lg focus:ring-primary focus:border-primary"
                        placeholder="Repite la contraseña">
                    <span id="password_confirmation-error" class="text-red-500 text-xs"></span>
                </div>
            </div>

            <!-- Botón de registro -->
            <div class="flex items-center justify-between mt-6">
                <button type="submit" class="w-full bg-primary text-white py-2 px-4 rounded-lg hover:bg-primary-dark transition font-medium">
                    Registrar
                </button>
            </div>

            <!-- Enlace a login -->
            <div class="mt-4 text-center">
                <a href="{{ route('login') }}" class="text-sm text-primary hover:underline">¿Ya tienes cuenta? Inicia sesión</a>
            </div>
        </form>
    </div>
</div>

<script>
// Objeto global para almacenar el estado de validación de cada campo
window.validationErrors = {};

// Función centralizada para actualizar el estado visual de los campos
window.updateFieldStatus = function(input, isValid, errorMessage = '') {
    const formGroup = input.closest('.mb-4') || input.closest('.mb-6');
    if (!formGroup) return;
    
    const fieldId = input.id;
    const errorElement = document.getElementById(fieldId + '-error');
    
    if (!isValid) {
        // Guardamos el error en el objeto global
        window.validationErrors[fieldId] = errorMessage;
        
        // Añadimos la clase de error al input
        input.classList.add('border-red-500');
        
        // Actualizamos el mensaje de error
        if (errorElement) {
            errorElement.textContent = errorMessage;
        }
    } else {
        // Eliminamos el error del objeto global
        delete window.validationErrors[fieldId];
        
        // Quitamos la clase de error
        input.classList.remove('border-red-500');
        
        // Eliminamos el mensaje de error
        if (errorElement) {
            errorElement.textContent = '';
        }
    }
};

// Validación del nombre
window.validateName = function() {
    const nameField = document.getElementById('name');
    if (!nameField) return true;
    
    const nameValue = nameField.value.trim();
    if (!nameValue) {
        window.updateFieldStatus(nameField, false, 'El nombre de la empresa es obligatorio');
        return false;
    } else if (nameValue.length < 2) {
        window.updateFieldStatus(nameField, false, 'El nombre debe tener al menos 2 caracteres');
        return false;
    }
    
    window.updateFieldStatus(nameField, true);
    return true;
};

// Validación del email
window.validateEmail = function() {
    const emailField = document.getElementById('email');
    if (!emailField) return true;
    
    const emailValue = emailField.value.trim();
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    
    if (!emailValue) {
        window.updateFieldStatus(emailField, false, 'El correo electrónico es obligatorio');
        return false;
    } else if (!emailRegex.test(emailValue)) {
        window.updateFieldStatus(emailField, false, 'El formato del correo electrónico no es válido');
        return false;
    }
    
    window.updateFieldStatus(emailField, true);
    return true;
};

// Validación del CIF
window.validateCIF = function() {
    const cifField = document.getElementById('cif');
    if (!cifField) return true;
    
    const cifValue = cifField.value.trim();
    const cifRegex = /^[A-HJNPQRSUVW]{1}[0-9]{7}[0-9A-J]{1}$/;
    
    if (!cifValue) {
        window.updateFieldStatus(cifField, false, 'El CIF es obligatorio');
        return false;
    } else if (!cifRegex.test(cifValue)) {
        window.updateFieldStatus(cifField, false, 'El formato del CIF no es válido');
        return false;
    }
    
    window.updateFieldStatus(cifField, true);
    return true;
};

// Validación de la dirección
window.validateDireccion = function() {
    const direccionField = document.getElementById('direccion');
    if (!direccionField) return true;
    
    const direccionValue = direccionField.value.trim();
    if (!direccionValue) {
        window.updateFieldStatus(direccionField, false, 'La dirección es obligatoria');
        return false;
    }
    
    window.updateFieldStatus(direccionField, true);
    return true;
};

// Validación de la contraseña
window.validatePassword = function() {
    const passwordField = document.getElementById('password');
    if (!passwordField) return true;
    
    const passwordValue = passwordField.value;
    if (!passwordValue) {
        window.updateFieldStatus(passwordField, false, 'La contraseña es obligatoria');
        return false;
    } else if (passwordValue.length < 8) {
        window.updateFieldStatus(passwordField, false, 'La contraseña debe tener al menos 8 caracteres');
        return false;
    }
    
    window.updateFieldStatus(passwordField, true);
    return true;
};

// Validación de la confirmación de contraseña
window.validatePasswordConfirmation = function() {
    const passwordField = document.getElementById('password');
    const confirmField = document.getElementById('password_confirmation');
    if (!passwordField || !confirmField) return true;
    
    const passwordValue = passwordField.value;
    const confirmValue = confirmField.value;
    
    if (!confirmValue) {
        window.updateFieldStatus(confirmField, false, 'La confirmación de contraseña es obligatoria');
        return false;
    } else if (confirmValue !== passwordValue) {
        window.updateFieldStatus(confirmField, false, 'Las contraseñas no coinciden');
        return false;
    }
    
    window.updateFieldStatus(confirmField, true);
    return true;
};

// Validación de la provincia
window.validateProvincia = function() {
    const provinciaField = document.getElementById('provincia');
    if (!provinciaField) return true;
    
    const provinciaValue = provinciaField.value;
    if (!provinciaValue) {
        window.updateFieldStatus(provinciaField, false, 'La provincia es obligatoria');
        return false;
    }
    
    window.updateFieldStatus(provinciaField, true);
    return true;
};

// Validación completa del formulario
window.validateForm = function() {
    const validations = [
        window.validateName(),
        window.validateEmail(),
        window.validateCIF(),
        window.validateDireccion(),
        window.validateProvincia(),
        window.validatePassword(),
        window.validatePasswordConfirmation()
    ];
    
    return validations.every(Boolean);
};

// Cuando el DOM esté cargado
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('companyRegisterForm');
    
    // Añadir eventos de validación en tiempo real
    const name = document.getElementById('name');
    const email = document.getElementById('email');
    const cif = document.getElementById('cif');
    const direccion = document.getElementById('direccion');
    const provincia = document.getElementById('provincia');
    const password = document.getElementById('password');
    const password_confirmation = document.getElementById('password_confirmation');
    
    if (name) name.addEventListener('blur', window.validateName);
    if (email) email.addEventListener('blur', window.validateEmail);
    if (cif) cif.addEventListener('blur', window.validateCIF);
    if (direccion) direccion.addEventListener('blur', window.validateDireccion);
    if (provincia) provincia.addEventListener('blur', window.validateProvincia);
    if (password) password.addEventListener('blur', window.validatePassword);
    if (password_confirmation) password_confirmation.addEventListener('blur', window.validatePasswordConfirmation);
    
    // Validación al enviar el formulario
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            console.log('Formulario enviado');
            const isValid = window.validateForm();
            console.log('Validación:', isValid);
            
            if (isValid) {
                console.log('Enviando formulario...');
                this.submit();
            }
        });
    }
});
</script>
@endsection
