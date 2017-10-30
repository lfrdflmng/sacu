<?php
/**
 * Created by PhpStorm.
 * User: Alfredo
 * Date: 20/9/2017
 * Time: 5:23 PM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Modelo extends Model {

    use SoftDeletes;

    const CREATED_AT = 'fecha_creacion';

    const UPDATED_AT = 'fecha_actualizacion';

    const DELETED_AT = 'fecha_eliminacion';

    /**
     * Retorna los datos que se van a cargar en el DataTables
     *
     * @param array $campos
     * @return array
     */
    public static function traerData($campos = []) {
        return self::get(!empty($campos) ? $campos : ['id','nombre','descripcion'])->toArray();
    }


    /**
     * Proceso personalizado para eliminar un registro
     */
    public function eliminar() {
        //$this->delete();
        $campo_fecha_eliminacion = self::DELETED_AT;
        $this->$campo_fecha_eliminacion = date('Y-m-d H:i:s');
        $this->status = 0;
        $this->save();
    }

}