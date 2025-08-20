@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Editar Perfil</h2>
    <form action="{{ route('perfil.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Nombre</label>
            <input type="text" name="nombre" class="form-control" value="{{ $taxista->nombre }}">
        </div>

        <div class="mb-3">
            <label>Apellidos</label>
            <input type="text" name="apellidos" class="form-control" value="{{ $taxista->apellidos }}">
        </div>

        <div class="mb-3">
            <label>Edad</label>
            <input type="number" name="edad" class="form-control" value="{{ $taxista->edad }}">
        </div>

        <div class="mb-3">
            <label>INE</label>
            <input type="text" name="ine" class="form-control" value="{{ $taxista->ine }}">
        </div>

        <div class="mb-3">
            <label>Permiso</label>
            <input type="text" name="permiso" class="form-control" value="{{ $taxista->permiso }}">
        </div>

        <div class="mb-3">
            <label>Licencia</label>
            <input type="text" name="licencia" class="form-control" value="{{ $taxista->licencia }}">
        </div>

        <div class="mb-3">
            <label>Teléfono</label>
            <input type="text" name="num_telefono" class="form-control" value="{{ $taxista->num_telefono }}">
        </div>

        <div class="mb-3">
            <label>Foto del Conductor</label>
            <input type="file" name="foto_conductor" class="form-control">
            @if($taxista->foto_conductor)
                <img src="{{ asset('storage/'.$taxista->foto_conductor) }}" width="120" class="mt-2">
            @endif
        </div>

        <div class="mb-3">
            <label>Foto del Taxi</label>
            <input type="file" name="foto_taxi" class="form-control">
            @if($taxista->foto_taxi)
                <img src="{{ asset('storage/'.$taxista->foto_taxi) }}" width="120" class="mt-2">
            @endif
        </div>

        <div class="mb-3">
            <label>Ubicación Actual</label>
            <input type="text" name="ubicacion_actual" class="form-control" value="{{ $taxista->ubicacion_actual }}">
        </div>

        <div class="mb-3">
            <label>Estado</label>
            <select name="estado" class="form-control">
                <option value="activo" {{ $taxista->estado == 'activo' ? 'selected' : '' }}>Activo</option>
                <option value="inactivo" {{ $taxista->estado == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Turno</label>
            <select name="turno" class="form-control">
                <option value="mañana" {{ $taxista->turno == 'mañana' ? 'selected' : '' }}>Mañana</option>
                <option value="tarde" {{ $taxista->turno == 'tarde' ? 'selected' : '' }}>Tarde</option>
                <option value="noche" {{ $taxista->turno == 'noche' ? 'selected' : '' }}>Noche</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Carro Asignado (id_carro)</label>
            <input type="number" name="id_carro" class="form-control" value="{{ $taxista->id_carro }}">
        </div>

        <div class="mb-3">
            <label>Género (id_genero)</label>
            <input type="number" name="id_genero" class="form-control" value="{{ $taxista->id_genero }}">
        </div>

        <div class="mb-3">
            <label>Idioma (id_idioma)</label>
            <input type="number" name="id_idoma" class="form-control" value="{{ $taxista->id_idoma }}">
        </div>

        <div class="mb-3">
            <label>Nueva Contraseña</label>
            <input type="password" name="contrasena" class="form-control">
            <small>Dejar vacío si no deseas cambiarla</small>
        </div>

        <button type="submit" class="btn btn-success">Guardar Cambios</button>
    </form>
</div>
@endsection
