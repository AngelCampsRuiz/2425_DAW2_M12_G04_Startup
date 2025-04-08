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
    public function showStudentRegistrationForm()
    {
        return view('auth.register-student');
    }

    // Vista de registro de empresa
    public function showCompanyRegistrationForm()
    {
        return view('auth.register-company');
    }

    // Registro de estudiante
    public function registerStudent(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],

            'centro_estudios' => ['required', 'string', 'max:255'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => null
        ]);

        // Asignamos el rol de estudiante
        $rol = \App\Models\Rol::where('nombre', 'alumno')->first();
        $user->rol_id = $rol->id;
        $user->save();

        // Creamos el perfil de estudiante
        Estudiante::create([
            'usuario_id' => $user->id,
            'centro_estudios' => $request->centro_estudios,
        ]);

        event(new Registered($user));
        Auth::login($user);
        return redirect()->route('alumno.dashboard');
    }

    // Registro de empresa
    public function registerCompany(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],

            'cif' => ['required', 'string', 'max:15'],
            'direccion' => ['required', 'string', 'max:255'],
            'provincia' => ['required', 'string', 'max:100'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => null
        ]);

        // Asignamos el rol de empresa
        $rol = \App\Models\Rol::where('nombre', 'empresa')->first();
        $user->rol_id = $rol->id;
        $user->save();

        // Creamos el perfil de empresa
        Empresa::create([
            'usuario_id' => $user->id,
            'cif' => $request->cif,
            'direccion' => $request->direccion,
            'provincia' => $request->provincia,
            'latitud' => 0, // Se actualizará después con geocodificación
            'longitud' => 0, // Se actualizará después con geocodificación
        ]);

        event(new Registered($user));
        Auth::login($user);
        return redirect()->route('empresa.dashboard');
    }

    // Registro general
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:user'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'string', 'in:alumno,empresa']
        ]);
        
        // Crear el usuario base
        $user = User::create([
            'nombre' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
        
        // Asignar el rol según la selección
        $rolName = $request->role === 'alumno' ? 'Estudiante' : 'Empresa';
        $rol = \App\Models\Rol::where('nombre_rol', $rolName)->first();
        
        if (!$rol) {
            // Si no se encuentra el rol, redirigir con error
            return redirect()->back()->withErrors(['role' => 'El rol seleccionado no es válido']);
        }
        
        $user->role_id = $rol->id;
        $user->save();
        
        // Registrar el evento y autenticar al usuario
        event(new Registered($user));
        Auth::login($user);
        
        // Redirigir según el rol
        if ($request->role === 'alumno') {
            return redirect()->route('student.dashboard');
        } else {
            return redirect()->route('home');
        }
    }
}