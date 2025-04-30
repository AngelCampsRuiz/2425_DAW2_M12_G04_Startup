<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Publicacion;
use App\Models\Empresa;
use App\Models\Categoria;
use App\Models\Subcategoria;
use App\Models\NivelEducativo;

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
        $niveles = NivelEducativo::all();
        $horarios = ['mañana', 'tarde', 'flexible'];
        
        // Publicaciones para Ciclos de Grado Medio
        $this->crearPublicacionesParaNivel($niveles->where('nombre_nivel', 'Ciclos de Grado Medio')->first()->id, $empresas, $horarios);
        
        // Publicaciones para Ciclos de Grado Superior
        $this->crearPublicacionesParaNivel($niveles->where('nombre_nivel', 'Ciclos de Grado Superior')->first()->id, $empresas, $horarios);
        
        // Publicaciones para Universidades
        $this->crearPublicacionesParaNivel($niveles->where('nombre_nivel', 'Universidades')->first()->id, $empresas, $horarios);
        
        // Publicaciones para Máster
        $this->crearPublicacionesParaNivel($niveles->where('nombre_nivel', 'Máster')->first()->id, $empresas, $horarios);
    }
    
    /**
     * Crea publicaciones específicas para un nivel educativo
     */
    private function crearPublicacionesParaNivel($nivelId, $empresas, $horarios)
    {
        $categoriasNivel = Categoria::where('nivel_educativo_id', $nivelId)->get();
        
        foreach ($categoriasNivel as $categoria) {
            // Para cada categoría, creamos entre 1 y 3 publicaciones
            $numPublicaciones = rand(1, 3);
            
            for ($i = 0; $i < $numPublicaciones; $i++) {
                $empresa = $empresas->random();
                $titulo = $this->generarTitulo($categoria);
                $descripcion = $this->generarDescripcion($categoria);
                
                // Creamos la publicación
                $publicacion = Publicacion::create([
                    'titulo' => $titulo,
                    'descripcion' => $descripcion,
                    'horario' => $horarios[array_rand($horarios)],
                    'horas_totales' => rand(100, 500),
                    'fecha_publicacion' => fake()->dateTimeBetween('-1 month', 'now'),
                    'activa' => true,
                    'empresa_id' => $empresa->id,
                    'categoria_id' => $categoria->id,
                    'subcategoria_id' => $categoria->subcategorias->first()->id, // Para mantener compatibilidad
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
                
                // Asignamos múltiples subcategorías (entre 2 y 4)
                $subcategoriasCategoria = $categoria->subcategorias;
                $numSubcategorias = min(rand(2, 4), count($subcategoriasCategoria));
                $subcategoriasSeleccionadas = $subcategoriasCategoria->random($numSubcategorias);
                
                foreach ($subcategoriasSeleccionadas as $subcategoria) {
                    $publicacion->subcategorias()->attach($subcategoria->id);
                }
            }
        }
    }
    
    /**
     * Genera un título relevante para la categoría
     */
    private function generarTitulo($categoria)
    {
        $prefijos = [
            'Prácticas en', 'Colaboración con', 'Formación en', 'Becario/a de', 
            'Estudiante en', 'Aprendiz de', 'Ayudante de', 'Asistente de'
        ];
        
        $prefijo = $prefijos[array_rand($prefijos)];
        return "$prefijo {$categoria->nombre_categoria}";
    }
    
    /**
     * Genera una descripción relevante para la categoría
     */
    private function generarDescripcion($categoria)
    {
        $nivel = $categoria->nivelEducativo->nombre_nivel;
        
        $introduccion = [
            "Buscamos un estudiante de {$nivel} especializado en {$categoria->nombre_categoria} para incorporarse a nuestro equipo.",
            "Empresa líder en el sector busca incorporar un estudiante de {$categoria->nombre_categoria} para realizar prácticas.",
            "¿Estás estudiando {$categoria->nombre_categoria}? Tenemos una oportunidad para ti.",
            "Se ofrece puesto de prácticas para estudiante de {$categoria->nombre_categoria}.",
            "Interesante oportunidad para estudiantes de {$categoria->nombre_categoria} que quieran completar su formación con nosotros."
        ];
        
        $requisitos = [
            "Requisitos: Conocimientos en {$this->getRandomSubcategorias($categoria, 2)}.",
            "Se valorarán competencias en {$this->getRandomSubcategorias($categoria, 3)}.",
            "Imprescindible interés por {$this->getRandomSubcategorias($categoria, 2)}.",
            "Valoramos positivamente conocimientos de {$this->getRandomSubcategorias($categoria, 2)}.",
            "Se requiere capacidad de aprendizaje en {$this->getRandomSubcategorias($categoria, 2)}."
        ];
        
        $beneficios = [
            "Ofrecemos: formación continua, buen ambiente laboral y posibilidad de incorporación.",
            "Te ofrecemos un ambiente dinámico donde podrás aplicar tus conocimientos y seguir aprendiendo.",
            "Tendrás la oportunidad de trabajar en proyectos reales y aprender de profesionales experimentados.",
            "Posibilidad de contratación al finalizar las prácticas para los perfiles que mejor encajen.",
            "Gran oportunidad para iniciar tu carrera profesional en un entorno colaborativo y de aprendizaje."
        ];
        
        return $introduccion[array_rand($introduccion)] . "\n\n" . 
               $requisitos[array_rand($requisitos)] . "\n\n" . 
               $beneficios[array_rand($beneficios)];
    }
    
    /**
     * Obtiene subcategorías aleatorias para la descripción
     */
    private function getRandomSubcategorias($categoria, $num)
    {
        $subcategorias = $categoria->subcategorias->pluck('nombre_subcategoria')->toArray();
        $selected = array_rand($subcategorias, min($num, count($subcategorias)));
        
        if (!is_array($selected)) {
            $selected = [$selected];
        }
        
        $result = [];
        foreach ($selected as $index) {
            $result[] = $subcategorias[$index];
        }
        
        if (count($result) > 1) {
            $last = array_pop($result);
            return implode(', ', $result) . ' y ' . $last;
        }
        
        return implode(', ', $result);
    }
}
