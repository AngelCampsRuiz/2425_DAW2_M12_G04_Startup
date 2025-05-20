<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Clase;
use App\Models\Docente;
use Illuminate\Support\Facades\DB;

class ShowClaseFields extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clase:show-fields {clase_id=1}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Muestra los campos de una clase y prueba actualizar docente_id';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $claseId = $this->argument('clase_id');
        $this->info("Buscando clase con ID: {$claseId}");
        
        DB::enableQueryLog();
        
        // Obtener la clase
        $clase = Clase::find($claseId);
        
        if (!$clase) {
            $this->error("Clase con ID {$claseId} no encontrada");
            return 1;
        }
        
        // Mostrar campos actuales
        $this->info("Información de la clase:");
        $this->table(
            ['Campo', 'Valor'],
            collect($clase->getAttributes())->map(function ($value, $key) {
                return [$key, $value === null ? 'NULL' : $value];
            })->toArray()
        );
        
        // Mostrar docente relacionado
        $this->info("Docente actual:");
        if ($clase->docente) {
            $this->info("ID: {$clase->docente->id}, Nombre: {$clase->docente->user->nombre}");
        } else {
            $this->info("No hay docente asignado");
        }
        
        // Listar docentes disponibles
        $docentes = Docente::with('user')->take(5)->get();
        $this->info("Docentes disponibles (primeros 5):");
        $this->table(
            ['ID', 'Nombre'],
            $docentes->map(function ($docente) {
                return [
                    $docente->id,
                    $docente->user ? $docente->user->nombre : 'No user'
                ];
            })->toArray()
        );
        
        // Preguntar si quiere actualizar
        if ($this->confirm('¿Quieres actualizar el docente de esta clase?')) {
            $docenteId = $this->ask('Escribe el ID del docente');
            
            // Actualizar directamente con consulta
            try {
                $this->info("Actualizando con consulta directa a la base de datos...");
                DB::beginTransaction();
                
                $affected = DB::table('clases')
                    ->where('id', $clase->id)
                    ->update(['docente_id' => $docenteId]);
                
                $this->info("Filas afectadas: $affected");
                
                // Hacer una consulta para verificar
                $claseActualizada = DB::table('clases')->where('id', $clase->id)->first();
                $this->info("docente_id después de la actualización: " . $claseActualizada->docente_id);
                
                if ($this->confirm('¿Confirmar cambios?')) {
                    DB::commit();
                    $this->info("Cambios guardados");
                    
                    // Cargar la clase nuevamente y mostrar los datos
                    $claseReloaded = Clase::find($claseId);
                    $this->info("Información de la clase actualizada:");
                    $this->table(
                        ['Campo', 'Valor'],
                        collect($claseReloaded->getAttributes())->map(function ($value, $key) {
                            return [$key, $value === null ? 'NULL' : $value];
                        })->toArray()
                    );
                } else {
                    DB::rollBack();
                    $this->info("Cambios descartados");
                }
            } catch (\Exception $e) {
                DB::rollBack();
                $this->error("Error al actualizar: " . $e->getMessage());
            }
        }
        
        // Mostrar consultas ejecutadas
        $this->info("Consultas ejecutadas:");
        foreach (DB::getQueryLog() as $query) {
            $this->info($query['query'] . ' [' . implode(', ', $query['bindings']) . ']');
        }
        
        return 0;
    }
}
