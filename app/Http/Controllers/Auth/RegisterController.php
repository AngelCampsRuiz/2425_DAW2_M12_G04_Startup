<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Estudiante;
use App\Models\Empresa;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisterController extends Controller
{
    // MOSTRAMOS LA VISTA DEL REGISTER
        public function showRegistrationForm()
        {
            return view('auth.register');
        }

    // Vista de registro de estudiante
    public function showStudentRegistrationForm(Request $request)
    {
        $registrationData = $request->session()->get('registration_data');
        
        if (!$registrationData || !isset($registrationData['step']) || $registrationData['step'] < 2) {
            return redirect()->route('register.personal')
                ->withErrors(['error' => 'Por favor complete el segundo paso del registro']);
        }
        
        // Verificar que el rol sea estudiante
        if ($registrationData['role'] !== 'alumno') {
            return redirect()->route('register')
                ->withErrors(['error' => 'Esta página es solo para estudiantes']);
        }
        
        return view('auth.register-student');
    }

    // Vista de registro de empresa
    public function showCompanyRegistrationForm(Request $request)
    {
        $registrationData = $request->session()->get('registration_data');
        
        if (!$registrationData || !isset($registrationData['step']) || $registrationData['step'] < 2) {
            return redirect()->route('register.personal')
                ->withErrors(['error' => 'Por favor complete el segundo paso del registro']);
        }
        
        // Verificar que el rol sea empresa
        if ($registrationData['role'] !== 'empresa') {
            return redirect()->route('register')
                ->withErrors(['error' => 'Esta página es solo para empresas']);
        }
        
        return view('auth.register-company');
    }

    // Registro de estudiante (tercer paso)
    public function registerStudent(Request $request)
    {
        // Recuperar datos de los pasos anteriores
        $registrationData = $request->session()->get('registration_data');
        
        if (!$registrationData || $registrationData['step'] < 2) {
            return redirect()->route('register')
                ->withErrors(['error' => 'Por favor complete los pasos anteriores del registro']);
        }
        
        $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'centro_estudios' => ['required', 'string', 'max:255'],
            // Los siguientes campos son opcionales porque se envían como ocultos
            'cv_pdf' => ['nullable', 'string'],
            'numero_seguridad_social' => ['nullable', 'string'],
        ]);
        
        // Obtener el usuario y verificar que tenga todos los campos requeridos
        $user = User::find($registrationData['user_id']);
        if (!$user) {
            return redirect()->route('register')
                ->withErrors(['error' => 'Usuario no encontrado']);
        }
        
        // Verificar que los campos obligatorios estén presentes
        if (!$user->fecha_nacimiento || !$user->ciudad || !$user->dni || !$user->telefono) {
            return redirect()->route('register.personal')
                ->withErrors(['error' => 'Por favor complete todos los campos personales requeridos']);
        }
        
        // Verificación adicional usando el método del modelo
        if (!$user->hasRequiredFields()) {
            // Si faltan campos, determinar qué paso debe completar
            if (!$user->fecha_nacimiento || !$user->ciudad || !$user->dni || !$user->telefono) {
                return redirect()->route('register.personal')
                    ->withErrors(['error' => 'Información personal incompleta']);
            } else {
                return redirect()->route('register')
                    ->withErrors(['error' => 'Registro incompleto, por favor comience de nuevo']);
            }
        }

        // Obtener el usuario creado en el primer paso
        $user = User::find($registrationData['user_id']);
        if (!$user) {
            return redirect()->route('register')
                ->withErrors(['error' => 'Usuario no encontrado']);
        }
        
        // Actualizar la contraseña
        $user->password = Hash::make($request->password);

        // Asignar el rol de estudiante (ID 3)
        $rol = \App\Models\Rol::find(3);
        if (!$rol) {
            // Si no se encuentra por ID, intentar por nombre
            $rol = \App\Models\Rol::where('nombre_rol', 'Estudiante')->first();
            
            if (!$rol) {
                return redirect()->back()->withErrors(['error' => 'Rol de estudiante no encontrado']);
            }
        }
        
        $user->role_id = $rol->id;
        $user->save();

        // Crear el perfil de estudiante
        Estudiante::create([
            'id' => $user->id,
            'centro_educativo' => $request->centro_estudios,
            'cv_pdf' => $request->cv_pdf ?: '', // Usar el valor del formulario o cadena vacía
            'numero_seguridad_social' => $request->numero_seguridad_social ?: '' // Usar el valor del formulario o cadena vacía
        ]);

        // Limpiar los datos de sesión
        $request->session()->forget('registration_data');
        
        event(new Registered($user));
        Auth::login($user);
        return redirect()->route('student.dashboard');
    }

    // Registro de empresa (tercer paso)
    public function registerCompany(Request $request)
    {
        // Recuperar datos de los pasos anteriores
        $registrationData = $request->session()->get('registration_data');
        
        if (!$registrationData || $registrationData['step'] < 2) {
            return redirect()->route('register')
                ->withErrors(['error' => 'Por favor complete los pasos anteriores del registro']);
        }
        
        $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'cif' => ['required', 'string', 'max:15'],
            'direccion' => ['required', 'string', 'max:255'],
            'provincia' => ['required', 'string', 'max:100'],
        ]);
        
        // Obtener el usuario y verificar que tenga todos los campos requeridos
        $user = User::find($registrationData['user_id']);
        if (!$user) {
            return redirect()->route('register')
                ->withErrors(['error' => 'Usuario no encontrado']);
        }
        
        // Verificar que los campos obligatorios estén presentes
        if (!$user->fecha_nacimiento || !$user->ciudad || !$user->dni || !$user->telefono) {
            return redirect()->route('register.personal')
                ->withErrors(['error' => 'Por favor complete todos los campos personales requeridos']);
        }
        
        // Verificación adicional usando el método del modelo
        if (!$user->hasRequiredFields()) {
            // Si faltan campos, determinar qué paso debe completar
            if (!$user->fecha_nacimiento || !$user->ciudad || !$user->dni || !$user->telefono) {
                return redirect()->route('register.personal')
                    ->withErrors(['error' => 'Información personal incompleta']);
            } else {
                return redirect()->route('register')
                    ->withErrors(['error' => 'Registro incompleto, por favor comience de nuevo']);
            }
        }

        // Obtener el usuario creado en el primer paso
        $user = User::find($registrationData['user_id']);
        if (!$user) {
            return redirect()->route('register')
                ->withErrors(['error' => 'Usuario no encontrado']);
        }
        
        // Actualizar la contraseña
        $user->password = Hash::make($request->password);

        // Asignar el rol de empresa (ID 2)
        $rol = \App\Models\Rol::find(2);
        if (!$rol) {
            // Si no se encuentra por ID, intentar por nombre
            $rol = \App\Models\Rol::where('nombre_rol', 'Empresa')->first();
            
            if (!$rol) {
                return redirect()->back()->withErrors(['error' => 'Rol de empresa no encontrado']);
            }
        }
        
        $user->role_id = $rol->id;
        $user->save();

        // Crear el perfil de empresa
        Empresa::create([
            'id' => $user->id,
            'cif' => $request->cif,
            'direccion' => $request->direccion,
            'provincia' => $request->provincia,
            'latitud' => 0, // Se actualizará después con geocodificación
            'longitud' => 0, // Se actualizará después con geocodificación
        ]);

        // Limpiar los datos de sesión
        $request->session()->forget('registration_data');
        
        event(new Registered($user));
        Auth::login($user);
        return redirect()->route('empresa.dashboard');
    }

    // Registro general - Primer paso (nombre, email, rol)
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:user'],
            'role' => ['required', 'string', 'in:alumno,empresa']
        ]);
        
        // Crear usuario temporal con datos básicos
        // Asignamos una contraseña temporal y un rol temporal que se actualizarán en los siguientes pasos
        $temporaryPassword = Hash::make(uniqid('temp_', true));
        
        // Obtener un rol temporal (se actualizará en el paso final)
        // Usamos el rol con ID 1 (Administrador) como temporal
        $defaultRole = \App\Models\Rol::find(1);
        if (!$defaultRole) {
            // Si no se encuentra, intentar cualquier rol
            $defaultRole = \App\Models\Rol::first();
            
            if (!$defaultRole) {
                return redirect()->back()->withErrors(['error' => 'Error en la configuración del sistema. No hay roles definidos.']);
            }
        }
        
        $user = User::create([
            'nombre' => $request->name,
            'email' => $request->email,
            'password' => $temporaryPassword,
            'role_id' => $defaultRole->id
        ]);
        
        // Almacenar datos en sesión para los siguientes pasos
        $request->session()->put('registration_data', [
            'user_id' => $user->id,
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'step' => 1
        ]);
        
        // Redirigir al segundo paso (datos personales)
        return redirect()->route('register.personal');
    }
    
    // Mostrar formulario para el segundo paso (datos personales)
    public function showPersonalInfoForm(Request $request)
    {
        $registrationData = $request->session()->get('registration_data');
        
        if (!$registrationData || !isset($registrationData['step']) || $registrationData['step'] < 1) {
            return redirect()->route('register')
                ->withErrors(['error' => 'Por favor complete el primer paso del registro']);
        }
        
        return view('auth.register-personal');
    }
    
    // Procesar el segundo paso (datos personales)
    public function registerPersonalInfo(Request $request)
    {
        // Verificar que existan los datos del primer paso
        $registrationData = $request->session()->get('registration_data');
        if (!$registrationData || $registrationData['step'] < 1) {
            return redirect()->route('register');
        }
        
        // Calcular la fecha de hace 16 años
        $minAgeDate = now()->subYears(16)->format('Y-m-d');
        
        // Validar los datos personales con reglas más estrictas
        $request->validate([
            'fecha_nacimiento' => ['required', 'date', 'before_or_equal:'.$minAgeDate, 'after:1900-01-01'],
            'provincia' => ['required', 'string', 'max:100'],
            'ciudad' => ['required', 'string', 'max:100'],
            'dni' => ['required', 'string', 'max:20', 'regex:/^[0-9]{8}[A-Z]$|^[XYZ][0-9]{7}[A-Z]$/'],
            'telefono' => ['required', 'string', 'max:20', 'regex:/^[6-9][0-9]{8}$/']
        ], [
            'fecha_nacimiento.required' => 'La fecha de nacimiento es obligatoria',
            'fecha_nacimiento.before_or_equal' => 'Debes tener al menos 16 años para registrarte',
            'fecha_nacimiento.after' => 'La fecha de nacimiento no es válida',
            'provincia.required' => 'La provincia es obligatoria',
            'ciudad.required' => 'La ciudad es obligatoria',
            'dni.regex' => 'El formato del DNI/NIE no es válido',
            'telefono.regex' => 'El formato del teléfono no es válido'
        ]);
        
        // Actualizar el usuario con los datos personales
        $user = User::find($registrationData['user_id']);
        if (!$user) {
            return redirect()->route('register')
                ->withErrors(['error' => 'Usuario no encontrado']);
        }
        
        $user->update([
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'ciudad' => $request->ciudad,
            'dni' => $request->dni,
            'telefono' => $request->telefono
        ]);
        
        // Actualizar datos de sesión para el tercer paso
        $registrationData['step'] = 2;
        $request->session()->put('registration_data', $registrationData);
        
        // Redirigir según el rol seleccionado al tercer paso
        if ($registrationData['role'] === 'alumno') {
            return redirect()->route('register.alumno');
        } else {
            return redirect()->route('register.empresa');
        }
    }
}