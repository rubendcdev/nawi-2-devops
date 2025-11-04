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
        background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
        position: relative;
        min-height: 100vh;
    }

    /* Efectos de fondo animado */
    body::before {
        content: '';
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background:
            radial-gradient(circle at 25% 25%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
            radial-gradient(circle at 75% 75%, rgba(255, 255, 255, 0.05) 0%, transparent 50%);
        animation: backgroundFloat 8s ease-in-out infinite;
        pointer-events: none;
        z-index: 1;
    }

    @keyframes backgroundFloat {
        0%, 100% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(-10px) rotate(1deg); }
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
        margin-bottom: 60px;
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(20px);
        border-radius: 30px;
        padding: 50px 40px;
        border: 1px solid rgba(255, 255, 255, 0.2);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    }

    h1 {
        font-size: 3.5rem;
        font-weight: 800;
        margin-bottom: 20px;
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

    .subtitle {
        font-size: 1.2rem;
        color: rgba(255, 255, 255, 0.8);
        font-weight: 400;
        animation: fadeInUp 1s ease-out 0.5s both;
    }

    /* Grid moderno */
    .grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
        gap: 30px;
        margin-top: 40px;
    }

    /* Tarjetas mejoradas */
    .card {
        perspective: 1000px;
        height: 450px;
        animation: fadeInUp 1s ease-out;
        animation-fill-mode: both;
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
        height: 100%;
        transition: all 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        transform-style: preserve-3d;
        border-radius: 20px;
        box-shadow:
            0 20px 40px rgba(0, 0, 0, 0.1),
            0 0 0 1px rgba(255, 255, 255, 0.1);
    }

    .card.flipped .card-inner {
        transform: rotateY(180deg) scale(1.02);
        box-shadow:
            0 30px 60px rgba(0, 0, 0, 0.2),
            0 0 0 1px rgba(255, 255, 255, 0.2);
    }

    .card-front, .card-back {
        position: absolute;
        width: 100%;
        height: 100%;
        backface-visibility: hidden;
        border-radius: 20px;
        overflow: hidden;
    }

    .card-front {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        flex-direction: column;
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
        width: 100%;
        height: 250px;
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
        font-size: 1.4rem;
        font-weight: 700;
        margin-bottom: 10px;
        color: white;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
    }

    .card-front .card-body .status {
        background: rgba(76, 175, 80, 0.2);
        color: #4caf50;
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 0.9rem;
        font-weight: 600;
        margin-bottom: 15px;
        border: 1px solid rgba(76, 175, 80, 0.3);
        display: inline-block;
    }

    .toggle-btn {
        background: rgba(255, 255, 255, 0.2);
        color: white;
        padding: 12px 24px;
        border-radius: 25px;
        font-size: 0.95rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        border: 1px solid rgba(255, 255, 255, 0.3);
        backdrop-filter: blur(10px);
    }

    .toggle-btn:hover {
        background: rgba(255, 255, 255, 0.3);
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
    }

    .card-back {
        background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
        color: white;
        padding: 30px;
        transform: rotateY(180deg);
        overflow-y: auto;
    }

    .card-back h2 {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 20px;
        color: #ffd700;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
    }

    .card-back h3 {
        font-size: 1.1rem;
        font-weight: 600;
        margin: 20px 0 10px 0;
        color: #ffd700;
        border-bottom: 2px solid rgba(255, 215, 0, 0.3);
        padding-bottom: 5px;
    }

    .card-back p {
        margin-bottom: 8px;
        font-size: 1rem;
        line-height: 1.5;
        opacity: 0.9;
    }

    .card-back .info-item {
        background: rgba(255, 255, 255, 0.1);
        padding: 10px 15px;
        border-radius: 10px;
        margin-bottom: 10px;
        border-left: 4px solid #ffd700;
    }

    .card-back .status-badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 15px;
        font-size: 0.85rem;
        font-weight: 600;
        margin-left: 10px;
    }

    .status-approved {
        background: rgba(76, 175, 80, 0.2);
        color: #4caf50;
        border: 1px solid rgba(76, 175, 80, 0.3);
    }

    .status-pending {
        background: rgba(255, 193, 7, 0.2);
        color: #ffc107;
        border: 1px solid rgba(255, 193, 7, 0.3);
    }

    /* Estado vacío */
    .empty-state {
        text-align: center;
        padding: 80px 20px;
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(20px);
        border-radius: 30px;
        border: 1px solid rgba(255, 255, 255, 0.2);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    }

    .empty-state h3 {
        font-size: 2rem;
        color: white;
        margin-bottom: 20px;
        font-weight: 600;
    }

    .empty-state p {
        font-size: 1.1rem;
        color: rgba(255, 255, 255, 0.8);
        line-height: 1.6;
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

        .header {
            padding: 40px 20px;
        }

        .grid {
            grid-template-columns: 1fr;
            gap: 25px;
        }

        .card {
            height: 400px;
        }
    }

    @media (max-width: 480px) {
        h1 {
            font-size: 2rem;
        }

        .subtitle {
            font-size: 1rem;
        }
    }
</style>

