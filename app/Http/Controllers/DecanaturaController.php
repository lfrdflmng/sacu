<?php
/**
 * Created by PhpStorm.
 * User: Alfredo
 * Date: 24-Sep-17
 * Time: 6:26 PM
 */

namespace App\Http\Controllers;


class DecanaturaController extends Controlador {

    protected $modelo = 'Decanatura';


    /*public function index() {
        $dt = new DatatablesController;
        /*$dt->draw = 1;
        $dt->records_total = 0;
        $dt->records_filtered = 0;* /
        $dt->data = $this->data();
        return $dt->json();
    }*/


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


    public static function pies() {
        return [];
    }


    public function camposBusqueda() {
        return [
            'codigo',
            'nombre',
            'abreviatura',
            'descripcion'
        ];
    }


    public static function configuracionColumnasDataTables() {
        return [
            'codigo'            => 'negritas_mayusculas',
            'abreviatura'       => 'mayusculas',
            'fecha_creacion'    => 'fecha_hora'
        ];
    }


    /*public function data() {
        $modelo = '\App\\' . $this->modelo;
        $data = $modelo::traerDataVista(self::cabeceras());
        dd($data);
        return $data;
    }*/

}