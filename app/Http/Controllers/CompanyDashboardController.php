<?php

namespace App\Http\Controllers;

use App\Models\Publication;
use App\Models\Application;
use App\Models\Categoria;
use App\Models\Subcategoria;
use App\Models\Solicitud;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CompanyDashboardController extends Controller
{
    public function index()
    {
        $company = Auth::user();
        $activePublications = Publication::where('empresa_id', $company->id)
            ->where('activa', true)
            ->withCount('applications')
            ->orderBy('created_at', 'desc')
            ->get();

        $inactivePublications = Publication::where('empresa_id', $company->id)
            ->where('activa', false)
            ->withCount('applications')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('empresa.dashboard', compact('activePublications', 'inactivePublications'));
    }

    public function createOffer()
    {
        $categorias = Categoria::select('id', 'nombre_categoria')
                             ->orderBy('nombre_categoria')
                             ->get()
                             ->unique('id');

        return view('empresa.create-offer', compact('categorias'));
    }

    public function getSubcategorias($categoriaId)
    {
        $subcategorias = Subcategoria::select('id', 'nombre_subcategoria')
                                    ->where('categoria_id', $categoriaId)
                                    ->orderBy('nombre_subcategoria')
                                    ->get()
                                    ->unique('id');
        
        return response()->json($subcategorias->values()->all());
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

        $publication = new Publication($request->all());
        $publication->empresa_id = Auth::id();
        $publication->activa = true;
        $publication->fecha_publicacion = now();
        $publication->save();

        return redirect()->route('empresa.dashboard')
            ->with('success', 'Oferta creada exitosamente');
    }

    public function viewApplications($publicationId)
    {
        $publication = Publication::where('empresa_id', Auth::id())
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

        return back()->with('success', 'Estado de la solicitud actualizado correctamente');
    }
}
