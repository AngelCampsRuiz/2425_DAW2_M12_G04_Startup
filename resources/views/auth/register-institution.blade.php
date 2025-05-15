@extends('layouts.app')

@section('title', 'Registro de Institución - PickJob')

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

        <!-- Mensajes de error -->
        @if ($errors->any())
        <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800">Algunos campos tienen errores:</h3>
                    <ul class="mt-1 text-xs text-red-700 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        @endif

        <form method="POST" action="{{ route('institution.register') }}" id="institutionRegisterForm" class="space-y-6">
            @csrf
            <meta name="csrf-token" content="{{ csrf_token() }}">
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

                <!-- Niveles educativos (select múltiple) -->
                <div class="mb-4">
                    <label for="niveles_educativos" class="block text-gray-700 text-sm font-medium mb-2">Niveles educativos</label>
                    <select id="niveles_educativos" name="niveles_educativos[]" multiple
                        class="select2 w-full px-4 py-2 border rounded-lg focus:ring-primary focus:border-primary @error('niveles_educativos') border-red-500 @enderror">
                        @php
                            // Asegurar que no haya duplicados en los niveles educativos
                            $nivelesIds = [];
                            $oldNiveles = old('niveles_educativos', []);
                        @endphp
                        @foreach ($nivelesEducativos as $nivel)
                            @if (!in_array($nivel->id, $nivelesIds))
                                @php $nivelesIds[] = $nivel->id; @endphp
                                <option value="{{ $nivel->id }}" {{ in_array($nivel->id, $oldNiveles) ? 'selected' : '' }}>{{ $nivel->nombre_nivel }}</option>
                            @endif
                        @endforeach
                    </select>
                    @error('niveles_educativos')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                    <span id="niveles_educativos-error" class="text-red-500 text-xs"></span>
                </div>

                <!-- Categorías (aparecerá dinámicamente según los niveles seleccionados) -->
                <div class="mb-4 md:col-span-2" id="categorias-container">
                    <label class="block text-gray-700 text-sm font-medium mb-2">Categorías por nivel educativo</label>
                    <div id="categorias-por-nivel" class="space-y-4">
                        <!-- Aquí se cargarán dinámicamente las categorías según los niveles seleccionados -->
                        <p class="text-sm text-gray-500">Selecciona primero los niveles educativos para ver las categorías disponibles</p>
                    </div>
                    @error('categorias')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
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
                    <select id="provincia" name="provincia" 
                        class="w-full px-4 py-2 border rounded-lg focus:ring-primary focus:border-primary @error('provincia') border-red-500 @enderror">
                        <option value="">Selecciona una provincia</option>
                    </select>
                    <input type="hidden" id="provincia_anterior" value="{{ old('provincia') }}">
                    @error('provincia')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                    <span id="provincia-error" class="text-red-500 text-xs"></span>
                </div>

                <!-- Ciudad -->
                <div class="mb-4">
                    <label for="ciudad" class="block text-gray-700 text-sm font-medium mb-2">Ciudad</label>
                    <select id="ciudad" name="ciudad" 
                        class="w-full px-4 py-2 border rounded-lg focus:ring-primary focus:border-primary @error('ciudad') border-red-500 @enderror">
                        <option value="">Primero selecciona una provincia</option>
                    </select>
                    <input type="hidden" id="ciudad_anterior" value="{{ old('ciudad') }}">
                    @error('ciudad')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                    <span id="ciudad-error" class="text-red-500 text-xs"></span>
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

<!-- Incluir Select2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<style>
    /* Estilos personalizados para Select2 */
    .select2-container--default .select2-selection--multiple {
        border-color: #e2e8f0;
        border-radius: 0.5rem;
        min-height: 42px;
        line-height: 24px;
        padding: 2px 4px;
    }
    
    .select2-container--default.select2-container--focus .select2-selection--multiple {
        border-color: #4f46e5;
        box-shadow: 0 0 0 1px #4f46e5;
    }
    
    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        background-color: #4f46e5;
        color: white;
        border: none;
        border-radius: 0.375rem;
        padding: 2px 8px 2px 25px;  /* Aumentado el padding izquierdo para dar espacio al botón de eliminar */
        margin-top: 4px;
        margin-right: 4px;
        position: relative;  /* Para posicionar correctamente el botón de eliminar */
    }
    
    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
        color: white;
        margin-right: 5px;
        position: absolute;  /* Posicionamiento absoluto para que no empuje el texto */
        left: 6px;  /* Posicionar a la izquierda */
        top: 50%;  /* Centrar verticalmente */
        transform: translateY(-50%);  /* Ajuste fino para centrado vertical */
        font-weight: bold;
        border: none;
        background: none;
    }
    
    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover {
        color: #f9fafb;
        background-color: rgba(255, 255, 255, 0.1);  /* Fondo sutil al hacer hover */
        border-radius: 50%;  /* Forma circular al hacer hover */
    }
    
    .select2-dropdown {
        border-color: #e2e8f0;
        border-radius: 0.5rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }
    
    .select2-container--default .select2-results__option--highlighted[aria-selected] {
        background-color: #4f46e5;
    }
