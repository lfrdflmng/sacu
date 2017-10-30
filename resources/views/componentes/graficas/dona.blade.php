<?php
/**
 * $tamano
 * $data
 */
    //tamaño
    if (empty($tamano)) $tamano = 150;

    //data

?>
<div class="el-chart-w">
    <canvas height="{!! $tamano !!}" id="donutChart" width="{!! $tamano !!}" style="display:block; width:{!! $tamano !!}px; height:{!! $tamano !!}px;"></canvas>
    <div class="inside-donut-chart-label"><strong>{!! $total['estudiante'] !!}</strong><span>{!! __('estudiante.titulo_plural') !!}</span></div>
</div>
<div class="el-legend">
    @foreach ($data as $item)
    <div class="legend-value-w">
        <div class="legend-pin" style="background-color: {!! $item['color'] or '' !!};"></div>
        <div class="legend-value">{!! $item['nombre'] !!}</div>
    </div>
    @endforeach
    <div class="legend-value-w">
        <div class="legend-pin" style="background-color: #f06292;"></div>
        <div class="legend-value">Femenino</div>
    </div>
</div>