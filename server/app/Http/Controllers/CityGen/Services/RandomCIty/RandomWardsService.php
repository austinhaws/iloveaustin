<?php

namespace App\Http\Controllers\CityGen\Services\RandomCity;

use App\Http\Controllers\CityGen\Constants\BooleanRandom;
use App\Http\Controllers\CityGen\Constants\PopulationType;
use App\Http\Controllers\CityGen\Constants\Table;
use App\Http\Controllers\CityGen\Constants\Ward;
use App\Http\Controllers\CityGen\Models\City\City;
use App\Http\Controllers\CityGen\Models\City\CityWard;
use App\Http\Controllers\CityGen\Models\Post\PostData;
use App\Http\Controllers\CityGen\Models\Service\RandomWardMetaData;
use App\Http\Controllers\CityGen\Services\BaseService;

class RandomWardsService extends BaseService
{

    public function determineWards(City $city, PostData $postData)
    {

        $wardMetaData = $this->determineWardCounts($city, $postData);
        $wardMetaData->acresToFill = $city->acres;

        $this->addSpecificWards($city, $postData, $wardMetaData);

        // fill up acres with wards
        while ($wardMetaData->acresToFill > 0) {
            $this->addRandomWard($city, $postData, $wardMetaData);
        }
    }

    /**
     * @param City $city
     * @param string $ward_type
     * @param bool $insideWalls
     * @param int[] $wardCount how many of each ward
     * @param string $generateBuildings RandomBoolean::
     * @param int[]|null $buildingWeights
     * @return float how many acres are left
     */
    private function addWard(City $city, string $ward_type, bool $insideWalls, array &$wardCount, string $generateBuildings, array $buildingWeights = null)
    {
        // based on city type, should allocate bigger/smaller randomness in sizes
        $value = $this->services->table->getTableResultIndex(Table::WARD_ACRES_USED, $city->populationType);

        $acresUsed = $this->services->random->randMinMax('Ward acres used', $value);

        $ward = new CityWard();
        $ward->type = $ward_type;
        $ward->acres = $acresUsed;
        $ward->insideWalls = $insideWalls;
        if ($generateBuildings === BooleanRandom::TRUE) {
            $this->services->randomBuildings->generateBuildings($city, $ward, $buildingWeights);
        }

        $city->wards[] = $ward;
        $wardCount[$ward->type]++;

        return $acresUsed;
    }

    /**
     * geta meta data about ward counts
     *
     * @param City $city
     * @param PostData $postData
     * @return RandomWardMetaData
     */
    private function determineWardCounts(City $city, PostData $postData)
    {
        $metaData = new RandomWardMetaData();

        $metaData->requiredWards = 2 +
            $city->gates +
            ($city->hasSea ? 1 : 0) +
            ($city->hasRiver ? 1 : 0) +
            ($city->hasMilitary ? 1 : 0) +
            (PopulationType::isCitySizeAtLeast($city->populationType, PopulationType::SMALL_TOWN, $this->services) ? 1 : 0) +
            (PopulationType::isCitySizeAtLeast($city->populationType, PopulationType::SMALL_CITY, $this->services) ? 1 : 0) +
            (PopulationType::isCitySizeAtLeast($city->populationType, PopulationType::METROPOLIS, $this->services) ? 1 : 0);

        // check if custom entered wards satisfy required wards
        $metaData->numGates = $city->gates;
        foreach ($postData->wardsAdded as $wardAdded) {
            if ($wardAdded->ward === Ward::GATE) {
                if ($metaData->numGates > 0) {
                    $metaData->numGates--;
                } else {
                    // make sure the count is correct
                    $city->gates++;
                }
            } else {
                // don't have to do more of these wards because it's already done
                $metaData->alreadyDone[$wardAdded->ward] = true;
                break;
            }
        }

        $metaData->acresPerWard = $city->acres / ($metaData->requiredWards + count($postData->wardsAdded));

        return $metaData;
    }

