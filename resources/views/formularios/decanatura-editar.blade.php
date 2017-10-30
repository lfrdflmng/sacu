@if (empty($no_id))
<!-- id -->
<input type="hidden" name="id">
@endif

<!-- código -->
@component('componentes.inputs.texto', ['nombre' => 'codigo', 'autofocus' => true])
    @slot('id', 'codigo_e')
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