<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Docente;
use App\Models\Clase;
use Illuminate\Support\Facades\DB;

class AssignClassesToTeachers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:assign-classes-to-teachers {docente_id?} {clase_id?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Asigna clases a docentes';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $docenteId = $this->argument('docente_id');
        $claseId = $this->argument('clase_id');

        if ($docenteId && $claseId) {
            // Asignar una clase específica a un docente específico
            $this->assignClassToTeacher($docenteId, $claseId);
        } elseif ($docenteId) {
            // Asignar todas las clases al docente especificado
            $this->assignAllClassesToTeacher($docenteId);
        } else {
            // Mostrar docentes y clases disponibles
            $this->showTeachersAndClasses();
        }

        return Command::SUCCESS;
    }

    private function assignClassToTeacher($docenteId, $claseId)
    {
        $docente = Docente::find($docenteId);
        $clase = Clase::find($claseId);

        if (!$docente) {
            $this->error("Docente con ID {$docenteId} no encontrado.");
            return;
        }

        if (!$clase) {
            $this->error("Clase con ID {$claseId} no encontrada.");
            return;
        }

        // Verificar si ya existe la asignación
        $existingAssignment = DB::table('docente_clase')
            ->where('docente_id', $docenteId)
            ->where('clase_id', $claseId)
            ->first();

        if ($existingAssignment) {
            $this->info("El docente ya está asignado a esta clase.");
            return;
        }

        // Crear la asignación
        DB::table('docente_clase')->insert([
            'docente_id' => $docenteId,
            'clase_id' => $claseId,
            'fecha_asignacion' => now(),
            'es_titular' => true,
            'rol' => 'Profesor titular',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $this->info("Docente {$docente->user->nombre} asignado a la clase {$clase->nombre} correctamente.");
    }

    private function assignAllClassesToTeacher($docenteId)
    {
        $docente = Docente::find($docenteId);

        if (!$docente) {
            $this->error("Docente con ID {$docenteId} no encontrado.");
            return;
        }

        $clases = Clase::all();

        if ($clases->isEmpty()) {
            $this->warn("No hay clases disponibles para asignar.");
            return;
        }

        foreach ($clases as $clase) {
            // Verificar si ya existe la asignación
            $existingAssignment = DB::table('docente_clase')
                ->where('docente_id', $docenteId)
                ->where('clase_id', $clase->id)
                ->first();

            if ($existingAssignment) {
                $this->info("El docente ya está asignado a la clase {$clase->nombre}.");
                continue;
            }

            // Crear la asignación
            DB::table('docente_clase')->insert([
                'docente_id' => $docenteId,
                'clase_id' => $clase->id,
                'fecha_asignacion' => now(),
                'es_titular' => true,
                'rol' => 'Profesor titular',
                'created_at' => now(),
                'updated_at' => now()
            ]);

            $this->info("Docente {$docente->user->nombre} asignado a la clase {$clase->nombre} correctamente.");
        }
    }

    private function showTeachersAndClasses()
    {
        $this->info("Docentes disponibles:");
        $docentes = Docente::with('user')->get();
        foreach ($docentes as $docente) {
            $this->line(" - ID: {$docente->id}, Nombre: {$docente->user->nombre}");
        }

        $this->info("\nClases disponibles:");
        $clases = Clase::all();
        foreach ($clases as $clase) {
            $this->line(" - ID: {$clase->id}, Nombre: {$clase->nombre}");
        }

        $this->info("\nPara asignar una clase a un docente:");
        $this->line("php artisan app:assign-classes-to-teachers [docente_id] [clase_id]");

        $this->info("\nPara asignar todas las clases a un docente:");
        $this->line("php artisan app:assign-classes-to-teachers [docente_id]");
    }
} 