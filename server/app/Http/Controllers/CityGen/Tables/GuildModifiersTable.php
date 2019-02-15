<?php

namespace App\Http\Controllers\CityGen\Tables;

use App\Http\Controllers\CityGen\Constants\PopulationType;
use App\Http\Controllers\CityGen\Models\MinMax;

class GuildModifiersTable extends BaseTable
{
    function getTable()
    {
        return array(
            PopulationType::THORP => new MinMax(0, 0),
            PopulationType::HAMLET => new MinMax(0, 0),
            PopulationType::VILLAGE => new MinMax(0, 2),
            PopulationType::SMALL_TOWN => new MinMax(0, 3),
            PopulationType::LARGE_TOWN => new MinMax(0, 4),
            PopulationType::SMALL_CITY => new MinMax(0, 5),
            PopulationType::LARGE_CITY => new MinMax(0, 6),
            PopulationType::METROPOLIS => new MinMax(0, 7),
        );
    }
}
