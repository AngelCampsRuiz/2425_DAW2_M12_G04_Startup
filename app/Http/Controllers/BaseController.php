<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Schema;

class BaseController extends Controller
{
    /**
     * Registra una actividad de creación
     *
     * @param mixed $model El modelo creado
     * @param string $description Descripción legible de la acción
     * @param array|null $additionalData Datos adicionales
     * @return void
     */
    protected function logCreation($model, $description, $additionalData = null)
    {
        if (Schema::hasTable('activity_logs')) {
            ActivityLog::logCreation($model, $description, $additionalData);
        }
    }
    
    /**
     * Registra una actividad de actualización
     *
     * @param mixed $model El modelo actualizado
     * @param string $description Descripción legible de la acción
     * @param array|null $additionalData Datos adicionales
     * @return void
     */
    protected function logUpdate($model, $description, $additionalData = null)
    {
        if (Schema::hasTable('activity_logs')) {
            ActivityLog::logUpdate($model, $description, $additionalData);
        }
    }
    
    /**
     * Registra una actividad de eliminación
     *
     * @param mixed $model El modelo eliminado
     * @param string $description Descripción legible de la acción
     * @param array|null $additionalData Datos adicionales
     * @return void
     */
    protected function logDeletion($model, $description, $additionalData = null)
    {
        if (Schema::hasTable('activity_logs')) {
            ActivityLog::logDeletion($model, $description, $additionalData);
        }
    }
} 