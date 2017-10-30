<?php
/**
 * Created by PhpStorm.
 * User: Alfredo
 * Date: 22/9/2017
 * Time: 11:24 AM
 */

namespace App;

use Carbon\Carbon;

class Persona extends Modelo {

    public $timestamps = true;

    protected $table = 'persona';

    /**
     * Los atributos que se pueden guardar
     *
     * @var array
     */
    protected $fillable = [
	    'id_usuario',
	    'primer_nombre',
	    'segundo_nombre',
	    'primer_apellido',
	    'segundo_apellido',
	    'dni',
	    'sexo',
	    'direccion_domicilio',
	    'fecha_nacimiento',
	    'foto',
        'status'
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
            'id'                    => 'integer',
            'id_usuario'            => 'integer',
            'primer_nombre'         => 'required|max:60',
            'segundo_nombre'        => 'max:60',
            'primer_apellido'       => 'required|max:60',
            'segundo_apellido'      => 'max:60',
            'dni'                   => 'required|max:20|unique:persona,dni,' . $ignorar_id . ',id,fecha_eliminacion,NULL',
            'sexo'                  => 'in:0,1',
            'direccion_domicilio'   => 'max:255',
            'fecha_nacimiento'      => 'nullable|date_format:d/m/Y',
            'foto'                  => '',
            'foto_upload'           => 'image',
            'status'                => 'integer'
        ];
        if ($campo === null) {
            return $reglas;
        }
        return isset($reglas[$campo]) ? $reglas[$campo] : '';
    }

    /**
     * Devuélve los mensajes de validación para un campo específico o el arreglo de mensajes por defecto
     * Los mensajes se buscan en el archivo de correspondiente en lang
     *
     * @param $campo
     * @return array|string
     */
    public static function mensajesValidacion($campo = null) {
        $mensajes = [
            'dni' => [
                'unique' => 'dni_not_unique'
            ]
        ];
        if ($campo === null) {
            return $mensajes;
        }
        return isset($mensajes[$campo]) ? $mensajes[$campo] : '';
    }


    # RELACIONES

    public function estudiante() {
        return $this->hasOne('App\Estudiante', 'id_persona', 'id');
    }

    public function contactos() {
        return $this->hasMany('App\Contacto', 'id_persona', 'id');
    }


    # FILTROS


    # ASIGNACIONES

    public function setFechaNacimientoAttribute($val) {
        if (!empty($val)) {
            $this->attributes['fecha_nacimiento'] = Carbon::createFromFormat('d/m/Y', $val)->format('Y-m-d');
        }
    }


    # LECTURAS

    public function getDniAttribute() {
        return strtoupper($this->attributes['dni']);
    }

    public function getPrimerNombreAttribute() {
        return mb_convert_case(mb_strtolower($this->attributes['primer_nombre']), MB_CASE_TITLE, 'UTF-8');
    }

    public function getSegundoNombreAttribute() {
        return mb_convert_case(mb_strtolower($this->attributes['segundo_nombre']), MB_CASE_TITLE, 'UTF-8');
    }

    public function getPrimerApellidoAttribute() {
        return mb_convert_case(mb_strtolower($this->attributes['primer_apellido']), MB_CASE_TITLE, 'UTF-8');
    }

    public function getSegundoApellidoAttribute() {
        return mb_convert_case(mb_strtolower($this->attributes['segundo_apellido']), MB_CASE_TITLE, 'UTF-8');
    }

    /*public function getFechaNacimientoAttribute() {
        if (!empty($this->attributes['fecha_nacimiento'])) {
            return Carbon::createFromFormat('Y-m-d', $this->attributes['fecha_nacimiento'])->format('d/m/Y');
        }
        return null;
    }*/


    # METODOS

    /**
     * Retorna verdadero si la persona ya está asignada a un estudiante
     *
     * @return bool
     */
    public function esEstudiante() {
        return Estudiante::where('id_persona', '=', $this->id)->count() > 0;
    }

    /**
     * Retorna verdadero si la persona ya está asignada a un profesor
     *
     * @return bool
     */
    public function esProfesor() {
        return Profesor::where('id_persona', '=', $this->id)->count() > 0;
    }

}