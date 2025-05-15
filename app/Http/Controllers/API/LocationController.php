<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Institucion;
use App\Models\NivelEducativo;
use Illuminate\Support\Facades\DB;

class LocationController extends Controller
{
    /**
     * Obtener la lista de provincias españolas.
     */
    public function getProvincias()
    {
        // Provincias de España
        $provincias = [
            ['id' => 'Álava', 'nombre' => 'Álava'],
            ['id' => 'Albacete', 'nombre' => 'Albacete'],
            ['id' => 'Alicante', 'nombre' => 'Alicante'],
            ['id' => 'Almería', 'nombre' => 'Almería'],
            ['id' => 'Asturias', 'nombre' => 'Asturias'],
            ['id' => 'Ávila', 'nombre' => 'Ávila'],
            ['id' => 'Badajoz', 'nombre' => 'Badajoz'],
            ['id' => 'Barcelona', 'nombre' => 'Barcelona'],
            ['id' => 'Burgos', 'nombre' => 'Burgos'],
            ['id' => 'Cáceres', 'nombre' => 'Cáceres'],
            ['id' => 'Cádiz', 'nombre' => 'Cádiz'],
            ['id' => 'Cantabria', 'nombre' => 'Cantabria'],
            ['id' => 'Castellón', 'nombre' => 'Castellón'],
            ['id' => 'Ciudad Real', 'nombre' => 'Ciudad Real'],
            ['id' => 'Córdoba', 'nombre' => 'Córdoba'],
            ['id' => 'Cuenca', 'nombre' => 'Cuenca'],
            ['id' => 'Girona', 'nombre' => 'Girona'],
            ['id' => 'Granada', 'nombre' => 'Granada'],
            ['id' => 'Guadalajara', 'nombre' => 'Guadalajara'],
            ['id' => 'Guipúzcoa', 'nombre' => 'Guipúzcoa'],
            ['id' => 'Huelva', 'nombre' => 'Huelva'],
            ['id' => 'Huesca', 'nombre' => 'Huesca'],
            ['id' => 'Islas Baleares', 'nombre' => 'Islas Baleares'],
            ['id' => 'Jaén', 'nombre' => 'Jaén'],
            ['id' => 'La Coruña', 'nombre' => 'La Coruña'],
            ['id' => 'La Rioja', 'nombre' => 'La Rioja'],
            ['id' => 'Las Palmas', 'nombre' => 'Las Palmas'],
            ['id' => 'León', 'nombre' => 'León'],
            ['id' => 'Lleida', 'nombre' => 'Lleida'],
            ['id' => 'Lugo', 'nombre' => 'Lugo'],
            ['id' => 'Madrid', 'nombre' => 'Madrid'],
            ['id' => 'Málaga', 'nombre' => 'Málaga'],
            ['id' => 'Murcia', 'nombre' => 'Murcia'],
            ['id' => 'Navarra', 'nombre' => 'Navarra'],
            ['id' => 'Orense', 'nombre' => 'Orense'],
            ['id' => 'Palencia', 'nombre' => 'Palencia'],
            ['id' => 'Pontevedra', 'nombre' => 'Pontevedra'],
            ['id' => 'Salamanca', 'nombre' => 'Salamanca'],
            ['id' => 'Santa Cruz de Tenerife', 'nombre' => 'Santa Cruz de Tenerife'],
            ['id' => 'Segovia', 'nombre' => 'Segovia'],
            ['id' => 'Sevilla', 'nombre' => 'Sevilla'],
            ['id' => 'Soria', 'nombre' => 'Soria'],
            ['id' => 'Tarragona', 'nombre' => 'Tarragona'],
            ['id' => 'Teruel', 'nombre' => 'Teruel'],
            ['id' => 'Toledo', 'nombre' => 'Toledo'],
            ['id' => 'Valencia', 'nombre' => 'Valencia'],
            ['id' => 'Valladolid', 'nombre' => 'Valladolid'],
            ['id' => 'Vizcaya', 'nombre' => 'Vizcaya'],
            ['id' => 'Zamora', 'nombre' => 'Zamora'],
            ['id' => 'Zaragoza', 'nombre' => 'Zaragoza'],
            ['id' => 'Ceuta', 'nombre' => 'Ceuta'],
            ['id' => 'Melilla', 'nombre' => 'Melilla']
        ];

        return response()->json($provincias);
    }

