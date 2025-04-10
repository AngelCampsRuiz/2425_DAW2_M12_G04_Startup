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

        return view('empresa.dashboard', compact('activePublications', 'inactivePublications'));
    }

    public function createOffer()
    {
        $categorias = Categoria::all();
        return view('empresa.create-offer', compact('categorias'));
    }

    public function getSubcategorias($categoriaId)
    {
        $subcategorias = Subcategoria::where('categoria_id', $categoriaId)->get();
        return response()->json($subcategorias);
    }

    public function storeOffer(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'horario' => 'required|in:mañana,tarde',
            'horas_totales' => 'required|integer|min:100|max:400',
            'categoria_id' => 'required|exists:categorias,id',
            'subcategoria_id' => 'required|exists:subcategorias,id'
        ]);

        $publication = new Publicacion($request->all());
        $publication->empresa_id = Auth::id();
        $publication->activa = true;
        $publication->fecha_publicacion = now();
        $publication->save();

        return redirect()->route('empresa.dashboard')
            ->with('success', 'Oferta creada exitosamente');
    }

    public function viewApplications($publicationId)
    {
        $publication = Publicacion::where('empresa_id', Auth::id())
            ->findOrFail($publicationId);
        
        $solicitudes = Solicitud::where('publicacion_id', $publicationId)
            ->with('estudiante.user')
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
        }

        return back()->with('success', 'Estado de la solicitud actualizado correctamente');
    }
}

