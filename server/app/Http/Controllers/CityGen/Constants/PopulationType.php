<?php

namespace App\Http\Controllers\CityGen\Constants;

use App\Http\Controllers\CityGen\Services\ServicesService;

class PopulationType extends BaseEnum
{
    const THORP = 'Thorp';
    const HAMLET = 'Hamlet';
    const VILLAGE = 'Village';
    const SMALL_TOWN = 'SmallTown';
    const LARGE_TOWN = 'LargeTown';
    const SMALL_CITY = 'SmallCity';
    const LARGE_CITY = 'LargeCity';
    const METROPOLIS = 'Metropolis';

    /**
     * check that a city is at least a certain size
     *
     * @param string $cityPopulationType city's population size that is being tested
     * @param string $minPopulationType target population size city must be at least this size
     * @param ServicesService $services
     * @return bool
     */
    public static function isCitySizeAtLeast(string $cityPopulationType, string $minPopulationType, $services) {
        return false !== array_search($cityPopulationType, $services->table->getTableResultIndex(Table::IS_CITY_SIZE_AT_LEAST, $minPopulationType));
    }
}
