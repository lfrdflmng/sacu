<?php
/**
* $id
* $nombre
* $etiqueta
*/
    if (empty($nombre)) {
        $nombre = uniqid();
    }

    if (empty($id)) {
        $id = $nombre;
    }

    if (!isset($etiqueta)) {
        if (!empty($GLOBALS['fuente'])) {
            $etiqueta = __($GLOBALS['fuente'] . '.' . $nombre);
        }
        else {
            $etiqueta = ucfirst($nombre);
        }
    }
?>
<div class="form-group">
    @if (!empty($etiqueta))
    <label for="{!! $id !!}" class="col-md-12">{!! $etiqueta !!}</label>
    @endif
    <div class="col-md-12">
        <input type="file" id="{!! $id !!}" name="{!! $nombre !!}_upload" class="dropify" data-min-width="40" data-min-height="40" data-allowed-file-extensions="jpg jpeg png">
        <input type="hidden" id="{!! $id !!}_upload_modificado" name="{!! $nombre !!}_upload_modificado" class="input-imagen-modificado" value="0">
        <input type="hidden" id="{!! $id !!}" name="{!! $nombre !!}" class="input-imagen" value="">
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        if (typeof window['inicializarCampoImagen'] === 'function') {
            window['inicializarCampoImagen']($('#{!! $id !!}'));
        }
    });
</script>