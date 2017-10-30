<?php
/**
 * $titulo
 * $mostrar_buscador
 * $mostrar_crear
 * $opciones_adicionales [[id, clases, enlace, titulo]]
 * $opciones_adicionales_seleccion [[id, clases, enlace, titulo]]
 */

    //mostrar buscador
    $mostrar_buscador = !isset($mostrar_buscador) || $mostrar_buscador;

    //mostrar crear
    $mostrar_crear = !isset($mostrar_crear) || $mostrar_crear;
?>
<div class="row barra-accion-superior">
    <div class="col-sm-4">
        <h6 class="element-header">
            {!! $titulo or __($fuente . '.titulo_plural') !!}
        </h6>
    </div>

    @if ($mostrar_buscador)
        <div class="col-sm-3">
            @component('componentes.tabla-buscador', ['fuente' => $fuente])
            @endcomponent
        </div>
    @endif

    <div class="col-sm-{!! $mostrar_buscador ? '5' : '8' !!}">
        @if (empty($slot->toHtml()))
            @component('componentes.tabla-barra', ['fuente' => $fuente])
                @slot('mostrar_crear', $mostrar_crear)
                @slot('opciones_adicionales', empty($opciones_adicionales) ? null : $opciones_adicionales)
                @slot('opciones_adicionales_seleccion', empty($opciones_adicionales_seleccion) ? null : $opciones_adicionales_seleccion)
            @endcomponent
        @else
            {!! $slot !!}
        @endif
    </div>
</div>