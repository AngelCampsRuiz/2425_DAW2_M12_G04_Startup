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
            ->get();

        $inactivePublications = Publicacion::where('empresa_id', $company->id)
            ->where('activa', false)
            ->withCount('solicitudes')
            ->orderBy('created_at', 'desc')
            ->get();

        $categorias = Categoria::all();

        return view('empresa.dashboard', compact('activePublications', 'inactivePublications', 'categorias'));
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
        try {
            $request->validate([
                'titulo' => 'required|string|max:255',
                'descripcion' => 'required|string',
                'horario' => 'required|in:mañana,tarde',
                'horas_totales' => 'required|integer|min:100|max:1000',
                'categoria_id' => 'required|exists:categorias,id',
                'subcategoria_id' => 'required|exists:subcategorias,id'
            ]);

            $publication = new Publicacion($request->all());
            $publication->empresa_id = Auth::id();
            $publication->activa = true;
            $publication->fecha_publicacion = now();
            $publication->save();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Oferta creada exitosamente'
                ]);
            }

            return redirect()->route('empresa.dashboard')
                ->with('success', 'Oferta creada exitosamente');

        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'error' => true,
                    'message' => 'Error al crear la oferta: ' . $e->getMessage()
                ], 422);
            }

            return redirect()->back()
                ->withErrors(['error' => 'Error al crear la oferta'])
                ->withInput();
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
                    'message' => "Oferta {$status} exitosamente"
                ]);
            }

            return redirect()->back()
                ->with('success', "Oferta {$status} exitosamente");

        } catch (\Exception $e) {
            if (request()->ajax()) {
                return response()->json([
                    'error' => true,
                    'message' => 'Error al cambiar el estado de la oferta'
                ], 500);
            }

            return redirect()->back()
                ->withErrors(['error' => 'Error al cambiar el estado de la oferta']);
        }
    }
}

