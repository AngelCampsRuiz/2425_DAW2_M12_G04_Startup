<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Empresa;

class CompanyDashboardController extends Controller
{
    /**
     * Show the company dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
        
        // Verificar que el usuario tenga el rol de empresa (role_id = 2)
        if (!$user || $user->role_id != 2) {
            return redirect('/')->with('error', 'No tienes permiso para acceder a esta página');
        }
        
        $empresa = Empresa::where('id', $user->id)->first();
        
        return view('dashboard.empresa', [
            'user' => $user,
            'empresa' => $empresa
        ]);
    }
}
