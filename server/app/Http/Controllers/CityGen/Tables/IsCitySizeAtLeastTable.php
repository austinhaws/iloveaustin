<?php

namespace App\Http\Controllers\CityGen\Tables;

use App\Http\Controllers\CityGen\Constants\PopulationType;

class IsCitySizeAtLeastTable extends BaseTable
{
    function getTable()
    {
        return array(
            PopulationType::THORP => array(
                PopulationType::THORP,
                PopulationType::HAMLET,
                PopulationType::VILLAGE,
                PopulationType::SMALL_TOWN,
                PopulationType::LARGE_TOWN,
                PopulationType::SMALL_CITY,
                PopulationType::LARGE_CITY,
                PopulationType::METROPOLIS,
            ),
            PopulationType::HAMLET => array(
                PopulationType::HAMLET,
                PopulationType::VILLAGE,
                PopulationType::SMALL_TOWN,
                PopulationType::LARGE_TOWN,
                PopulationType::SMALL_CITY,
                PopulationType::LARGE_CITY,
                PopulationType::METROPOLIS,
            ),
            PopulationType::VILLAGE => array(
                PopulationType::VILLAGE,
                PopulationType::SMALL_TOWN,
                PopulationType::LARGE_TOWN,
                PopulationType::SMALL_CITY,
                PopulationType::LARGE_CITY,
                PopulationType::METROPOLIS,
            ),
            PopulationType::SMALL_TOWN => array(
                PopulationType::SMALL_TOWN,
                PopulationType::LARGE_TOWN,
                PopulationType::SMALL_CITY,
                PopulationType::LARGE_CITY,
                PopulationType::METROPOLIS,
            ),
            PopulationType::LARGE_TOWN => array(
                PopulationType::LARGE_TOWN,
                PopulationType::SMALL_CITY,
                PopulationType::LARGE_CITY,
                PopulationType::METROPOLIS,
            ),
            PopulationType::SMALL_CITY => array(
                PopulationType::SMALL_CITY,
                PopulationType::LARGE_CITY,
                PopulationType::METROPOLIS,
            ),
            PopulationType::LARGE_CITY => array(
                PopulationType::LARGE_CITY,
                PopulationType::METROPOLIS,
            ),
            PopulationType::METROPOLIS => array(
                PopulationType::METROPOLIS,
            ),
        );
    }
}
