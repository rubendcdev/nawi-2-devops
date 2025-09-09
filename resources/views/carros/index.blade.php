@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Vehículo</h2>
    <a href="{{ route('carros.create') }}" class="btn btn-primary mb-3">Agregar vehiculo</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Placa</th>
                <th>Modelo</th>
                <th>Año</th>
                <th>Marca</th>
                <th>Número Taxi</th>
                <th>Foto</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($carros as $carro)
                <tr>
                    <td>{{ $carro->id_carro }}</td>
                    <td>{{ $carro->placa }}</td>
                    <td>{{ $carro->modelo }}</td>
                    <td>{{ $carro->anio }}</td>
                    <td>{{ $carro->marca }}</td>
                    <td>{{ $carro->num_taxi }}</td>
                    <td>
                        @if($carro->foto_taxi)
                            <img src="{{ asset('storage/' . $carro->foto_taxi) }}" width="80">
                        @else
                            <small>No tiene foto</small>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('carros.show', $carro->id_carro) }}" class="btn btn-info btn-sm">Ver</a>
                        <a href="{{ route('carros.edit', $carro->id_carro) }}" class="btn btn-warning btn-sm">Editar</a>
                        <form action="{{ route('carros.destroy', $carro->id_carro) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que deseas eliminar este carro?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">No hay carros registrados</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
