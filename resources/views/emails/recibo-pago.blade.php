<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="{{ asset('css/stylePago.css') }}">
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="{{ asset('assets/images/logo.svg') }}" alt="NextGen Logo" class="logo">
            <h1>Recibo de Pago</h1>
        </div>

        <div class="receipt">
            <p>Estimado/a {{ $pago->institucion->user->nombre }},</p>

            <p>Gracias por su pago. A continuación encontrará los detalles de su transacción:</p>

            <div class="amount">
                Monto: {{ number_format($pago->monto, 2) }} {{ $pago->moneda }}
            </div>

            <p><strong>Detalles del pago:</strong></p>
            <ul>
                <li>ID de Transacción: {{ $pago->stripe_session_id }}</li>
                <li>Fecha: {{ $pago->fecha_pago->format('d/m/Y H:i:s') }}</li>
                <li>Estado: {{ ucfirst($pago->estado) }}</li>
            </ul>
        </div>

        <div class="footer">
            <p>Este es un recibo electrónico automático. Por favor, guárdelo para sus registros.</p>
            <p>© {{ date('Y') }} NextGen. Todos los derechos reservados.</p>
        </div>
    </div>
</body>
</html>
