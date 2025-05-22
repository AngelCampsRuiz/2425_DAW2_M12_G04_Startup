<?php

namespace App\Http\Controllers\Institucion;

use App\Http\Controllers\Controller;
use App\Models\Convenio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ConvenioController as BaseConvenioController;
use Illuminate\Support\Facades\Storage;

class ConvenioController extends Controller
{
    /**
     * Mostrar los convenios pendientes de firma
     */
    public function index()
    {
        $convenios = Convenio::where('estado', 'activo')
            ->where('firmado_institucion', false)
            ->with(['estudiante', 'empresa', 'oferta'])
            ->orderBy('fecha_aprobacion', 'desc')
            ->paginate(10);

        return view('institucion.convenios.index', compact('convenios'));
    }

    /**
     * Firmar un convenio
     */
    public function firmar(Convenio $convenio)
    {
        // Verificar que el convenio está activo y no ha sido firmado
        if ($convenio->estado !== 'activo' || $convenio->firmado_institucion) {
            return back()->with('error', 'El convenio no puede ser firmado');
        }

        // Actualizar el convenio
        $convenio->firmado_institucion = true;
        $convenio->firmado_por_institucion = Auth::id();
        $convenio->fecha_firma_institucion = now();
        $convenio->save();

        // Regenerar el PDF con la firma de la institución
        $convenioController = new BaseConvenioController();
        $pdfFileName = $convenioController->generarPDF($convenio);
        $convenio->documento_pdf = $pdfFileName;
        $convenio->save();

        return redirect()->route('institucion.convenios.show', $convenio)
            ->with('success', 'El convenio ha sido firmado correctamente');
    }

    /**
     * Mostrar un convenio específico
     */
    public function show(Convenio $convenio)
    {
        $convenio->load(['estudiante', 'empresa', 'oferta', 'firmadoPorInstitucion']);
        return view('institucion.convenios.show', compact('convenio'));
    }

    /**
     * Descargar el PDF del convenio
     */
    public function download(Convenio $convenio)
    {
        // Verificamos que el PDF existe
        if (!empty($convenio->documento_pdf) && Storage::disk('public')->exists('convenios/' . $convenio->documento_pdf)) {
            return Storage::disk('public')->download('convenios/' . $convenio->documento_pdf, 'Convenio_' . $convenio->id . '.pdf');
        }
        
        // Si no existe, generar el PDF y descargarlo
        $baseController = new BaseConvenioController();
        $pdfFileName = $baseController->generarPDF($convenio);
        
        // Actualizar el convenio con la ruta del PDF si no lo tenía
        if (empty($convenio->documento_pdf)) {
            $convenio->documento_pdf = $pdfFileName;
            $convenio->save();
        }
        
        return Storage::disk('public')->download('convenios/' . $pdfFileName, 'Convenio_' . $convenio->id . '.pdf');
    }

    /**
     * Mostrar los convenios ya firmados por la institución
     */
    public function firmados()
    {
        $convenios = Convenio::where('estado', 'activo')
            ->where('firmado_institucion', true)
            ->with(['estudiante', 'empresa', 'oferta', 'firmadoPorInstitucion'])
            ->orderBy('fecha_firma_institucion', 'desc')
            ->paginate(10);

        return view('institucion.convenios.firmados', compact('convenios'));
    }
}
