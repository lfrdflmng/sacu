<?php
/**
 * $id
 * $nombre
 * $etiqueta
 * $valor
 * $placeholder
 * $autofocus
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

    if (!isset($placeholder)) {
        $placeholder = $etiqueta;
    }

    if (empty($id)) {
        $id = $nombre;
    }

    $sufijo = !empty($GLOBALS['sufijo_id_campos']) ? $GLOBALS['sufijo_id_campos'] : '';
    $id .= $sufijo;

    $autofocus_attr = !empty($autofocus) ? ' autofocus' : '';
?>
<div class="form-group">
    @if (!empty($etiqueta))
        <label for="{!! $id !!}" class="col-md-12">{!! $etiqueta !!}</label>
    @endif
    <div class="col-md-12">
        <input type="number" id="{!! $id !!}" name="{!! $nombre !!}" class="form-control form-control-line" min="0" value="{!! $valor or '' !!}" placeholder="{!! $placeholder !!}"{!! $autofocus_attr !!}>
    </div>
</div>