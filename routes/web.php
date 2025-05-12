<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

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
