@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-r from-primary/20 to-primary p-4">
    <div class="w-full max-w-4xl bg-white rounded-xl shadow-xl p-8">
        <div class="flex justify-center mb-6">
            <a href="{{ url('/') }}">
                <img src="{{ asset('assets/images/logo.svg') }}" alt="Logo" class="h-24">
            </a>
        </div>

        <!-- DEBUG INFORMACIÓN DE SESIÓN
        <div class="mb-6 p-4 bg-gray-100 rounded text-xs overflow-auto max-h-32">
            <p class="font-bold">Información de sesión:</p>
            <pre>{{ var_export(session()->all(), true) }}</pre>
        </div> -->

        <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Registro de Estudiante</h2>
        <p class="text-gray-600 text-center mb-6">Paso 2 de 2: Completa tus datos personales</p>

        <!-- Mensajes de error generales -->
        @if ($errors->any())
        <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded" role="alert">
            <p class="font-bold">Ha ocurrido un error</p>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form id="registerStudentForm" method="POST" action="{{ route('register.student.submit') }}" enctype="multipart/form-data">
            @csrf

            <div class="grid md:grid-cols-2 gap-6">
                <!-- Nombre y Email (solo lectura) -->
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 text-sm font-medium mb-2">Nombre completo</label>
                    <input id="name" type="text" name="name" value="{{ session('registration_data.name') ?? old('name') }}" readonly class="w-full bg-gray-100 px-4 py-2 border rounded-lg focus:ring-primary focus:border-primary @error('name') border-red-500 @enderror">
                    
                    @error('name')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                    <span id="name-error" class="text-red-500 text-xs"></span>
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-gray-700 text-sm font-medium mb-2">Correo electrónico</label>
                    <input id="email" type="email" name="email" value="{{ session('registration_data.email') ?? old('email') }}" readonly class="w-full bg-gray-100 px-4 py-2 border rounded-lg focus:ring-primary focus:border-primary @error('email') border-red-500 @enderror">
                    
                    @error('email')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                    <span id="email-error" class="text-red-500 text-xs"></span>
                </div>

                <!-- DNI -->
                <div class="mb-4">
                    <label for="dni" class="block text-gray-700 text-sm font-medium mb-2">DNI/NIE</label>
                    <input id="dni" type="text" name="dni" class="w-full px-4 py-2 border rounded-lg focus:ring-primary focus:border-primary @error('dni') border-red-500 @enderror" placeholder="Ej: 12345678A o X1234567B">
                    
                    @error('dni')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                    <span id="dni-error" class="text-red-500 text-xs"></span>
                </div>

                <!-- Teléfono -->
                <div class="mb-4">
                    <label for="telefono" class="block text-gray-700 text-sm font-medium mb-2">Teléfono</label>
                    <input id="telefono" type="tel" name="telefono" class="w-full px-4 py-2 border rounded-lg focus:ring-primary focus:border-primary @error('telefono') border-red-500 @enderror" placeholder="Ej: 612345678">
                    
                    @error('telefono')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                    <span id="telefono-error" class="text-red-500 text-xs"></span>
                </div>

                <!-- Provincia -->
                <div class="mb-4">
                    <label for="provincia_id" class="block text-gray-700 text-sm font-medium mb-2">Provincia</label>
                    <select id="provincia_id" name="provincia_id" class="w-full px-4 py-2 border rounded-lg focus:ring-primary focus:border-primary @error('provincia_id') border-red-500 @enderror">
                        <option value="">Selecciona una provincia</option>
                    </select>
                    
                    @error('provincia_id')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                    <span id="provincia_id-error" class="text-red-500 text-xs"></span>
                </div>

                <!-- Ciudad -->
                <div class="mb-4">
                    <label for="ciudad" class="block text-gray-700 text-sm font-medium mb-2">Ciudad</label>
                    <select id="ciudad" name="ciudad" class="w-full px-4 py-2 border rounded-lg focus:ring-primary focus:border-primary @error('ciudad') border-red-500 @enderror">
                        <option value="">Primero selecciona una provincia</option>
                    </select>
                    
                    @error('ciudad')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                    <span id="ciudad-error" class="text-red-500 text-xs"></span>
                </div>

                <!-- Centro educativo -->
                <div class="mb-4">
                    <label for="centro_estudios" class="block text-gray-700 text-sm font-medium mb-2">Centro Educativo</label>
                    <select id="centro_estudios" name="centro_estudios" class="w-full px-4 py-2 border rounded-lg focus:ring-primary focus:border-primary @error('centro_estudios') border-red-500 @enderror">
                        <option value="">Primero selecciona una ciudad</option>
                    </select>
                    
                    @error('centro_estudios')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                    <span id="centro_estudios-error" class="text-red-500 text-xs"></span>
                </div>

                <!-- Nivel educativo -->
                <div class="mb-4">
                    <label for="nivel_educativo_id" class="block text-gray-700 text-sm font-medium mb-2">Nivel Educativo</label>
                    <select id="nivel_educativo_id" name="nivel_educativo_id" class="w-full px-4 py-2 border rounded-lg focus:ring-primary focus:border-primary @error('nivel_educativo_id') border-red-500 @enderror">
                        <option value="">Primero selecciona un centro</option>
                    </select>
                    
                    @error('nivel_educativo_id')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                    <span id="nivel_educativo_id-error" class="text-red-500 text-xs"></span>
                </div>

                <!-- Título -->
                <div class="mb-4">
                    <label for="titulo_id" class="block text-gray-700 text-sm font-medium mb-2">Título</label>
                    <select id="titulo_id" name="titulo_id" class="w-full px-4 py-2 border rounded-lg focus:ring-primary focus:border-primary @error('titulo_id') border-red-500 @enderror">
                        <option value="">Primero selecciona un nivel educativo</option>
                    </select>
                    
                    @error('titulo_id')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                    <span id="titulo_id-error" class="text-red-500 text-xs"></span>
                </div>

                <!-- Número de Seguridad Social -->
                <div class="mb-4">
                    <label for="numero_seguridad_social" class="block text-gray-700 text-sm font-medium mb-2">Número de Seguridad Social</label>
                    <input id="numero_seguridad_social" type="text" name="numero_seguridad_social" class="w-full px-4 py-2 border rounded-lg focus:ring-primary focus:border-primary @error('numero_seguridad_social') border-red-500 @enderror" value="{{ old('numero_seguridad_social') }}" placeholder="Ej: SS12345678">
                    
                    @error('numero_seguridad_social')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                    <span id="numero_seguridad_social-error" class="text-red-500 text-xs"></span>
                </div>

                <!-- Contraseña -->
                <div class="mb-4">
                    <label for="password" class="block text-gray-700 text-sm font-medium mb-2">Contraseña</label>
                    <input id="password" type="password" name="password" class="w-full px-4 py-2 border rounded-lg focus:ring-primary focus:border-primary @error('password') border-red-500 @enderror" placeholder="Mínimo 8 caracteres">
                    
                    @error('password')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                    <span id="password-error" class="text-red-500 text-xs"></span>
                </div>

                <!-- Confirmar Contraseña -->
                <div class="mb-4">
                    <label for="password_confirmation" class="block text-gray-700 text-sm font-medium mb-2">Confirmar Contraseña</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" class="w-full px-4 py-2 border rounded-lg focus:ring-primary focus:border-primary" placeholder="Repite tu contraseña">
                    <span id="password_confirmation-error" class="text-red-500 text-xs"></span>
                </div>
            </div>

            <!-- CV -->
            <div class="mb-4">
                <label for="cv_pdf" class="block text-gray-700 text-sm font-medium mb-2">CV</label>
                <input id="cv_pdf" type="file" name="cv_pdf" class="w-full px-4 py-2 border rounded-lg focus:ring-primary focus:border-primary @error('cv_pdf') border-red-500 @enderror" accept=".pdf,.doc,.docx">
                
                @error('cv_pdf')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
                <span id="cv_pdf-error" class="text-red-500 text-xs"></span>
                <p class="text-xs text-gray-500 mt-1">Formatos aceptados: PDF, DOC, DOCX. Máximo 2MB.</p>
            </div>

            <!-- Botón de registro -->
            <div class="flex items-center justify-between">
                <button type="submit" id="submitBtn" class="w-full bg-primary text-white py-2 px-4 rounded-lg hover:bg-primary-dark transition font-medium">
                    Registrarse
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

