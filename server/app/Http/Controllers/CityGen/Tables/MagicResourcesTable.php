<?php

namespace App\Http\Controllers\CityGen\Tables;

use App\Http\Controllers\CityGen\Constants\PopulationType;

class MagicResourcesTable extends BaseTable
{
    function getTable()
    {
        return array(
            PopulationType::THORP => 0,
            PopulationType::HAMLET => 0,
            PopulationType::VILLAGE => 0.01,
            PopulationType::SMALL_TOWN => 0.05,
            PopulationType::LARGE_TOWN => 0.05,
            PopulationType::SMALL_CITY => 0.1,
            PopulationType::LARGE_CITY => 0.1,
            PopulationType::METROPOLIS => 0.1,
        );
    }
}
