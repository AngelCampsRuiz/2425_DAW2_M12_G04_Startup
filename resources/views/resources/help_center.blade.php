@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-lg p-6 md:p-8">
        <h1 class="text-3xl font-bold text-primary mb-6">{{ __('footer.help_center') }}</h1>
        
        <div class="space-y-8">
            <!-- Sección FAQ -->
            <section>
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">Preguntas Frecuentes</h2>
                
                <div class="space-y-4">
                    <div class="border border-gray-200 rounded-lg p-4">
                        <h3 class="font-medium text-primary mb-2">¿Cómo funciona NextGen?</h3>
                        <p class="text-gray-600">NextGen es una plataforma que conecta estudiantes con empresas para oportunidades laborales y prácticas. Las empresas publican ofertas y los estudiantes pueden aplicar directamente a ellas.</p>
                    </div>
                    
                    <div class="border border-gray-200 rounded-lg p-4">
                        <h3 class="font-medium text-primary mb-2">¿Cómo puedo crear una cuenta?</h3>
                        <p class="text-gray-600">Puedes registrarte como estudiante, empresa o institución educativa. Simplemente haz clic en "Registro" en la barra de navegación y sigue los pasos según tu perfil.</p>
                    </div>
                    
                    <div class="border border-gray-200 rounded-lg p-4">
                        <h3 class="font-medium text-primary mb-2">¿Qué información debo incluir en mi perfil?</h3>
                        <p class="text-gray-600">Para los estudiantes, recomendamos incluir tus habilidades, educación, experiencia y proyectos. Las empresas deben detallar su sector, ubicación y cultura empresarial.</p>
                    </div>
                    
                    <div class="border border-gray-200 rounded-lg p-4">
                        <h3 class="font-medium text-primary mb-2">¿Cómo aplico a una oferta?</h3>
                        <p class="text-gray-600">Navega por las ofertas disponibles, haz clic en "Ver detalles" de la que te interese y luego presiona el botón "Aplicar". Podrás incluir un mensaje personalizado para la empresa.</p>
                    </div>
                </div>
            </section>
            
            <!-- Sección Contacto -->
            <section>
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">Contacto de Soporte</h2>
                
                <div class="bg-gray-50 rounded-lg p-6">
                    <p class="mb-4">Si no encuentras respuesta a tu pregunta, no dudes en contactarnos:</p>
                    
                    <div class="flex items-center mb-3">
                        <div class="bg-primary text-white p-2 rounded-full mr-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <span>soporte@nextgen.com</span>
                    </div>
                    
                    <div class="flex items-center">
                        <div class="bg-primary text-white p-2 rounded-full mr-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                        </div>
                        <span>+34 93 123 45 67</span>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
@endsection 