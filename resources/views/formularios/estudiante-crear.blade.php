<!-- núm. de carnet -->
@component('componentes.inputs.texto', ['nombre' => 'num_carnet', 'autofocus' => true])
@endcomponent

<!-- fecha de ingreso -->
@component('componentes.inputs.fecha', ['nombre' => 'fecha_ingreso'])
@endcomponent

@component('componentes.pestanas')
    @slot('opciones', [
        'campos_crear_nueva_persona' => __('estudiante.crear_nueva_persona'),
        'campos_asignar_existente' => __('estudiante.asignar_persona_existente')
    ])
    @slot('activo', 'campos_crear_nueva_persona')
@endcomponent

<div id="campos_crear_nueva_persona" data-fn="seleccionPersonaNueva">
    <!-- campos para los datos de persona -->
    @include('formularios.persona-crear')
</div>

<div id="campos_asignar_existente" class="hidden" data-fn="seleccionPersonaExistente">
    <!-- campo para seleccionar la persona -->
    @component('componentes.inputs.seleccion', ['nombre' => 'id_persona'])
        @slot('remoto', true)
        @slot('fuente', 'Persona')
        @slot('plantilla', 'avatar')
    @endcomponent
</div>

<input type="hidden" name="persona_existente" id="persona_existente" value="0">