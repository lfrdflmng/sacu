<?php
/**
 * $id
 * $nombre
 * $etiqueta
 * $valor
 * $placeholder
 */
    //nombre
    if (empty($nombre)) {
        $nombre = uniqid();
    }

    //etiqueta
    if (!isset($etiqueta)) {
        if (!empty($GLOBALS['fuente'])) {
            $etiqueta = __($GLOBALS['fuente'] . '.' . $nombre);
        }
        else {
            $etiqueta = ucfirst($nombre);
        }
    }

    //placeholder
    if (!isset($placeholder)) {
        $placeholder = $etiqueta;
    }

    //id
    if (empty($id)) {
        $id = $nombre;
    }
    $sufijo = !empty($GLOBALS['sufijo_id_campos']) ? $GLOBALS['sufijo_id_campos'] : '';
    $id .= $sufijo;

    //formato
    if (empty($formato)) {
        $formato = 'DD/MM/YYYY';
    }
    $attr_alias = $formato == 'DD/MM/YYYY' ? ' data-inputmask-alias="date"' : '';

    //autofocus
    $autofocus_attr = !empty($autofocus) ? ' autofocus' : '';
?>
<div class="form-group">
    @if (!empty($etiqueta))
        <label for="{!! $id !!}" class="col-md-12">{!! $etiqueta !!}</label>
    @endif
    <div class="col-md-12">
        <input type="text" id="{!! $id !!}" name="{!! $nombre !!}" class="form-control form-control-line input-fecha" value="{!! $valor or '' !!}" placeholder="{!! $placeholder !!}"{!! $attr_alias !!} data-inputmask-inputformat="{!! $formato !!}"{!! $autofocus_attr !!}>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        if (typeof window['inicializarCampoFecha'] === 'function') {
            window['inicializarCampoFecha']($('#{!! $id !!}'), '{!! $formato !!}', '{!! App::getLocale() !!}');
        }
    });
</script>