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
        footer, footer p {
            color: #fff !important;
        }
    </style>
@endpush

@section('content')

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



