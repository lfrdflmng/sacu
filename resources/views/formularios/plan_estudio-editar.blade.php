@if (empty($no_id))
    <!-- id -->
    <input type="hidden" name="id">
@endif

<!-- carrera -->
@component('componentes.inputs.seleccion', ['nombre' => 'id_carrera', 'autofocus' => true])
    @slot('id', 'id_carrera_e')
    @slot('remoto', true)
    @slot('fuente', 'Carrera')
@endcomponent

{{--<!-- código -->
@component('componentes.inputs.texto', ['nombre' => 'codigo'])
@endcomponent--}}

<!-- nombre -->
@component('componentes.inputs.texto', ['nombre' => 'nombre', 'autofocus' => true])
    @slot('id', 'nombre_e')
@endcomponent

<!-- descripción -->
@component('componentes.inputs.texto', ['nombre' => 'descripcion'])
    @slot('id', 'descripcion_e')
@endcomponent

<!-- fecha -->
@component('componentes.inputs.fecha', ['nombre' => 'fecha'])
    @slot('id', 'fecha_e')
    @slot('formato', 'YYYY')
@endcomponent