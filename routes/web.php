<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\StudentDashboardController;
use App\Http\Controllers\CompanyDashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\PublicacionController;
use App\Http\Controllers\DemoController;
use App\Http\Controllers\PublicationController;
use App\Http\Controllers\Admin\CategoriaController;
use App\Http\Controllers\Admin\SubcategoriaController;
use App\Http\Controllers\SolicitudController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ValoracionController;

// Ruta principal usando el HomeController
Route::get('/', [HomeController::class, 'index'])->name('home');

// Rutas de demostración
Route::get('/demo/student', [DemoController::class, 'demoStudent'])->name('demo.student');
Route::get('/demo/company', [DemoController::class, 'demoCompany'])->name('demo.company');
Route::get('/demo/redirect', [DemoController::class, 'redirectToRegister'])->name('demo.redirect');

// AUTENTICACIÓN
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Rutas de registro generales
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Rutas de registro por pasos
// Paso 2: Información personal
Route::get('/register/personal', [RegisterController::class, 'showPersonalInfoForm'])->name('register.personal');
Route::post('/register/personal', [RegisterController::class, 'registerPersonalInfo'])->name('register.personal.post');

// Paso 3: Información específica según rol
Route::get('/register/alumno', [RegisterController::class, 'showStudentRegistrationForm'])->name('register.alumno');
Route::post('/register/alumno', [RegisterController::class, 'registerStudent']);
Route::get('/register/empresa', [RegisterController::class, 'showCompanyRegistrationForm'])->name('register.empresa');
Route::post('/register/empresa', [RegisterController::class, 'registerCompany']);

// Rutas generales accesibles para todos los usuarios autenticados
Route::middleware(['auth'])->group(function () {
    Route::post('/update-visibility', [HomeController::class, 'updateVisibility']);
    
    // Rutas de perfil
    Route::get('/profile', [HomeController::class, 'profile'])->name('profile');
    Route::get('/profile/{id}', [HomeController::class, 'profile'])->name('profile.view');
    Route::get('/profile/{user}', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    
    // Publicaciones visibles para todos los usuarios
    Route::get('/publication/{id}', [PublicationController::class, 'show'])->name('publication.show');
    
    // Rutas para el chat
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::get('/chat/{chat}', [ChatController::class, 'showChat'])->name('chat.show');
    Route::post('/chat/{chat}/message', [ChatController::class, 'sendMessage'])->name('chat.message');
    Route::get('/chat/{chat}/messages', [ChatController::class, 'getMessages'])->name('chat.messages');
    Route::post('/chat/create/{solicitud}', [ChatController::class, 'createChat'])->name('chat.create');
    
    // Rutas para valoraciones
    Route::post('/valoraciones', [ValoracionController::class, 'store'])->name('valoraciones.store');
    Route::get('/valoraciones/convenios/{receptorId}', [ValoracionController::class, 'getConvenios'])->name('valoraciones.getConvenios');
    Route::put('/valoraciones/{id}', [ValoracionController::class, 'update'])->name('valoraciones.update');
    Route::delete('/valoraciones/{id}', [ValoracionController::class, 'destroy'])->name('valoraciones.destroy');
    
    // Solicitudes
    Route::post('/solicitudes/{publication}', [SolicitudController::class, 'store'])->name('solicitudes.store');
});

// RUTAS PROTEGIDAS PARA ESTUDIANTES
Route::middleware(['auth', \App\Http\Middleware\CheckRole::class.':student'])->group(function () {
    Route::get('/student/dashboard', [StudentDashboardController::class, 'index'])->name('student.dashboard');
    // Otras rutas específicas de estudiantes
});

// RUTAS PROTEGIDAS PARA EMPRESAS
Route::middleware(['auth', \App\Http\Middleware\CheckRole::class.':empresa'])->group(function () {
    Route::get('/empresa/dashboard', [CompanyDashboardController::class, 'index'])->name('empresa.dashboard');
    Route::get('/empresa/ofertas/crear', [CompanyDashboardController::class, 'createOffer'])->name('empresa.offers.create');
    Route::post('/empresa/ofertas', [CompanyDashboardController::class, 'storeOffer'])->name('empresa.offers.store');
    Route::get('/empresa/ofertas/{publication}/solicitudes', [CompanyDashboardController::class, 'viewApplications'])->name('empresa.applications.view');
    Route::post('/empresa/ofertas/{publication}/toggle', [CompanyDashboardController::class, 'togglePublicationStatus'])->name('empresa.offers.toggle');
    Route::put('/empresa/ofertas/{publication}/solicitudes/{application}', [CompanyDashboardController::class, 'updateApplicationStatus'])->name('empresa.applications.update');
    Route::get('/empresa/get-subcategorias/{categoria}', [CompanyDashboardController::class, 'getSubcategorias'])
        ->name('empresa.subcategorias');
});

// RUTAS PROTEGIDAS PARA ADMINISTRADORES
Route::middleware(['auth', \App\Http\Middleware\CheckRole::class.':admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

    // Rutas para gestionar las publicaciones
    Route::resource('publicaciones', PublicacionController::class);

    // Rutas de categorías
    Route::resource('categorias', CategoriaController::class);

    // Rutas de subcategorías
    Route::get('subcategorias/check/{id}', [SubcategoriaController::class, 'checkPublicaciones'])->name('subcategorias.check');
    Route::delete('subcategorias/delete-directo/{id}', [SubcategoriaController::class, 'deleteDirecto'])->name('subcategorias.delete-directo');
    Route::post('subcategorias/eliminar-sql/{id}', [SubcategoriaController::class, 'deleteDirecto'])->name('subcategorias.eliminar-sql');
    Route::resource('subcategorias', SubcategoriaController::class);
});
