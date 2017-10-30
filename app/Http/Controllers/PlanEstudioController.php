<?php
/**
 * Created by PhpStorm.
 * User: Alfredo
 * Date: 08-Oct-17
 * Time: 11:07 AM
 */

namespace App\Http\Controllers;


use App\Anualidad;
use App\Materia;
use App\Modalidad;
use App\PlanEstudio;
use App\PlanEstudioMateria;
use App\Prerrequisito;
use Illuminate\Support\Facades\Input;

class PlanEstudioController extends Controlador {

    protected $modelo = 'PlanEstudio';


    public static function cabeceras() {
        return [
            'id',
            'codigo',
            'nombre',
            'descripcion',
            'fecha',
            'id_carrera',
            'status',
            'fecha_creacion'
        ];
    }


    public static function pies() {
        return [];
    }


    public static function configuracionColumnasDataTables() {
        return [
            'codigo'            => 'negristas_mayusculas',
            'nombre'            => 'titulo',
            'id_carrera'        => 'etiqueta',
            'fecha_creacion'    => 'fecha_hora'
        ];
    }


    public function itemDataAdicional($item) {
        $this->etiquetaCampoSeleccion($item, 'carrera');
    }


    public function cargarEstructuraGet() {
        $id = Input::get('id');
        if ($id) {
            $plan = PlanEstudio::find((int)$id);
            if ($plan) {
                //estructura actual
                //$estructura = $plan->traerDataEstructura();
                if (true/*empty($estructura)*/) {
                    $estructura = $plan->borrador_estructura;
                    $prerrequisitos = $plan->borrador_prerrequisitos;
                }
                else {
                    //TODO
                }
                $this->especificarRespuesta('data_borrador', $estructura);
                $this->especificarRespuesta('data_prerrequisitos_borrador', $prerrequisitos);

                //anualidad
                if (Input::get('anualidad')) {
                    $anualidad = Anualidad::orderBy('nombre')->pluck('nombre', 'id')->toArray();
                    $this->especificarRespuesta('anualidad', $anualidad);
                }

                //modalidad
                if (Input::get('modalidad')) {
                    $modalidad = Modalidad::orderBy('nombre')->pluck('nombre', 'id')->toArray();
                    $this->especificarRespuesta('modalidad', $modalidad);
                }

                //materia
                if (Input::get('materia')) {
                    $materia = Materia::orderBy('nombre')->pluck('nombre', 'id')->toArray();
                    $this->especificarRespuesta('materia', $materia);
                }

                $this->especificarRespuesta('id_plan_estudio', $id);
                $this->especificarRespuesta('finalizado', $plan->status == PlanEstudio::FINALIZADO);
                return $this->retornar();
            }
            return $this->retornarError(__('global.not_found'));
        }
        return $this->retornarError();
    }


    public function guardarEstructuraPost() {
        $id_plan_estudio = (int)Input::get('id');
        $finalizar = (int)Input::get('finalizar');
        if ($id_plan_estudio) {
            $json_estructura = Input::get('estructura', '');
            $json_prerrequisitos = Input::get('prerrequisitos', '');
            $estructura = json_decode($json_estructura);
            $prerrequisitos = json_decode($json_prerrequisitos);

            $plan_estudio = PlanEstudio::find($id_plan_estudio);

            if ($plan_estudio && !$plan_estudio->status != PlanEstudio::FINALIZADO) {
                //guarda un borrador
                $plan_estudio->borrador_estructura = $json_estructura;
                $plan_estudio->borrador_prerrequisitos = $json_prerrequisitos;
                $plan_estudio->save();

                if ($finalizar) {
                    //proceso para guardar la estructura en las tablas relacionadas
                    $guardado = $this->guardarEstructuraDesdeJson($id_plan_estudio, $estructura, $prerrequisitos);
                    if ($guardado) {
                        $plan_estudio->status = PlanEstudio::FINALIZADO;
                        $plan_estudio->save();
                    }
                }
                else {
                    $guardado = false;
                }

                //retorna al cliente
                $this->especificarRespuesta('guardado', $guardado);
                return $this->retornar(__('global.saved_msg'));
            }
            return $this->retornarError(__('global.not_found'));
        }
        return $this->retornarError();
    }


    public function guardarEstructuraDesdeJson($id_plan_estudio, $estructura, $prerrequisitos) {
        $estructura_final = [];
        $plan_estudio_materia = [];
        $indice = 0;

        $plan_estudio_materia['id_plan_estudio'] = $id_plan_estudio;

        //anualidad
        foreach ($estructura as $anualidad) {
            $incompleto = true;
            $plan_estudio_materia['id_anualidad'] = $anualidad->id;
            if (isset($anualidad->children) && is_array($anualidad->children) && count($anualidad->children)) {

                //modalidad
                foreach ($anualidad->children as $modalidad) {
                    $plan_estudio_materia['id_modalidad'] = $modalidad->id;
                    if (isset($modalidad->children) && is_array($anualidad->children) && count($anualidad->children)) {

                        //materia
                        if (isset($anualidad->children)) {
                            foreach ($modalidad->children as $materia) {
                                $plan_estudio_materia['id_materia'] = $materia->id;
                                $plan_estudio_materia['indice'] = $indice;
                                $estructura_final[] = $plan_estudio_materia;
                                $indice++;
                                $incompleto = false;
                            }
                        }

                    }
                }

            }

            if ($incompleto) {
                return false;
            }
        }

        //guarda la estructura
        $guardado = PlanEstudioMateria::insert($estructura_final);

        if ($guardado) {

            //para los prerrequisitos...

            $plan_estudio_materias = PlanEstudioMateria::where('id_plan_estudio', '=', $id_plan_estudio)->get();

            //por cada materia en el plan de estudio
            foreach ($plan_estudio_materias as $plan_estudio_materia) {

                //se busca la materia en la lista de prerrequisitos
                foreach ($prerrequisitos as $materia) {

                    //si se encuentra, se registran los prerrequisitos
                    if ($materia->id == $plan_estudio_materia->id_materia) {

                        $prerrequisitos_materia = [];

                        foreach ($materia->prerrequisitos as $prerrequisito) {
                            $prerrequisitos_materia[] = [
                                'id_plan_estudio_materia' => $plan_estudio_materia->id,
                                'tipo' => $prerrequisito->tipo,
                                'valor' => $prerrequisito->valor,
                                'opcional' => $prerrequisito->opcional ? 1 : 0
                            ];
                        }

                        //guarda los prerrequisitos de la materia
                        Prerrequisito::insert($prerrequisitos_materia);

                        break;
                    }
                }
            }
        }

        return true;
    }


}