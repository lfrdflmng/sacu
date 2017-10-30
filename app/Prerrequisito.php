<?php
/**
 * Created by PhpStorm.
 * User: Alfredo
 * Date: 19/10/2017
 * Time: 10:11 AM
 */

namespace App;

class Prerrequisito extends Modelo {

    public $timestamps = false;
    protected $forceDeleting = true;

    protected $table = 'prerrequisito';

    /**
     * Los atributos que se pueden guardar
     *
     * @var array
     */
    protected $fillable = [
        'id_plan_estudio_materia',
        'tipo',
        'valor',
        'opcional'
    ];


    # RELACIONES

    public function planEstudioMateria() {
        return $this->belongsTo('App\PlanEstudioMateria', 'id_plan_estudio_materia', 'id');
    }


    # FILTROS


    # ASIGNACIONES


    # LECTURAS


    # METODOS

}