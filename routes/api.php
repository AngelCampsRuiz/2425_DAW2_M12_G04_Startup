<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\CategoriaController;
use App\Http\Controllers\API\LocationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Ruta para obtener categorías por niveles educativos
Route::post('/categorias-por-niveles', [CategoriaController::class, 'getCategoriasPorNiveles']); 

// Rutas para ubicaciones geográficas
Route::get('/provincias', [LocationController::class, 'getProvincias'])->name('api.provincias');
Route::get('/ciudades', [LocationController::class, 'getCiudades'])->name('api.ciudades');
Route::get('/instituciones/{ciudad?}', [LocationController::class, 'getInstituciones'])->name('api.instituciones');
Route::get('/niveles-educativos/{institucion_id?}', [LocationController::class, 'getNivelesEducativos'])->name('api.niveles_educativos'); 