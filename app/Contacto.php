<?php
/**
 * Created by PhpStorm.
 * User: Alfredo
 * Date: 29/9/2017
 * Time: 4:12 PM
 */

namespace App;

class Contacto extends Modelo {

    public $timestamps = true;

    protected $table = 'contacto';

    /**
     * Los atributos que se pueden guardar
     *
     * @var array
     */
    protected $fillable = [
        'id_persona',
        'valor',
        'tipo'
    ];

    const TIPO_TELEFONO = 1;
    const TIPO_CORREO = 2;
    const TIPO_FACEBOOK = 3;
    const TIPO_TWITTER = 4;
    const TIPO_INSTAGRAM = 5;


    /**
     * Retorna el arreglo o elemento del arreglo de los tipos de contactos
     *
     * @param null $index
     * @return array|mixed|string
     */
    public function tiposContacto($index = null) {
        $arr = [
            self::TIPO_TELEFONO => 'tipo_telefono',
            self::TIPO_CORREO => 'tipo_correo',
            self::TIPO_FACEBOOK => 'tipo_facebook',
            self::TIPO_TWITTER => 'tipo_twitter',
            self::TIPO_INSTAGRAM => 'tipo_instagram',
        ];

        if (!empty($index)) {
            return isset($arr[$index]) ? $arr[$index] : '';
        }

        return $arr;
    }


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
            'id_persona'    => 'required|integer',
            'valor'         => 'required',
            'tipo'          => 'integer'
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

    public function persona() {
        return $this->belongsTo('App\Persona', 'id_persona', 'id');
    }


    # FILTROS


    # ASIGNACIONES


    # LECTURAS


    # METODOS


}