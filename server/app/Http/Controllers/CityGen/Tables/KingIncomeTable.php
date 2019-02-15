<?php

namespace App\Http\Controllers\CityGen\Tables;

use App\Http\Controllers\CityGen\Constants\PopulationType;

class KingIncomeTable extends BaseTable
{
    function getTable()
    {
        return array(
            PopulationType::THORP => 0.003,
            PopulationType::HAMLET => 0.002,
            PopulationType::VILLAGE => 0.002,
            PopulationType::SMALL_TOWN => 0.01,
            PopulationType::LARGE_TOWN => 0.01,
            PopulationType::SMALL_CITY => 0.005,
            PopulationType::LARGE_CITY => 0.0025,
            PopulationType::METROPOLIS => 0.0005,
        );
    }
}
