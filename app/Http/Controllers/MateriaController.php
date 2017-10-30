<?php
/**
 * Created by PhpStorm.
 * User: Alfredo
 * Date: 07-Oct-17
 * Time: 9:47 AM
 */

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Input;

class MateriaController extends Controlador {

    protected $modelo = 'Materia';

    public static function cabeceras() {
        return [
            'id',
            'codigo',
            'nombre',
            'abreviatura',
            'descripcion',
            'ht',
            'hp',
            'uc',
            'facultades',
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
            'facultades'        => 'etiquetas',
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


    /**
     * Después de guardar la materia, se guardan las facultades relacionadas
     *
     * @param $item
     */
    public function despuesDeGuardar($item) {
        $this->guardarRelaciones($item, 'facultades');
    }

    /**
     * Se envía los nombres y IDs de las facultades relacionadas
     *
     * @param $item
     */
    public function itemDataAdicional($item) {
        $this->etiquetaCampoSeleccionMultiples($item, 'facultades');
    }


}