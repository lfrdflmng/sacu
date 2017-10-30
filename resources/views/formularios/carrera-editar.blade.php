@if (empty($no_id))
    <!-- id -->
    <input type="hidden" name="id">
@endif

<!-- código -->
{{--@component('componentes.inputs.texto', ['nombre' => 'codigo', 'autofocus' => true])
@endcomponent--}}

<!-- tipo carrera -->
@component('componentes.inputs.seleccion', ['nombre' => 'id_tipo_carrera'])
    @slot('id', 'id_tipo_carrera_e')
    @slot('remoto', true)
    @slot('fuente', 'TipoCarrera')
@endcomponent

<!-- facultad -->
@component('componentes.inputs.seleccion', ['nombre' => 'id_facultad'])
    @slot('id', 'id_facultad_e')
    @slot('remoto', true)
    @slot('fuente', 'Facultad')
@endcomponent

<!-- nombre -->
@component('componentes.inputs.texto', ['nombre' => 'nombre'])
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