<?php
/**
 * $fuente
 * $mostrar_crear
 * $opciones_adicionales [[id, clases, enlace, titulo]]
 * $opciones_adicionales_seleccion [[id, clases, enlace, titulo]]
 */
    $mostrar_crear = empty($mostrar_crear) || $mostrar_crear;
?>
<div class="element-actions">
    <div class="btn-toolbar fuente-{{ $fuente }}" data-fuente="{{ $fuente }}" role="toolbar" aria-label="Barra de herramientas">

        @if (!empty($opciones_adicionales))
            <!-- botones adicionales -->
            <div class="barra-opciones">
                <button id="btn_group_drop_opciones_adicionales" type="button" class="btn btn-default mr-2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-fw fa-ellipsis-v"></i>
                </button>
                <div class="dropdown-menu" aria-labelledby="btn_group_drop_opciones_adicionales">
                    @foreach ($opciones_adicionales as $opcion)
                        <a{!! !empty($opcion['id']) ? (' id="' . $opcion['id'] . '"') : '' !!} class="dropdown-item{!! !empty($opcion['clases']) ? (' ' . $opcion['clases']) : '' !!}" href="{!! $opcion['enlace'] or '#' !!}">{!! $opcion['titulo'] !!}</a>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- tipo de vista / filtro -->
        <div class="btn-group mr-4" role="group" aria-label="Vista">
            <button type="button" class="btn btn-default btn-modo-cartas hidden-xs-down"><i class="fa fa-fw fa-th-large"></i></button>
            <button type="button" class="btn btn-default btn-modo-lista hidden-xs-down"><i class="fa fa-fw fa-list"></i></button>
            <!--button type="button" class="btn btn-default"><i class="fa fa-fw fa-filter"></i></button-->
        </div>

        <!-- editar / eliminar / opciones adicionales -->
        <div class="btn-group mr-2 item-acciones" role="group" aria-label="Acciones del elemento" style="display:none">
            <!-- botones adicionales selcción -->
            @if (!empty($opciones_adicionales_seleccion))
                <button id="btn_group_drop_opciones_adicionales_seleccion" type="button" class="btn btn-secondary" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-fw fa-ellipsis-v"></i>
                </button>
                <div class="dropdown-menu" aria-labelledby="btn_group_drop_opciones_adicionales_seleccion">
                    @foreach ($opciones_adicionales_seleccion as $opcion)
                        <a{!! !empty($opcion['id']) ? (' id="' . $opcion['id'] . '"') : '' !!} class="dropdown-item{!! !empty($opcion['clases']) ? (' ' . $opcion['clases']) : '' !!}" href="{!! $opcion['enlace'] or '#' !!}">{!! $opcion['titulo'] !!}</a>
                    @endforeach
                </div>
            @endif
            <button type="button" class="btn btn-secondary btn-editar" data-accion="editar"><i class="fa fa-fw fa-pencil"></i></button>
            <button type="button" class="btn btn-secondary btn-eliminar" data-accion="eliminar"><i class="fa fa-fw fa-trash"></i></button>
        </div>

        <!-- crear -->
        @if ($mostrar_crear)
        <div class="btn-group item-nuevo" role="group" aria-label="Agregar">
            <button type="button" class="btn btn-primary btn-nuevo" data-toggle="modal" data-target="#modal_nuevo_registro"><i class="fa fa-fw fa-plus"></i> {{ __('global.new') }}</button>
        </div>
        @endif
    </div>
</div>