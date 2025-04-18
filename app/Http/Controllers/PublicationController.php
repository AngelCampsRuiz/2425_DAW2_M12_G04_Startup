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
        $publication = Publication::with(['empresa', 'categoria', 'subcategoria'])
            ->withCount('solicitudes')
            ->findOrFail($id);
        
        // Verificar si el usuario autenticado ya ha enviado una solicitud
        $solicitudExistente = null;
        if (Auth::check()) {
            $solicitudExistente = Solicitud::where('estudiante_id', Auth::id())
                ->where('publicacion_id', $id)
                ->first();
        }
        
        return view('publication.show', compact('publication', 'solicitudExistente'));
    }
} 