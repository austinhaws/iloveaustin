<?php

namespace App\Http\Controllers\CityGen\Tables;

use App\Http\Controllers\CityGen\Constants\PopulationType;
use App\Http\Controllers\CityGen\Models\MinMax;

class WardAcresUsedTable extends BaseTable
{

    function getTable()
    {
        return [
            PopulationType::THORP => new MinMax(1, 2),
            PopulationType::HAMLET => new MinMax(1, 3),
            PopulationType::VILLAGE => new MinMax(2, 5),
            PopulationType::SMALL_TOWN => new MinMax(2, 7),
            PopulationType::LARGE_TOWN => new MinMax(3, 9),
            PopulationType::SMALL_CITY => new MinMax(4, 11),
            PopulationType::LARGE_CITY => new MinMax(5, 13),
            PopulationType::METROPOLIS => new MinMax(6, 15),
        ];
    }
}
