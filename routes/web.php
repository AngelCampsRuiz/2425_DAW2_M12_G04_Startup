<?php
    // RUTAS DE LA APLICACIÓN
    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\Controller;
    use App\Http\Controllers\HomeController;
    use App\Http\Controllers\ProfileController;
    use App\Http\Controllers\CalendarController;
    use App\Http\Controllers\CompanyDashboardController;
    use App\Http\Controllers\StudentDashboardController;
    use App\Http\Controllers\TeacherDashboardController;
    use App\Http\Controllers\InstitutionDashboardController;
    use App\Http\Controllers\DemoController;
    use App\Http\Controllers\PublicacionController;
    use App\Http\Controllers\SolicitudController;
    use App\Http\Controllers\DepartamentoController;
    use App\Http\Controllers\ChatController;
    use App\Http\Controllers\ValoracionController;

    // CONTROLADORES
        // CONTROLADOR HOME
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
                    Route::post('/profile/update-location', [ProfileController::class, 'updateLocation'])
                        ->name('profile.update-location');
                
                // PUBLICACIONES VISIBLES PARA TODOS LOS USUARIOS
                    Route::get('/publication/{id}', [PublicationController::class, 'show'])->name('publication.show');

                // RUTAS PARA EL CHAT
                    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
                    Route::get('/chat/{chat}', [ChatController::class, 'showChat'])->name('chat.show');
                    Route::post('/chat/{chat}/message', [ChatController::class, 'sendMessage'])->name('chat.message');
                    Route::get('/chat/{chat}/messages', [ChatController::class, 'getMessages'])->name('chat.messages');
                    Route::post('/chat/create/{solicitud}', [ChatController::class, 'createChat'])->name('chat.create');
                    Route::post('/chat/create-docente', [ChatController::class, 'createDocenteChat'])->name('chat.create.docente');

                // RUTAS PARA VALORACIONES
                    Route::post('/valoraciones', [ValoracionController::class, 'store'])->name('valoraciones.store');
                    Route::get('/valoraciones/convenios/{receptorId}', [ValoracionController::class, 'getConvenios'])->name('valoraciones.getConvenios');
                    Route::put('/valoraciones/{id}', [ValoracionController::class, 'update'])->name('valoraciones.update');
                    Route::delete('/valoraciones/{id}', [ValoracionController::class, 'destroy'])->name('valoraciones.destroy');

                // RUTAS PARA SOLICITUDES
                    Route::post('/solicitudes/{publication}', [SolicitudController::class, 'store'])->name('solicitudes.store');

                // RUTAS PARA NOTIFICACIONES
                    Route::get('/notifications/unread', [NotificationController::class, 'getUnreadNotifications']);
                    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
                    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.read-all');
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
               
                // RUTAS DEL CALENDARIO
                    Route::get('/empresa/calendar', [CalendarController::class, 'index'])->name('empresa.calendar');
                    Route::get('/empresa/calendar/reminders/{reminder}', [CalendarController::class, 'show'])->name('empresa.reminder.show');
                    Route::post('/empresa/calendar/reminders', [CalendarController::class, 'store'])->name('empresa.reminder.store');
                    Route::put('/empresa/calendar/reminders/{reminder}', [CalendarController::class, 'update'])->name('empresa.reminder.update');
                    Route::delete('/empresa/calendar/reminders/{reminder}', [CalendarController::class, 'destroy'])->name('empresa.reminder.destroy');
                    Route::post('/empresa/calendar/reminders/{reminder}/toggle', [CalendarController::class, 'toggleComplete'])->name('empresa.reminder.toggle');

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
                    // RUTA OBTENER SUBCATEGORÍAS POR CATEGORÍA
                        Route::get('subcategorias/por-categoria/{categoriaId}', [SubcategoriaController::class, 'getByCategoria'])->name('subcategorias.por-categoria');
                    // RUTA GESTIONAR SUBCATEGORÍAS
                        Route::resource('subcategorias', SubcategoriaController::class);

                // RUTAS PARA GESTIONAR LAS EMPRESAS
                    // RUTA ELIMINAR SQL
                        Route::delete('empresas/eliminar-sql/{empresa}', [App\Http\Controllers\Admin\EmpresaController::class, 'destroySQL'])->name('empresas.destroySQL');
                    // RUTA GESTIONAR EMPRESAS
                        Route::resource('empresas', App\Http\Controllers\Admin\EmpresaController::class);

                // Rutas de Publicaciones
                Route::get('/publicaciones', [App\Http\Controllers\Admin\PublicacionController::class, 'index'])->name('publicaciones.index');
                Route::post('/publicaciones', [App\Http\Controllers\Admin\PublicacionController::class, 'store'])->name('publicaciones.store');
                Route::get('/publicaciones/{publicacion}/edit', [App\Http\Controllers\Admin\PublicacionController::class, 'edit'])->name('publicaciones.edit');
                Route::put('/publicaciones/{publicacion}', [App\Http\Controllers\Admin\PublicacionController::class, 'update'])->name('publicaciones.update');
                Route::delete('/publicaciones/{publicacion}', [App\Http\Controllers\Admin\PublicacionController::class, 'destroy'])->name('publicaciones.destroy');
                Route::delete('/publicaciones/eliminar-sql/{publicacion}', [App\Http\Controllers\Admin\PublicacionController::class, 'destroySQL'])->name('publicaciones.destroySQL');
                Route::get('publicaciones/subcategorias/{categoriaId}', [PublicacionController::class, 'getSubcategorias'])->name('publicaciones.subcategorias');
            });

        // Footer resource pages
        Route::get('/help-center', [App\Http\Controllers\ResourceController::class, 'helpCenter'])->name('help.center');
        Route::get('/student-guides', [App\Http\Controllers\ResourceController::class, 'studentGuides'])->name('student.guides');
        Route::get('/company-resources', [App\Http\Controllers\ResourceController::class, 'companyResources'])->name('company.resources');
        Route::get('/terms-conditions', [App\Http\Controllers\ResourceController::class, 'termsConditions'])->name('terms.conditions');
        Route::get('/privacy-policy', [App\Http\Controllers\ResourceController::class, 'privacyPolicy'])->name('privacy.policy');
        Route::get('/blog', [App\Http\Controllers\ResourceController::class, 'blog'])->name('blog');

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
        Route::get('/docentes/{id}/get-data', [App\Http\Controllers\DocenteController::class, 'getData'])->name('docentes.get-data');

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
        Route::get('/departamentos/{id}/get-data', [App\Http\Controllers\DepartamentoController::class, 'getData'])->name('departamentos.get-data');

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

    // Rutas para estudiantes
    Route::middleware(['auth', \App\Http\Middleware\CheckRole::class.':student'])->prefix('estudiante')->name('estudiante.')->group(function () {
        // Solicitudes del estudiante
        Route::get('/solicitudes', [App\Http\Controllers\Estudiante\SolicitudController::class, 'index'])->name('solicitudes.index');
        Route::get('/solicitudes/{id}', [App\Http\Controllers\Estudiante\SolicitudController::class, 'show'])->name('solicitudes.show');
        Route::post('/solicitudes/{id}/cancelar', [App\Http\Controllers\Estudiante\SolicitudController::class, 'cancelar'])->name('solicitudes.cancelar');
        
        // Rutas AJAX para solicitudes
        Route::get('/api/solicitudes', [App\Http\Controllers\Estudiante\SolicitudAjaxController::class, 'getSolicitudes'])->name('api.solicitudes');
        Route::get('/api/solicitudes/{id}', [App\Http\Controllers\Estudiante\SolicitudAjaxController::class, 'getSolicitud'])->name('api.solicitudes.show');
        Route::post('/api/solicitudes/{id}/cancelar', [App\Http\Controllers\Estudiante\SolicitudAjaxController::class, 'cancelarSolicitud'])->name('api.solicitudes.cancelar');
    });

    // RUTAS PARA DOCENTES
    Route::prefix('docente')->middleware(['auth', \App\Http\Middleware\CheckRole::class.':docente'])->name('docente.')->group(function () {
        // Dashboard
        Route::get('/dashboard', [App\Http\Controllers\DocenteController::class, 'dashboard'])->name('dashboard');

        // Alumnos
        Route::get('/alumnos', [App\Http\Controllers\DocenteController::class, 'alumnos'])->name('alumnos.index');
        Route::get('/alumnos/{id}', [App\Http\Controllers\DocenteController::class, 'showAlumno'])->name('alumnos.show');

        // Clases
        Route::get('/clases', [App\Http\Controllers\DocenteController::class, 'clases'])->name('clases.index');
        Route::get('/clases/{id}', [App\Http\Controllers\DocenteController::class, 'showClase'])->name('clases.show');
        Route::get('/clases/{id}/alumnos', [App\Http\Controllers\DocenteController::class, 'clasesAlumnos'])->name('clases.alumnos');

        // Solicitudes
        Route::get('/solicitudes', [App\Http\Controllers\DocenteController::class, 'solicitudes'])->name('solicitudes.index');
        Route::get('/solicitudes/{id}', [App\Http\Controllers\DocenteController::class, 'showSolicitud'])->name('solicitudes.show');
        Route::post('/solicitudes/{id}/aprobar', [App\Http\Controllers\DocenteController::class, 'aprobarSolicitud'])->name('solicitudes.aprobar');
        Route::post('/solicitudes/{id}/rechazar', [App\Http\Controllers\DocenteController::class, 'rechazarSolicitud'])->name('solicitudes.rechazar');
    });
