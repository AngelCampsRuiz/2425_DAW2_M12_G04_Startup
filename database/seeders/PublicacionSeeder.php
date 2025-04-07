<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Publicacion;
use App\Models\Empresa;
use App\Models\Categoria;
use App\Models\Subcategoria;

class PublicacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $empresas = Empresa::all();
        $categorias = Categoria::all();
        $subcategorias = Subcategoria::all();
        $horarios = ['mañana', 'tarde'];

        // Crear 20 publicaciones de prueba
        for ($i = 0; $i < 20; $i++) {
            $categoria = $categorias->random();
            // Obtener una subcategoría que pertenezca a la categoría seleccionada
            $subcategoria = $subcategorias->where('categoria_id', $categoria->id)->random();

            Publicacion::create([
                'titulo' => fake()->sentence,
                'descripcion' => fake()->paragraph,
                'horario' => $horarios[array_rand($horarios)],
                'horas_totales' => rand(100, 500),
                'fecha_publicacion' => fake()->dateTimeBetween('-1 month', 'now'),
                'activa' => true,
                'empresa_id' => $empresas->random()->id,
                'categoria_id' => $categoria->id,
                'subcategoria_id' => $subcategoria->id,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
