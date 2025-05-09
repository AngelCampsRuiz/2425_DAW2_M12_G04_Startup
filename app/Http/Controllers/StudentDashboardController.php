<?php

namespace App\Http\Controllers;

use App\Models\Publication;
use App\Models\Categoria;
use App\Models\Subcategoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StudentDashboardController extends Controller
{
    public function index(Request $request)
    {
        DB::enableQueryLog();

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

        // Aplicar filtro de distancia
        if ($request->has('user_lat') && $request->has('user_lng') && $request->has('radio_distancia')) {
            $lat = $request->get('user_lat');
            $lng = $request->get('user_lng');
            $radio = $request->get('radio_distancia');

            $query->whereHas('empresa', function($q) use ($lat, $lng, $radio) {
                // Asegurarse de que la empresa tiene coordenadas
                $q->whereNotNull('latitud')
                  ->whereNotNull('longitud')
                  // Fórmula Haversine para calcular distancia en kilómetros
                  ->whereRaw('(
                    6371 * acos(
                        cos(radians(?)) * 
                        cos(radians(latitud)) * 
                        cos(radians(longitud) - radians(?)) + 
                        sin(radians(?)) * 
                        sin(radians(latitud))
                    )
                  ) <= ?', [$lat, $lng, $lat, $radio]);
            });
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

        Log::info('SQL Queries:', DB::getQueryLog());

        // Verificar si es una solicitud AJAX
        if ($request->ajax()) {
            return view('student.dashboard', [
                'publications' => $publications,
                'horarios' => $horarios,
                'categorias' => $categorias,
                'horasTotalesMin' => $horasTotalesMin,
                'horasTotalesMax' => $horasTotalesMax
            ])->render();
        }

        return view('student.dashboard', [
            'publications' => $publications,
            'horarios' => $horarios,
            'categorias' => $categorias,
            'horasTotalesMin' => $horasTotalesMin,
            'horasTotalesMax' => $horasTotalesMax
        ]);
    }
}
