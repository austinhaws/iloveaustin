<?php

namespace Test\Controllers\CityGen\Tables;

use App\Http\Controllers\CityGen\Constants\BooleanRandom;
use App\Http\Controllers\CityGen\Constants\Integration;
use App\Http\Controllers\CityGen\Constants\PopulationType;
use App\Http\Controllers\CityGen\Constants\Race;
use App\Http\Controllers\CityGen\Models\City\City;
use App\Http\Controllers\CityGen\Models\Post\PostData;
use App\Http\Controllers\CityGen\Models\Post\PostRaceRatio;
use App\Http\Controllers\CityGen\Services\RandomCity\RandomService;
use App\Http\Controllers\CityGen\Util\TestRoll;
use Test\Controllers\CityGen\Util\BaseTestCase;

final class RandomRacesServiceTest extends BaseTestCase
{
    /**
     * @covers \App\Http\Controllers\CityGen\Services\RandomCity\RandomRacesService::determineRaces
     */
    public function testRaces()
    {
        $postData = new PostData();
        $postData->professions = BooleanRandom::FALSE;
        $postData->racialMix = RandomService::RANDOM;

        $city = new City();
        $city->populationType = PopulationType::HAMLET;
        $city->populationSize = 98;

        $this->services->random->setRolls([
            new TestRoll('Racial Mix', 2, 1, 3),
            new TestRoll('RacesRandomTable: range', 33, 1, 100),
        ]);

        $this->services->randomRacesService->determineRaces($city, $postData);
        $this->services->random->verifyRolls();

        $this->assertSame(Race::HUMAN, $city->races[0]->race);

        $this->assertIsSorted(array_reverse($city->races), function ($race) {
            return $race->total;
        });
        $this->assertSame(83, $city->races[0]->total);
        $this->assertSame(Integration::MIXED, $postData->racialMix);
    }

    /**
     * @covers \App\Http\Controllers\CityGen\Services\RandomCity\RandomRacesService::determineRaces
     */
    public function testRacialMixSet()
    {
        $postData = new PostData();
        $postData->professions = BooleanRandom::FALSE;
        $postData->racialMix = Integration::INTEGRATED;

        $city = new City();
        $city->populationType = PopulationType::HAMLET;
        $city->populationSize = 98;

        $this->services->random->setRolls([
            new TestRoll('RacesRandomTable: range', 33, 1, 100),
        ]);

        $this->services->randomRacesService->determineRaces($city, $postData);
        $this->services->random->verifyRolls();

        $this->assertSame(Race::HUMAN, $city->races[0]->race);

        $this->assertIsSorted(array_reverse($city->races), function ($race) {
            return $race->total;
        });
        $this->assertSame(41, $city->races[0]->total);
    }

    /**
     * @covers \App\Http\Controllers\CityGen\Services\RandomCity\RandomRacesService::determineRaces
     */
    public function testRaceSet()
    {
        $postData = new PostData();
        $postData->professions = BooleanRandom::FALSE;
        $postData->racialMix = RandomService::RANDOM;
        $postData->race = Race::HALFORC;

        $city = new City();
        $city->populationType = PopulationType::HAMLET;
        $city->populationSize = 98;

        $this->services->random->setRolls([
            new TestRoll('Racial Mix', 2, 1, 3),
        ]);

        $this->services->randomRacesService->determineRaces($city, $postData);
        $this->services->random->verifyRolls();

        $this->assertIsSorted(array_reverse($city->races), function ($race) {
            return $race->total;
        });
        $this->assertSame(Race::HALFORC, $city->races[0]->race);
        $this->assertSame(Race::HUMAN, $city->races[1]->race);
        $this->assertSame(83, $city->races[0]->total);
        $this->assertSame(Integration::MIXED, $postData->racialMix);
    }

    public function testCustomMix_Ratio0()
    {
        $postData = new PostData();
        $postData->professions = BooleanRandom::FALSE;
        $postData->racialMix = RandomService::CUSTOM;
        $postData->raceRatio = [
            new PostRaceRatio(Race::DWARF, 0),
        ];

        $city = new City();
        $city->populationType = PopulationType::HAMLET;
        $city->populationSize = 98;

        $this->services->random->setRolls([
            new TestRoll('RacesRandomTable: range', 98, 1, 100),
            new TestRoll('Racial Mix', 2, 1, 3),
        ]);

        $this->services->randomRacesService->determineRaces($city, $postData);
        $this->services->random->verifyRolls();

        $this->assertIsSorted(array_reverse($city->races), function ($race) {
            return $race->total;
        });
        $this->assertSame(Race::HALFORC, $city->races[0]->race);
        $this->assertSame(Race::HUMAN, $city->races[1]->race);
        $this->assertSame(83, $city->races[0]->total);
        $this->assertSame(Integration::MIXED, $postData->racialMix);
    }


    public function testCustomMix_RatioOne()
    {
        $postData = new PostData();
        $postData->professions = BooleanRandom::FALSE;
        $postData->racialMix = RandomService::CUSTOM;
        $postData->raceRatio = [
            new PostRaceRatio(Race::DWARF, 80),
        ];

        $city = new City();
        $city->populationType = PopulationType::HAMLET;
        $city->populationSize = 98;

        $this->services->randomRacesService->determineRaces($city, $postData);

        $this->assertIsSorted(array_reverse($city->races), function ($race) {
            return $race->total;
        });
        $this->assertSame(Race::DWARF, $city->races[0]->race);
        $this->assertSame(1, count($city->races));
        $this->assertSame(98, $city->races[0]->total);
        $this->assertSame(Integration::CUSTOM, $postData->racialMix);
    }

    public function testCustomMix_RatioSeveral()
    {
        $postData = new PostData();
        $postData->professions = BooleanRandom::FALSE;
        $postData->racialMix = RandomService::CUSTOM;
        $postData->raceRatio = [
            new PostRaceRatio(Race::DWARF, .60),
            new PostRaceRatio(Race::ELF, .80),
            new PostRaceRatio(Race::HUMAN, .5),
        ];

        $city = new City();
        $city->populationType = PopulationType::HAMLET;
        $city->populationSize = 98;

        $this->services->randomRacesService->determineRaces($city, $postData);

        $this->assertIsSorted(array_reverse($city->races), function ($race) {
            return $race->total;
        });
        $this->assertSame(Race::ELF, $city->races[0]->race);
        $this->assertSame(Race::DWARF, $city->races[1]->race);
        $this->assertSame(Race::HUMAN, $city->races[2]->race);
        $this->assertSame(3, count($city->races));
        $this->assertSame(43, $city->races[0]->total);
        $this->assertSame(30, $city->races[1]->total);
        $this->assertSame(25, $city->races[2]->total);
        $this->assertSame(Integration::CUSTOM, $postData->racialMix);
    }
}
