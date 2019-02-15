<?php

namespace App\Http\Controllers\CityGen\Services\RandomCity;

use App\Http\Controllers\CityGen\Models\City\City;
use App\Http\Controllers\CityGen\Models\Post\PostData;
use App\Http\Controllers\CityGen\Services\BaseService;

class RandomCityService extends BaseService
{
    /**
     * @param PostData $postData
     */
    public function randomizeCity(PostData $postData)
    {
        $city = new City();

        $this->services->randomCityPopulation->determinePopulation($city, $postData);
        $this->services->randomAcresStructures->randomAcres($city);
        $this->services->randomAcresStructures->randomNumStructures($city);
        $this->services->randomSeaRiverMilitaryGates->determineZones($city, $postData);
        $this->services->randomWards->determineWards($city, $postData);
        $this->services->randomProfessions->determineProfessions($city, $postData);
        $this->services->randomPowerCenters->determinePowerCenters($city, $postData);
        $this->services->randomRacesService->determineRaces($city, $postData);
        $this->services->randomGuildService->determineGuilds($city, $postData);
        $this->services->randomCommodities->determineCommodities($city, $postData);
        $this->services->randomFamous->determineFamous($city, $postData);

//        if ($post['name']) {
//            $this->name = $post['name'];
//        } else {
//            $this->random_name();
//        }
//
//        // for json/mustache put calculated fields in to variables for easy access
//        $this->races_output = $this->output_races();
//        $this->gold_piece_limit_output = $this->gold_piece_limit();
//        $this->wealth_output = $this->wealth();
//        $this->king_income_output = $this->king_income();
//        $this->magic_resources_output = $this->magic_resources();
//        $this->commodities_export = implode_and($this->commodities['export'], 'none');
//        $this->commodities_import = implode_and($this->commodities['import'], 'none');
//        $this->famous_famous = implode_and($this->famous['famous'], 'None');
//        $this->famous_infamous = implode_and($this->famous['infamous'], 'None');
//        $this->buildings_total = 0;
//        foreach ($this->wards as $ward) {
//            $this->buildings_total += $ward->building_total;
//        }
    }
}
