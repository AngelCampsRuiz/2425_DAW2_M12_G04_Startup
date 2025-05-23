<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // MOSTRAMOS LA VISTA DEL LOGIN
        public function showLoginForm()
        {
            return view('auth.login');
        }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->remember)) {
            $user = Auth::user();

            // Verificar si el usuario está activo
            if (!$user->activo) {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Tu cuenta no está activada. Por favor, contacta con tu institución para activar tu cuenta.',
                ]);
            }

            $request->session()->regenerate();

            // Comprobamos el nombre del rol en lugar del ID para mayor seguridad
            $roleName = $user->role ? $user->role->nombre_rol : null;

            // REDIRIGIMOS SEGUN EL ROL DEL USUARIO
            switch($roleName) {
                case 'Estudiante':
                    return redirect()->intended(route('student.dashboard'));
                case 'Administrador':
                    return redirect()->intended(route('admin.dashboard'));
                case 'Empresa':
                    return redirect()->intended(route('empresa.dashboard'));
                case 'Institución':
                    return redirect()->intended(route('institucion.dashboard'));
                case 'Docente':
                    return redirect()->intended(route('docente.dashboard'));
                default:
                    return redirect()->intended('/');
            }
        }

        return back()->withErrors([
            'email' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    protected function authenticated(Request $request, $user)
    {
        if ($user->rol === 'Estudiante') {
            $estudiante = $user->estudiante;
            if ($estudiante && $estudiante->estado === 'pendiente') {
                return redirect()->route('estudiante.dashboard')
                    ->with('warning', 'Tu cuenta está pendiente de activación. Por favor, contacta con tu institución.');
            }
        }

        return redirect()->intended($this->redirectPath());
    }

    protected function redirectPath()
    {
        $user = auth()->user();

        if ($user->rol === 'Estudiante') {
            return route('estudiante.dashboard');
        } elseif ($user->rol === 'Institucion') {
            return route('institucion.dashboard');
        } elseif ($user->rol === 'Admin') {
            return route('admin.dashboard');
        } elseif ($user->rol === 'Empresa') {
            return route('empresa.dashboard');
        }

        return '/';
    }
}