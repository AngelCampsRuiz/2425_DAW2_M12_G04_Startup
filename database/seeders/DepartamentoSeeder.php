<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Departamento;
use App\Models\Institucion;
use App\Models\Docente;
use App\Models\Clase;

class DepartamentoSeeder extends Seeder
{
    public function run(): void
    {
        $departamentos = [
            'Informática' => [
                'descripcion' => 'Departamento de Informática y Comunicaciones',
                'clases' => [
                    [
                        'nombre' => 'DAW2 - Desarrollo de Aplicaciones Web',
                        'codigo' => 'DAW2A',
                        'nivel' => 'Superior',
                        'curso' => 2,
                        'grupo' => 'A',
                        'descripcion' => 'Segundo curso de Desarrollo de Aplicaciones Web',
                        'capacidad' => 30,
                        'horario' => 'Lunes a Viernes 8:00-14:00'
                    ],
                    [
                        'nombre' => 'DAM2 - Desarrollo de Aplicaciones Multiplataforma',
                        'codigo' => 'DAM2A',
                        'nivel' => 'Superior',
                        'curso' => 2,
                        'grupo' => 'A',
                        'descripcion' => 'Segundo curso de Desarrollo de Aplicaciones Multiplataforma',
                        'capacidad' => 30,
                        'horario' => 'Lunes a Viernes 8:00-14:00'
                    ]
                ]
            ],
            'Administración' => [
                'descripcion' => 'Departamento de Administración y Gestión',
                'clases' => [
                    [
                        'nombre' => 'ADF2 - Administración y Finanzas',
                        'codigo' => 'ADF2A',
                        'nivel' => 'Superior',
                        'curso' => 2,
                        'grupo' => 'A',
                        'descripcion' => 'Segundo curso de Administración y Finanzas',
                        'capacidad' => 30,
                        'horario' => 'Lunes a Viernes 8:00-14:00'
                    ]
                ]
            ],
            'Marketing' => [
                'descripcion' => 'Departamento de Marketing y Comercio',
                'clases' => [
                    [
                        'nombre' => 'MKT2 - Marketing y Publicidad',
                        'codigo' => 'MKT2A',
                        'nivel' => 'Superior',
                        'curso' => 2,
                        'grupo' => 'A',
                        'descripcion' => 'Segundo curso de Marketing y Publicidad',
                        'capacidad' => 30,
                        'horario' => 'Lunes a Viernes 8:00-14:00'
                    ]
                ]
            ]
        ];

        // Obtener todas las instituciones
        $instituciones = Institucion::all();

        foreach ($instituciones as $institucion) {
            foreach ($departamentos as $nombreDepartamento => $datosDepartamento) {
                // Crear departamento
                $departamento = Departamento::create([
                    'institucion_id' => $institucion->id,
                    'nombre' => $nombreDepartamento,
                    'codigo' => strtoupper(substr(str_replace(' ', '', $nombreDepartamento), 0, 3)),
                    'descripcion' => $datosDepartamento['descripcion']
                ]);

                // Asignar un jefe de departamento
                $jefeDocente = Docente::where('institucion_id', $institucion->id)
                    ->inRandomOrder()
                    ->first();

                if ($jefeDocente) {
                    $departamento->update(['jefe_departamento_id' => $jefeDocente->id]);
                }

                // Crear clases para el departamento
                foreach ($datosDepartamento['clases'] as $datosClase) {
                    $clase = new Clase($datosClase);
                    $clase->institucion_id = $institucion->id;
                    $clase->departamento_id = $departamento->id;
                    $clase->activa = true;
                    $clase->save();

                    // Asignar docentes a la clase
                    $docentes = Docente::where('institucion_id', $institucion->id)
                        ->inRandomOrder()
                        ->take(2)
                        ->get();

                    foreach ($docentes as $index => $docente) {
                        $clase->docentes()->attach($docente->id, [
                            'fecha_asignacion' => now(),
                            'es_titular' => $index === 0,
                            'rol' => $index === 0 ? 'Titular' : 'Auxiliar'
                        ]);
                    }
                }
            }
        }
    }
} 