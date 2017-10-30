<?php
/**
 * Created by PhpStorm.
 * User: Alfredo
 * Date: 23-Sep-17
 * Time: 4:37 PM
 */

namespace App\Http\Controllers;


use App\Menu;
use Illuminate\Support\Facades\View;

class MenuController {

    public static function contruirMenu() {
        $items = Menu::items();

        $html = '';

        foreach ($items as $item) {
            $html .= self::construirMenuItem($item);
        }

        return $html;
    }


    private static function construirMenuItem($item) {
        return View::make('componentes.menu-item')->with([
            'url' => $item['url'],
            'titulo' => $item['titulo'],
            'clases_icono' => $item['clases_icono'],
            'submenu' => $item['hijos']
        ])->render();
    }

}