    /**
     * Obtener las ciudades de una provincia.
     */
    public function getCiudades(Request $request)
    {
        $provincia = $request->query('provincia');
        
        \Log::info('Buscando ciudades para provincia: ' . $provincia);
        
        if (!$provincia) {
            \Log::warning('No se proporcionó provincia');
            return response()->json([]);
        }

        // Simulación de ciudades por provincia
        $ciudadesPorProvincia = [
            'Barcelona' => [
                ['id' => 1, 'nombre' => 'Barcelona'],
                ['id' => 2, 'nombre' => 'Sabadell'],
                ['id' => 3, 'nombre' => 'Terrassa'],
                ['id' => 4, 'nombre' => 'Badalona'],
                ['id' => 5, 'nombre' => 'Mataró']
            ],
            'Madrid' => [
                ['id' => 6, 'nombre' => 'Madrid'],
                ['id' => 7, 'nombre' => 'Alcalá de Henares'],
                ['id' => 8, 'nombre' => 'Móstoles'],
                ['id' => 9, 'nombre' => 'Leganés'],
                ['id' => 10, 'nombre' => 'Getafe']
            ],
            'Valencia' => [
                ['id' => 11, 'nombre' => 'Valencia'],
                ['id' => 12, 'nombre' => 'Torrent'],
                ['id' => 13, 'nombre' => 'Paterna'],
                ['id' => 14, 'nombre' => 'Sagunt'],
                ['id' => 15, 'nombre' => 'Gandía']
            ],
            'Sevilla' => [
                ['id' => 16, 'nombre' => 'Sevilla'],
                ['id' => 17, 'nombre' => 'Dos Hermanas'],
                ['id' => 18, 'nombre' => 'Alcalá de Guadaíra'],
                ['id' => 19, 'nombre' => 'Utrera'],
                ['id' => 20, 'nombre' => 'Écija']
            ],
            // Añadir más ciudades para las demás provincias según sea necesario
            'Álava' => [
                ['id' => 21, 'nombre' => 'Vitoria-Gasteiz'],
                ['id' => 22, 'nombre' => 'Laudio/Llodio'],
                ['id' => 23, 'nombre' => 'Amurrio']
            ],
            'Albacete' => [
                ['id' => 24, 'nombre' => 'Albacete'],
                ['id' => 25, 'nombre' => 'Hellín'],
                ['id' => 26, 'nombre' => 'Villarrobledo']
            ],
            'Alicante' => [
                ['id' => 27, 'nombre' => 'Alicante'],
                ['id' => 28, 'nombre' => 'Elche'],
                ['id' => 29, 'nombre' => 'Torrevieja']
            ]
        ];

        // Si la provincia no tiene ciudades definidas, devolver ciudades genéricas
        if (!isset($ciudadesPorProvincia[$provincia])) {
            \Log::info('Creando ciudades genéricas para: ' . $provincia);
            $ciudades = [
                ['id' => rand(100, 999), 'nombre' => 'Capital de ' . $provincia],
                ['id' => rand(100, 999), 'nombre' => 'Ciudad 2 de ' . $provincia],
                ['id' => rand(100, 999), 'nombre' => 'Ciudad 3 de ' . $provincia]
            ];
            return response()->json($ciudades);
        }

        \Log::info('Devolviendo ' . count($ciudadesPorProvincia[$provincia]) . ' ciudades para: ' . $provincia);
        return response()->json($ciudadesPorProvincia[$provincia]);
    }

    /**
     * Obtener las instituciones en una ciudad específica.
     */
    public function getInstituciones($ciudad = null)
    {
        if (!$ciudad) {
            return response()->json([]);
        }

        // Consultar instituciones en la ciudad especificada
        $instituciones = Institucion::whereHas('user', function($query) use ($ciudad) {
            $query->where('ciudad', $ciudad);
        })->with('user:id,nombre')->get();

        return response()->json($instituciones);
    }

    /**
     * Obtener los niveles educativos de una institución específica.
     */
    public function getNivelesEducativos($institucionId = null)
    {
        if (!$institucionId) {
            return response()->json([]);
        }

        // Consultar niveles educativos de la institución específica
        $niveles = DB::table('institucion_nivel_educativo')
            ->where('institucion_id', $institucionId)
            ->join('niveles_educativos', 'institucion_nivel_educativo.nivel_educativo_id', '=', 'niveles_educativos.id')
            ->select('niveles_educativos.id', 'niveles_educativos.nombre_nivel')
            ->get();

        return response()->json($niveles);
    }
} 