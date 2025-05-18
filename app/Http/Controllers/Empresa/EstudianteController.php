<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Estudiante;
use Illuminate\Support\Facades\Log;

class EstudianteController extends Controller
{
    /**
     * Show a student's profile
     */
    public function show($id)
    {
        // Find the student by ID
        $estudiante = Estudiante::with('user')->findOrFail($id);
        
        // Return the view with student data
        return view('empresa.estudiante.show', [
            'estudiante' => $estudiante
        ]);
    }
    
    /**
     * Search for students based on criteria
     */
    public function search(Request $request)
    {
        try {
            // Get search parameters
            $search = $request->input('search');
            $niveles = $request->input('niveles', []);
            $categorias = $request->input('categorias', []);
            $disponibilidad = $request->input('disponibilidad', []);
            $ubicacion = $request->input('ubicacion');
            $page = $request->input('page', 1);
            $perPage = 5; // Cantidad de estudiantes por página
            
            // Agregar log para depuración
            Log::info('Búsqueda de estudiantes solicitada', [
                'search' => $search,
                'niveles' => $niveles,
                'categorias' => $categorias,
                'disponibilidad' => $disponibilidad,
                'ubicacion' => $ubicacion,
                'page' => $page
            ]);
            
            // Verificar si hay estudiantes en la base de datos
            $countEstudiantes = Estudiante::count();
            $countUsers = User::count();
            
            Log::info('Conteo de registros', [
                'estudiantes_total' => $countEstudiantes,
                'users_total' => $countUsers
            ]);
            
            // Si no hay estudiantes, devolver datos de ejemplo para depuración
            if ($countEstudiantes == 0) {
                Log::warning('No hay estudiantes en la base de datos. Devolviendo datos de ejemplo.');
                
                // Datos de ejemplo para mostrar mientras se soluciona el problema
                $estudiantes_ejemplo = [
                    [
                        'id' => 1,
                        'nombre' => 'Ana Martínez (Ejemplo)',
                        'titulo' => 'Estudiante de Grado Superior en Desarrollo de Aplicaciones Web',
                        'ubicacion' => 'Barcelona',
                        'habilidades' => ['HTML', 'CSS', 'JavaScript', 'PHP'],
                        'imagen' => null
                    ],
                    [
                        'id' => 2,
                        'nombre' => 'Carlos Rodríguez (Ejemplo)',
                        'titulo' => 'Estudiante de Ingeniería Informática',
                        'ubicacion' => 'Madrid',
                        'habilidades' => ['Java', 'Python', 'SQL', 'Análisis de datos'],
                        'imagen' => null
                    ],
                    [
                        'id' => 3,
                        'nombre' => 'Laura Gómez (Ejemplo)',
                        'titulo' => 'Estudiante de Grado Medio en Sistemas Microinformáticos y Redes',
                        'ubicacion' => 'Valencia',
                        'habilidades' => ['Redes', 'Hardware', 'Soporte técnico'],
                        'imagen' => null
                    ]
                ];
                
                return response()->json([
                    'mensaje_debug' => 'Mostrando datos de ejemplo porque no hay estudiantes en la base de datos',
                    'estudiantes' => $estudiantes_ejemplo,
                    'total' => count($estudiantes_ejemplo),
                    'per_page' => count($estudiantes_ejemplo),
                    'current_page' => 1,
                    'last_page' => 1,
                    'from' => 1,
                    'to' => count($estudiantes_ejemplo)
                ]);
            }
            
            // Consulta básica de estudiantes con user
            $query = Estudiante::with('user');
            
            // Aplicar filtros solo si no estamos en modo depuración
            $debugMode = false; // Cambiado a false para aplicar filtros
            
            if (!$debugMode) {
                // Filtros - ahora habilitados
                if (!empty($search)) {
                    $query->whereHas('user', function($q) use ($search) {
                        $q->where('nombre', 'LIKE', "%{$search}%");
                    });
                }
                
                if (!empty($niveles)) {
                    $query->whereIn('nivel_educativo_id', $niveles);
                }
                
                if (!empty($categorias)) {
                    $query->whereHas('categorias', function($q) use ($categorias) {
                        $q->whereIn('categoria_id', $categorias);
                    });
                }
                
                if (!empty($disponibilidad)) {
                    $query->where(function($q) use ($disponibilidad) {
                        foreach($disponibilidad as $horario) {
                            $q->orWhere('horario_preferido', 'LIKE', "%{$horario}%");
                        }
                    });
                }
                
                if (!empty($ubicacion)) {
                    $query->whereHas('user', function($q) use ($ubicacion) {
                        $q->where('ciudad', $ubicacion);
                    });
                }
            }
            
            // Realizar la paginación
            $estudiantes = $query->paginate($perPage, ['*'], 'page', $page);
            
            // Registrar información básica de los estudiantes obtenidos
            $estudiantesInfo = [];
            foreach ($estudiantes as $est) {
                $estudiantesInfo[] = [
                    'id' => $est->id,
                    'has_user' => $est->user ? true : false,
                    'user_name' => $est->user ? $est->user->nombre : 'N/A'
                ];
            }
            
            Log::info('Estudiantes recuperados:', [
                'estudiantes_info' => $estudiantesInfo,
                'count' => count($estudiantesInfo)
            ]);
            
            // Transformar los datos para el formato esperado por el frontend
            $transformed = [];
            
            foreach ($estudiantes as $estudiante) {
                // Cada estudiante debe tener un usuario asociado por el diseño de la base de datos
                $habilidades = [];
                
                // Usar intereses como habilidades (si existe)
                if (!empty($estudiante->intereses)) {
                    $habilidades = explode(',', $estudiante->intereses);
                }
                
                // Usar conocimientos previos si no hay intereses
                if (empty($habilidades) && !empty($estudiante->conocimientos_previos)) {
                    $habilidades = explode(',', $estudiante->conocimientos_previos);
                }
                
                // Si sigue vacío, poner algunos valores por defecto
                if (empty($habilidades)) {
                    $habilidades = ['Estudiante'];
                }
                
                // Si por alguna razón no hay usuario, usamos valores por defecto
                $nombre = $estudiante->user ? $estudiante->user->nombre : 'Estudiante ID ' . $estudiante->id;
                $ciudad = $estudiante->user ? $estudiante->user->ciudad : '';
                $imagen = $estudiante->user ? $estudiante->user->imagen : null;
                
                // Normalizamos el nombre para construir el nombre de archivo de imagen si no existe
                if (!$imagen && $estudiante->user) {
                    // Convertir nombre a minúsculas y reemplazar espacios por guiones bajos
                    $nombreNormalizado = strtolower($nombre);
                    $nombreNormalizado = str_replace(' ', '_', $nombreNormalizado);
                    
                    // Buscar si existe un archivo con ese nombre en la carpeta de imágenes
                    $posibleImagen = $nombreNormalizado . '.jpg';
                    
                    // Verificar si existe en el sistema de archivos (solo para depuración)
                    $rutaImagen = public_path('profile_images/' . $posibleImagen);
                    
                    if (file_exists($rutaImagen)) {
                        $imagen = $posibleImagen;
                    }
                }
                
                $transformed[] = [
                    'id' => $estudiante->id,
                    'nombre' => $nombre,
                    'titulo' => $estudiante->titulo ? $estudiante->titulo->nombre_titulo : 'Estudiante',
                    'ubicacion' => $ciudad,
                    'habilidades' => $habilidades,
                    'imagen' => $imagen
                ];
            }
            
            // Si después de filtrar no quedaron estudiantes, mostrar mensaje de depuración
            if (count($transformed) == 0) {
                Log::warning('No hay estudiantes con usuario asociado. Devolviendo datos de ejemplo.');
                
                // Datos de ejemplo como plan B
                $transformed = [
                    [
                        'id' => 999,
                        'nombre' => 'DEPURACIÓN: No hay estudiantes disponibles',
                        'titulo' => 'Intenta desactivar los filtros',
                        'ubicacion' => 'Sistema',
                        'habilidades' => ['Depuración', 'Datos de ejemplo'],
                        'imagen' => null
                    ]
                ];
            }
            
            // Registrar la respuesta en el log
            Log::info('Enviando respuesta de búsqueda de estudiantes', [
                'total_estudiantes' => $estudiantes->total(),
                'total_paginas' => $estudiantes->lastPage(),
                'pagina_actual' => $estudiantes->currentPage(),
                'estudiantes_transformados' => count($transformed)
            ]);
            
            return response()->json([
                'estudiantes' => $transformed,
                'total' => count($transformed), // Usar el conteo real de estudiantes transformados
                'per_page' => $estudiantes->perPage(),
                'current_page' => $estudiantes->currentPage(),
                'last_page' => ceil(count($transformed) / $estudiantes->perPage()),
                'from' => $estudiantes->firstItem() ?? 0,
                'to' => $estudiantes->lastItem() ?? 0
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error al buscar estudiantes: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString()
            ]);
            
            // Devolver datos de ejemplo en caso de error para evitar errores en el frontend
            $estudiantes_ejemplo = [
                [
                    'id' => 1,
                    'nombre' => 'ERROR: ' . $e->getMessage(),
                    'titulo' => 'Estudiante de ejemplo (error en la búsqueda)',
                    'ubicacion' => 'Error',
                    'habilidades' => ['Error', 'Datos de ejemplo'],
                    'imagen' => null
                ]
            ];
            
            // Devolver un error 200 con mensaje en lugar de 500 para poder depurar
            return response()->json([
                'error' => true,
                'message' => 'Error al buscar estudiantes: ' . $e->getMessage(),
                'estudiantes' => $estudiantes_ejemplo,
                'total' => count($estudiantes_ejemplo),
                'per_page' => 5,
                'current_page' => 1,
                'last_page' => 1,
                'from' => 1,
                'to' => count($estudiantes_ejemplo)
            ], 200);
        }
    }
} 