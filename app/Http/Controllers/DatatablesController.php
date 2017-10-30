<?php
/**
 * Created by PhpStorm.
 * User: Alfredo
 * Date: 25/9/2017
 * Time: 10:24 AM
 */

namespace App\Http\Controllers;


use stdClass;

class DatatablesController {

    public $draw;
    public $records_total;
    public $records_filtered;
    public $data;

    public function __construct($data = []) {
        $this->draw = 1;
        $this->records_total = 0;
        $this->records_filtered = 0;
        $this->data = $data;
    }

    public function json() {
        $dt = new stdClass;
        $dt->draw = $this->draw;
        $dt->recordsTotal = $this->records_total;
        $dt->recordsFiltered = $this->records_filtered;
        $dt->data = [];
        $i = 1;
        foreach ($this->data as $key => $item) {
            $dt->data[] = array_values(array($i) + $item);
            $i++;
        }
        return json_encode($dt);
    }

}