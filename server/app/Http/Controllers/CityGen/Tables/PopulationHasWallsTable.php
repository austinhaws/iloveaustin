<?php

namespace App\Http\Controllers\CityGen\Tables;

use App\Http\Controllers\CityGen\Constants\PopulationType;

class PopulationHasWallsTable extends BaseTable
{

    function getTable()
    {
        // value is X in 100 that the city will have walls (0 means impossible)
        return array(
            PopulationType::THORP => 0,
            PopulationType::HAMLET => 0,
            PopulationType::VILLAGE => 0,
            PopulationType::SMALL_TOWN => 0,
            PopulationType::LARGE_TOWN => 5,
            PopulationType::SMALL_CITY => 50,
            PopulationType::LARGE_CITY => 75,
            PopulationType::METROPOLIS => 99,
        );
    }
}
