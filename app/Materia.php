<?php
/**
 * Created by PhpStorm.
 * User: Alfredo
 * Date: 07-Oct-17
 * Time: 8:33 AM
 */

namespace App;

class Materia extends Modelo {

    public $timestamps = true;

    protected $table = 'materia';

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
        'ht',
        'hp',
        'uc'
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
            'id'            => 'integer',
            'id_usuario'    => 'integer',
            'nombre'        => 'required|max:60|unique:materia,nombre,' . $ignorar_id . ',id,fecha_eliminacion,NULL',
            'descripcion'   => 'max:255',
            'codigo'        => 'max:60',
            'abreviatura'   => 'max:15',
            'ht'            => 'nullable|integer',
            'hp'            => 'nullable|integer',
            'uc'            => 'nullable|integer'
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

    public function facultades() {
        return $this->belongsToMany('App\Facultad', 'materia_facultad', 'id_materia', 'id_facultad');
    }


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
            'materia.id',
            'materia.codigo',
            'materia.nombre',
            'materia.abreviatura',
            'materia.descripcion',
            'materia.ht',
            'materia.hp',
            'materia.uc',
            'STRING_AGG(facultad.nombre, \'|\') AS facultades', //MySQL = GROUP_CONCATENATE
            'materia.fecha_creacion'
        ];
        return self::selectRaw(implode(',', $campos))
            ->join('materia_facultad', 'materia_facultad.id_materia', '=', 'materia.id', 'left')
            ->join('facultad', 'materia_facultad.id_facultad', '=', 'facultad.id', 'left')
            ->groupBy('materia.id')
            ->orderBy('fecha_creacion')
            ->get()
            ->toArray();
    }

}