// Validación de nombre
window.validateName = function() {
    const nameField = document.getElementById('name');
    if (!nameField) return true;
    
    const nameValue = nameField.value.trim();
    if (!nameValue) {
        window.updateFieldStatus(nameField, false, 'El nombre es obligatorio');
        return false;
    } else if (nameValue.length < 3) {
        window.updateFieldStatus(nameField, false, 'El nombre debe tener al menos 3 caracteres');
        return false;
    }
    
    window.updateFieldStatus(nameField, true);
    return true;
};

// Validación de email
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

// Validación de DNI
window.validateDNI = function() {
    const dniField = document.getElementById('dni');
    if (!dniField) return true;
    
    const dniValue = dniField.value.trim();
    const dniRegex = /^[0-9]{8}[A-Za-z]$/;
    const nieRegex = /^[XYZxyz][0-9]{7}[A-Za-z]$/;
    
    if (!dniValue) {
        window.updateFieldStatus(dniField, false, 'El DNI/NIE es obligatorio');
        return false;
    } else if (!dniRegex.test(dniValue) && !nieRegex.test(dniValue)) {
        window.updateFieldStatus(dniField, false, 'El formato del DNI/NIE no es válido (DNI: 8 números y una letra, NIE: X/Y/Z, 7 números y una letra)');
        return false;
    }
    
    window.updateFieldStatus(dniField, true);
    return true;
};

