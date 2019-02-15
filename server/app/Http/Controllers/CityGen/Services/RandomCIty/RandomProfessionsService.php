<?php

namespace App\Http\Controllers\CityGen\Services\RandomCity;

use App\Http\Controllers\CityGen\Constants\BooleanRandom;
use App\Http\Controllers\CityGen\Constants\Table;
use App\Http\Controllers\CityGen\Models\City\City;
use App\Http\Controllers\CityGen\Models\City\CityProfession;
use App\Http\Controllers\CityGen\Models\Post\PostData;
use App\Http\Controllers\CityGen\Services\BaseService;

class RandomProfessionsService extends BaseService
{

    /**
     * @param City $city
     * @param PostData $postData
     */
    public function determineProfessions(City $city, PostData $postData)
    {
        if ($postData->professions === BooleanRandom::TRUE) {
            $total = 0;

            // add automatic ratio'ed professions
            $tableProfessionRatio = Table::getTable(Table::PROFESSION_RATIO)->getTable();
            foreach ($tableProfessionRatio as $profession => $entry) {
                $num = intval($city->populationSize / $entry);
                if ($num > 0) {
                    $this->addProfession($city, $profession, $num);
                }
                $total += $num;
            }

            // for all population not accounted for in ratio'ed, do random single load
            for(;$total < $city->populationSize; $total++) {
                $this->addProfession($city, $this->services->table->getTableResultRange(Table::PROFESSION), 1);
            }

            usort($city->professions, function ($a, $b) {
                return strcmp($a->profession, $b->profession);
            });
        }
    }

    /**
     * @param City $city
     * @param string $profession Profession::
     * @param int $num
     */
    private function addProfession(City $city, string $profession, int $num)
    {
        $found = false;
        foreach ($city->professions as $professionLoop) {
            if ($professionLoop->profession == $profession) {
                $professionLoop->total += $num;
                $found = true;
                break;
            }
        }

        if (!$found) {
            $city->professions[] = new CityProfession($profession, $num);
        }
    }
}
