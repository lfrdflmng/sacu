<?php
/**
 * $id
 * $nombre
 * $etiqueta
 * $seleccionado
 */
    if (empty($nombre)) {
        $nombre = uniqid();
    }

    if (!isset($etiqueta)) {
        if (!empty($GLOBALS['fuente'])) {
            $etiqueta = __($GLOBALS['fuente'] . '.' . $nombre);
        }
        else {
            $etiqueta = ucfirst($nombre);
        }
    }

    $seleccionado_attr = !empty($seleccionado) ? ' checked="checked"' : '';

    if (empty($id)) {
        $id = $nombre;
    }

    $sufijo = !empty($GLOBALS['sufijo_id_campos']) ? $GLOBALS['sufijo_id_campos'] : '';
    $id .= $sufijo;
?>
<div class="form-group">
    <div class="md-checkbox">
        <input type="checkbox" id="{!! $id !!}" name="{!! $nombre !!}" value="1"{!! $seleccionado_attr !!}>
        <div></div>
    </div>
    @if (!empty($etiqueta))
        <label for="{!! $id !!}">{!! $etiqueta !!}</label>
    @endif
</div>