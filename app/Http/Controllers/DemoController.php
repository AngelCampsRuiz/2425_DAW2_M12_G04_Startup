<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Publication;
use App\Models\Empresa;
use App\Models\Categoria;
use App\Models\Subcategoria;

class DemoController extends Controller
{
    /**
     * Muestra una vista de demostración del dashboard de estudiante
     */
    public function demoStudent(Request $request)
    {
        $query = Publication::with(['empresa', 'categoria', 'subcategoria'])->where('activa', true);

        // Aplicar búsqueda por título
        if ($request->has('search')) {
            $query->where('titulo', 'like', '%' . $request->get('search') . '%');
        }

        // Aplicar filtro de horario
        if ($request->has('horario')) {
            $query->whereIn('horario', $request->get('horario'));
        }

        // Aplicar filtro de categoría
        if ($request->has('categoria')) {
            $query->whereIn('categoria_id', $request->get('categoria'));
        }

        // Aplicar filtro de subcategoría
        if ($request->has('subcategoria')) {
            $query->whereIn('subcategoria_id', $request->get('subcategoria'));
        }

        // Aplicar filtro de fecha de publicación
        if ($request->has('fecha_inicio') && $request->has('fecha_fin')) {
            $query->whereBetween('fecha_publicacion', [$request->get('fecha_inicio'), $request->get('fecha_fin')]);
        }

        // Aplicar filtro de horas totales
        if ($request->has('horas_totales_min') && $request->has('horas_totales_max')) {
            $query->whereBetween('horas_totales', [$request->get('horas_totales_min'), $request->get('horas_totales_max')]);
        }

        // Aplicar ordenamiento
        $orderBy = $request->get('order_by', 'fecha_publicacion');
        $orderDirection = $request->get('order_direction', 'desc');
        $query->orderBy($orderBy, $orderDirection);

        // Obtener resultados paginados
        $publications = $query->paginate(6);

        // Obtener horarios únicos
        $horarios = Publication::select('horario')->distinct()->pluck('horario');

        // Obtener categorías con sus subcategorías que tienen publicaciones activas
        $categoriasConPublicaciones = Publication::where('activa', true)
            ->distinct()
            ->pluck('categoria_id');

        $subcategoriasConPublicaciones = Publication::where('activa', true)
            ->whereNotNull('subcategoria_id')
            ->distinct()
            ->pluck('subcategoria_id');

        $categorias = Categoria::whereIn('id', $categoriasConPublicaciones)
            ->with(['subcategorias' => function($query) use ($subcategoriasConPublicaciones) {
                $query->whereIn('id', $subcategoriasConPublicaciones);
            }])
            ->get();

        // Obtener valores mínimos y máximos de horas totales
        $horasTotalesMin = Publication::min('horas_totales');
        $horasTotalesMax = Publication::max('horas_totales');

        return view('student.dashboard', [
            'publications' => $publications,
            'horarios' => $horarios,
            'categorias' => $categorias,
            'horasTotalesMin' => $horasTotalesMin,
            'horasTotalesMax' => $horasTotalesMax,
            'is_demo' => true // Agregar flag para indicar que es una demostración
        ]);
    }

    /**
     * Muestra una vista de demostración del dashboard de empresa
     */
    public function demoCompany()
    {
        // Obtener algunas empresas para mostrar en la demo
        $empresa = Empresa::with('user')->first();
        
        // Obtener algunas estadísticas ficticias para la demo
        $stats = [
            'ofertasActivas' => 3,
            'totalSolicitudes' => 15,
            'solicitudesPendientes' => 8,
            'ofertasInactivas' => 2
        ];
        
        // Pasar un flag para indicar que es una vista de demostración
        return view('demo.company', compact('empresa', 'stats'));
    }

    /**
     * Redirecciona al formulario de registro cuando se intenta realizar una acción
     * que requiere autenticación
     */
    public function redirectToRegister(Request $request)
    {
        return redirect()->route('register')->with('demo_message', 'Para realizar esta acción, necesitas registrarte primero.');
    }
}
