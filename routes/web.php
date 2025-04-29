<?php
    // RUTAS DE LA APLICACIÓN
    use Illuminate\Support\Facades\Route;
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

    // RUTAS DE LA APLICACIÓN
        // RUTA PRINCIPAL HOME
            Route::get('/', [HomeController::class, 'index'])->name('home');

        // RUTAS DE DEMOSTRACIÓN
            Route::get('/demo/student', [DemoController::class, 'demoStudent'])->name('demo.student');
            Route::get('/demo/company', [DemoController::class, 'demoCompany'])->name('demo.company');
            Route::get('/demo/redirect', [DemoController::class, 'redirectToRegister'])->name('demo.redirect');

        // AUTENTICACIÓN
            // RUTA INICIO DE SESIÓN
                Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
            // RUTA INICIO DE SESIÓN
                Route::post('/login', [LoginController::class, 'login']);
            // RUTA CIERRE DE SESIÓN
                Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

        // RUTAS DE REGISTRO
            // RUTA REGISTRO
                Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
            // RUTA REGISTRO
                Route::post('/register', [RegisterController::class, 'register']);

        // RUTAS DE REGISTRO POR PASOS
            // PASO 2: INFORMACIÓN PERSONAL
                // RUTA INFORMACIÓN PERSONAL
                    Route::get('/register/personal', [RegisterController::class, 'showPersonalInfoForm'])->name('register.personal');
                // RUTA INFORMACIÓN PERSONAL
                    Route::post('/register/personal', [RegisterController::class, 'registerPersonalInfo'])->name('register.personal.post');

            // PASO 3: INFORMACIÓN ESPECÍFICA SEGÚN ROL
                // RUTA INFORMACIÓN ESPECÍFICA SEGÚN ROL
                    Route::get('/register/alumno', [RegisterController::class, 'showStudentRegistrationForm'])->name('register.alumno');
                // RUTA INFORMACIÓN ESPECÍFICA SEGÚN ROL
                    Route::post('/register/alumno', [RegisterController::class, 'registerStudent'])->name('register.student.submit');
                // RUTA INFORMACIÓN ESPECÍFICA SEGÚN ROL
                    Route::get('/register/empresa', [RegisterController::class, 'showCompanyRegistrationForm'])->name('register.empresa');
                // RUTA INFORMACIÓN ESPECÍFICA SEGÚN ROL
                    Route::post('/register/empresa', [RegisterController::class, 'registerCompany'])->name('company.register');

        // RUTAS GENERALES ACCESIBLES PARA TODOS LOS USUARIOS AUTENTICADOS
            Route::middleware(['auth'])->group(function () {
                // RUTA ACTUALIZAR VISIBILIDAD
                    Route::post('/update-visibility', [HomeController::class, 'updateVisibility']);

                // RUTAS DE PERFIL
                    Route::get('/profile', [HomeController::class, 'profile'])->name('profile');
                    Route::get('/profile/{id}', [HomeController::class, 'profile'])->name('profile.view');
                    Route::get('/profile/{user}', [ProfileController::class, 'show'])->name('profile.show');
                    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

                // PUBLICACIONES VISIBLES PARA TODOS LOS USUARIOS
                    Route::get('/publication/{id}', [PublicationController::class, 'show'])->name('publication.show');

                // RUTAS PARA EL CHAT
                    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
                    Route::get('/chat/{chat}', [ChatController::class, 'showChat'])->name('chat.show');
                    Route::post('/chat/{chat}/message', [ChatController::class, 'sendMessage'])->name('chat.message');
                    Route::get('/chat/{chat}/messages', [ChatController::class, 'getMessages'])->name('chat.messages');
                    Route::post('/chat/create/{solicitud}', [ChatController::class, 'createChat'])->name('chat.create');

                // RUTAS PARA VALORACIONES
                    Route::post('/valoraciones', [ValoracionController::class, 'store'])->name('valoraciones.store');
                    Route::get('/valoraciones/convenios/{receptorId}', [ValoracionController::class, 'getConvenios'])->name('valoraciones.getConvenios');
                    Route::put('/valoraciones/{id}', [ValoracionController::class, 'update'])->name('valoraciones.update');
                    Route::delete('/valoraciones/{id}', [ValoracionController::class, 'destroy'])->name('valoraciones.destroy');

                // RUTAS PARA SOLICITUDES
                    Route::post('/solicitudes/{publication}', [SolicitudController::class, 'store'])->name('solicitudes.store');
            });

        // RUTAS PROTEGIDAS PARA ESTUDIANTES
                Route::middleware(['auth', \App\Http\Middleware\CheckRole::class.':student'])->group(function () {
                    Route::get('/student/dashboard', [StudentDashboardController::class, 'index'])->name('student.dashboard');
                });

        // RUTAS PROTEGIDAS PARA EMPRESAS
            Route::middleware(['auth', \App\Http\Middleware\CheckRole::class.':empresa'])->group(function () {
                // RUTA DASHBOARD EMPRESA
                    Route::get('/empresa/dashboard', [CompanyDashboardController::class, 'index'])->name('empresa.dashboard');
                // RUTA CREAR OFERTA
                    Route::get('/empresa/ofertas/crear', [CompanyDashboardController::class, 'createOffer'])->name('empresa.offers.create');
                // RUTA CREAR OFERTA
                    Route::post('/empresa/ofertas', [CompanyDashboardController::class, 'storeOffer'])->name('empresa.offers.store');
                // RUTA VER SOLICITUDES
                    Route::get('/empresa/ofertas/{publication}/solicitudes', [CompanyDashboardController::class, 'viewApplications'])->name('empresa.applications.view');
                // RUTA CAMBIAR ESTADO DE PUBLICACIÓN
                    Route::post('/empresa/ofertas/{publication}/toggle', [CompanyDashboardController::class, 'togglePublicationStatus'])->name('empresa.offers.toggle');
                // RUTA ACTUALIZAR ESTADO DE SOLICITUD
                    Route::put('/empresa/ofertas/{publication}/solicitudes/{application}', [CompanyDashboardController::class, 'updateApplicationStatus'])->name('empresa.applications.update');
                // RUTA OBTENER SUBCATEGORÍAS
                    Route::get('/empresa/get-subcategorias/{categoria}', [CompanyDashboardController::class, 'getSubcategorias'])
                        ->name('empresa.subcategorias');
            });

        // RUTAS PROTEGIDAS PARA ADMINISTRADORES
            Route::middleware(['auth', \App\Http\Middleware\CheckRole::class.':admin'])->prefix('admin')->name('admin.')->group(function () {
                Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

                // RUTAS PARA GESTIONAR LAS PUBLICACIONES
                    // RUTA GESTIONAR PUBLICACIONES
                        Route::resource('publicaciones', PublicacionController::class);

                // RUTAS PARA GESTIONAR LAS CATEGORÍAS
                    // RUTA GESTIONAR CATEGORÍAS
                        Route::resource('categorias', CategoriaController::class);

                // RUTAS PARA GESTIONAR LAS SUBCATEGORÍAS
                    // RUTA COMPROBAR PUBLICACIONES
                        Route::get('subcategorias/check/{id}', [SubcategoriaController::class, 'checkPublicaciones'])->name('subcategorias.check');
                    // RUTA ELIMINAR DIRECTAMENTE
                        Route::delete('subcategorias/delete-directo/{id}', [SubcategoriaController::class, 'deleteDirecto'])->name('subcategorias.delete-directo');
                    // RUTA ELIMINAR SQL
                        Route::post('subcategorias/eliminar-sql/{id}', [SubcategoriaController::class, 'deleteDirecto'])->name('subcategorias.eliminar-sql');
                    // RUTA GESTIONAR SUBCATEGORÍAS
                        Route::resource('subcategorias', SubcategoriaController::class);
            });

        Route::post('/set-locale', [App\Http\Controllers\LocaleController::class, 'setLocale'])->name('set-locale');
