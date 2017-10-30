<?php
/**
 * Created by PhpStorm.
 * User: Alfredo
 * Date: 29/9/2017
 * Time: 5:22 PM
 */

namespace App\Http\Controllers;


use App\Estudiante;
use App\Persona;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;

class EstudianteController extends Controlador {

    protected $modelo = 'Estudiante';


    public static function cabeceras() {
        return [
            'id',
            '&nbsp;',//foto
            'num_carnet',
            'nombres',
            'apellidos',
            'dni',
            'sexo',
            'fecha_nacimiento',
            'direccion_domicilio',
            'fecha_ingreso',
            'fecha_creacion'
        ];
    }


    public static function pies() {
        return [];
    }


    public static function configuracionColumnasDataTables() {
        return [
            '&nbsp;'            => 'avatar',
            'num_carnet'        => 'negritas_mayusculas',
            'nombres'           => 'titulo',
            'apellidos'         => 'titulo',
            'dni'               => 'mayusculas',
            'sexo'              => 'sexo',
            'fecha_nacimiento'  => 'fecha_edad',
            'fecha_ingreso'     => 'fecha',
            'fecha_creacion'    => 'fecha_hora'
        ];
    }


    public function camposBusqueda() {
        return [
            'num_carnet'
        ];
    }


    /**
     * Antes de guardar, se verifican los datos enviados de la persona
     */
    public function antesDeGuardar() {
        $this->antesDeGuardarDefecto();

        $id = (int)Input::get('id');

        //cuando se está editanto un estudiante
        if ($id) {
            if (!$this->verificarInputsDatosPersonaEstudianteExistente($id)) {
                return false;
            }
        }

        //cuando se está creando un estudiante
        else {
            if (!$this->verificarInputsDatosPersonaEstudianteNuevo()) {
                return false;
            }

            //si no hay errores de validación, se guarda la persona
            //cuando se está registrando una persona nueva

            $persona_existente = Input::get('persona_existente', false);

            if (!$persona_existente) {
                if (!$this->crearPersonaDesdeInputs()) {
                    return false;
                }
            }
        }

        return true;
    }


    /**
     * Después de guardar el estudiante, se actualizan los datos de la persona
     *
     * @param $item
     */
    public function despuesDeGuardar($item) {
        $id = (int)Input::get('id', 0);
        $persona_existente = Input::get('persona_existente', false);
        $persona_id = (int)Input::get('id_persona', 0);

        if ($id && !$persona_existente && $persona_id) {
            $this->actualizarPersonaDesdeInputs($persona_id);
        }
    }


    /**
     * Cuando se solicitan los datos del estudiante para editar se
     * envían también los datos de la persona
     *
     * @param $item
     */
    public function itemDataAdicional($item) {
        $persona_id = (int)$item->id_persona;

        if (!empty($persona_id)) {
            $persona = Persona::find($persona_id);
            $this->agregarArregloEnRespuesta($persona->toArray());
        }
    }


    /*public function listadoResultado($items) {
        $resultado = [];
        foreach ($items as $item) {
            $resultado[] = [
                'id' => $item->id,
                'text' => $item->num_carnet,
                'subtext' => 'V-17339453',
                'img' => URL::asset('uploads/img/s/avatar0.jpg')
            ];
        }
        return $resultado;
    }*/


    /**
     * Verifica los datos de la persona cuando se está editando el estudiante
     *
     * @param $id
     * @return bool
     */
    public function verificarInputsDatosPersonaEstudianteExistente($id) {
        //busca el estudiante
        $estudiante = Estudiante::find($id);

        if ($estudiante) {
            $persona_existente = Input::get('persona_existente', false);

            //cuando se está asignando una persona existente
            if ($persona_existente) {
                if (!$this->verificarInputsPersonaAsignada($estudiante->id_persona)) {
                    return false;
                }
            }

            //cuando se está editando una persona
            else {
                $persona_id = (int)$estudiante->id_persona;

                if (!$this->verificarInputsPersonaNueva($persona_id)) {
                    return false;
                }

                Input::merge(['id_persona' => $persona_id]);
            }
        }
        else {
            $this->retornarError(__('global.not_found'));
            return false;
        }

        return true;
    }


    /**
     * Verifica los datos de la persona cuando se está creando un estudiante
     *
     * @return bool
     */
    public function verificarInputsDatosPersonaEstudianteNuevo() {
        $persona_existente = Input::get('persona_existente', false);

        //cuando se está asignando una persona existente
        if ($persona_existente) {
            if (!$this->verificarInputsPersonaAsignada()) {
                return false;
            }
        }

        //cuando se está creando una persona nueva
        else {
            if (!$this->verificarInputsPersonaNueva()) {
                return false;
            }
        }

        return true;
    }


    /***
     * Verifica que los datos enviados de la persona sean válidos
     *
     * @param int $persona_id_a_ignorar
     * @return bool
     */
    public function verificarInputsPersonaNueva($persona_id_a_ignorar = 0) {
        //reglas de validación de persona
        $reglas = Persona::reglasValidacion(null, $persona_id_a_ignorar);

        //valida datos de la persona
        $validacion = Validator::make(Input::all(), $reglas);

        if (!$validacion->passes()) {
            list($err, $campo) = $this->mensajeYCampoDeError($validacion);
            $this->retornarError($err, $campo);
            return false;
        }

        return true;
    }


    /**
     * Verifica que la persona enviada a asignar sea válida
     *
     * @param int $persona_id_a_ignorar
     * @return bool
     */
    public function verificarInputsPersonaAsignada($persona_id_a_ignorar = 0) {
        $persona_id = (int)Input::get('id_persona');

        //busca la persona
        $persona = Persona::find($persona_id);

        if ($persona) {
            if ($persona_id != $persona_id_a_ignorar) {

                //si la persona ya está asignada a un estudiante, retorna un error
                if ($persona->esEstudiante()) {
                    $this->retornarError(__('estudiante.persona_ya_asignada'), 'id_persona');
                    return false;
                }

            }
        }
        else {
            $this->retornarError(__('global.not_found'));
            return false;
        }

        return true;
    }


    /**
     * Crea la persona y guarda el id. Los datos ya deben estar validados
     *
     * @return bool
     */
    public function crearPersonaDesdeInputs() {
        $persona = Persona::create(Input::all());
        if ($persona && $persona->id) {
            //registra el id de la persona creada para ser asignada al estudiante
            Input::merge([
                'id_persona' => $persona->id
            ]);

            $ctrl = new PersonaController;
            $ctrl->despuesDeGuardar($persona);
        }
        else {
            $this->retornarError(__('global.unable_perform_action'));
            return false;
        }
        return true;
    }


    /**
     * Actualiza la persona. Los datos ya deben estar validados
     *
     * @param $id
     */
    public function actualizarPersonaDesdeInputs($id) {
        $persona = Persona::find((int)$id);
        if ($persona) {
            $persona->update(Input::all());

            $ctrl = new PersonaController;
            $ctrl->despuesDeGuardar($persona);
        }
    }

}