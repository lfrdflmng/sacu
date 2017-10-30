<?php
/**
 * $id
 * $titulo
 * $secciones
 */
    //id
    $id_attr = !empty($id) ? (' id="' . $id . '"') : '';

    //seccciones
    if (!isset($secciones)) $secciones = [];
?>
<div class="panel-lateral scroll"{!! $id_attr !!}>
    <div class="panel-lateral-cabecera">
        <h4>{!! $titulo or '' !!}</h4>
        <div class="panel-lateral-accion expandir">
            <span class="btn-colapsar">
                <i class="fa fa-minus"></i><span>{!! __('global.collapse') !!}</span>
            </span>
            <span class="btn-expandir">
                <i class="fa fa-plus"></i><span>{!! __('global.expand') !!}</span>
            </span>
        </div>
    </div>

    @foreach ($secciones as $seccion)
    <div class="panel-lateral-seccion">
        <div class="panel-lateral-alternar"><i class="fa fa-plus"></i></div>
        <h6 class="panel-lateral-seccion-cabecera">{!! $seccion['titulo'] !!}</h6>
        <div class="panel-lateral-contenido" style="display:none">
            {!! ${$seccion['nombre']} or '' !!}
        </div>
    </div>
    @endforeach

    {!! $slot !!}
</div>