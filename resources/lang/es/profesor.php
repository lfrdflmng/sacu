<?php
$saltar_return = true;
include(resource_path('lang/' . App::getLocale() . '/persona.php')); //<-- $persona_lang

$estudiante_lang = array_merge($persona_lang, [
    'titulo' => 'Profesor',
    'titulo_plural' => 'Profesores',

    'num_carnet' => 'Núm. Carnet',
    'fecha_ingreso' => 'Fecha de Ingreso',

    'crear_nueva_persona' => 'Datos personales',
    'asignar_persona_existente' => 'Asignar persona registrada',

    'id_persona' => 'Persona',

    'materias' => 'Materias',

    //errores
    'persona_ya_asignada' => 'La persona ya está asignada a un profesor.'
]);

return $estudiante_lang;