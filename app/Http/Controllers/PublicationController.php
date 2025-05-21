<?php

namespace App\Http\Controllers;

use App\Models\Publication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Solicitud;
use App\Http\Controllers\BaseController;

class PublicationController extends BaseController
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Valida y guarda la publicación como lo hacía antes
        $publicacion = Publication::create($request->all());
        
        // Registra la actividad
        $this->logCreation($publicacion, 'Se ha creado una nueva oferta: ' . $publicacion->titulo);
        
        return redirect()->route('admin.publicaciones.index')
            ->with('success', 'Oferta creada correctamente');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $publicacion = Publication::findOrFail($id);
        $publicacion->update($request->all());
        
        // Registra la actividad
        $this->logUpdate($publicacion, 'Se ha actualizado la oferta: ' . $publicacion->titulo);
        
        return redirect()->route('admin.publicaciones.index')
            ->with('success', 'Oferta actualizada correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $publicacion = Publication::findOrFail($id);
        $titulo = $publicacion->titulo; // Guardamos el título antes de eliminar
        $publicacion->delete();
        
        // Registra la actividad
        $this->logDeletion($publicacion, 'Se ha eliminado la oferta: ' . $titulo);
        
        return redirect()->route('admin.publicaciones.index')
            ->with('success', 'Oferta eliminada correctamente');
    }
}