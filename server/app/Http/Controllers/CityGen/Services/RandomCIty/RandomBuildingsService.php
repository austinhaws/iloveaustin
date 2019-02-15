<?php

namespace App\Http\Controllers\CityGen\Services\RandomCity;

use App\Http\Controllers\CityGen\Constants\Table;
use App\Http\Controllers\CityGen\Models\City\City;
use App\Http\Controllers\CityGen\Models\City\CityBuilding;
use App\Http\Controllers\CityGen\Models\City\CityWard;
use App\Http\Controllers\CityGen\Models\Table\TableBuilding;
use App\Http\Controllers\CityGen\Services\BaseService;

class RandomBuildingsService extends BaseService
{
    /**
     * @param City $city
     * @param CityWard $ward
     * @param int[]|null $buildingWeights
     */
    public function generateBuildings($city, $ward, $buildingWeights)
    {
        // determine how many buildings per acre
        $acresDensity = Table::getTable(Table::POPULATION_WARD_DENSITY)->getTable()[$city->populationType][$ward->type];
        $wardDensityAcres = max(1, $acresDensity * $ward->acres);

        // use given weights or from the buildings table
        $buildingWeightsUse = $buildingWeights ? $buildingWeights : Table::getTable(Table::BUILDINGS)->getTable()[$ward->type];
        $tableBuildingSubtypes = Table::getTable(Table::BUILDINGS_SUBTYPES)->getTable();

        // add buildings to fill densityAcres
        for ($i = 1; $i <= $wardDensityAcres; ++$i) {
            $tableBuilding = $this->services->table->getTableResultRangeCustom('Building Weight', $buildingWeightsUse);
            $quality = $this->services->random->randMinMax('Building Quality', $tableBuilding->qualityMinMax);

            if (isset($tableBuildingSubtypes[$tableBuilding->building])) {
                $subTypes = $tableBuildingSubtypes[$tableBuilding->building];
                $subType = $subTypes[$this->services->table->getCustomTableResultRange('Building SubType', $subTypes)];
            } else {
                $subType = null;
            }
            $ward->buildings[] = new CityBuilding($tableBuilding->building, $subType, $quality);
        }

        // sort by name
        usort($ward->buildings, function ($a, $b) {
            return strcmp($a->building, $b->building);
        });
    }
}
