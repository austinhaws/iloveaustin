<?php

namespace App\Http\Controllers\CityGen\Tables;

use App\Http\Controllers\CityGen\Constants\PopulationType;
use App\Http\Controllers\CityGen\Models\MinMax;

class PopulationNumStructuresTable extends BaseTable
{

    function getTable()
    {
        return array(
            PopulationType::THORP => new MinMax(0, 4),
            PopulationType::HAMLET => new MinMax(5, 9),
            PopulationType::VILLAGE => new MinMax(10, 14),
            PopulationType::SMALL_TOWN => new MinMax(15, 19),
            PopulationType::LARGE_TOWN => new MinMax(20, 39),
            PopulationType::SMALL_CITY => new MinMax(40, 49),
            PopulationType::LARGE_CITY => new MinMax(50, 69),
            PopulationType::METROPOLIS => new MinMax(60, 80),
        );
    }
}
