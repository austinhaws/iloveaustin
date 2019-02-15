<?php

namespace App\Http\Controllers\CityGen\Services\RandomCity;

use App\Http\Controllers\CityGen\Constants\Table;
use App\Http\Controllers\CityGen\Models\City\City;
use App\Http\Controllers\CityGen\Services\BaseService;

class RandomAcresStructuresService extends BaseService
{
    /**
     * @param City $city
     */
    public function randomAcres(City $city)
    {
        $value = $this->services->table->getTableResultIndex(Table::POPULATION_ACRES, $city->populationType);
        $city->acres = intVal($city->populationSize / $this->services->random->randRatioRange("randomAcres", $value->min, $value->max));
    }

    /**
     * @param City $city
     */
    public function randomNumStructures(City $city)
    {
        $value = $this->services->table->getTableResultIndex(Table::POPULATION_NUM_STRUCTURES, $city->populationType);
        $city->numStructures = intVal($city->acres / $this->services->random->randRatioRange("randomNumStructures", $value->min, $value->max));
    }
}
