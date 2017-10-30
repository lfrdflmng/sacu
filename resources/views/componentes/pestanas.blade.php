<?php
/**
 * $id
 * $opciones : arreglo con las pestañas [id1 => texto1, id2 => text2]
 * $activo : id de la pestaña activa por defecto
 */
    if (empty($id)) {
        $id = uniqid('pestana');
    }

    if (empty($activo)) {
        $activo = true;
    }
?>
<ul id="{!! $id !!}" class="nav nav-tabs">
    @if (isset($opciones) && is_array($opciones))
        <?php $first = true; ?>
        @foreach ($opciones as $key => $opcion)
        <li class="nav-item">
            <a class="nav-link{!! ($activo === $key || $activo && $first) ? ' active' : '' !!}" href="#" data-destino="{!! $key !!}">{!! $opcion !!}</a>
        </li>
        <?php $first = false; ?>
        @endforeach
        {!! $slot !!}
    @endif
</ul>

<script type="text/javascript">
    $(document).ready(function() {
        if (typeof window['inicializarPestanas'] === 'function') {
            window['inicializarPestanas']($('#{!! $id !!}'));
        }
    });
</script>