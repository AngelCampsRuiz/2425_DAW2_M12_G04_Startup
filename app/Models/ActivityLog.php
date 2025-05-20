<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'action',
        'subject_type',
        'subject_id',
        'description',
        'data',
        'ip_address',
        'user_agent'
    ];

    protected $casts = [
        'data' => 'array',
    ];

    /**
     * Relación con el usuario que realizó la acción
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Registra una actividad en el sistema
     * 
     * @param string $type Tipo de acción (create, update, delete)
     * @param string $action Acción específica realizada
     * @param string $subjectType Tipo de modelo afectado
     * @param int|null $subjectId ID del registro afectado
     * @param string $description Descripción legible de la acción
     * @param array|null $data Datos adicionales opcionales
     * @param int|null $userId ID del usuario que realizó la acción
     * @return ActivityLog
     */
    public static function log($type, $action, $subjectType, $subjectId = null, $description, $data = null, $userId = null)
    {
        // Si no se proporciona userId, intenta obtener el ID del usuario autenticado
        if (is_null($userId) && auth()->check()) {
            $userId = auth()->id();
        }

        $request = request();

        return self::create([
            'user_id' => $userId,
            'type' => $type,
            'action' => $action,
            'subject_type' => $subjectType,
            'subject_id' => $subjectId,
            'description' => $description,
            'data' => $data,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent()
        ]);
    }

    /**
     * Método auxiliar para registrar la creación de un recurso
     */
    public static function logCreation($subject, $description, $data = null, $userId = null)
    {
        $subjectType = get_class($subject);
        $subjectType = class_basename($subjectType);
        
        return self::log('create', 'created', $subjectType, $subject->id, $description, $data, $userId);
    }

    /**
     * Método auxiliar para registrar la actualización de un recurso
     */
    public static function logUpdate($subject, $description, $data = null, $userId = null)
    {
        $subjectType = get_class($subject);
        $subjectType = class_basename($subjectType);
        
        return self::log('update', 'updated', $subjectType, $subject->id, $description, $data, $userId);
    }

    /**
     * Método auxiliar para registrar la eliminación de un recurso
     */
    public static function logDeletion($subject, $description, $data = null, $userId = null)
    {
        $subjectType = get_class($subject);
        $subjectType = class_basename($subjectType);
        
        return self::log('delete', 'deleted', $subjectType, $subject->id, $description, $data, $userId);
    }
    
    /**
     * Devuelve un icono apropiado según el tipo de actividad
     */
    public function getIconHtml()
    {
        switch ($this->type) {
            case 'create':
                return '<div class="bg-green-100 p-2 rounded-full"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg></div>';
            case 'update':
                return '<div class="bg-blue-100 p-2 rounded-full"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg></div>';
            case 'delete':
                return '<div class="bg-red-100 p-2 rounded-full"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg></div>';
            default:
                return '<div class="bg-gray-100 p-2 rounded-full"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg></div>';
        }
    }
    
    /**
     * Devuelve un texto formateado con el tiempo transcurrido
     */
    public function getTimeAgo()
    {
        return $this->created_at->diffForHumans();
    }
} 