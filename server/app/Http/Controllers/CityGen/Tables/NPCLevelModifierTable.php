<?php

namespace App\Http\Controllers\CityGen\Tables;

use App\Http\Controllers\CityGen\Constants\PopulationType;

class NPCLevelModifierTable extends BaseTable
{
    function getTable()
    {
        return array(
            PopulationType::THORP => -10,
            PopulationType::HAMLET => -6,
            PopulationType::VILLAGE => -2,
            PopulationType::SMALL_TOWN => 0,
            PopulationType::LARGE_TOWN => 4,
            PopulationType::SMALL_CITY => 8,
            PopulationType::LARGE_CITY => 12,
            PopulationType::METROPOLIS => 18,
        );
    }
}
