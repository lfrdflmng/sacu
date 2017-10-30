<?php
/**
 * Created by PhpStorm.
 * User: Alfredo
 * Date: 6/10/2017
 * Time: 3:54 PM
 */

namespace App;

class Carrera extends Modelo {

    public $timestamps = true;

    protected $table = 'carrera';

    /**
     * Los atributos que se pueden guardar
     *
     * @var array
     */
    protected $fillable = [
        'id_usuario',
        'nombre',
        'descripcion',
        'codigo',
        'abreviatura',
        'id_tipo_carrera',
        'id_facultad'
    ];


    /**
     * Devuélve los mensajes de validación para un campo específico o el arreglo de mensajes por defecto
     * Los mensajes se buscan en el archivo de correspondiente en lang
     *
     * @param string $campo     Nombre del campo del que se quiere las reglas de validación.
     * @param int $ignorar_id    ID del elemento que se está editando, si es el caso.
     * @return array|string
     */
    public static function reglasValidacion($campo = null, $ignorar_id = 0) {
        $reglas = [
            'id_usuario'        => 'integer',
            'nombre'            => 'required|max:60',
            'codigo'            => 'max:30|unique:carrera,codigo,' . $ignorar_id . ',id,fecha_eliminacion,NULL',
            'abreviatura'       => 'max:15',
            'id_facultad'       => 'required|integer',
            'id_tipo_carrera'   => 'required|integer'
        ];
        if ($campo === null) {
            return $reglas;
        }
        return isset($reglas[$campo]) ? $reglas[$campo] : '';
    }


    /**
     * Devuélve los mensajes para un campo específico o el arreglo de mensajes por defecto
     *
     * @param $campo
     * @return array|string
     */
    public static function mensajesValidacion($campo = null) {
        $mensajes = [

        ];
        if ($campo === null) {
            return $mensajes;
        }
        return isset($mensajes[$campo]) ? $mensajes[$campo] : '';
    }


    # RELACIONES


    # FILTROS


    # ASIGNACIONES


    # LECTURAS

    public function getNombreAttribute() {
        return ucwords($this->attributes['nombre']);
    }

    public function getAbreviaturaAttribute() {
        return strtoupper($this->attributes['abreviatura']);
    }

    public function getDescripcionAttribute() {
        return ucfirst(mb_strtolower($this->attributes['descripcion'], 'UTF-8'));
    }


    # METODOS

    public static function traerData($campos = null) {
        $campos = [
            'carrera.id',
            'carrera.codigo',
            'carrera.nombre',
            'carrera.abreviatura',
            'carrera.descripcion',
            'facultad.nombre AS facultad',
            'tipo_carrera.nombre AS tipo_carrera',
            'carrera.fecha_creacion'
        ];
        return self::selectRaw(implode(',', $campos))
            ->join('facultad', 'carrera.id_facultad', '=', 'facultad.id')
            ->join('tipo_carrera', 'carrera.id_tipo_carrera', '=', 'tipo_carrera.id')
            ->orderBy('fecha_creacion')
            ->get()
            ->toArray();
    }

}