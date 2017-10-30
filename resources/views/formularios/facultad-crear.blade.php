<!-- código -->
@component('componentes.inputs.texto', ['nombre' => 'codigo', 'autofocus' => true])
@endcomponent

<!-- nombre -->
@component('componentes.inputs.texto', ['nombre' => 'nombre'])
@endcomponent

<!-- descripción -->
@component('componentes.inputs.texto', ['nombre' => 'descripcion'])
@endcomponent

<!-- abreviatura -->
@component('componentes.inputs.texto', ['nombre' => 'abreviatura'])
@endcomponent

<!-- decanatura -->
@component('componentes.inputs.seleccion', ['nombre' => 'id_decanatura'])
    @slot('remoto', true)
    @slot('fuente', 'Decanatura')
@endcomponent