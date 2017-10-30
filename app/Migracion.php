<?php

/**
 * Created by PhpStorm.
 * User: Alfredo
 * Date: 18/9/2017
 * Time: 3:03 PM
 */

namespace App;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class Migracion extends Migration {

    /**
     * Agrega campos comunes a las tabla
     *
     * @param Blueprint $table (por referencia)
     */
    public function fechasYStatus(Blueprint &$table) {
        $table->datetime('fecha_creacion')->nullable();
        $table->datetime('fecha_actualizacion')->nullable();
        $table->datetime('fecha_eliminacion')->nullable();
        $table->tinyInteger('status')->default('1');
    }

}