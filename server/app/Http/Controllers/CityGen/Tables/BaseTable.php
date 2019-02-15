<?php

namespace App\Http\Controllers\CityGen\Tables;

abstract class BaseTable
{

    /**
     * @return array the actual table
     */
    abstract function getTable();
}