    /**
     * @param City $city
     * @param PostData $postData
     * @param RandomWardMetaData $wardMetaData
     */
    private function addSpecificWards(City $city, PostData $postData, RandomWardMetaData $wardMetaData)
    {
        foreach ($postData->wardsAdded as $wardAdded) {
            $wardMetaData->acresToFill -= $this->addWard($city, $wardAdded->ward, $postData->hasGates === BooleanRandom::TRUE, $wardMetaData->wardCount, $postData->generateBuildings);
        }

        // put in wards
        for ($i = 1; $i <= $wardMetaData->numGates; ++$i) {
            $wardMetaData->acresToFill -= $this->addWard($city, Ward::GATE, true, $wardMetaData->wardCount, $postData->generateBuildings);
        }

        if ($city->hasSea === BooleanRandom::TRUE && !$wardMetaData->alreadyDone[Ward::SEA]) {
            $wardMetaData->acresToFill -= $this->addWard($city, Ward::SEA, $postData->hasGates === BooleanRandom::TRUE && $this->services->random->percentile('Sea inside walls') < 50, $wardMetaData->wardCount, $postData->generateBuildings);
        }

        if ($city->hasRiver === BooleanRandom::TRUE && !$wardMetaData->alreadyDone[Ward::RIVER]) {
            $wardMetaData->acresToFill -= $this->addWard($city, Ward::RIVER, $postData->hasGates === BooleanRandom::TRUE && $this->services->random->percentile('River inside walls') < 50, $wardMetaData->wardCount, $postData->generateBuildings);
        }

        if ($city->hasMilitary === BooleanRandom::TRUE && !$wardMetaData->alreadyDone[Ward::MILITARY]) {
            $wardMetaData->acresToFill -= $this->addWard($city, Ward::MILITARY, $postData->hasGates === BooleanRandom::TRUE, $wardMetaData->wardCount, $postData->generateBuildings);
        }

        if (PopulationType::isCitySizeAtLeast($city->populationType, PopulationType::SMALL_TOWN, $this->services) && !$wardMetaData->alreadyDone[Ward::ADMINISTRATION]) {
            $wardMetaData->acresToFill -= $this->addWard($city, Ward::ADMINISTRATION, $postData->hasGates === BooleanRandom::TRUE, $wardMetaData->wardCount, $postData->generateBuildings);
        }

        if (PopulationType::isCitySizeAtLeast($city->populationType, PopulationType::SMALL_CITY, $this->services) && !$wardMetaData->alreadyDone[Ward::CRAFTSMEN]) {
            $wardMetaData->acresToFill -= $this->addWard($city, Ward::CRAFTSMEN, $postData->hasGates === BooleanRandom::TRUE, $wardMetaData->wardCount, $postData->generateBuildings);
        }

        if (PopulationType::isCitySizeAtLeast($city->populationType, PopulationType::METROPOLIS, $this->services) && !$wardMetaData->alreadyDone[Ward::PATRICIATE]) {
            $wardMetaData->acresToFill -= $this->addWard($city, Ward::PATRICIATE, $postData->hasGates === BooleanRandom::TRUE, $wardMetaData->wardCount, $postData->generateBuildings);
        }

        if (!$wardMetaData->alreadyDone[Ward::MARKET]) {
            $wardMetaData->acresToFill -= $this->addWard($city, Ward::MARKET, $postData->hasGates === BooleanRandom::TRUE, $wardMetaData->wardCount, $postData->generateBuildings);
        }

        if (!$wardMetaData->alreadyDone[Ward::MERCHANT]) {
            $wardMetaData->acresToFill -= $this->addWard($city, Ward::MERCHANT, $postData->hasGates === BooleanRandom::TRUE, $wardMetaData->wardCount, $postData->generateBuildings);
        }
    }

