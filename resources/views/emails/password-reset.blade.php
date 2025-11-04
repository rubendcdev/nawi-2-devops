<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperación de Contraseña - NAWI</title>
    <style>
        body {
            font-family: 'Montserrat', Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%);
            color: white;
            padding: 30px;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }
        .content {
            background: #f9f9f9;
            padding: 30px;
            border-radius: 0 0 10px 10px;
        }
        .button {
            display: inline-block;
            padding: 15px 30px;
            background-color: #ffc107;
            color: #000;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            margin: 20px 0;
        }
        .button:hover {
            background-color: #ff9800;
        }
        .footer {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            font-size: 12px;
            color: #666;
            text-align: center;
        }
        .warning {
            background-color: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>🔑 Recuperación de Contraseña</h1>
        <p style="margin: 0;">NAWI - Taxi Seguro en Ocosingo</p>
    </div>

    <div class="content">
        <p>Hola,</p>
        
        <p>Recibimos una solicitud para restablecer la contraseña de tu cuenta en NAWI.</p>

        <p>Haz clic en el botón siguiente para restablecer tu contraseña:</p>

        <div style="text-align: center;">
            <a href="{{ $resetUrl }}" class="button">Restablecer Contraseña</a>
        </div>

        <p>O copia y pega este enlace en tu navegador:</p>
        <p style="word-break: break-all; background: #e9ecef; padding: 10px; border-radius: 4px;">
            {{ $resetUrl }}
        </p>

        <div class="warning">
            <strong>⚠️ Importante:</strong>
            <ul style="margin: 10px 0; padding-left: 20px;">
                <li>Este enlace expirará en 1 hora</li>
                <li>Si no solicitaste este cambio, ignora este email</li>
                <li>Tu contraseña no cambiará hasta que hagas clic en el enlace</li>
            </ul>
        </div>

        <p>Si tienes problemas para hacer clic en el botón, copia y pega el enlace completo en tu navegador.</p>

        <p>Saludos,<br>
        <strong>Equipo NAWI</strong></p>
    </div>

    <div class="footer">
        <p>Este es un email automático, por favor no respondas a este mensaje.</p>
        <p>&copy; {{ date('Y') }} NAWI. Todos los derechos reservados.</p>
    </div>
</body>
</html>

