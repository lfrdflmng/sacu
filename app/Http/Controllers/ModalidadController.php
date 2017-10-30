<?php
/**
 * Created by PhpStorm.
 * User: Alfredo
 * Date: 08-Oct-17
 * Time: 7:52 AM
 */

namespace App\Http\Controllers;


class ModalidadController extends Controlador {

    protected $modelo = 'Modalidad';


    public static function cabeceras() {
        return [
            'id',
            'nombre',
            'descripcion'
        ];
    }


    public static function pies() {
        return [];
    }


    public static function configuracionColumnasDataTables() {
        return [
            'nombre' => 'titulo'
        ];
    }


}