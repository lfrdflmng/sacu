@if (empty($no_id))
<!-- id -->
<input type="hidden" name="id">
@endif

<!-- núm. de carnet -->
@component('componentes.inputs.texto', ['nombre' => 'num_carnet', 'autofocus' => true])
    @slot('id', 'num_carnet_e')
@endcomponent

<!-- fecha de ingreso -->
@component('componentes.inputs.fecha', ['nombre' => 'fecha_ingreso'])
    @slot('id', 'fecha_ingreso_e')
@endcomponent

@component('componentes.pestanas')
    @slot('opciones', [
        'campos_crear_nueva_persona_e' => __('estudiante.crear_nueva_persona'),
        'campos_asignar_existente_e' => __('estudiante.asignar_persona_existente')
    ])
    @slot('activo', 'campos_crear_nueva_persona_e')
@endcomponent

<div id="campos_crear_nueva_persona_e" data-fn="seleccionPersonaNuevaEditar">
    <!-- campos para los datos de persona -->
    @include('formularios.persona-editar', ['no_id' => true])
</div>

<div id="campos_asignar_existente_e" class="hidden" data-fn="seleccionPersonaExistenteEditar">
    <!-- campo para seleccionar la persona -->
    @component('componentes.inputs.seleccion', ['nombre' => 'id_persona'])
        @slot('id', 'id_persona_e')
        @slot('remoto', true)
        @slot('fuente', 'Persona')
        @slot('plantilla', 'avatar')
    @endcomponent
</div>

<input type="hidden" name="persona_existente" id="persona_existente_e" value="0">