</style>

<script>
$(document).ready(function() {
    // Inicializar Select2 con prevención de duplicados
    $('.select2').select2({
        placeholder: "Selecciona los niveles educativos",
        allowClear: true,
        width: '100%',
        // Esta función de selección previene seleccionar un mismo valor dos veces
        selectOnClose: true,
        // Personalización adicional
        language: {
            noResults: function() {
                return "No se encontraron resultados";
            }
        },
        // Clases personalizadas para mejor integración con Tailwind
        theme: "default"
    }).on('select2:selecting', function(e) {
        const existingValues = $(this).val() || [];
        const selectedValue = e.params.args.data.id;
        
        // Si ya está seleccionado, prevenir la selección
        if (existingValues.includes(selectedValue)) {
            e.preventDefault();
        }
    });
    
    // Detectar cambios en Select2
    $('.select2').on('change', function() {
        validateNivelesEducativos();
        cargarCategoriasPorNivel();
    });

    // Cargar provincias al inicio
    window.loadProvincias();
    
    // Configurar evento para actualizar ciudades cuando cambia la provincia
    const provinciaSelect = document.getElementById('provincia');
    if (provinciaSelect) {
        provinciaSelect.addEventListener('change', function() {
            if (this.value) {
                console.log('Provincia seleccionada:', this.value);
                window.loadCiudades(this.value);
                window.validateProvincia();
                
                // Reiniciar el selector de ciudad
                const ciudadSelect = document.getElementById('ciudad');
                ciudadSelect.innerHTML = '<option value="">Selecciona una ciudad</option>';
            }
        });
    }
    
    // Configurar evento para validar ciudad cuando cambia
    const ciudadSelect = document.getElementById('ciudad');
    if (ciudadSelect) {
        ciudadSelect.addEventListener('change', function() {
            window.validateCiudad();
        });
        ciudadSelect.addEventListener('blur', function() {
            window.validateCiudad();
        });
    }
    
    // Configurar validaciones onblur para todos los campos
    const camposAValidar = [
        { id: 'name', validacion: window.validateName },
        { id: 'email', validacion: window.validateEmail },
        { id: 'codigo_centro', validacion: window.validateCodigoCentro },
        { id: 'direccion', validacion: window.validateDireccion },
        { id: 'provincia', validacion: window.validateProvincia },
        { id: 'ciudad', validacion: window.validateCiudad },
        { id: 'codigo_postal', validacion: window.validateCodigoPostal },
        { id: 'representante_legal', validacion: window.validateRepresentanteLegal },
        { id: 'cargo_representante', validacion: window.validateCargoRepresentante },
        { id: 'password', validacion: window.validatePassword },
        { id: 'password_confirmation', validacion: window.validatePasswordConfirmation }
    ];
    
    camposAValidar.forEach(campo => {
        const elemento = document.getElementById(campo.id);
        if (elemento) {
            elemento.addEventListener('blur', campo.validacion);
        }
    });
    
    // Restaurar provincia y ciudad si existen valores anteriores
    const provinciaAnterior = document.getElementById('provincia_anterior').value;
    if (provinciaAnterior) {
        // Esperar a que carguen las provincias y luego seleccionar
        setTimeout(function() {
            console.log('Restaurando provincia anterior:', provinciaAnterior);
            const provinciaSelect = document.getElementById('provincia');
            if (provinciaSelect) {
                provinciaSelect.value = provinciaAnterior;
                // Cargar las ciudades correspondientes
                window.loadCiudades(provinciaAnterior, function() {
                    // Callback después de cargar ciudades
                    const ciudadAnterior = document.getElementById('ciudad_anterior').value;
                    if (ciudadAnterior) {
                        console.log('Restaurando ciudad anterior:', ciudadAnterior);
                        const ciudadSelect = document.getElementById('ciudad');
                        if (ciudadSelect) {
                            ciudadSelect.value = ciudadAnterior;
                        }
                    }
                });
            }
        }, 500);
    }
    
    // Activar carga inicial de categorías si hay niveles seleccionados
    if ($('#niveles_educativos').val() && $('#niveles_educativos').val().length > 0) {
        cargarCategoriasPorNivel();
    }
});

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

