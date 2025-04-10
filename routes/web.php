<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\StudentDashboardController;
use App\Http\Controllers\CompanyDashboardController;
use App\Http\Controllers\CompanyDashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\PublicacionController;
use App\Http\Controllers\DemoController;
use App\Http\Controllers\PublicationController;

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

    Route::middleware(['auth'])->group(function () {
        Route::get('/student/dashboard', [StudentDashboardController::class, 'index'])->name('student.dashboard');
        Route::post('/toggle-favorite/{publicationId}', [StudentDashboardController::class, 'toggleFavorite'])->name('toggle-favorite');
        Route::get('/profile', [HomeController::class, 'profile'])->name('profile');
        Route::get('/profile/{id}', [HomeController::class, 'profile'])->name('profile.view');
    });

// RUTAS PROTEGIDAS PARA EMPRESAS
Route::middleware(['auth'])->group(function () {
    Route::get('/empresa/dashboard', [CompanyDashboardController::class, 'index'])->name('empresa.dashboard');
    Route::get('/empresa/ofertas/crear', [CompanyDashboardController::class, 'createOffer'])->name('empresa.offers.create');
    Route::post('/empresa/ofertas', [CompanyDashboardController::class, 'storeOffer'])->name('empresa.offers.store');
    Route::get('/empresa/ofertas/{publication}/solicitudes', [CompanyDashboardController::class, 'viewApplications'])->name('empresa.applications.view');
    Route::post('/empresa/ofertas/{publication}/toggle', [CompanyDashboardController::class, 'togglePublicationStatus'])->name('empresa.offers.toggle');
    Route::put('/empresa/ofertas/{publication}/solicitudes/{application}', [CompanyDashboardController::class, 'updateApplicationStatus'])->name('empresa.applications.update');
    Route::get('/empresa/get-subcategorias/{categoria}', [CompanyDashboardController::class, 'getSubcategorias'])->name('empresa.subcategorias');
});

// RUTAS PROTEGIDAS PARA EMPRESAS
Route::middleware(['auth'])->group(function () {
    Route::get('/empresa/dashboard', [CompanyDashboardController::class, 'index'])->name('empresa.dashboard');
});

// RUTAS PROTEGIDAS PARA ADMINISTRADORES
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

    // Rutas para gestionar las publicaciones
    Route::resource('publicaciones', PublicacionController::class);
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
});

// Test route without custom middleware
Route::get('/test-dashboard', [StudentDashboardController::class, 'index'])->name('test.dashboard');

Route::get('/publication/{id}', [PublicationController::class, 'show'])->name('publication.show');