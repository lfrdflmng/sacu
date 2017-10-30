<?php
/**
 * $id
 * $nombre
 * $etiqueta
 * $buscar
 * $opciones
 * $remoto
 * $fuente
 * $placeholder
 * $multiple
 */
    if (empty($nombre)) {
        $nombre = uniqid();
    }

    if (empty($fuente)) {
        $fuente = (empty($GLOBALS['fuente'])) ? '' : $GLOBALS['fuente'];
    }

    if (!isset($etiqueta)) {
        if (!empty($fuente)) {
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

    //ruta / url
    if (empty($remoto)) { //sin ajax
        $url = false;
        $clase_remoto = '';
    }
    elseif ($remoto === true) { //ajax por defecto
        $url = URL::route('listado');
        $clase_remoto = ' select2ajax';
    }
    else { //ajax con ruta personalizada
        $url = $remoto;
        $clase_remoto = ' select2ajax';
    }

    //funcion plantilla
    if (empty($plantilla)) {
        $plantilla = false;
    }
    elseif ($plantilla == 'avatar') {
        $plantilla = 'formatoSeleccionAvatar';
    }

    //multiple
    $multiple_attr = !empty($multiple) ? ' multiple' : '';
    if (!empty($multiple)) $nombre .= '[]';

    //autofocus
    $autofocus_attr = !empty($autofocus) ? ' autofocus' : '';
?>
<div class="form-group">
    @if (!empty($etiqueta))
        <label for="{!! $id !!}" class="col-md-12">{!! $etiqueta !!}</label>
    @endif
    <div class="col-md-12">
        <select id="{!! $id !!}" name="{!! $nombre !!}" class="form-control form-control-line input-select{!! $clase_remoto !!}"{!! $autofocus_attr !!}{!! $multiple_attr !!}>
            @if (!empty($opciones) && is_array($opciones))
                @foreach ($opciones as $key => $val)
                    <option value="{!! $key !!}">{{ $val }}</option>
                @endforeach
            @endif
            {!! $slot !!}
        </select>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        if (typeof window['inicializarCampoSeleccion'] === 'function') {
            window['inicializarCampoSeleccion']($('#{!! $id !!}'), '{!! $placeholder !!}', {!! $url ? ('\'' . $url . '\'') : 'undefined' !!}, '{!! $fuente !!}', {!! $plantilla ? $plantilla : 'undefined' !!}, '{!! App::getLocale() !!}');
        }
    });
</script>