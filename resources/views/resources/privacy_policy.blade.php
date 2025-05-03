@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-lg p-6 md:p-8">
        <h1 class="text-3xl font-bold text-primary mb-6">{{ __('footer.privacy_policy') }}</h1>
        
        <div class="prose prose-primary max-w-none">
            <p class="text-gray-600">Última actualización: {{ date('d/m/Y') }}</p>
            
            <h2 class="mt-8 text-xl font-semibold">1. Introducción</h2>
            <p>En NextGen, respetamos su privacidad y nos comprometemos a proteger sus datos personales. Esta política de privacidad le informará sobre cómo cuidamos sus datos personales cuando visita nuestra plataforma y le informará sobre sus derechos de privacidad y cómo la ley le protege.</p>
            
            <h2 class="mt-6 text-xl font-semibold">2. Datos que recopilamos</h2>
            <p>Podemos recopilar, usar, almacenar y transferir diferentes tipos de datos personales sobre usted, que hemos agrupado de la siguiente manera:</p>
            <ul class="list-disc pl-6 space-y-2 mt-2">
                <li><strong>Datos de identidad:</strong> Incluye nombre, apellido, nombre de usuario o identificador similar, estado civil, fecha de nacimiento y género.</li>
                <li><strong>Datos de contacto:</strong> Incluye dirección de facturación, dirección de entrega, dirección de correo electrónico y números de teléfono.</li>
                <li><strong>Datos profesionales:</strong> Incluye su historial educativo, experiencia laboral, habilidades, certificaciones y preferencias laborales.</li>
                <li><strong>Datos técnicos:</strong> Incluye dirección de protocolo de Internet (IP), datos de inicio de sesión, tipo y versión del navegador, configuración de zona horaria y ubicación, tipos y versiones de plugins del navegador, sistema operativo y plataforma.</li>
                <li><strong>Datos de uso:</strong> Incluye información sobre cómo utiliza nuestra plataforma y servicios.</li>
            </ul>
            
            <h2 class="mt-6 text-xl font-semibold">3. Cómo recopilamos sus datos</h2>
            <p>Utilizamos diferentes métodos para recopilar datos de y sobre usted, incluyendo:</p>
            <ul class="list-disc pl-6 space-y-2 mt-2">
                <li><strong>Interacciones directas:</strong> Puede proporcionarnos sus datos al completar formularios o al comunicarse con nosotros.</li>
                <li><strong>Tecnologías automatizadas:</strong> A medida que interactúa con nuestra plataforma, podemos recopilar automáticamente datos técnicos sobre su equipo y acciones de navegación.</li>
                <li><strong>Terceros:</strong> Podemos recibir datos personales sobre usted de varios terceros, como socios académicos o empresariales.</li>
            </ul>
            
            <h2 class="mt-6 text-xl font-semibold">4. Cómo utilizamos sus datos</h2>
            <p>Utilizamos sus datos personales solo cuando la ley nos lo permite. Principalmente utilizaremos sus datos personales en las siguientes circunstancias:</p>
            <ul class="list-disc pl-6 space-y-2 mt-2">
                <li>Para registrar su cuenta y gestionar nuestra relación con usted.</li>
                <li>Para permitir que las empresas e instituciones vean su perfil si usted es un estudiante.</li>
                <li>Para permitir que los estudiantes vean ofertas de trabajo y prácticas si usted es una empresa.</li>
                <li>Para mejorar nuestra plataforma y ofrecer una experiencia personalizada.</li>
                <li>Para comunicarnos con usted sobre actualizaciones o cambios en la plataforma.</li>
            </ul>
            
            <h2 class="mt-6 text-xl font-semibold">5. Divulgación de sus datos</h2>
            <p>Podemos compartir sus datos personales con las siguientes partes:</p>
            <ul class="list-disc pl-6 space-y-2 mt-2">
                <li>Empresas e instituciones educativas que utilizan nuestra plataforma.</li>
                <li>Proveedores de servicios que nos proporcionan servicios de TI y administración de sistemas.</li>
                <li>Asesores profesionales, incluidos abogados, banqueros, auditores y aseguradores.</li>
                <li>Autoridades fiscales, reguladoras y otras autoridades que requieran la información en determinadas circunstancias.</li>
            </ul>
            
            <h2 class="mt-6 text-xl font-semibold">6. Seguridad de datos</h2>
            <p>Hemos implementado medidas de seguridad apropiadas para evitar que sus datos personales se pierdan, utilicen o accedan de forma no autorizada. También limitamos el acceso a sus datos personales a aquellos empleados, agentes, contratistas y otros terceros que tengan una necesidad comercial de conocerlos.</p>
            
            <h2 class="mt-6 text-xl font-semibold">7. Retención de datos</h2>
            <p>Solo retendremos sus datos personales durante el tiempo necesario para cumplir con los fines para los que los recopilamos, incluido el cumplimiento de requisitos legales, contables o de informes.</p>
            
            <h2 class="mt-6 text-xl font-semibold">8. Sus derechos legales</h2>
            <p>Bajo ciertas circunstancias, usted tiene derechos bajo las leyes de protección de datos en relación con sus datos personales, incluyendo el derecho a:</p>
            <ul class="list-disc pl-6 space-y-2 mt-2">
                <li>Solicitar acceso a sus datos personales.</li>
                <li>Solicitar la corrección de sus datos personales.</li>
                <li>Solicitar la eliminación de sus datos personales.</li>
                <li>Oponerse al procesamiento de sus datos personales.</li>
                <li>Solicitar la restricción del procesamiento de sus datos personales.</li>
                <li>Solicitar la transferencia de sus datos personales.</li>
                <li>Retirar el consentimiento en cualquier momento.</li>
            </ul>
            
            <h2 class="mt-6 text-xl font-semibold">9. Cookies</h2>
            <p>Nuestra plataforma utiliza cookies para distinguirlo de otros usuarios. Esto nos ayuda a proporcionarle una buena experiencia cuando navega por nuestro sitio y también nos permite mejorarlo.</p>
            
            <h2 class="mt-6 text-xl font-semibold">10. Cambios a esta política de privacidad</h2>
            <p>Podemos actualizar nuestra política de privacidad de vez en cuando. Cualquier cambio que hagamos en nuestra política de privacidad en el futuro se publicará en esta página.</p>
            
            <h2 class="mt-6 text-xl font-semibold">11. Contacto</h2>
            <p>Si tiene alguna pregunta sobre esta política de privacidad o sobre nuestras prácticas de privacidad, póngase en contacto con nuestro equipo de protección de datos en: <a href="mailto:privacy@nextgen.com" class="text-primary hover:underline">privacy@nextgen.com</a></p>
        </div>
    </div>
</div>
@endsection 