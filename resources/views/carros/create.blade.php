@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Registrar Carro</h2>

    <form action="{{ route('carros.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label>Placa</label>
            <input type="text" name="placa" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Modelo</label>
            <input type="text" name="modelo" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Número de Serie</label>
            <input type="text" name="num_serie" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Año</label>
            <input type="number" name="anio" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Marca</label>
            <input type="text" name="marca" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Número de Taxi</label>
            <input type="number" name="num_taxi" class="form-control">
        </div>

        <div class="mb-3">
            <label>Foto del Taxi</label>
            <input type="file" name="foto_taxi" class="form-control">
        </div>

        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="{{ route('carros.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
