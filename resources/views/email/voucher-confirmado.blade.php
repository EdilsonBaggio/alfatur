<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reserva Confirmada</title>
</head>
<body>
    <p>Hola, gracias por confiar en nosotros.</p>
    <p>Tu reserva está confirmada.</p>
    <p>Sigue abajo el link para tener acceso a tu voucher:</p>

    <p>
        <a href="{{ url('/viajes-full/get-venda-details/' . $venda->id) }}">
            {{ url('/viajes-full/get-venda-details/' . $venda->id) }}
        </a>
    </p>
    
    <p><strong>Tus datos de acceso son:</strong><br>
    ALF - {{ $venda->id }}<br>
    Nombre: {{ explode(' ', $venda->nome)[0] }}</p>

    <p>Saludos,<br>
    ALFATUR Chile.</p>

    <p style="font-size: 0.8em;">PD: E-mail generado automáticamente.<br>
    COD: ALF-MAILER-V01</p>
</body>
</html>
