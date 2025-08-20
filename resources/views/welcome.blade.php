<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>OcoTaxi | Tu transporte seguro</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap');

        body {
            font-family: 'Montserrat', sans-serif;
            text-align: center;
            padding: 100px 20px;
            margin: 0;
            background-image: url('https://static.wixstatic.com/media/952b60_67f559efb50a4101804756294550c92a~mv2.jpg/v1/fill/w_679,h_452,al_c,q_80,enc_auto/952b60_67f559efb50a4101804756294550c92a~mv2.jpg'); /* Puedes reemplazar por una imagen cultural o de taxi local */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            color: #fff;
        }

        h1 {
            font-size: 3rem;
            font-weight: 700;
            text-shadow: 2px 2px 4px #000;
            margin-bottom: 50px;
        }

        .btn {
            display: inline-block;
            padding: 14px 28px;
            margin: 12px;
            background-color: rgba(255, 193, 7, 0.9); /* amarillo tipo taxi */
            color: #000;
            text-decoration: none;
            border-radius: 10px;
            font-weight: bold;
            font-size: 1.1rem;
            box-shadow: 2px 4px 10px rgba(0, 0, 0, 0.3);
            transition: transform 0.2s ease, background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #ffc107;
            transform: scale(1.05);
        }

        .footer {
            position: absolute;
            bottom: 20px;
            width: 100%;
            text-align: center;
            font-size: 0.9rem;
            color: #eee;
            text-shadow: 1px 1px 2px #000;
        }
    </style>
</head>
<body>
    <h1>Bienvenido a OcoTaxi</h1>

    <a href="{{ route('login') }}" class="btn">Iniciar Sesión</a>
    <a href="{{ route('register') }}" class="btn">Registrarse</a>

    <div class="footer">© {{ date('Y') }} OcoTaxi | Tu viaje, nuestra prioridad</div>
</body>
</html>
