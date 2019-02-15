<?php

namespace App\Http\Controllers\CityGen\Tables;

use App\Http\Controllers\CityGen\Constants\PopulationType;
use App\Http\Controllers\CityGen\Models\MinMax;

class CommodityCountTable extends BaseTable
{
    function getTable()
    {
        return array(
            PopulationType::THORP => new MinMax(0, 0),
            PopulationType::HAMLET => new MinMax(0, 1),
            PopulationType::VILLAGE => new MinMax(0, 2),
            PopulationType::SMALL_TOWN => new MinMax(1, 3),
            PopulationType::LARGE_TOWN => new MinMax(1, 4),
            PopulationType::SMALL_CITY => new MinMax(2, 4),
            PopulationType::LARGE_CITY => new MinMax(3, 7),
            PopulationType::METROPOLIS => new MinMax(4, 8),
        );
    }
}
