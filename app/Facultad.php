<?php
/**
 * Created by PhpStorm.
 * User: Alfredo
 * Date: 5/10/2017
 * Time: 11:30 AM
 */

namespace App;

class Facultad extends Modelo {

    public $timestamps = true;

    protected $table = 'facultad';

    /**
     * Los atributos que se pueden guardar
     *
     * @var array
     */
    protected $fillable = [
        'id_usuario',
        'id_decanatura',
        'codigo',
        'nombre',
        'descripcion',
        'abreviatura'
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
            'id_usuario'    => 'integer',
            'codigo'        => 'max:60|unique:facultad,codigo,' . $ignorar_id . ',id,fecha_eliminacion,NULL',
            'nombre'        => 'required|unique:facultad,nombre,' . $ignorar_id . ',id,fecha_eliminacion,NULL',
            'abreviatura'   => 'max:15',
            'descripcion'   => 'max:255',
            'id_decanatura' => 'required|integer',
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

    public function decanatura() {
        return $this->belongsTo('App\Decanatura', 'id_decanatura', 'id');
    }


    public function carrera() {
        return $this->hasMany('App\Carrera', 'id_facultad', 'id');
    }


    public function materias() {
        return $this->belongsToMany('App\Materia', 'materia_factultad','id_facultad', 'id_materia');
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
        //return self::get(['id', 'codigo', 'nombre', 'descripcion', 'fecha_creacion'])->toArray();
        $campos = [
            'facultad.id',
            'facultad.codigo',
            'facultad.nombre',
            'facultad.abreviatura',
            'facultad.descripcion',
            'decanatura.nombre AS decanatura',
            'facultad.fecha_creacion'
        ];
        return self::selectRaw(implode(',', $campos))
            ->join('decanatura', 'facultad.id_decanatura', '=', 'decanatura.id', 'left')
            ->orderBy('fecha_creacion')
            ->get()
            ->toArray();
    }

}