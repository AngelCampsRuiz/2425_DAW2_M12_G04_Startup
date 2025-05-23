{{-- FOOTER --}}
<footer class="bg-gradient-to-tr from-primary/5 to-primary/15 pt-16 pb-12 relative overflow-hidden">
    <!-- Elementos decorativos -->
    <div class="absolute top-0 right-0 w-40 h-40 bg-primary/5 rounded-full -mr-20 -mt-20"></div>
    <div class="absolute bottom-0 left-0 w-64 h-64 bg-primary/5 rounded-full -ml-32 -mb-32"></div>

    <div class="container mx-auto px-4 relative z-10">

        <!-- Main Footer Content -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10">
            <!-- Logo y descripción -->
            <div class="col-span-1 lg:col-span-1">
                <div class="flex items-center">
                    <a href="{{ url('/') }}" class="transition hover:opacity-80 transform hover:scale-105 duration-300">
                        <img src="{{ asset('assets/images/logo.svg') }}" alt="NextGen Logo" class="h-12">
                    </a>
                    <span class="ml-3 font-bold text-primary text-xl">NextGen</span>
                </div>
                <p class="mt-5 text-gray-600 leading-relaxed">Plataforma innovadora que conecta el talento estudiantil con oportunidades profesionales en empresas de vanguardia. Transformando el futuro laboral desde las aulas.</p>

                <!-- Redes sociales -->
                <div class="mt-6 flex space-x-4">
                    <a href="#" class="text-primary hover:text-primary-dark transition bg-white p-2 rounded-full shadow-sm hover:shadow-md transform hover:scale-110 duration-300" aria-label="Facebook">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z"/>
                        </svg>
                    </a>
                    <a href="#" class="text-primary hover:text-primary-dark transition bg-white p-2 rounded-full shadow-sm hover:shadow-md transform hover:scale-110 duration-300" aria-label="Twitter">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                        </svg>
                    </a>
                    <a href="#" class="text-primary hover:text-primary-dark transition bg-white p-2 rounded-full shadow-sm hover:shadow-md transform hover:scale-110 duration-300" aria-label="LinkedIn">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M4.98 3.5c0 1.381-1.11 2.5-2.48 2.5s-2.48-1.119-2.48-2.5c0-1.38 1.11-2.5 2.48-2.5s2.48 1.12 2.48 2.5zm.02 4.5h-5v16h5v-16zm7.982 0h-4.968v16h4.969v-8.399c0-4.67 6.029-5.052 6.029 0v8.399h4.988v-10.131c0-7.88-8.922-7.593-11.018-3.714v-2.155z"/>
                        </svg>
                    </a>
                    <a href="#" class="text-primary hover:text-primary-dark transition bg-white p-2 rounded-full shadow-sm hover:shadow-md transform hover:scale-110 duration-300" aria-label="Instagram">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                        </svg>
                    </a>
                </div>

                <!-- Estadísticas -->
                <div class="mt-8 grid grid-cols-3 gap-2 bg-white/80 rounded-lg p-4 shadow-sm backdrop-blur-sm">
                    <div class="text-center">
                        <span class="block text-primary font-bold text-xl">1200+</span>
                        <span class="text-xs text-gray-500">Estudiantes</span>
                    </div>
                    <div class="text-center">
                        <span class="block text-primary font-bold text-xl">500+</span>
                        <span class="text-xs text-gray-500">Empresas</span>
                    </div>
                    <div class="text-center">
                        <span class="block text-primary font-bold text-xl">350+</span>
                        <span class="text-xs text-gray-500">Conexiones</span>
                    </div>
                </div>
            </div>

            <!-- Enlaces rápidos -->
            <div class="col-span-1">
                <h3 class="text-lg font-semibold text-primary mb-5 border-b border-primary/20 pb-2">Enlaces rápidos</h3>
                <ul class="space-y-3">
                    <li>
                        <a href="{{ route('home') }}" class="group flex items-center text-gray-600 hover:text-primary transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-primary/70 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                            Inicio
                        </a>
                    </li>
                    <li>
                        <a href="#" class="group flex items-center text-gray-600 hover:text-primary transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-primary/70 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                            Ofertas de empleo
                        </a>
                    </li>
                    <li>
                        <a href="#" class="group flex items-center text-gray-600 hover:text-primary transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-primary/70 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                            Perfiles de estudiantes
                        </a>
                    </li>
                    <li>
                        <a href="#" class="group flex items-center text-gray-600 hover:text-primary transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-primary/70 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                            Empresas colaboradoras
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('blog') }}" class="group flex items-center text-gray-600 hover:text-primary transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-primary/70 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                            Blog
                        </a>
                    </li>
                </ul>

                <!-- Aplicación móvil -->
                <div class="mt-8 bg-white/80 rounded-lg p-4 shadow-sm backdrop-blur-sm">
                    <h4 class="font-semibold text-primary text-sm mb-2">Descarga nuestra app</h4>
                    <div class="flex space-x-2">
                        <a href="#" class="block">
                            <img src="https://placehold.co/90x30/7705B6/FFFFFF?text=App+Store" alt="App Store" class="h-8 rounded-md hover:opacity-90 transition">
                        </a>
                        <a href="#" class="block">
                            <img src="https://placehold.co/90x30/7705B6/FFFFFF?text=Google+Play" alt="Google Play" class="h-8 rounded-md hover:opacity-90 transition">
                        </a>
                    </div>
                </div>
            </div>

            <!-- Recursos -->
            <div class="col-span-1">
                <h3 class="text-lg font-semibold text-primary mb-5 border-b border-primary/20 pb-2">Recursos</h3>
                <ul class="space-y-3">
                    <li>
                        <a href="{{ route('help.center') }}" class="group flex items-center text-gray-600 hover:text-primary transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-primary/70 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                            Centro de ayuda
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('student.guides') }}" class="group flex items-center text-gray-600 hover:text-primary transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-primary/70 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                            Guías para estudiantes
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('company.resources') }}" class="group flex items-center text-gray-600 hover:text-primary transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-primary/70 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                            Recursos para empresas
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('terms.conditions') }}" class="group flex items-center text-gray-600 hover:text-primary transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-primary/70 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                            Términos y condiciones
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('privacy.policy') }}" class="group flex items-center text-gray-600 hover:text-primary transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-primary/70 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                            Política de privacidad
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Contacto -->
            <div class="col-span-1">
                <h3 class="text-lg font-semibold text-primary mb-5 border-b border-primary/20 pb-2">Contacto</h3>
                <ul class="space-y-4">
                    <li class="flex items-start group">
                        <div class="bg-white p-2 rounded-full shadow-sm mr-3 text-primary group-hover:bg-primary group-hover:text-white transition-colors duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-gray-600 group-hover:text-primary transition-colors duration-300">Calle Principal 123</p>
                            <p class="text-gray-600 group-hover:text-primary transition-colors duration-300">08001 Barcelona, España</p>
                        </div>
                    </li>
                    <li class="flex items-center group">
                        <div class="bg-white p-2 rounded-full shadow-sm mr-3 text-primary group-hover:bg-primary group-hover:text-white transition-colors duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <span class="text-gray-600 group-hover:text-primary transition-colors duration-300">info@nextgen.com</span>
                    </li>
                    <li class="flex items-center group">
                        <div class="bg-white p-2 rounded-full shadow-sm mr-3 text-primary group-hover:bg-primary group-hover:text-white transition-colors duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                        </div>
                        <span class="text-gray-600 group-hover:text-primary transition-colors duration-300">+34 93 123 45 67</span>
                    </li>
                </ul>

                <!-- Horario de atención -->
                <div class="mt-8 bg-white/80 rounded-lg p-4 shadow-sm backdrop-blur-sm">
                    <h4 class="font-semibold text-primary text-sm mb-2">Horario de atención</h4>
                    <div class="space-y-1 text-sm text-gray-600">
                        <p class="flex justify-between">
                            <span>Lunes - Viernes:</span>
                            <span>9:00 - 18:00</span>
                        </p>
                        <p class="flex justify-between">
                            <span>Sábado:</span>
                            <span>10:00 - 14:00</span>
                        </p>
                        <p class="flex justify-between">
                            <span>Domingo:</span>
                            <span>Cerrado</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Línea divisoria -->
        <div class="mt-14 pt-8 border-t border-primary/20">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <p class="text-sm text-gray-600">© {{ date('Y') }} <span class="text-primary font-semibold">NextGen</span>. Todos los derechos reservados.</p>
                <div class="mt-4 md:mt-0 flex items-center">
                    <p class="text-sm text-gray-600">Diseñado y desarrollado con</p>
                    <span class="mx-1 text-red-500 animate-pulse text-lg">❤</span>
                    <p class="text-sm text-gray-600">por <span class="text-primary hover:underline">Grupo 03</span></p>
                </div>
            </div>

            <!-- Botón volver arriba -->
            <div class="flex justify-end mt-6">
                <button id="back-to-top" aria-label="Volver arriba" class="inline-flex items-center justify-center bg-primary text-white w-10 h-10 rounded-full shadow-lg hover:bg-primary-dark transition transform hover:translate-y-[-3px] focus:outline-none focus:ring-2 focus:ring-primary/30 opacity-0 invisible">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</footer>

<!-- Scripts del footer -->
<script src="{{ asset('js/footer.js') }}"></script>
<script src="{{ asset('js/language-selector.js') }}"></script>
