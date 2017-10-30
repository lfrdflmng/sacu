<?php
/**
 * $id
 * $url
 * $metodo
 * $con_archivo
 * $funcion_pre_enviar
 */
    //id
    if (!empty($id)) {
        $id_attr = 'id="' . $id . '"';
    }
    else {
        $id_attr = '';
    }

    //url
    if (empty($url)) {
        if (isset($GLOBALS['fuente'])) {
            $url = URL::route('post');
        }
        else {
            $url = '';
        }
    }

    //metodo
    if (empty($metodo)) {
        $metodo = 'POST';
    }

    //fuente
    if (isset($GLOBALS['fuente'])) {
        $fuente_input = '<input type="hidden" name="_fuente" class="static-value" autocomplete="off" value="' . $GLOBALS['fuente'] . '">';
    }
    else {
        $fuente_input = '';
    }

    //con_archivo
    $clase_archivo = !empty($con_archivo) ? ' con-archivo' : '';

    //funcion_pre_enviar
    $funcion_pre_enviar_attr = !empty($funcion_pre_enviar) ? (' data-fn_pre_enviar="' . $funcion_pre_enviar . '"') : '';

    //funcion_post_enviar
    $funcion_pos_enviar_attr = !empty($funcion_pos_enviar) ? (' data-fn_pos_enviar="' . $funcion_pos_enviar . '"') : '';
?>
@if (empty($no_form))
<form {!! $id_attr !!} class="form-material ajax-submit{!! $clase_archivo !!}" method="{!! $metodo !!}" action="{!! $url !!}" autocomplete="off"{!! $funcion_pre_enviar_attr !!}{!! $funcion_pos_enviar_attr !!}>
@endif
    {!! $slot !!}
    {!! $fuente_input !!}
    {!! csrf_field() !!}
@if (empty($no_form))
</form>
@endif