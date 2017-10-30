<?php
/**
 * Created by PhpStorm.
 * User: Alfredo
 * Date: 11/10/2017
 * Time: 9:40 AM
 */

namespace App;

class PlanEstudioMateria extends Modelo {

    public $timestamps = false;
    protected $forceDeleting = true;

    protected $table = 'plan_estudio_materia';

    /**
     * Los atributos que se pueden guardar
     *
     * @var array
     */
    protected $fillable = [
        'id_plan_estudio',
        'id_anualidad',
        'id_modalidad',
        'id_materia',
        'indice'
    ];


    # RELACIONES

    public function prerrequisitos() {
        return $this->hasMany('App\Prerrequisito', 'id_plan_estudio_materia', 'id');
    }


    # FILTROS


    # ASIGNACIONES


    # LECTURAS


    # METODOS

}