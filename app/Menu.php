<?php
/**
 * Created by PhpStorm.
 * User: Alfredo
 * Date: 20/9/2017
 * Time: 3:38 PM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Menu extends Model {

    protected $fillable = array(
        'id_menu_padre',
        'nombre',
        'url',
        'clases',
        'clases_icono',
        'indice'
    );

    protected $table = 'menu';


    # FILTROS

    public function scopeSinPadre($query) {
        return $query->whereNull('id_menu_padre');
    }


    public function scopeConPadre($query, $val) {
        if (!empty($val)) {
            return $query->where('id_menu_padre', '=', (int)$val);
        }
        else {
            return $query->whereNull('id_menu_padre');
        }
    }


    /**
     * Busca los elementos con el padre especificado (0 = sin padre)
     *
     * @param $nivel
     * @return mixed
     */
    public static function itemsDePadre($nivel) {
        return self::conPadre($nivel)
            ->join('menu_lenguaje', 'menu_lenguaje.id_menu', '=', 'menu.id')
            ->where('lenguaje', '=', App::getLocale())
            ->orderBy('indice')
            ->selectRaw('menu.*, menu_lenguaje.texto AS titulo')
            ->get();
    }


    /**
     * Retorna el arreglo de todos los elementos del menu según la estructura
     *
     * @return array
     */
    public static function items() {
        //busca los elementos de nivel 0
        $items = self::itemsDePadre(0);

        //convierte en arreglo
        $menu = self::itemsEnArreglo($items);

        //busca los elementos de nivel 1 y los asigna como hijos
        foreach ($items as $key => $item) {
            $subitems = self::itemsDePadre($item->id);
            $menu[$key]['hijos'] = self::itemsEnArreglo($subitems);
        }

        return $menu;
    }


    /**
     * Convierte los objectos de la clase en un arreglo simple
     *
     * @param $items
     * @return array
     */
    private static function itemsEnArreglo($items) {
        $arr = [];
        foreach ($items as $key => $item) {
            $arr[$key] = [
                //'id_menu_padre' => $item->id_menu_padre,
                'nombre' => $item->nombre,
                'titulo' => $item->titulo,
                'url' => $item->ruta,
                'clases' => $item->clases,
                'clases_icono' => $item->clases_icono,
                //'indice' => $item->indice
            ];
        }
        return $arr;
    }

}