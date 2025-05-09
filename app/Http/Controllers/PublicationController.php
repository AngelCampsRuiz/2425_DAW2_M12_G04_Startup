<?php

namespace App\Http\Controllers;

use App\Models\Publication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Solicitud;

class PublicationController extends Controller
{
    public function show($id)
    {
        $publication = Publication::with(['empresa', 'categoria', 'subcategoria', 'subcategorias'])
            ->withCount('solicitudes')
            ->findOrFail($id);

        // Verificar si el usuario autenticado ya ha enviado una solicitud
        $solicitudExistente = null;
        if (Auth::check()) {
            $solicitudExistente = Solicitud::where('estudiante_id', Auth::id())
                ->where('publicacion_id', $id)
                ->first();
        }

        // Verificar si la publicación está en favoritos para el usuario autenticado
        if (Auth::check()) {
            $favorito = Auth::user()->favoritePublications()->where('publicacion_id', $publication->id)->exists();
            $publication->favorito = $favorito;
        } else {
            $publication->favorito = false;
        }

        return view('publication.show', compact('publication', 'solicitudExistente'));
    }

    public function index(Request $request)
    {
        $query = Publication::with(['empresa', 'categoria', 'subcategorias'])
            ->where('activa', true)
            ->orderBy('fecha_publicacion', 'desc');

        // Aplicar filtros si existen
        if ($request->has('categoria_id') && $request->categoria_id) {
            $query->where('categoria_id', $request->categoria_id);
        }

        if ($request->has('subcategoria_id') && $request->subcategoria_id) {
            $query->whereHas('subcategorias', function($q) use ($request) {
                $q->where('subcategorias.id', $request->subcategoria_id);
            });
        }

        if ($request->has('horario') && $request->horario) {
            $query->where('horario', $request->horario);
        }

        if ($request->has('empresa_id') && $request->empresa_id) {
            $query->where('empresa_id', $request->empresa_id);
        }

        $publications = $query->paginate(10);

        return view('publication.index', compact('publications'));
    }
}