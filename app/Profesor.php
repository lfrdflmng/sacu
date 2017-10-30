<?php
/**
 * Created by PhpStorm.
 * User: Alfredo
 * Date: 13/10/2017
 * Time: 11:29 AM
 */

namespace App;

use Carbon\Carbon;

class Profesor extends Modelo {

    public $timestamps = true;

    protected $table = 'profesor';

    /**
     * Los atributos que se pueden guardar
     *
     * @var array
     */
    protected $fillable = [
        'id_persona',
        'id_usuario',
        'num_carnet',
        'fecha_ingreso'
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
            'id_persona'    => 'integer',
            'id_usuario'    => 'integer',
            'num_carnet'    => 'required|max:40|unique:profesor,num_carnet,' . $ignorar_id . ',id,fecha_eliminacion,NULL',
            'fecha_ingreso' => 'date_format:d/m/Y'
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
        return $this->hasOne('App\Persona', 'id', 'id_persona');
    }


    public function materias() {
        return $this->belongsToMany('App\Materia', 'profesor_materia','id_profesor', 'id_materia');
    }


    # FILTROS


    # ASIGNACIONES

    public function setFechaIngresoAttribute($val) {
        if (!empty($val)) {
            $this->attributes['fecha_ingreso'] = Carbon::createFromFormat('d/m/Y', $val)->format('Y-m-d');
        }
    }


    # LECTURAS

    /*public function getFechaIngresoAttribute() {
        if (!empty($this->attributes['fecha_ingreso'])) {
            return Carbon::createFromFormat('Y-m-d', $this->attributes['fecha_ingreso'])->format('d/m/Y');
        }
        return null;
    }*/


    # METODOS

    public static function traerData($campos = []) {
        //return self::get(!empty($campos) ? $campos : ['id','nombre','descripcion'])->toArray();
        $campos = [
            'profesor.id',
            'persona.foto',
            'profesor.num_carnet',
            'CONCAT(persona.primer_nombre, \' \', persona.segundo_nombre) AS nombre',
            'CONCAT(persona.primer_apellido, \' \', persona.segundo_apellido) AS apellido',
            'persona.dni',
            'persona.sexo',
            'persona.fecha_nacimiento',
            'persona.direccion_domicilio',
            'profesor.fecha_ingreso',
            //'STRING_AGG(materia.nombre, \'|\') AS materias', //MySQL = GROUP_CONCATENATE
            '(SELECT STRING_AGG(materia.nombre, \'|\') FROM materia LEFT JOIN profesor_materia ON profesor_materia.id_profesor = profesor.id WHERE materia.id = profesor_materia.id_materia AND profesor_materia.id_profesor = profesor.id) AS materias', //MySQL = GROUP_CONCATENATE
            'profesor.fecha_creacion'
        ];

        return self::selectRaw(implode(',', $campos))
            ->join('persona', 'profesor.id_persona', '=', 'persona.id', 'left')
            //->join('profesor_materia', 'profesor_materia.id_profesor', '=', 'profesor.id', 'left')
            //->join('materia', 'profesor_materia.id_materia', '=', 'materia.id', 'left')
            //->groupBy('profesor.id')
            ->orderBy('fecha_creacion')
            ->get()
            ->toArray();
    }


    /**
     * Actualiza el campo id_persona con el nuevo id de persona
     *
     * @param $id_persona
     */
    public function asignarPersona($id_persona) {
        $this->id_persona = $id_persona;
        $this->save();
    }

}