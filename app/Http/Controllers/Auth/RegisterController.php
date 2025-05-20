<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Estudiante;
use App\Models\Empresa;
use App\Models\Rol;
use App\Models\Institucion;
use App\Models\Categoria;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
        
        if (!$registrationData) {
            return redirect()->route('register')
                ->withErrors(['error' => 'Por favor complete el primer paso del registro']);
        }
        
        // Verificar que el rol sea alumno
        if ($registrationData['role'] !== 'alumno') {
            return redirect()->route('register')
                ->withErrors(['error' => 'Esta página es solo para estudiantes']);
        }

        // Obtener todas las categorías para mostrarlas en el formulario
        $categorias = Categoria::all();
        return view('auth.register-student', compact('categorias'));
    }

    // Vista de registro de empresa
    public function showCompanyRegistrationForm(Request $request)
    {
        $registrationData = $request->session()->get('registration_data');
        
        if (!$registrationData) {
            return redirect()->route('register')
                ->withErrors(['error' => 'Por favor complete el primer paso del registro']);
        }
        
        // Verificar que el rol sea empresa
        if ($registrationData['role'] !== 'empresa') {
            return redirect()->route('register')
                ->withErrors(['error' => 'Esta página es solo para empresas']);
        }
        
        return view('auth.register-company');
    }

    // Vista de registro de institución
    public function showInstitutionRegistrationForm(Request $request)
    {
        $registrationData = $request->session()->get('registration_data');
        
        if (!$registrationData) {
            return redirect()->route('register')
                ->withErrors(['error' => 'Por favor complete el primer paso del registro']);
        }
        
        // Verificar que el rol sea institución
        if ($registrationData['role'] !== 'institucion') {
            return redirect()->route('register')
                ->withErrors(['error' => 'Esta página es solo para instituciones']);
        }
        
        // Obtener todos los niveles educativos para pasarlos a la vista (asegurando que no haya duplicados)
        $nivelesEducativos = \App\Models\NivelEducativo::select('id', 'nombre_nivel')
                                ->distinct()
                                ->orderBy('nombre_nivel')
                                ->get();
        
        return view('auth.register-institution', compact('nivelesEducativos'));
    }

    // Registro de estudiante (tercer paso)
    public function registerStudent(Request $request)
    {
        // Obtener datos de registro de la sesión
        $registrationData = $request->session()->get('registration_data');
        
        if (!$registrationData) {
            return redirect()->route('register')
                ->withErrors(['error' => 'Por favor complete el primer paso del registro']);
        }
        
        // Combinar datos de la sesión con los datos del formulario
        $data = array_merge($request->all(), [
            'name' => $registrationData['name'],
            'email' => $registrationData['email'],
        ]);

        Log::info('Datos recibidos en registerStudent', [
            'categoria_id' => $request->categoria_id,
            'data' => $data
        ]);

        $validator = Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:user',
            'password' => 'required|string|min:8|confirmed',
            'dni' => ['required', 'string', 'max:20', 'unique:user', 'regex:/^[0-9]{8}[A-Za-z]$|^[XYZxyz][0-9]{7}[A-Za-z]$/'],
            'telefono' => 'required|string|max:20|unique:user',
            'provincia_id' => 'required|integer|min:1|max:52',
            'ciudad' => 'required|string|max:100',
            'centro_estudios' => 'required|exists:instituciones,id',
            'nivel_educativo_id' => 'required|exists:niveles_educativos,id',
            'categoria_id' => 'required|exists:categorias,id',
            'cv_pdf' => 'required|file|mimes:pdf|max:5120', // 5MB máximo
            'numero_seguridad_social' => ['required', 'string', 'max:50', 'regex:/^SS[0-9]{8}$/']
        ], [
            'provincia_id.required' => 'Debes seleccionar una provincia',
            'centro_estudios.required' => 'Debes seleccionar un centro educativo',
            'centro_estudios.exists' => 'El centro educativo seleccionado no existe',
            'nivel_educativo_id.required' => 'Debes seleccionar un nivel educativo',
            'nivel_educativo_id.exists' => 'El nivel educativo seleccionado no existe',
            'categoria_id.required' => 'Debes seleccionar una categoría',
            'categoria_id.exists' => 'La categoría seleccionada no existe',
            'numero_seguridad_social.regex' => 'El número de seguridad social debe tener el formato SS seguido de 8 dígitos',
            'cv_pdf.mimes' => 'El archivo debe ser un PDF',
            'cv_pdf.max' => 'El archivo no puede ser mayor a 5MB',
            'dni.unique' => 'Este DNI/NIE ya está registrado',
            'dni.regex' => 'El formato del DNI/NIE no es válido. Debe ser un DNI (8 números y 1 letra) o un NIE (X/Y/Z seguido de 7 números y 1 letra)',
            'telefono.unique' => 'Este teléfono ya está registrado'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Obtener el nombre de la ciudad seleccionada
        $nombreCiudad = $request->ciudad;
        
        // Obtener el nombre del centro educativo
        $institucion = Institucion::find($request->centro_estudios);
        $nombreCentro = $institucion ? $institucion->user->nombre : 'Centro no encontrado';

        // Crear usuario
        $user = User::create([
            'nombre' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($request->password),
            'role_id' => Rol::where('nombre_rol', 'Estudiante')->first()->id,
            'fecha_nacimiento' => now()->subYears(rand(18, 25)),
            'ciudad' => $nombreCiudad,
            'dni' => $request->dni,
            'activo' => false,
            'telefono' => $request->telefono,
            'descripcion' => 'Estudiante',
            'imagen' => null
        ]);

        // Procesar y guardar el archivo PDF
        if ($request->hasFile('cv_pdf')) {
            $cvFile = $request->file('cv_pdf');
            $cvFileName = 'cv_' . $user->id . '_' . time() . '.pdf';
            
            // Crear directorio si no existe
            if (!file_exists(public_path('cv'))) {
                mkdir(public_path('cv'), 0777, true);
            }
            
            // Mover el archivo a public/cv
            $cvFile->move(public_path('cv'), $cvFileName);
        }

        // Crear estudiante
        // Desactivar temporalmente la comprobación de claves foráneas
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        
        Estudiante::create([
            'id' => $user->id,
            'institucion_id' => $request->centro_estudios,
            'centro_educativo' => $nombreCentro,
            'cv_pdf' => $cvFileName,
            'numero_seguridad_social' => $request->numero_seguridad_social,
            'categoria_id' => $request->categoria_id,
            'estado' => 'pendiente'
        ]);
        
        // Reactivar la comprobación de claves foráneas
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        // Limpiar datos de registro de la sesión
        $request->session()->forget('registration_data');

        event(new Registered($user));
        // Auth::login($user); // Comentado para evitar el inicio de sesión automático
        
        return redirect()->route('login')
            ->with('success', 'Registro completado correctamente. Tu cuenta debe ser activada por tu institución antes de poder acceder.');
    }

    // Registro de empresa (tercer paso)
    public function registerCompany(Request $request)
    {
        // Recuperar datos de los pasos anteriores
        $registrationData = $request->session()->get('registration_data');
        
        if (!$registrationData) {
            return redirect()->route('register')
                ->withErrors(['error' => 'Por favor complete el primer paso del registro']);
        }
        
        $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'cif' => ['required', 'string', 'max:15'],
            'direccion' => ['required', 'string', 'max:255'],
            'provincia' => ['required', 'string', 'max:100'],
        ]);
        
        // Crear usuario
        $user = User::create([
            'nombre' => $registrationData['name'],
            'email' => $registrationData['email'],
            'password' => Hash::make($request->password),
            'role_id' => Rol::where('nombre_rol', 'Empresa')->first()->id,
            'fecha_nacimiento' => now()->subYears(rand(25, 65)),
            'ciudad' => 'Madrid',
            'dni' => 'DNI' . rand(10000000, 99999999),
            'activo' => true,
            'telefono' => '6' . rand(100000000, 999999999),
            'descripcion' => 'Empresa',
            'imagen' => null
        ]);

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

    // Registro de institución
    public function registerInstitution(Request $request)
    {
        // Recuperar datos de los pasos anteriores
        $registrationData = $request->session()->get('registration_data');
        
        if (!$registrationData) {
            return redirect()->route('register')
                ->withErrors(['error' => 'Por favor complete el primer paso del registro']);
        }
        
        $validator = Validator::make($request->all(), [
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'codigo_centro' => ['required', 'string', 'max:8', 'unique:instituciones,codigo_centro'],
            'niveles_educativos' => ['required', 'array', 'min:1'],
            'niveles_educativos.*' => ['exists:niveles_educativos,id'],
            'direccion' => ['required', 'string', 'max:255'],
            'provincia' => ['required', 'string', 'max:100'],
            'ciudad' => ['required', 'string', 'max:100'],
            'codigo_postal' => ['required', 'string', 'max:5'],
            'representante_legal' => ['required', 'string', 'max:255'],
            'cargo_representante' => ['required', 'string', 'max:255'],
            'categorias' => ['sometimes', 'array'],
        ], [
            'codigo_centro.unique' => 'Este código de centro ya está registrado',
            'password.required' => 'La contraseña es obligatoria',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres',
            'password.confirmed' => 'Las contraseñas no coinciden',
            'niveles_educativos.required' => 'Debes seleccionar al menos un nivel educativo',
            'niveles_educativos.min' => 'Debes seleccionar al menos un nivel educativo',
            'provincia.required' => 'Debes seleccionar una provincia',
            'ciudad.required' => 'Debes seleccionar una ciudad',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        // Crear usuario
        $user = User::create([
            'nombre' => $registrationData['name'],
            'email' => $registrationData['email'],
            'password' => Hash::make($request->password),
            'role_id' => Rol::where('nombre_rol', 'Institucion')->first()->id,
            'fecha_nacimiento' => now()->subYears(rand(25, 50)),
            'ciudad' => $request->ciudad,
            'dni' => 'INST' . rand(10000000, 99999999),
            'activo' => true,
            'telefono' => '9' . rand(10000000, 99999999),
            'descripcion' => 'Institución Educativa',
            'imagen' => null
        ]);
        
        // Crear el perfil de institución
        $institucion = Institucion::create([
            'user_id' => $user->id,
            'codigo_centro' => $request->codigo_centro,
            'direccion' => $request->direccion,
            'ciudad' => $request->ciudad,
            'codigo_postal' => $request->codigo_postal,
            'representante_legal' => $request->representante_legal,
            'cargo_representante' => $request->cargo_representante,
            'verificada' => false,
        ]);
        
        // Registrar los niveles educativos seleccionados
        if ($request->has('niveles_educativos')) {
            foreach ($request->niveles_educativos as $nivelId) {
                DB::table('institucion_nivel_educativo')->insert([
                    'institucion_id' => $institucion->id,
                    'nivel_educativo_id' => $nivelId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
        
        // Registrar las categorías seleccionadas para cada nivel
        if ($request->has('categorias') && is_array($request->categorias)) {
            foreach ($request->categorias as $nivelId => $categorias) {
                if (is_array($categorias)) {
                    foreach ($categorias as $categoriaId) {
                        DB::table('institucion_categoria')->insert([
                            'institucion_id' => $institucion->id,
                            'categoria_id' => $categoriaId,
                            'nivel_educativo_id' => $nivelId,
                            'nombre_personalizado' => null,
                            'descripcion' => null,
                            'activo' => true,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            }
        }
        
        // Limpiar los datos de sesión
        $request->session()->forget('registration_data');
        
        event(new Registered($user));
        Auth::login($user);
        return redirect()->route('institucion.dashboard');
    }

    // Registro general - Primer paso (nombre, email, rol)
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:user',
            'role' => 'required|in:alumno,empresa,institucion'
        ], [
            'name.required' => 'El nombre es obligatorio',
            'name.max' => 'El nombre no puede tener más de 255 caracteres',
            'email.required' => 'El correo electrónico es obligatorio',
            'email.email' => 'El formato del correo electrónico no es válido',
            'email.max' => 'El correo electrónico no puede tener más de 255 caracteres',
            'email.unique' => 'Este correo electrónico ya está registrado',
            'role.required' => 'Debes seleccionar un tipo de usuario',
            'role.in' => 'El tipo de usuario seleccionado no es válido'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Guardar datos en la sesión
        $request->session()->put('registration_data', [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'step' => 1
        ]);

        // Redirigir según el rol
        if ($request->role === 'alumno') {
            return redirect()->route('register.alumno');
        } elseif ($request->role === 'empresa') {
            return redirect()->route('register.empresa');
        } else {
            return redirect()->route('register.institucion');
        }
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

    protected function create(array $data)
    {
        $user = User::create([
            'nombre' => $data['nombre'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'dni' => $data['dni'],
            'rol' => 'Estudiante',
        ]);

        Estudiante::create([
            'user_id' => $user->id,
            'categoria_id' => $data['categoria_id'],
            'estado' => 'pendiente',
            'institucion_id' => $data['institucion_id']
        ]);

        return $user;
    }
}