@if (empty($no_id))
<!-- id -->
<input type="hidden" name="id">
@endif

<!-- primer nombre -->
@component('componentes.inputs.texto', ['nombre' => 'primer_nombre'])
    @slot('id', 'primer_nombre_e')
@endcomponent

<!-- segundo nombre -->
@component('componentes.inputs.texto', ['nombre' => 'segundo_nombre'])
    @slot('id', 'segundo_nombre_e')
@endcomponent

<!-- primer apellido -->
@component('componentes.inputs.texto', ['nombre' => 'primer_apellido'])
    @slot('id', 'primer_apellido_e')
@endcomponent

<!-- segundo apellido -->
@component('componentes.inputs.texto', ['nombre' => 'segundo_apellido'])
    @slot('id', 'segundo_apellido_e')
@endcomponent

<!-- dni -->
@component('componentes.inputs.texto', ['nombre' => 'dni'])
    @slot('id', 'dni_e')
@endcomponent

<!-- sexo -->
@component('componentes.inputs.seleccion', ['nombre' => 'sexo'])
    @slot('id', 'sexo_e')
    @slot('buscar', false)
    @slot('opciones', [
        '0' => __('persona.femenino'),
        '1' => __('persona.masculino')
    ])
@endcomponent

<!-- fecha de nacimiento -->
@component('componentes.inputs.fecha', ['nombre' => 'fecha_nacimiento'])
    @slot('id', 'fecha_nacimiento_e')
@endcomponent

<!-- direccion de domicilio -->
@component('componentes.inputs.texto', ['nombre' => 'direccion_domicilio'])
    @slot('id', 'direccion_domicilio_e')
@endcomponent

<!-- foto -->
@component('componentes.inputs.imagen', ['nombre' => 'foto'])
    @slot('id', 'foto_e')
@endcomponent