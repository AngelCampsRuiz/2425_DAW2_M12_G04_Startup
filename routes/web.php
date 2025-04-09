<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\StudentDashboardController;
use App\Http\Controllers\AdminController;
// Ruta principal usando el HomeController
    Route::get('/', [HomeController::class, 'index'])->name('home');

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

// RUTAS PROTEGIDAS PARA ESTUDIANTES
Route::middleware(['auth'])->group(function () {
    Route::get('/student/dashboard', [StudentDashboardController::class, 'index'])->name('student.dashboard');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', action: [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/empresa/dashboard', action: [AdminController::class, 'index'])->name('empresa.dashboard');
});

// Test route without custom middleware
Route::get('/test-dashboard', [StudentDashboardController::class, 'index'])->name('test.dashboard');