<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categoria;
use App\Models\NivelEducativo;
use Illuminate\Support\Facades\DB;

class CategoriaController extends Controller
{
    /**
     * Obtiene las categorías asociadas a los niveles educativos seleccionados
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCategoriasPorNiveles(Request $request)
    {
        $request->validate([
            'niveles' => 'required|array',
            'niveles.*' => 'exists:niveles_educativos,id',
        ]);

        $nivelesIds = $request->input('niveles');
        
        // Inicializamos el array con todos los niveles solicitados
        $resultado = [];
        
        // Para cada nivel, obtenemos las categorías asociadas
        foreach ($nivelesIds as $nivelId) {
            $categorias = Categoria::select('id', 'nombre_categoria')
                ->where('nivel_educativo_id', $nivelId)
                ->distinct()  // Aseguramos que no haya duplicados
                ->get();
                
            $resultado[$nivelId] = $categorias;
        }
        
        return response()->json($resultado);
    }
} 