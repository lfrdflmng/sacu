@if (empty($no_id))
    <!-- id -->
    <input type="hidden" name="id">
@endif

<!-- nombre -->
@component('componentes.inputs.texto', ['nombre' => 'nombre', 'autofocus' => true])
    @slot('id', 'nombre_e')
@endcomponent

<!-- descripción -->
@component('componentes.inputs.texto', ['nombre' => 'descripcion'])
    @slot('id', 'descripcion_e')
@endcomponent