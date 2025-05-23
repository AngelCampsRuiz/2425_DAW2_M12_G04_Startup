<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Estudiante;
use App\Models\Empresa;
use App\Models\Convenio;
use App\Models\Seguimiento;
use App\Models\Publicacion;
use App\Models\Valoracion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        // OBTENEMOS LOS DATOS DE LA BASE DE DATOS
            $totalAlumnos = Estudiante::count();
            $totalEmpresas = Empresa::count();
            $totalConvenios = Convenio::count();


        // OBTENEMOS LAS EMPRESAS DESTACADAS
            $empresasDestacadas = Empresa::withCount(['convenios as alumnos_contratados' => function($query) {
                $query->whereHas('seguimiento', function($q) {
                    $q->where('estado', 'completado');
                });
            }])
            ->orderByDesc('alumnos_contratados')
            ->limit(6)
            ->get();

            // Si no hay empresas con alumnos contratados, obtenemos al menos algunas empresas para mostrar
            if ($empresasDestacadas->isEmpty() || $empresasDestacadas->sum('alumnos_contratados') == 0) {
                // Intentamos obtener algunas empresas aunque no tengan convenios completados
                $empresasDestacadas = Empresa::limit(6)->get();

                // Asignamos valores ficticios para mostrar en la vista
                $empresasDestacadas->each(function($empresa) {
                    $empresa->alumnos_contratados = rand(1, 10); // Valor aleatorio para demo
                });
            }

        // CALCULAMOS EL PORCENTAJE DE EXITO
            $alumnosConPracticas = Seguimiento::where('estado', 'completado')->count();
            $porcentajeExito = $totalAlumnos > 0 ? round(($alumnosConPracticas / $totalAlumnos) * 100) : 0;

        // OBTENEMOS EL NUMERO DE COLES
            $totalCentros = Estudiante::distinct('centro_educativo')->count('centro_estudios');

        // PORCENTAJE DE EMPRESAS QUE VUELVEN HACER CONVENIOS
            $empresasRepiten = Empresa::has('convenios', '>', 1)->count();
            $porcentajeRepiten = $totalEmpresas > 0 ? round(($empresasRepiten / $totalEmpresas) * 100) : 0;

        // TOTAL DE PROVINCIAS
            // $totalProvincias = Empresa::distinct('provincia')->count('provincia');

        // TOTAL DE OFERTAS
            $totalOfertas = Publicacion::where('activa', true)->count();

        // OFERTAS ACTIVAS ACTUALMENTE
            $ofertasActivas = Publicacion::where('activa', true)
                                         ->count();

        // CALCULAMOS EL SECTOR MÁS DEMANDADO
            $sectoresMasDemandados = Publicacion::where('activa', true)
                                      ->selectRaw('categoria_id, COUNT(*) as total')
                                      ->groupBy('categoria_id')
                                      ->orderByDesc('total')
                                      ->with('categoria')
                                      ->first();
            
            $sectorMasDemandado = $sectoresMasDemandados ? $sectoresMasDemandados->categoria->nombre_categoria : 'Informática';

        // VALORACIÓN MEDIA DE LAS EMPRESAS
            $valoracionMedia = '4.8'; // Valor fijo para evitar errores
            
            // $valoracionMedia = $valoracionMedia ? number_format($valoracionMedia, 1) : '4.8';

            return view('welcome', compact(
                'totalAlumnos',
                'totalEmpresas',
                'totalConvenios',
                'totalOfertas',
                'empresasDestacadas',
                'totalCentros',
                'porcentajeExito',
                'porcentajeRepiten',
                'ofertasActivas',
                'sectorMasDemandado',
                'valoracionMedia'
            ));
    }

    public function profile($id = null)
    {
        $user = $id ? User::where('id', $id)->firstOrFail() : Auth::user();
        $user->load(['tutor', 'estudiante', 'empresa']);

        // Obtener las valoraciones recibidas por el usuario
        $valoracionesRecibidas = $user->valoracionesRecibidas()
            ->with(['emisor', 'convenio'])
            ->orderBy('fecha_valoracion', 'desc')
            ->get();

        // Obtener las valoraciones emitidas por el usuario
        $valoracionesEmitidas = $user->valoracionesEmitidas()
            ->with(['receptor', 'convenio'])
            ->orderBy('fecha_valoracion', 'desc')
            ->get();

        $data = [
            'user' => $user,
            'tutor' => $user->tutor,
            'estudiante' => $user->estudiante,
            'empresa' => $user->empresa,
            'valoracionesRecibidas' => $valoracionesRecibidas,
            'valoracionesEmitidas' => $valoracionesEmitidas
        ];

        if ($user->empresa) {
            $data['experiencias'] = $user->empresa->experiencias()->with('alumno.user')->get();
        }

        return view('profile', $data);
    }

    public function updateVisibility(Request $request)
    {
        $user = User::where('id', $request->user_id)->firstOrFail();
        $user->visibilidad = !$user->visibilidad; // Toggle visibility
        $user->save();

        return response()->json(['success' => true, 'visibilidad' => $user->visibilidad]);
    }
}
