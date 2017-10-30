<?php
/**
 * Created by PhpStorm.
 * User: Alfredo
 * Date: 6/10/2017
 * Time: 2:48 PM
 */

namespace App\Http\Controllers;


class TipoCarreraController extends Controlador {

    protected $modelo = 'TipoCarrera';


    public static function cabeceras() {
        return [
            'id',
            'codigo',
            'nombre',
            'abreviatura',
            'descripcion',
            'fecha_creacion'
        ];
    }


    public function camposBusqueda() {
        return [
            'codigo',
            'nombre',
            'abreviatura',
            'descripcion'
        ];
    }


    public static function pies() {
        return [];
    }


    public static function configuracionColumnasDataTables() {
        return [
            'codigo'            => 'negritas_mayusculas',
            'abreviatura'       => 'mayusculas',
            'fecha_creacion'    => 'fecha_hora'
        ];
    }

}