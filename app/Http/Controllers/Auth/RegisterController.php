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

    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:usuarios'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:alumno,empresa'],
        ]);

        $user = User::create([
            'nombre' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'active' => 1,
        ]);

        // ASIGNAMOS EL ROL
            $rol = \App\Models\Rol::where('nombre', $request->role)->first();
            $user->rol_id = $rol->id;
            $user->save();

        // CREAMOS EL PERFIL
            if ($request->role == 'alumno') {
                Estudiante::create([
                    'usuario_id' => $user->id,
                    // SE AÑADE DESPUES
                    'centro_estudios' => null,
                ]);
            } else {
                Empresa::create([
                    'usuario_id' => $user->id,
                    // SE AÑADE DESPUES
                    'direccion' => null,
                ]);
            }

        event(new Registered($user));

        Auth::login($user);

        return redirect($request->role == 'alumno' ? route('alumno.dashboard') : route('empresa.dashboard'));
    }
}