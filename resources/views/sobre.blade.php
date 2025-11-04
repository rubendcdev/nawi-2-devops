@extends('layouts.app')

@section('content')
<style>
    /* Reset y configuración base */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    html, body {
        height: 100%;
        font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        overflow-x: hidden;
    }

    body {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        position: relative;
        min-height: 100vh;
    }

    /* Efectos de partículas animadas */
    body::before {
        content: '';
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background:
            radial-gradient(circle at 20% 80%, rgba(120, 119, 198, 0.3) 0%, transparent 50%),
            radial-gradient(circle at 80% 20%, rgba(255, 119, 198, 0.3) 0%, transparent 50%),
            radial-gradient(circle at 40% 40%, rgba(120, 219, 255, 0.3) 0%, transparent 50%);
        animation: float 6s ease-in-out infinite;
        pointer-events: none;
        z-index: 1;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(-20px) rotate(180deg); }
    }

    .container {
        position: relative;
        z-index: 2;
        width: 90%;
        max-width: 1400px;
        margin: 0 auto;
        padding: 60px 20px;
        animation: slideInUp 1s ease-out;
    }

    /* Header con efecto glassmorphism */
    .header {
        text-align: center;
        margin-bottom: 80px;
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(20px);
        border-radius: 30px;
        padding: 60px 40px;
        border: 1px solid rgba(255, 255, 255, 0.2);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    }

    h1 {
        font-size: 4rem;
        font-weight: 800;
        margin-bottom: 30px;
        background: linear-gradient(135deg, #fff 0%, #f0f8ff 50%, #e6f3ff 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        text-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        animation: titleGlow 3s ease-in-out infinite alternate;
    }

    @keyframes titleGlow {
        0% { filter: drop-shadow(0 0 5px rgba(255, 255, 255, 0.3)); }
        100% { filter: drop-shadow(0 0 20px rgba(255, 255, 255, 0.6)); }
    }

    .intro-text {
        font-size: 1.4rem;
        font-weight: 400;
        line-height: 1.8;
        color: rgba(255, 255, 255, 0.9);
        max-width: 800px;
        margin: 0 auto;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        animation: fadeInUp 1s ease-out 0.5s both;
    }

    /* Grid moderno con efectos */
    .grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 40px;
        margin-top: 60px;
    }

    /* Tarjetas con efecto 3D mejorado */
    .card {
        perspective: 1000px;
        height: 400px;
        animation: fadeInUp 1s ease-out;
        animation-fill-mode: both;
    }

    .card:nth-child(1) { animation-delay: 0.1s; }
    .card:nth-child(2) { animation-delay: 0.2s; }
    .card:nth-child(3) { animation-delay: 0.3s; }
    .card:nth-child(4) { animation-delay: 0.4s; }

    .card-inner {
        position: relative;
        width: 100%;
        height: 100%;
        transition: all 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        transform-style: preserve-3d;
        border-radius: 25px;
        box-shadow:
            0 20px 40px rgba(0, 0, 0, 0.1),
            0 0 0 1px rgba(255, 255, 255, 0.1);
    }

    .card:hover .card-inner {
        transform: rotateY(180deg) scale(1.05);
        box-shadow:
            0 30px 60px rgba(0, 0, 0, 0.2),
            0 0 0 1px rgba(255, 255, 255, 0.2);
    }

    .card-front, .card-back {
        position: absolute;
        width: 100%;
        height: 100%;
        backface-visibility: hidden;
        border-radius: 25px;
        overflow: hidden;
    }

    .card-front {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        position: relative;
    }

    .card-front::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, rgba(255,255,255,0.1) 0%, transparent 100%);
        z-index: 1;
    }

    .card-front img {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid rgba(255, 255, 255, 0.3);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
        z-index: 2;
        position: relative;
        transition: all 0.3s ease;
    }

    .card:hover .card-front img {
        transform: scale(1.1);
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.3);
    }

    .card-front h3 {
        color: white;
        font-size: 1.3rem;
        font-weight: 600;
        margin-top: 20px;
        text-align: center;
        z-index: 2;
        position: relative;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
    }

    .card-back {
        background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
        color: white;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: 30px;
        transform: rotateY(180deg);
        text-align: center;
    }

    .card-back h2 {
        font-size: 1.4rem;
        font-weight: 700;
        margin-bottom: 15px;
        color: #ffd700;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
    }

    .card-back p {
        font-size: 1rem;
        line-height: 1.6;
        margin-bottom: 10px;
        opacity: 0.9;
    }

    .card-back .role {
        background: rgba(255, 215, 0, 0.2);
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 0.9rem;
        font-weight: 600;
        margin-top: 15px;
        border: 1px solid rgba(255, 215, 0, 0.3);
    }

    /* Footer mejorado */
    footer {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(20px);
        color: rgba(255, 255, 255, 0.9);
        text-align: center;
        padding: 40px 20px;
        margin-top: 80px;
        border-radius: 25px;
        border: 1px solid rgba(255, 255, 255, 0.2);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    }

    footer p {
        margin: 8px 0;
        font-size: 1rem;
        font-weight: 500;
    }

    /* Animaciones */
    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(50px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Responsive */
    @media (max-width: 768px) {
        .container {
            padding: 40px 15px;
        }

        h1 {
            font-size: 2.5rem;
        }

        .intro-text {
            font-size: 1.2rem;
        }

        .header {
            padding: 40px 20px;
        }

        .grid {
            grid-template-columns: 1fr;
            gap: 30px;
        }

        .card {
            height: 350px;
        }
    }

    @media (max-width: 480px) {
        h1 {
            font-size: 2rem;
        }

        .intro-text {
            font-size: 1.1rem;
        }
    }
</style>

<div class="container">
    <div class="header">
        <h1>Sobre Nosotros</h1>
        <p class="intro-text">💻 Somos un grupo de desarrollo apasionado por la innovación, comprometido con crear soluciones creativas y funcionales para cada desafío.</p>
    </div>

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
                        <h3>{{ $miembro['nombre'] }}</h3>
                    </div>
                    <div class="card-back">
                        <h2>{{ $miembro['nombre'] }}</h2>
                        <p>💡 Rol en el equipo: Desarrollador</p>
                        <p>✨ Apasionado por la innovación y la tecnología.</p>
                        <div class="role">Desarrollador Full Stack</div>
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
