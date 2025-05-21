<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Publication;
use App\Models\Empresa;
use App\Models\Estudiante;
use App\Models\User;
use App\Models\Institucion;
use App\Models\ActivityLog;
use App\Models\Categoria;
use App\Models\Subcategoria;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;

class AdminController extends Controller
{
    public function index()
    {
        // Estadísticas principales
        $stats = [
            'ofertas' => [
                'total' => Publication::count(),
                'activas' => Publication::where('activa', 1)->count(),
                'crecimiento' => $this->calcularCrecimiento('publicaciones')
            ],
            'empresas' => [
                'total' => Empresa::count(),
                'activas' => Empresa::whereHas('user', function($q) {
                    $q->where('activo', 1);
                })->count(),
                'crecimiento' => $this->calcularCrecimiento('user', 2) // role_id 2 = empresas
            ],
            'alumnos' => [
                'total' => Estudiante::count(),
                'activos' => Estudiante::whereHas('user', function($q) {
                    $q->where('activo', 1);
                })->count(),
                'crecimiento' => $this->calcularCrecimiento('user', 3) // role_id 3 = alumnos
            ],
            'profesores' => [
                'total' => User::where('role_id', 4)->count(),
                'activos' => User::where('role_id', 4)->where('activo', 1)->count(),
                'crecimiento' => $this->calcularCrecimiento('user', 4) // role_id 4 = profesores
            ],
            'instituciones' => [
                'total' => Institucion::count(),
                'crecimiento' => $this->calcularCrecimiento('instituciones')
            ],
            'categorias' => [
                'total' => Categoria::count()
            ],
            'subcategorias' => [
                'total' => Subcategoria::count()
            ]
        ];
        
        // Datos para gráficos
        $chartData = [
            'ofertas_mensuales' => $this->getOfertasPorMes(),
            'usuarios_por_rol' => $this->getUsuariosPorRol(),
            'ofertas_por_categoria' => $this->getOfertasPorCategoria(),
            'solicitudes_por_dia' => $this->getSolicitudesPorDia(),
            'ofertas_por_dia' => $this->getOfertasPorDia()
        ];
        
        // Actividad reciente del sistema
        $actividad_reciente = $this->getActividadesRecientes();
            
        // Últimos usuarios registrados
        $nuevos_usuarios = User::orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
            
        // Últimas ofertas publicadas
        $ultimas_ofertas = Publication::with(['empresa.user', 'categoria'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
            
        return view('admin.dashboard', compact(
            'stats', 
            'chartData', 
            'actividad_reciente', 
            'nuevos_usuarios',
            'ultimas_ofertas'
        ));
    }
    
    /**
     * Calcula el porcentaje de crecimiento de registros en la última semana
     */
    private function calcularCrecimiento($tabla, $role_id = null)
    {
        $ahora = Carbon::now();
        $hace_una_semana = Carbon::now()->subWeek();
        
        if ($tabla == 'user' && $role_id) {
            $actual = User::where('role_id', $role_id)
                ->whereDate('created_at', '>=', $hace_una_semana)
                ->count();
                
            $anterior = User::where('role_id', $role_id)
                ->whereDate('created_at', '<', $hace_una_semana)
                ->whereDate('created_at', '>=', $hace_una_semana->copy()->subWeek())
                ->count();
        } else {
            // Tabla genérica
            $actual = DB::table($tabla)
                ->whereDate('created_at', '>=', $hace_una_semana)
                ->count();
                
            $anterior = DB::table($tabla)
                ->whereDate('created_at', '<', $hace_una_semana)
                ->whereDate('created_at', '>=', $hace_una_semana->copy()->subWeek())
                ->count();
        }
        
        // Evitar división por cero
        if ($anterior == 0) {
            return $actual > 0 ? 100 : 0;
        }
        
        return round((($actual - $anterior) / $anterior) * 100);
    }
    
    /**
     * Obtiene el número de ofertas publicadas por mes en el último año
     */
    private function getOfertasPorMes()
    {
        $data = [];
        $labels = [];
        
        for ($i = 11; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $count = Publication::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();
                
            $data[] = $count;
            $labels[] = $month->format('M Y');
        }
        
        return [
            'labels' => $labels,
            'data' => $data
        ];
    }
    
    /**
     * Obtiene la distribución de usuarios por rol
     */
    private function getUsuariosPorRol()
    {
        $roles = [
            'Administradores' => User::where('role_id', 1)->count(),
            'Empresas' => User::where('role_id', 2)->count(),
            'Estudiantes' => User::where('role_id', 3)->count(),
            'Profesores' => User::where('role_id', 4)->count(),
            'Instituciones' => User::where('role_id', 5)->count()
        ];
        
        return [
            'labels' => array_keys($roles),
            'data' => array_values($roles)
        ];
    }
    
    /**
     * Obtiene la distribución de ofertas por categoría
     */
    private function getOfertasPorCategoria()
    {
        $categorias = Categoria::withCount('publicaciones')->get();
        
        return [
            'labels' => $categorias->pluck('nombre')->toArray(),
            'data' => $categorias->pluck('publicaciones_count')->toArray()
        ];
    }
    
    /**
     * Obtiene el número de solicitudes por día en la última semana
     */
    private function getSolicitudesPorDia()
    {
        $data = [];
        $labels = [];
        
        for ($i = 6; $i >= 0; $i--) {
            $day = Carbon::now()->subDays($i);
            $count = DB::table('solicitudes')
                ->whereDate('created_at', $day->toDateString())
                ->count();
                
            $data[] = $count;
            $labels[] = $day->format('D');
        }
        
        return [
            'labels' => $labels,
            'data' => $data
        ];
    }
    
    /**
     * Obtiene el número de ofertas publicadas por día en la última semana
     */
    private function getOfertasPorDia()
    {
        $data = [];
        $labels = [];
        
        for ($i = 6; $i >= 0; $i--) {
            $day = Carbon::now()->subDays($i);
            $count = Publication::whereDate('created_at', $day->toDateString())
                ->count();
                
            $data[] = $count;
            $labels[] = $day->format('D');
        }
        
        return [
            'labels' => $labels,
            'data' => $data
        ];
    }
    
    /**
     * Obtiene las actividades más recientes, filtrando solo las más relevantes
     */
    private function getActividadesRecientes()
    {
        // Si la tabla no existe, devolver un array vacío
        if (!Schema::hasTable('activity_logs')) {
            return collect([]);
        }
        
        return ActivityLog::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(4)
            ->get();
    }
}
