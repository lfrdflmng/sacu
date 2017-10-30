@if (empty($no_id))
    <!-- id -->
    <input type="hidden" name="id">
@endif

{{--<!-- código -->
@component('componentes.inputs.texto', ['nombre' => 'codigo')
    @slot('codigo_e')
@endcomponent--}}

<!-- nombre -->
@component('componentes.inputs.texto', ['nombre' => 'nombre', 'autofocus' => true])
    @slot('id', 'nombre_e')
@endcomponent

<!-- abreviatura -->
@component('componentes.inputs.texto', ['nombre' => 'abreviatura'])
    @slot('id', 'abreviatura_e')
@endcomponent

<!-- descripción -->
@component('componentes.inputs.texto', ['nombre' => 'descripcion'])
    @slot('id', 'descripcion_e')
@endcomponent

<!-- ht -->
@component('componentes.inputs.numero', ['nombre' => 'ht'])
    @slot('id', 'ht_e')
@endcomponent

<!-- hp -->
@component('componentes.inputs.numero', ['nombre' => 'hp'])
    @slot('id', 'hp_e')
@endcomponent

<!-- uc -->
@component('componentes.inputs.numero', ['nombre' => 'uc'])
    @slot('id', 'uc_e')
@endcomponent

<!-- facultades -->
@component('componentes.inputs.seleccion', ['nombre' => 'facultades', 'multiple'])
    @slot('id', 'facultades_e')
    @slot('remoto', true)
    @slot('multiple', true)
    @slot('fuente', 'Facultad')
@endcomponent