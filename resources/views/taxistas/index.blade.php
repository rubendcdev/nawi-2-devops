@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    <style>
        .container, .container * {
            color: #fff !important;
        }
        h1, h2, h3, p, .intro-text {
            color: #fff !important;
        }
        .card-back p, .card-back h2, .card-back h3 {
            color: #fff !important;
        }
        .empty-state, .empty-state h3, .empty-state p {
            color: #fff !important;
        }
        footer, footer p {
            color: #fff !important;
        }
    </style>
@endpush

@section('content')

<div class="container">
    <h1>Taxistas Verificados</h1>
    <p class="intro-text">Conoce a los conductores registrados y verificados por NAWI.</p>

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
                            <img src="{{ asset('images/default-avatar.svg') }}" alt="Foto por defecto">
                        @endif
                        <div class="card-body">
                            <h2>{{ $taxista->usuario->nombre ?? 'Sin nombre' }} {{ $taxista->usuario->apellido ?? '' }}</h2>
                            <p>Taxista Verificado</p>
                        </div>
                    </div>

                    <!-- BACK -->
                    <div class="card-back">
                        <h2>{{ $taxista->usuario->nombre ?? 'Sin nombre' }} {{ $taxista->usuario->apellido ?? '' }}</h2>
                        <hr>

                        <p><strong>📧 Email:</strong> {{ $taxista->usuario->email ?? 'No disponible' }}</p>
                        <hr>
                        <h3>📄 Documentos</h3>
                        <p>Matrícula: <strong>{{ $taxista->matricula->estatus->nombre ?? 'Pendiente' }}</strong></p>
                        <p>Licencia: <strong>{{ $taxista->licencia->estatus->nombre ?? 'Pendiente' }}</strong></p>
                        <hr>
                        <h3>🚗 Vehículo</h3>
                        @if($taxista->taxis->count() > 0)
                            <p><strong>Marca:</strong> {{ $taxista->taxis->first()->marca }}</p>
                            <p><strong>Modelo:</strong> {{ $taxista->taxis->first()->modelo }}</p>
                            <p><strong>Número:</strong> #{{ $taxista->taxis->first()->numero_taxi }}</p>
                        @else
                            <p><em>No registrado</em></p>
                        @endif
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

<footer>
    <p>&copy; 2025 NAWI TECNOLOGÍAS S.A. DE C.V.</p>
    <p>Todos los derechos reservados.</p>
</footer>

<script type="text/javascript">
    // Guardar taxistas en localStorage para uso offline
    (function() {
        'use strict';

        function guardarTaxistasEnLocalStorage() {
            try {
                var taxistasData = @json($taxistas->toArray());
                if (taxistasData && Array.isArray(taxistasData) && taxistasData.length > 0) {
                    localStorage.setItem('taxistas', JSON.stringify(taxistasData));
                    console.log('Taxistas guardados en localStorage:', taxistasData.length);
                } else {
                    console.log('No hay taxistas para guardar');
                }
            } catch (e) {
                console.error('Error al guardar taxistas en localStorage:', e);
            }
        }

        // Ejecutar cuando el DOM esté listo
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', guardarTaxistasEnLocalStorage);
        } else {
            guardarTaxistasEnLocalStorage();
        }
    })();
</script>
@endsection
