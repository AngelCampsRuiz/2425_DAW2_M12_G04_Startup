<?php
    // RUTAS DE LA APLICACIÓN
    use Illuminate\Support\Facades\Route;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;
    use Illuminate\Support\Facades\Http;
    use Illuminate\Support\Facades\Artisan;
        // CONTROLADORES
            // CONTROLADOR HOME
                use App\Http\Controllers\HomeController;
            // CONTROLADOR DE AUTENTICACIÓN INICIO DE SESIÓN
                use App\Http\Controllers\Auth\LoginController;
            // CONTROLADOR DE AUTENTICACIÓN REGISTRO
                use App\Http\Controllers\Auth\RegisterController;
            // CONTROLADOR DASHBOARD ESTUDIANTE
                use App\Http\Controllers\StudentDashboardController;
            // CONTROLADOR DASHBOARD EMPRESA
                use App\Http\Controllers\CompanyDashboardController;
            // CONTROLADOR ADMINISTRADOR
                use App\Http\Controllers\AdminController;
            // CONTROLADOR ADMINISTRADOR PUBLICACIONES
                use App\Http\Controllers\Admin\PublicacionController;
            // CONTROLADOR DE DEMOSTRACIÓN
                use App\Http\Controllers\DemoController;
            // CONTROLADOR PUBLICACIONES
                use App\Http\Controllers\PublicationController;
            // CONTROLADOR CATEGORÍAS
                use App\Http\Controllers\Admin\CategoriaController;
            // CONTROLADOR API CATEGORÍAS
                use App\Http\Controllers\API\CategoriaController as APICategoriaController;
            // CONTROLADOR SUBCATEGORÍAS
                use App\Http\Controllers\Admin\SubcategoriaController;
            // CONTROLADOR SOLICITUDES
                use App\Http\Controllers\SolicitudController;
            // CONTROLADOR CHAT
                use App\Http\Controllers\ChatController;
            // CONTROLADOR PERFIL
                use App\Http\Controllers\ProfileController;
            // CONTROLADOR VALORACIONES
                use App\Http\Controllers\ValoracionController;
            // CONTROLADOR NOTIFICACIONES
                use App\Http\Controllers\NotificationController;
            // CONTROLADOR DOCENTES
                use App\Http\Controllers\DocenteController;
            // CONTROLADOR DEPARTAMENTOS
                use App\Http\Controllers\DepartamentoController;
            // CONTROLADOR CALENDARIO
                use App\Http\Controllers\CalendarController;
            // CONTROLADOR DE RECORDATORIOS
                use App\Http\Controllers\ReminderController;
            // CONTROLADOR ESTUDIANTE (EMPRESA)
                use App\Http\Controllers\Empresa\EstudianteController;
                use Illuminate\Http\Response;
            // CONTROLADOR DE PAGO DE INSTITUCIONES
                use App\Http\Controllers\InstitucionPaymentController;
            // CONTROLADOR DE EXPERIENCIAS
                use App\Http\Controllers\ExperienciaController;


    Route::get('/run-migrations-safe', function () {
    // Verifica la clave proporcionada
    if (request('key') !== env('DEPLOY_KEY')) {
        abort(403, 'Acceso no autorizado');
    }

    try {
        // Llama a las migraciones si la clave es correcta
        $result = Artisan::call('migrate:fresh --seed --force');
        $output = Artisan::output();

        return response()->json(['message' => 'Migraciones ejecutadas correctamente', 'output' => $output]);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Error al ejecutar migraciones: ' . $e->getMessage()], 500);
    }
});

