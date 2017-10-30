<?php
$saltar_return = true;
include(resource_path('lang/' . App::getLocale() . '/persona.php')); //<-- $persona_lang

$estudiante_lang = array_merge($persona_lang, [
	'titulo' => 'Estudiante',
    'titulo_plural' => 'Estudiantes',

    'num_carnet' => 'Núm. Carnet',
    'fecha_ingreso' => 'Fecha de Ingreso',

    'crear_nueva_persona' => 'Datos personales',
    'asignar_persona_existente' => 'Asignar persona registrada',

    'id_persona' => 'Persona',

    //errores
    'persona_ya_asignada' => 'La persona ya está asignada a un estudiante.'
]);

return $estudiante_lang;