<?php

namespace App\Http\Controllers\CityGen\Services\RandomCity;

use App\Http\Controllers\CityGen\Constants\Race;
use App\Http\Controllers\CityGen\Constants\Table;
use App\Http\Controllers\CityGen\Models\City\City;
use App\Http\Controllers\CityGen\Models\City\CityRace;
use App\Http\Controllers\CityGen\Models\Post\PostData;
use App\Http\Controllers\CityGen\Models\Post\PostRaceRatio;
use App\Http\Controllers\CityGen\Services\BaseService;

class RandomRacesService extends BaseService
{

    /**
     *
     * @param City $city
     * @param PostData $postData
     */
    public function determineRaces(City $city, PostData $postData)
    {
        $this->setMajorityRace($city, $postData);
        $this->setRaceRatios($city, $postData);
        $this->setPopulations($city, $postData);
    }

    private function setMajorityRace(City $city, PostData $postData)
    {
        if ($postData->racialMix === RandomService::CUSTOM) {
            // create map of [race => value]
            usort($postData->raceRatio, function ($a, $b) {
                return $b->ratio < $a->ratio ? -1 : ($b->ratio > $a->ratio ? 1 : 0);
            });

            $totalValues = array_reduce($postData->raceRatio, function ($total, $raceRatio) {
                return $total + $raceRatio->ratio;
            }, 0.0);

            // setup race ratios
            if ($totalValues !== 0.0) {
                foreach($postData->raceRatio as $raceRatio) {
                    $raceRatio->ratio = $raceRatio->ratio / $totalValues;
                }
                $city->majorityRace = $postData->raceRatio[0]->race;
            }
        }
    }

    private function setRaceRatios(City $city, PostData $postData)
    {

        // if they didn't choose custom or they didn't choose sliders for custom
        if ($city->majorityRace === null) {
            if ($this->services->random->isRandom($postData->racialMix)) {
                $this->randomRacialMix($postData);
            }

            if ($this->services->random->isRandom($postData->race)) {
                $postData->race = $this->services->table->getTableResultRange(Table::RACES_RANDOM);
            }
            $city->majorityRace = $postData->race;

            // list of races with majority at top
            $racesOrdered = array_filter(array_values(Race::getConstants()), function ($race) use ($city) {
                return $race !== $city->majorityRace;
            });
            array_unshift($racesOrdered, $city->majorityRace);

            // get ordered list of ratios
            $ratioTotal = 0.0;
            $ratios = [];
            if ($postData->racialMix === RandomService::CUSTOM) {
                $ratios = array_map(function ($race) use ($postData) {
                    // find ratio for race in supplied ratio information
                    $raceRatioArray = array_filter($postData->raceRatio, function ($raceRatio) use ($race) {
                        return $raceRatio->race === $race;
                    });

                    // if not found then ratio is 0
                    return count($raceRatioArray) === 0 ? 0.0 : $raceRatioArray[0]->ratio;
                }, $racesOrdered);
                $ratioTotal = array_reduce($ratios, function ($carry, $ratio) {
                    return $carry + $ratio;
                }, 0.0);
            }
            if ($postData->racialMix !== RandomService::CUSTOM || $ratioTotal === 0.0) {
                if ($postData->racialMix === RandomService::CUSTOM) {
                    $this->randomRacialMix($postData);
                }
                $ratios = Table::getTable(Table::RACES_PERCENTS)->getTable()[$postData->racialMix];
            }

            // combine races and ratios
            $postData->raceRatio = array_map(
                function ($race, $ratio) {
                    return new PostRaceRatio($race, $ratio);
                },
                $racesOrdered,
                $ratios
            );
        }
    }

    private function setPopulations(City $city, PostData $postData)
    {

        // give each race some population
        $city->races = array_map(function ($raceRatio) use ($city) {
            return new CityRace($raceRatio->race, floor($raceRatio->ratio * $city->populationSize));
        }, $postData->raceRatio);

        // give the majority race any left overs
        $total = array_reduce($city->races, function ($carry, $race) {
            return $carry + $race->total;
        }, 0);
        $city->races[0]->total += $city->populationSize - $total;

        // remove 0 sized races
        $city->races = array_filter($city->races, function ($race) {
            return $race->total > 0;
        });

        // races already sorted by size because of ratios from integration so no need to sort again
    }

    /**
     * @param PostData $postData
     */
    private function randomRacialMix(PostData $postData)
    {
        $postData->racialMix = $this->services->table->getTableResultIndex(Table::INTEGRATION, $this->services->random->randRangeInt('Racial Mix', 1, 3));
    }

}
