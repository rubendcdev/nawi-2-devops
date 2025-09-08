@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Mi Perfil</h2>
    <div class="card">
        <div class="card-body">
            <p><strong>Nombre:</strong> {{ $taxista->nombre }} {{ $taxista->apellidos }}</p>
            <p><strong>Teléfono:</strong> {{ $taxista->num_telefono }}</p>
            <p><strong>Licencia:</strong> {{ $taxista->licencia ?? 'No registrada' }}</p>
            <a href="{{ route('perfil.edit') }}" class="btn btn-primary">Editar Perfil</a>
        </div>
    </div>
</div>
@endsection
