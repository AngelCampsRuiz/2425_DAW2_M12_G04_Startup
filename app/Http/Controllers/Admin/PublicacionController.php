<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Publication;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Empresa;
use Illuminate\Http\Request;

class PublicacionController extends Controller
{
    /**
     * Muestra el listado de publicaciones
     */
    public function index()
    {
        $publicaciones = Publication::with(['empresa', 'categoria', 'subcategoria'])->get();
        return view('admin.publicaciones.index', compact('publicaciones'));
    }

    /**
     * Muestra el formulario para crear una publicación
     */
    public function create()
    {
        $categorias = Category::all();
        $subcategorias = Subcategory::all();
        $empresas = Empresa::all();
        return view('admin.publicaciones.create', compact('categorias', 'subcategorias', 'empresas'));
    }

    /**
     * Almacena una nueva publicación
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'titulo' => 'required|max:100',
            'descripcion' => 'required',
            'horario' => 'required|in:mañana,tarde',
            'horas_totales' => 'required|integer|min:1',
            'fecha_publicacion' => 'required|date',
            'activa' => 'boolean',
            'empresa_id' => 'required|exists:empresas,id',
            'categoria_id' => 'required|exists:categorias,id',
            'subcategoria_id' => 'required|exists:subcategorias,id',
        ]);

        Publication::create($validated);

        return redirect()->route('admin.publicaciones.index')
            ->with('success', 'Publicación creada correctamente');
    }

    /**
     * Muestra los detalles de una publicación
     */
    public function show(Publication $publicacion)
    {
        return view('admin.publicaciones.show', compact('publicacion'));
    }

    /**
     * Muestra el formulario para editar una publicación
     */
    public function edit(Publication $publicacion)
    {
        $categorias = Category::all();
        $subcategorias = Subcategory::all();
        $empresas = Empresa::all();
        return view('admin.publicaciones.edit', compact('publicacion', 'categorias', 'subcategorias', 'empresas'));
    }

    /**
     * Actualiza una publicación
     */
    public function update(Request $request, Publication $publicacion)
    {
        $validated = $request->validate([
            'titulo' => 'required|max:100',
            'descripcion' => 'required',
            'horario' => 'required|in:mañana,tarde',
            'horas_totales' => 'required|integer|min:1',
            'fecha_publicacion' => 'required|date',
            'activa' => 'boolean',
            'empresa_id' => 'required|exists:empresas,id',
            'categoria_id' => 'required|exists:categorias,id',
            'subcategoria_id' => 'required|exists:subcategorias,id',
        ]);

        $publicacion->update($validated);

        return redirect()->route('admin.publicaciones.index')
            ->with('success', 'Publicación actualizada correctamente');
    }

    /**
     * Elimina una publicación
     */
    public function destroy(Publication $publicacion)
    {
        $publicacion->delete();

        return redirect()->route('admin.publicaciones.index')
            ->with('success', 'Publicación eliminada correctamente');
    }
} 