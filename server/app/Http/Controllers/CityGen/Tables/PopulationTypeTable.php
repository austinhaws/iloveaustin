<?php

namespace App\Http\Controllers\CityGen\Tables;

use App\Http\Controllers\CityGen\Constants\PopulationType;

class PopulationTypeTable extends BaseTable
{

    function getTable()
    {
        return [
            10 => PopulationType::THORP,
            30 => PopulationType::HAMLET,
            50 => PopulationType::VILLAGE,
            70 => PopulationType::SMALL_TOWN,
            85 => PopulationType::LARGE_TOWN,
            95 => PopulationType::SMALL_CITY,
            99 => PopulationType::LARGE_CITY,
            100 => PopulationType::METROPOLIS,
        ];
    }
}
