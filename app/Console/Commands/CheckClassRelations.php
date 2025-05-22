<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Docente;
use App\Models\Clase;
use App\Models\Estudiante;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class CheckClassRelations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-class-relations {docente_id?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verifica las relaciones entre docentes, clases y estudiantes';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $docenteId = $this->argument('docente_id');

        if ($docenteId) {
            $this->checkDocente($docenteId);
        } else {
            $this->checkAllRelations();
        }

        return Command::SUCCESS;
    }

    private function checkDocente($docenteId)
    {
        $docente = Docente::find($docenteId);
        
        if (!$docente) {
            $this->error("Docente con ID {$docenteId} no encontrado");
            return;
        }
        
        $this->info("Verificando docente: ID {$docente->id}, User ID {$docente->user_id}");
        
        if ($docente->user) {
            $this->info("Usuario: {$docente->user->nombre} ({$docente->user->email})");
        } else {
            $this->error("¡Error! No se encontró el usuario asociado al docente");
        }
        
        // Verificar clases asignadas
        $clases = $docente->clases()->get();
        
        if ($clases->isEmpty()) {
            $this->warn("No hay clases asignadas a este docente");
            
            // Verificar directamente en la tabla pivote
            $clasesDirectas = DB::table('docente_clase')
                ->where('docente_id', $docente->id)
                ->get();
                
            if ($clasesDirectas->isEmpty()) {
                $this->warn("No hay asignaciones en la tabla docente_clase");
            } else {
                $this->info("Se encontraron {$clasesDirectas->count()} asignaciones en docente_clase:");
                foreach ($clasesDirectas as $asignacion) {
                    $clase = Clase::find($asignacion->clase_id);
                    $this->line(" - Clase ID: {$asignacion->clase_id}" . 
                        ($clase ? ", Nombre: {$clase->nombre}" : " (No existe la clase)"));
                }
            }
        } else {
            $this->info("Clases asignadas: {$clases->count()}");
            foreach ($clases as $clase) {
                $this->line(" - {$clase->nombre} (ID: {$clase->id})");
                
                // Verificar estudiantes en esta clase
                $estudiantes = $clase->estudiantes()->get();
                if ($estudiantes->isEmpty()) {
                    $this->warn("   No hay estudiantes asignados a esta clase");
                    
                    // Verificar directamente en la tabla pivote
                    $estudiantesDirectos = DB::table('estudiante_clase')
                        ->where('clase_id', $clase->id)
                        ->get();
                        
                    if ($estudiantesDirectos->isEmpty()) {
                        $this->warn("   No hay asignaciones en la tabla estudiante_clase");
                    } else {
                        $this->info("   Se encontraron {$estudiantesDirectos->count()} estudiantes en estudiante_clase:");
                        foreach ($estudiantesDirectos as $asignacion) {
                            $estudiante = Estudiante::find($asignacion->estudiante_id);
                            $usuario = $estudiante ? User::find($estudiante->user_id) : null;
                            $this->line("   - Estudiante ID: {$asignacion->estudiante_id}" . 
                                ($usuario ? ", Nombre: {$usuario->nombre}" : " (No existe el usuario)"));
                        }
                    }
                } else {
                    $this->info("   Estudiantes en esta clase: {$estudiantes->count()}");
                    foreach ($estudiantes as $estudiante) {
                        $this->line("   - {$estudiante->user->nombre} (ID: {$estudiante->id})");
                    }
                }
            }
        }
    }

    private function checkAllRelations()
    {
        $this->info("Verificando todas las relaciones...");
        
        // Contar docentes
        $docentes = Docente::all();
        $this->info("Docentes: {$docentes->count()}");
        
        // Contar clases
        $clases = Clase::all();
        $this->info("Clases: {$clases->count()}");
        
        // Contar estudiantes
        $estudiantes = Estudiante::all();
        $this->info("Estudiantes: {$estudiantes->count()}");
        
        // Contar asignaciones docente-clase
        $docenteClases = DB::table('docente_clase')->get();
        $this->info("Asignaciones docente-clase: {$docenteClases->count()}");
        
        // Contar asignaciones estudiante-clase
        $estudianteClases = DB::table('estudiante_clase')->get();
        $this->info("Asignaciones estudiante-clase: {$estudianteClases->count()}");
        
        // Lista de docentes con sus clases
        $this->info("\nListado de docentes con clases:");
        foreach ($docentes as $docente) {
            $clasesCount = $docente->clases()->count();
            $this->line(" - Docente ID {$docente->id}: {$clasesCount} clases");
            
            if ($clasesCount == 0) {
                $this->warn("   ¡Este docente no tiene clases asignadas!");
            }
        }
    }
}
