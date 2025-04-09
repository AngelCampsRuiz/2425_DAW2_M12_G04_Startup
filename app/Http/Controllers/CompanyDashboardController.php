<?php

namespace App\Http\Controllers;

use App\Models\Publication;
use App\Models\Application;
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
        $categorias = \App\Models\Categoria::all();
        return view('empresa.create-offer', compact('categorias'));
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
        $publication->save();

        return redirect()->route('empresa.dashboard')
            ->with('success', 'Oferta creada exitosamente');
    }

    public function viewApplications($publicationId)
    {
        $publication = Publication::where('empresa_id', Auth::id())
            ->findOrFail($publicationId);
        
        $applications = $publication->applications()
            ->with('student')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('empresa.applications', compact('publication', 'applications'));
    }

    public function togglePublicationStatus($id)
    {
        $publication = Publication::where('empresa_id', Auth::id())
            ->findOrFail($id);
        
        $publication->activa = !$publication->activa;
        $publication->save();

        return back()->with('success', 
            $publication->activa ? 'Oferta activada exitosamente' : 'Oferta desactivada exitosamente');
    }

    public function updateApplicationStatus($publicationId, $applicationId, Request $request)
    {
        $publication = Publication::where('empresa_id', Auth::id())
            ->findOrFail($publicationId);
        
        $application = $publication->applications()
            ->findOrFail($applicationId);

        if ($request->action === 'accept') {
            $application->estado = 'aceptada';
            $message = 'Solicitud aceptada exitosamente';
        } else {
            $application->estado = 'rechazada';
            $message = 'Solicitud rechazada exitosamente';
        }

        $application->save();

        return back()->with('success', $message);
    }

    public function getSubcategorias($categoriaId)
    {
        \Log::info('Buscando subcategorías para categoría: ' . $categoriaId);
        
        $subcategorias = \App\Models\Subcategoria::where('categoria_id', $categoriaId)
            ->select('id', 'nombre_subcategoria')
            ->get();
            
        \Log::info('Subcategorías encontradas: ' . $subcategorias->count());
        
        return response()->json($subcategorias);
    }
} 