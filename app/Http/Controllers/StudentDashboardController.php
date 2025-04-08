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

        // Aplicar filtros de búsqueda
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('titulo', 'like', "%{$search}%")
                  ->orWhere('descripcion', 'like', "%{$search}%")
                  ->orWhereHas('empresa', function($q) use ($search) {
                      $q->where('nombre', 'like', "%{$search}%");
                  });
            });
        }

        // Aplicar filtros
        if ($request->has('horario')) {
            $query->where('horario', $request->horario);
        }

        if ($request->has('horas_totales')) {
            $query->where('horas_totales', '>=', $request->horas_totales);
        }

        if ($request->has('categoria_id')) {
            $query->where('categoria_id', $request->categoria_id);
        }

        if ($request->has('subcategoria_id')) {
            $query->where('subcategoria_id', $request->subcategoria_id);
        }

        // Aplicar ordenamiento
        $orderBy = $request->get('order_by', 'fecha_publicacion');
        $orderDirection = $request->get('order_direction', 'desc');
        $query->orderBy($orderBy, $orderDirection);

        // Obtener resultados paginados
        $publications = $query->paginate(6);

        // Obtener categorías para los filtros
        $categories = Category::all();

        return view('student.dashboard', [
            'publications' => $publications,
            'categories' => $categories,
            'filters' => [
                'horarios' => ['mañana', 'tarde'],
                'horas_totales' => [100, 200, 300, 400],
            ]
        ]);
    }
}
