@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Editar Perfil</h2>
    <form action="{{ route('perfil.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Nombre --}}
        <div class="mb-3">
            <label>Nombre</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}">
        </div>

        {{-- Teléfono --}}
        <div class="mb-3">
            <label>Teléfono</label>
            <input type="text" name="telefono" class="form-control" value="{{ old('telefono', $user->telefono) }}">
        </div>

        {{-- Dirección --}}
        <div class="mb-3">
            <label>Dirección</label>
            <input type="text" name="direccion" class="form-control" value="{{ old('direccion', $user->direccion) }}">
        </div>

        {{-- Estado (activo/inactivo) --}}
        <div class="mb-3">
            <label>Estado</label>
            <select name="activo" class="form-control">
                <option value="1" {{ $user->activo ? 'selected' : '' }}>Activo</option>
                <option value="0" {{ !$user->activo ? 'selected' : '' }}>Inactivo</option>
            </select>
        </div>

        {{-- Licencia (archivo) --}}
        <div class="mb-3">
            <label>Licencia (Archivo)</label>
            <input type="file" name="licencia" class="form-control">
            @if(!empty($user->licencia))
            @endif
        </div>

        {{-- Nueva Contraseña --}}
        <div class="mb-3">
            <label>Nueva Contraseña</label>
            <input type="password" name="password" class="form-control">
            <small class="text-muted">Dejar vacío si no deseas cambiarla</small>
        </div>

        <button type="submit" class="btn btn-success">Guardar Cambios</button>
    </form>
</div>
@endsection
