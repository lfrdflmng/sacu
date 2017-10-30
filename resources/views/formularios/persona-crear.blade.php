<!-- primer nombre -->
@component('componentes.inputs.texto', ['nombre' => 'primer_nombre'])
@endcomponent

<!-- segundo nombre -->
@component('componentes.inputs.texto', ['nombre' => 'segundo_nombre'])
@endcomponent

<!-- primer apellido -->
@component('componentes.inputs.texto', ['nombre' => 'primer_apellido'])
@endcomponent

<!-- segundo apellido -->
@component('componentes.inputs.texto', ['nombre' => 'segundo_apellido'])
@endcomponent

<!-- dni -->
@component('componentes.inputs.texto', ['nombre' => 'dni'])
@endcomponent

<!-- sexo -->
@component('componentes.inputs.seleccion', ['nombre' => 'sexo'])
    @slot('buscar', false)
    @slot('opciones', [
        '0' => __('persona.femenino'),
        '1' => __('persona.masculino')
    ])
@endcomponent

<!-- fecha de nacimiento -->
@component('componentes.inputs.fecha', ['nombre' => 'fecha_nacimiento'])
@endcomponent

<!-- direccion de domicilio -->
@component('componentes.inputs.texto', ['nombre' => 'direccion_domicilio'])
@endcomponent

<!-- foto -->
@component('componentes.inputs.imagen', ['nombre' => 'foto'])
@endcomponent