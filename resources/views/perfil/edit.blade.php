@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    <link rel="stylesheet" href="{{ asset('css/perfil.css') }}">
@endpush

@section('content')
<div class="perfil-form">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="perfil-card">
                    <h2><i class="fas fa-user-edit"></i> Editar Perfil</h2>
                    <form action="{{ route('perfil.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- Nombre (solo lectura) --}}
                        <div class="mb-3">
                            <label>Nombre</label>
                            <input type="text" class="form-control" value="{{ $user->name }}" disabled>
                        </div>

                        {{-- Correo (solo lectura) --}}
                        <div class="mb-3">
                            <label>Correo</label>
                            <input type="email" class="form-control"
                                   value="{{ $user->email }}" disabled>
                        </div>

                        {{-- Apellidos --}}
                        <div class="mb-3">
                            <label>Apellidos</label>
                            <input type="text" name="apellidos" class="form-control"
                                   value="{{ old('apellidos', $user->apellidos) }}">
                        </div>

                        {{-- Edad --}}
                        <div class="mb-3">
                            <label>Edad</label>
                            <input type="number" name="edad" class="form-control"
                                   value="{{ old('edad', $user->edad) }}">
                        </div>

                        {{-- INE --}}
                        <div class="mb-3">
                            <label>INE</label>
                            <input type="text" name="ine" class="form-control"
                                   value="{{ old('ine', $user->ine) }}">
                        </div>

                        {{-- Permiso de Circulación --}}
                        <div class="mb-3">
                            <label>permiso (Archivo)</label>
                            <input type="file" name="permiso" class="form-control">
                            @if(!empty($user->permiso))
                                <small class="text-muted">
                                    Archivo actual: {{ basename($user->permiso) }}
                                </small>
                            @endif
                        </div>

                        {{-- Teléfono --}}
                        <div class="mb-3">
                            <label>Teléfono</label>
                            <input type="text" name="telefono" class="form-control"
                                   value="{{ old('telefono', $user->telefono) }}">
                        </div>

                        {{-- Dirección --}}
                        <div class="mb-3">
                            <label>Dirección</label>
                            <input type="text" name="direccion" class="form-control"
                                   value="{{ old('direccion', $user->direccion) }}">
                        </div>

                        {{-- Estado --}}
                        <div class="mb-3">
                            <label>Estado</label>
                            <select name="estado" class="form-control">
                                <option value="activo" {{ $user->estado == 'activo' ? 'selected' : '' }}>Activo</option>
                                <option value="inactivo" {{ $user->estado == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                            </select>
                        </div>

                        {{-- Turno --}}
                        <div class="mb-3">
                            <label>Turno</label>
                            <select name="turno" class="form-control">
                                <option value="">--Seleccionar--</option>
                                <option value="mañana" {{ $user->turno == 'mañana' ? 'selected' : '' }}>Mañana</option>
                                <option value="tarde" {{ $user->turno == 'tarde' ? 'selected' : '' }}>Tarde</option>
                                <option value="noche" {{ $user->turno == 'noche' ? 'selected' : '' }}>Noche</option>
                            </select>
                        </div>

                        {{-- Licencia --}}
                        <div class="mb-3">
                            <label>Licencia (Archivo)</label>
                            <input type="file" name="licencia" class="form-control">
                            @if(!empty($user->licencia))
                                <small class="text-muted">
                                    Archivo actual: {{ basename($user->licencia) }}
                                </small>
                            @endif
                        </div>

                        {{-- Foto de conductor --}}
                        <div class="mb-3">
                            <label>Foto del conductor</label>
                            <input type="file" name="foto_conductor" class="form-control">
                            @if(!empty($user->foto_conductor))
                                <small class="text-muted">
                                    Archivo actual: {{ basename($user->foto_conductor) }}
                                </small>
                            @endif
                        </div>

                        {{-- Foto del taxi --}}
                        <div class="mb-3">
                            <label>Foto del taxi</label>
                            <input type="file" name="foto_taxi" class="form-control">
                            @if(!empty($user->foto_taxi))
                                <small class="text-muted">
                                    Archivo actual: {{ basename($user->foto_taxi) }}
                                </small>
                            @endif
                        </div>

                        {{-- Nueva Contraseña --}}
                        <div class="mb-3">
                            <label>Nueva Contraseña</label>
                            <input type="password" name="password" class="form-control">
                            <small class="text-muted">Dejar vacío si no deseas cambiarla</small>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <a href="{{ route('perfil.show') }}" class="btn btn-secondary me-2">
                                <i class="fas fa-times"></i> Cancelar
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save"></i> Guardar Cambios
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
