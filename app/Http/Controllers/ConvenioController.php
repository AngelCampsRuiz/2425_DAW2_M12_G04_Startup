<?php

namespace App\Http\Controllers;

use App\Models\Convenio;
use App\Models\Publicacion;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class ConvenioController extends Controller
{
    /**
     * Mostrar la vista de convenios.
     */
    public function index(Request $request)
    {
        // Obtener el ID del usuario empresa actual
        $empresaId = Auth::id();
        
        // Obtener el número de elementos por página de la solicitud
        $perPage = $request->input('per_page', 10);
        
        // Obtener ofertas de la empresa con candidatos aceptados
        $ofertas = Publicacion::where('empresa_id', $empresaId)
            ->where('activa', true)
            ->withCount('candidatosAceptados')
            ->has('candidatosAceptados')
            ->with('categoria', 'candidatosAceptados')
            ->get();
            
        // Obtener convenios existentes de la empresa con paginación
        $convenios = Convenio::whereHas('oferta', function($query) use ($empresaId) {
                $query->where('empresa_id', $empresaId);
            })
            ->with(['estudiante', 'oferta'])
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
            
        return view('empresa.convenios', compact('ofertas', 'convenios'));
    }

    /**
     * Búsqueda de convenios por AJAX.
     */
    public function search(Request $request)
    {
        $empresaId = Auth::id();
        $query = $request->input('query', '');
        $estado = $request->input('estado', 'todos');
        $page = $request->input('page', 1);
        $perPage = $request->input('per_page', 10);

        // Búsqueda de ofertas con candidatos aceptados
        $ofertasQuery = Publicacion::where('empresa_id', $empresaId)
            ->where('activa', true)
            ->withCount('candidatosAceptados')
            ->has('candidatosAceptados')
            ->with(['categoria', 'candidatosAceptados']);

        // Búsqueda de convenios
        $conveniosQuery = Convenio::whereHas('oferta', function($q) use ($empresaId) {
                $q->where('empresa_id', $empresaId);
            })
            ->with(['estudiante', 'oferta']);

        // Aplicar filtro de búsqueda
        if (!empty($query)) {
            $ofertasQuery->where(function($q) use ($query) {
                $q->where('titulo', 'like', "%{$query}%")
                  ->orWhere('descripcion', 'like', "%{$query}%")
                  ->orWhereHas('candidatosAceptados', function($q) use ($query) {
                      $q->where('nombre', 'like', "%{$query}%")
                        ->orWhere('email', 'like', "%{$query}%");
                  });
            });

            $conveniosQuery->where(function($q) use ($query) {
                $q->whereHas('estudiante', function($q) use ($query) {
                      $q->where('nombre', 'like', "%{$query}%")
                        ->orWhere('email', 'like', "%{$query}%");
                  })
                  ->orWhereHas('oferta', function($q) use ($query) {
                      $q->where('titulo', 'like', "%{$query}%");
                  })
                  ->orWhere('tutor_empresa', 'like', "%{$query}%");
            });
        }

        // Aplicar filtro de estado para convenios
        if ($estado !== 'todos') {
            $conveniosQuery->where('estado', $estado);
        }

        // Ejecutar consultas
        $ofertas = $ofertasQuery->get();
        
        // Aplicar paginación a los convenios
        $conveniosQuery->orderBy('created_at', 'desc');
        $conveniosPaginados = $conveniosQuery->paginate($perPage, ['*'], 'page', $page);

        // Preparar datos para la respuesta
        $ofertasData = $ofertas->map(function ($oferta) {
            $candidatosAceptados = $oferta->candidatosAceptados->map(function ($candidato) use ($oferta) {
                $convenio = Convenio::where('oferta_id', $oferta->id)
                    ->where('estudiante_id', $candidato->id)
                    ->first();
                
                return [
                    'id' => $candidato->id,
                    'nombre' => $candidato->nombre,
                    'email' => $candidato->email,
                    'imagen' => $candidato->imagen,
                    'convenio' => $convenio ? [
                        'id' => $convenio->id,
                        'estado' => $convenio->estado
                    ] : null
                ];
            });
            
            return [
                'id' => $oferta->id,
                'titulo' => $oferta->titulo,
                'created_at' => $oferta->created_at,
                'horario' => $oferta->horario,
                'horas_totales' => $oferta->horas_totales,
                'categoria' => $oferta->categoria ? [
                    'id' => $oferta->categoria->id,
                    'nombre_categoria' => $oferta->categoria->nombre_categoria
                ] : null,
                'candidatos_aceptados' => $candidatosAceptados
            ];
        });

        // Crear datos de paginación
        $paginationData = [
            'total' => $conveniosPaginados->total(),
            'per_page' => $conveniosPaginados->perPage(),
            'current_page' => $conveniosPaginados->currentPage(),
            'last_page' => $conveniosPaginados->lastPage(),
            'first_item' => $conveniosPaginados->firstItem(),
            'last_item' => $conveniosPaginados->lastItem()
        ];

        return response()->json([
            'ofertas' => $ofertasData,
            'convenios' => $conveniosPaginados->items(),
            'pagination' => $paginationData
        ]);
    }

    /**
     * Almacenar un nuevo convenio.
     */
    public function store(Request $request)
    {
        $request->validate([
            'oferta_id' => 'required|exists:publicaciones,id',
            'estudiante_id' => 'required|exists:user,id',
            'empresa_id' => 'required|exists:user,id',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after:fecha_inicio',
            'horario_practica' => 'required|string',
            'tutor_empresa' => 'required|string',
            'tareas' => 'required|string',
            'objetivos' => 'required|string',
        ]);

        try {
            // Crear nuevo convenio
            $convenio = new Convenio();
            $convenio->oferta_id = $request->oferta_id;
            $convenio->estudiante_id = $request->estudiante_id;
            $convenio->empresa_id = $request->empresa_id;
            $convenio->fecha_inicio = $request->fecha_inicio;
            $convenio->fecha_fin = $request->fecha_fin;
            $convenio->horario_practica = $request->horario_practica;
            $convenio->tutor_empresa = $request->tutor_empresa;
            $convenio->tareas = $request->tareas;
            $convenio->objetivos = $request->objetivos;
            $convenio->estado = 'pendiente';
            $convenio->fecha_creacion = now();
            $convenio->save();
            
            // Generar el PDF del convenio
            $pdfFileName = $this->generarPDF($convenio);
            
            // Actualizar el convenio con la ruta del PDF
            $convenio->documento_pdf = $pdfFileName;
            $convenio->save();
            
            // Preparar la respuesta para descargar el PDF
            $pdfUrl = route('empresa.convenios.download', $convenio->id);
            
            return response()->json([
                'success' => true,
                'message' => 'Convenio creado correctamente',
                'data' => $convenio,
                'pdf_url' => $pdfUrl
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al crear el convenio: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mostrar un convenio específico.
     */
    public function show($id)
    {
        $convenio = Convenio::with(['estudiante', 'oferta'])->findOrFail($id);
        
        // Verificar que el convenio pertenece a la empresa actual
        if ($convenio->oferta->empresa_id != Auth::id()) {
            abort(403, 'No tienes permiso para acceder a este convenio');
        }
        
        return view('empresa.convenios.show', compact('convenio'));
    }

    /**
     * Mostrar el formulario para editar un convenio.
     */
    public function edit($id)
    {
        $convenio = Convenio::with(['estudiante', 'oferta'])->findOrFail($id);
        
        // Verificar que el convenio pertenece a la empresa actual
        if ($convenio->oferta->empresa_id != Auth::id()) {
            abort(403, 'No tienes permiso para acceder a este convenio');
        }
        
        return view('empresa.convenios.edit', compact('convenio'));
    }

    /**
     * Actualizar un convenio existente.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after:fecha_inicio',
            'horario_practica' => 'required|string',
            'tutor_empresa' => 'required|string',
            'tareas' => 'required|string',
            'objetivos' => 'required|string',
        ]);

        $convenio = Convenio::findOrFail($id);
        
        // Verificar que el convenio pertenece a la empresa actual
        if ($convenio->oferta->empresa_id != Auth::id()) {
            abort(403, 'No tienes permiso para modificar este convenio');
        }
        
        try {
            $convenio->fecha_inicio = $request->fecha_inicio;
            $convenio->fecha_fin = $request->fecha_fin;
            $convenio->horario_practica = $request->horario_practica;
            $convenio->tutor_empresa = $request->tutor_empresa;
            $convenio->tareas = $request->tareas;
            $convenio->objetivos = $request->objetivos;
            $convenio->save();
            
            return redirect()->route('empresa.convenios')->with('success', 'Convenio actualizado correctamente');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al actualizar el convenio: ' . $e->getMessage());
        }
    }

    /**
     * Descargar un convenio.
     */
    public function download($id)
    {
        $convenio = Convenio::with(['estudiante', 'oferta.empresa', 'oferta.categoria'])->findOrFail($id);
        
        // Verificar que el convenio pertenece a la empresa actual
        if ($convenio->oferta->empresa_id != Auth::id()) {
            abort(403, 'No tienes permiso para descargar este convenio');
        }
        
        // Si el documento PDF ya existe, descargarlo
        if (!empty($convenio->documento_pdf) && Storage::disk('public')->exists('convenios/' . $convenio->documento_pdf)) {
            return Storage::disk('public')->download('convenios/' . $convenio->documento_pdf, 'Convenio_' . $convenio->id . '.pdf');
        }
        
        // Si no existe, generar el PDF y descargarlo
        $pdfFileName = $this->generarPDF($convenio);
        
        // Actualizar el convenio con la ruta del PDF si no lo tenía
        if (empty($convenio->documento_pdf)) {
            $convenio->documento_pdf = $pdfFileName;
            $convenio->save();
        }
        
        return Storage::disk('public')->download('convenios/' . $pdfFileName, 'Convenio_' . $convenio->id . '.pdf');
    }
    
    /**
     * Genera un PDF para el convenio y lo guarda en el almacenamiento.
     * 
     * @param Convenio $convenio
     * @return string Nombre del archivo PDF generado
     */
    public function generarPDF($convenio)
    {
        // Cargar el convenio con todas las relaciones necesarias si no están cargadas
        if (!$convenio->relationLoaded('estudiante') || !$convenio->relationLoaded('oferta')) {
            $convenio->load(['estudiante', 'oferta.empresa', 'oferta.categoria']);
        }
        
        // Generar el nombre del archivo
        $fileName = 'convenio_' . $convenio->id . '_' . time() . '.pdf';
        
        // Crear el directorio si no existe
        Storage::disk('public')->makeDirectory('convenios');
        
        // Generar el PDF
        $pdf = PDF::loadView('pdf.convenio', ['convenio' => $convenio]);
        
        // Guardar el PDF en el almacenamiento
        Storage::disk('public')->put('convenios/' . $fileName, $pdf->output());
        
        return $fileName;
    }
}
