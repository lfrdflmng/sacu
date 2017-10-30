<?php
/**
 * Created by PhpStorm.
 * User: Alfredo
 * Date: 29/9/2017
 * Time: 4:48 PM
 */

namespace App\Http\Controllers;


use Illuminate\Support\Facades\URL;

class PersonaController extends Controlador {

    protected $modelo = 'Persona';


    /*public static function cabeceras() {
        return [
            'id',
            'nombres',
            'apellidos',
            'dni',
            'sexo',
            'direccion_domicilio',
            'fecha_nacimiento',
            'fecha_creacion'
        ];
    }


    public static function pies() {
        return [];
    }*/


    public function camposBusqueda() {
        return [
            'primer_nombre',
            'segundo_nombre',
            'primer_apellido',
            'segundo_apellido',
            'dni'
        ];
    }


    /**
     * Después de guardar, se actualiza la foto si es el caso
     *
     * @param $item
     */
    public function despuesDeGuardar($item) {
        ImagenController::subirImagenParaItem($item, 'foto');
    }


    public function listadoResultado($items) {
        $avatar_defecto = URL::asset('img/avatar-defecto.jpg');

        $resultado = [];
        foreach ($items as $item) {
            $resultado[] = [
                'id' => $item->id,
                'text' => ucwords(mb_strtolower($item->primer_nombre . ' ' . $item->primer_apellido, 'UTF-8')), //TODO: ucwords no funciona con acentos; nombres con acentos en la primera letra no se van a pasar a mayúsculas
                'subtext' => strtoupper($item->dni),
                'img' => !empty($item->foto) ? URL::asset(config('app.uploads_img_dir') . '/s/' . $item->foto) : $avatar_defecto
            ];
        }
        return $resultado;
    }

}