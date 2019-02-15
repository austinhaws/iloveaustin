<?php

namespace App\Http\Controllers\CityGen\Services\RandomCity;

use App\Http\Controllers\CityGen\Constants\BooleanRandom;
use App\Http\Controllers\CityGen\Constants\MinMax;
use App\Http\Controllers\CityGen\Constants\Table;
use App\Http\Controllers\CityGen\Models\City\City;
use App\Http\Controllers\CityGen\Models\Post\PostData;
use App\Http\Controllers\CityGen\Services\BaseService;

class RandomSeaRiverMilitaryGatesService extends BaseService
{

    public function determineZones(City $city, PostData $postData)
    {
        // sea
        $city->hasSea = $postData->hasSea;
        if ($city->hasSea === BooleanRandom::RANDOM) {
            $city->hasSea = BooleanRandom::construct($this->services->random->percentile('Has Sea') <= 33);
        }

        // river
        $city->hasRiver = $postData->hasRiver;
        if ($city->hasRiver === BooleanRandom::RANDOM) {
            $city->hasRiver = BooleanRandom::construct($this->services->random->percentile('Has River') <= 33);
        }

        // military
        $city->hasMilitary = $postData->hasMilitary;
        if ($city->hasMilitary === BooleanRandom::RANDOM) {
            $range = $this->services->table->getTableResultIndex(Table::POPULATION_MILITARY, $city->populationType);
            $city->hasMilitary = BooleanRandom::construct($this->services->random->percentile('Has Military') <= $range);
        }

        // gates
        if ($postData->hasGates === BooleanRandom::RANDOM) {
            $range = $this->services->table->getTableResultIndex(Table::POPULATION_HAS_WALLS, $city->populationType);
            $postData->hasGates = BooleanRandom::construct($this->services->random->percentile('Has Walls') <= $range);
        }

        if ($postData->hasGates === BooleanRandom::TRUE) {
            $numGatesRange = $this->services->table->getTableResultIndex(Table::POPULATION_NUM_WALLS, $city->populationType);
            $city->gates = $this->services->random->randMinMax('Num Gates', $numGatesRange);
        } else {
            $city->gates = 0;
        }
    }
}
