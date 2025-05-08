@component('mail::message')
<div style="background: linear-gradient(90deg, #7705B6 0%, #D0AAFE 100%); padding: 24px 0 12px 0; text-align: center; border-radius: 8px 8px 0 0;">
    <img src="{{ asset('assets/images/logo.svg') }}" alt="NextGen Logo" style="height: 60px; margin-bottom: 8px;">
    <h1 style="color: #fff; font-size: 2rem; margin: 0;">NextGen</h1>
</div>

{{-- Aquí va el contenido dinámico del correo --}}
# {{ $subject ?? 'Notificación' }}

{{ $greeting ?? '' }}

{{ $line1 ?? '' }}

@isset($actionText)
@component('mail::button', ['url' => $actionUrl, 'color' => $actionColor ?? 'primary'])
{{ $actionText }}
@endcomponent
@endisset

{{ $line2 ?? '' }}

@endcomponent