<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categoria;
use App\Models\NivelEducativo;
use App\Models\Institucion;
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

    /**
     * Obtiene las categorías asociadas a un nivel educativo específico
     * y opcionalmente filtradas por institución
     *
     * @param int $nivel_id
     * @param int|null $institucion_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCategoriasPorNivel($nivel_id, $institucion_id = null)
    {
        // Verificamos que el nivel educativo exista
        $nivelEducativo = NivelEducativo::find($nivel_id);
        if (!$nivelEducativo) {
            return response()->json(['error' => 'Nivel educativo no encontrado'], 404);
        }

        // Si se proporciona una institución, verificamos que exista
        if ($institucion_id) {
            $institucion = Institucion::find($institucion_id);
            if (!$institucion) {
                return response()->json(['error' => 'Institución no encontrada'], 404);
            }

            // Verificamos que la institución tenga este nivel educativo
            $tieneNivel = DB::table('institucion_nivel_educativo')
                ->where('institucion_id', $institucion_id)
                ->where('nivel_educativo_id', $nivel_id)
                ->exists();

            if (!$tieneNivel) {
                // Si la institución no tiene este nivel educativo, devolvemos todas las categorías del nivel
                $categorias = Categoria::select('id', 'nombre_categoria')
                    ->where('nivel_educativo_id', $nivel_id)
                    ->distinct()
                    ->get();
                
                return response()->json($categorias);
            }

            // Primero intentamos obtener las categorías específicas para esta institución y nivel
            $categoriasInstitucion = DB::table('categorias')
                ->select('categorias.id', 'categorias.nombre_categoria')
                ->join('institucion_categoria', function($join) use ($institucion_id, $nivel_id) {
                    $join->on('categorias.id', '=', 'institucion_categoria.categoria_id')
                        ->where('institucion_categoria.institucion_id', $institucion_id)
                        ->where('institucion_categoria.nivel_educativo_id', $nivel_id);
                })
                ->distinct()
                ->get();
            
            // Si encontramos categorías específicas, las devolvemos
            if ($categoriasInstitucion->count() > 0) {
                return response()->json($categoriasInstitucion);
            }
        }

        // Si no hay institución o no hay categorías específicas, devolvemos todas las del nivel
        $categorias = Categoria::select('id', 'nombre_categoria')
            ->where('nivel_educativo_id', $nivel_id)
            ->distinct()
            ->get();
        
        return response()->json($categorias);
    }
} 