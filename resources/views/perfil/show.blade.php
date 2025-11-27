@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    <link rel="stylesheet" href="{{ asset('css/perfil.css') }}">
@endpush

@section('content')
<div class="container">
    <h2>Mi Perfil</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <p><strong>Nombre:</strong> {{ $user->name }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Teléfono:</strong> {{ $user->telefono ?? 'No registrado' }}</p>
            <p><strong>Dirección:</strong> {{ $user->direccion ?? 'No registrada' }}</p>
            <p><strong>Estado:</strong> {{ $user->activo ? 'Activo' : 'Inactivo' }}</p>

            <a href="{{ route('perfil.edit') }}" class="btn btn-primary">Editar Perfil</a>
        </div>
    </div>
</div>
@endsection
