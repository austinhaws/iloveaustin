<?php

namespace App\Http\Controllers\CityGen\Tables;

use App\Http\Controllers\CityGen\Constants\Integration;

class IntegrationTable extends BaseTable
{
    function getTable()
    {
        return array(
            1 => Integration::ISOLATED,
            2 => Integration::MIXED,
            3 => Integration::INTEGRATED,
        );
    }
}
