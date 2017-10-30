<!-- código -->
{{--@component('componentes.inputs.texto', ['nombre' => 'codigo', 'autofocus' => true])
@endcomponent--}}

<!-- tipo carrera -->
@component('componentes.inputs.seleccion', ['nombre' => 'id_tipo_carrera', 'autofocus' => true])
    @slot('remoto', true)
    @slot('fuente', 'TipoCarrera')
@endcomponent

<!-- facultad -->
@component('componentes.inputs.seleccion', ['nombre' => 'id_facultad'])
    @slot('remoto', true)
    @slot('fuente', 'Facultad')
@endcomponent

<!-- nombre -->
@component('componentes.inputs.texto', ['nombre' => 'nombre'])
@endcomponent

<!-- abreviatura -->
@component('componentes.inputs.texto', ['nombre' => 'abreviatura'])
@endcomponent

<!-- descripción -->
@component('componentes.inputs.texto', ['nombre' => 'descripcion'])
@endcomponent