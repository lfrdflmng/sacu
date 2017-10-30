<?php
$persona_lang = [
    'titulo' => 'Persona',
    'titulo_plural' => 'Personas',

    'id' => 'ID',
    'nombres' => 'Nombres',
    'apellidos' => 'Apellidos',
    'primer_nombre' => 'Primer nombre',
    'segundo_nombre' => 'Segundo nombre',
    'primer_apellido' => 'Primer apellido',
    'segundo_apellido' => 'Segundo apellido',
    'dni' => 'DNI',
    'sexo' => 'Sexo',
    'masculino' => 'Masculino',
    'masculino_min' => 'M',
    'femenino' => 'Femenino',
    'femenino_min' => 'F',
    'direccion_domicilio' => 'Dirección de domicilio',
    'fecha_nacimiento' => 'Fecha de nacimiento',
    'foto' => 'Foto',

    'status' => 'Estado',
    'fecha_creacion' => 'Fecha de Registro',

    //tipos de contactos
    'tipo_telefono' => 'Teléfono',
    'tipo_correo' => 'Correo',
    'tipo_facebook' => 'Facebook',
    'tipo_twitter' => 'Twitter',
    'tipo_instagram' => 'Instagram',

    //validación

    'dni_not_unique' => 'El DNI ingresado ya existe con otro registro.'
];

if (!isset($saltar_return)) return $persona_lang;