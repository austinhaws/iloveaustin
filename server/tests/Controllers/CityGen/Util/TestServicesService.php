<?php

namespace Test\Controllers\CityGen\Util;

use App\Http\Controllers\CityGen\Services\PostDataService;
use App\Http\Controllers\CityGen\Services\RandomCity\RandomAcresStructuresService;
use App\Http\Controllers\CityGen\Services\RandomCity\RandomBuildingsService;
use App\Http\Controllers\CityGen\Services\RandomCity\RandomCityPopulationService;
use App\Http\Controllers\CityGen\Services\RandomCity\RandomCityService;
use App\Http\Controllers\CityGen\Services\RandomCity\RandomCommoditiesService;
use App\Http\Controllers\CityGen\Services\RandomCity\RandomFamousService;
use App\Http\Controllers\CityGen\Services\RandomCity\RandomGuildsService;
use App\Http\Controllers\CityGen\Services\RandomCity\RandomPowerCentersService;
use App\Http\Controllers\CityGen\Services\RandomCity\RandomProfessionsService;
use App\Http\Controllers\CityGen\Services\RandomCity\RandomRacesService;
use App\Http\Controllers\CityGen\Services\RandomCity\RandomSeaRiverMilitaryGatesService;
use App\Http\Controllers\CityGen\Services\RandomCity\RandomService;
use App\Http\Controllers\CityGen\Services\RandomCity\RandomWardsService;
use App\Http\Controllers\CityGen\Services\ServicesService;
use App\Http\Controllers\CityGen\Services\TableService;
use App\Http\Controllers\CityGen\Util\TestRandomService;

class TestServicesService extends ServicesService
{
    /** @var RandomService */
    public $realRandom;

    public function __construct()
    {
        parent::__construct();

        $this->realRandom = new RandomService();

        $this->postData = new PostDataService($this);
        $this->random = new TestRandomService();
        $this->randomAcresStructures = new RandomAcresStructuresService($this);
        $this->randomBuildings = new RandomBuildingsService($this);
        $this->randomCityPopulation = new RandomCityPopulationService($this);
        $this->randomCity = new RandomCityService($this);
        $this->randomCommodities = new RandomCommoditiesService($this);
        $this->randomFamous = new RandomFamousService($this);
        $this->randomGuildService = new RandomGuildsService($this);
        $this->randomPowerCenters = new RandomPowerCentersService($this);
        $this->randomProfessions = new RandomProfessionsService($this);
        $this->randomRacesService = new RandomRacesService($this);
        $this->randomSeaRiverMilitaryGates = new RandomSeaRiverMilitaryGatesService($this);
        $this->randomWards = new RandomWardsService($this);
        $this->table = new TableService($this);
    }
}
