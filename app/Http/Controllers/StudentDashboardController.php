<?php

namespace App\Http\Controllers;

use App\Models\Publication;
use App\Models\Category;
use Illuminate\Http\Request;

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

        // Obtener valores mínimos y máximos de horas totales
        $horasTotalesMin = Publication::min('horas_totales');
        $horasTotalesMax = Publication::max('horas_totales');

        return view('student.dashboard', [
            'publications' => $publications,
            'horarios' => $horarios,
            'horasTotalesMin' => $horasTotalesMin,
            'horasTotalesMax' => $horasTotalesMax
        ]);
    }
}
