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

        // Aplicar ordenamiento
        $orderBy = $request->get('order_by', 'fecha_publicacion');
        $orderDirection = $request->get('order_direction', 'desc');
        $query->orderBy($orderBy, $orderDirection);

        // Obtener resultados paginados
        $publications = $query->paginate(6);

        return view('student.dashboard', [
            'publications' => $publications
        ]);
    }
}
