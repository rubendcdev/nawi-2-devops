@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Editar Carro</h2>

    <form action="{{ route('carros.update', $carro->id_carro) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Placa</label>
            <input type="text" name="placa" class="form-control" value="{{ $carro->placa }}" required>
        </div>

        <div class="mb-3">
            <label>Modelo</label>
            <input type="text" name="modelo" class="form-control" value="{{ $carro->modelo }}" required>
        </div>

        <div class="mb-3">
            <label>Número de Serie</label>
            <input type="text" name="num_serie" class="form-control" value="{{ $carro->num_serie }}" required>
        </div>

        <div class="mb-3">
            <label>Año</label>
            <input type="number" name="anio" class="form-control" value="{{ $carro->anio }}" required>
        </div>

        <div class="mb-3">
            <label>Marca</label>
            <input type="text" name="marca" class="form-control" value="{{ $carro->marca }}" required>
        </div>

        <div class="mb-3">
            <label>Número de Taxi</label>
            <input type="number" name="num_taxi" class="form-control" value="{{ $carro->num_taxi }}">
        </div>

        <div class="mb-3">
            <label>Foto del Taxi</label>
            <input type="file" name="foto_taxi" class="form-control">
            @if($carro->foto_taxi)
                <small class="text-muted">Foto actual: {{ basename($carro->foto_taxi) }}</small>
            @endif
        </div>

        <button type="submit" class="btn btn-success">Actualizar</button>
        <a href="{{ route('carros.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
