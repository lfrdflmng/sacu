<?php
namespace App\Http\Controllers;


class CarreraController extends Controlador {

    protected $modelo = 'Carrera';


    public static function cabeceras() {
        return [
            'id',
            'codigo',
            'nombre',
            'abreviatura',
            'descripcion',
            'id_facultad',
            'id_tipo_carrera',
            'fecha_creacion'
        ];
    }


    public static function pies() {
        return [];
    }


    public static function configuracionColumnasDataTables() {
        return [
            'codigo'            => 'negritas_mayusculas',
            'nombre'            => 'titulo',
            'abreviatura'       => 'mayusculas',
            'fecha_creacion'    => 'fecha_hora',
            'id_facultad'       => 'etiqueta',
            'id_tipo_carrera'   => 'etiqueta'
        ];
    }


    public function itemDataAdicional($item) {
        //facultad
        $this->etiquetaCampoSeleccion($item, 'facultad');

        //tipo de carrera
        $this->etiquetaCampoSeleccion($item, 'tipo_carrera');
    }


    public function camposBusqueda() {
        return [
            'codigo',
            'nombre',
            'abreviatura',
            'descripcion'
        ];
    }

}