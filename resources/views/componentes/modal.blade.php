<?php
/**
 * $id
 * $titulo
 * $posicion
 * $clases
 * $botones
 * $texto_boton_cerrar
 * $texto_boton_ok
 * $botones_adicionales
 */
    if (!isset($clases)) {
        $clases = '';
    }

    //posicion
    $subclases = '';
    if (isset($posicion)) {
        if ($posicion == 'derecha') {
            $clases .= ' right';
            $subclases = ' modal-full-height modal-right';
        }
        elseif ($posicion == 'centro') {
            $subclases .= ' modal-fluid';
        }
    }

    //texto botones
    $texto_boton_ok= !isset($texto_boton_ok) ? __('global.save') : $texto_boton_ok;
    $texto_boton_cerrar = !isset($texto_boton_cerrar) ? __('global.close') : $texto_boton_cerrar;
?>
<div class="modal fade {!! $clases or '' !!}" id="{!! $id or 'modal' !!}" role="dialog" aria-hidden="true">
    <div class="modal-dialog{!! $subclases !!}" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title{!! isset($posicion) && $posicion == 'centro' ? ' fijo' : '' !!}" id="{!! $id or 'modal' !!}_title">{!! $titulo or '' !!}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {!! $slot !!}
            </div>
            <div class="modal-footer">
                @if (!empty($botones_adicionales))
                    {!! $botones_adicionales !!}
                @endif
                @if (!isset($botones))
                <button type="button" class="btn btn-default" data-dismiss="modal">{!! strtoupper($texto_boton_cerrar) !!}</button>
                <button type="button" class="btn btn-primary btn-ok">{!! strtoupper($texto_boton_ok) !!}</button>
                @else
                {!! $botones !!}
                @endif
            </div>
        </div>
    </div>
</div>