// Validación de los niveles educativos
window.validateNivelesEducativos = function() {
    const nivelesField = document.getElementById('niveles_educativos');
    if (!nivelesField) return true;
    
    const nivelesSeleccionados = $('#niveles_educativos').val(); // Uso de jQuery para Select2
    
    if (!nivelesSeleccionados || nivelesSeleccionados.length === 0) {
        window.updateFieldStatus(nivelesField, false, 'Debes seleccionar al menos un nivel educativo');
        return false;
    }
    
    window.updateFieldStatus(nivelesField, true);
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
    // Depuración: Mostrar las categorías seleccionadas en consola antes de enviar
    const categoriaCheckboxes = document.querySelectorAll('input[name^="categorias["]');
    const categoriasSeleccionadas = {};
    
    categoriaCheckboxes.forEach(checkbox => {
        if (checkbox.checked) {
            const match = checkbox.name.match(/\[(\d+)\]/);
            if (match && match[1]) {
                const nivelId = match[1];
                if (!categoriasSeleccionadas[nivelId]) {
                    categoriasSeleccionadas[nivelId] = [];
                }
                categoriasSeleccionadas[nivelId].push(checkbox.value);
            }
        }
    });
    
    console.log('Categorías seleccionadas:', categoriasSeleccionadas);
    
    // Validar todos los campos
    const isValid = 
        validateName() &&
        validateEmail() &&
        validateCodigoCentro() &&
        validateNivelesEducativos() &&
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

// Función para cargar las categorías según los niveles seleccionados
function cargarCategoriasPorNivel() {
    const nivelesSeleccionados = $('#niveles_educativos').val(); // Uso de jQuery para Select2
    const contenedorCategorias = document.getElementById('categorias-por-nivel');
    
    // Guardar las selecciones actuales antes de recargar
    const seleccionesActuales = {};
    document.querySelectorAll('input[name^="categorias["]').forEach(checkbox => {
        if (checkbox.checked) {
            const name = checkbox.name;
            const value = checkbox.value;
            if (!seleccionesActuales[name]) {
                seleccionesActuales[name] = [];
            }
            seleccionesActuales[name].push(value);
        }
    });
    
    // Recuperar categorías de old() si existen
    @php
    $oldCategorias = session()->getOldInput('categorias', []);
    @endphp
    
    const oldCategorias = @json($oldCategorias);
    
    // Mostrar un estado de carga
    contenedorCategorias.innerHTML = '<p class="text-sm text-gray-500">Cargando categorías...</p>';
    
    // Limpiar el contenedor
    if (!nivelesSeleccionados || nivelesSeleccionados.length === 0) {
        contenedorCategorias.innerHTML = '<p class="text-sm text-gray-500">Selecciona primero los niveles educativos para ver las categorías disponibles</p>';
        return;
    }
    
    // Mapear los niveles seleccionados con sus nombres (sin duplicados)
    const nivelesInfo = [];
    const nivelesYaAgregados = new Set();
    
    $('#niveles_educativos option:selected').each(function() {
        const nivelId = $(this).val();
        // Solo agregamos el nivel si no está ya en el conjunto
        if (!nivelesYaAgregados.has(nivelId)) {
            nivelesYaAgregados.add(nivelId);
            nivelesInfo.push({
                id: nivelId,
                nombre: $(this).text()
            });
        }
    });
    
    // Solicitar las categorías para cada nivel seleccionado
    fetch(window.location.origin + '/api/categorias-por-niveles', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ niveles: Array.from(nivelesYaAgregados) }) // Convertir a array
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Error en la respuesta del servidor: ' + response.status);
        }
        return response.json();
    })
    .then(data => {
        console.log('Datos recibidos:', data); // Para depuración
        
        if (Object.keys(data).length === 0) {
            contenedorCategorias.innerHTML = '<p class="text-sm text-gray-500">No hay categorías disponibles para los niveles seleccionados</p>';
            return;
        }
        
        // Limpiar el contenedor antes de añadir nuevos elementos
        contenedorCategorias.innerHTML = '';
        
        // Crear una sección para cada nivel con sus categorías
        nivelesInfo.forEach(nivel => {
            if (!data[nivel.id]) {
                console.log('No hay datos para el nivel:', nivel.id); // Para depuración
                return;
            }
            
            // Almacenar todas las categorías para este nivel
            const todasLasCategorias = data[nivel.id] || [];
            console.log('Categorías para nivel', nivel.id, ':', todasLasCategorias); // Para depuración
            
            // Crear el contenedor para este nivel
            const nivelContainer = document.createElement('div');
            nivelContainer.className = 'p-4 border rounded-lg mb-4';
            nivelContainer.dataset.nivelId = nivel.id;
            
            // Título del nivel
            const nivelTitle = document.createElement('h3');
            nivelTitle.className = 'font-medium text-gray-800 mb-2';
            nivelTitle.textContent = nivel.nombre;
            nivelContainer.appendChild(nivelTitle);
            
            // Si no hay categorías para este nivel
            if (todasLasCategorias.length === 0) {
                const noCategoriasMsg = document.createElement('p');
                noCategoriasMsg.className = 'text-sm text-gray-500';
                noCategoriasMsg.textContent = 'No hay categorías disponibles para este nivel';
                nivelContainer.appendChild(noCategoriasMsg);
            } else {
                // Añadir un campo de búsqueda
                const searchContainer = document.createElement('div');
                searchContainer.className = 'mb-3';
                
                const searchInput = document.createElement('input');
                searchInput.type = 'text';
                searchInput.placeholder = 'Buscar categorías...';
                searchInput.className = 'w-full px-3 py-2 text-sm border rounded-lg focus:ring-primary focus:border-primary';
                searchInput.dataset.nivelId = nivel.id;
                
                searchContainer.appendChild(searchInput);
                nivelContainer.appendChild(searchContainer);
                
                // Crear un div para contener las checkboxes de las categorías
                const categoriasWrapper = document.createElement('div');
                categoriasWrapper.className = 'grid grid-cols-2 gap-2';
                categoriasWrapper.id = `categorias-wrapper-${nivel.id}`;
                
                // Eliminar duplicados en las categorías mediante un Set de IDs
                const categoriasVistas = new Set();
                const categoriasFiltradas = [];
                
                todasLasCategorias.forEach(categoria => {
                    if (!categoriasVistas.has(categoria.id)) {
                        categoriasVistas.add(categoria.id);
                        categoriasFiltradas.push(categoria);
                    }
                });
                
                // Añadir las checkboxes de categorías sin duplicados
                categoriasFiltradas.forEach(categoria => {
                    const categoriaDiv = document.createElement('div');
                    categoriaDiv.className = 'flex items-center categoria-item';
                    categoriaDiv.dataset.nombre = categoria.nombre_categoria.toLowerCase();
                    
                    const checkbox = document.createElement('input');
                    checkbox.type = 'checkbox';
                    checkbox.name = `categorias[${nivel.id}][]`;
                    checkbox.value = categoria.id;
                    checkbox.id = `categoria-${nivel.id}-${categoria.id}`;
                    checkbox.className = 'mr-2';
                    
                    // Comprobar si esta categoría estaba seleccionada anteriormente
                    // Primero verificar en old() de Laravel
                    const nivelIdStr = nivel.id.toString();
                    if (oldCategorias && oldCategorias[nivelIdStr] && 
                        oldCategorias[nivelIdStr].includes(categoria.id.toString())) {
                        checkbox.checked = true;
                    }
                    // Si no está en old(), verificar en las selecciones actuales de la sesión
                    else {
                        const checkboxName = `categorias[${nivel.id}][]`;
                        if (seleccionesActuales[checkboxName] && 
                            seleccionesActuales[checkboxName].includes(categoria.id.toString())) {
                            checkbox.checked = true;
                        }
                    }
                    
                    const label = document.createElement('label');
                    label.htmlFor = `categoria-${nivel.id}-${categoria.id}`;
                    label.className = 'text-sm text-gray-700';
                    label.textContent = categoria.nombre_categoria;
                    
                    categoriaDiv.appendChild(checkbox);
                    categoriaDiv.appendChild(label);
                    categoriasWrapper.appendChild(categoriaDiv);
                });
                
                nivelContainer.appendChild(categoriasWrapper);
                
                // Añadir evento de búsqueda
                searchInput.addEventListener('input', function() {
                    const searchText = this.value.toLowerCase();
                    const nivelId = this.dataset.nivelId;
                    const categoriaItems = document.querySelectorAll(`#categorias-wrapper-${nivelId} .categoria-item`);
                    
                    categoriaItems.forEach(item => {
                        const nombreCategoria = item.dataset.nombre;
                        if (nombreCategoria.includes(searchText)) {
                            item.style.display = '';
                        } else {
                            item.style.display = 'none';
                        }
                    });
                });
            }
            
            // Añadir este nivel al contenedor principal
            contenedorCategorias.appendChild(nivelContainer);
        });
    })
    .catch(error => {
        console.error('Error al cargar categorías:', error);
        contenedorCategorias.innerHTML = `<p class="text-sm text-red-500">Error al cargar las categorías: ${error.message}. Inténtalo de nuevo más tarde.</p>`;
    });
}

