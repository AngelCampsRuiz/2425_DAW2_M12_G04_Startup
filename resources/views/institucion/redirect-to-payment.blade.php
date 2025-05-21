<!DOCTYPE html>
<html>
<head>
    <title>Redirigiendo al pago...</title>
</head>
<body>
    <form id="paymentForm" method="POST" action="{{ route('institucion.payment') }}">
        @csrf
        <input type="hidden" name="institution_id" value="{{ $institution_id }}">
    </form>
    <script>
        document.getElementById('paymentForm').submit();
    </script>
    <p>Redirigiendo al pago, por favor espera...</p>
</body>
</html>
