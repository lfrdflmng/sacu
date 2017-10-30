<?php
/**
 * Created by PhpStorm.
 * User: Alfredo
 * Date: 08-Oct-17
 * Time: 10:48 AM
 */

namespace App;

use Illuminate\Support\Facades\DB;

class PlanEstudio extends Modelo {

    public $timestamps = true;

    protected $table = 'plan_estudio';

    //definiciones de status
    const FINALIZADO = 2;

    /**
     * Los atributos que se pueden guardar
     *
     * @var array
     */
    protected $fillable = [
        'id_carrera',
        'id_usuario',
        'nombre',
        'descripcion',
        'codigo',
        'fecha',
        'fecha_aprobacion'
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
            'id_carrera'        => 'required|integer',
            'id_usuario'        => 'integer',
            'nombre'            => 'required|max:60|unique:plan_estudio,nombre,' . $ignorar_id . ',id,fecha_eliminacion,NULL',
            'descripcion'       => 'max:255',
            'codigo'            => 'max:30',
            'fecha'             => 'nullable|date_format:Y',
            'fecha_aprobacion'  => 'nullable|date_format:d/m/Y'
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

    public function materias() {
        return $this->hasMany('App\PlanEstudioMateria', 'id_plan_estudio', 'id');
    }


    # FILTROS


    # ASIGNACIONES

    public function setFechaAttribute($val) {
        return $this->attributes['fecha'] = date($val . '-01-01'); //solo uso el año, pero es un campo de tipo fecha
    }


    # LECTURAS

    public function getNombreAttribute() {
        return ucwords($this->attributes['nombre']);
    }

    public function getDescripcionAttribute() {
        return ucfirst(mb_strtolower($this->attributes['descripcion'], 'UTF-8'));
    }

    /*public function getFechaAttribute() {
        return date('Y', strtotime($this->attributes['fecha']));
    }*/


    # METODOS

    public static function traerData($campos = null) {
        $campos = [
            'plan_estudio.id',
            'plan_estudio.codigo',
            'plan_estudio.nombre',
            'plan_estudio.descripcion',
            'plan_estudio.fecha',
            'carrera.nombre AS carrera',
            'plan_estudio.status',
            'plan_estudio.fecha_creacion'
        ];
        return self::selectRaw(implode(',', $campos))
            ->join('carrera', 'plan_estudio.id_carrera', '=', 'carrera.id')
            ->orderBy('fecha_creacion')
            ->get($campos)
            ->toArray();
    }


    public function traerDataEstructura() {
        return DB::table('plan_estudio_materia')
            ->where('id_plan_estudio', '=', $this->id)
            ->get()
            ->toArray();
    }

}