// Cargar provincias y ciudades
window.loadProvincias = function() {
    fetch('/api/provincias')
        .then(response => response.json())
        .then(data => {
            const select = document.getElementById('provincia');
            select.innerHTML = '<option value="">Selecciona una provincia</option>';
            
            data.forEach(provincia => {
                const option = document.createElement('option');
                option.value = provincia.nombre;
                option.textContent = provincia.nombre;
                select.appendChild(option);
            });
            
            // Restaurar provincia si hay un valor anterior
            const provinciaAnterior = document.getElementById('provincia_anterior').value;
            if (provinciaAnterior) {
                select.value = provinciaAnterior;
                // Cargar ciudades de esta provincia
                window.loadCiudades(provinciaAnterior);
            }
        })
        .catch(error => console.error('Error cargando provincias:', error));
};

window.loadCiudades = function(provincia, callback) {
    console.log('Cargando ciudades para provincia:', provincia);
    fetch(`/api/ciudades?provincia=${encodeURIComponent(provincia)}`)
        .then(response => {
            console.log('Respuesta status:', response.status);
            return response.json();
        })
        .then(data => {
            console.log('Ciudades recibidas:', data);
            const select = document.getElementById('ciudad');
            select.innerHTML = '<option value="">Selecciona una ciudad</option>';
            
            data.forEach(ciudad => {
                const option = document.createElement('option');
                option.value = ciudad.nombre;
                option.textContent = ciudad.nombre;
                select.appendChild(option);
            });
            
            // Restaurar ciudad si hay un valor anterior
            const ciudadAnterior = document.getElementById('ciudad_anterior').value;
            if (ciudadAnterior) {
                select.value = ciudadAnterior;
            }
            
            // Si hay un callback, ejecutarlo
            if (typeof callback === 'function') {
                callback();
            }
        })
        .catch(error => console.error('Error cargando ciudades:', error));
};

