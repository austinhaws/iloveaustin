<?php

namespace App\Http\Controllers\CityGen\Services\RandomCity;

use App\Http\Controllers\CityGen\Constants\Table;
use App\Http\Controllers\CityGen\Models\City\City;
use App\Http\Controllers\CityGen\Models\Post\PostData;
use App\Http\Controllers\CityGen\Services\BaseService;

class RandomFamousService extends BaseService
{

    /**
     *
     * @param City $city
     * @param PostData $postData
     */
    public function determineFamous(City $city, PostData $postData)
    {
        $famousMinMax = $this->services->table->getTableResultIndex(Table::FAMOUS_OCCURRENCE, $city->populationType);
        $this->services->table->fillRandomStrings($city->famous, Table::FAMOUS, $this->services->random->randMinMax('Number Famous', $famousMinMax));
        $this->services->table->fillRandomStrings($city->infamous, Table::FAMOUS, $this->services->random->randMinMax('Number Infamous', $famousMinMax));
    }
}
