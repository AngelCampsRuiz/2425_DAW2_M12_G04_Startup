@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-12">
    <div class="max-w-4xl mx-auto">
        <!-- Encabezado -->
        <div class="text-center mb-10">
            <h1 class="text-4xl font-bold bg-gradient-to-r from-primary to-purple-600 bg-clip-text text-transparent mb-4">Términos y condiciones</h1>
            <p class="text-lg text-gray-600">Nuestras políticas y normas para el uso de la plataforma NextGen</p>
        </div>
        
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-16">
            <div class="p-8 md:p-10">
                <div class="flex items-center mb-6">
                    <div class="h-10 w-10 rounded-full bg-primary/10 flex items-center justify-center mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <p class="text-gray-600 font-medium">Última actualización: {{ date('d/m/Y') }}</p>
                </div>
                
                <div class="prose prose-primary max-w-none">
                    <div class="space-y-8">
                        <section>
                            <h2 class="text-2xl font-bold text-gray-800 border-b border-gray-100 pb-2">1. Aceptación de Términos</h2>
                            <p class="mt-4 text-gray-600">Al utilizar NextGen, usted acepta estos términos y condiciones en su totalidad. Si no está de acuerdo con estos términos, por favor no utilice esta plataforma.</p>
                        </section>
                        
                        <section>
                            <h2 class="text-2xl font-bold text-gray-800 border-b border-gray-100 pb-2">2. Descripción del Servicio</h2>
                            <p class="mt-4 text-gray-600">NextGen es una plataforma que conecta a estudiantes, instituciones educativas y empresas con el propósito de facilitar oportunidades laborales, prácticas profesionales y desarrollo de carrera. Nos reservamos el derecho de modificar, suspender o discontinuar cualquier aspecto del servicio en cualquier momento.</p>
                        </section>
                        
                        <section>
                            <h2 class="text-2xl font-bold text-gray-800 border-b border-gray-100 pb-2">3. Registro y Cuentas de Usuario</h2>
                            <p class="mt-4 text-gray-600">Al registrarse en NextGen, usted acepta proporcionar información precisa, actual y completa. Es responsable de mantener la confidencialidad de su contraseña y de todas las actividades que ocurran bajo su cuenta. NextGen no será responsable de ninguna pérdida o daño derivado de su incumplimiento de esta obligación.</p>
                        </section>
                        
                        <section>
                            <h2 class="text-2xl font-bold text-gray-800 border-b border-gray-100 pb-2">4. Conducta del Usuario</h2>
                            <p class="mt-4 text-gray-600">Al utilizar la plataforma, usted acepta no:</p>
                            <ul class="mt-4 space-y-3 bg-gray-50 rounded-xl p-5">
                                <li class="flex items-start">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary mt-0.5 mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>Publicar contenido falso, inexacto, engañoso o fraudulento.</span>
                                </li>
                                <li class="flex items-start">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary mt-0.5 mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>Participar en actividades ilegales o no autorizadas.</span>
                                </li>
                                <li class="flex items-start">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary mt-0.5 mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>Interferir con el acceso de otros usuarios a la plataforma.</span>
                                </li>
                                <li class="flex items-start">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary mt-0.5 mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>Distribuir virus o cualquier tecnología diseñada para dañar NextGen.</span>
                                </li>
                                <li class="flex items-start">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary mt-0.5 mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>Recopilar información de otros usuarios sin su consentimiento.</span>
                                </li>
                            </ul>
                        </section>
                        
                        <section>
                            <h2 class="text-2xl font-bold text-gray-800 border-b border-gray-100 pb-2">5. Contenido del Usuario</h2>
                            <p class="mt-4 text-gray-600">Al publicar contenido en NextGen, usted otorga a la plataforma una licencia mundial, no exclusiva y libre de regalías para usar, modificar, reproducir y distribuir dicho contenido. Usted es el único responsable del contenido que publica y afirma tener todos los derechos necesarios sobre el mismo.</p>
                        </section>
                        
                        <section>
                            <h2 class="text-2xl font-bold text-gray-800 border-b border-gray-100 pb-2">6. Propiedad Intelectual</h2>
                            <p class="mt-4 text-gray-600">Todo el contenido, características y funcionalidades de NextGen, incluyendo pero no limitado a texto, gráficos, logotipos, íconos y software, son propiedad de NextGen o de sus licenciantes y están protegidos por leyes de propiedad intelectual.</p>
                        </section>
                        
                        <section>
                            <h2 class="text-2xl font-bold text-gray-800 border-b border-gray-100 pb-2">7. Limitación de Responsabilidad</h2>
                            <p class="mt-4 text-gray-600">NextGen no será responsable de ningún daño directo, indirecto, incidental, especial o consecuente derivado del uso o la imposibilidad de uso de nuestros servicios. No garantizamos que la plataforma estará libre de errores o ininterrumpida, ni que se corregirán los defectos.</p>
                        </section>
                        
                        <section>
                            <h2 class="text-2xl font-bold text-gray-800 border-b border-gray-100 pb-2">8. Privacidad</h2>
                            <p class="mt-4 text-gray-600">Su uso de NextGen está sujeto a nuestra Política de Privacidad, que describe cómo recopilamos, usamos y compartimos su información personal.</p>
                        </section>
                        
                        <section>
                            <h2 class="text-2xl font-bold text-gray-800 border-b border-gray-100 pb-2">9. Cambios a los Términos</h2>
                            <p class="mt-4 text-gray-600">Nos reservamos el derecho de modificar estos términos en cualquier momento. Los cambios entrarán en vigor inmediatamente después de su publicación. Su uso continuado de NextGen después de dichos cambios constituirá su aceptación de los términos revisados.</p>
                        </section>
                        
                        <section>
                            <h2 class="text-2xl font-bold text-gray-800 border-b border-gray-100 pb-2">10. Ley Aplicable</h2>
                            <p class="mt-4 text-gray-600">Estos términos se regirán e interpretarán de acuerdo con las leyes de España, sin tener en cuenta sus conflictos de disposiciones legales.</p>
                        </section>
                    </div>
                    
                    <!-- Contacto -->
                    <div class="mt-12 bg-gradient-to-r from-primary/5 to-purple-500/5 p-6 rounded-xl border border-primary/10">
                        <h2 class="text-2xl font-bold text-gray-800 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            Contacto
                        </h2>
                        <p class="mt-4 text-gray-600">Si tiene alguna pregunta sobre estos Términos y Condiciones, póngase en contacto con nosotros a través de:</p>
                        <a href="mailto:info@nextgen.com" class="inline-flex items-center px-4 py-2 bg-primary text-white rounded-lg mt-4 hover:bg-primary-dark transition duration-200 group">
                            info@nextgen.com
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 