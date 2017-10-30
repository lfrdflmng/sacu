<?php
/**
 * Created by PhpStorm.
 * User: Alfredo
 * Date: 5/10/2017
 * Time: 12:08 PM
 */

namespace App\Http\Controllers;


use App\Decanatura;

class FacultadController extends Controlador {

    protected $modelo = 'Facultad';


    public static function cabeceras() {
        return [
            'id',
            'codigo',
            'nombre',
            'abreviatura',
            'descripcion',
            'decanatura',
            'fecha_creacion'
        ];
    }


    public static function pies() {
        return [];
    }


    public static function configuracionColumnasDataTables() {
        return [
            'codigo'            => 'negritas_mayusculas',
            'abreviatura'       => 'mayusculas',
            'decanatura'        => 'etiqueta',
            'fecha_creacion'    => 'fecha_hora'
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


    public function itemDataAdicional($item) {
        //se envía el nombre de la decanatura para ser cargada por el select2
        if (!empty($item->id_decanatura)) {
            $decanatura = Decanatura::find((int)$item->id_decanatura);
            if ($decanatura) {
                $this->especificarRespuesta('id_decanatura_lbl', $decanatura->nombre);
            }
        }
    }

}