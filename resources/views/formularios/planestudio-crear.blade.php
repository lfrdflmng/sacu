{{--<!-- código -->
@component('componentes.inputs.texto', ['nombre' => 'codigo'])
@endcomponent--}}

<!-- carrera -->
@component('componentes.inputs.seleccion', ['nombre' => 'id_carrera', 'autofocus' => true])
    @slot('remoto', true)
    @slot('fuente', 'Carrera')
@endcomponent

<!-- nombre -->
@component('componentes.inputs.texto', ['nombre' => 'nombre'])
@endcomponent

<!-- descripción -->
@component('componentes.inputs.texto', ['nombre' => 'descripcion'])
@endcomponent

<!-- fecha -->
@component('componentes.inputs.fecha', ['nombre' => 'fecha'])
    @slot('formato', 'YYYY')
@endcomponent