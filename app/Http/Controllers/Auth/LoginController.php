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
            $role = $user->role->id;

            // REDIRIGIMOS SEGUN EL ROL DEL USUARIO
                if ($role == 3) {
                    return redirect()->intended(route('student.dashboard'));
                } elseif($role == 1) {
                    return redirect()->intended(route('admin.dashboard'));

                } elseif ($role == 2) {
                    return redirect()->intended(route('empresa.dashboard'));
                } else {
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