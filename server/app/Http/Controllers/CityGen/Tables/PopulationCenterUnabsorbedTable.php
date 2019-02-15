<?php

namespace App\Http\Controllers\CityGen\Tables;

use App\Http\Controllers\CityGen\Constants\PopulationType;

class PopulationCenterUnabsorbedTable extends BaseTable
{
    function getTable()
    {
        return array(
            PopulationType::THORP => 0.05,
            PopulationType::HAMLET => 0.05,
            PopulationType::VILLAGE => 0.10,
            PopulationType::SMALL_TOWN => 0.15,
            PopulationType::LARGE_TOWN => 0.20,
            PopulationType::SMALL_CITY => 0.25,
            PopulationType::LARGE_CITY => 0.30,
            PopulationType::METROPOLIS => 0.30,
        );
    }
}
