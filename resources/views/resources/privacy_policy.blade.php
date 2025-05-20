@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-12">
    <div class="max-w-5xl mx-auto">
        <div class="text-center mb-10">
            <h1 class="text-4xl font-bold bg-gradient-to-r from-primary to-purple-600 bg-clip-text text-transparent mb-4">Politica de privacidad</h1>
            <p class="text-lg text-gray-600 max-w-3xl mx-auto">Entendemos la importancia de tu privacidad. Esta política describe cómo recopilamos, usamos y protegemos tu información personal.</p>
            <div class="mt-4 text-gray-500">Última actualización: {{ date('d/m/Y') }}</div>
        </div>
        
        <div class="bg-white rounded-2xl shadow-xl p-8 mb-10">
            <!-- Índice de contenidos -->
            <div class="bg-gray-50 rounded-xl p-6 mb-8">
                <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                    </svg>
                    Índice de contenidos
                </h2>
                <ul class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <li>
                        <a href="#introduccion" class="flex items-center text-primary hover:text-primary-dark hover:underline">
                            <span class="inline-flex items-center justify-center w-6 h-6 bg-primary/10 text-primary rounded-full mr-2 text-sm">1</span>
                            Introducción
                        </a>
                    </li>
                    <li>
                        <a href="#datos-recopilados" class="flex items-center text-primary hover:text-primary-dark hover:underline">
                            <span class="inline-flex items-center justify-center w-6 h-6 bg-primary/10 text-primary rounded-full mr-2 text-sm">2</span>
                            Datos que recopilamos
                        </a>
                    </li>
                    <li>
                        <a href="#como-recopilamos" class="flex items-center text-primary hover:text-primary-dark hover:underline">
                            <span class="inline-flex items-center justify-center w-6 h-6 bg-primary/10 text-primary rounded-full mr-2 text-sm">3</span>
                            Cómo recopilamos sus datos
                        </a>
                    </li>
                    <li>
                        <a href="#como-utilizamos" class="flex items-center text-primary hover:text-primary-dark hover:underline">
                            <span class="inline-flex items-center justify-center w-6 h-6 bg-primary/10 text-primary rounded-full mr-2 text-sm">4</span>
                            Cómo utilizamos sus datos
                        </a>
                    </li>
                    <li>
                        <a href="#divulgacion" class="flex items-center text-primary hover:text-primary-dark hover:underline">
                            <span class="inline-flex items-center justify-center w-6 h-6 bg-primary/10 text-primary rounded-full mr-2 text-sm">5</span>
                            Divulgación de sus datos
                        </a>
                    </li>
                    <li>
                        <a href="#seguridad" class="flex items-center text-primary hover:text-primary-dark hover:underline">
                            <span class="inline-flex items-center justify-center w-6 h-6 bg-primary/10 text-primary rounded-full mr-2 text-sm">6</span>
                            Seguridad de datos
                        </a>
                    </li>
                    <li>
                        <a href="#retencion" class="flex items-center text-primary hover:text-primary-dark hover:underline">
                            <span class="inline-flex items-center justify-center w-6 h-6 bg-primary/10 text-primary rounded-full mr-2 text-sm">7</span>
                            Retención de datos
                        </a>
                    </li>
                    <li>
                        <a href="#derechos" class="flex items-center text-primary hover:text-primary-dark hover:underline">
                            <span class="inline-flex items-center justify-center w-6 h-6 bg-primary/10 text-primary rounded-full mr-2 text-sm">8</span>
                            Sus derechos legales
                        </a>
                    </li>
                    <li>
                        <a href="#cookies" class="flex items-center text-primary hover:text-primary-dark hover:underline">
                            <span class="inline-flex items-center justify-center w-6 h-6 bg-primary/10 text-primary rounded-full mr-2 text-sm">9</span>
                            Cookies
                        </a>
                    </li>
                    <li>
                        <a href="#cambios" class="flex items-center text-primary hover:text-primary-dark hover:underline">
                            <span class="inline-flex items-center justify-center w-6 h-6 bg-primary/10 text-primary rounded-full mr-2 text-sm">10</span>
                            Cambios a esta política
                        </a>
                    </li>
                    <li>
                        <a href="#contacto" class="flex items-center text-primary hover:text-primary-dark hover:underline">
                            <span class="inline-flex items-center justify-center w-6 h-6 bg-primary/10 text-primary rounded-full mr-2 text-sm">11</span>
                            Contacto
                        </a>
                    </li>
                </ul>
            </div>
            
            <div class="prose prose-primary max-w-none">
                <h2 class="mt-8 text-xl font-semibold flex items-center" id="introduccion">
                    <span class="inline-flex items-center justify-center w-8 h-8 bg-primary/10 text-primary rounded-full mr-3 text-sm">1</span>
                    <span class="bg-gradient-to-r from-primary to-purple-600 bg-clip-text text-transparent">Introducción</span>
                </h2>
                <div class="pl-11 mt-3">
                    <p class="text-gray-700">En NextGen, respetamos su privacidad y nos comprometemos a proteger sus datos personales. Esta política de privacidad le informará sobre cómo cuidamos sus datos personales cuando visita nuestra plataforma y le informará sobre sus derechos de privacidad y cómo la ley le protege.</p>
                </div>
                
                <h2 class="mt-10 text-xl font-semibold flex items-center" id="datos-recopilados">
                    <span class="inline-flex items-center justify-center w-8 h-8 bg-primary/10 text-primary rounded-full mr-3 text-sm">2</span>
                    <span class="bg-gradient-to-r from-primary to-purple-600 bg-clip-text text-transparent">Datos que recopilamos</span>
                </h2>
                <div class="pl-11 mt-3">
                    <p class="text-gray-700">Podemos recopilar, usar, almacenar y transferir diferentes tipos de datos personales sobre usted, que hemos agrupado de la siguiente manera:</p>
                    <ul class="mt-4 space-y-3">
                        <li class="flex">
                            <div class="flex-shrink-0 bg-primary/10 rounded-full p-1.5 mt-0.5 mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <div>
                                <span class="font-medium text-gray-800">Datos de identidad:</span>
                                <span class="text-gray-700"> Incluye nombre, apellido, nombre de usuario o identificador similar, estado civil, fecha de nacimiento y género.</span>
                            </div>
                        </li>
                        <li class="flex">
                            <div class="flex-shrink-0 bg-primary/10 rounded-full p-1.5 mt-0.5 mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <span class="font-medium text-gray-800">Datos de contacto:</span>
                                <span class="text-gray-700"> Incluye dirección de facturación, dirección de entrega, dirección de correo electrónico y números de teléfono.</span>
                            </div>
                        </li>
                        <li class="flex">
                            <div class="flex-shrink-0 bg-primary/10 rounded-full p-1.5 mt-0.5 mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <span class="font-medium text-gray-800">Datos profesionales:</span>
                                <span class="text-gray-700"> Incluye su historial educativo, experiencia laboral, habilidades, certificaciones y preferencias laborales.</span>
                            </div>
                        </li>
                        <li class="flex">
                            <div class="flex-shrink-0 bg-primary/10 rounded-full p-1.5 mt-0.5 mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <span class="font-medium text-gray-800">Datos técnicos:</span>
                                <span class="text-gray-700"> Incluye dirección de protocolo de Internet (IP), datos de inicio de sesión, tipo y versión del navegador, configuración de zona horaria y ubicación, tipos y versiones de plugins del navegador, sistema operativo y plataforma.</span>
                            </div>
                        </li>
                        <li class="flex">
                            <div class="flex-shrink-0 bg-primary/10 rounded-full p-1.5 mt-0.5 mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </div>
                            <div>
                                <span class="font-medium text-gray-800">Datos de uso:</span>
                                <span class="text-gray-700"> Incluye información sobre cómo utiliza nuestra plataforma y servicios.</span>
                            </div>
                        </li>
                    </ul>
                </div>
                
                <h2 class="mt-10 text-xl font-semibold flex items-center" id="como-recopilamos">
                    <span class="inline-flex items-center justify-center w-8 h-8 bg-primary/10 text-primary rounded-full mr-3 text-sm">3</span>
                    <span class="bg-gradient-to-r from-primary to-purple-600 bg-clip-text text-transparent">Cómo recopilamos sus datos</span>
                </h2>
                <div class="pl-11 mt-3">
                    <p class="text-gray-700">Utilizamos diferentes métodos para recopilar datos de y sobre usted, incluyendo:</p>
                    
                    <div class="bg-gray-50 rounded-xl p-5 mt-4 grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="bg-white p-4 rounded-lg shadow-sm">
                            <div class="flex items-center mb-3">
                                <div class="bg-primary/10 rounded-full p-2 mr-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                    </svg>
                                </div>
                                <h3 class="font-bold text-gray-800">Interacciones directas</h3>
                            </div>
                            <p class="text-gray-600 text-sm">Puede proporcionarnos sus datos al completar formularios o al comunicarse con nosotros.</p>
                        </div>
                        
                        <div class="bg-white p-4 rounded-lg shadow-sm">
                            <div class="flex items-center mb-3">
                                <div class="bg-primary/10 rounded-full p-2 mr-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <h3 class="font-bold text-gray-800">Tecnologías automatizadas</h3>
                            </div>
                            <p class="text-gray-600 text-sm">A medida que interactúa con nuestra plataforma, podemos recopilar automáticamente datos técnicos sobre su equipo y acciones de navegación.</p>
                        </div>
                        
                        <div class="bg-white p-4 rounded-lg shadow-sm">
                            <div class="flex items-center mb-3">
                                <div class="bg-primary/10 rounded-full p-2 mr-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                </div>
                                <h3 class="font-bold text-gray-800">Terceros</h3>
                            </div>
                            <p class="text-gray-600 text-sm">Podemos recibir datos personales sobre usted de varios terceros, como socios académicos o empresariales.</p>
                        </div>
                    </div>
                </div>
                
                <h2 class="mt-10 text-xl font-semibold flex items-center" id="como-utilizamos">
                    <span class="inline-flex items-center justify-center w-8 h-8 bg-primary/10 text-primary rounded-full mr-3 text-sm">4</span>
                    <span class="bg-gradient-to-r from-primary to-purple-600 bg-clip-text text-transparent">Cómo utilizamos sus datos</span>
                </h2>
                <div class="pl-11 mt-3">
                    <p class="text-gray-700">Utilizamos sus datos personales solo cuando la ley nos lo permite. Principalmente utilizaremos sus datos personales en las siguientes circunstancias:</p>
                    
                    <div class="mt-4 space-y-3">
                        <div class="flex items-start p-3 border border-gray-100 rounded-lg hover:border-primary/30 hover:bg-gray-50 transition-colors duration-300">
                            <div class="flex-shrink-0 bg-primary/10 rounded-full p-1.5 mt-0.5 mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <p class="text-gray-700">Para registrar su cuenta y gestionar nuestra relación con usted.</p>
                        </div>
                        
                        <div class="flex items-start p-3 border border-gray-100 rounded-lg hover:border-primary/30 hover:bg-gray-50 transition-colors duration-300">
                            <div class="flex-shrink-0 bg-primary/10 rounded-full p-1.5 mt-0.5 mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <p class="text-gray-700">Para permitir que las empresas e instituciones vean su perfil si usted es un estudiante.</p>
                        </div>
                        
                        <div class="flex items-start p-3 border border-gray-100 rounded-lg hover:border-primary/30 hover:bg-gray-50 transition-colors duration-300">
                            <div class="flex-shrink-0 bg-primary/10 rounded-full p-1.5 mt-0.5 mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122" />
                                </svg>
                            </div>
                            <p class="text-gray-700">Para permitir que los estudiantes vean ofertas de trabajo y prácticas si usted es una empresa.</p>
                        </div>
                        
                        <div class="flex items-start p-3 border border-gray-100 rounded-lg hover:border-primary/30 hover:bg-gray-50 transition-colors duration-300">
                            <div class="flex-shrink-0 bg-primary/10 rounded-full p-1.5 mt-0.5 mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                </svg>
                            </div>
                            <p class="text-gray-700">Para mejorar nuestra plataforma y ofrecer una experiencia personalizada.</p>
                        </div>
                        
                        <div class="flex items-start p-3 border border-gray-100 rounded-lg hover:border-primary/30 hover:bg-gray-50 transition-colors duration-300">
                            <div class="flex-shrink-0 bg-primary/10 rounded-full p-1.5 mt-0.5 mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                </svg>
                            </div>
                            <p class="text-gray-700">Para comunicarnos con usted sobre actualizaciones o cambios en la plataforma.</p>
                        </div>
                    </div>
                </div>
                
                <h2 class="mt-10 text-xl font-semibold flex items-center" id="divulgacion">
                    <span class="inline-flex items-center justify-center w-8 h-8 bg-primary/10 text-primary rounded-full mr-3 text-sm">5</span>
                    <span class="bg-gradient-to-r from-primary to-purple-600 bg-clip-text text-transparent">Divulgación de sus datos</span>
                </h2>
                <div class="pl-11 mt-3">
                    <p class="text-gray-700">Podemos compartir sus datos personales con las siguientes partes:</p>
                    
                    <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-100">
                            <div class="flex items-center mb-3">
                                <div class="bg-primary/10 rounded-full p-2 mr-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                </div>
                                <h3 class="font-bold text-gray-800">Empresas e instituciones</h3>
                            </div>
                            <p class="text-gray-600 text-sm">Empresas e instituciones educativas que utilizan nuestra plataforma.</p>
                        </div>
                        
                        <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-100">
                            <div class="flex items-center mb-3">
                                <div class="bg-primary/10 rounded-full p-2 mr-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                </div>
                                <h3 class="font-bold text-gray-800">Proveedores de servicios</h3>
                            </div>
                            <p class="text-gray-600 text-sm">Proveedores de servicios que nos proporcionan servicios de TI y administración de sistemas.</p>
                        </div>
                        
                        <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-100">
                            <div class="flex items-center mb-3">
                                <div class="bg-primary/10 rounded-full p-2 mr-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                    </svg>
                                </div>
                                <h3 class="font-bold text-gray-800">Asesores profesionales</h3>
                            </div>
                            <p class="text-gray-600 text-sm">Asesores profesionales, incluidos abogados, banqueros, auditores y aseguradores.</p>
                        </div>
                        
                        <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-100">
                            <div class="flex items-center mb-3">
                                <div class="bg-primary/10 rounded-full p-2 mr-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2zM10 8.5a.5.5 0 11-1 0 .5.5 0 011 0zm5 5a.5.5 0 11-1 0 .5.5 0 011 0z" />
                                    </svg>
                                </div>
                                <h3 class="font-bold text-gray-800">Autoridades reguladoras</h3>
                            </div>
                            <p class="text-gray-600 text-sm">Autoridades fiscales, reguladoras y otras autoridades que requieran la información en determinadas circunstancias.</p>
                        </div>
                    </div>
                </div>
                
                <h2 class="mt-10 text-xl font-semibold flex items-center" id="seguridad">
                    <span class="inline-flex items-center justify-center w-8 h-8 bg-primary/10 text-primary rounded-full mr-3 text-sm">6</span>
                    <span class="bg-gradient-to-r from-primary to-purple-600 bg-clip-text text-transparent">Seguridad de datos</span>
                </h2>
                <div class="pl-11 mt-3">
                    <p class="text-gray-700">Hemos implementado medidas de seguridad apropiadas para evitar que sus datos personales se pierdan, utilicen o accedan de forma no autorizada. También limitamos el acceso a sus datos personales a aquellos empleados, agentes, contratistas y otros terceros que tengan una necesidad comercial de conocerlos.</p>
                </div>
                
                <h2 class="mt-10 text-xl font-semibold flex items-center" id="retencion">
                    <span class="inline-flex items-center justify-center w-8 h-8 bg-primary/10 text-primary rounded-full mr-3 text-sm">7</span>
                    <span class="bg-gradient-to-r from-primary to-purple-600 bg-clip-text text-transparent">Retención de datos</span>
                </h2>
                <div class="pl-11 mt-3">
                    <p class="text-gray-700">Solo retendremos sus datos personales durante el tiempo necesario para cumplir con los fines para los que los recopilamos, incluido el cumplimiento de requisitos legales, contables o de informes.</p>
                </div>
                
                <h2 class="mt-10 text-xl font-semibold flex items-center" id="derechos">
                    <span class="inline-flex items-center justify-center w-8 h-8 bg-primary/10 text-primary rounded-full mr-3 text-sm">8</span>
                    <span class="bg-gradient-to-r from-primary to-purple-600 bg-clip-text text-transparent">Sus derechos legales</span>
                </h2>
                <div class="pl-11 mt-3">
                    <p class="text-gray-700">Bajo ciertas circunstancias, usted tiene derechos bajo las leyes de protección de datos en relación con sus datos personales, incluyendo el derecho a:</p>
                    <ul class="list-disc pl-6 space-y-2 mt-2">
                        <li>Solicitar acceso a sus datos personales.</li>
                        <li>Solicitar la corrección de sus datos personales.</li>
                        <li>Solicitar la eliminación de sus datos personales.</li>
                        <li>Oponerse al procesamiento de sus datos personales.</li>
                        <li>Solicitar la restricción del procesamiento de sus datos personales.</li>
                        <li>Solicitar la transferencia de sus datos personales.</li>
                        <li>Retirar el consentimiento en cualquier momento.</li>
                    </ul>
                </div>
                
                <h2 class="mt-10 text-xl font-semibold flex items-center" id="cookies">
                    <span class="inline-flex items-center justify-center w-8 h-8 bg-primary/10 text-primary rounded-full mr-3 text-sm">9</span>
                    <span class="bg-gradient-to-r from-primary to-purple-600 bg-clip-text text-transparent">Cookies</span>
                </h2>
                <div class="pl-11 mt-3">
                    <p class="text-gray-700">Nuestra plataforma utiliza cookies para distinguirlo de otros usuarios. Esto nos ayuda a proporcionarle una buena experiencia cuando navega por nuestro sitio y también nos permite mejorarlo.</p>
                </div>
                
                <h2 class="mt-10 text-xl font-semibold flex items-center" id="cambios">
                    <span class="inline-flex items-center justify-center w-8 h-8 bg-primary/10 text-primary rounded-full mr-3 text-sm">10</span>
                    <span class="bg-gradient-to-r from-primary to-purple-600 bg-clip-text text-transparent">Cambios a esta política de privacidad</span>
                </h2>
                <div class="pl-11 mt-3">
                    <p class="text-gray-700">Podemos actualizar nuestra política de privacidad de vez en cuando. Cualquier cambio que hagamos en nuestra política de privacidad en el futuro se publicará en esta página.</p>
                </div>
                
                <h2 class="mt-10 text-xl font-semibold flex items-center" id="contacto">
                    <span class="inline-flex items-center justify-center w-8 h-8 bg-primary/10 text-primary rounded-full mr-3 text-sm">11</span>
                    <span class="bg-gradient-to-r from-primary to-purple-600 bg-clip-text text-transparent">Contacto</span>
                </h2>
                <div class="pl-11 mt-3">
                    <p class="text-gray-700">Si tiene alguna pregunta sobre esta política de privacidad o sobre nuestras prácticas de privacidad, póngase en contacto con nuestro equipo de protección de datos en: <a href="mailto:privacy@nextgen.com" class="text-primary hover:underline">privacy@nextgen.com</a></p>
                </div>
            </div>
        </div>
        
        <!-- Componente final -->
        <div class="bg-gradient-to-br from-primary/5 to-purple-100 rounded-2xl shadow-xl p-8 mb-10 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-br from-primary/20 to-purple-300/20 rounded-full -mr-32 -mt-32 blur-3xl"></div>
            <div class="absolute bottom-0 left-0 w-80 h-80 bg-gradient-to-tr from-purple-300/20 to-primary/10 rounded-full -ml-40 -mb-40 blur-3xl"></div>
            
            <div class="relative z-10">
                <div class="mb-8 text-center">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4">¿Necesitas más información?</h2>
                    <p class="text-gray-600 max-w-3xl mx-auto">Si tienes alguna pregunta específica sobre nuestra política de privacidad o cómo manejamos tus datos, no dudes en contactarnos. Nuestro equipo de protección de datos está disponible para ayudarte.</p>
                </div>
                
                <div class="flex flex-col md:flex-row gap-6 justify-center">
                    <a href="mailto:privacy@nextgen.com" class="inline-flex items-center px-6 py-3 bg-primary text-white rounded-xl hover:bg-primary-dark transition shadow-md hover:shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        Contactar al equipo de privacidad
                    </a>
                    
                    <a href="#" class="inline-flex items-center px-6 py-3 bg-white text-gray-700 border border-gray-200 rounded-xl hover:bg-gray-50 transition shadow-sm hover:shadow-md">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Descargar política de privacidad
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 