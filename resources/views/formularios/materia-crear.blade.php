{{--<!-- código -->
@component('componentes.inputs.texto', ['nombre' => 'codigo')
@endcomponent--}}

<!-- nombre -->
@component('componentes.inputs.texto', ['nombre' => 'nombre', 'autofocus' => true])
@endcomponent

<!-- abreviatura -->
@component('componentes.inputs.texto', ['nombre' => 'abreviatura'])
@endcomponent

<!-- descripción -->
@component('componentes.inputs.texto', ['nombre' => 'descripcion'])
@endcomponent

<!-- ht -->
@component('componentes.inputs.numero', ['nombre' => 'ht'])
@endcomponent

<!-- hp -->
@component('componentes.inputs.numero', ['nombre' => 'hp'])
@endcomponent

<!-- uc -->
@component('componentes.inputs.numero', ['nombre' => 'uc'])
@endcomponent

<!-- facultades -->
@component('componentes.inputs.seleccion', ['nombre' => 'facultades', 'multiple'])
    @slot('remoto', true)
    @slot('multiple', true)
    @slot('fuente', 'Facultad')
@endcomponent