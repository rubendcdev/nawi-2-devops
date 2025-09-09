@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Detalles del Carro</h2>

    <ul class="list-group">
        <li class="list-group-item"><strong>ID:</strong> {{ $carro->id_carro }}</li>
        <li class="list-group-item"><strong>Placa:</strong> {{ $carro->placa }}</li>
        <li class="list-group-item"><strong>Modelo:</strong> {{ $carro->modelo }}</li>
        <li class="list-group-item"><strong>Número de Serie:</strong> {{ $carro->num_serie }}</li>
        <li class="list-group-item"><strong>Año:</strong> {{ $carro->anio }}</li>
        <li class="list-group-item"><strong>Marca:</strong> {{ $carro->marca }}</li>
        <li class="list-group-item"><strong>Número Taxi:</strong> {{ $carro->num_taxi }}</li>
        <li class="list-group-item">
            <strong>Foto:</strong> 
            @if($carro->foto_taxi)
                <img src="{{ asset('storage/' . $carro->foto_taxi) }}" width="150">
            @else
                <small>No tiene foto</small>
            @endif
        </li>
    </ul>

    <a href="{{ route('carros.index') }}" class="btn btn-secondary mt-3">Volver</a>
</div>
@endsection
