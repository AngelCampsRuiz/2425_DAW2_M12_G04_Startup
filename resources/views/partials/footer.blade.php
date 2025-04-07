{{-- FOOTER --}}
    <footer class="bg-[#D0AAFE] py-8 mt-12">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-4 md:mb-0">
                    <div class="flex items-center">
                        {{--  IMAGEN LOGO--}}
                            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-8">
                        {{-- NOMBRE EMPRESA --}}
                            <span class="ml-2 font-bold text-[#7705B6]">PrácticasJobs</span>
                    </div>
                    <p class="mt-2 text-sm text-[#7705B6]">Conectando talento con oportunidades</p>
                </div>
                
                <div class="flex space-x-6">
                    <a href="#" class="text-[#7705B6] hover:text-[#5E0490]">Términos</a>
                    <a href="#" class="text-[#7705B6] hover:text-[#5E0490]">Privacidad</a>
                    <a href="#" class="text-[#7705B6] hover:text-[#5E0490]">Contacto</a>
                </div>
            </div>
            
            <div class="mt-8 pt-6 border-t border-[#7705B6] text-center text-sm text-[#7705B6]">
                © {{ date('Y') }} PrácticasJobs. Todos los derechos reservados.
            </div>
        </div>
    </footer>