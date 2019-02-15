<?php

namespace App\Http\Controllers\CityGen\Tables;

use App\Http\Controllers\CityGen\Constants\PopulationType;

class PopulationWealthTable extends BaseTable
{
    function getTable()
    {
        return array(
            PopulationType::THORP => 40,
            PopulationType::HAMLET => 100,
            PopulationType::VILLAGE => 200,
            PopulationType::SMALL_TOWN => 800,
            PopulationType::LARGE_TOWN => 7000,
            PopulationType::SMALL_CITY => 15000,
            PopulationType::LARGE_CITY => 40000,
            PopulationType::METROPOLIS => 160000,
        );
    }
}
