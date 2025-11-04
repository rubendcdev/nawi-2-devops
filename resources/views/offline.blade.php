@extends('layouts.app')

@section('content')

<div class="hoja-libreta">
    <h1 class="hoja-titulo">Taxistas (Offline)</h1>
    <div id="lista-taxistas"></div>
    </div>

    <script type="text/javascript">
        (function () {
            var taxistas = [];
            try {
                taxistas = JSON.parse(localStorage.getItem('taxistas') || '[]');
            } catch (e) { taxistas = []; }

            if (!Array.isArray(taxistas) || taxistas.length === 0) {
                $('#lista-taxistas').append('<p class="hoja-aviso">No hay taxistas guardados para mostrar sin conexión.</p>');
                return;
            }

            taxistas.forEach(function (t) {
                var nombreCompleto = [t.nombre || '', t.apellido || ''].join(' ').trim();
                $('#lista-taxistas').append(
                    '<p class="lista-cat">' +
                    (nombreCompleto || 'Taxista') +
                    (t.email ? ' <small style="opacity:.7">(' + t.email + ')</small>' : '') +
                    '</p>'
                );
            });
        })();
    </script>
@endsection
