<?php

namespace App\Http\Controllers;

use App\Models\Publication;
use App\Models\Application;
use App\Models\Categoria;
use App\Models\Subcategoria;
use App\Models\Publicacion;
use App\Models\Solicitud;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use App\Notifications\SolicitudEstadoNotification;
use App\Events\NotificacionPusher;
class CompanyDashboardController extends Controller
{
    /**
     * Show the company dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $company = Auth::user();
        $activePublications = Publicacion::where('empresa_id', $company->id)
            ->where('activa', true)
            ->withCount('solicitudes')
            ->orderBy('created_at', 'desc')
            ->paginate(4);

        $inactivePublications = Publicacion::where('empresa_id', $company->id)
            ->where('activa', false)
            ->withCount('solicitudes')
            ->orderBy('created_at', 'desc')
            ->paginate(4);

        $categorias = Categoria::all();

        // Cargar los niveles educativos para el filtro de búsqueda de candidatos
        $nivelesEducativos = \App\Models\NivelEducativo::all();

        return view('empresa.dashboard', compact('activePublications', 'inactivePublications', 'categorias', 'nivelesEducativos'));
    }

    public function createOffer()
    {
        $categorias = Categoria::all();
        return view('empresa.create-offer', compact('categorias'));
    }

    public function getSubcategorias($categoria)
    {
        try {
            // Validar que la categoría existe
            $subcategorias = Subcategoria::where('categoria_id', $categoria)->get();

            if ($subcategorias->isEmpty()) {
                return response()->json([
                    'error' => true,
                    'message' => 'No se encontraron subcategorías para esta categoría'
                ], 404);
            }

            return response()->json([
                'error' => false,
                'data' => $subcategorias
            ]);

        } catch (\Exception $e) {
            Log::error('Error en getSubcategorias: ' . $e->getMessage());
            return response()->json([
                'error' => true,
                'message' => 'Error al cargar las subcategorías'
            ], 500);
        }
    }

    public function storeOffer(Request $request)
    {
        // SISTEMA DE PREVENCIÓN DE DUPLICADOS ABSOLUTO
        Log::info('⚠️ INICIO PROCESO CREACIÓN OFERTA', [
            'ip' => $request->ip(),
            'user_id' => Auth::id(),
            'tiempo' => now()->format('Y-m-d H:i:s.u')
        ]);

        // 1. BLOQUEO ABSOLUTO POR CLAVE - Adquirir un bloqueo distribuido exclusivo por usuario
        $lockKey = 'LOCK_CREAR_OFERTA_' . Auth::id();

        try {
            return DB::transaction(function() use ($request, $lockKey) {
                // Obtenemos un bloqueo con un timeout corto (3 segundos de espera máximo)
                return Cache::lock($lockKey, 30)->block(3, function() use ($request) {
                    // 2. DENTRO DEL BLOQUEO Y LA TRANSACCIÓN

                    try {
                        // Validamos datos
                        $validated = $request->validate([
                            'titulo' => 'required|string|max:255',
                            'descripcion' => 'required|string',
                            'horario' => 'required|in:mañana,tarde',
                            'horas_totales' => 'required|integer|min:100|max:1000',
                            'categoria_id' => 'required|exists:categorias,id',
                            'subcategoria_id' => 'required|exists:subcategorias,id'
                        ]);

                        // 3. VALIDACIÓN EN BASE DE DATOS - Verificación de duplicados extrema
                        $duplicado = Publicacion::where('empresa_id', Auth::id())
                            ->where(function($query) use ($validated) {
                                $query->where('titulo', $validated['titulo'])
                                    ->orWhere('descripcion', $validated['descripcion']);
                            })
                            ->where('created_at', '>=', now()->subHours(24))
                            ->first();

                        if ($duplicado) {
                            Log::warning('⛔ DUPLICADO DETECTADO EN COMPROBACIÓN FINAL', [
                                'titulo_duplicado' => $duplicado->titulo,
                                'id_duplicado' => $duplicado->id,
                                'created_at' => $duplicado->created_at
                            ]);

                            $mensaje = 'DUPLICADO DETECTADO: Ya has creado una oferta similar en las últimas 24 horas.';

                            if ($request->ajax()) {
                                return response()->json([
                                    'success' => false,
                                    'duplicate' => true,
                                    'message' => $mensaje
                                ], 409); // 409 Conflict
                            }

                            return redirect()->route('empresa.dashboard')
                                ->with('error', $mensaje);
                        }

                        // 4. SI LLEGAMOS AQUÍ, PODEMOS CREAR LA OFERTA (SIN DUPLICADOS)
                        $publication = new Publicacion($validated);
                        $publication->empresa_id = Auth::id();
                        $publication->activa = true;
                        $publication->fecha_publicacion = now();
                        $publication->save(); // Esto lanzará excepción si hay duplicado (ver boot() en modelo)

                        Log::info('✅ OFERTA CREADA EXITOSAMENTE', [
                            'id' => $publication->id,
                            'titulo' => $publication->titulo
                        ]);

                        if ($request->ajax()) {
                            return response()->json([
                                'success' => true,
                                'message' => 'Oferta creada exitosamente',
                                'publication' => [
                                    'id' => $publication->id,
                                    'titulo' => $publication->titulo
                                ]
                            ]);
                        }

                        return redirect()->route('empresa.dashboard')
                            ->with('success', 'Oferta creada exitosamente');
                    } catch (\Illuminate\Validation\ValidationException $e) {
                        Log::error('Error de validación', ['errors' => $e->errors()]);
                        throw $e; // Re-lanzar para mantener el formato de errores de validación
                    } catch (\Exception $e) {
                        Log::error('Error en transacción', [
                            'error' => $e->getMessage(),
                            'trace' => $e->getTraceAsString()
                        ]);
                        throw $e;
                    }
                });
            }, 3); // Nivel de aislamiento SERIALIZABLE
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Manejar errores de validación
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error de validación',
                    'errors' => $e->errors()
                ], 422);
            }

            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Illuminate\Contracts\Cache\LockTimeoutException $e) {
            Log::warning('🔒 No se pudo obtener el bloqueo', [
                'user_id' => Auth::id(),
                'tiempo' => now()->format('Y-m-d H:i:s.u')
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Hay otra operación en curso. Espera un momento e inténtalo de nuevo.'
                ], 423); // 423 Locked
            }

            return redirect()->back()
                ->withErrors(['error' => 'Hay otra operación en curso. Espera un momento e inténtalo de nuevo.'])
                ->withInput();
        } catch (\Exception $e) {
            // Si contiene 'DUPLICADO' es un error de duplicado del modelo
            if (strpos($e->getMessage(), 'DUPLICADO') !== false) {
                Log::warning('⛔ DUPLICADO DETECTADO EN MODELO', [
                    'mensaje' => $e->getMessage()
                ]);

                if ($request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'duplicate' => true,
                        'message' => $e->getMessage()
                    ], 409); // 409 Conflict
                }

                return redirect()->route('empresa.dashboard')
                    ->with('error', $e->getMessage());
            }

            // Error general
            Log::error('Error general', [
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al crear la oferta: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()
                ->withErrors(['error' => 'Error al crear la oferta: ' . $e->getMessage()])
                ->withInput();
        } finally {
            // Asegurarnos de liberar el bloqueo en caso de que aún esté activo por algún error
            try {
                if (Cache::has($lockKey)) {
                    Cache::forget($lockKey);
                    Log::info('🔓 Bloqueo liberado manualmente', [
                        'lockKey' => $lockKey
                    ]);
                }
            } catch (\Exception $e) {
                Log::error('Error al liberar bloqueo', [
                    'message' => $e->getMessage()
                ]);
            }
        }
    }

    public function viewApplications($publicationId)
    {
        $publication = Publicacion::where('empresa_id', Auth::id())
            ->findOrFail($publicationId);

        $solicitudes = Solicitud::where('publicacion_id', $publicationId)
            ->with(['estudiante.user', 'estudiante.titulo', 'chat'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('empresa.applications', compact('publication', 'solicitudes'));
    }

    public function updateApplicationStatus(Request $request, $publicationId, $solicitudId)
    {
        $solicitud = Solicitud::whereHas('publicacion', function ($query) {
            $query->where('empresa_id', Auth::id());
        })->findOrFail($solicitudId);

        $request->validate([
            'estado' => 'required|in:aceptada,rechazada',
            'respuesta_empresa' => 'nullable|string|max:500'
        ]);

        $solicitud->update([
            'estado' => $request->estado,
            'respuesta_empresa' => $request->respuesta_empresa
        ]);

        // Notificar al estudiante
        $estudiante = $solicitud->estudiante->user;
        $estudiante->notify(new SolicitudEstadoNotification($request->estado, $solicitud->publicacion->empresa, $solicitud->publicacion));
        event(new NotificacionPusher($estudiante->id));

        // Si la solicitud fue aceptada
        if ($request->estado === 'aceptada') {
            // Marcar la publicación como inactiva
            $solicitud->publicacion->update([
                'activa' => false
            ]);

            // Rechazar automáticamente todas las otras solicitudes
            Solicitud::where('publicacion_id', $solicitud->publicacion_id)
                ->where('id', '!=', $solicitud->id)
                ->update([
                    'estado' => 'rechazada',
                    'respuesta_empresa' => 'Solicitud rechazada automáticamente porque otro candidato fue aceptado.'
                ]);

            // Crear un chat entre la empresa y el estudiante
            $chat = \App\Models\Chat::create([
                'empresa_id' => Auth::id(),
                'solicitud_id' => $solicitud->id
            ]);

            // Redirigir al chat
            return redirect()->route('chat.show', $chat->id)
                ->with('success', 'Solicitud aceptada y chat creado correctamente');
        }

        return back()->with('success', 'Estado de la solicitud actualizado correctamente');
    }

    public function togglePublicationStatus($publicationId)
    {
        try {
            $publication = Publicacion::where('empresa_id', Auth::id())
                ->findOrFail($publicationId);

            $publication->activa = !$publication->activa;
            $publication->save();

            $status = $publication->activa ? 'activada' : 'desactivada';

            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => "Oferta {$status} exitosamente",
                    'publication' => [
                        'id' => $publication->id,
                        'activa' => $publication->activa
                    ]
                ]);
            }

            return redirect()->back()
                ->with('success', "Oferta {$status} exitosamente");

        } catch (\Exception $e) {
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al cambiar el estado de la oferta: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()
                ->withErrors(['error' => 'Error al cambiar el estado de la oferta']);
        }
    }

    /**
     * Show all active offers for the company.
     *
     * @return \Illuminate\Contracts\Support\Renderable|\Illuminate\Http\JsonResponse
     */
    public function activeOffers(Request $request)
    {
        $company = Auth::user();
        $query = Publicacion::where('empresa_id', $company->id)
            ->where('activa', true)
            ->withCount('solicitudes');

        // Apply filters if present
        if ($request->has('titulo') && !empty($request->titulo)) {
            $query->where('titulo', 'like', '%' . $request->titulo . '%');
        }

        if ($request->has('horario') && !empty($request->horario)) {
            $query->where('horario', $request->horario);
        }

        if ($request->has('categoria_id') && !empty($request->categoria_id)) {
            $query->where('categoria_id', $request->categoria_id);
        }

        // Apply sorting
        $sortField = $request->input('sort_field', 'created_at');
        $sortDirection = $request->input('sort_direction', 'desc');

        // Validate sort field to prevent SQL injection
        $allowedSortFields = [
            'titulo', 'horario', 'created_at', 'horas_totales', 'solicitudes_count'
        ];

        if (in_array($sortField, $allowedSortFields)) {
            $query->orderBy($sortField, $sortDirection);
        } else {
            $query->orderBy('created_at', 'desc');
        }

        // Paginate results - use per_page from request or default to 4 items
        $perPage = $request->input('per_page', 4);
        $activePublications = $query->paginate($perPage);

        // Return JSON for Ajax requests
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'data' => $activePublications->items(),
                'pagination' => [
                    'total' => $activePublications->total(),
                    'per_page' => $activePublications->perPage(),
                    'current_page' => $activePublications->currentPage(),
                    'last_page' => $activePublications->lastPage(),
                    'from' => $activePublications->firstItem(),
                    'to' => $activePublications->lastItem()
                ]
            ]);
        }

        // For regular page load
        $categorias = Categoria::all();

        return view('empresa.active-offers', compact('activePublications', 'categorias'));
    }

    /**
     * Show all inactive offers for the company.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function inactiveOffers(Request $request)
    {
        $company = Auth::user();
        $query = Publicacion::where('empresa_id', $company->id)
            ->where('activa', false)
            ->withCount('solicitudes');

        // Apply filters if present
        if ($request->has('titulo') && !empty($request->titulo)) {
            $query->where('titulo', 'like', '%' . $request->titulo . '%');
        }

        if ($request->has('horario') && !empty($request->horario)) {
            $query->where('horario', $request->horario);
        }

        if ($request->has('categoria_id') && !empty($request->categoria_id)) {
            $query->where('categoria_id', $request->categoria_id);
        }

        // Apply sorting
        $sortField = $request->input('sort_field', 'created_at');
        $sortDirection = $request->input('sort_direction', 'desc');

        // Validate sort field to prevent SQL injection
        $allowedSortFields = [
            'titulo', 'horario', 'created_at', 'horas_totales', 'solicitudes_count'
        ];

        if (in_array($sortField, $allowedSortFields)) {
            $query->orderBy($sortField, $sortDirection);
        } else {
            $query->orderBy('created_at', 'desc');
        }

        // Paginate with 4 items per page
        $perPage = $request->input('per_page', 4);
        $inactivePublications = $query->paginate($perPage);

        // Return JSON for Ajax requests
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'data' => $inactivePublications->items(),
                'pagination' => [
                    'total' => $inactivePublications->total(),
                    'per_page' => $inactivePublications->perPage(),
                    'current_page' => $inactivePublications->currentPage(),
                    'last_page' => $inactivePublications->lastPage(),
                    'from' => $inactivePublications->firstItem(),
                    'to' => $inactivePublications->lastItem()
                ]
            ]);
        }

        $categorias = Categoria::all();

        return view('empresa.inactive-offers', compact('inactivePublications', 'categorias'));
    }

    public function getDashboardStats()
    {
        $company = Auth::user();

        // Obtener las solicitudes aceptadas y rechazadas
        $solicitudesAceptadas = Solicitud::whereHas('publicacion', function($query) use ($company) {
            $query->where('empresa_id', $company->id);
        })->where('estado', 'aceptada')->count();

        $solicitudesRechazadas = Solicitud::whereHas('publicacion', function($query) use ($company) {
            $query->where('empresa_id', $company->id);
        })->where('estado', 'rechazada')->count();

        $stats = [
            'activePublications' => Publicacion::where('empresa_id', $company->id)
                ->where('activa', true)
                ->count(),
            'inactivePublications' => Publicacion::where('empresa_id', $company->id)
                ->where('activa', false)
                ->count(),
            'activeSolicitudes' => $solicitudesAceptadas,
            'inactiveSolicitudes' => $solicitudesRechazadas
        ];

        return response()->json($stats);
    }
}

