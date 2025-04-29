@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-r from-primary/20 to-primary p-4">
    <div class="w-full max-w-4xl bg-white rounded-xl shadow-xl p-8">
        <div class="flex justify-center mb-6">
            <a href="{{ url('/') }}">
                <img src="{{ asset('assets/images/logo.svg') }}" alt="Logo" class="h-24">
            </a>
        </div>

        <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Registro de Institución Educativa</h2>
        <p class="text-gray-600 text-center mb-6">Paso 2 de 2: Completa la información de tu institución</p>

        <form method="POST" action="{{ route('institution.register') }}" id="institutionRegisterForm" class="space-y-6">
            @csrf
            <div class="grid md:grid-cols-2 gap-6">
                <!-- Nombre de la institución (readonly) -->
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 text-sm font-medium mb-2">Nombre de la institución</label>
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

                <!-- Código de centro -->
                <div class="mb-4">
                    <label for="codigo_centro" class="block text-gray-700 text-sm font-medium mb-2">Código de centro</label>
                    <input id="codigo_centro" type="text" name="codigo_centro" value="{{ old('codigo_centro') }}" 
                        class="w-full px-4 py-2 border rounded-lg focus:ring-primary focus:border-primary @error('codigo_centro') border-red-500 @enderror"
                        placeholder="Ej: 08012345">
                    @error('codigo_centro')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                    <span id="codigo_centro-error" class="text-red-500 text-xs"></span>
                </div>

                <!-- Tipo de institución -->
                <div class="mb-4">
                    <label for="tipo_institucion" class="block text-gray-700 text-sm font-medium mb-2">Tipo de institución</label>
                    <select id="tipo_institucion" name="tipo_institucion" 
                        class="w-full px-4 py-2 border rounded-lg focus:ring-primary focus:border-primary @error('tipo_institucion') border-red-500 @enderror">
                        <option value="">Selecciona un tipo</option>
                        <option value="Instituto de Educación Secundaria">Instituto de Educación Secundaria</option>
                        <option value="Universidad">Universidad</option>
                        <option value="Centro de Formación Profesional">Centro de Formación Profesional</option>
                        <option value="Escuela de Negocios">Escuela de Negocios</option>
                        <option value="Otro">Otro</option>
                    </select>
                    @error('tipo_institucion')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                    <span id="tipo_institucion-error" class="text-red-500 text-xs"></span>
                </div>

                <!-- Dirección -->
                <div class="mb-4">
                    <label for="direccion" class="block text-gray-700 text-sm font-medium mb-2">Dirección</label>
                    <input id="direccion" type="text" name="direccion" value="{{ old('direccion') }}" 
                        class="w-full px-4 py-2 border rounded-lg focus:ring-primary focus:border-primary @error('direccion') border-red-500 @enderror"
                        placeholder="Ej: Calle Gran Vía 123">
                    @error('direccion')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                    <span id="direccion-error" class="text-red-500 text-xs"></span>
                </div>

                <!-- Provincia -->
                <div class="mb-4">
                    <label for="provincia" class="block text-gray-700 text-sm font-medium mb-2">Provincia</label>
                    <input id="provincia" type="text" name="provincia" value="{{ old('provincia') }}"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-primary focus:border-primary @error('provincia') border-red-500 @enderror"
                        placeholder="Ej: Barcelona">
                    @error('provincia')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                    <span id="provincia-error" class="text-red-500 text-xs"></span>
                </div>

                <!-- Código postal -->
                <div class="mb-4">
                    <label for="codigo_postal" class="block text-gray-700 text-sm font-medium mb-2">Código postal</label>
                    <input id="codigo_postal" type="text" name="codigo_postal" value="{{ old('codigo_postal') }}"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-primary focus:border-primary @error('codigo_postal') border-red-500 @enderror"
                        placeholder="Ej: 08001">
                    @error('codigo_postal')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                    <span id="codigo_postal-error" class="text-red-500 text-xs"></span>
                </div>

                <!-- Representante legal -->
                <div class="mb-4">
                    <label for="representante_legal" class="block text-gray-700 text-sm font-medium mb-2">Representante legal</label>
                    <input id="representante_legal" type="text" name="representante_legal" value="{{ old('representante_legal') }}"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-primary focus:border-primary @error('representante_legal') border-red-500 @enderror"
                        placeholder="Nombre completo del representante">
                    @error('representante_legal')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                    <span id="representante_legal-error" class="text-red-500 text-xs"></span>
                </div>

                <!-- Cargo del representante -->
                <div class="mb-4">
                    <label for="cargo_representante" class="block text-gray-700 text-sm font-medium mb-2">Cargo del representante</label>
                    <input id="cargo_representante" type="text" name="cargo_representante" value="{{ old('cargo_representante') }}"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-primary focus:border-primary @error('cargo_representante') border-red-500 @enderror"
                        placeholder="Ej: Director, Rector, etc.">
                    @error('cargo_representante')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                    <span id="cargo_representante-error" class="text-red-500 text-xs"></span>
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
        window.validationErrors[fieldId] = errorMessage;
        input.classList.add('border-red-500');
        if (errorElement) {
            errorElement.textContent = errorMessage;
        }
    } else {
        delete window.validationErrors[fieldId];
        input.classList.remove('border-red-500');
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
        window.updateFieldStatus(nameField, false, 'El nombre de la institución es obligatorio');
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

// Validación del código de centro
window.validateCodigoCentro = function() {
    const codigoField = document.getElementById('codigo_centro');
    if (!codigoField) return true;
    
    const codigoValue = codigoField.value.trim();
    const codigoRegex = /^[0-9]{8}$/;
    
    if (!codigoValue) {
        window.updateFieldStatus(codigoField, false, 'El código de centro es obligatorio');
        return false;
    } else if (!codigoRegex.test(codigoValue)) {
        window.updateFieldStatus(codigoField, false, 'El código de centro debe tener 8 dígitos');
        return false;
    }
    
    window.updateFieldStatus(codigoField, true);
    return true;
};

// Validación del tipo de institución
window.validateTipoInstitucion = function() {
    const tipoField = document.getElementById('tipo_institucion');
    if (!tipoField) return true;
    
    const tipoValue = tipoField.value;
    if (!tipoValue) {
        window.updateFieldStatus(tipoField, false, 'El tipo de institución es obligatorio');
        return false;
    }
    
    window.updateFieldStatus(tipoField, true);
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

// Validación de la provincia
window.validateProvincia = function() {
    const provinciaField = document.getElementById('provincia');
    if (!provinciaField) return true;
    
    const provinciaValue = provinciaField.value.trim();
    if (!provinciaValue) {
        window.updateFieldStatus(provinciaField, false, 'La provincia es obligatoria');
        return false;
    }
    
    window.updateFieldStatus(provinciaField, true);
    return true;
};

// Validación del código postal
window.validateCodigoPostal = function() {
    const codigoPostalField = document.getElementById('codigo_postal');
    if (!codigoPostalField) return true;
    
    const codigoPostalValue = codigoPostalField.value.trim();
    const codigoPostalRegex = /^[0-9]{5}$/;
    
    if (!codigoPostalValue) {
        window.updateFieldStatus(codigoPostalField, false, 'El código postal es obligatorio');
        return false;
    } else if (!codigoPostalRegex.test(codigoPostalValue)) {
        window.updateFieldStatus(codigoPostalField, false, 'El código postal debe tener 5 dígitos');
        return false;
    }
    
    window.updateFieldStatus(codigoPostalField, true);
    return true;
};

// Validación del representante legal
window.validateRepresentanteLegal = function() {
    const representanteField = document.getElementById('representante_legal');
    if (!representanteField) return true;
    
    const representanteValue = representanteField.value.trim();
    if (!representanteValue) {
        window.updateFieldStatus(representanteField, false, 'El nombre del representante legal es obligatorio');
        return false;
    }
    
    window.updateFieldStatus(representanteField, true);
    return true;
};

// Validación del cargo del representante
window.validateCargoRepresentante = function() {
    const cargoField = document.getElementById('cargo_representante');
    if (!cargoField) return true;
    
    const cargoValue = cargoField.value.trim();
    if (!cargoValue) {
        window.updateFieldStatus(cargoField, false, 'El cargo del representante es obligatorio');
        return false;
    }
    
    window.updateFieldStatus(cargoField, true);
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
    } else if (passwordValue !== confirmValue) {
        window.updateFieldStatus(confirmField, false, 'Las contraseñas no coinciden');
        return false;
    }
    
    window.updateFieldStatus(confirmField, true);
    return true;
};

// Validación del formulario completo
document.getElementById('institutionRegisterForm').addEventListener('submit', function(event) {
    // Validar todos los campos
    const isValid = 
        validateName() &&
        validateEmail() &&
        validateCodigoCentro() &&
        validateTipoInstitucion() &&
        validateDireccion() &&
        validateProvincia() &&
        validateCodigoPostal() &&
        validateRepresentanteLegal() &&
        validateCargoRepresentante() &&
        validatePassword() &&
        validatePasswordConfirmation();
    
    if (!isValid) {
        event.preventDefault();
    }
});

// Validación en tiempo real
document.querySelectorAll('input, select').forEach(field => {
    field.addEventListener('input', function() {
        const fieldId = this.id;
        switch(fieldId) {
            case 'name':
                validateName();
                break;
            case 'email':
                validateEmail();
                break;
            case 'codigo_centro':
                validateCodigoCentro();
                break;
            case 'tipo_institucion':
                validateTipoInstitucion();
                break;
            case 'direccion':
                validateDireccion();
                break;
            case 'provincia':
                validateProvincia();
                break;
            case 'codigo_postal':
                validateCodigoPostal();
                break;
            case 'representante_legal':
                validateRepresentanteLegal();
                break;
            case 'cargo_representante':
                validateCargoRepresentante();
                break;
            case 'password':
                validatePassword();
                validatePasswordConfirmation();
                break;
            case 'password_confirmation':
                validatePasswordConfirmation();
                break;
        }
    });
});
</script>
@endsection 