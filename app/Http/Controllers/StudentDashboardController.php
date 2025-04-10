<?php

namespace App\Http\Controllers;

use App\Models\Publication;
use App\Models\Category;
use App\Models\Subcategoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentDashboardController extends Controller
{
    public function index(Request $request)
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

        // Obtener categorías con sus subcategorías
        $categorias = Category::with('subcategorias')->get();

        // Obtener valores mínimos y máximos de horas totales
        $horasTotalesMin = Publication::min('horas_totales');
        $horasTotalesMax = Publication::max('horas_totales');

        return view('student.dashboard', [
            'publications' => $publications,
            'horarios' => $horarios,
            'categorias' => $categorias,
            'horasTotalesMin' => $horasTotalesMin,
            'horasTotalesMax' => $horasTotalesMax
        ]);
    }

    public function toggleFavorite(Request $request, $publicationId)
    {
        $user = Auth::user();
        $publication = Publication::findOrFail($publicationId);

        if ($user->favorites()->where('publicacion_id', $publicationId)->exists()) {
            $user->favorites()->detach($publicationId);
            return response()->json(['status' => 'removed']);
        } else {
            $user->favorites()->attach($publicationId);
            return response()->json(['status' => 'added']);
        }
    }
}