    private function addRandomWard(City $city, PostData $postData, RandomWardMetaData $wardMetaData)
    {
        //	ward	1->10 (1 = not common)	range	X >= percentile
        //----------------------------------------------------------------------------------------
        // ---- 25 % -----
        //Patriciate	1	1	1
        //Administration	2	10	11
        //Sea	3	2	13
        //River	4	3	16
        //Odiferous	5	9	25
        // ---- 75% ----
        //Shanty	6	5	30
        //Slums	7	10	40
        //Merchant	8	15	55
        //Market	9	20	75
        //Craftsmen	10	25	100
        $rand = $this->services->random->percentile('Ward Type');

        // Patriciate //
        if ($rand <= 1) {
            if (PopulationType::isCitySizeAtLeast($city->populationType, PopulationType::SMALL_CITY, $this->services) && $wardMetaData->wardCount[Ward::PATRICIATE] == 0) {
                // only one patriciate ward
                // always inside the walls
                $wardMetaData->acresToFill -= $this->addWard($city, Ward::PATRICIATE, $postData->hasGates === BooleanRandom::TRUE, $wardMetaData->wardCount, $postData->generateBuildings);
            }

            // Administration //
        } elseif ($rand <= 11) {
            // if small town or smaller then will ALWAYS get administration above; so when it gets here it will always have an administration ward if it's small_city or bigger, so this is worthless and unreachable
            if (PopulationType::isCitySizeAtLeast($city->populationType, PopulationType::SMALL_CITY, $this->services) && $wardMetaData->wardCount[Ward::ADMINISTRATION] == 0) {
                //only one administration ward
                // always inside the walls
                // !!! unreachable !!! //
                $wardMetaData->acresToFill -= $this->addWard($city, Ward::ADMINISTRATION, $postData->hasGates === BooleanRandom::TRUE, $wardMetaData->wardCount, $postData->generateBuildings);
            }

            // Sea //
        } elseif ($rand <= 13) {
            if ($city->hasSea === BooleanRandom::TRUE) {
                $seaCount = 0;
                foreach ($city->wards as $ward) {
                    if ($ward->type == Ward::SEA) {
                        $seaCount++;
                    }
                }
                // seas start in corners of city so don't allow more than 4
                if ($seaCount < 4) {
                    $wardMetaData->acresToFill -= $this->addWard($city, Ward::SEA, false, $wardMetaData->wardCount, $postData->generateBuildings);
                }
            }

            // River //
        } elseif ($rand <= 16) {
            if ($city->hasRiver === BooleanRandom::TRUE) {
                $wardMetaData->acresToFill -= $this->addWard($city, Ward::RIVER, $postData->hasGates === BooleanRandom::TRUE && $this->services->random->percentile('River inside walls?') < 50, $wardMetaData->wardCount, $postData->generateBuildings);
            }

            // Odoriferous //
        } elseif ($rand <= 25) {
            $wardMetaData->acresToFill -= $this->addWard($city, Ward::ODORIFEROUS, $postData->hasGates === BooleanRandom::TRUE && $this->services->random->percentile('Odoriferous inside walls?') < 5, $wardMetaData->wardCount, $postData->generateBuildings);

            // Shanty //
        } elseif ($rand <= 30) {
            if (PopulationType::isCitySizeAtLeast($city->populationType, PopulationType::SMALL_CITY, $this->services)) {
                // outside the walls
                $wardMetaData->acresToFill -= $this->addWard($city, Ward::SHANTY, false, $wardMetaData->wardCount, $postData->generateBuildings);
            }

            // Slum //
        } elseif ($rand <= 40) {
            if (PopulationType::isCitySizeAtLeast($city->populationType, PopulationType::SMALL_CITY, $this->services)) {
                // outside the walls
                $wardMetaData->acresToFill -= $this->addWard($city, Ward::SLUM, $postData->hasGates === BooleanRandom::TRUE, $wardMetaData->wardCount, $postData->generateBuildings);
            }

            // Merchant //
        } elseif ($rand <= 55) {
            // one merchant ward in town unless metropolis; note: merchant is always added, so don't need to check for === 0 since it will always be > 0
            if (PopulationType::isCitySizeAtLeast($city->populationType, PopulationType::METROPOLIS, $this->services)) {
                $wardMetaData->acresToFill -= $this->addWard($city, Ward::MERCHANT, $postData->hasGates === BooleanRandom::TRUE, $wardMetaData->wardCount, $postData->generateBuildings);
            }

            // Market //
        } elseif ($rand <= 75) {
            // mostly inside walls
            $wardMetaData->acresToFill -= $this->addWard($city, Ward::MARKET, $postData->hasGates === BooleanRandom::TRUE && $this->services->random->percentile('Market inside walls?') < 83, $wardMetaData->wardCount, $postData->generateBuildings);

            // Craftsmen //
        } else {
            // most common ward within city walls
            // more than one ward possible in large towns or larger
            // mostly inside city walls
            if ((PopulationType::isCitySizeAtLeast($city->populationType, PopulationType::LARGE_TOWN, $this->services) && $wardMetaData->wardCount[Ward::CRAFTSMEN] <= 1)
                    || PopulationType::isCitySizeAtLeast($city->populationType, PopulationType::METROPOLIS, $this->services)) {
                $wardMetaData->acresToFill -= $this->addWard($city, Ward::CRAFTSMEN, $postData->hasGates === BooleanRandom::TRUE && $this->services->random->percentile('Craftsmen inside walls?') < 90, $wardMetaData->wardCount, $postData->generateBuildings);
            }
        }
    }
}
