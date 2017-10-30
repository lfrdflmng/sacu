<?php
/**
 * $id
 * $tamano
 * $data [[nombre,valor,color]]
 * $usar_decimales
 */
    //id
    if (empty($id)) $id = uniqid('chart');

    //tamaño
    if (empty($tamano)) $tamano = 150;

    //usar decimales
    $usar_decimales = !empty($usar_decimales);

    $total = 0;
    foreach ($data as $key => $item) {
        //total
        if ($usar_decimales) {
            $total += (float)$item['valor'];
        }
        else {
            $total += (int)$item['valor'];
        }

        //colores
        if (empty($item['color'])) {
            $data[$key]['color'] = \App\Funciones::randomColor();
        }
    }
?>
<div class="el-chart-w">
    <canvas height="{!! $tamano !!}" id="{!! $id !!}" width="{!! $tamano !!}" style="display:block; width:{!! $tamano !!}px; height:{!! $tamano !!}px;"></canvas>
    <div class="inside-donut-chart-label"><strong>{!! $total !!}</strong><span>{!! __('estudiante.titulo_plural') !!}</span></div>
</div>
<div class="el-legend">
    @foreach ($data as $item)
        <div class="legend-value-w">
            <div class="legend-pin" style="background-color: {!! $item['color'] !!};"></div>
            <div class="legend-value">{!! $item['nombre'] !!}</div>
        </div>
    @endforeach
</div>

<script type="text/javascript">
    $(document).ready(function() {
        let data = {
            labels: ['{!! implode("', '", array_pluck($data, 'nombre')) !!}'],
            datasets: [{
                data: [{!! implode(', ', array_pluck($data, 'valor')) !!}],
                backgroundColor: ['{!! $c_str = implode("', '", array_pluck($data, 'color')) !!}'],
                hoverBackgroundColor: ['{!! $c_str !!}'],
                borderWidth: 0
            }]
        };

        inicializarGraficaDona($('#{!! $id !!}'), data);
    });
</script>