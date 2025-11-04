@extends('layouts.app')

@section('content')
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    html, body {
        height: 100%;
        background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)),
            url('https://static.wixstatic.com/media/952b60_67f559efb50a4101804756294550c92a~mv2.jpg')
            no-repeat center center/cover;
        color: #fff;
    }

    .container {
        position: relative;
        z-index: 2;
        width: 90%;
        max-width: 1200px;
        margin: 50px auto;
        animation: fadeIn 1s ease-in-out;
    }

    h1 {
        font-size: 3rem;
        font-weight: 700;
        margin-bottom: 20px;
        text-align: center;
        color: #000;
        text-shadow: 
            0 0 5px #e18222ff,
            0 0 10px #e18222ff,
            0 0 15px #e18222ff,
            0 0 20px #e18222ff,
            0 0 25px #e18222ff,
            2px 2px 4px rgba(255,255,255,0.3);
        animation: neonGlow 2s ease-in-out infinite alternate;
    }

    @keyframes neonGlow {
        from {
            text-shadow: 0 0 5px #efad6bff, 0 0 10px #efad6bff, 0 0 15px #efad6bff,
                         0 0 20px #efad6bff, 0 0 25px #efad6bff, 2px 2px 4px rgba(255,255,255,0.3);
        }
        to {
            text-shadow: 0 0 10px #fbdb5bff, 0 0 20px #fbdb5bff, 0 0 30px #fbdb5bff,
                         0 0 40px #fbdb5bff, 0 0 50px #fbdb5bff, 2px 2px 4px rgba(255,255,255,0.5);
        }
    }

    .intro-text {
        text-align: center;
        font-size: 1.3rem;
        font-weight: 500;
        background: linear-gradient(90deg, #ffc107, #e18222ff);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin-bottom: 50px;
        transition: transform 0.3s;
    }

    .intro-text:hover {
        transform: scale(1.05);
    }

    /* --- GRID TARJETAS --- */
    .grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
        gap: 25px;
    }

    .card {
        perspective: 1000px;
        min-height: 400px;
    }

    .card:nth-child(1) { animation-delay: 0.1s; }
    .card:nth-child(2) { animation-delay: 0.2s; }
    .card:nth-child(3) { animation-delay: 0.3s; }
    .card:nth-child(4) { animation-delay: 0.4s; }
    .card:nth-child(5) { animation-delay: 0.5s; }
    .card:nth-child(6) { animation-delay: 0.6s; }

    .card-inner {
        position: relative;
        width: 100%;
        height: 400px;
        transition: all 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        transform-style: preserve-3d;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.3);
    }

    .card:hover .card-inner {
        transform: rotateY(180deg);
    }

    .card-front, .card-back {
        position: absolute;
        width: 100%;
        height: 100%;
        backface-visibility: hidden;
        border-radius: 15px;
        overflow: hidden;
    }

    .card-front {
        background: rgba(255,255,255,0.1);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255,255,255,0.2);
        display: flex;
        flex-direction: column;
    }

    .card-front img {
        width: 100%;
        height: 60%;
        object-fit: cover;
        border-radius: 20px 20px 0 0;
        transition: all 0.3s ease;
    }

    .card:hover .card-front img {
        transform: scale(1.05);
    }

    .card-front .card-body {
        padding: 25px;
        text-align: center;
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
        z-index: 2;
        position: relative;
    }

    .card-front .card-body h2 {
        font-size: 1.2rem;
        margin-bottom: 5px;
        color: #ffc107;
    }

    .card-front .card-body p {
        font-size: 0.95rem;
        color: #fff;
        margin: 0;
    }

    .card-back {
        background: rgba(26,26,26,0.9);
        backdrop-filter: blur(10px);
        color: #fff;
        transform: rotateY(180deg);
        padding: 20px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: flex-start;
        border: 1px solid rgba(255,255,255,0.1);
    }

    .card-back h2 {
        font-size: 1.2rem;
        margin-bottom: 10px;
        color: #ffc107;
    }

    .card-back p {
        font-size: 0.95rem;
        margin-bottom: 8px;
        color: #ddd;
    }

    .card-back hr {
        width: 100%;
        border: 0;
        border-top: 1px solid rgba(255,255,255,0.2);
        margin: 10px 0;
    }

    footer {
        background: linear-gradient(180deg, #2c2c2c 0%, #1a1a1a 50%, #0f0f0f 100%);
        color: #fff;
        text-align: center;
        padding: 30px 20px;
        font-size: 0.9rem;
        letter-spacing: 1px;
        margin-top: 50px;
        position: relative;
        overflow: hidden;
    }

    footer::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, transparent 0%, #ff9900ff 25%, #ff9900ff 50%, transparent 75%);
        animation: roadLine 3s linear infinite;
    }

    @keyframes roadLine {
        0% { transform: translateX(-100%); }
        100% { transform: translateX(100%); }
    }

    footer p:first-child {
        color: #ffcc00;
        text-shadow: 0 0 10px #ffcc00;
        font-weight: 600;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<div class="container">
    <h1>Sobre Nosotros</h1>
    <p class="intro-text">Somos un grupo de desarrollo apasionado por la innovación, comprometido con crear soluciones creativas y funcionales para cada desafío.</p>

    <div class="grid">
        @php
            $equipo = [
                ['nombre' => 'Mariana Eurice Guillen Navarro', 'foto' => asset('images/integrantes/mariana.jpg')],
                ['nombre' => 'Froilan Najera Morales', 'foto' => asset('images/integrantes/froilan.jpg')],
                ['nombre' => 'Hugo Ruben Díaz Cruz', 'foto' => asset('images/integrantes/hugo.jpg')],
                ['nombre' => 'José Alejandro Díaz Gómez', 'foto' => asset('images/integrantes/alex.jpg')],
            ];
        @endphp

        @foreach($equipo as $miembro)
            <div class="card">
                <div class="card-inner">
                    <!-- FRONT -->
                    <div class="card-front">
                        <img src="{{ $miembro['foto'] ?? 'https://via.placeholder.com/400x300' }}" alt="{{ $miembro['nombre'] }}">
                        <div class="card-body">
                            <h2>{{ $miembro['nombre'] }}</h2>
                            <p>Desarrollador</p>
                        </div>
                    </div>

                    <!-- BACK -->
                    <div class="card-back">
                        <h2>{{ $miembro['nombre'] }}</h2>
                        <hr>
                        <p><strong>Rol en el equipo:</strong> Desarrollador</p>
                        <p>Apasionado por la innovación y la tecnología.</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<footer>
    <p>&copy; 2025 NAWI TECNOLOGÍAS S.A. DE C.V.</p>
    <p>Todos los derechos reservados.</p>
</footer>
@endsection



