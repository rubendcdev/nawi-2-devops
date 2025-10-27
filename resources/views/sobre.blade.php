@extends('layouts.app')

@section('content')
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
        background: linear-gradient(135deg, #f4f7fb, #e2eafc);
    }

    body {
        display: flex;
        flex-direction: column;
        font-family: 'Montserrat', sans-serif;
        margin: 0;
        background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), 
            url('https://static.wixstatic.com/media/952b60_67f559efb50a4101804756294550c92a~mv2.jpg') 
            no-repeat center center/cover;
        color: #fff;
    }

    .container {
        flex: 1;
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
        color: #000000;
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
            text-shadow: 
                0 0 5px #efad6bff,
                0 0 10px #efad6bff,
                0 0 15px #efad6bff,
                0 0 20px #efad6bff,
                0 0 25px #efad6bff,
                2px 2px 4px rgba(255,255,255,0.3);
        }
        to {
            text-shadow: 
                0 0 10px #fbdb5bff,
                0 0 20px #fbdb5bff,
                0 0 30px #fbdb5bff,
                0 0 40px #fbdb5bff,
                0 0 50px #fbdb5bff,
                2px 2px 4px rgba(255,255,255,0.5);
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
        line-height: 1.6;
        transition: transform 0.3s;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 10px;
    }

    .intro-text:hover {
        transform: scale(1.05);
    }

    /* --- GRID EQUIPO --- */
    .grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
        gap: 25px;
    }

    /* --- TARJETAS FLIP --- */
    .card {
        perspective: 1000px;
    }

    .card-inner {
        position: relative;
        width: 100%;
        height: 320px;
        text-align: center;
        transition: transform 0.8s;
        transform-style: preserve-3d;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
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
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .card-front img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 15px;
    }

    .card-back {
        background: rgba(26, 26, 26, 0.8);
        backdrop-filter: blur(10px);
        color: #fff;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: 20px;
        transform: rotateY(180deg);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .card-back h2 {
        font-size: 1.2rem;
        margin-bottom: 10px;
        color: #ffc107;
    }

    .card-back p {
        font-size: 0.95rem;
        line-height: 1.5;
    }

    /* --- FOOTER CON FONDO DE CARRETERA --- */
    footer {
        background: 
            /* Asfalto base */
            linear-gradient(180deg, #2c2c2c 0%, #1a1a1a 50%, #0f0f0f 100%),
            /* Líneas de carretera */
            repeating-linear-gradient(
                90deg,
                transparent 0px,
                transparent 45px,
                #ffcc00ff 45px,
                #ffcc00ff 55px,
                transparent 55px,
                transparent 100px
            ),
            /* Efectos de desgaste del asfalto */
            radial-gradient(ellipse at 20% 50%, rgba(255,255,255,0.1) 0%, transparent 50%),
            radial-gradient(ellipse at 80% 30%, rgba(255,255,255,0.05) 0%, transparent 40%),
            /* Textura de asfalto */
            repeating-linear-gradient(
                45deg,
                transparent 0px,
                transparent 2px,
                rgba(255,255,255,0.02) 2px,
                rgba(255,255,255,0.02) 4px
            );
        color: #fff;
        text-align: center;
        padding: 30px 20px;
        font-size: 0.95rem;
        letter-spacing: 1px;
        margin-top: 40px;
        border-radius: 0;
        position: relative;
        overflow: hidden;
        box-shadow: 
            0 -5px 15px rgba(0,0,0,0.3),
            inset 0 1px 0 rgba(255,255,255,0.1);
    }

    /* Efectos adicionales de carretera */
    footer::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, 
            transparent 0%, 
            #ff9900ff 20%, 
            #ff9900ff 30%, 
            transparent 50%,
            #ff9900ff 70%,
            #ff9900ff 80%,
            transparent 100%
        );
        animation: roadLine 3s linear infinite;
    }

    footer::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 2px;
        background: linear-gradient(90deg, 
            #ff6b6b 0%, 
            #ff6b6b 10%, 
            transparent 10%, 
            transparent 20%,
            #ff6b6b 20%,
            #ff6b6b 30%,
            transparent 30%
        );
        opacity: 0.7;
    }

    @keyframes roadLine {
        0% { transform: translateX(-100%); }
        100% { transform: translateX(100%); }
    }

    footer p {
        margin: 8px 0;
        position: relative;
        z-index: 2;
        text-shadow: 0 1px 3px rgba(0,0,0,0.5);
    }

    /* Efecto de luces de neón en el texto */
    footer p:first-child {
        color: #ffcc00ff;
        text-shadow: 
            0 0 5px #ffcc00ff,
            0 0 10px #ffcc00ff,
            0 0 15px #ffcc00ff,
            0 1px 3px rgba(0,0,0,0.8);
        font-weight: 600;
    }

    footer p:last-child {
        color: #cccccc;
        font-size: 0.85rem;
    }

    /* --- ANIMACIONES --- */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 768px) {
        h1 { font-size: 2.2rem; }
        .intro-text { font-size: 1.1rem; text-align: center; }
        .card-inner { height: 280px; }
    }
</style>

<div class="container">
    <h1>Sobre Nosotros</h1>
    <p class="intro-text">💻 Somos un grupo de desarrollo apasionado por la innovación, comprometido con crear soluciones creativas y funcionales para cada desafío.</p>

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
                    <div class="card-front">
                        <img src="{{ $miembro['foto'] ?? 'https://via.placeholder.com/400x300' }}" alt="{{ $miembro['nombre'] }}">
                    </div>
                    <div class="card-back">
                        <h2>{{ $miembro['nombre'] }}</h2>
                        <p>💡 Rol en el equipo: Desarrollador</p>
                        <p>✨ Apasionado por la innovación y la tecnología.</p>
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