<div class="container">
    <div class="header">
        <h1>Taxistas Verificados</h1>
        <p class="subtitle">🚕 Conoce a nuestros taxistas certificados y verificados</p>
    </div>

    <div class="grid">
        @forelse($taxistas as $taxista)
            <div class="card">
                <div class="card-inner">
                    <!-- FRONT -->
                    <div class="card-front">
                        @if($taxista->usuario && $taxista->usuario->fotos && $taxista->usuario->fotos->count() > 0)
                            <img src="{{ asset('uploads/fotos/' . $taxista->usuario->fotos->first()->url) }}"
                                 alt="Foto de {{ $taxista->usuario->nombre ?? 'Taxista' }}">
                        @else
                            <img src="{{ asset('images/default-avatar.svg') }}"
                                 alt="Foto de {{ $taxista->usuario->nombre ?? 'Taxista' }}">
                        @endif
                        <div class="card-body">
                            <h2>{{ $taxista->nombre }} {{ $taxista->apellidos }}</h2>
                            <p>Edad: {{ $taxista->edad }}</p>

                            <h2>{{ $taxista->usuario->nombre ?? 'Sin nombre' }} {{ $taxista->usuario->apellido ?? '' }}</h2>
                            <div class="status">✅ Verificado</div>
                            <span class="toggle-btn">Ver información</span>
                        </div>
                    </div>

                    <!-- BACK -->
                    <div class="card-back">
                        <h2>{{ $taxista->usuario->nombre ?? 'Sin nombre' }} {{ $taxista->usuario->apellido ?? '' }}</h2>

                        <h3>📞 Contacto</h3>
                        <div class="info-item">
                            <strong>Teléfono:</strong> {{ $taxista->usuario->telefono ?? 'No disponible' }}
                        </div>
                        <div class="info-item">
                            <strong>Email:</strong> {{ $taxista->usuario->email ?? 'No disponible' }}
                        </div>

                        <h3>📋 Documentos</h3>
                        <div class="info-item">
                            <strong>Matrícula:</strong>
                            @if($taxista->matricula && $taxista->matricula->estatus)
                                {{ ucfirst($taxista->matricula->estatus->nombre) }}
                                <span class="status-badge {{ $taxista->matricula->estatus->nombre === 'aprobado' ? 'status-approved' : 'status-pending' }}">
                                    {{ $taxista->matricula->estatus->nombre === 'aprobado' ? 'Aprobado' : 'Pendiente' }}
                                </span>
                            @else
                                <em>Pendiente</em>
                                <span class="status-badge status-pending">Pendiente</span>
                            @endif
                        </div>
                        <div class="info-item">
                            <strong>Licencia:</strong>
                            @if($taxista->licencia && $taxista->licencia->estatus)
                                {{ ucfirst($taxista->licencia->estatus->nombre) }}
                                <span class="status-badge {{ $taxista->licencia->estatus->nombre === 'aprobado' ? 'status-approved' : 'status-pending' }}">
                                    {{ $taxista->licencia->estatus->nombre === 'aprobado' ? 'Aprobado' : 'Pendiente' }}
                                </span>
                            @else
                                <em>Pendiente</em>
                                <span class="status-badge status-pending">Pendiente</span>
                            @endif
                        </div>

                        <h3>🚗 Vehículo</h3>
                        @if($taxista->taxis->count() > 0)
                            <div class="info-item">
                                <strong>Marca:</strong> {{ $taxista->taxis->first()->marca }}
                            </div>
                            <div class="info-item">
                                <strong>Modelo:</strong> {{ $taxista->taxis->first()->modelo }}
                            </div>
                            <div class="info-item">
                                <strong>Número:</strong> #{{ $taxista->taxis->first()->numero_taxi }}
                            </div>
                        @else
                            <div class="info-item">
                                <em>Vehículo no registrado</em>
                            </div>
                        @endif

                        <span class="toggle-btn">Volver</span>
                    </div>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <h3>🚕 No hay taxistas verificados aún</h3>
                <p>Los taxistas aparecerán aquí una vez que sus documentos sean aprobados por el administrador.</p>
            </div>
        @endforelse
    </div>
</div>

<script>
    // Script para el flip de tarjetas
    document.querySelectorAll('.card').forEach(card => {
        card.addEventListener('click', (e) => {
            // Solo girar si se hace clic en el botón
            card.classList.toggle('flipped');

        });
    });
</script>
<script>
    // Persist minimal taxistas data for offline use
    try {
        const minimalTaxistas = @json(
            $taxistas->map(function ($t) {
                return [
                    'id' => $t->id,
                    'nombre' => optional($t->usuario)->nombre ?? 'Sin nombre',
                    'apellido' => optional($t->usuario)->apellido ?? '',
                    'email' => optional($t->usuario)->email ?? null,
                ];
            })
        );
        localStorage.setItem('taxistas', JSON.stringify(minimalTaxistas));
        // Optional timestamp to know freshness
        localStorage.setItem('taxistas_updated_at', new Date().toISOString());
    } catch (e) {
        console.warn('No se pudo guardar taxistas en localStorage', e);
    }
</script>
@endsection
