<?php

namespace App\Http\Controllers\CityGen\Services;

use App\Http\Controllers\CityGen\Constants\BooleanRandom;
use App\Http\Controllers\CityGen\Constants\Integration;
use App\Http\Controllers\CityGen\Constants\PopulationType;
use App\Http\Controllers\CityGen\Constants\Race;
use App\Http\Controllers\CityGen\Constants\Ward;

class ListsService
{

    const ID = 'id';
    const LABEL = 'label';

    public function getLists()
    {
        return [
            'populationTypes' => $this->enumToList(PopulationType::getConstants(), [
                PopulationType::THORP => 'Thorp (20-80)',
                PopulationType::HAMLET => 'Hamlet (81-400)',
                PopulationType::VILLAGE => 'Village (401-900)',
                PopulationType::SMALL_TOWN => 'Small Town (901-2000)',
                PopulationType::LARGE_TOWN => 'Large Town (2001-5000)',
                PopulationType::SMALL_CITY => 'Small City (5001-12000)',
                PopulationType::LARGE_CITY => 'Large City (12001-32000)',
                PopulationType::METROPOLIS => 'Metropolis (32001+)',
            ]),
            'integration' => $this->enumToList(Integration::getConstants()),
            'race' => $this->enumToList(Race::getConstants()),
            'wards' => $this->enumToList(Ward::getConstants()),
            'buildingsByWard' => $this->buildingsByWard(),
            'booleanRandomValues' => BooleanRandom::getConstants(),
        ];
    }

    /**
     * @param array $enums
     * @param array|null $labelConversion
     * @return array
     */
    private function enumToList(array $enums, array $labelConversion = null)
    {

        return array_reduce($enums, function ($carry, $item) use ($labelConversion) {
            $carry[] = [
                ListsService::ID => $item,
                ListsService::LABEL => $labelConversion ? $labelConversion[$item] : $item,
            ];
            return $carry;
        }, []);
    }

    /**
     * list of each ward and what buildings are allowed in that ward
     *
     * @return array
     */
    private function buildingsByWard()
    {
        return array_reduce(Ward::getConstants(), function ($carry, $ward) {
            $carry[$ward] = Ward::buildingsForWard($ward);
            return $carry;
        }, []);
    }
}
