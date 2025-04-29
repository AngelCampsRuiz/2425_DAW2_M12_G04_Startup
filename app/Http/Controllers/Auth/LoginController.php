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
            $request->session()->regenerate();

            $user = Auth::user();
            
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
                    // Implementar ruta para docentes cuando sea necesario
                    return redirect()->intended('/');
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
}