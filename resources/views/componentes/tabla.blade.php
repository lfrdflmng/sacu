<?php
/**
 * id
 * $fuente
 * $cabeceras
 * $pies
 * $data
 * $configuracion_columnas
 */
    if (!empty($fuente)) {
        $ctrl = '\App\Http\Controllers\\' . ucfirst(camel_case($fuente)) . 'Controller';
        if (empty($cabeceras)) {
            $cabeceras = $ctrl::cabeceras();
        }
        if (empty($pies)) {
            $pies = $ctrl::pies();
        }
        $ctrl_configuracion_columnas = $ctrl::configuracionColumnasDataTables();
    }

    if (!isset($fuente)) {
        $fuente = '';
    }

    //para ser reusada en componentes
    $GLOBALS['fuente'] = $fuente;
?>
<!--div class="datatable-toolbar">
    <div class="ae-content-w">
        <div class="aec-head">
            <div class="actions-left"><!--a class="highlight" href="#"><i class="os-icon os-icon-ui-02"></i></a- -></div>
            <div class="actions-right">
                <div class="aeh-actions"><a href="#"><i class="os-icon os-icon-ui-44"></i></a><a class="separate" href="#"><i class="os-icon os-icon-ui-15"></i></a><a href="#"><i class="os-icon os-icon-common-07"></i></a><a href="#"><i class="os-icon os-icon-mail-19"></i></a></div>
            </div>
        </div>
    </div>
</div-->

<div class="table-hover">
    <table id="{{ $id or 'registros' }}" data-fuente="{{ $fuente }}" class="display table" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th class="num-fila"></th>
            @if (!empty($cabeceras))
                @foreach ($cabeceras as $cabecera)
                    @if (!empty($cabecera))
                        @if ($fuente && $cabecera != '&nbsp;')
                            <th>{{ __($fuente . '.' . $cabecera) }}</th>
                        @else
                            <th>{!! $cabecera !!}</th>
                        @endif
                    @endif
                @endforeach
            @endif
            </tr>
        </thead>

        @if (!empty($pies))
        <tfoot>
            <tr>
                <th class="num-fila"></th>
            @foreach ($pies as $pie)
                <th>{{ $pie }}</th>
            @endforeach
            </tr>
        </tfoot>
        @endif

        <tbody>
        @if (isset($data))
            @foreach ($data as $items)
            <tr>
                <td class="num-fila"></td>
                @foreach ($items as $item)
                    <td>{{ $item }}</td>
                @endforeach
            </tr>
            @endforeach
        @else
            {{ $slot }}
        @endif
        </tbody>
    </table>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $.fn.dataTableExt.sErrMode = 'throw';
        moment.locale('{{ App::getLocale() }}');

        //inicializa la tabla
        let $dt_main = $('#{{ $id or 'registros' }}').DataTable({
            ajax: '{{ URL::route($fuente . '_index') }}',
            lengthChange: false,
            searching: true,
            fixedHeader: {
                header: true,
                footer: true/*,
                headerOffset: 60*/
            },
            //scrollX: true,
            responsive: true,
            select: true,
            @if (App::getLocale() != 'en')
            language: {
                url: "{{ URL::asset('js/datatables.' . App::getLocale() . '.json') }}"
            },
            @endif
            columnDefs: [
                {
                    'targets': [1], //id
                    'visible': false,
                    'searchable': false
                }
                @foreach ($ctrl_configuracion_columnas as $columna => $plantilla)
                ,{
                    'targets': [{!! (int)array_search($columna, $cabeceras) + 1 !!}]
                    @if ($plantilla == 'oculta')
                    ,'visible': false
                    @else
                    ,'render': function(data) { return typeof Tabla !== 'undefined' ? Tabla.formatoColumna('{!! $plantilla !!}', data) : data }
                    @endif
                    @if ($plantilla == 'etiquetas')
                    ,'className': 'multilinea'
                    @endif
                }
                @endforeach
                @if (!empty($configuracion_columnas))
                ,{!! $configuracion_columnas !!}
                @endif
            ]
        });

        //evento cuando se cargan los datos desde el servidor
        $dt_main.on('xhr.dt', function(e) {
            let $tabla = $(e.target);
            let tabla_id = $tabla.attr('data-fuente');
            $('.btn-toolbar.fuente-' + tabla_id).find('.item-acciones').hide();
            if (typeof window['cargaTablaCompletada'] === 'function') {
                window['cargaTablaCompletada']($tabla);
            }
            setTimeout(function() {
                //permite seleccionar al hacer clic dentro del tr pero fuera del td (por defecto solo se puede dentro del td)
                $tabla.find('tr').click(function(e) {
                    if (e.target !== this) return;
                    let $tr = $(this);
                    if ($tr.hasClass('selected')) {
                        $tabla.DataTable().row(':eq(' + $tr.index() + ')', {page: 'current'}).deselect();
                    }
                    else {
                        if (!e.ctrlKey && !e.shiftKey) {
                            $tabla.DataTable().rows().deselect();
                        }
                        $tabla.DataTable().row(':eq(' + $tr.index() + ')', {page: 'current'}).select();
                    }
                });

                @if (!empty($funcion_doble_clic))
                //accion al hacer doble clic
                $tabla.find('tr').on('dblclick', function() {
                    let $tr = $(this);
                    $tabla.DataTable().rows().deselect();
                    $tabla.DataTable().row(':eq(' + $tr.index() + ')', {page: 'current'}).select();
                    if (typeof window['{!! $funcion_doble_clic !!}']) {
                        window['{!! $funcion_doble_clic !!}']($tr);
                    }
                });
                @endif
            },1500);
        });

        //evento cuando se selecciona un registro en la tabla
        $dt_main.on('select', function(e) {
            window['tabla_principal'].actualizarBarraAccionesItem();
        });

        //evento cuando se deselecciona un registro en la tabla
        $dt_main.on('deselect', function(e) {
            window['tabla_principal'].actualizarBarraAccionesItem();
        });

        {{-- crea una instancia de la clase Tabla (tabla.js) --}}
        window['tabla_principal'] = new Tabla('{{ $id or 'registros' }}');
    });
</script>