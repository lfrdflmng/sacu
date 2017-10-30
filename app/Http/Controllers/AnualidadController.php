<?php
/**
 * Created by PhpStorm.
 * User: Alfredo
 * Date: 07-Oct-17
 * Time: 10:06 PM
 */

namespace App\Http\Controllers;


class AnualidadController extends Controlador {

    protected $modelo = 'Anualidad';


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
            'nombre' => 'negritas_mayusculas'
        ];
    }


}