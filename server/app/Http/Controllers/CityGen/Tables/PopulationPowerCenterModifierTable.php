<?php

namespace App\Http\Controllers\CityGen\Tables;

use App\Http\Controllers\CityGen\Constants\PopulationType;

class PopulationPowerCenterModifierTable extends BaseTable
{
    function getTable()
    {
        return array(
            PopulationType::THORP => -1,
            PopulationType::HAMLET => 0,
            PopulationType::VILLAGE => 1,
            PopulationType::SMALL_TOWN => 2,
            PopulationType::LARGE_TOWN => 3,
            PopulationType::SMALL_CITY => 4,
            PopulationType::LARGE_CITY => 5,
            PopulationType::METROPOLIS => 6,
        );
    }
}
