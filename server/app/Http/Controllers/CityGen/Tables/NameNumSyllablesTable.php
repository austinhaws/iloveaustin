<?php

namespace App\Http\Controllers\CityGen\Tables;

class NameNumSyllablesTable extends BaseTable
{
    function getTable()
    {
        return array(
            5 => 1,
            16 => 2,
            31 => 3,
            40 => 4,
            45 => 5,
            46 => 2,
            55 => 1,
        );
    }
}
