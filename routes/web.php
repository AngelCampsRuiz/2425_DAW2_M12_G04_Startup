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
                // RUTA INFORMACIÓN ESPECÍFICA SEGÚN ROL
                    Route::get('/register/institucion', [RegisterController::class, 'showInstitutionRegistrationForm'])->name('register.institucion');
                // RUTA INFORMACIÓN ESPECÍFICA SEGÚN ROL
                    Route::post('/register/institucion', [RegisterController::class, 'registerInstitution'])->name('institution.register');

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
                        Route::get('categorias/{categoria}/subcategorias', [CategoriaController::class, 'getSubcategorias'])->name('categorias.subcategorias');

                // RUTAS PARA GESTIONAR LAS SUBCATEGORÍAS
                    // RUTA COMPROBAR PUBLICACIONES
                        Route::get('subcategorias/check/{id}', [SubcategoriaController::class, 'checkPublicaciones'])->name('subcategorias.check');
                    // RUTA ELIMINAR DIRECTAMENTE
                        Route::delete('subcategorias/delete-directo/{id}', [SubcategoriaController::class, 'deleteDirecto'])->name('subcategorias.delete-directo');
                    // RUTA ELIMINAR SQL
                        Route::post('subcategorias/eliminar-sql/{id}', [SubcategoriaController::class, 'deleteDirecto'])->name('subcategorias.eliminar-sql');
                    // RUTA OBTENER SUBCATEGORÍAS POR CATEGORÍA
                        Route::get('subcategorias/por-categoria/{categoriaId}', [SubcategoriaController::class, 'getByCategoria'])->name('subcategorias.por-categoria');
                    // RUTA GESTIONAR SUBCATEGORÍAS
                        Route::resource('subcategorias', SubcategoriaController::class);

                // RUTAS PARA GESTIONAR LAS EMPRESAS
                    // RUTA ELIMINAR SQL
                        Route::delete('empresas/eliminar-sql/{empresa}', [App\Http\Controllers\Admin\EmpresaController::class, 'destroySQL'])->name('empresas.destroySQL');
                    // RUTA GESTIONAR EMPRESAS
                        Route::resource('empresas', App\Http\Controllers\Admin\EmpresaController::class);

                // RUTAS PARA GESTIONAR LOS PROFESORES
                    Route::get('profesores', [App\Http\Controllers\Admin\ProfesorController::class, 'index'])->name('profesores.index');
                    Route::post('profesores', [App\Http\Controllers\Admin\ProfesorController::class, 'store'])->name('profesores.store');
                    Route::get('profesores/{profesor}/edit', [App\Http\Controllers\Admin\ProfesorController::class, 'edit'])->name('profesores.edit');
                    Route::put('profesores/{profesor}', [App\Http\Controllers\Admin\ProfesorController::class, 'update'])->name('profesores.update');
                    Route::delete('profesores/{profesor}', [App\Http\Controllers\Admin\ProfesorController::class, 'destroy'])->name('profesores.destroy');
                    Route::delete('profesores/eliminar-sql/{profesor}', [App\Http\Controllers\Admin\ProfesorController::class, 'eliminarSQL'])->name('profesores.eliminar-sql');

                // Rutas de Publicaciones
                Route::get('/publicaciones', [App\Http\Controllers\Admin\PublicacionController::class, 'index'])->name('publicaciones.index');
                Route::post('/publicaciones', [App\Http\Controllers\Admin\PublicacionController::class, 'store'])->name('publicaciones.store');
                Route::get('/publicaciones/{publicacion}/edit', [App\Http\Controllers\Admin\PublicacionController::class, 'edit'])->name('publicaciones.edit');
                Route::put('/publicaciones/{publicacion}', [App\Http\Controllers\Admin\PublicacionController::class, 'update'])->name('publicaciones.update');
                Route::delete('/publicaciones/{publicacion}', [App\Http\Controllers\Admin\PublicacionController::class, 'destroy'])->name('publicaciones.destroy');
                Route::delete('/publicaciones/eliminar-sql/{publicacion}', [App\Http\Controllers\Admin\PublicacionController::class, 'destroySQL'])->name('publicaciones.destroySQL');
                Route::get('publicaciones/subcategorias/{categoriaId}', [PublicacionController::class, 'getSubcategorias'])->name('publicaciones.subcategorias');

                // RUTAS PARA GESTIONAR LOS ALUMNOS
                Route::get('alumnos', [App\Http\Controllers\Admin\AlumnoController::class, 'index'])->name('alumnos.index');
                Route::post('alumnos', [App\Http\Controllers\Admin\AlumnoController::class, 'store'])->name('alumnos.store');
                Route::get('alumnos/{alumno}/edit', [App\Http\Controllers\Admin\AlumnoController::class, 'edit'])->name('alumnos.edit');
                Route::put('alumnos/{alumno}', [App\Http\Controllers\Admin\AlumnoController::class, 'update'])->name('alumnos.update');
                Route::delete('alumnos/{alumno}', [App\Http\Controllers\Admin\AlumnoController::class, 'destroy'])->name('alumnos.destroy');
                Route::delete('alumnos/eliminar-sql/{alumno}', [App\Http\Controllers\Admin\AlumnoController::class, 'destroySQL'])->name('alumnos.destroySQL');
            });

        Route::post('/set-locale', [App\Http\Controllers\LocaleController::class, 'setLocale'])->name('set-locale');

    // RUTAS PARA INSTITUCIONES
    Route::prefix('institucion')->middleware(['auth', \App\Http\Middleware\CheckRole::class.':institucion'])->name('institucion.')->group(function () {
        // Dashboard
        Route::get('/dashboard', [App\Http\Controllers\InstitucionController::class, 'dashboard'])->name('dashboard');
        
        // Perfil
        Route::get('/perfil', [App\Http\Controllers\InstitucionController::class, 'perfil'])->name('perfil');
        Route::put('/perfil', [App\Http\Controllers\InstitucionController::class, 'actualizarPerfil'])->name('perfil.update');
        Route::put('/perfil/password', [App\Http\Controllers\InstitucionController::class, 'cambiarPassword'])->name('perfil.password');
        
        // Docentes
        Route::get('/docentes', [App\Http\Controllers\DocenteController::class, 'index'])->name('docentes.index');
        Route::get('/docentes/create', [App\Http\Controllers\DocenteController::class, 'create'])->name('docentes.create');
        Route::post('/docentes', [App\Http\Controllers\DocenteController::class, 'store'])->name('docentes.store');
        Route::get('/docentes/{id}', [App\Http\Controllers\DocenteController::class, 'show'])->name('docentes.show');
        Route::get('/docentes/{id}/edit', [App\Http\Controllers\DocenteController::class, 'edit'])->name('docentes.edit');
        Route::put('/docentes/{id}', [App\Http\Controllers\DocenteController::class, 'update'])->name('docentes.update');
        Route::delete('/docentes/{id}', [App\Http\Controllers\DocenteController::class, 'destroy'])->name('docentes.destroy');
        Route::post('/docentes/{id}/toggle-active', [App\Http\Controllers\DocenteController::class, 'toggleActive'])->name('docentes.toggle-active');
        Route::post('/docentes/{id}/reset-password', [App\Http\Controllers\DocenteController::class, 'resetPassword'])->name('docentes.reset-password');
        
        // Departamentos
        Route::get('/departamentos', [App\Http\Controllers\DepartamentoController::class, 'index'])->name('departamentos.index');
        Route::get('/departamentos/create', [App\Http\Controllers\DepartamentoController::class, 'create'])->name('departamentos.create');
        Route::post('/departamentos', [App\Http\Controllers\DepartamentoController::class, 'store'])->name('departamentos.store');
        Route::get('/departamentos/{id}', [App\Http\Controllers\DepartamentoController::class, 'show'])->name('departamentos.show');
        Route::get('/departamentos/{id}/edit', [App\Http\Controllers\DepartamentoController::class, 'edit'])->name('departamentos.edit');
        Route::put('/departamentos/{id}', [App\Http\Controllers\DepartamentoController::class, 'update'])->name('departamentos.update');
        Route::delete('/departamentos/{id}', [App\Http\Controllers\DepartamentoController::class, 'destroy'])->name('departamentos.destroy');
        Route::get('/departamentos/{id}/asignar-docentes', [App\Http\Controllers\DepartamentoController::class, 'asignarDocentes'])->name('departamentos.asignar-docentes');
        Route::post('/departamentos/{id}/asignar-docentes', [App\Http\Controllers\DepartamentoController::class, 'guardarAsignacionDocentes'])->name('departamentos.guardar-asignacion-docentes');
        
        // Clases
        Route::get('/clases', [App\Http\Controllers\ClaseController::class, 'index'])->name('clases.index');
        Route::get('/clases/create', [App\Http\Controllers\ClaseController::class, 'create'])->name('clases.create');
        Route::post('/clases', [App\Http\Controllers\ClaseController::class, 'store'])->name('clases.store');
        Route::get('/clases/{id}', [App\Http\Controllers\ClaseController::class, 'show'])->name('clases.show');
        Route::get('/clases/{id}/edit', [App\Http\Controllers\ClaseController::class, 'edit'])->name('clases.edit');
        Route::put('/clases/{id}', [App\Http\Controllers\ClaseController::class, 'update'])->name('clases.update');
        Route::delete('/clases/{id}', [App\Http\Controllers\ClaseController::class, 'destroy'])->name('clases.destroy');
        Route::post('/clases/{id}/toggle-active', [App\Http\Controllers\ClaseController::class, 'toggleActive'])->name('clases.toggle-active');
        Route::get('/clases/{id}/asignar-estudiantes', [App\Http\Controllers\ClaseController::class, 'asignarEstudiantes'])->name('clases.asignar-estudiantes');
        Route::post('/clases/{id}/asignar-estudiantes', [App\Http\Controllers\ClaseController::class, 'guardarAsignacionEstudiantes'])->name('clases.guardar-asignacion-estudiantes');
        
        // Solicitudes de estudiantes
        Route::get('/solicitudes', [App\Http\Controllers\SolicitudEstudianteController::class, 'index'])->name('solicitudes.index');
        Route::get('/solicitudes/{id}', [App\Http\Controllers\SolicitudEstudianteController::class, 'show'])->name('solicitudes.show');
        Route::post('/solicitudes/{id}/aprobar', [App\Http\Controllers\SolicitudEstudianteController::class, 'aprobar'])->name('solicitudes.aprobar');
        Route::post('/solicitudes/{id}/rechazar', [App\Http\Controllers\SolicitudEstudianteController::class, 'rechazar'])->name('solicitudes.rechazar');
        
        // Asignación de clases a estudiantes tras aprobar solicitudes
        Route::get('/solicitudes/{solicitud}/asignar-clase', [App\Http\Controllers\Institucion\SolicitudClaseController::class, 'asignar'])->name('solicitudes.asignar-clase');
        Route::post('/solicitudes/{solicitud}/asignar-clase', [App\Http\Controllers\Institucion\SolicitudClaseController::class, 'store'])->name('solicitudes.asignar-clase.store');
    });