<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Listado de Taxistas</title>
<style>
    /* Reset básico */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    html, body {
        height: 100%;
        background-color: #f4f7fb;
    }

    body {
        display: flex;
        flex-direction: column;
    }

    nav {
        background-color: #1a1a1a;
        padding: 10px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    nav .nav-logo img {
        height: 50px;
    }

    nav .nav-links a {
        color: #fff;
        text-decoration: none;
        font-weight: bold;
        margin: 0 15px;
        transition: color 0.3s;
    }

    nav .nav-links a:hover {
        color: #4caf50;
    }

    /* Contenedor principal */
    .container {
        flex: 1;
        width: 90%;
        max-width: 1200px;
        margin: 40px auto;
    }

    h1 {
        text-align: center;
        margin-bottom: 30px;
        color: #333;
        font-size: 2.5rem;
    }

    /* Grid */
    .grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 20px;
    }

    /* Card Flip */
    .card {
        perspective: 1000px;
        cursor: pointer;
    }

    .card-inner {
        position: relative;
        width: 100%;
        height: 350px;
        transition: transform 0.8s;
        transform-style: preserve-3d;
        border-radius: 12px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    .card.flipped .card-inner {
        transform: rotateY(180deg);
    }

    /* Caras */
    .card-front, .card-back {
        position: absolute;
        width: 100%;
        height: 100%;
        backface-visibility: hidden;
        border-radius: 12px;
        overflow: hidden;
        background: #fff;
    }

    .card-front {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .card-front img {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }

    .card-front .card-body {
        padding: 15px;
        text-align: center;
    }

    .card-front .card-body h2 {
        font-size: 1.25rem;
        margin-bottom: 8px;
    }

    .card-back {
        transform: rotateY(180deg);
        padding: 20px;
        overflow-y: auto;
    }

    .card-back h2 {
        margin-bottom: 10px;
    }

    .card-back p {
        margin-bottom: 6px;
        font-size: 0.95rem;
        color: #333;
    }

    .card-back hr {
        margin: 10px 0;
        border: 0;
        border-top: 1px solid #eee;
    }

    .toggle-btn {
        display: inline-block;
        margin-top: 10px;
        background: #4caf50;
        color: #fff;
        padding: 8px 12px;
        border-radius: 8px;
        font-size: 0.9rem;
        cursor: pointer;
        transition: background 0.3s;
    }

    .toggle-btn:hover {
        background: #43a047;
    }

    footer {
        background-color: #1a1a1a;
        color: #fff;
        text-align: center;
        padding: 20px;
    }
</style>
</head>
<body>

<nav>
    <div class="nav-logo">
        <a href="/"><img src="{{ asset('images/logo1.png') }}" alt="Logo Nawi"></a>
    </div>
    <div class="nav-links">
        <a href="#">Taxistas</a>
        <a href="/sobre-nosotros">Sobre Nosotros</a>
    </div>
</nav>

<div class="container">
    <h1>Nuestros Taxistas</h1>

    <div class="grid">
        @foreach($taxistas as $taxista)
            <div class="card">
                <div class="card-inner">
                    <!-- FRONT -->
                    <div class="card-front">
                        <img src="{{ asset('images/taxistas/'.$taxista->foto_conductor) }}" alt="Foto de {{ $taxista->nombre }}">
                        <div class="card-body">
                            <h2>{{ $taxista->nombre }} {{ $taxista->apellidos }}</h2>
                            <p>Edad: {{ $taxista->edad }}</p>
                         
                        </div>
                    </div>

                    <!-- BACK -->
                    <div class="card-back">
                        <h2>{{ $taxista->nombre }} {{ $taxista->apellidos }}</h2>
                        <p>Teléfono: {{ $taxista->num_telefono }}</p>
                        <p>Estado: <strong>{{ ucfirst($taxista->estado) }}</strong></p>
                        <p>Turno: {{ ucfirst($taxista->turno ?? 'Desconocido') }}</p>
                        <hr>
                        @if($taxista->carro)
                            <h3>Taxi:</h3>
                            <p>Marca: {{ $taxista->carro->marca }}</p>
                            <p>Modelo: {{ $taxista->carro->modelo }}</p>
                            <p>Placa: {{ $taxista->carro->placa }}</p>
                            <p>Año: {{ $taxista->carro->anio }}</p>
                        @else
                            <p><em>Este taxista aún no tiene asignado un taxi.</em></p>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<footer>
    <p>&copy; 2025 NAWI TECNOLOGÍAS S.A. DE C.V. Todos los derechos reservados.</p>
</footer>

<script>
    // Script para el flip de tarjetas
    document.querySelectorAll('.card').forEach(card => {
        card.addEventListener('click', (e) => {
            // Solo girar si se hace clic en el botón
            card.classList.toggle('flipped');
        
        });
    });
</script>

</body>
</html>
