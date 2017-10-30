<?php
/**
 * Created by PhpStorm.
 * User: Alfredo
 * Date: 22/9/2017
 * Time: 11:13 AM
 */

namespace App\Http\Controllers;


class DashboardController {

    public function index() {
        //totales
        $totales = $this->totalesContadores();

        //generos de estudiantes
        $data_genero_estudiantes = $this->dataGenerosEstudiantes();

        return view('dashboard')->with([
            'total' => $totales,
            'estudiantes' => $data_genero_estudiantes
        ]);
    }


    /**
     * Totales de registros que se usan en los contadores
     *
     * @return array
     */
    private function totalesContadores() {
        return [
            'estudiante' => \App\Estudiante::count(),
            'carrera' => \App\Carrera::count(),
            'materia' => \App\Materia::count(),
            'profesor' => \App\Profesor::count()
        ];
    }


    /**
     * Data para la gráfica de estudiantes
     *
     * @return array
     */
    private function dataGenerosEstudiantes() {
        return \App\Estudiante::totalesPorGenero();
    }

}