// Validación de ciudad
window.validateCiudad = function() {
    const ciudadField = document.getElementById('ciudad');
    if (!ciudadField) return true;
    
    const ciudadValue = ciudadField.value.trim();
    if (!ciudadValue) {
        window.updateFieldStatus(ciudadField, false, 'Debes seleccionar una ciudad');
        return false;
    }
    
    window.updateFieldStatus(ciudadField, true);
    return true;
};

// Validación completa del formulario
window.validateForm = function() {
    const validations = [
        window.validateName(),
        window.validateEmail(),
        window.validateCodigoCentro(),
        window.validateNivelesEducativos(),
        window.validateDireccion(),
        window.validateProvincia(),
        window.validateCiudad(),
        window.validateCodigoPostal(),
        window.validateRepresentanteLegal(),
        window.validateCargoRepresentante(),
        window.validatePassword(),
        window.validatePasswordConfirmation()
    ];
    
    return validations.every(Boolean);
};

// Cuando el DOM esté cargado
document.addEventListener('DOMContentLoaded', function() {
    // ... existing code ...
    
    // Marcar los campos con errores de servidor
    const serverErrors = document.querySelectorAll('.text-red-500:not([id*="-error"])');
    serverErrors.forEach(errorElement => {
        const parentField = errorElement.closest('.mb-4');
        if (parentField) {
            const input = parentField.querySelector('input, select');
            if (input) {
                input.classList.add('border-red-500');
            }
        }
    });
});
</script>
@endsection 