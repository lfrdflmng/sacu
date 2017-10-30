<?php

namespace App;

class Decanatura extends Modelo {

    public $timestamps = true;

    protected $table = 'decanatura';

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
        'abreviatura'
    ];


    /**
     * Devuélve las reglas de validación para un campo específico o el arreglo de reglas por defecto.
     *
     * @param string $campo     Nombre del campo del que se quiere las reglas de validación.
     * @param int $ignorar_id    ID del elemento que se está editando, si es el caso.
     * @return array|string
     */
    public static function reglasValidacion($campo = null, $ignorar_id = 0) {
        $reglas = [
            'id'            => 'integer',
            'id_usuario'    => 'integer',
            'nombre'        => 'required|max:60|unique:decanatura,nombre,' . $ignorar_id . ',id,fecha_eliminacion,NULL',
            'descripcion'   => 'max:255',
            'codigo'        => 'max:60|unique:decanatura,codigo,' . $ignorar_id . ',id,fecha_eliminacion,NULL',
            'abreviatura'   => 'max:15',
        ];
        if ($campo === null) {
            return $reglas;
        }
        return isset($reglas[$campo]) ? $reglas[$campo] : '';
    }


    /**
     * Devuélve los mensajes de validación para un campo específico o el arreglo de mensajes por defecto
     * Los mensajes se buscan en el archivo correspondiente en lang
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

    public function facultad() {
        return $this->hasMany('App\Facultad', 'id_decanatura', 'id');
    }


    # FILTROS


    # ASIGNACIONES


    # LECTURAS

    public function getCodigoAttribute() {
        return strtoupper($this->attributes['codigo']);
    }

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
            'id',
            'codigo',
            'nombre',
            'abreviatura',
            'descripcion',
            'fecha_creacion'
        ];
        return self::orderBy('fecha_creacion')
            ->get($campos)
            ->toArray();
    }

}