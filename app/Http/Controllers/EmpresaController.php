<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Models\Empresa;
use Illuminate\Http\Request;

class EmpresaController extends BaseController
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Valida y guarda la empresa como lo hacía antes
        $empresa = Empresa::create($request->all());
        
        // Registra la actividad
        $this->logCreation($empresa, 'Se ha registrado una nueva empresa: ' . $empresa->user->nombre);
        
        return redirect()->route('admin.empresas.index')
            ->with('success', 'Empresa creada correctamente');
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
        $empresa = Empresa::findOrFail($id);
        $empresa->update($request->all());
        
        // Registra la actividad
        $this->logUpdate($empresa, 'Se ha actualizado la empresa: ' . $empresa->user->nombre);
        
        return redirect()->route('admin.empresas.index')
            ->with('success', 'Empresa actualizada correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $empresa = Empresa::findOrFail($id);
        $nombre = $empresa->user->nombre; // Guardamos el nombre antes de eliminar
        $empresa->delete();
        
        // Registra la actividad
        $this->logDeletion($empresa, 'Se ha eliminado la empresa: ' . $nombre);
        
        return redirect()->route('admin.empresas.index')
            ->with('success', 'Empresa eliminada correctamente');
    }
} 