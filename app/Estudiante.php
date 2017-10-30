<?php
/**
 * Created by PhpStorm.
 * User: Alfredo
 * Date: 29/9/2017
 * Time: 3:25 PM
 */

namespace App;

use Carbon\Carbon;
use Illuminate\Support\Facades\URL;

class Estudiante extends Modelo {

    public $timestamps = true;

    protected $table = 'estudiante';

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
            'num_carnet'    => 'required|max:40|unique:estudiante,num_carnet,' . $ignorar_id . ',id,fecha_eliminacion,NULL',
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
        $campos = <<<EOT
            estudiante.id,
            persona.foto,
            estudiante.num_carnet,
            CONCAT(persona.primer_nombre, ' ', persona.segundo_nombre) AS nombre,
            CONCAT(persona.primer_apellido, ' ', persona.segundo_apellido) AS apellido,
            persona.dni,
            persona.sexo,
            persona.fecha_nacimiento,
            persona.direccion_domicilio,
            estudiante.fecha_ingreso,
            estudiante.fecha_creacion
EOT;

        return self::selectRaw($campos)
            ->join('persona', 'estudiante.id_persona', '=', 'persona.id', 'left')
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


    /**
     * Retorna los totales de estudiantes por géneros
     *
     * @return array
     */
    public static function totalesPorGenero() {
        $data = self::selectRaw('sexo, COUNT(*) AS total')
            ->join('persona', 'id_persona', '=', 'persona.id')
            ->groupBy('sexo')
            ->pluck('total', 'sexo');
        if (!isset($data[0])) $data[0] = 0;
        if (!isset($data[1])) $data[1] = 0;
        return $data;
    }

}