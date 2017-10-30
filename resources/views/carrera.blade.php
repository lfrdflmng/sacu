@extends('layouts.admin')

@section('css')
@endsection


@section('contenido')
<!-- RASTRO -->
<ul class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="/">{{ __('global.home') }}</a>
    </li>
    <li class="breadcrumb-item">
        <span>{{ __($fuente . '.titulo_plural') }}</span>
    </li>
</ul>
<!-- /RASTRO -->

<!-- CONTENIDO PRINCIPAL -->
<div class="content-box">
    <div class="element-wrapper">

        @component('componentes.barra-accion-superior', ['fuente' => $fuente])
        @endcomponent

        <div class="element-box tabla-contenedor" style="display:none"> {{-- Se muestra luego cuando haya cargado con Javascript --}}
            @component('componentes.tabla', ['fuente' => $fuente])
            @endcomponent
        </div>

    </div>
</div>
<!-- /CONTENIDO PRINCIPAL -->

<!-- MODAL "NUEVO REGISTRO" -->
@component('componentes.modal', ['id' => 'modal_nuevo_registro'])
    @slot('titulo', __('global.new'))
    @slot('posicion', 'derecha')

    <!-- formulario -->
    @component('componentes.formulario')
        @include('formularios.' . $fuente . '-crear')
    @endcomponent
@endcomponent
<!-- /MODAL "NUEVO REGISTRO" -->

<!-- MODAL "EDITAR REGISTRO" -->
@component('componentes.modal', ['id' => 'modal_editar_registro'])
    @slot('titulo', __('global.edit'))
    @slot('posicion', 'derecha')

    <!-- formulario -->
    @component('componentes.formulario')
        @include('formularios.' . $fuente . '-editar')
    @endcomponent
@endcomponent
<!-- /MODAL "EDITAR REGISTRO" -->

@endsection


@section('script')
@endsection