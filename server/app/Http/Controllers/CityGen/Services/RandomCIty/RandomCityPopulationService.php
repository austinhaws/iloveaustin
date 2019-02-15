<?php

namespace App\Http\Controllers\CityGen\Services\RandomCity;

use App\Http\Controllers\CityGen\Constants\PopulationType;
use App\Http\Controllers\CityGen\Constants\Table;
use App\Http\Controllers\CityGen\Models\City\City;
use App\Http\Controllers\CityGen\Models\Post\PostData;
use App\Http\Controllers\CityGen\Services\BaseService;

class RandomCityPopulationService extends BaseService
{

    /**
     * randomize or set population and side effects
     *
     * @param City $city
     * @param PostData $postData
     */
    public function determinePopulation(City $city, PostData $postData)
    {
        // population type
        $populationType = $postData->populationType;
        if ($this->services->random->isRandom($populationType)) {
            $city->populationType = $this->services->table->getTableResultRandom(Table::POPULATION_TYPE);
        } else {
            $this->useEnteredPopulationType($city, $populationType);
        }

        // population size: if hand entered, may already be set
        if ($city->populationSize === null) {
            $value = $this->services->table->getTableResultIndex(Table::POPULATION_SIZE, $city->populationType);
            $city->populationSize = $this->services->random->randMinMax("Random Population Size", $value);
        }

        $city->goldPieceLimit = $this->services->table->getTableResultIndex(Table::POPULATION_WEALTH, $city->populationType);
        $city->wealth = (float)$city->goldPieceLimit * 0.5 * (float)($city->populationSize) * 0.1;
        $city->kingIncome = $this->services->table->getTableResultIndex(Table::KING_INCOME, $city->populationType) * $city->wealth;
        $city->magicResources = $this->services->table->getTableResultIndex(Table::MAGIC_RESOURCES, $city->populationType) * $city->wealth;
    }

    /**
     * user picked a population type or an actual #. if a number then determine what size of city is good for that number
     *
     * @param City $city
     * @param string $populationType
     */
    private function useEnteredPopulationType(City $city, string $populationType)
    {
        switch ($populationType) {
            case PopulationType::THORP:
            case PopulationType::HAMLET:
            case PopulationType::VILLAGE:
            case PopulationType::SMALL_TOWN:
            case PopulationType::LARGE_TOWN:
            case PopulationType::SMALL_CITY:
            case PopulationType::LARGE_CITY:
            case PopulationType::METROPOLIS:
                $city->populationType = $populationType;
                break;
            default:
                // they hand entered a value
                $entered_value = intval($populationType, 10);

                // check for bounds
                $populationSizeTable = Table::getTable(Table::POPULATION_SIZE)->getTable();
                $city->populationType = false;
                if ($entered_value < $populationSizeTable[PopulationType::THORP]->min) {
                    $entered_value = $populationSizeTable[PopulationType::THORP]->min;
                    $city->populationType = PopulationType::THORP;
                } else if ($entered_value > $populationSizeTable[PopulationType::METROPOLIS]->max) {
                    // hand entered a very large value, so make it a metropolis
                    $city->populationType = PopulationType::METROPOLIS;
                }

                // if population type not yet set, determine what it should be
                if (!$city->populationType) {
                    $city->populationType = $this->services->table->getTableKeyFromRangeValue(Table::POPULATION_SIZE, $entered_value);
                }

                $city->populationSize = $entered_value;
                break;
        }
    }

}