// Validación de teléfono
window.validateTelefono = function() {
    const telefonoField = document.getElementById('telefono');
    if (!telefonoField) return true;
    
    const phoneValue = telefonoField.value.trim();
    const phoneRegex = /^[0-9]{9}$/;
    
    if (!phoneValue) {
        window.updateFieldStatus(telefonoField, false, 'El teléfono es obligatorio');
        return false;
    } else if (!phoneRegex.test(phoneValue)) {
        window.updateFieldStatus(telefonoField, false, 'El formato del teléfono no es válido (9 dígitos)');
        return false;
    }
    
    window.updateFieldStatus(telefonoField, true);
    return true;
};

// Validación de provincia
window.validateProvincia = function() {
    const provinciaField = document.getElementById('provincia_id');
    if (!provinciaField) return true;
    
    const provinciaValue = provinciaField.value.trim();
    
    if (!provinciaValue) {
        window.updateFieldStatus(provinciaField, false, 'Debes seleccionar una provincia');
        return false;
    }
    
    window.updateFieldStatus(provinciaField, true);
    return true;
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

// Validación de centro de estudios
window.validateCentroEstudios = function() {
    const centroField = document.getElementById('centro_estudios');
    if (!centroField) return true;
    
    const centroValue = centroField.value.trim();
    
    if (!centroValue) {
        window.updateFieldStatus(centroField, false, 'Debes seleccionar un centro educativo');
        return false;
    }
    
    window.updateFieldStatus(centroField, true);
    return true;
};

// Validación de nivel educativo
window.validateNivelEducativo = function() {
    const nivelField = document.getElementById('nivel_educativo_id');
    if (!nivelField) return true;
    
    const nivelValue = nivelField.value.trim();
    
    if (!nivelValue) {
        window.updateFieldStatus(nivelField, false, 'Debes seleccionar un nivel educativo');
        return false;
    }
    
    window.updateFieldStatus(nivelField, true);
    return true;
};

// Validación del título
window.validateTitulo = function() {
    const tituloField = document.getElementById('titulo_id');
    if (!tituloField) return true;
    
    const tituloValue = tituloField.value.trim();
    
    if (!tituloValue) {
        window.updateFieldStatus(tituloField, false, 'Debes seleccionar un título');
        return false;
    }
    
    window.updateFieldStatus(tituloField, true);
    return true;
};

// Validación de número de seguridad social
window.validateNumeroSeguridadSocial = function() {
    const nssField = document.getElementById('numero_seguridad_social');
    if (!nssField) return true;
    
    const nssValue = nssField.value.trim();
    const nssRegex = /^SS[0-9]{8}$/;
    
    if (!nssValue) {
        window.updateFieldStatus(nssField, false, 'El número de seguridad social es obligatorio');
        return false;
    } else if (!nssRegex.test(nssValue)) {
        window.updateFieldStatus(nssField, false, 'El formato del número de seguridad social no es válido (SS seguido de 8 dígitos)');
        return false;
    }
    
    window.updateFieldStatus(nssField, true);
    return true;
};

// Validación de contraseña
window.validatePassword = function() {
    const passwordField = document.getElementById('password');
    if (!passwordField) return true;
    
    const passwordValue = passwordField.value.trim();
    
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

// Validación de confirmación de contraseña
window.validatePasswordConfirmation = function() {
    const passwordField = document.getElementById('password');
    const passwordConfirmField = document.getElementById('password_confirmation');
    if (!passwordField || !passwordConfirmField) return true;
    
    const passwordValue = passwordField.value.trim();
    const passwordConfirmValue = passwordConfirmField.value.trim();
    
    if (!passwordConfirmValue) {
        window.updateFieldStatus(passwordConfirmField, false, 'La confirmación de contraseña es obligatoria');
        return false;
    } else if (passwordValue !== passwordConfirmValue) {
        window.updateFieldStatus(passwordConfirmField, false, 'Las contraseñas no coinciden');
        return false;
    }
    
    window.updateFieldStatus(passwordConfirmField, true);
    return true;
};

// Validación de CV
window.validateCV = function() {
    const cvField = document.getElementById('cv_pdf');
    if (!cvField) return true;
    
    const cvValue = cvField.value.trim();
    const allowedExtensions = ['pdf', 'doc', 'docx'];
    const fileExtension = cvValue.split('.').pop().toLowerCase();
    
    if (!cvValue) {
        window.updateFieldStatus(cvField, false, 'El CV es obligatorio');
        return false;
    } else if (!allowedExtensions.includes(fileExtension)) {
        window.updateFieldStatus(cvField, false, 'El formato del CV no es válido (PDF, DOC o DOCX)');
        return false;
    }
    
    window.updateFieldStatus(cvField, true);
    return true;
};

// Cargar provincias, ciudades, instituciones y niveles educativos
window.loadProvincias = function() {
    fetch('/api/provincias')
        .then(response => response.json())
        .then(data => {
            const select = document.getElementById('provincia_id');
            select.innerHTML = '<option value="">Selecciona una provincia</option>';
            
            data.forEach(provincia => {
                const option = document.createElement('option');
                option.value = provincia.id;
                option.textContent = provincia.nombre;
                select.appendChild(option);
            });
        })
        .catch(error => console.error('Error cargando provincias:', error));
};

window.loadCiudades = function(provinciaId) {
    fetch(`/api/ciudades/${provinciaId}`)
        .then(response => response.json())
        .then(data => {
            const select = document.getElementById('ciudad');
            select.innerHTML = '<option value="">Selecciona una ciudad</option>';
            
            data.forEach(ciudad => {
                const option = document.createElement('option');
                option.value = ciudad.nombre;
                option.textContent = ciudad.nombre;
                select.appendChild(option);
            });
        })
        .catch(error => console.error('Error cargando ciudades:', error));
};

window.loadInstituciones = function(ciudad) {
    fetch(`/api/instituciones/${encodeURIComponent(ciudad)}`)
        .then(response => response.json())
        .then(data => {
            const select = document.getElementById('centro_estudios');
            select.innerHTML = '<option value="">Selecciona un centro educativo</option>';
            
            data.forEach(institucion => {
                const option = document.createElement('option');
                option.value = institucion.id;
                option.textContent = institucion.user.nombre;
                select.appendChild(option);
            });
        })
        .catch(error => console.error('Error cargando instituciones:', error));
};

window.loadNivelesEducativos = function(institucionId) {
    fetch(`/api/niveles-educativos/${institucionId}`)
        .then(response => response.json())
        .then(data => {
            const select = document.getElementById('nivel_educativo_id');
            select.innerHTML = '<option value="">Selecciona un nivel educativo</option>';
            
            data.forEach(nivel => {
                const option = document.createElement('option');
                option.value = nivel.id;
                option.textContent = nivel.nombre_nivel;
                select.appendChild(option);
            });
        })
        .catch(error => console.error('Error cargando niveles educativos:', error));
};

window.loadCategorias = function(nivelId, institucionId) {
    console.log(`Cargando categorías para nivel ${nivelId} e institución ${institucionId}`);
    
    fetch(`/api/categorias/${nivelId}/${institucionId}`)
        .then(response => {
            console.log('Respuesta API status:', response.status);
            return response.json();
        })
        .then(data => {
            console.log('Datos de categorías recibidos:', data);
            const select = document.getElementById('titulo_id');
            select.innerHTML = '<option value="">Selecciona un título</option>';
            
            if (data && data.length > 0) {
                data.forEach(categoria => {
                    const option = document.createElement('option');
                    option.value = categoria.id;
                    option.textContent = categoria.nombre_categoria;
                    select.appendChild(option);
                });
            } else {
                console.log('No se encontraron categorías para esta combinación de nivel e institución');
                select.innerHTML = '<option value="">No hay títulos disponibles</option>';
            }
        })
        .catch(error => {
            console.error('Error cargando categorías:', error);
            const select = document.getElementById('titulo_id');
            select.innerHTML = '<option value="">Error al cargar títulos</option>';
        });
};

document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('registerStudentForm');
    
    // Añadir validaciones en tiempo real
    const name = document.getElementById('name');
    const email = document.getElementById('email');
    const dni = document.getElementById('dni');
    const telefono = document.getElementById('telefono');
    const provincia_id = document.getElementById('provincia_id');
    const ciudad = document.getElementById('ciudad');
    const centro_estudios = document.getElementById('centro_estudios');
    const nivel_educativo_id = document.getElementById('nivel_educativo_id');
    const titulo_id = document.getElementById('titulo_id');
    const numero_seguridad_social = document.getElementById('numero_seguridad_social');
    const password = document.getElementById('password');
    const password_confirmation = document.getElementById('password_confirmation');
    const cv_pdf = document.getElementById('cv_pdf');
    
    // Cargar provincias al cargar la página
    window.loadProvincias();
    
    // Eventos para selección en cascada
    if (provincia_id) {
        provincia_id.addEventListener('change', function() {
            if (this.value) {
                window.loadCiudades(this.value);
                window.validateProvincia();
                
                // Reiniciar campos dependientes
                ciudad.innerHTML = '<option value="">Selecciona una ciudad</option>';
                centro_estudios.innerHTML = '<option value="">Primero selecciona una ciudad</option>';
                nivel_educativo_id.innerHTML = '<option value="">Primero selecciona un centro</option>';
                titulo_id.innerHTML = '<option value="">Primero selecciona un nivel educativo</option>';
            }
        });
    }
    
    if (ciudad) {
        ciudad.addEventListener('change', function() {
            if (this.value) {
                window.loadInstituciones(this.value);
                window.validateCiudad();
                
                // Reiniciar campos dependientes
                centro_estudios.innerHTML = '<option value="">Selecciona un centro educativo</option>';
                nivel_educativo_id.innerHTML = '<option value="">Primero selecciona un centro</option>';
                titulo_id.innerHTML = '<option value="">Primero selecciona un nivel educativo</option>';
            }
        });
    }
    
    if (centro_estudios) {
        centro_estudios.addEventListener('change', function() {
            if (this.value) {
                window.loadNivelesEducativos(this.value);
                window.validateCentroEstudios();
                
                // Reiniciar campos dependientes
                nivel_educativo_id.innerHTML = '<option value="">Selecciona un nivel educativo</option>';
                titulo_id.innerHTML = '<option value="">Primero selecciona un nivel educativo</option>';
            }
        });
    }
    
    if (nivel_educativo_id) {
        nivel_educativo_id.addEventListener('change', function() {
            if (this.value) {
                const institucionId = centro_estudios.value;
                window.loadCategorias(this.value, institucionId);
                window.validateNivelEducativo();
                
                // Reiniciar campos dependientes
                titulo_id.innerHTML = '<option value="">Selecciona un título</option>';
            }
        });
    }
    
    if (name) name.addEventListener('blur', window.validateName);
    if (email) email.addEventListener('blur', window.validateEmail);
    if (dni) dni.addEventListener('blur', window.validateDNI);
    if (telefono) telefono.addEventListener('blur', window.validateTelefono);
    if (provincia_id) provincia_id.addEventListener('blur', window.validateProvincia);
    if (ciudad) ciudad.addEventListener('blur', window.validateCiudad);
    if (centro_estudios) centro_estudios.addEventListener('blur', window.validateCentroEstudios);
    if (nivel_educativo_id) nivel_educativo_id.addEventListener('blur', window.validateNivelEducativo);
    if (titulo_id) titulo_id.addEventListener('change', window.validateTitulo);
    if (numero_seguridad_social) numero_seguridad_social.addEventListener('blur', window.validateNumeroSeguridadSocial);
    if (password) password.addEventListener('blur', window.validatePassword);
    if (password_confirmation) password_confirmation.addEventListener('blur', window.validatePasswordConfirmation);
    if (cv_pdf) cv_pdf.addEventListener('change', window.validateCV);
    
    // Validación en el submit del formulario
    if (form) {
        form.addEventListener('submit', function(e) {
            // Verificar todos los campos antes de enviar
            const isNameValid = window.validateName();
            const isEmailValid = window.validateEmail();
            const isDNIValid = window.validateDNI();
            const isTelefonoValid = window.validateTelefono();
            const isProvinciaValid = window.validateProvincia();
            const isCiudadValid = window.validateCiudad();
            const isCentroEstudiosValid = window.validateCentroEstudios();
            const isNivelEducativoValid = window.validateNivelEducativo();
            const isTituloValid = window.validateTitulo();
            const isNumeroSeguridadSocialValid = window.validateNumeroSeguridadSocial();
            const isPasswordValid = window.validatePassword();
            const isPasswordConfirmationValid = window.validatePasswordConfirmation();
            const isCVValid = window.validateCV();
            
            // Si hay errores, prevenir el envío del formulario
            if (!isNameValid || !isEmailValid || !isDNIValid || !isTelefonoValid || 
                !isProvinciaValid || !isCiudadValid || !isCentroEstudiosValid || 
                !isNivelEducativoValid || !isTituloValid || !isNumeroSeguridadSocialValid || 
                !isPasswordValid || !isPasswordConfirmationValid || !isCVValid) {
                e.preventDefault();
            }
        });
    }
    
    // Marcar los campos con errores de servidor
    const serverErrors = document.querySelectorAll('.text-red-500:not([id*="-error"])');
    serverErrors.forEach(errorElement => {
        const parentField = errorElement.closest('.mb-4');
        if (parentField) {
            const input = parentField.querySelector('input, select, .select2-container');
            if (input) {
                input.classList.add('border-red-500');
            }
        }
    });
});
</script>
@endsection
