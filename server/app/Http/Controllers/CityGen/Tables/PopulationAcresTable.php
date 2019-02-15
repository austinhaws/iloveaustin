<?php

namespace App\Http\Controllers\CityGen\Tables;

use App\Http\Controllers\CityGen\Constants\PopulationType;
use App\Http\Controllers\CityGen\Models\MinMax;

class PopulationAcresTable extends BaseTable
{

    function getTable()
    {
        return array(
            PopulationType::THORP => new MinMax(1, 9),
            PopulationType::HAMLET => new MinMax(10, 19),
            PopulationType::VILLAGE => new MinMax(20, 29),
            PopulationType::SMALL_TOWN => new MinMax(30, 39),
            PopulationType::LARGE_TOWN => new MinMax(40, 79),
            PopulationType::SMALL_CITY => new MinMax(80, 120),
            PopulationType::LARGE_CITY => new MinMax(121, 149),
            PopulationType::METROPOLIS => new MinMax(150, 200),
        );
    }
}
