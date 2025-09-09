@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Datos Personales</h2>

    <div class="card p-4 mb-3">
        <h4>Información General</h4>
        <p><strong>Nombre:</strong> {{ $user->name ?? '-' }}</p>
        <p><strong>Apellidos:</strong> {{ $user->apellidos ?? '-' }}</p>
        <p><strong>Edad:</strong> {{ $user->edad ?? '-' }}</p>
        <p><strong>Email:</strong> {{ $user->email ?? '-' }}</p>
        <p><strong>Teléfono:</strong> {{ $user->telefono ?? '-' }}</p>
        <p><strong>Dirección:</strong> {{ $user->direccion ?? '-' }}</p>
        <p><strong>Estado:</strong> {{ $user->estado ?? '-' }}</p>
        <p><strong>Turno:</strong> {{ $user->turno ?? '-' }}</p>
    </div>

    <div class="card p-4 mb-3">
        <h4>Documentos</h4>
        <p><strong>INE:</strong> {{ $user->ine ?? '-' }}</p>
        <p><strong>Permiso:</strong> {{ $user->permiso ?? '-' }}</p>
        <p><strong>Licencia:</strong> {{ $user->licencia ? basename($user->licencia) : '-' }}</p>
    </div>

    <div class="card p-4 mb-3">
        <h4>Fotos</h4>
        <p><strong>Foto del Conductor:</strong> {{ $user->foto_conductor ? basename($user->foto_conductor) : '-' }}</p>
        <p><strong>Foto del Taxi:</strong> {{ $user->foto_taxi ? basename($user->foto_taxi) : '-' }}</p>
    </div>

    <div class="card p-4">
        <h4>Vehículo y Otros</h4>
        <p><strong>ID Carro:</strong> {{ $user->id_carro ?? '-' }}</p>
        <p><strong>ID Género:</strong> {{ $user->id_genero ?? '-' }}</p>
        <p><strong>ID Idioma:</strong> {{ $user->id_idioma ?? '-' }}</p>
        <p><strong>Ubicación Actual:</strong> {{ $user->ubicacion_actual ?? '-' }}</p>
    </div>
</div>
@endsection
