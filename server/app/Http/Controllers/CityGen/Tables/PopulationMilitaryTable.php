<?php

namespace App\Http\Controllers\CityGen\Tables;

use App\Http\Controllers\CityGen\Constants\PopulationType;

class PopulationMilitaryTable extends BaseTable
{
    function getTable()
    {
        return array(
            PopulationType::THORP => 1,
            PopulationType::HAMLET => 1,
            PopulationType::VILLAGE => 1,
            PopulationType::SMALL_TOWN => 3,
            PopulationType::LARGE_TOWN => 5,
            PopulationType::SMALL_CITY => 8,
            PopulationType::LARGE_CITY => 18,
            PopulationType::METROPOLIS => 35,
        );
    }
}
