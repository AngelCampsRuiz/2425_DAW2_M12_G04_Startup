<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Estudiante;
use App\Models\Empresa;
use App\Models\Convenio;
use App\Models\Seguimiento;
use App\Models\Publicacion;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // OBTENEMOS LOS DATOS DE LA BASE DE DATOS
            $totalAlumnos = Estudiante::count();
            $totalEmpresas = Empresa::count();
            $totalConvenios = Convenio::count();


        // OBTENEMOS LAS EMPRESAS DESTACADAS
            // $empresasDestacadas = Empresa::withCount(['convenios as alumnos_contratados' => function($query) {
            //     $query->whereHas('seguimiento', function($q) {
            //         $q->where('estado', 'completado');
            //     });
            // }])
            // ->orderByDesc('alumnos_contratados')
            // ->limit(6)
            // ->get();
            $empresasDestacadas = collect();

        // CALCULAMOS EL PORCENTAJE DE EXITO
            $alumnosConPracticas = Seguimiento::where('estado', 'completado')->count();
            $porcentajeExito = $totalAlumnos > 0 ? round(($alumnosConPracticas / $totalAlumnos) * 100) : 0;

        // OBTENEMOS EL NUMERO DE COLES
            $totalCentros = Estudiante::distinct('centro_educativo')->count('centro_estudios');

        // PORCENTAJE DE EMPRESAS QUE VUELVEN HACER CONVENIOS
            $empresasRepiten = Empresa::has('convenios', '>', 1)->count();
            $porcentajeRepiten = $totalEmpresas > 0 ? round(($empresasRepiten / $totalEmpresas) * 100) : 0;

        // TOTAL DE PROVINCIAS
            $totalProvincias = Empresa::distinct('provincia')->count('provincia');

        // TOTAL DE OFERTAS
            $totalOfertas = Publicacion::where('activa', true)->count();

            return view('welcome', compact(
                'totalAlumnos',
                'totalEmpresas',
                'totalConvenios',
                'totalOfertas',
                'empresasDestacadas',
                'totalCentros',
                'porcentajeExito',
                'porcentajeRepiten',
                'totalProvincias'
            ));
    }

    public function profile()
    {
        return view('profile');
    }
}