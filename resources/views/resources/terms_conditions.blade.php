@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-lg p-6 md:p-8">
        <h1 class="text-3xl font-bold text-primary mb-6">{{ __('footer.terms_conditions') }}</h1>
        
        <div class="prose prose-primary max-w-none">
            <p class="text-gray-600">Última actualización: {{ date('d/m/Y') }}</p>
            
            <h2 class="mt-8 text-xl font-semibold">1. Aceptación de Términos</h2>
            <p>Al utilizar NextGen, usted acepta estos términos y condiciones en su totalidad. Si no está de acuerdo con estos términos, por favor no utilice esta plataforma.</p>
            
            <h2 class="mt-6 text-xl font-semibold">2. Descripción del Servicio</h2>
            <p>NextGen es una plataforma que conecta a estudiantes, instituciones educativas y empresas con el propósito de facilitar oportunidades laborales, prácticas profesionales y desarrollo de carrera. Nos reservamos el derecho de modificar, suspender o discontinuar cualquier aspecto del servicio en cualquier momento.</p>
            
            <h2 class="mt-6 text-xl font-semibold">3. Registro y Cuentas de Usuario</h2>
            <p>Al registrarse en NextGen, usted acepta proporcionar información precisa, actual y completa. Es responsable de mantener la confidencialidad de su contraseña y de todas las actividades que ocurran bajo su cuenta. NextGen no será responsable de ninguna pérdida o daño derivado de su incumplimiento de esta obligación.</p>
            
            <h2 class="mt-6 text-xl font-semibold">4. Conducta del Usuario</h2>
            <p>Al utilizar la plataforma, usted acepta no:</p>
            <ul class="list-disc pl-6 space-y-2 mt-2">
                <li>Publicar contenido falso, inexacto, engañoso o fraudulento.</li>
                <li>Participar en actividades ilegales o no autorizadas.</li>
                <li>Interferir con el acceso de otros usuarios a la plataforma.</li>
                <li>Distribuir virus o cualquier tecnología diseñada para dañar NextGen.</li>
                <li>Recopilar información de otros usuarios sin su consentimiento.</li>
            </ul>
            
            <h2 class="mt-6 text-xl font-semibold">5. Contenido del Usuario</h2>
            <p>Al publicar contenido en NextGen, usted otorga a la plataforma una licencia mundial, no exclusiva y libre de regalías para usar, modificar, reproducir y distribuir dicho contenido. Usted es el único responsable del contenido que publica y afirma tener todos los derechos necesarios sobre el mismo.</p>
            
            <h2 class="mt-6 text-xl font-semibold">6. Propiedad Intelectual</h2>
            <p>Todo el contenido, características y funcionalidades de NextGen, incluyendo pero no limitado a texto, gráficos, logotipos, íconos y software, son propiedad de NextGen o de sus licenciantes y están protegidos por leyes de propiedad intelectual.</p>
            
            <h2 class="mt-6 text-xl font-semibold">7. Limitación de Responsabilidad</h2>
            <p>NextGen no será responsable de ningún daño directo, indirecto, incidental, especial o consecuente derivado del uso o la imposibilidad de uso de nuestros servicios. No garantizamos que la plataforma estará libre de errores o ininterrumpida, ni que se corregirán los defectos.</p>
            
            <h2 class="mt-6 text-xl font-semibold">8. Privacidad</h2>
            <p>Su uso de NextGen está sujeto a nuestra Política de Privacidad, que describe cómo recopilamos, usamos y compartimos su información personal.</p>
            
            <h2 class="mt-6 text-xl font-semibold">9. Cambios a los Términos</h2>
            <p>Nos reservamos el derecho de modificar estos términos en cualquier momento. Los cambios entrarán en vigor inmediatamente después de su publicación. Su uso continuado de NextGen después de dichos cambios constituirá su aceptación de los términos revisados.</p>
            
            <h2 class="mt-6 text-xl font-semibold">10. Ley Aplicable</h2>
            <p>Estos términos se regirán e interpretarán de acuerdo con las leyes de España, sin tener en cuenta sus conflictos de disposiciones legales.</p>
            
            <h2 class="mt-6 text-xl font-semibold">11. Contacto</h2>
            <p>Si tiene alguna pregunta sobre estos Términos y Condiciones, póngase en contacto con nosotros a través de: <a href="mailto:info@nextgen.com" class="text-primary hover:underline">info@nextgen.com</a></p>
        </div>
    </div>
</div>
@endsection 