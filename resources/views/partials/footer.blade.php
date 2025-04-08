{{-- FOOTER --}}
    <footer class="bg-primary/20 py-8">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-4 md:mb-0">
                    <div class="flex items-center">
                        <a href="{{ url('/') }}">
                            <img src="{{ asset('assets/images/logo.svg') }}" alt="Logo" class="h-8">
                        </a>
                        <span class="ml-2 font-bold text-primary">NextGen</span>
                    </div>
                    <p class="mt-2 text-sm text-primary">Conectando talento con oportunidades</p>
                </div>
                
                <div class="flex flex-col md:flex-row space-y-2 md:space-y-0 md:space-x-6 text-center md:text-left">
                    <a href="#" class="text-primary hover:text-primary-dark">Términos</a>
                    <a href="#" class="text-primary hover:text-primary-dark">Privacidad</a>
                    <a href="#" class="text-primary hover:text-primary-dark">Contacto</a>
                </div>
            </div>
            
            <div class="mt-8 pt-6 border-t border-primary text-center text-sm text-primary">
                © {{ date('Y') }} NextGen. Todos los derechos reservados.
            </div>
        </div>
    </footer>