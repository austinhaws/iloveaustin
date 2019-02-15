<?php

namespace App\Http\Controllers\CityGen\Tables;

use App\Http\Controllers\CityGen\Constants\PopulationType;
use App\Http\Controllers\CityGen\Models\MinMax;

class PopulationInfluencePointsTable extends BaseTable
{
    function getTable()
    {
        return array(
            PopulationType::THORP => new MinMax(18, 23),
            PopulationType::HAMLET => new MinMax(31, 38),
            PopulationType::VILLAGE => new MinMax(50, 62),
            PopulationType::SMALL_TOWN => new MinMax(81, 89),
            PopulationType::LARGE_TOWN => new MinMax(188, 353),
            PopulationType::SMALL_CITY => new MinMax(1807, 2209),
            PopulationType::LARGE_CITY => new MinMax(13520, 16830),
            PopulationType::METROPOLIS => new MinMax(29982, 36645),
        );
    }
}
