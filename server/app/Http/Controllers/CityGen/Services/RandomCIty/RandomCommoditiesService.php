<?php

namespace App\Http\Controllers\CityGen\Services\RandomCity;

use App\Http\Controllers\CityGen\Constants\Table;
use App\Http\Controllers\CityGen\Models\City\City;
use App\Http\Controllers\CityGen\Models\Post\PostData;
use App\Http\Controllers\CityGen\Services\BaseService;

class RandomCommoditiesService extends BaseService
{

    /**
     *
     * @param City $city
     * @param PostData $postData
     */
    public function determineCommodities(City $city, PostData $postData)
    {
        $minMax = $this->services->table->getTableResultIndex(Table::COMMODITY_COUNT, $city->populationType);
        $this->services->table->fillRandomStrings($city->commoditiesExport, Table::COMMODITIES, $this->services->random->randMinMax('Number Exports', $minMax));
        $this->services->table->fillRandomStrings($city->commoditiesImport, Table::COMMODITIES, $this->services->random->randMinMax('Number Imports', $minMax));
    }
}
